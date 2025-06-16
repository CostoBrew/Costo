<?php

/**
 * Firebase Authentication Middleware
 * Handles Firebase token verification and user authentication
 */

require_once __DIR__ . '/../config/firebase.php';

class FirebaseAuthMiddleware
{    /**
     * @var array Paths that don't require authentication
     */
    private static $publicPaths = [
        '/',
        '/home',
        '/login',
        '/register',
        '/signup',
        '/logout',
        '/about',
        '/contact',
        '/menu',
        '/community',
        '/community/product',
        '/forgot-password',
        '/reset-password',
        '/test-simple.php',
        '/simple-debug.php',
        '/phpinfo.php'
    ];

    /**
     * @var array Paths that require admin privileges
     */
    private static $adminPaths = [
        '/admin',
        '/admin/dashboard',
        '/admin/users',
        '/admin/orders',
        '/admin/products'
    ];

    /**
     * Handle Firebase authentication middleware
     * 
     * @param string $path Current request path
     * @return array|false User data if authenticated, false if authentication failed
     */
    public static function handle(string $path)
    {
        // Clean the path
        $path = '/' . trim($path, '/');
        
        // Check if path is public (no authentication required)
        if (self::isPublicPath($path)) {
            return ['status' => 'public', 'user' => null];
        }

        // Check if Firebase is configured
        if (!FirebaseConfig::isConfigured()) {
            error_log("Firebase not configured, but protected route accessed: " . $path);
            return ['status' => 'error', 'message' => 'Authentication service not configured'];
        }

        // Try to get Firebase ID token from various sources
        $idToken = self::getIdTokenFromRequest();
        
        if (!$idToken) {
            // No token provided, redirect to login
            return ['status' => 'unauthorized', 'message' => 'Authentication required'];
        }

        // Verify the Firebase ID token
        $userData = FirebaseConfig::verifyIdToken($idToken);
        
        if (!$userData) {
            // Invalid token, redirect to login
            return ['status' => 'unauthorized', 'message' => 'Invalid authentication token'];
        }

        // Check if user account is disabled
        if ($userData['disabled']) {
            return ['status' => 'forbidden', 'message' => 'Account has been disabled'];
        }

        // Check email verification if required
        $requireEmailVerification = $_ENV['REQUIRE_EMAIL_VERIFICATION'] ?? 'false';
        if ($requireEmailVerification === 'true' && !$userData['emailVerified']) {
            return ['status' => 'unauthorized', 'message' => 'Email verification required'];
        }

        // Check admin access for admin paths
        if (self::isAdminPath($path)) {
            $isAdmin = self::isUserAdmin($userData);
            if (!$isAdmin) {
                return ['status' => 'forbidden', 'message' => 'Admin access required'];
            }
        }

        // Store user data in session for easy access
        self::storeUserSession($userData);

        return ['status' => 'authenticated', 'user' => $userData];
    }

    /**
     * Get Firebase ID token from request
     * Checks Authorization header, cookies, and POST data
     * 
     * @return string|null The ID token or null if not found
     */
    private static function getIdTokenFromRequest(): ?string
    {
        // Check Authorization header (Bearer token)
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            $authHeader = $headers['Authorization'];
            if (preg_match('/Bearer\s+(.*)$/i', $authHeader, $matches)) {
                return $matches[1];
            }
        }

        // Check for token in cookies
        if (isset($_COOKIE['firebase_token'])) {
            return $_COOKIE['firebase_token'];
        }

        // Check for token in POST data
        if (isset($_POST['firebase_token'])) {
            return $_POST['firebase_token'];
        }        // Check for token in session (fallback)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (isset($_SESSION['firebase_token'])) {
            return $_SESSION['firebase_token'];
        }

        return null;
    }

    /**
     * Check if path is public (doesn't require authentication)
     * 
     * @param string $path The request path
     * @return bool True if public, false if protected
     */
    private static function isPublicPath(string $path): bool
    {
        // Exact matches
        if (in_array($path, self::$publicPaths)) {
            return true;
        }

        // Pattern matches for dynamic routes
        $publicPatterns = [
            '/^\/community\/product\/\d+$/',  // Community product pages
            '/^\/api\/public\/.*$/',          // Public API endpoints
            '/^\/src\/.*$/',                  // Static assets
            '/^\/assets\/.*$/',               // Static assets
            '/^\/css\/.*$/',                  // CSS files
            '/^\/js\/.*$/',                   // JavaScript files
            '/^\/images\/.*$/',               // Images
        ];

        foreach ($publicPatterns as $pattern) {
            if (preg_match($pattern, $path)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if path requires admin privileges
     * 
     * @param string $path The request path
     * @return bool True if admin path, false otherwise
     */
    private static function isAdminPath(string $path): bool
    {
        foreach (self::$adminPaths as $adminPath) {
            if (strpos($path, $adminPath) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if user has admin privileges
     * 
     * @param array $userData User data from Firebase
     * @return bool True if user is admin, false otherwise
     */
    private static function isUserAdmin(array $userData): bool
    {
        // Check custom claims for admin role
        if (isset($userData['customClaims']['admin']) && $userData['customClaims']['admin'] === true) {
            return true;
        }

        if (isset($userData['customClaims']['role']) && $userData['customClaims']['role'] === 'admin') {
            return true;
        }

        // Check specific admin emails (fallback)
        $adminEmails = [
            'admin@costobrew.com',
            'owner@costobrew.com'
        ];

        return in_array($userData['email'], $adminEmails);
    }

    /**
     * Store user data in session
     * 
     * @param array $userData User data from Firebase
     */
    private static function storeUserSession(array $userData): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['firebase_user'] = $userData;
        $_SESSION['user_id'] = $userData['uid'];
        $_SESSION['user_email'] = $userData['email'];
        $_SESSION['user_name'] = $userData['displayName'] ?? '';
        $_SESSION['is_authenticated'] = true;
        $_SESSION['auth_time'] = time();
    }

    /**
     * Get current user from session
     * 
     * @return array|null User data or null if not authenticated
     */
    public static function getCurrentUser(): ?array
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['firebase_user'])) {
            // Check session age
            $maxAge = $_ENV['MAX_TOKEN_AGE'] ?? 3600;
            $authTime = $_SESSION['auth_time'] ?? 0;
            
            if ((time() - $authTime) > $maxAge) {
                // Session expired
                self::clearUserSession();
                return null;
            }

            return $_SESSION['firebase_user'];
        }

        return null;
    }

    /**
     * Clear user session
     */
    public static function clearUserSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        unset($_SESSION['firebase_user']);
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['is_authenticated']);
        unset($_SESSION['auth_time']);
        unset($_SESSION['firebase_token']);

        // Clear Firebase token cookie
        setcookie('firebase_token', '', time() - 3600, '/', '', false, true);
    }

    /**
     * Check if current user is authenticated
     * 
     * @return bool True if authenticated, false otherwise
     */
    public static function isAuthenticated(): bool
    {
        return self::getCurrentUser() !== null;
    }

    /**
     * Check if current user is admin
     * 
     * @return bool True if admin, false otherwise
     */
    public static function isAdmin(): bool
    {
        $user = self::getCurrentUser();
        
        if (!$user) {
            return false;
        }

        return self::isUserAdmin($user);
    }

    /**
     * Redirect to login page
     * 
     * @param string $returnUrl URL to return to after login
     */
    public static function redirectToLogin(string $returnUrl = ''): void
    {
        $baseUrl = $_ENV['APP_URL'] ?? 'http://localhost:8000';
        $loginUrl = $baseUrl . '/login';
        
        if (!empty($returnUrl)) {
            $loginUrl .= '?return=' . urlencode($returnUrl);
        }

        header('Location: ' . $loginUrl);
        exit;
    }

    /**
     * Handle authentication response
     * 
     * @param array $authResult Result from handle() method
     * @param string $currentPath Current request path
     */
    public static function handleAuthResponse(array $authResult, string $currentPath): void
    {
        switch ($authResult['status']) {
            case 'public':
                // Public route, continue normally
                break;
                
            case 'authenticated':
                // User is authenticated, continue normally
                break;
                
            case 'unauthorized':
                // Redirect to login
                self::redirectToLogin($currentPath);
                break;
                
            case 'forbidden':
                // Show 403 error
                http_response_code(403);
                echo "Access denied: " . ($authResult['message'] ?? 'Insufficient privileges');
                exit;
                
            case 'error':
                // Show 500 error
                http_response_code(500);
                echo "Authentication error: " . ($authResult['message'] ?? 'Unknown error');
                exit;
        }
    }
}
