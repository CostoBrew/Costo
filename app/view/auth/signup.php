<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Costobrew</title>
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
        <div class="col-md-6 col-lg-5">
            <div class="card bg-dark border-secondary">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="bi bi-cup-hot text-primary" style="font-size: 3rem;"></i>
                        <h2 class="mt-2">Join Costobrew</h2>
                        <p class="text-muted">Create your account to start your coffee journey.</p>
                    </div>
                    
                    <!-- Error/Success Messages -->
                    <div id="authMessage" class="alert alert-dismissible fade" role="alert" style="display: none;">
                        <span id="authMessageText"></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                      <form id="signupForm">
                        <?php 
                        require_once __DIR__ . '/../../middleware/CSRFMiddleware.php';
                        echo CSRFMiddleware::field(); 
                        ?>
                        <div class="mb-3">
                            <label for="displayName" class="form-label">
                                <i class="bi bi-person me-2"></i>Full Name
                            </label>
                            <input type="text" class="form-control" id="displayName" name="displayName" required 
                                   placeholder="Enter your full name">
                        </div>
                        
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
                                   placeholder="Enter your password" minlength="6">
                            <div class="form-text">Password must be at least 6 characters long.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">
                                <i class="bi bi-lock-fill me-2"></i>Confirm Password
                            </label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required 
                                   placeholder="Confirm your password">
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" required>
                            <label class="form-check-label" for="terms">
                                I agree to the <a href="/terms" class="text-primary">Terms of Service</a> and 
                                <a href="/privacy" class="text-primary">Privacy Policy</a>
                            </label>
                        </div>
                          <button type="submit" class="btn btn-primary w-100 mb-3" id="signupBtn">
                            <i class="bi bi-person-plus me-2"></i>
                            <span id="signupBtnText">Create Account</span>
                            <span id="signupSpinner" class="spinner-border spinner-border-sm ms-2" style="display: none;"></span>
                        </button>
                    </form>
                    
                    <div class="text-center mb-3">
                        <div class="d-flex align-items-center">
                            <hr class="flex-grow-1">
                            <span class="mx-3 text-muted">or</span>
                            <hr class="flex-grow-1">
                        </div>
                    </div>
                    
                    <button type="button" class="btn btn-outline-light w-100 mb-3" id="googleSignupBtn">
                        <svg class="me-2" width="18" height="18" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span id="googleSignupBtnText">Continue with Google</span>
                        <span id="googleSignupSpinner" class="spinner-border spinner-border-sm ms-2" style="display: none;"></span>
                    </button>
                    
                    <hr class="my-3">
                    
                    <div class="text-center">
                        <p class="mb-2">Already have an account?</p>
                        <a href="/login" class="btn btn-outline-primary">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Sign in here
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
} catch (Exception $e) {
    echo "firebaseConfig = { error: 'Configuration error' };\n";
}
?>

// Initialize Firebase
var auth = null; // Declare in global scope

if (typeof firebaseConfig !== 'undefined' && firebaseConfig.apiKey) {
    firebase.initializeApp(firebaseConfig);
    auth = firebase.auth(); // Assign to global variable
} else {
    console.error('Firebase configuration is missing or incomplete');
    // Show error message to user
    document.addEventListener('DOMContentLoaded', function() {
        showMessage('Firebase configuration error. Please contact administrator.', 'danger');
    });
}

// Signup form handler
document.addEventListener('DOMContentLoaded', function() {
    const signupForm = document.getElementById('signupForm');
    if (!signupForm) {
        console.error('Signup form not found!');
        return;
    }
    
    signupForm.addEventListener('submit', async function(e) {
        e.preventDefault();
          if (typeof auth === 'undefined' || auth === null) {
            showMessage('Authentication service unavailable. Please try again later.', 'danger');
            return;
        }
    
    const displayName = document.getElementById('displayName').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;        const signupBtn = document.getElementById('signupBtn');
        const signupBtnText = document.getElementById('signupBtnText');
        const signupSpinner = document.getElementById('signupSpinner');
        
        // Validate passwords match
        if (password !== confirmPassword) {
            showMessage('Passwords do not match', 'danger');
            return;
        }
        
        // Show loading state        signupBtn.disabled = true;
        signupBtnText.textContent = 'Creating account...';
        signupSpinner.style.display = 'inline-block';
        
        try {
            // Create user with Firebase
            const userCredential = await auth.createUserWithEmailAndPassword(email, password);
            const user = userCredential.user;
            
            // Update profile with display name
            await user.updateProfile({
                displayName: displayName
            });
            
            // Send email verification
            await user.sendEmailVerification();
            
            // Get ID token
            const idToken = await user.getIdToken();
              // Send token to backend to complete registration
            const response = await fetch('/signup', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    firebase_token: idToken,
                    csrf_token: document.querySelector('input[name="csrf_token"]').value,
                    display_name: displayName
                })
            });
            
            const responseText = await response.text();
            
            let result;
            try {
                result = JSON.parse(responseText);
            } catch (parseError) {
                throw new Error('Invalid response from server');
            }        if (result.success) {
            showMessage('Account created successfully! Please check your email for verification.', 'success');
            
            // Wait for Firebase auth state to be properly established
            const authStatePromise = new Promise((resolve) => {
                const unsubscribe = auth.onAuthStateChanged((user) => {
                    if (user) {
                        unsubscribe(); // Stop listening
                        resolve(user);
                    }
                });
                
                // Fallback timeout in case auth state doesn't change
                setTimeout(() => {
                    unsubscribe();
                    resolve(null);
                }, 3000);
            });
            
            // Wait for auth state, then redirect
            authStatePromise.then(() => {
                // Force a page reload to ensure session is recognized
                setTimeout(() => {
                    window.location.href = result.redirect || '/';
                    // Fallback: if redirect doesn't work, force reload
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }, 1000); // Increased delay to ensure backend session is fully established
            });
            
        } else {
            showMessage(result.message || 'Registration failed', 'danger');
        }
          } catch (error) {
        let errorMessage = 'An error occurred during registration';
        
        switch (error.code) {
            case 'auth/email-already-in-use':
                errorMessage = 'An account with this email already exists';
                break;
            case 'auth/invalid-email':
                errorMessage = 'Invalid email address';
                break;
            case 'auth/weak-password':
                errorMessage = 'Password is too weak. Please use at least 6 characters';
                break;
            case 'auth/operation-not-allowed':
                errorMessage = 'Email/password accounts are not enabled';
                break;
            default:
                errorMessage = error.message;
        }
        
        showMessage(errorMessage, 'danger');    } finally {
        // Reset button state
        signupBtn.disabled = false;
        signupBtnText.textContent = 'Create Account';
        signupSpinner.style.display = 'none';
    }    });
});

// Google Sign-In handler
document.getElementById('googleSignupBtn').addEventListener('click', async function() {
    if (typeof auth === 'undefined' || auth === null) {
        showMessage('Authentication service unavailable. Please try again later.', 'danger');
        return;
    }
    
    const googleBtn = document.getElementById('googleSignupBtn');
    const googleBtnText = document.getElementById('googleSignupBtnText');
    const googleSpinner = document.getElementById('googleSignupSpinner');
    
    // Show loading state
    googleBtn.disabled = true;
    googleBtnText.textContent = 'Signing up with Google...';
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
        
        // Send token to backend
        const response = await fetch('/signup', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                firebase_token: idToken,
                csrf_token: document.querySelector('input[name="csrf_token"]').value,
                display_name: user.displayName || user.email.split('@')[0],
                provider: 'google'
            })
        });
        
        const responseText = await response.text();
        
        let responseResult;
        try {
            responseResult = JSON.parse(responseText);
        } catch (parseError) {
            throw new Error('Invalid response from server');
        }
        
        if (responseResult.success) {
            showMessage('Account created successfully with Google!', 'success');
            
            // Wait for Firebase auth state to be properly established
            const authStatePromise = new Promise((resolve) => {
                const unsubscribe = auth.onAuthStateChanged((user) => {
                    if (user) {
                        unsubscribe();
                        resolve(user);
                    }
                });
                
                setTimeout(() => {
                    unsubscribe();
                    resolve(null);
                }, 3000);
            });
            
            // Wait for auth state, then redirect
            authStatePromise.then(() => {
                setTimeout(() => {
                    window.location.href = responseResult.redirect || '/';
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }, 1000);
            });
            
        } else {
            showMessage(responseResult.message || 'Google signup failed', 'danger');
        }
        
    } catch (error) {
        let errorMessage = 'An error occurred during Google signup';
        
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
        }, 5000);
    }
}

// Password matching validation
document.getElementById('confirmPassword').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmPassword = this.value;
    
    if (confirmPassword && password !== confirmPassword) {
        this.setCustomValidity('Passwords do not match');
    } else {
        this.setCustomValidity('');
    }
});

// Check if user is already logged in (only if auth is available)
document.addEventListener('DOMContentLoaded', function() {
    if (typeof auth !== 'undefined' && auth) {
        auth.onAuthStateChanged(function(user) {
            if (user) {
                // User is signed in, redirect to home
                window.location.href = '/';
            }
        });
    }
});
</script>
</body>
</html>
