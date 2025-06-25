<?php

/**
 * Admin Authentication Middleware
 * Ensures user has admin privileges
 */

class AdminMiddleware
{
    /**
     * Handle admin authentication check
     */
    public function handle()
    {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // First check if user is authenticated
        if (!$this->isAuthenticated()) {
            $this->redirectToLogin();
        }

        // Then check if user has admin privileges
        if (!$this->isAdmin()) {
            $this->accessDenied();
        }

        // Validate admin session
        $this->validateAdminSession();
    }

    /**
     * Check if user is authenticated
     */
    private function isAuthenticated()
    {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }

    /**
     * Check if user has admin privileges
     */
    private function isAdmin()
    {
        // Check if user email is the specific admin email
        $userEmail = $_SESSION['user_email'] ?? '';
        return $userEmail === '1admin@costobrew.com';
    }

    /**
     * Validate admin session with enhanced security
     */
    private function validateAdminSession()
    {
        // Enhanced timeout for admin sessions (shorter)
        $adminSessionLifetime = 30 * 60; // 30 minutes
        
        if (isset($_SESSION['admin_last_activity'])) {
            if (time() - $_SESSION['admin_last_activity'] > $adminSessionLifetime) {
                $this->logAdminActivity('session_timeout');
                $this->destroySession();
                $this->redirectToLogin('Admin session expired for security.');
            }
        }

        // Update admin activity
        $_SESSION['admin_last_activity'] = time();

        // More frequent session regeneration for admin
        if (!isset($_SESSION['admin_created_at'])) {
            $_SESSION['admin_created_at'] = time();
        } elseif (time() - $_SESSION['admin_created_at'] > 180) { // Every 3 minutes
            session_regenerate_id(true);
            $_SESSION['admin_created_at'] = time();
        }

        // Log admin access
        $this->logAdminActivity('access');
    }

    /**
     * Log admin activities for security auditing
     */
    private function logAdminActivity($action)
    {
        $logData = [
            'timestamp' => date('Y-m-d H:i:s'),
            'user_id' => $_SESSION['user_id'] ?? 'unknown',
            'action' => $action,
            'ip' => $this->getClientIp(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'url' => $_SERVER['REQUEST_URI'] ?? 'unknown'
        ];

        // Log to file (in production, consider using a proper logging system)
        $logEntry = json_encode($logData) . "\n";
        file_put_contents(__DIR__ . '/../../logs/admin.log', $logEntry, FILE_APPEND | LOCK_EX);
    }

    /**
     * Get client IP address
     */
    private function getClientIp()
    {
        $ipKeys = ['HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'HTTP_CLIENT_IP', 'REMOTE_ADDR'];
        
        foreach ($ipKeys as $key) {
            if (!empty($_SERVER[$key])) {
                $ip = $_SERVER[$key];
                if (strpos($ip, ',') !== false) {
                    $ip = trim(explode(',', $ip)[0]);
                }
                
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }

        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }

    /**
     * Handle access denied
     */
    private function accessDenied()
    {
        $this->logAdminActivity('access_denied');
        
        http_response_code(403);
        
        if (file_exists(__DIR__ . '/../view/errors/403.php')) {
            require_once __DIR__ . '/../view/errors/403.php';
        } else {
            echo '403 - Access Denied: You do not have permission to access this resource.';
        }
        exit();
    }

    /**
     * Destroy session and clean up
     */
    private function destroySession()
    {
        $_SESSION = [];
        
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        session_destroy();
    }

    /**
     * Redirect to login page
     */
    private function redirectToLogin($message = null)
    {
        $loginUrl = url('/login');
        
        if ($message) {
            $_SESSION['flash_message'] = $message;
        }

        header("Location: {$loginUrl}");
        exit();
    }
}
