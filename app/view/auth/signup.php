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

    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
            font-family: 'Readex Pro', sans-serif;
        }

        .auth-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: url('/src/assets/bglogin.png') center/cover no-repeat;
            background-attachment: fixed;
            padding: 2rem;
            position: relative;
        }

        .auth-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1;
        }

        .signup-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            display: flex;
            position: relative;
            z-index: 2;
            animation: cardFadeIn 0.8s ease-out;
        }

        @keyframes cardFadeIn {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .card-image-section {
            flex: 1;
            background: url('/src/assets/depositphotos_322567336-stock-photo-hot-coffee-cappuccino-latte-art 1.png') center/cover no-repeat;
            display: flex;
            align-items: flex-end;
            justify-content: flex-start;
            padding: 0;
            position: relative;
            min-height: 500px;
            border-radius: 24px 0 0 24px;
            overflow: hidden;
        }

        .card-image-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.6) 0%, rgba(0, 0, 0, 0.3) 50%, rgba(0, 0, 0, 0.1) 100%);
            z-index: 1;
        }

        @keyframes photoFloat {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .image-content {
            position: relative;
            z-index: 2;
            color: white;
            padding: 2rem;
            max-width: 300px;
        }

        .image-content h2 {
            font-size: 1.8rem;
            font-weight: 400;
            margin-bottom: 0.5rem;
            line-height: 1.3;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.7);
            animation: slideInLeft 0.8s ease-out 0.5s both;
        }

        .image-content p {
            font-size: 1rem;
            opacity: 0.95;
            line-height: 1.5;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.7);
            animation: slideInLeft 0.8s ease-out 0.7s both;
            margin: 0;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 0.95;
                transform: translateX(0);
            }
        }

        .card-form-section {
            flex: 1;
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .auth-form {
            width: 100%;
        }

        .brand-header {
            position: absolute;
            top: 30px;
            left: 50px;
            color: white;
            font-size: 1.5rem;
            font-weight: 500;
            z-index: 3;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .help-icon {
            position: absolute;
            top: 2rem;
            right: 2rem;
            color: #666;
            font-size: 1.5rem;
            cursor: pointer;
            z-index: 3;
            transition: color 0.3s ease;
        }

        .help-icon:hover {
            color: #333;
        }

        .form-title {
            color: #333;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-subtitle {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        .form-subtitle a {
            color: #007bff;
            text-decoration: none;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            color: #333;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
        }

        .form-control::placeholder {
            color: #999;
        }

        .password-requirements {
            font-size: 0.8rem;
            color: #666;
            margin-top: 0.5rem;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background: #333;
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .submit-btn:hover {
            background: #555;
        }

        .submit-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .divider {
            text-align: center;
            margin: 1.5rem 0;
            color: #666;
            font-size: 0.9rem;
        }

        .social-buttons {
            display: flex;
            justify-content: center;
        }

        .social-btn {
            padding: 10px 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            color: #333;
        }

        .social-btn:hover {
            background: #f8f9fa;
            border-color: #ccc;
        }

        .google-btn {
            background: #4285f4;
            color: white;
            border-color: #4285f4;
            width: 100%;
        }

        .google-btn:hover {
            background: #3367d6;
        }



        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        @media (max-width: 768px) {
            .auth-container {
                padding: 1rem;
            }

            .signup-card {
                flex-direction: column;
                max-width: none;
                border-radius: 20px;
            }

            .card-image-section {
                min-height: 300px;
                border-radius: 20px 20px 0 0;
            }

            .image-content {
                padding: 1.5rem;
                max-width: none;
            }

            .image-content {
                position: static;
                margin-top: 1rem;
            }

            .image-content h2 {
                font-size: 1.8rem;
            }

            .image-content p {
                font-size: 0.9rem;
            }

            .card-form-section {
                padding: 2rem 1.5rem;
            }

            .brand-header {
                left: 20px;
                font-size: 1.3rem;
            }

            .help-icon {
                right: 20px;
                font-size: 1.3rem;
            }

            .form-title {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
<div class="auth-container">
    <!-- Brand Header -->
    <div class="brand-header">CostoBrew</div>

    <!-- Card-based Signup Layout -->
    <div class="signup-card">
        <!-- Left Side - Coffee Image -->
        <div class="card-image-section">
            <div class="image-content">
                <h2>Every cup tells a story.</h2>
                <p>Share yours with the community.</p>
            </div>
        </div>

        <!-- Right Side - Signup Form -->
        <div class="card-form-section">
            <!-- Help Icon -->
            <div class="help-icon">
                <i class="bi bi-question-circle"></i>
            </div>

            <div class="auth-form">
            <h2 class="form-title">Sign Up</h2>
            <p class="form-subtitle">Do you have an existing account? <a href="/login">Login</a></p>

            <!-- Error/Success Messages -->
            <div id="authMessage" class="alert" style="display: none;">
                <span id="authMessageText"></span>
            </div>
            <form id="signupForm">
                <?php
                require_once __DIR__ . '/../../middleware/CSRFMiddleware.php';
                echo CSRFMiddleware::field();
                ?>

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required
                           placeholder="Enter your email address">
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required
                           placeholder="Enter your password" minlength="6">
                    <div class="password-requirements">Password must be at least 6 characters long.</div>
                </div>

                <button type="submit" class="submit-btn" id="signupBtn">
                    <span id="signupBtnText">→</span>
                    <span id="signupSpinner" style="display: none;">...</span>
                </button>
            </form>

            <div class="divider">Sign up with</div>

            <div class="social-buttons">
                <button type="button" class="social-btn google-btn" id="googleSignupBtn">
                    <svg width="18" height="18" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    <span id="googleSignupBtnText">Continue with Google</span>
                    <span id="googleSignupSpinner" style="display: none;">...</span>
                </button>


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

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const signupBtn = document.getElementById('signupBtn');
        const signupBtnText = document.getElementById('signupBtnText');
        const signupSpinner = document.getElementById('signupSpinner');

        // Show loading state
        signupBtn.disabled = true;
        signupBtnText.textContent = '...';
        signupSpinner.style.display = 'inline-block';

        try {
            // Create user with Firebase
            const userCredential = await auth.createUserWithEmailAndPassword(email, password);
            const user = userCredential.user;

            // Update profile with display name (use email prefix as default)
            const displayName = email.split('@')[0];
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
        
        showMessage(errorMessage, 'danger');
        } finally {
            // Reset button state
            signupBtn.disabled = false;
            signupBtnText.textContent = '→';
            signupSpinner.style.display = 'none';
        }
    });
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
    googleBtnText.textContent = '...';
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

// Password validation
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;

    if (password && password.length < 6) {
        this.setCustomValidity('Password must be at least 6 characters long');
    } else {
        this.setCustomValidity('');
    }
});

// Check if user is already logged in (only if auth is available)
//document.addEventListener('DOMContentLoaded', function() {
   // if (typeof auth !== 'undefined' && auth) {
        //auth.onAuthStateChanged(function(user) {
          //  if (user) {
                // User is signed in, redirect to home
             //   window.location.href = '/';
          //  }
        //});
    //}
//});
</script>
</body>
</html>
