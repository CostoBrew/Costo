<?php
// Create test order
require_once 'app/config/database.php';

try {
    $pdo = DatabaseConfig::getConnection();
    
    // Insert test order
    $orderSql = "INSERT INTO orders (
        order_number, customer_name, customer_email, customer_phone,
        order_type, payment_method, payment_status, order_status,
        subtotal, tax_amount, total_amount, session_id
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $orderStmt = $pdo->prepare($orderSql);
    $orderStmt->execute([
        'TEST001',
        'Test Customer',
        'test@example.com',
        '1234567890',
        'takeout',
        'cash',
        'paid',
        'confirmed',
        4.50,
        0.50,
        5.00,
        'test_session'
    ]);
    
    $orderId = $pdo->lastInsertId();
    echo "Created order with ID: $orderId\n";
    
    // Insert test order item
    $itemSql = "INSERT INTO order_items (
        order_id, item_type, item_name, quantity, unit_price, total_price, 
        customization_data, special_instructions
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $itemStmt = $pdo->prepare($itemSql);
    $itemStmt->execute([
        $orderId,
        'diy_coffee',
        'Custom DIY Coffee',
        1,
        4.50,
        4.50,
        '{"cup":"medium","beans":"arabica","milk":"whole","sweetener":"sugar"}',
        null
    ]);
    
    echo "Created test order item\n";
    echo "Visit: http://localhost:8000/checkout/receipt/$orderId\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
