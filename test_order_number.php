<?php
// Test order number generation
require_once 'app/model/BaseModel.php';
require_once 'app/model/Order.php';

try {
    $orderNumber = Order::generateOrderNumber();
    echo "Generated order number: $orderNumber\n";
} catch (Exception $e) {
    echo "Error generating order number: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
?>
