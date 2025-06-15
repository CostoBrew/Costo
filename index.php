<?php

/**
 * Costobrew Framework - Secure Entry Point
 * Main router with security features and middleware
 */

// Error reporting based on environment
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Load environment configuration
require_once 'app/config/database.php';

// Initialize environment variables by triggering database config load
try {
    DatabaseConfig::getConnection();
} catch (Exception $e) {
    // Database might not be set up yet, but environment should be loaded
    error_log('Database connection failed during startup: ' . $e->getMessage());
}

// Security headers and session setup
require_once 'app/core/Router.php';
require_once 'app/middleware/SecurityMiddleware.php';
require_once 'app/middleware/CSRFMiddleware.php';
require_once 'app/middleware/RateLimitMiddleware.php';

// Load controllers
require_once 'app/controller/AuthController.php';
require_once 'app/controller/CommunityController.php';
require_once 'app/controller/SettingsController.php';
require_once 'app/controller/CoffeeStudioController.php';
require_once 'app/controller/CartController.php';
require_once 'app/controller/CheckoutController.php';
require_once 'app/controller/OrderController.php';

// Initialize router
$router = new Router();

// Apply global security middleware
$router->middleware([
    'SecurityMiddleware',
    RateLimitMiddleware::create(100, 1), // 100 requests per minute
]);

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

// Authentication routes
$router->get('/login', function() {
    require_once 'app/view/auth/login.php';
});

$router->get('/signup', function() {
    require_once 'app/view/auth/signup.php';
});

$router->post('/login', 'AuthController@login', ['CSRFMiddleware']);
$router->post('/signup', 'AuthController@signup', ['CSRFMiddleware']);
$router->post('/logout', 'AuthController@logout', ['CSRFMiddleware']);

// Community Page
$router->get('/community', 'CommunityController@index');
$router->get('/community/product/{id}', 'CommunityController@viewProduct');

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

// DIY Coffee (8 Stages)
$router->get('/studio/diy', 'CoffeeStudioController@diyStart', ['AuthMiddleware']);
$router->get('/studio/diy/info', 'CoffeeStudioController@diyInfo', ['AuthMiddleware']);
$router->get('/studio/diy/cup-size', 'CoffeeStudioController@diyCupSize', ['AuthMiddleware']);
$router->get('/studio/diy/coffee-beans', 'CoffeeStudioController@diyCoffeeBeans', ['AuthMiddleware']);
$router->get('/studio/diy/milk-type', 'CoffeeStudioController@diyMilkType', ['AuthMiddleware']);
$router->get('/studio/diy/sweeteners', 'CoffeeStudioController@diySweeteners', ['AuthMiddleware']);
$router->get('/studio/diy/syrups', 'CoffeeStudioController@diySyrups', ['AuthMiddleware']);
$router->get('/studio/diy/toppings', 'CoffeeStudioController@diyToppings', ['AuthMiddleware']);
$router->get('/studio/diy/pastry', 'CoffeeStudioController@diyPastry', ['AuthMiddleware']);

// Premade Coffee (3 stages)
$router->get('/studio/premade', 'CoffeeStudioController@premadeStart', ['AuthMiddleware']);
$router->get('/studio/premade/cup-size', 'CoffeeStudioController@premadeCupSize', ['AuthMiddleware']);
$router->get('/studio/premade/coffee', 'CoffeeStudioController@premadeCoffee', ['AuthMiddleware']);
$router->get('/studio/premade/pastry', 'CoffeeStudioController@premadePastry', ['AuthMiddleware']);

// Studio API endpoints for updating selections
$router->post('/studio/update-selection', 'CoffeeStudioController@updateSelection', ['AuthMiddleware', 'CSRFMiddleware']);
$router->post('/studio/add-to-cart', 'CoffeeStudioController@addToCart', ['AuthMiddleware', 'CSRFMiddleware']);

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
$router->get('/admin/orders', 'AdminController@manageOrders', ['AdminMiddleware']);
$router->get('/admin/customers', 'AdminController@manageCustomers', ['AdminMiddleware']);

// Admin CRUD operations
$router->post('/admin/coffees', 'AdminController@createCoffee', ['AdminMiddleware', 'CSRFMiddleware']);
$router->put('/admin/coffees/{id}', 'AdminController@updateCoffee', ['AdminMiddleware', 'CSRFMiddleware']);
$router->delete('/admin/coffees/{id}', 'AdminController@deleteCoffee', ['AdminMiddleware', 'CSRFMiddleware']);

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
    
    if ($_ENV['APP_ENV'] === 'development') {
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
    return rtrim($_ENV['APP_URL'], '/') . '/' . ltrim($path, '/');
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