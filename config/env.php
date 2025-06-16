<?php

/**
 * Environment Configuration Loader
 * This file loads environment variables from .env file
 */

function loadEnv($filePath) {
    if (!file_exists($filePath)) {
        return;
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue; // Skip comments
        }

        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            
            // Remove quotes
            $value = trim($value, '"\'');
            
            if (!array_key_exists($name, $_ENV)) {
                $_ENV[$name] = $value;
                putenv("$name=$value");
            }
        }
    }
}

// Load environment variables
$envPath = __DIR__ . '/.env';
if (file_exists($envPath)) {
    loadEnv($envPath);
} else {
    // Load example if .env doesn't exist
    $envExamplePath = __DIR__ . '/.env.example';
    if (file_exists($envExamplePath)) {
        loadEnv($envExamplePath);
        error_log('Warning: Using .env.example file. Please create a .env file with your actual configuration.');
    }
}
