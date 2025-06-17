<?php

/**
 * CSRF Protection Middleware
 * Protects against Cross-Site Request Forgery attacks
 */

class CSRFMiddleware
{    /**
     * Handle CSRF protection
     */
    public function handle()
    {
        // Session should already be started in index.php
        // But double-check just in case
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $method = $_SERVER['REQUEST_METHOD'];

        // Only check CSRF for state-changing methods
        if (in_array($method, ['POST', 'PUT', 'DELETE', 'PATCH'])) {
            $this->validateCSRFToken();
        }

        // Generate token for next request
        $this->generateCSRFToken();
    }

    /**
     * Generate CSRF token
     */
    private function generateCSRFToken()
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }

    /**
     * Validate CSRF token
     */    private function validateCSRFToken()
    {
        $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;

        if (!$token || !isset($_SESSION['csrf_token'])) {
            $this->csrfFailure();
        }

        if (!hash_equals($_SESSION['csrf_token'], $token)) {
            $this->csrfFailure();
        }
    }

    /**
     * Handle CSRF failure
     */    private function csrfFailure()
    {
        http_response_code(419);
        
        if ($_ENV['APP_ENV'] === 'development') {
            die('CSRF Token Mismatch: Invalid or missing CSRF token.');
        } else {
            die('Security error: Invalid request.');
        }
    }/**
     * Get CSRF token for forms
     */
    public static function getToken()
    {
        // Session should already be started in index.php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    /**
     * Generate CSRF input field for forms
     */
    public static function field()
    {
        $token = self::getToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
    }
}
