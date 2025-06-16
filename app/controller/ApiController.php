<?php

/**
 * API Controller
 * Handles API endpoints for external access
 */

class ApiController
{
    /**
     * Get available coffees
     */
    public function coffees()
    {
        header('Content-Type: application/json');
        
        // Sample coffee data
        $coffees = [
            [
                'id' => 1,
                'name' => 'Americano',
                'price' => 3.00,
                'description' => 'Classic black coffee'
            ],
            [
                'id' => 2,
                'name' => 'Latte',
                'price' => 4.50,
                'description' => 'Espresso with steamed milk'
            ],
            [
                'id' => 3,
                'name' => 'Cappuccino',
                'price' => 4.00,
                'description' => 'Espresso with steamed milk foam'
            ],
            [
                'id' => 4,
                'name' => 'Mocha',
                'price' => 5.00,
                'description' => 'Espresso with chocolate and steamed milk'
            ]
        ];
        
        echo json_encode([
            'success' => true,
            'data' => $coffees,
            'count' => count($coffees)
        ]);
    }
    
    /**
     * Get specific order
     */
    public function getOrder()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['is_authenticated']) || !$_SESSION['is_authenticated']) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        
        header('Content-Type: application/json');
        
        // TODO: Get order from database
        // For now, return sample data
        $orderId = $_GET['id'] ?? 1;
        
        $order = [
            'id' => $orderId,
            'user_id' => $_SESSION['user_id'] ?? 'unknown',
            'items' => [
                ['name' => 'Custom DIY Coffee', 'price' => 5.50, 'quantity' => 1]
            ],
            'total' => 5.50,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        echo json_encode([
            'success' => true,
            'data' => $order
        ]);
    }
    
    /**
     * Create new order
     */
    public function createOrder()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['is_authenticated']) || !$_SESSION['is_authenticated']) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        
        header('Content-Type: application/json');
        
        // Get POST data
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        
        if (!$data) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            exit;
        }
        
        // TODO: Validate and save order to database
        
        // For now, return success with mock order ID
        $orderId = 'CB-' . date('mdHis') . rand(100, 999);
        
        echo json_encode([
            'success' => true,
            'order_id' => $orderId,
            'message' => 'Order created successfully',
            'data' => [
                'id' => $orderId,
                'total' => $data['total'] ?? 0,
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
