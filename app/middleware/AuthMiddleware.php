<?php

/**
 * Authentication Middleware
 * Ensures user is logged in before accessing protected routes
 */

class AuthMiddleware
{
    /**
     * Handle authentication check
     */
    public function handle()
    {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if user is authenticated
        if (!$this->isAuthenticated()) {
            $this->redirectToLogin();
        }

        // Check session validity
        $this->validateSession();
    }

    /**
     * Check if user is authenticated
     */
    private function isAuthenticated()
    {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }

    /**
     * Validate session integrity
     */
    private function validateSession()
    {
        // Check session timeout
        $sessionLifetime = ($_ENV['SESSION_LIFETIME'] ?? 120) * 60;
        
        if (isset($_SESSION['last_activity'])) {
            if (time() - $_SESSION['last_activity'] > $sessionLifetime) {
                $this->destroySession();
                $this->redirectToLogin('Your session has expired. Please log in again.');
            }
        }

        // Update last activity
        $_SESSION['last_activity'] = time();

        // Regenerate session ID periodically for security
        if (!isset($_SESSION['created_at'])) {
            $_SESSION['created_at'] = time();
        } elseif (time() - $_SESSION['created_at'] > 300) { // Every 5 minutes
            session_regenerate_id(true);
            $_SESSION['created_at'] = time();
        }
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
        
        // Store the intended URL for redirect after login
        if (!isset($_SESSION['intended_url'])) {
            $_SESSION['intended_url'] = $_SERVER['REQUEST_URI'];
        }

        if ($message) {
            $_SESSION['flash_message'] = $message;
        }

        header("Location: {$loginUrl}");
        exit();
    }
}
