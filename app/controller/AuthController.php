<?php

/**
 * Authentication Controller
 * Handles login, signup, and logout functionality with Firebase integration
 */

require_once __DIR__ . '/../config/firebase.php';
require_once __DIR__ . '/../middleware/FirebaseAuthMiddleware.php';

class AuthController
{
    /**
     * Display login page
     */    public function showLogin()
    {
        // Check if user is already authenticated
        if (FirebaseAuthMiddleware::isAuthenticated()) {
            // Check if user is admin and redirect to admin dashboard
            if (isset($_SESSION['user_email']) && $_SESSION['user_email'] === '1admin@costobrew.com') {
                header('Location: /admin');
                exit;
            }
            $returnUrl = $_GET['return'] ?? '/';
            header('Location: ' . $returnUrl);
            exit;
        }

        // Include the login view
        include __DIR__ . '/../view/auth/login.php';
    }/**
     * Handle user login with Firebase token
     */    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Start output buffering to capture any stray output
            ob_start();
            
            $response = [
                'success' => false, 
                'message' => '',
                'data' => null,
                'errors' => [],
                'timestamp' => date('c')
            ];            try {
                // Get Firebase ID token from POST data
                $idToken = $_POST['firebase_token'] ?? '';
                
                if (empty($idToken)) {
                    $response['message'] = 'Authentication token is required';
                    $response['errors'][] = 'MISSING_TOKEN';
                    http_response_code(400);
                    $this->jsonResponse($response);
                    return;
                }                // Verify Firebase token
                $userData = FirebaseConfig::verifyIdToken($idToken);
                
                if (!$userData) {
                    $response['message'] = 'Invalid authentication credentials';
                    $response['errors'][] = 'INVALID_TOKEN';
                    http_response_code(401);
                    $this->jsonResponse($response);
                    return;
                }

                // Check if account is disabled
                if ($userData['disabled']) {
                    $response['message'] = 'Your account has been disabled';
                    $response['errors'][] = 'ACCOUNT_DISABLED';
                    http_response_code(403);
                    $this->jsonResponse($response);
                    return;
                }

                // Check email verification if required
                $requireEmailVerification = $_ENV['REQUIRE_EMAIL_VERIFICATION'] ?? 'false';
                if ($requireEmailVerification === 'true' && !$userData['emailVerified']) {
                    $response['message'] = 'Please verify your email address before logging in';
                    $response['errors'][] = 'EMAIL_NOT_VERIFIED';
                    $response['data'] = ['email' => $userData['email']];
                    http_response_code(403);
                    $this->jsonResponse($response);
                    return;
                }                // Store token in session and cookie
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                $_SESSION['firebase_token'] = $idToken;
                $_SESSION['firebase_user'] = $userData;
                $_SESSION['user_id'] = $userData['uid'];
                $_SESSION['user_email'] = $userData['email'];
                $_SESSION['user_name'] = $userData['displayName'] ?? '';
                $_SESSION['is_authenticated'] = true;
                $_SESSION['auth_time'] = time();
                $_SESSION['login_timestamp'] = date('c');

                // Set secure HTTP-only cookie for token
                $cookieOptions = [
                    'expires' => time() + 3600, // 1 hour
                    'path' => '/',
                    'domain' => '',
                    'secure' => ($_ENV['APP_ENV'] === 'production'),
                    'httponly' => true,
                    'samesite' => 'Strict'                ];
                setcookie('firebase_token', $idToken, $cookieOptions);                // Ensure session is written before response
                session_write_close();

                // Add delay to ensure session is written
                usleep(100000); // 100ms delay

                // Success response
                $response['success'] = true;
                $response['message'] = 'Login successful';
                $response['data'] = [
                    'user' => [
                        'uid' => $userData['uid'],
                        'email' => $userData['email'],
                        'displayName' => $userData['displayName'],
                        'emailVerified' => $userData['emailVerified'],
                        'photoURL' => $userData['photoURL'] ?? null,
                        'customClaims' => $userData['customClaims'] ?? []
                    ],
                    'session' => [
                        'expiresAt' => date('c', time() + 3600),
                        'loginTime' => date('c')
                    ],                    'redirect' => $userData['email'] === '1admin@costobrew.com' ? '/admin' : ($_POST['return_url'] ?? '/')
                ];

                http_response_code(200);
                $this->jsonResponse($response);

            } catch (Exception $e) {
                error_log("Login error: " . $e->getMessage());
                $response['message'] = 'An error occurred during login';
                $response['errors'][] = 'INTERNAL_ERROR';
                $response['data'] = $_ENV['APP_ENV'] === 'development' ? ['debug' => $e->getMessage()] : null;
                http_response_code(500);
                $this->jsonResponse($response);
            }
        } else {
            // GET request - show login form
            $this->showLogin();
        }
    }
    
    /**
     * Display signup page
     */
    public function showSignup()
    {
        // Check if user is already authenticated
        if (FirebaseAuthMiddleware::isAuthenticated()) {
            header('Location: /');
            exit;
        }

        // Include the signup view
        include __DIR__ . '/../view/auth/signup.php';
    }    /**
     * Handle user signup (Firebase handles account creation on frontend)
     */
    public function signup()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Start output buffering to capture any stray output
            ob_start();
            
            $response = [
                'success' => false, 
                'message' => '',
                'data' => null,
                'errors' => [],
                'timestamp' => date('c')
            ];

            try {
                // Get Firebase ID token from POST data (user already created via Firebase JS SDK)
                $idToken = $_POST['firebase_token'] ?? '';
                
                if (empty($idToken)) {
                    $response['message'] = 'Authentication token is required';
                    $response['errors'][] = 'MISSING_TOKEN';
                    http_response_code(400);
                    $this->jsonResponse($response);
                    return;
                }

                // Verify Firebase token
                $userData = FirebaseConfig::verifyIdToken($idToken);
                
                if (!$userData) {
                    $response['message'] = 'Invalid authentication credentials';
                    $response['errors'][] = 'INVALID_TOKEN';
                    http_response_code(401);
                    $this->jsonResponse($response);
                    return;
                }                // Get additional signup data
                $displayName = $_POST['display_name'] ?? $userData['displayName'] ?? '';
                $provider = $_POST['provider'] ?? 'email'; // email or google
                
                // Set custom claims if needed (e.g., user role)
                $customClaims = [
                    'role' => 'user', 
                    'signup_time' => time(),
                    'signup_date' => date('c'),
                    'signup_provider' => $provider
                ];
                FirebaseConfig::setCustomUserClaims($userData['uid'], $customClaims);

                // Store session data
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                $_SESSION['firebase_token'] = $idToken;
                $_SESSION['firebase_user'] = $userData;
                $_SESSION['user_id'] = $userData['uid'];
                $_SESSION['user_email'] = $userData['email'];
                $_SESSION['user_name'] = $userData['displayName'] ?? '';
                $_SESSION['is_authenticated'] = true;
                $_SESSION['auth_time'] = time();
                $_SESSION['signup_timestamp'] = date('c');

                // Set secure cookie
                $cookieOptions = [
                    'expires' => time() + 3600,
                    'path' => '/',
                    'domain' => '',
                    'secure' => ($_ENV['APP_ENV'] === 'production'),
                    'httponly' => true,
                    'samesite' => 'Strict'                ];
                
                setcookie('firebase_token', $idToken, $cookieOptions);

                // Ensure session is written before response
                session_write_close();
                  // Success response
                $response['success'] = true;
                $response['message'] = $provider === 'google' ? 'Account created successfully with Google!' : 'Account created successfully';
                $response['data'] = [
                    'user' => [
                        'uid' => $userData['uid'],
                        'email' => $userData['email'],
                        'displayName' => $userData['displayName'],
                        'emailVerified' => $userData['emailVerified'],
                        'photoURL' => $userData['photoURL'] ?? null,
                        'isNewUser' => true,
                        'signupProvider' => $provider
                    ],
                    'session' => [
                        'expiresAt' => date('c', time() + 3600),
                        'signupTime' => date('c')
                    ],
                    'redirect' => '/',
                    'welcomeMessage' => $provider === 'google' ? 'Welcome to Costobrew! Your Google account has been linked successfully.' : 'Welcome to Costobrew! Your account has been created successfully.'
                ];

                http_response_code(201); // Created
                $this->jsonResponse($response);

            } catch (Exception $e) {
                error_log("Signup error: " . $e->getMessage());
                $response['message'] = 'An error occurred during signup';
                $response['errors'][] = 'INTERNAL_ERROR';
                $response['data'] = $_ENV['APP_ENV'] === 'development' ? ['debug' => $e->getMessage()] : null;
                http_response_code(500);
                $this->jsonResponse($response);
            }
        } else {
            // GET request - show signup form
            $this->showSignup();
        }
    }
    
    /**
     * Handle user logout
     */
    public function logout()
    {
        try {
            // Clear session
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Clear Firebase-related session data
            FirebaseAuthMiddleware::clearUserSession();

            // Destroy entire session for security
            session_destroy();            // Clear any remaining cookies
            setcookie('firebase_token', '', time() - 3600, '/', '', false, true);

            // Always redirect to login with logout=true, regardless of request type
            header('Location: /login?logout=true');
            exit;        } catch (Exception $e) {
            error_log("Logout error: " . $e->getMessage());
            // Always redirect to login on error too
            header('Location: /login?logout=true');
            exit;
        }
    }

    /**
     * Check authentication status (AJAX endpoint)
     */
    public function checkAuth()
    {
        $user = FirebaseAuthMiddleware::getCurrentUser();
        
        if ($user) {
            $this->jsonResponse([
                'authenticated' => true,
                'user' => [
                    'uid' => $user['uid'],
                    'email' => $user['email'],
                    'displayName' => $user['displayName'] ?? '',
                    'emailVerified' => $user['emailVerified']
                ]
            ]);
        } else {
            $this->jsonResponse(['authenticated' => false]);
        }
    }

    /**
     * Get current user info (AJAX endpoint)
     */
    public function userInfo()
    {
        if (!FirebaseAuthMiddleware::isAuthenticated()) {
            http_response_code(401);
            $this->jsonResponse(['error' => 'Not authenticated']);
            return;
        }

        $user = FirebaseAuthMiddleware::getCurrentUser();
        
        $this->jsonResponse([
            'user' => [
                'uid' => $user['uid'],
                'email' => $user['email'],
                'displayName' => $user['displayName'] ?? '',
                'emailVerified' => $user['emailVerified'],
                'photoURL' => $user['photoURL'] ?? '',
                'metadata' => $user['metadata'],
                'customClaims' => $user['customClaims'] ?? [],
                'isAdmin' => FirebaseAuthMiddleware::isAdmin()
            ]
        ]);
    }    /**
     * Send JSON response
     * 
     * @param array $data Response data
     */
    private function jsonResponse(array $data)
    {
        // Clean any output buffer to prevent corrupted JSON
        if (ob_get_level()) {
            ob_clean();
        }
        
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
