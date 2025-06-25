<?php
// Simple test to check if main routing works
echo "Testing main index.php routing...\n";

// Simulate a simple GET request to home
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['DOCUMENT_ROOT'] = __DIR__;
$_SERVER['SCRIPT_NAME'] = '/index.php';

try {
    ob_start();
    require_once 'index.php';
    $output = ob_get_clean();
    
    if (strlen($output) > 100) {
        echo "✓ Index.php loaded successfully (output length: " . strlen($output) . " chars)\n";
        echo "✓ First 200 chars of output:\n";
        echo substr($output, 0, 200) . "...\n";
    } else {
        echo "✗ Index.php output seems too short: " . strlen($output) . " chars\n";
        echo "Output: " . $output . "\n";
    }
    
} catch (Exception $e) {
    echo "✗ Error loading index.php: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
