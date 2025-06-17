<?php
// Simple database test
require_once 'app/config/database.php';

try {
    $pdo = DatabaseConfig::getConnection();
    
    // Check if orders table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'orders'");
    $ordersExists = $stmt->fetch() ? true : false;
    
    // Check if order_items table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'order_items'");
    $orderItemsExists = $stmt->fetch() ? true : false;
    
    echo "Orders table exists: " . ($ordersExists ? 'YES' : 'NO') . "\n";
    echo "Order items table exists: " . ($orderItemsExists ? 'YES' : 'NO') . "\n";
    
    if ($ordersExists) {
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM orders");
        $orderCount = $stmt->fetch()['count'];
        echo "Number of orders: $orderCount\n";
        
        if ($orderCount > 0) {
            $stmt = $pdo->query("SELECT * FROM orders LIMIT 1");
            $order = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "Sample order:\n";
            print_r($order);
        }
    }
    
    if ($orderItemsExists) {
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM order_items");
        $itemCount = $stmt->fetch()['count'];
        echo "Number of order items: $itemCount\n";
        
        if ($itemCount > 0) {
            $stmt = $pdo->query("SELECT * FROM order_items LIMIT 1");
            $item = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "Sample order item:\n";
            print_r($item);
        }
    }
    
} catch (Exception $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
?>
