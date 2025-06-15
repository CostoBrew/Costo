<?php

/**
 * Authentication Controller
 * Handles login, signup, and logout functionality
 */

class AuthController
{
    /**
     * Handle user login
     */
    public function login()
    {
        // Implementation for login logic
        // This will handle POST request from login form
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Process login
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            // TODO: Implement authentication logic
            // For now, redirect to home
            header('Location: /');
            exit;
        }
    }
    
    /**
     * Handle user signup
     */
    public function signup()
    {
        // Implementation for signup logic
        // This will handle POST request from signup form
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Process signup
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            $full_name = $_POST['full_name'] ?? '';
            
            // TODO: Implement registration logic
            // For now, redirect to login
            header('Location: /login');
            exit;
        }
    }
    
    /**
     * Handle user logout
     */
    public function logout()
    {
        // Clear session and redirect
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        session_destroy();
        header('Location: /');
        exit;
    }
}
