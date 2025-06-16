<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Costobrew</title>
    
    <!-- Load fonts first -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/src/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
      <!-- Firebase SDK -->
    <script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-auth-compat.js"></script>
    </head>
<body class="loginbg vh-100 d-flex align-items-center justify-content-center">
    <img src="/src/assets/CBL2.png"  class="fixed-top img-fluid ms-5 mt-5" style="width: 150px; height: auto;">
    <div class="login-container bg-white rounded shadow">
        <div class="row g-0">
            <div class="col-md-6">
                <img src="https://images.pexels.com/photos/312418/pexels-photo-312418.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" 
                     alt="Coffee Image" class="login-image w-100">
            </div>
            <div class="col-md-6 login-form-container p-5">
                <div class="text-start mb-5 mt-5">
                    <h2 class="fw-semibold text-dark">Welcome Back</h2>
                    <p class="text-muted">Sign in to your account</p>
                </div>

                <!-- Auth Messages -->
                <div id="authMessage" class="alert alert-danger alert-dismissible fade" style="display: none;" role="alert">
                    <span id="authMessageText"></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>

                <!-- Login Form -->
                <form id="loginForm" novalidate>
                    <!-- CSRF Token -->
                    <?php
                    // Generate CSRF token
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    if (!isset($_SESSION['csrf_token'])) {
                        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                    }
                    ?>
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                    <!-- Email Field -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-medium">Email</label>
                        <input type="email" class="form-control form-control-md" id="email" name="email" required 
                               placeholder="Enter your email">
                        <div class="invalid-feedback">
                            Please enter a valid email address.
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-medium">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control form-control-md" id="password" name="password" required 
                                   placeholder="Enter your password">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="bi bi-eye" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback">
                            Please enter your password.
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rememberMe">
                            <label class="form-check-label text-muted" for="rememberMe">
                                Remember me
                            </label>
                        </div>
                        <a href="/forgot-password" class="text-decoration-none text-primary">Forgot password?</a>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="btn btnc-brown btn-md w-100 mb-3" id="loginBtn">
                        <span class="spinner-border spinner-border-sm me-2" id="loginSpinner" style="display: none;"></span>
                        <span id="loginBtnText">Sign In</span>
                    </button>
                </form>

                <!-- Divider -->
                <div class="text-center mb-3">
                    <span class="text-muted">or</span>
                </div>

                <!-- Google Sign In Button -->
                <button type="button" class="btn btn-outline-dark btn-md w-100 mb-4" id="googleLoginBtn">
                    <span class="spinner-border spinner-border-sm me-2" id="googleLoginSpinner" style="display: none;"></span>
                    <i class="bi bi-google me-2"></i>
                    <span id="googleLoginBtnText">Continue with Google</span>
                </button>                <!-- Sign Up Link -->
                <div class="text-center">
                    <span class="text-muted">Don't have an account? </span>
                    <a href="/signup<?php echo isset($_GET['return']) ? '?return=' . urlencode($_GET['return']) : ''; ?>" 
                       class="text-decoration-none text-primary fw-medium">Sign up</a>
                </div>
            </div>
        </div>
    </div>







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
    
    // Password toggle functionality
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const togglePasswordIcon = document.getElementById('togglePasswordIcon');
    
    if (togglePassword && passwordInput && togglePasswordIcon) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle icon
            if (type === 'text') {
                togglePasswordIcon.classList.remove('bi-eye');
                togglePasswordIcon.classList.add('bi-eye-slash');
            } else {
                togglePasswordIcon.classList.remove('bi-eye-slash');
                togglePasswordIcon.classList.add('bi-eye');
            }
        });
    }
    
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
    loginSpinner.style.display = 'inline-block';    try {        // Step 1: Firebase Authentication
        console.log('Starting Firebase authentication...');
        const userCredential = await auth.signInWithEmailAndPassword(email, password);
        const user = userCredential.user;
        console.log('Firebase authentication successful:', user.email);
        
        // Step 2: Get ID token
        console.log('Getting ID token...');
        const idToken = await user.getIdToken();
        console.log('ID token obtained, length:', idToken.length);
        
        // Step 3: Get CSRF token
        const csrfTokenElement = document.querySelector('input[name="csrf_token"]');
        if (!csrfTokenElement) {
            throw new Error('CSRF token not found in form');
        }
        const csrfToken = csrfTokenElement.value;
        console.log('CSRF token found');
        
        // Step 4: Prepare request data
        const returnUrl = new URLSearchParams(window.location.search).get('return') || '/';
        console.log('Return URL:', returnUrl);
        const requestData = new URLSearchParams({
            firebase_token: idToken,
            csrf_token: csrfToken,
            return_url: returnUrl
        });        console.log('Sending POST request to /login...');
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
    } finally {        // Reset button state
        loginBtn.disabled = false;
        loginBtnText.textContent = 'Sign In';
        loginSpinner.style.display = 'none';
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
