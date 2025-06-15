<?php

/**
 * Secure Database Configuration
 * Loads environment variables from .env file and creates PDO connection
 */

class DatabaseConfig
{
    private static $connection = null;
    private static $config = [];

    /**
     * Load environment variables from .env file
     */
    private static function loadEnvironment()
    {
        $envFile = __DIR__ . '/../../.env';
        
        if (!file_exists($envFile)) {
            throw new Exception('.env file not found. Please create .env file in project root.');
        }

        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            // Skip comments
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Parse key=value pairs
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);
                
                // Remove quotes if present
                if ((substr($value, 0, 1) === '"' && substr($value, -1) === '"') ||
                    (substr($value, 0, 1) === "'" && substr($value, -1) === "'")) {
                    $value = substr($value, 1, -1);
                }
                
                $_ENV[$key] = $value;
                putenv("$key=$value");
            }
        }
    }

    /**
     * Get database configuration with security validation
     */
    private static function getDatabaseConfig()
    {
        self::loadEnvironment();

        // Required environment variables
        $required = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'];
        $missing = [];

        foreach ($required as $var) {
            if (!isset($_ENV[$var])) {
                $missing[] = $var;
            }
        }

        if (!empty($missing)) {
            throw new Exception('Missing required environment variables: ' . implode(', ', $missing));
        }

        return [
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'] ?? '3306',
            'database' => $_ENV['DB_NAME'],
            'username' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASS'],
            'charset' => $_ENV['DB_CHARSET'] ?? 'utf8mb4',
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_PERSISTENT => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
            ]
        ];
    }

    /**
     * Create secure PDO connection with singleton pattern
     */
    public static function getConnection()
    {
        if (self::$connection === null) {
            try {
                $config = self::getDatabaseConfig();
                
                $dsn = sprintf(
                    "mysql:host=%s;port=%s;dbname=%s;charset=%s",
                    $config['host'],
                    $config['port'],
                    $config['database'],
                    $config['charset']
                );

                self::$connection = new PDO(
                    $dsn,
                    $config['username'],
                    $config['password'],
                    $config['options']
                );

                // Additional security settings
                self::$connection->exec("SET SESSION sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_DATE,NO_ZERO_IN_DATE,ERROR_FOR_DIVISION_BY_ZERO'");
                
            } catch (PDOException $e) {
                // Log error securely (don't expose credentials)
                error_log('Database connection failed: ' . $e->getMessage());
                
                // Show user-friendly error
                if ($_ENV['APP_ENV'] === 'development') {
                    throw new Exception('Database connection failed: ' . $e->getMessage());
                } else {
                    throw new Exception('Database connection failed. Please check your configuration.');
                }
            }
        }

        return self::$connection;
    }

    /**
     * Test database connection
     */
    public static function testConnection()
    {
        try {
            $pdo = self::getConnection();
            $stmt = $pdo->query('SELECT 1');
            return $stmt !== false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Close database connection
     */
    public static function closeConnection()
    {
        self::$connection = null;
    }

    /**
     * Get connection info (for debugging - safe version)
     */
    public static function getConnectionInfo()
    {
        $config = self::getDatabaseConfig();
        return [
            'host' => $config['host'],
            'port' => $config['port'],
            'database' => $config['database'],
            'charset' => $config['charset'],
            'username' => substr($config['username'], 0, 2) . '***' // Partially hidden
        ];
    }
}

// Create connection instance for backward compatibility
// Note: Connection is now handled by DatabaseConfig::getConnection()
// This allows the application to work even if database is not configured
$pdo = null;