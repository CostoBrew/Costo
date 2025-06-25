<?php

/**
 * Order Model
 * Handles order-related database operations
 */

class Order
{
    
    /**
     * Get database connection
     */
    private static function getDatabaseConnection()
    {
        require_once __DIR__ . '/../config/database.php';
        DatabaseConfig::loadEnvironment();
        return DatabaseConfig::getConnection();
    }
    
    /**
     * Create a new order with items
     */
    public static function createOrderWithItems($orderData, $orderItems)
    {
        try {
            $pdo = self::getDatabaseConnection();
            $pdo->beginTransaction();
            
            // Insert order
            $orderSql = "INSERT INTO orders (
                user_id, order_number, customer_name, customer_email, customer_phone,
                order_type, payment_method, payment_status, order_status,
                subtotal, tax_amount, total_amount, session_id, special_instructions
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $orderStmt = $pdo->prepare($orderSql);
            $orderStmt->execute([
                $orderData['user_id'] ?? null,
                $orderData['order_number'],
                $orderData['customer_name'],
                $orderData['customer_email'],
                $orderData['customer_phone'],
                $orderData['order_type'] ?? 'takeout',
                $orderData['payment_method'] ?? 'cash',
                $orderData['payment_status'] ?? 'paid',
                $orderData['order_status'] ?? 'confirmed',
                $orderData['subtotal'],
                $orderData['tax_amount'],
                $orderData['total_amount'],
                $orderData['session_id'] ?? null,
                $orderData['special_instructions'] ?? null
            ]);
            
            $orderId = $pdo->lastInsertId();
            
            // Insert order items
            $itemSql = "INSERT INTO order_items (
                order_id, item_type, item_name, quantity, unit_price, total_price, 
                customization_data, special_instructions
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
            $itemStmt = $pdo->prepare($itemSql);            foreach ($orderItems as $item) {
                $itemStmt->execute([
                    $orderId,
                    $item['item_type'],
                    $item['item_name'],
                    $item['quantity'],
                    $item['unit_price'],
                    $item['total_price'],
                    $item['customization_data'] ? json_encode($item['customization_data']) : null,
                    $item['special_instructions'] ?? null
                ]);
            }
            
            $pdo->commit();
            return $orderId;
              } catch (Exception $e) {
            if ($pdo && $pdo->inTransaction()) {
                $pdo->rollback();
            }
            error_log("Order creation SQL error: " . $e->getMessage());
            if ($e instanceof PDOException) {
                error_log("PDO Error Info: " . print_r($e->errorInfo, true));
            }
            throw $e;
        }
    }
    
    /**
     * Get order with items by ID
     */
    public static function getOrderWithItems($orderId)
    {
        $pdo = self::getDatabaseConnection();
        
        // Get order
        $orderSql = "SELECT o.*, u.full_name as user_name, u.email as user_email 
                     FROM orders o 
                     LEFT JOIN users u ON o.user_id = u.id 
                     WHERE o.id = ?";
        $orderStmt = $pdo->prepare($orderSql);
        $orderStmt->execute([$orderId]);
        $order = $orderStmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$order) {
            return null;
        }        // Get order items
        $itemSql = "SELECT * FROM order_items WHERE order_id = ? ORDER BY id";
        $itemStmt = $pdo->prepare($itemSql);
        $itemStmt->execute([$orderId]);
        $items = $itemStmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Parse JSON customization data
        foreach ($items as &$item) {
            if ($item['customization_data']) {
                $item['customization_data'] = json_decode($item['customization_data'], true);
            }
        }
        
        $order['items'] = $items;
        return $order;
    }
    
    /**
     * Get order by order number
     */
    public static function getOrderByNumber($orderNumber)
    {
        $pdo = self::getDatabaseConnection();
        
        $sql = "SELECT id FROM orders WHERE order_number = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$orderNumber]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return self::getOrderWithItems($result['id']);
        }
        
        return null;
    }
    
    /**
     * Update order status
     */
    public static function updateOrderStatus($orderId, $status)
    {
        $pdo = self::getDatabaseConnection();

        $sql = "UPDATE orders SET order_status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$status, $orderId]);
    }

    /**
     * Update order details
     */
    public static function updateOrderDetails($orderId, $data)
    {
        try {
            $pdo = self::getDatabaseConnection();

            $sql = "UPDATE orders SET
                        customer_name = ?,
                        customer_email = ?,
                        customer_phone = ?,
                        order_status = ?,
                        payment_status = ?,
                        special_instructions = ?,
                        updated_at = CURRENT_TIMESTAMP
                    WHERE id = ?";

            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([
                $data['customer_name'],
                $data['customer_email'],
                $data['customer_phone'] ?? null,
                $data['order_status'],
                $data['payment_status'],
                $data['special_instructions'] ?? null,
                $orderId
            ]);

            return $result && $stmt->rowCount() > 0;

        } catch (Exception $e) {
            error_log("Error updating order details: " . $e->getMessage());
            return false;
        }
    }


    
    /**
     * Get orders for a user
     */
    public static function getUserOrders($userId, $limit = 20)
    {
        $pdo = self::getDatabaseConnection();
        
        $sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC LIMIT ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId, $limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Generate unique order number
     */
    public static function generateOrderNumber()
    {
        $pdo = self::getDatabaseConnection();
        $date = date('Ymd');
        $prefix = 'CB' . $date;
        
        // Get the highest order number for today
        $sql = "SELECT order_number FROM orders WHERE order_number LIKE ? ORDER BY order_number DESC LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$prefix . '%']);
        $lastOrder = $stmt->fetchColumn();
        
        if ($lastOrder) {
            // Extract the sequence number and increment
            $sequence = intval(substr($lastOrder, -4)) + 1;
        } else {
            $sequence = 1;
        }
        
        return $prefix . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
    
    /**
     * Get recent orders for admin dashboard
     */
    public static function getRecentOrders($limit = 50)
    {
        $pdo = self::getDatabaseConnection();

        $sql = "SELECT o.*, u.full_name as user_name,
                       COUNT(oi.id) as item_count,
                       GROUP_CONCAT(DISTINCT oi.item_type) as item_types,
                       GROUP_CONCAT(DISTINCT oi.item_name SEPARATOR ', ') as item_names
                FROM orders o
                LEFT JOIN users u ON o.user_id = u.id
                LEFT JOIN order_items oi ON o.id = oi.order_id
                GROUP BY o.id
                ORDER BY o.created_at DESC
                LIMIT ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$limit]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Process the orders to determine coffee type
        foreach ($orders as &$order) {
            $order['coffee_type'] = self::determineCoffeeType($order['item_types']);
        }

        return $orders;
    }

    /**
     * Determine the primary coffee type for an order
     */
    private static function determineCoffeeType($itemTypes)
    {
        if (empty($itemTypes)) {
            return 'Unknown';
        }

        $types = explode(',', $itemTypes);

        // Check for DIY coffee first
        if (in_array('diy_coffee', $types) || in_array('diy', $types)) {
            return 'DIY';
        }

        // Check for premade coffee
        if (in_array('premade_coffee', $types) || in_array('premade', $types)) {
            return 'Premade';
        }

        // Check for other types
        if (in_array('pastry', $types)) {
            return 'Pastry';
        }

        return 'Other';
    }

    /**
     * Delete order and its items
     */
    public static function deleteOrder($orderId)
    {
        try {
            $pdo = self::getDatabaseConnection();
            $pdo->beginTransaction();

            // Delete order items first (foreign key constraint)
            $itemSql = "DELETE FROM order_items WHERE order_id = ?";
            $itemStmt = $pdo->prepare($itemSql);
            $itemStmt->execute([$orderId]);

            // Delete the order
            $orderSql = "DELETE FROM orders WHERE id = ?";
            $orderStmt = $pdo->prepare($orderSql);
            $result = $orderStmt->execute([$orderId]);

            $pdo->commit();
            return $result && $orderStmt->rowCount() > 0;

        } catch (Exception $e) {
            if ($pdo && $pdo->inTransaction()) {
                $pdo->rollback();
            }
            error_log("Error deleting order: " . $e->getMessage());
            return false;
        }
    }

}
