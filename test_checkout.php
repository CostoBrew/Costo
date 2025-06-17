<?php
// Simple test to check checkout functionality
session_start();

// Simulate a direct checkout item
$_SESSION['direct_checkout_item'] = [
    'id' => uniqid('diy_'),
    'type' => 'diy_coffee',
    'item_type' => 'diy',
    'name' => 'Test Coffee',
    'custom_data' => [
        'name' => 'Test Coffee',
        'type' => 'diy_coffee'
    ],
    'build' => [],
    'ingredients' => [],
    'price' => 150.00,
    'subtotal' => 100.00,
    'deliveryFee' => 50.00,
    'vatAmount' => 18.00,
    'quantity' => 1,
    'created_at' => date('Y-m-d H:i:s')
];

// Simulate POST data
$_POST = [
    'customer_name' => 'Test Customer',
    'customer_email' => 'test@example.com',
    'customer_phone' => '09123456789',
    'order_type' => 'delivery',
    'payment_method' => 'cash',
    'special_instructions' => 'Test order'
];

// Set the request method
$_SERVER['REQUEST_METHOD'] = 'POST';

echo "Testing checkout process...\n";

try {
    require_once 'app/controller/CheckoutController.php';
    
    $controller = new CheckoutController();
    $controller->process();
    
    echo "Checkout process completed successfully!\n";
} catch (Exception $e) {
    echo "Error during checkout: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
