<?php
// Simple routing test script
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== ROUTING TEST ===\n";

// Test if we can load the basic files
echo "1. Testing file includes...\n";

$files_to_test = [
    'app/config/database.php',
    'app/core/Router.php',
    'app/middleware/AuthMiddleware.php'
];

foreach ($files_to_test as $file) {
    if (file_exists($file)) {
        echo "   ✓ $file exists\n";
        try {
            require_once $file;
            echo "   ✓ $file loaded successfully\n";
        } catch (Exception $e) {
            echo "   ✗ $file failed to load: " . $e->getMessage() . "\n";
        }
    } else {
        echo "   ✗ $file does not exist\n";
    }
}

echo "\n2. Testing Router class...\n";
if (class_exists('Router')) {
    echo "   ✓ Router class exists\n";
    
    try {
        $router = new Router();
        echo "   ✓ Router instantiated successfully\n";
        
        // Test adding a simple route
        $router->get('/test', function() {
            return 'Test route works!';
        });
        echo "   ✓ Route added successfully\n";
        
    } catch (Exception $e) {
        echo "   ✗ Router error: " . $e->getMessage() . "\n";
    }
} else {
    echo "   ✗ Router class not found\n";
}

echo "\n3. Testing environment...\n";
if (file_exists('.env')) {
    echo "   ✓ .env file exists\n";
    
    // Load environment manually
    $lines = file('.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
    
    echo "   APP_URL: " . ($_ENV['APP_URL'] ?? 'not set') . "\n";
    echo "   APP_ENV: " . ($_ENV['APP_ENV'] ?? 'not set') . "\n";
    echo "   DB_HOST: " . ($_ENV['DB_HOST'] ?? 'not set') . "\n";
} else {
    echo "   ✗ .env file not found\n";
}

echo "\n4. Testing request simulation...\n";
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/test';

echo "   Request method: " . $_SERVER['REQUEST_METHOD'] . "\n";
echo "   Request URI: " . $_SERVER['REQUEST_URI'] . "\n";
echo "   Parsed path: " . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . "\n";

echo "\n=== TEST COMPLETE ===\n";
