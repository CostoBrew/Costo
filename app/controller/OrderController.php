<?php

/**
 * Order Controller
 * Handles order history and order details
 */

class OrderController
{
    /**
     * Display order history
     */
    public function index()
    {
        $orders = $this->getUserOrders();
        
        require_once __DIR__ . '/../view/orders/index.php';
    }
    
    /**
     * Display specific order details
     */
    public function show($orderId)
    {
        $order = $this->getOrder($orderId);
        
        if (!$order) {
            http_response_code(404);
            require_once __DIR__ . '/../view/errors/404.php';
            return;
        }
        
        require_once __DIR__ . '/../view/orders/show.php';
    }
    
    // ========================================
    // HELPER METHODS
    // ========================================
    
    /**
     * Get all orders for current user
     */
    private function getUserOrders()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // TODO: Replace with actual database query
        // For now, return orders from session
        $orders = $_SESSION['orders'] ?? [];
        
        // Sort by date (newest first)
        uasort($orders, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        
        return $orders;
    }
    
    /**
     * Get specific order
     */
    private function getOrder($orderId)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        return $_SESSION['orders'][$orderId] ?? null;
    }
}
