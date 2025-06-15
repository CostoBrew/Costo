<?php

/**
 * Security Headers Middleware
 * Adds security headers to prevent common attacks
 */

class SecurityMiddleware
{
    /**
     * Handle security headers
     */
    public function handle()
    {
        // Prevent clickjacking
        header('X-Frame-Options: DENY');
        
        // Prevent MIME type sniffing
        header('X-Content-Type-Options: nosniff');
        
        // Enable XSS protection
        header('X-XSS-Protection: 1; mode=block');
        
        // Referrer policy
        header('Referrer-Policy: strict-origin-when-cross-origin');
        
        // Content Security Policy
        $csp = $this->getContentSecurityPolicy();
        header("Content-Security-Policy: {$csp}");
        
        // Strict Transport Security (only for HTTPS)
        if ($this->isHttps()) {
            header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
        }
        
        // Permissions Policy
        header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
        
        // Remove server signature
        header_remove('X-Powered-By');
        
        // Set secure session cookies
        $this->setSecureSessionConfig();
    }

    /**
     * Get Content Security Policy
     */
    private function getContentSecurityPolicy()
    {
        $policies = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://stackpath.bootstrapcdn.com",
            "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://stackpath.bootstrapcdn.com",
            "img-src 'self' data: https:",
            "font-src 'self' https://cdn.jsdelivr.net",
            "connect-src 'self'",
            "frame-ancestors 'none'",
            "base-uri 'self'",
            "form-action 'self'"
        ];

        return implode('; ', $policies);
    }

    /**
     * Check if connection is HTTPS
     */
    private function isHttps()
    {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
               $_SERVER['SERVER_PORT'] == 443 ||
               (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
    }

    /**
     * Set secure session configuration
     */
    private function setSecureSessionConfig()
    {
        if (session_status() === PHP_SESSION_NONE) {
            // Configure session security
            ini_set('session.cookie_httponly', 1);
            ini_set('session.use_only_cookies', 1);
            ini_set('session.cookie_samesite', 'Strict');
            
            if ($this->isHttps()) {
                ini_set('session.cookie_secure', 1);
            }
            
            // Set session lifetime from environment
            $lifetime = $_ENV['SESSION_LIFETIME'] ?? 120;
            ini_set('session.gc_maxlifetime', $lifetime * 60);
            ini_set('session.cookie_lifetime', $lifetime * 60);
            
            session_start();
        }
    }
}
