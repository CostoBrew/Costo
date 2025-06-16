<?php

/**
 * Firebase Configuration
 * Handles Firebase SDK initialization and authentication
 */

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/database.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;
use Kreait\Firebase\Exception\FirebaseException;

class FirebaseConfig
{
    private static $auth = null;
    private static $factory = null;    /**
     * Initialize Firebase with service account
     */
    private static function initializeFirebase()
    {
        if (self::$factory === null) {
            // Load environment variables
            DatabaseConfig::loadEnvironment();

            // Set cURL default options for SSL in development
            if (($_ENV['FIREBASE_DISABLE_SSL_VERIFY'] ?? 'false') === 'true') {
                // Set global cURL defaults
                curl_setopt_array(curl_init(), [
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_TIMEOUT => 30
                ]);
                
                // Also set ini settings for HTTP context
                ini_set('default_socket_timeout', 30);
                ini_set('user_agent', 'Costobrew-Firebase-Client/1.0');
            }

            $projectId = $_ENV['FIREBASE_PROJECT_ID'] ?? 'your-firebase-project-id';
            $serviceAccountPath = $_ENV['FIREBASE_SERVICE_ACCOUNT_PATH'] ?? './config/firebase-service-account.json';

            // Resolve the service account path
            $fullPath = __DIR__ . '/../../' . ltrim($serviceAccountPath, './');
              try {
                if (file_exists($fullPath)) {
                    // For Kreait Firebase SDK v6, use fromValue with file contents
                    $serviceAccountJson = file_get_contents($fullPath);
                    $serviceAccount = ServiceAccount::fromValue($serviceAccountJson);
                } else {
                    // Fallback: try to create service account from environment variables
                    throw new Exception("Firebase service account file not found at: $fullPath");
                }                self::$factory = (new Factory)
                    ->withServiceAccount($serviceAccount)
                    ->withProjectId($projectId);

            } catch (Exception $e) {
                error_log("Firebase initialization error: " . $e->getMessage());
                throw new Exception("Failed to initialize Firebase: " . $e->getMessage());
            }
        }

        return self::$factory;
    }

    /**
     * Get Firebase Auth instance
     */
    public static function getAuth(): Auth
    {
        if (self::$auth === null) {
            $factory = self::initializeFirebase();
            self::$auth = $factory->createAuth();
        }

        return self::$auth;
    }

    /**
     * Verify Firebase ID Token
     * 
     * @param string $idToken The Firebase ID token to verify
     * @return array|false User data if token is valid, false otherwise
     */    public static function verifyIdToken(string $idToken)
    {
        try {
            // For development SSL bypass
            if (($_ENV['FIREBASE_DISABLE_SSL_VERIFY'] ?? 'false') === 'true' && 
                ($_ENV['APP_ENV'] ?? 'development') === 'development') {
                
                try {
                    // Try normal verification first
                    $auth = self::getAuth();
                    $verifiedIdToken = $auth->verifyIdToken($idToken);
                    
                    $uid = $verifiedIdToken->claims()->get('sub');
                    $user = $auth->getUser($uid);
                    
                    return [
                        'uid' => $user->uid,
                        'email' => $user->email,
                        'emailVerified' => $user->emailVerified,
                        'displayName' => $user->displayName,
                        'photoURL' => $user->photoUrl,
                        'disabled' => $user->disabled,
                        'metadata' => [
                            'createdAt' => $user->metadata->createdAt,
                            'lastSignedInAt' => $user->metadata->lastSignedInAt ?? null,
                            'lastRefreshAt' => $user->metadata->lastRefreshAt ?? null
                        ],
                        'customClaims' => $user->customClaims,
                        'tokenClaims' => $verifiedIdToken->claims()->all()
                    ];
                    
                } catch (Exception $sslError) {
                    // Development bypass for SSL issues
                    error_log("SSL bypass activated due to: " . $sslError->getMessage());
                    
                    // Basic JWT decode for development (NOT SECURE - development only)
                    $parts = explode('.', $idToken);
                    if (count($parts) === 3) {
                        $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $parts[1])), true);
                        
                        if ($payload && isset($payload['email'])) {
                            return [
                                'uid' => $payload['sub'] ?? 'dev-' . hash('md5', $payload['email']),
                                'email' => $payload['email'],
                                'emailVerified' => $payload['email_verified'] ?? true,
                                'displayName' => $payload['name'] ?? '',
                                'photoURL' => $payload['picture'] ?? '',
                                'disabled' => false,
                                'metadata' => [
                                    'createdAt' => date('c'),
                                    'lastSignedInAt' => date('c'),
                                    'lastRefreshAt' => date('c')
                                ],
                                'customClaims' => [],
                                'tokenClaims' => $payload
                            ];
                        }
                    }
                    
                    throw $sslError;
                }
            } else {
                // Normal production verification
                $auth = self::getAuth();
                $verifiedIdToken = $auth->verifyIdToken($idToken);
                
                $uid = $verifiedIdToken->claims()->get('sub');
                $user = $auth->getUser($uid);
                
                return [
                    'uid' => $user->uid,
                    'email' => $user->email,
                    'emailVerified' => $user->emailVerified,
                    'displayName' => $user->displayName,
                    'photoURL' => $user->photoUrl,
                    'disabled' => $user->disabled,
                    'metadata' => [
                        'createdAt' => $user->metadata->createdAt,
                        'lastSignedInAt' => $user->metadata->lastSignedInAt ?? null,
                        'lastRefreshAt' => $user->metadata->lastRefreshAt ?? null
                    ],
                    'customClaims' => $user->customClaims,
                    'tokenClaims' => $verifiedIdToken->claims()->all()
                ];
            }

        } catch (FailedToVerifyToken $e) {
            error_log("Failed to verify Firebase token: " . $e->getMessage());
            return false;
        } catch (FirebaseException $e) {
            error_log("Firebase error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General error in token verification: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Create a custom token for a user
     * 
     * @param string $uid User ID
     * @param array $additionalClaims Additional claims to include in the token
     * @return string|false Custom token or false on failure
     */
    public static function createCustomToken(string $uid, array $additionalClaims = [])
    {
        try {
            $auth = self::getAuth();
            return $auth->createCustomToken($uid, $additionalClaims)->toString();
        } catch (Exception $e) {
            error_log("Failed to create custom token: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get user by UID
     * 
     * @param string $uid User ID
     * @return array|false User data or false if not found
     */
    public static function getUser(string $uid)
    {
        try {
            $auth = self::getAuth();
            $user = $auth->getUser($uid);

            return [
                'uid' => $user->uid,
                'email' => $user->email,
                'emailVerified' => $user->emailVerified,
                'displayName' => $user->displayName,
                'photoURL' => $user->photoUrl,
                'disabled' => $user->disabled,
                'metadata' => [
                    'createdAt' => $user->metadata->createdAt,
                    'lastSignedInAt' => $user->metadata->lastSignedInAt ?? null,
                    'lastRefreshAt' => $user->metadata->lastRefreshAt ?? null
                ],
                'customClaims' => $user->customClaims
            ];

        } catch (Exception $e) {
            error_log("Failed to get user: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get user by email
     * 
     * @param string $email User email
     * @return array|false User data or false if not found
     */
    public static function getUserByEmail(string $email)
    {
        try {
            $auth = self::getAuth();
            $user = $auth->getUserByEmail($email);

            return [
                'uid' => $user->uid,
                'email' => $user->email,
                'emailVerified' => $user->emailVerified,
                'displayName' => $user->displayName,
                'photoURL' => $user->photoUrl,
                'disabled' => $user->disabled,
                'metadata' => [
                    'createdAt' => $user->metadata->createdAt,
                    'lastSignedInAt' => $user->metadata->lastSignedInAt ?? null,
                    'lastRefreshAt' => $user->metadata->lastRefreshAt ?? null
                ],
                'customClaims' => $user->customClaims
            ];

        } catch (Exception $e) {
            error_log("Failed to get user by email: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update user custom claims
     * 
     * @param string $uid User ID
     * @param array $customClaims Custom claims to set
     * @return bool Success status
     */
    public static function setCustomUserClaims(string $uid, array $customClaims): bool
    {
        try {
            $auth = self::getAuth();
            $auth->setCustomUserClaims($uid, $customClaims);
            return true;
        } catch (Exception $e) {
            error_log("Failed to set custom user claims: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Disable user account
     * 
     * @param string $uid User ID
     * @return bool Success status
     */
    public static function disableUser(string $uid): bool
    {
        try {
            $auth = self::getAuth();
            $auth->disableUser($uid);
            return true;
        } catch (Exception $e) {
            error_log("Failed to disable user: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Enable user account
     * 
     * @param string $uid User ID
     * @return bool Success status
     */
    public static function enableUser(string $uid): bool
    {
        try {
            $auth = self::getAuth();
            $auth->enableUser($uid);
            return true;
        } catch (Exception $e) {
            error_log("Failed to enable user: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if Firebase is properly configured
     * 
     * @return bool True if Firebase is configured, false otherwise
     */
    public static function isConfigured(): bool
    {
        try {
            DatabaseConfig::loadEnvironment();
            $projectId = $_ENV['FIREBASE_PROJECT_ID'] ?? '';
            $serviceAccountPath = $_ENV['FIREBASE_SERVICE_ACCOUNT_PATH'] ?? '';
            
            if (empty($projectId) || $projectId === 'your-firebase-project-id') {
                return false;
            }

            $fullPath = __DIR__ . '/../../' . ltrim($serviceAccountPath, './');
            return file_exists($fullPath);
            
        } catch (Exception $e) {
            return false;
        }
    }
}
