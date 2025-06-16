<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Costobrew</title>
    
    <!-- Load fonts first -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@160..700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/src/css/style.css" rel="stylesheet">
    
    <!-- Firebase SDK -->
    <script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-auth-compat.js"></script>
</head>
<body data-bs-theme="dark" class="d-flex flex-column min-vh-100">
<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="container my-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card bg-dark border-secondary">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="bi bi-cup-hot text-primary" style="font-size: 3rem;"></i>
                        <h2 class="mt-2">Login to Costobrew</h2>
                        <p class="text-muted">Welcome back! Please sign in to your account.</p>
                    </div>

                    <!-- Error/Success Messages -->
                    <div id="authMessage" class="alert alert-dismissible fade" role="alert" style="display: none;">
                        <span id="authMessageText"></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>

                    <form id="loginForm">
                        <?php 
                        require_once __DIR__ . '/../../middleware/CSRFMiddleware.php';
                        echo CSRFMiddleware::field(); 
                        ?>
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope me-2"></i>Email Address
                            </label>
                            <input type="email" class="form-control" id="email" name="email" required 
                                   placeholder="Enter your email">
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="bi bi-lock me-2"></i>Password
                            </label>
                            <input type="password" class="form-control" id="password" name="password" required 
                                   placeholder="Enter your password">
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>
                          <button type="submit" class="btn btn-primary w-100 mb-3" id="loginBtn">
                            <i class="bi bi-box-arrow-in-right me-2"></i>
                            <span id="loginBtnText">Login</span>
                            <span id="loginSpinner" class="spinner-border spinner-border-sm ms-2" style="display: none;"></span>
                        </button>
                    </form>
                    
                    <div class="text-center mb-3">
                        <div class="d-flex align-items-center">
                            <hr class="flex-grow-1">
                            <span class="mx-3 text-muted">or</span>
                            <hr class="flex-grow-1">
                        </div>
                    </div>
                    
                    <button type="button" class="btn btn-outline-light w-100 mb-3" id="googleLoginBtn">
                        <svg class="me-2" width="18" height="18" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span id="googleLoginBtnText">Continue with Google</span>
                        <span id="googleLoginSpinner" class="spinner-border spinner-border-sm ms-2" style="display: none;"></span>
                    </button>
                    
                    <hr class="my-3">
                      <div class="text-center">
                        <p class="mb-2">Don't have an account?</p>
                        <a href="/signup" class="btn btn-outline-primary">
                            <i class="bi bi-person-plus me-2"></i>Sign up here
                        </a>
                    </div>
                    
                    <div class="text-center mt-3">
                        <a href="/forgot-password" class="text-decoration-none small">
                            Forgot your password?
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Firebase configuration
var firebaseConfig = null;
var auth = null;

// Load Firebase configuration from PHP
<?php
try {
    require_once __DIR__ . '/../../config/database.php';
    DatabaseConfig::loadEnvironment();
    
    echo "firebaseConfig = {\n";
    echo "  apiKey: '" . addslashes($_ENV['FIREBASE_API_KEY'] ?? '') . "',\n";
    echo "  authDomain: '" . addslashes($_ENV['FIREBASE_AUTH_DOMAIN'] ?? '') . "',\n";
    echo "  projectId: '" . addslashes($_ENV['FIREBASE_PROJECT_ID'] ?? '') . "',\n";
    echo "  storageBucket: '" . addslashes($_ENV['FIREBASE_STORAGE_BUCKET'] ?? '') . "',\n";
    echo "  messagingSenderId: '" . addslashes($_ENV['FIREBASE_MESSAGING_SENDER_ID'] ?? '') . "',\n";
    echo "  appId: '" . addslashes($_ENV['FIREBASE_APP_ID'] ?? '') . "'\n";
    echo "};\n";
} catch (Exception $e) {}
?>

// Initialize Firebase
function initializeFirebase() {
    if (!firebaseConfig || !firebaseConfig.apiKey) {
        showMessage('Firebase configuration error. Please contact administrator.', 'danger');
        return false;
    }
    
    try {
        firebase.initializeApp(firebaseConfig);
        auth = firebase.auth();
        return true;
    } catch (error) {
        console.error('Firebase initialization error:', error);
        showMessage('Authentication service unavailable. Please try again later.', 'danger');
        return false;
    }
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    const firebaseInitialized = initializeFirebase();
    
    if (firebaseInitialized && auth) {
        // Set up auth state listener
        auth.onAuthStateChanged(function(user) {
            if (user) {
                // Check if this is a fresh login page visit vs coming from logout
                const urlParams = new URLSearchParams(window.location.search);
                const fromLogout = urlParams.get('logout') === 'true';
                const forceLogin = urlParams.get('force_login') === 'true';
                const currentReturnUrl = urlParams.get('return');
                
                // Don't redirect back to logout page - this prevents loops
                if (currentReturnUrl === '/logout' || currentReturnUrl === '%2Flogout') {
                    const newUrl = new URL(window.location);
                    newUrl.searchParams.delete('return');
                    if (!fromLogout && !forceLogin) {
                        window.history.replaceState({}, '', newUrl);
                    }
                }
                
                if (fromLogout || forceLogin) {
                    // User came from logout or forced login, sign them out of Firebase
                    auth.signOut().catch((error) => {
                        console.error('Firebase signout error:', error);
                    });
                    return;
                }
                
                // Normal case - user is authenticated and should be redirected
                const redirectUrl = urlParams.get('return') || '/';
                setTimeout(() => {
                    window.location.href = redirectUrl;
                }, 1000);
            }
        });
    }
});

// Login form handler
document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    if (!auth) {
        showMessage('Authentication service unavailable. Please try again later.', 'danger');
        return;
    }
    
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const loginBtn = document.getElementById('loginBtn');
    const loginBtnText = document.getElementById('loginBtnText');
    const loginSpinner = document.getElementById('loginSpinner');
    
    // Show loading state
    loginBtn.disabled = true;
    loginBtnText.textContent = 'Signing in...';
    loginSpinner.style.display = 'inline-block';    try {
        // Step 1: Firebase Authentication
        const userCredential = await auth.signInWithEmailAndPassword(email, password);
        const user = userCredential.user;
        
        // Step 2: Get ID token
        const idToken = await user.getIdToken();
        
        // Step 3: Get CSRF token
        const csrfTokenElement = document.querySelector('input[name="csrf_token"]');
        if (!csrfTokenElement) {
            throw new Error('CSRF token not found in form');
        }
        const csrfToken = csrfTokenElement.value;
        
        // Step 4: Prepare request data
        const returnUrl = new URLSearchParams(window.location.search).get('return') || '/';
        const requestData = new URLSearchParams({
            firebase_token: idToken,
            csrf_token: csrfToken,
            return_url: returnUrl
        });
          // Step 5: Send to backend
        const response = await fetch('/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: requestData,
            credentials: 'same-origin'
        });
          // Step 6: Process response
        const responseText = await response.text();
        let result;
          try {
            result = JSON.parse(responseText);
        } catch (parseError) {
            console.error('Failed to parse JSON response. Response text:', responseText);
            
            // If Firebase auth succeeded but backend failed, user is still logged in
            if (user) {
                showMessage('Login succeeded but there was a communication error. Redirecting...', 'warning');
                setTimeout(() => {
                    window.location.href = returnUrl;
                }, 2000);
                return;
            }
            throw new Error('Invalid response from server');
        }
        
        if (result.success) {
            const redirectUrl = result.data?.redirect || returnUrl;
            showMessage('Login successful! Redirecting...', 'success');
            
            setTimeout(() => {
                window.location.href = redirectUrl;
            }, 1000);
        } else {
            showMessage(result.message || 'Login failed', 'danger');
        }
      } catch (error) {
        console.error('Login error details:', error);
        console.error('Error code:', error.code);
        console.error('Error message:', error.message);
        let errorMessage = 'An error occurred during login';
        
        // Handle different types of errors
        if (error.name === 'TypeError' && (error.message.includes('NetworkError') || error.message.includes('Failed to fetch'))) {
            // Network error - Firebase login likely succeeded but backend communication failed
            console.log('Network error detected, checking if user is authenticated...');
            
            // Check if we have a Firebase user (meaning Firebase auth succeeded)
            if (auth && auth.currentUser) {
                errorMessage = 'Login succeeded! There was a network issue but you are now logged in. Redirecting...';
                showMessage(errorMessage, 'success');
                
                // Redirect to home or return URL since user is authenticated
                setTimeout(() => {
                    const returnUrl = new URLSearchParams(window.location.search).get('return') || '/';
                    window.location.href = returnUrl;
                }, 2000);
                return;
            } else {
                errorMessage = 'Network error occurred. Please check your connection and try again.';
                showMessage(errorMessage, 'danger');
            }
            
        } else if (error.code && error.code.startsWith('auth/')) {
            // Firebase authentication errors
            switch (error.code) {
                case 'auth/user-not-found':
                    errorMessage = 'No account found with this email address';
                    break;
                case 'auth/wrong-password':
                    errorMessage = 'Incorrect password';
                    break;
                case 'auth/invalid-email':
                    errorMessage = 'Invalid email address';
                    break;
                case 'auth/user-disabled':
                    errorMessage = 'This account has been disabled';
                    break;
                case 'auth/too-many-requests':
                    errorMessage = 'Too many failed attempts. Please try again later';
                    break;
                case 'auth/invalid-login-credentials':
                    errorMessage = 'Invalid email or password. Please check your credentials and try again.';
                    break;
                default:
                    errorMessage = error.message;
            }
            showMessage(errorMessage, 'danger');
        } else {
            showMessage(errorMessage, 'danger');
        }
    } finally {
        // Reset button state
        loginBtn.disabled = false;
        loginBtnText.textContent = 'Login';        loginSpinner.style.display = 'none';
    }
});

// Google Sign-In handler
document.getElementById('googleLoginBtn').addEventListener('click', async function() {
    if (typeof auth === 'undefined' || auth === null) {
        showMessage('Authentication service unavailable. Please try again later.', 'danger');
        return;
    }
    
    const googleBtn = document.getElementById('googleLoginBtn');
    const googleBtnText = document.getElementById('googleLoginBtnText');
    const googleSpinner = document.getElementById('googleLoginSpinner');
    
    // Show loading state
    googleBtn.disabled = true;
    googleBtnText.textContent = 'Signing in with Google...';
    googleSpinner.style.display = 'inline-block';
    
    try {
        // Create Google provider
        const provider = new firebase.auth.GoogleAuthProvider();
        provider.addScope('email');
        provider.addScope('profile');
        
        // Sign in with popup
        const result = await auth.signInWithPopup(provider);
        const user = result.user;
        
        // Get ID token
        const idToken = await user.getIdToken();
        
        // Get CSRF token
        const csrfTokenElement = document.querySelector('input[name="csrf_token"]');
        if (!csrfTokenElement) {
            throw new Error('CSRF token not found in form');
        }
        const csrfToken = csrfTokenElement.value;
        
        // Prepare request data
        const returnUrl = new URLSearchParams(window.location.search).get('return') || '/';
        const requestData = new URLSearchParams({
            firebase_token: idToken,
            csrf_token: csrfToken,
            return_url: returnUrl,
            provider: 'google'
        });
        
        // Send to backend
        const response = await fetch('/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: requestData,
            credentials: 'same-origin'
        });
        
        const responseText = await response.text();
        let responseResult;
        
        try {
            responseResult = JSON.parse(responseText);
        } catch (parseError) {
            if (user) {
                showMessage('Google login succeeded but there was a communication error. Redirecting...', 'warning');
                setTimeout(() => {
                    window.location.href = returnUrl;
                }, 2000);
                return;
            }
            throw new Error('Invalid response from server');
        }
        
        if (responseResult.success) {
            const redirectUrl = responseResult.data?.redirect || returnUrl;
            showMessage('Google login successful! Redirecting...', 'success');
            
            setTimeout(() => {
                window.location.href = redirectUrl;
            }, 1000);
        } else {
            showMessage(responseResult.message || 'Google login failed', 'danger');
        }
        
    } catch (error) {
        let errorMessage = 'An error occurred during Google login';
        
        // Handle different types of errors
        if (error.name === 'TypeError' && (error.message.includes('NetworkError') || error.message.includes('Failed to fetch'))) {
            // Network error - check if user is authenticated
            if (auth && auth.currentUser) {
                errorMessage = 'Google login succeeded! There was a network issue but you are now logged in. Redirecting...';
                showMessage(errorMessage, 'success');
                setTimeout(() => {
                    const returnUrl = new URLSearchParams(window.location.search).get('return') || '/';
                    window.location.href = returnUrl;
                }, 2000);
                return;
            } else {
                errorMessage = 'Network error occurred. Please check your connection and try again.';
            }
        } else if (error.code) {
            switch (error.code) {
                case 'auth/popup-closed-by-user':
                    errorMessage = 'Google sign-in was cancelled';
                    break;
                case 'auth/popup-blocked':
                    errorMessage = 'Popup was blocked. Please allow popups and try again';
                    break;
                case 'auth/account-exists-with-different-credential':
                    errorMessage = 'An account already exists with this email using a different sign-in method';
                    break;
                case 'auth/cancelled-popup-request':
                    errorMessage = 'Sign-in was cancelled';
                    break;
                default:
                    errorMessage = error.message || errorMessage;
            }
        }
        
        showMessage(errorMessage, 'danger');
    } finally {
        // Reset button state
        googleBtn.disabled = false;
        googleBtnText.textContent = 'Continue with Google';
        googleSpinner.style.display = 'none';
    }
});

// Show message function
function showMessage(message, type) {
    const messageDiv = document.getElementById('authMessage');
    const messageText = document.getElementById('authMessageText');
    
    messageDiv.className = `alert alert-${type} alert-dismissible fade show`;
    messageText.textContent = message;
    messageDiv.style.display = 'block';
    
    // Auto-hide success messages
    if (type === 'success') {
        setTimeout(() => {
            messageDiv.style.display = 'none';
        }, 3000);
    }
}
</script>
</body>
</html>
