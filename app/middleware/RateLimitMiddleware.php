<?php

/**
 * Rate Limiting Middleware
 * Protects against brute force and DDoS attacks
 */

class RateLimitMiddleware
{
    private $maxAttempts;
    private $windowMinutes;

    public function __construct($maxAttempts = 60, $windowMinutes = 1)
    {
        $this->maxAttempts = $maxAttempts;
        $this->windowMinutes = $windowMinutes;
    }

    /**
     * Handle rate limiting
     */
    public function handle()
    {
        $clientIp = $this->getClientIp();
        $key = "rate_limit:{$clientIp}";
        
        // Start session for rate limiting storage
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $attempts = $this->getAttempts($key);
        
        if ($attempts >= $this->maxAttempts) {
            $this->rateLimitExceeded();
        }

        $this->incrementAttempts($key);
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
                // Handle comma-separated IPs
                if (strpos($ip, ',') !== false) {
                    $ip = trim(explode(',', $ip)[0]);
                }
                
                // Validate IP
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }

        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }

    /**
     * Get current attempts for IP
     */
    private function getAttempts($key)
    {
        $data = $_SESSION[$key] ?? null;
        
        if (!$data) {
            return 0;
        }

        // Check if window has expired
        $windowStart = time() - ($this->windowMinutes * 60);
        
        if ($data['timestamp'] < $windowStart) {
            unset($_SESSION[$key]);
            return 0;
        }

        return $data['attempts'];
    }

    /**
     * Increment attempts for IP
     */
    private function incrementAttempts($key)
    {
        $data = $_SESSION[$key] ?? ['attempts' => 0, 'timestamp' => time()];
        
        // Reset if window expired
        $windowStart = time() - ($this->windowMinutes * 60);
        if ($data['timestamp'] < $windowStart) {
            $data = ['attempts' => 0, 'timestamp' => time()];
        }

        $data['attempts']++;
        $_SESSION[$key] = $data;
    }

    /**
     * Handle rate limit exceeded
     */
    private function rateLimitExceeded()
    {
        http_response_code(429);
        header('Retry-After: ' . ($this->windowMinutes * 60));
        
        $response = [
            'error' => 'Too Many Requests',
            'message' => "Rate limit exceeded. Try again in {$this->windowMinutes} minute(s).",
            'retry_after' => $this->windowMinutes * 60
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    /**
     * Create rate limit middleware with custom limits
     */
    public static function create($maxAttempts = 60, $windowMinutes = 1)
    {
        return function() use ($maxAttempts, $windowMinutes) {
            $middleware = new self($maxAttempts, $windowMinutes);
            $middleware->handle();
        };
    }
}
