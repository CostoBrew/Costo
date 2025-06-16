<?php

/**
 * Firebase Frontend Configuration Helper
 * Generates JavaScript Firebase config from environment variables
 */

require_once __DIR__ . '/database.php';

class FirebaseFrontendConfig
{
    /**
     * Get Firebase configuration as JSON for frontend
     */
    public static function getConfigJson(): string
    {
        // Load environment variables
        DatabaseConfig::loadEnvironment();
        
        $config = [
            'apiKey' => $_ENV['FIREBASE_API_KEY'] ?? '',
            'authDomain' => $_ENV['FIREBASE_AUTH_DOMAIN'] ?? '',
            'projectId' => $_ENV['FIREBASE_PROJECT_ID'] ?? '',
            'storageBucket' => $_ENV['FIREBASE_STORAGE_BUCKET'] ?? '',
            'messagingSenderId' => $_ENV['FIREBASE_MESSAGING_SENDER_ID'] ?? '',
            'appId' => $_ENV['FIREBASE_APP_ID'] ?? ''
        ];
        
        return json_encode($config, JSON_UNESCAPED_SLASHES);
    }
    
    /**
     * Get Firebase configuration as JavaScript object string
     */
    public static function getConfigJs(): string
    {
        return 'const firebaseConfig = ' . self::getConfigJson() . ';';
    }
    
    /**
     * Check if Firebase frontend config is complete
     */
    public static function isConfigComplete(): bool
    {
        DatabaseConfig::loadEnvironment();
        
        $requiredKeys = [
            'FIREBASE_API_KEY',
            'FIREBASE_AUTH_DOMAIN', 
            'FIREBASE_PROJECT_ID',
            'FIREBASE_STORAGE_BUCKET',
            'FIREBASE_MESSAGING_SENDER_ID',
            'FIREBASE_APP_ID'
        ];
        
        foreach ($requiredKeys as $key) {
            $value = $_ENV[$key] ?? '';
            if (empty($value) || strpos($value, 'your-') === 0) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Get missing configuration keys
     */
    public static function getMissingKeys(): array
    {
        DatabaseConfig::loadEnvironment();
        
        $requiredKeys = [
            'FIREBASE_API_KEY',
            'FIREBASE_AUTH_DOMAIN', 
            'FIREBASE_PROJECT_ID',
            'FIREBASE_STORAGE_BUCKET',
            'FIREBASE_MESSAGING_SENDER_ID',
            'FIREBASE_APP_ID'
        ];
        
        $missing = [];
        foreach ($requiredKeys as $key) {
            $value = $_ENV[$key] ?? '';
            if (empty($value) || strpos($value, 'your-') === 0) {
                $missing[] = $key;
            }
        }
        
        return $missing;
    }
}
