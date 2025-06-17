<?php
// Test premade coffee studio functionality
session_start();

// Simulate a premade checkout item with the new fields
$_SESSION['direct_checkout_item'] = [
    'id' => uniqid('premade_'),
    'type' => 'premade_coffee',
    'item_type' => 'premade',
    'name' => 'Colombian Supreme Large',
    'custom_data' => [
        'name' => 'Colombian Supreme Large',
        'type' => 'premade_coffee'
    ],
    'build' => [
        'cup' => ['name' => 'Large', 'price' => 135.00],
        'coffee' => ['name' => 'Colombian Supreme', 'price' => 25.00],
        'pastry' => ['name' => 'Croissant', 'price' => 85.00]
    ],
    'price' => 274.50,      // Final total with delivery + VAT
    'subtotal' => 245.00,   // Cup + Coffee + Pastry (135 + 25 + 85)
    'deliveryFee' => 50.00,
    'vatAmount' => 29.50,   // 12% of (245 + 50)
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
    'special_instructions' => 'Test premade order'
];

// Set the request method
$_SERVER['REQUEST_METHOD'] = 'POST';

echo "Testing premade checkout process...\n";
echo "Order details:\n";
echo "- Subtotal: ₱" . number_format($_SESSION['direct_checkout_item']['subtotal'], 2) . "\n";
echo "- Delivery: ₱" . number_format($_SESSION['direct_checkout_item']['deliveryFee'], 2) . "\n";
echo "- VAT (12%): ₱" . number_format($_SESSION['direct_checkout_item']['vatAmount'], 2) . "\n";
echo "- Total: ₱" . number_format($_SESSION['direct_checkout_item']['price'], 2) . "\n\n";

try {
    require_once 'app/controller/CheckoutController.php';
    
    $controller = new CheckoutController();
    $controller->process();
    
    echo "Premade checkout process completed successfully!\n";
} catch (Exception $e) {
    echo "Error during checkout: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
