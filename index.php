<?php

/**
 * Costobrew Framework - Secure Entry Point
 * Main router with security features and Firebase middleware
 */

// Error reporting based on environment
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Load environment configuration
require_once 'app/config/database.php';
require_once 'app/config/firebase.php';

// Initialize environment variables by triggering database config load
try {
    DatabaseConfig::getConnection();
} catch (Exception $e) {
    // Database might not be set up yet, but environment should be loaded
    error_log('Database connection failed during startup: ' . $e->getMessage());
}

// Start session early to avoid header issues
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Security headers and session setup
require_once 'app/core/Router.php';
require_once 'app/middleware/SecurityMiddleware.php';
require_once 'app/middleware/CSRFMiddleware.php';
require_once 'app/middleware/RateLimitMiddleware.php';
require_once 'app/middleware/AuthMiddleware.php';
require_once 'app/middleware/AdminMiddleware.php';
require_once 'app/middleware/FirebaseAuthMiddleware.php';

// Load controllers
require_once 'app/controller/AuthController.php';
require_once 'app/controller/SettingsController.php';
require_once 'app/controller/CoffeeStudioController.php';
require_once 'app/controller/CartController.php';
require_once 'app/controller/CheckoutController.php';
require_once 'app/controller/OrderController.php';
require_once 'app/controller/AdminController.php';
require_once 'app/controller/ApiController.php';

// Initialize router
$router = new Router();

// Apply global security middleware
$router->middleware([
    'SecurityMiddleware',
    RateLimitMiddleware::create(100, 1), // 100 requests per minute
]);

// ===================================
// AUTHENTICATION HANDLING
// ===================================

// Note: Firebase authentication is handled by FirebaseAuthMiddleware when needed
// Regular session-based authentication is handled by AuthMiddleware

// ===================================
// PUBLIC ROUTES (No Authentication)
// ===================================

// Home page (contains home, about, contact)
$router->get('/', function() {
    require_once 'app/view/home.php';
});

$router->get('/home', function() {
    require_once 'app/view/home.php';
});

// Menu page
$router->get('/menu', function() {
    require_once 'app/view/menu.php';
});

// Authentication routes
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login', ['CSRFMiddleware']);

$router->get('/signup', 'AuthController@showSignup');
$router->get('/register', 'AuthController@showSignup'); // Alias for signup
$router->post('/signup', 'AuthController@signup', ['CSRFMiddleware']);
$router->post('/register', 'AuthController@signup', ['CSRFMiddleware']); // Alias for signup

$router->post('/logout', 'AuthController@logout');
$router->get('/logout', 'AuthController@logout'); // Allow GET for header links

// Authentication API routes
$router->get('/api/auth/check', 'AuthController@checkAuth');
$router->get('/api/auth/user', 'AuthController@userInfo');

// ===================================
// PROTECTED ROUTES (Authentication Required)
// ===================================

// Settings (Multi-page)
$router->get('/settings', 'SettingsController@index', ['AuthMiddleware']);
$router->get('/settings/account', 'SettingsController@account', ['AuthMiddleware']);
$router->get('/settings/security', 'SettingsController@security', ['AuthMiddleware']);
$router->get('/settings/notifications', 'SettingsController@notifications', ['AuthMiddleware']);
$router->get('/settings/cookies', 'SettingsController@cookiePolicy', ['AuthMiddleware']);

$router->post('/settings/account', 'SettingsController@updateAccount', ['AuthMiddleware', 'CSRFMiddleware']);
$router->post('/settings/security', 'SettingsController@updateSecurity', ['AuthMiddleware', 'CSRFMiddleware']);
$router->post('/settings/notifications', 'SettingsController@updateNotifications', ['AuthMiddleware', 'CSRFMiddleware']);

// Coffee Studio
$router->get('/studio', 'CoffeeStudioController@index', ['AuthMiddleware']);

// DIY Coffee (Single Page Dynamic)
$router->get('/studio/diy', 'CoffeeStudioController@diyStart', ['AuthMiddleware']);

// Premade Coffee (Unified Single Page)
$router->get('/studio/premade', 'CoffeeStudioController@premadeStart', ['AuthMiddleware']);

// Studio API endpoints for updating selections
$router->post('/studio/update-selection', 'CoffeeStudioController@updateSelection', ['AuthMiddleware', 'CSRFMiddleware']);
$router->post('/studio/add-to-cart', 'CoffeeStudioController@addToCart', ['AuthMiddleware', 'CSRFMiddleware']);
$router->post('/studio/direct-checkout', 'CoffeeStudioController@directCheckout', ['AuthMiddleware']);

// Shopping Cart
$router->get('/cart', 'CartController@index', ['AuthMiddleware']);
$router->post('/cart/add', 'CartController@add', ['AuthMiddleware', 'CSRFMiddleware']);
$router->post('/cart/remove', 'CartController@remove', ['AuthMiddleware', 'CSRFMiddleware']);
$router->post('/cart/update', 'CartController@update', ['AuthMiddleware', 'CSRFMiddleware']);
$router->post('/cart/clear', 'CartController@clear', ['AuthMiddleware', 'CSRFMiddleware']);

// Checkout / Counter + Order Process
$router->get('/checkout', 'CheckoutController@index', ['AuthMiddleware']);
$router->post('/checkout/process', 'CheckoutController@process', ['AuthMiddleware', 'CSRFMiddleware']);
$router->get('/checkout/receipt/{order_id}', 'CheckoutController@receipt', ['AuthMiddleware']);

// Order Management
$router->get('/orders', 'OrderController@index', ['AuthMiddleware']);
$router->get('/orders/{id}', 'OrderController@show', ['AuthMiddleware']);

// ===================================
// API ROUTES (Rate Limited)
// ===================================

// API endpoints with stricter rate limiting
$router->get('/api/coffees', 'ApiController@coffees', [
    RateLimitMiddleware::create(30, 1) // 30 requests per minute
]);

$router->get('/api/orders/{id}', 'ApiController@getOrder', [
    'AuthMiddleware',
    RateLimitMiddleware::create(30, 1)
]);

$router->post('/api/orders', 'ApiController@createOrder', [
    'AuthMiddleware',
    'CSRFMiddleware',
    RateLimitMiddleware::create(10, 1) // 10 orders per minute
]);

// ===================================
// ADMIN ROUTES (Admin Authentication)
// ===================================

$router->get('/admin', 'AdminController@dashboard', ['AdminMiddleware']);
$router->get('/admin/coffees', 'AdminController@manageCoffees', ['AdminMiddleware']);
$router->get('/admin/menu', 'AdminController@manageCoffees', ['AdminMiddleware']);
$router->get('/admin/orders', 'AdminController@manageOrders', ['AdminMiddleware']);
$router->get('/admin/customers', 'AdminController@manageCustomers', ['AdminMiddleware']);

// Admin CRUD operations
$router->post('/admin/coffees', 'AdminController@createCoffee', ['AdminMiddleware', 'CSRFMiddleware']);
$router->put('/admin/coffees/{id}', 'AdminController@updateCoffee', ['AdminMiddleware', 'CSRFMiddleware']);
$router->delete('/admin/coffees/{id}', 'AdminController@deleteCoffee', ['AdminMiddleware', 'CSRFMiddleware']);
$router->delete('/admin/coffees/{id}/delete', 'AdminController@deleteCoffee', ['AdminMiddleware']);

// Admin menu component CRUD operations
$router->post('/admin/menu/{category}', 'AdminController@createMenuItem', ['AdminMiddleware']);
$router->put('/admin/menu/{category}/{id}', 'AdminController@updateMenuItem', ['AdminMiddleware']);
$router->delete('/admin/menu/{category}/{id}/delete', 'AdminController@deleteMenuItem', ['AdminMiddleware']);
$router->get('/admin/menu/{category}/{id}/edit', 'AdminController@getMenuItem', ['AdminMiddleware']);

// Admin order operations
$router->delete('/admin/orders/{id}/delete', 'AdminController@deleteOrder', ['AdminMiddleware']);
$router->put('/admin/orders/{id}/status', 'AdminController@updateOrderStatus', ['AdminMiddleware', 'CSRFMiddleware']);
$router->get('/admin/orders/{id}/details', 'AdminController@getOrderDetails', ['AdminMiddleware']);
$router->put('/admin/orders/{id}/update', 'AdminController@updateOrder', ['AdminMiddleware']);

// ===================================
// ERROR HANDLING ROUTES
// ===================================

// Custom error pages
$router->get('/error/404', function() {
    http_response_code(404);
    require_once 'app/view/errors/404.php';
});

$router->get('/error/500', function() {
    http_response_code(500);
    require_once 'app/view/errors/500.php';
});

// ===================================
// SECURITY FEATURES
// ===================================

// Set error handler
set_exception_handler(function($exception) {
    error_log('Uncaught exception: ' . $exception->getMessage());
    
    if ($_ENV['APP_ENV'] === 'development') {
        echo '<h1>Error</h1>';
        echo '<p>' . htmlspecialchars($exception->getMessage()) . '</p>';
        echo '<pre>' . htmlspecialchars($exception->getTraceAsString()) . '</pre>';
    } else {
        http_response_code(500);
        if (file_exists('app/view/errors/500.php')) {
            require_once 'app/view/errors/500.php';
        } else {
            echo 'Internal Server Error';
        }
    }
});

// Set error handler for PHP errors
set_error_handler(function($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        return false;
    }
    
    error_log("PHP Error: {$message} in {$file} on line {$line}");
    
    // Don't output errors during redirects or AJAX requests
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    $isRedirect = headers_sent() || ob_get_level() > 0;
    
    if ($_ENV['APP_ENV'] === 'development' && !$isAjax && !$isRedirect) {
        echo "<b>Error:</b> {$message} in <b>{$file}</b> on line <b>{$line}</b><br>";
    }
    
    return true;
});

// ===================================
// SECURITY HELPERS
// ===================================

/**
 * Get CSRF token for forms
 */
function csrf_token() {
    return CSRFMiddleware::getToken();
}

/**
 * Generate CSRF field for forms
 */
function csrf_field() {
    return CSRFMiddleware::field();
}

/**
 * Sanitize output
 */
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Check if user is authenticated
 */
function auth() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return isset($_SESSION['user_id']);
}

/**
 * Get authenticated user
 */
function user() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return $_SESSION['user'] ?? null;
}

/**
 * Generate URL
 */
function url($path) {
    $baseUrl = $_ENV['APP_URL'] ?? 'http://localhost:8000';
    // Remove trailing slash from base URL and ensure path starts with /
    $baseUrl = rtrim($baseUrl, '/');
    if (!str_starts_with($path, '/')) {
        $path = '/' . $path;
    }
    return $baseUrl . $path;
}

/**
 * Redirect to URL
 */
function redirect($url) {
    header("Location: {$url}");
    exit();
}

// ===================================
// RESOLVE ROUTES
// ===================================

try {
    $router->resolve();
} catch (Exception $e) {
    error_log('Router exception: ' . $e->getMessage());
    
    if ($_ENV['APP_ENV'] === 'development') {
        echo '<h1>Router Error</h1>';
        echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
    } else {
        http_response_code(500);
        if (file_exists('app/view/errors/500.php')) {
            require_once 'app/view/errors/500.php';
        } else {
            echo 'Internal Server Error';
        }
    }
}

// ===================================
// DEBUG ROUTES (Development only)
// ===================================

if (($_ENV['APP_ENV'] ?? 'development') === 'development') {
    // Route for debugging - list all routes
    $router->get('/debug/routes', function() {
        echo '<h1>Router Debug Information</h1>';
        echo '<style>body{font-family:Arial,sans-serif;margin:20px;} .info{background:#f0f0f0;padding:10px;margin:10px 0;border-radius:5px;}</style>';
        
        echo '<div class="info">';
        echo '<h2>Current Request</h2>';
        echo '<p><strong>URI:</strong> ' . $_SERVER['REQUEST_URI'] . '</p>';
        echo '<p><strong>Method:</strong> ' . $_SERVER['REQUEST_METHOD'] . '</p>';
        echo '<p><strong>Parsed Path:</strong> ' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '</p>';
        echo '<p><strong>Document Root:</strong> ' . $_SERVER['DOCUMENT_ROOT'] . '</p>';
        echo '<p><strong>Script Name:</strong> ' . $_SERVER['SCRIPT_NAME'] . '</p>';
        echo '</div>';
        
        echo '<div class="info">';
        echo '<h2>Environment</h2>';
        echo '<p><strong>APP_URL:</strong> ' . ($_ENV['APP_URL'] ?? 'not set') . '</p>';
        echo '<p><strong>APP_ENV:</strong> ' . ($_ENV['APP_ENV'] ?? 'not set') . '</p>';
        echo '</div>';
        
        echo '<div class="info">';
        echo '<h2>Session Information</h2>';
        echo '<p><strong>Session Status:</strong> ' . (session_status() === PHP_SESSION_ACTIVE ? 'Active' : 'Inactive') . '</p>';
        if (isset($_SESSION['user_id'])) {
            echo '<p><strong>User ID:</strong> ' . $_SESSION['user_id'] . '</p>';
        } else {
            echo '<p><strong>User:</strong> Not logged in</p>';
        }
        echo '</div>';
    });
    
    // Simple test route
    $router->get('/debug/test', function() {
        echo '<h1>Router Test</h1>';
        echo '<p>✅ Router is working correctly!</p>';
        echo '<p>Current URL: ' . $_SERVER['REQUEST_URI'] . '</p>';
        echo '<p>Base URL from env: ' . ($_ENV['APP_URL'] ?? 'not set') . '</p>';
        echo '<a href="/debug/routes">View debug info</a> | <a href="/">Home</a>';
    });
}

// ===================================