<?php
// Check database schema
require_once 'app/config/database.php';

try {
    $pdo = DatabaseConfig::getConnection();
    
    // Check orders table structure
    echo "=== ORDERS TABLE STRUCTURE ===\n";
    $stmt = $pdo->query("DESCRIBE orders");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "{$row['Field']} - {$row['Type']} - {$row['Null']} - {$row['Key']} - {$row['Default']}\n";
    }
    
    echo "\n=== ORDER_ITEMS TABLE STRUCTURE ===\n";
    $stmt = $pdo->query("DESCRIBE order_items");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "{$row['Field']} - {$row['Type']} - {$row['Null']} - {$row['Key']} - {$row['Default']}\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
