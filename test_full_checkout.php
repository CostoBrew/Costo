<?php
// Simulate checkout with same data as the controller
session_start();

// Set up test data like the studio would
$_SESSION['direct_checkout_item'] = [
    'id' => uniqid('diy_'),
    'type' => 'diy_coffee',
    'item_type' => 'diy',
    'name' => 'Custom DIY Coffee',
    'custom_data' => [
        'name' => 'Custom DIY Coffee',
        'type' => 'diy_coffee'
    ],
    'build' => [
        'cup' => ['value' => 'medium', 'price' => 3.50],
        'beans' => ['value' => 'arabica', 'price' => 0.00]
    ],
    'price' => 3.50,
    'quantity' => 1,
    'created_at' => date('Y-m-d H:i:s')
];

require_once 'app/controller/CheckoutController.php';

$controller = new CheckoutController();

// Simulate POST data
$_POST = [
    'csrf_token' => $_SESSION['csrf_token'] ?? 'test_token',
    'customer_name' => 'Test Customer',
    'customer_email' => 'test@example.com',
    'customer_phone' => '09123456789',
    'delivery_address' => 'Test Address',
    'delivery_notes' => '',
    'order_type' => 'takeout'
];

$_SESSION['csrf_token'] = 'test_token'; // Set CSRF token

try {
    echo "Starting checkout process...\n";
    
    // Simulate the process method
    $cartItems = [$_SESSION['direct_checkout_item']];
    $customerInfo = [
        'name' => $_POST['customer_name'],
        'email' => $_POST['customer_email'],
        'phone' => $_POST['customer_phone'],
        'delivery_address' => $_POST['delivery_address'],
        'delivery_notes' => $_POST['delivery_notes']
    ];
    
    $paymentInfo = [
        'method' => 'cash',
        'order_type' => 'delivery'
    ];
    
    echo "Cart items: " . json_encode($cartItems) . "\n";
    echo "Customer info: " . json_encode($customerInfo) . "\n";
    echo "Payment info: " . json_encode($paymentInfo) . "\n";
    
    // Call createOrder directly using reflection
    $reflection = new ReflectionClass($controller);
    $createOrderMethod = $reflection->getMethod('createOrder');
    $createOrderMethod->setAccessible(true);
    
    $orderId = $createOrderMethod->invoke($controller, $cartItems, $customerInfo, $paymentInfo);
    
    echo "Order created with ID: $orderId\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
?>
