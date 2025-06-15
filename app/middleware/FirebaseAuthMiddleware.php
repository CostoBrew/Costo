<?php

/**
 * Firebase Authentication Middleware
 * Integrates with Firebase Auth while maintaining server-side security
 */

require_once 'vendor/autoload.php'; // Firebase SDK

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class FirebaseAuthMiddleware
{
    private $firebaseProjectId;
    private $firebaseKeys;

    public function __construct()
    {
        $this->firebaseProjectId = $_ENV['FIREBASE_PROJECT_ID'] ?? '';
        $this->firebaseKeys = $this->getFirebasePublicKeys();
    }

    /**
     * Handle Firebase authentication check
     */
    public function handle()
    {
        // Start session for additional security features
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Get Firebase ID token
        $idToken = $this->getFirebaseIdToken();

        if (!$idToken) {
            $this->redirectToLogin('Authentication required');
        }

        // Verify Firebase token
        $decodedToken = $this->verifyFirebaseToken($idToken);

        if (!$decodedToken) {
            $this->redirectToLogin('Invalid authentication token');
        }

        // Store user info in session for this request
        $this->storeUserSession($decodedToken);

        // Additional security checks
        $this->performSecurityChecks($decodedToken);
    }

    /**
     * Get Firebase ID token from request
     */
    private function getFirebaseIdToken()
    {
        // Check Authorization header
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            if (preg_match('/Bearer\s+(.*)$/i', $headers['Authorization'], $matches)) {
                return $matches[1];
            }
        }

        // Check POST data (for form submissions)
        if (isset($_POST['firebase_token'])) {
            return $_POST['firebase_token'];
        }

        // Check session (fallback)
        if (isset($_SESSION['firebase_token'])) {
            return $_SESSION['firebase_token'];
        }

        return null;
    }

    /**
     * Verify Firebase ID token
     */
    private function verifyFirebaseToken($idToken)
    {
        try {
            // Decode without verification first to get the kid
            $header = json_decode(base64_decode(str_replace('_', '/', str_replace('-', '+', explode('.', $idToken)[0]))), true);
            
            if (!isset($header['kid']) || !isset($this->firebaseKeys[$header['kid']])) {
                return false;
            }

            $publicKey = $this->firebaseKeys[$header['kid']];
            
            // Verify the token
            $decoded = JWT::decode($idToken, new Key($publicKey, 'RS256'));

            // Additional validation
            if ($decoded->aud !== $this->firebaseProjectId) {
                return false;
            }

            if ($decoded->iss !== "https://securetoken.google.com/{$this->firebaseProjectId}") {
                return false;
            }

            if ($decoded->exp < time()) {
                return false;
            }

            return $decoded;

        } catch (Exception $e) {
            error_log('Firebase token verification failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get Firebase public keys for token verification
     */
    private function getFirebasePublicKeys()
    {
        $cacheFile = __DIR__ . '/../../cache/firebase_keys.json';
        
        // Check cache first
        if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < 3600) {
            return json_decode(file_get_contents($cacheFile), true);
        }

        // Fetch fresh keys
        try {
            $context = stream_context_create([
                'http' => [
                    'timeout' => 10,
                    'user_agent' => 'Costobrew/1.0'
                ]
            ]);

            $response = file_get_contents(
                'https://www.googleapis.com/robot/v1/metadata/x509/securetoken@system.gserviceaccount.com',
                false,
                $context
            );

            if ($response) {
                $keys = json_decode($response, true);
                
                // Cache the keys
                if (!is_dir(dirname($cacheFile))) {
                    mkdir(dirname($cacheFile), 0755, true);
                }
                file_put_contents($cacheFile, $response);
                
                return $keys;
            }
        } catch (Exception $e) {
            error_log('Failed to fetch Firebase keys: ' . $e->getMessage());
        }

        return [];
    }

    /**
     * Store user info in session for this request
     */
    private function storeUserSession($decodedToken)
    {
        $_SESSION['firebase_user'] = [
            'uid' => $decodedToken->sub,
            'email' => $decodedToken->email ?? null,
            'email_verified' => $decodedToken->email_verified ?? false,
            'name' => $decodedToken->name ?? null,
            'picture' => $decodedToken->picture ?? null,
            'auth_time' => $decodedToken->auth_time,
            'token_issued_at' => $decodedToken->iat
        ];

        $_SESSION['user_id'] = $decodedToken->sub; // For compatibility
        $_SESSION['last_activity'] = time();
    }

    /**
     * Perform additional security checks
     */
    private function performSecurityChecks($decodedToken)
    {
        // Check if email is verified (optional requirement)
        if ($_ENV['REQUIRE_EMAIL_VERIFICATION'] === 'true') {
            if (!($decodedToken->email_verified ?? false)) {
                $this->redirectToEmailVerification();
            }
        }

        // Check token age (additional security)
        $maxTokenAge = $_ENV['MAX_TOKEN_AGE'] ?? 3600; // 1 hour
        if ((time() - $decodedToken->iat) > $maxTokenAge) {
            $this->redirectToLogin('Please refresh your authentication');
        }

        // Rate limiting per user
        $this->checkUserRateLimit($decodedToken->sub);
    }

    /**
     * Check rate limiting per user
     */
    private function checkUserRateLimit($userId)
    {
        $key = "user_rate_limit:{$userId}";
        $maxRequests = $_ENV['USER_RATE_LIMIT'] ?? 100;
        $windowMinutes = 5;

        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = ['count' => 0, 'reset_time' => time() + ($windowMinutes * 60)];
        }

        $rateData = $_SESSION[$key];

        if (time() > $rateData['reset_time']) {
            $_SESSION[$key] = ['count' => 1, 'reset_time' => time() + ($windowMinutes * 60)];
        } else {
            $_SESSION[$key]['count']++;
            
            if ($_SESSION[$key]['count'] > $maxRequests) {
                http_response_code(429);
                die('Rate limit exceeded for user');
            }
        }
    }

    /**
     * Redirect to login
     */
    private function redirectToLogin($message = null)
    {
        if ($message) {
            $_SESSION['auth_message'] = $message;
        }

        // For API requests, return JSON
        if ($this->isApiRequest()) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Authentication required', 'message' => $message]);
            exit();
        }

        // For web requests, redirect to login
        header('Location: ' . url('/login'));
        exit();
    }

    /**
     * Redirect to email verification
     */
    private function redirectToEmailVerification()
    {
        $_SESSION['auth_message'] = 'Please verify your email address';
        header('Location: ' . url('/verify-email'));
        exit();
    }

    /**
     * Check if this is an API request
     */
    private function isApiRequest()
    {
        return strpos($_SERVER['REQUEST_URI'], '/api/') === 0 ||
               (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false);
    }

    /**
     * Get current Firebase user
     */
    public static function getUser()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION['firebase_user'] ?? null;
    }

    /**
     * Check if user is authenticated
     */
    public static function check()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['firebase_user']);
    }
}
