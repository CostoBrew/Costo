<?php
// Test order creation
require_once 'app/model/BaseModel.php';
require_once 'app/model/Order.php';

try {
    $orderData = [
        'user_id' => null,
        'order_number' => 'TEST' . time(),
        'customer_name' => 'Test Customer',
        'customer_email' => 'test@example.com',
        'customer_phone' => '1234567890',
        'order_type' => 'takeout',
        'payment_method' => 'cash',
        'payment_status' => 'paid',
        'order_status' => 'confirmed',
        'subtotal' => 4.50,
        'tax_amount' => 0.50,
        'total_amount' => 5.00,
        'session_id' => 'test_session_' . time(),
        'special_instructions' => null
    ];
    
    $orderItems = [
        [
            'item_type' => 'diy_coffee',
            'item_name' => 'Test Coffee',
            'quantity' => 1,
            'unit_price' => 4.50,
            'total_price' => 4.50,
            'customization_data' => '{"cup":"medium","beans":"arabica"}',
            'special_instructions' => null
        ]
    ];
    
    $orderId = Order::createOrderWithItems($orderData, $orderItems);
    echo "Successfully created order with ID: $orderId\n";
    
} catch (Exception $e) {
    echo "Error creating order: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
?>
