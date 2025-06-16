<?php

/**
 * Admin Controller
 * Handles admin dashboard and management functions
 */

class AdminController
{
    /**
     * Admin dashboard
     */
    public function dashboard()
    {
        // Check if user is admin
        if (!$this->isAdmin()) {
            header('Location: /login');
            exit;
        }
        
        // TODO: Implement admin dashboard
        echo "<h1>Admin Dashboard</h1><p>Coming soon...</p>";
    }
    
    /**
     * Manage coffees
     */
    public function manageCoffees()
    {
        if (!$this->isAdmin()) {
            header('Location: /login');
            exit;
        }
        
        // TODO: Implement coffee management
        echo "<h1>Manage Coffees</h1><p>Coming soon...</p>";
    }
    
    /**
     * Manage orders
     */
    public function manageOrders()
    {
        if (!$this->isAdmin()) {
            header('Location: /login');
            exit;
        }
        
        // TODO: Implement order management
        echo "<h1>Manage Orders</h1><p>Coming soon...</p>";
    }
    
    /**
     * Manage customers
     */
    public function manageCustomers()
    {
        if (!$this->isAdmin()) {
            header('Location: /login');
            exit;
        }
        
        // TODO: Implement customer management
        echo "<h1>Manage Customers</h1><p>Coming soon...</p>";
    }
    
    /**
     * Create coffee
     */
    public function createCoffee()
    {
        if (!$this->isAdmin()) {
            http_response_code(403);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        
        // TODO: Implement coffee creation
        echo json_encode(['success' => true, 'message' => 'Coffee creation coming soon']);
    }
    
    /**
     * Update coffee
     */
    public function updateCoffee()
    {
        if (!$this->isAdmin()) {
            http_response_code(403);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        
        // TODO: Implement coffee update
        echo json_encode(['success' => true, 'message' => 'Coffee update coming soon']);
    }
    
    /**
     * Delete coffee
     */
    public function deleteCoffee()
    {
        if (!$this->isAdmin()) {
            http_response_code(403);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        
        // TODO: Implement coffee deletion
        echo json_encode(['success' => true, 'message' => 'Coffee deletion coming soon']);
    }
    
    /**
     * Check if current user is admin
     */
    private function isAdmin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // TODO: Implement proper admin check
        // For now, just check if user is logged in
        return isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated'] === true;
    }
}
