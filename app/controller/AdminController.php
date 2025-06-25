<?php

/**
 * Admin Controller
 * Handles admin dashboard and management functions
 */

require_once __DIR__ . '/../model/Order.php';
require_once __DIR__ . '/../config/database.php';

class AdminController
{
    /**
     * Admin dashboard
     */
    public function dashboard()
    {
        // Check if user is admin
        if (!$this->isAdmin()) {
            header('Location: /login');
            exit;
        }

        // Get dashboard statistics
        $stats = $this->getDashboardStats();

        // Get recent orders
        $orders = $this->getRecentOrders();

        // Include the admin dashboard view
        include __DIR__ . '/../view/admin/admin_dashboard.php';
    }
    
    /**
     * Manage coffees (menu)
     */
    public function manageCoffees()
    {
        if (!$this->isAdmin()) {
            header('Location: /login');
            exit;
        }

        // Get DIY menu components
        $menuData = $this->getMenuComponents();

        // Get premade coffees
        $premadeCoffees = $this->getPremadeCoffees();

        // Include menu management view
        include __DIR__ . '/../view/admin/menu.php';
    }
    
    /**
     * Manage orders
     */
    public function manageOrders()
    {
        if (!$this->isAdmin()) {
            header('Location: /login');
            exit;
        }

        // Get all orders
        $orders = Order::getRecentOrders(100);

        // Include orders management view
        include __DIR__ . '/../view/admin/orders.php';
    }
    
    /**
     * Manage customers
     */
    public function manageCustomers()
    {
        if (!$this->isAdmin()) {
            header('Location: /login');
            exit;
        }
        
        // TODO: Implement customer management
        echo "<h1>Manage Customers</h1><p>Coming soon...</p>";
    }
    
    /**
     * Create coffee
     */
    public function createCoffee()
    {
        if (!$this->isAdmin()) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        try {
            $input = json_decode(file_get_contents('php://input'), true);

            if (!$input) {
                echo json_encode(['success' => false, 'message' => 'Invalid input data']);
                return;
            }

            // Validate required fields
            $requiredFields = ['name', 'description', 'base_price', 'category'];
            foreach ($requiredFields as $field) {
                if (!isset($input[$field]) || empty($input[$field])) {
                    echo json_encode(['success' => false, 'message' => "Field '$field' is required"]);
                    return;
                }
            }

            // For now, simulate success (in real implementation, save to database)
            echo json_encode(['success' => true, 'message' => 'Premade coffee created successfully']);

        } catch (Exception $e) {
            error_log("Error creating coffee: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error creating coffee: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Update coffee
     */
    public function updateCoffee($coffeeId)
    {
        if (!$this->isAdmin()) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        try {
            $input = json_decode(file_get_contents('php://input'), true);

            if (!$input) {
                echo json_encode(['success' => false, 'message' => 'Invalid input data']);
                return;
            }

            // For now, simulate success (in real implementation, update in database)
            echo json_encode(['success' => true, 'message' => 'Premade coffee updated successfully']);

        } catch (Exception $e) {
            error_log("Error updating coffee: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error updating coffee: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Delete coffee
     */
    public function deleteCoffee($coffeeId)
    {
        if (!$this->isAdmin()) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        try {
            $pdo = DatabaseConfig::getConnection();

            // Check if coffee exists
            $checkSql = "SELECT id FROM coffees WHERE id = ?";
            $checkStmt = $pdo->prepare($checkSql);
            $checkStmt->execute([$coffeeId]);

            if (!$checkStmt->fetch()) {
                echo json_encode(['success' => false, 'message' => 'Coffee not found']);
                return;
            }

            // Delete the coffee
            $deleteSql = "DELETE FROM coffees WHERE id = ?";
            $deleteStmt = $pdo->prepare($deleteSql);
            $result = $deleteStmt->execute([$coffeeId]);

            if ($result && $deleteStmt->rowCount() > 0) {
                echo json_encode(['success' => true, 'message' => 'Coffee deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete coffee']);
            }

        } catch (Exception $e) {
            error_log("Error deleting coffee: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error deleting coffee: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Delete order
     */
    public function deleteOrder($orderId)
    {
        if (!$this->isAdmin()) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        try {
            $result = Order::deleteOrder($orderId);

            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Order deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Order not found or could not be deleted']);
            }
        } catch (Exception $e) {
            error_log("Error deleting order: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error deleting order']);
        }
    }

    /**
     * Update order status
     */
    public function updateOrderStatus($orderId)
    {
        if (!$this->isAdmin()) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $status = $input['status'] ?? '';

        if (empty($status)) {
            echo json_encode(['success' => false, 'message' => 'Status is required']);
            return;
        }

        try {
            $result = Order::updateOrderStatus($orderId, $status);

            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Order status updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Order not found or could not be updated']);
            }
        } catch (Exception $e) {
            error_log("Error updating order status: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error updating order status']);
        }
    }

    /**
     * Get order details for editing/viewing
     */
    public function getOrderDetails($orderId)
    {
        if (!$this->isAdmin()) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        try {
            $order = Order::getOrderWithItems($orderId);

            if ($order) {
                echo json_encode(['success' => true, 'order' => $order]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Order not found']);
            }
        } catch (Exception $e) {
            error_log("Error getting order details: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error retrieving order details']);
        }
    }

    /**
     * Update order details
     */
    public function updateOrder($orderId)
    {
        if (!$this->isAdmin()) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        // Validate required fields
        $requiredFields = ['customer_name', 'customer_email', 'order_status', 'payment_status'];
        foreach ($requiredFields as $field) {
            if (empty($input[$field])) {
                echo json_encode(['success' => false, 'message' => ucfirst(str_replace('_', ' ', $field)) . ' is required']);
                return;
            }
        }

        try {
            $result = Order::updateOrderDetails($orderId, $input);

            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Order updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Order not found or could not be updated']);
            }
        } catch (Exception $e) {
            error_log("Error updating order: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error updating order']);
        }
    }

    /**
     * Get dashboard statistics
     */
    private function getDashboardStats()
    {
        try {
            $pdo = DatabaseConfig::getConnection();

            // Total orders
            $stmt = $pdo->query("SELECT COUNT(*) as total FROM orders");
            $totalOrders = $stmt->fetchColumn();

            // Pending orders
            $stmt = $pdo->query("SELECT COUNT(*) as pending FROM orders WHERE order_status = 'pending'");
            $pendingOrders = $stmt->fetchColumn();

            // Total revenue
            $stmt = $pdo->query("SELECT SUM(total_amount) as revenue FROM orders WHERE payment_status = 'paid'");
            $totalRevenue = $stmt->fetchColumn() ?: 0;

            // Total customers (unique emails)
            $stmt = $pdo->query("SELECT COUNT(DISTINCT customer_email) as customers FROM orders");
            $totalCustomers = $stmt->fetchColumn();

            return [
                'total_orders' => $totalOrders,
                'pending_orders' => $pendingOrders,
                'total_revenue' => $totalRevenue,
                'total_customers' => $totalCustomers
            ];
        } catch (Exception $e) {
            error_log("Error getting dashboard stats: " . $e->getMessage());
            return [
                'total_orders' => 0,
                'pending_orders' => 0,
                'total_revenue' => 0,
                'total_customers' => 0
            ];
        }
    }

    /**
     * Get recent orders for dashboard
     */
    private function getRecentOrders($limit = 20)
    {
        try {
            return Order::getRecentOrders($limit);
        } catch (Exception $e) {
            error_log("Error getting recent orders: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get all coffee items for menu management
     */
    private function getAllCoffees()
    {
        try {
            $pdo = DatabaseConfig::getConnection();

            // Try to get from database first
            $sql = "SELECT * FROM coffees ORDER BY name ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $coffees = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // If no coffees in database, return sample data
            if (empty($coffees)) {
                return $this->getSampleCoffees();
            }

            return $coffees;

        } catch (Exception $e) {
            error_log("Error getting coffees: " . $e->getMessage());
            // Return sample data as fallback
            return $this->getSampleCoffees();
        }
    }

    /**
     * Get DIY menu components (what customers see in coffee studio)
     */
    private function getMenuComponents()
    {
        return [
            'cups' => [
                ['id' => 1, 'name' => 'Small', 'size' => '8 oz', 'price' => 95.00, 'available' => true],
                ['id' => 2, 'name' => 'Medium', 'size' => '12 oz', 'price' => 115.00, 'available' => true],
                ['id' => 3, 'name' => 'Large', 'size' => '16 oz', 'price' => 135.00, 'available' => true],
                ['id' => 4, 'name' => 'Extra Large', 'size' => '20 oz', 'price' => 155.00, 'available' => true]
            ],
            'beans' => [
                ['id' => 1, 'name' => 'Arabica', 'type' => 'Premium', 'price' => 15.00, 'available' => true],
                ['id' => 2, 'name' => 'Robusta', 'type' => 'Strong', 'price' => 12.00, 'available' => true],
                ['id' => 3, 'name' => 'Liberica', 'type' => 'Local', 'price' => 25.00, 'available' => true],
                ['id' => 4, 'name' => 'Excelsa', 'type' => 'Exotic', 'price' => 30.00, 'available' => false]
            ],
            'milk' => [
                ['id' => 1, 'name' => 'Whole Milk', 'type' => 'Dairy', 'price' => 10.00, 'available' => true],
                ['id' => 2, 'name' => 'Skim Milk', 'type' => 'Dairy', 'price' => 10.00, 'available' => true],
                ['id' => 3, 'name' => 'Almond Milk', 'type' => 'Plant-based', 'price' => 15.00, 'available' => true],
                ['id' => 4, 'name' => 'Oat Milk', 'type' => 'Plant-based', 'price' => 18.00, 'available' => true],
                ['id' => 5, 'name' => 'Coconut Milk', 'type' => 'Plant-based', 'price' => 15.00, 'available' => true]
            ],
            'sweeteners' => [
                ['id' => 1, 'name' => 'White Sugar', 'type' => 'Regular', 'price' => 0.00, 'available' => true],
                ['id' => 2, 'name' => 'Brown Sugar', 'type' => 'Natural', 'price' => 2.00, 'available' => true],
                ['id' => 3, 'name' => 'Honey', 'type' => 'Natural', 'price' => 8.00, 'available' => true],
                ['id' => 4, 'name' => 'Stevia', 'type' => 'Zero-calorie', 'price' => 5.00, 'available' => true],
                ['id' => 5, 'name' => 'Agave', 'type' => 'Natural', 'price' => 10.00, 'available' => true]
            ],
            'syrups' => [
                ['id' => 1, 'name' => 'Vanilla Syrup', 'flavor' => 'Vanilla', 'price' => 12.00, 'available' => true],
                ['id' => 2, 'name' => 'Caramel Syrup', 'flavor' => 'Caramel', 'price' => 12.00, 'available' => true],
                ['id' => 3, 'name' => 'Hazelnut Syrup', 'flavor' => 'Hazelnut', 'price' => 15.00, 'available' => true],
                ['id' => 4, 'name' => 'Chocolate Syrup', 'flavor' => 'Chocolate', 'price' => 12.00, 'available' => true],
                ['id' => 5, 'name' => 'Peppermint Syrup', 'flavor' => 'Peppermint', 'price' => 15.00, 'available' => false]
            ],
            'toppings' => [
                ['id' => 1, 'name' => 'Whipped Cream', 'type' => 'Cream', 'price' => 8.00, 'available' => true],
                ['id' => 2, 'name' => 'Chocolate Chips', 'type' => 'Chocolate', 'price' => 10.00, 'available' => true],
                ['id' => 3, 'name' => 'Cinnamon Powder', 'type' => 'Spice', 'price' => 5.00, 'available' => true],
                ['id' => 4, 'name' => 'Marshmallows', 'type' => 'Sweet', 'price' => 8.00, 'available' => true],
                ['id' => 5, 'name' => 'Caramel Drizzle', 'type' => 'Sauce', 'price' => 10.00, 'available' => true]
            ],
            'pastries' => [
                ['id' => 1, 'name' => 'Chocolate Croissant', 'type' => 'Pastry', 'price' => 75.00, 'available' => true],
                ['id' => 2, 'name' => 'Blueberry Muffin', 'type' => 'Muffin', 'price' => 85.00, 'available' => true],
                ['id' => 3, 'name' => 'Banana Bread', 'type' => 'Bread', 'price' => 65.00, 'available' => true],
                ['id' => 4, 'name' => 'Cinnamon Roll', 'type' => 'Sweet Roll', 'price' => 95.00, 'available' => true],
                ['id' => 5, 'name' => 'Cheesecake Slice', 'type' => 'Cake', 'price' => 120.00, 'available' => false]
            ]
        ];
    }

    /**
     * Get premade coffee options
     */
    private function getPremadeCoffees()
    {
        return [
            [
                'id' => 1,
                'name' => 'Classic Americano',
                'description' => 'Rich espresso with hot water, perfect for coffee purists',
                'base_price' => 120.00,
                'category' => 'Espresso-based',
                'is_available' => 1,
                'image' => '/src/assets/americano.jpg'
            ],
            [
                'id' => 2,
                'name' => 'Creamy Latte',
                'description' => 'Smooth espresso with steamed milk and light foam',
                'base_price' => 150.00,
                'category' => 'Milk-based',
                'is_available' => 1,
                'image' => '/src/assets/latte.jpg'
            ],
            [
                'id' => 3,
                'name' => 'Cappuccino',
                'description' => 'Equal parts espresso, steamed milk, and milk foam',
                'base_price' => 140.00,
                'category' => 'Milk-based',
                'is_available' => 1,
                'image' => '/src/assets/cappuccino.jpg'
            ],
            [
                'id' => 4,
                'name' => 'Caramel Macchiato',
                'description' => 'Vanilla syrup, steamed milk, espresso, and caramel drizzle',
                'base_price' => 180.00,
                'category' => 'Specialty',
                'is_available' => 1,
                'image' => '/src/assets/macchiato.jpg'
            ],
            [
                'id' => 5,
                'name' => 'Mocha Delight',
                'description' => 'Rich chocolate, espresso, and steamed milk with whipped cream',
                'base_price' => 170.00,
                'category' => 'Chocolate',
                'is_available' => 1,
                'image' => '/src/assets/mocha.jpg'
            ],
            [
                'id' => 6,
                'name' => 'Iced Coffee',
                'description' => 'Cold brew coffee served over ice with your choice of milk',
                'base_price' => 110.00,
                'category' => 'Cold Brew',
                'is_available' => 0,
                'image' => '/src/assets/iced-coffee.jpg'
            ]
        ];
    }

    /**
     * Create menu item
     */
    public function createMenuItem($category)
    {
        if (!$this->isAdmin()) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        try {
            $input = json_decode(file_get_contents('php://input'), true);

            if (!$input) {
                echo json_encode(['success' => false, 'message' => 'Invalid input data']);
                return;
            }

            // Validate category
            $validCategories = ['cups', 'beans', 'milk', 'sweeteners', 'syrups', 'toppings', 'pastries'];
            if (!in_array($category, $validCategories)) {
                echo json_encode(['success' => false, 'message' => 'Invalid category: ' . $category]);
                return;
            }

            // For now, simulate success (in real implementation, save to database)
            echo json_encode(['success' => true, 'message' => ucfirst($category) . ' item created successfully']);

        } catch (Exception $e) {
            error_log("Error creating menu item: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error creating item: ' . $e->getMessage()]);
        }
    }

    /**
     * Update menu item
     */
    public function updateMenuItem($category, $itemId)
    {
        if (!$this->isAdmin()) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        try {
            $input = json_decode(file_get_contents('php://input'), true);

            if (!$input) {
                echo json_encode(['success' => false, 'message' => 'Invalid input data']);
                return;
            }

            // For now, simulate success (in real implementation, update in database)
            echo json_encode(['success' => true, 'message' => ucfirst($category) . ' item updated successfully']);

        } catch (Exception $e) {
            error_log("Error updating menu item: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error updating item: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete menu item
     */
    public function deleteMenuItem($category, $itemId)
    {
        if (!$this->isAdmin()) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        try {
            // For now, simulate success (in real implementation, delete from database)
            echo json_encode(['success' => true, 'message' => ucfirst($category) . ' item deleted successfully']);

        } catch (Exception $e) {
            error_log("Error deleting menu item: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error deleting item: ' . $e->getMessage()]);
        }
    }

    /**
     * Get menu item for editing
     */
    public function getMenuItem($category, $itemId)
    {
        if (!$this->isAdmin()) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        try {
            $menuData = $this->getMenuComponents();

            if (!isset($menuData[$category])) {
                echo json_encode(['success' => false, 'message' => 'Category not found']);
                return;
            }

            $item = null;
            foreach ($menuData[$category] as $menuItem) {
                if ($menuItem['id'] == $itemId) {
                    $item = $menuItem;
                    break;
                }
            }

            if (!$item) {
                echo json_encode(['success' => false, 'message' => 'Item not found']);
                return;
            }

            echo json_encode(['success' => true, 'data' => $item]);

        } catch (Exception $e) {
            error_log("Error getting menu item: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error getting item: ' . $e->getMessage()]);
        }
    }

    /**
     * Get sample coffee data for testing (legacy support)
     */
    private function getSampleCoffees()
    {
        return [
            [
                'id' => 1,
                'name' => 'Ethiopian Single Origin',
                'description' => 'Bright and fruity with notes of blueberry and chocolate',
                'price' => 240.00,
                'type' => 'Single Origin',
                'stock' => 50,
                'is_available' => 1,
                'image' => '/src/assets/coffee1.jpg'
            ],
            [
                'id' => 2,
                'name' => 'Colombian Medium Roast',
                'description' => 'Smooth and balanced with caramel sweetness',
                'price' => 200.00,
                'type' => 'Medium Roast',
                'stock' => 75,
                'is_available' => 1,
                'image' => '/src/assets/coffee2.jpg'
            ]
        ];
    }

    /**
     * Check if current user is admin
     */
    private function isAdmin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if user email is the specific admin email
        $userEmail = $_SESSION['user_email'] ?? '';
        return $userEmail === '1admin@costobrew.com';
    }
}
