<?php

/**
 * Checkout Controller
 * Handles checkout process, payment, and receipt display with "You might like" suggestions
 */

class CheckoutController
{
    /**
     * Display checkout page with order summary
     */
    public function index()
    {
        $cartItems = $this->getCartItems();
        
        if (empty($cartItems)) {
            header('Location: /cart');
            exit;
        }
        
        $cartTotal = $this->calculateCartTotal($cartItems);
        $taxes = $this->calculateTaxes($cartTotal);
        $finalTotal = $cartTotal + $taxes;
        
        require_once __DIR__ . '/../view/checkout/index.php';
    }
    
    /**
     * Process checkout and create order
     */
    public function process()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartItems = $this->getCartItems();
            
            if (empty($cartItems)) {
                header('Location: /cart');
                exit;
            }
            
            // Get payment and customer info
            $customerInfo = [
                'name' => $_POST['customer_name'] ?? '',
                'email' => $_POST['customer_email'] ?? '',
                'phone' => $_POST['customer_phone'] ?? ''
            ];
            
            $paymentInfo = [
                'method' => $_POST['payment_method'] ?? 'cash',
                'card_number' => $_POST['card_number'] ?? '',
                'expiry' => $_POST['card_expiry'] ?? '',
                'cvv' => $_POST['card_cvv'] ?? ''
            ];
            
            // Process payment (placeholder)
            $paymentResult = $this->processPayment($paymentInfo, $this->calculateFinalTotal($cartItems));
            
            if ($paymentResult['success']) {
                // Create order
                $orderId = $this->createOrder($cartItems, $customerInfo, $paymentInfo);
                
                // Clear cart after successful order
                $this->clearCart();
                
                // Redirect to receipt
                header("Location: /checkout/receipt/{$orderId}");
                exit;
            } else {
                // Handle payment failure
                $errorMessage = $paymentResult['message'];
                require_once __DIR__ . '/../view/checkout/index.php';
                return;
            }
        }
    }
    
    /**
     * Display receipt with "You might like" suggestions
     */
    public function receipt($orderId)
    {
        $order = $this->getOrder($orderId);
        
        if (!$order) {
            http_response_code(404);
            require_once __DIR__ . '/../view/errors/404.php';
            return;
        }
        
        // Get "You might like" suggestions
        $suggestions = $this->getRecommendations($order);
        
        require_once __DIR__ . '/../view/checkout/receipt.php';
    }
    
    // ========================================
    // HELPER METHODS
    // ========================================
    
    /**
     * Get cart items from session
     */
    private function getCartItems()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        return $_SESSION['cart'] ?? [];
    }
    
    /**
     * Calculate cart total
     */
    private function calculateCartTotal($cartItems)
    {
        $total = 0;
        
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return $total;
    }
    
    /**
     * Calculate taxes
     */
    private function calculateTaxes($subtotal)
    {
        return $subtotal * 0.08; // 8% tax rate
    }
    
    /**
     * Calculate final total with taxes
     */
    private function calculateFinalTotal($cartItems)
    {
        $subtotal = $this->calculateCartTotal($cartItems);
        $taxes = $this->calculateTaxes($subtotal);
        return $subtotal + $taxes;
    }
    
    /**
     * Process payment (placeholder implementation)
     */
    private function processPayment($paymentInfo, $amount)
    {
        // TODO: Implement actual payment processing
        // For now, simulate successful payment
        
        if ($paymentInfo['method'] === 'cash') {
            return ['success' => true, 'transaction_id' => 'CASH_' . uniqid()];
        }
        
        if ($paymentInfo['method'] === 'card') {
            // Simulate card processing
            if (empty($paymentInfo['card_number'])) {
                return ['success' => false, 'message' => 'Card number is required'];
            }
            
            return ['success' => true, 'transaction_id' => 'CARD_' . uniqid()];
        }
        
        return ['success' => false, 'message' => 'Invalid payment method'];
    }
    
    /**
     * Create order in database
     */
    private function createOrder($cartItems, $customerInfo, $paymentInfo)
    {
        // TODO: Implement actual database insertion
        // For now, generate a unique order ID and store in session
        
        $orderId = 'ORD_' . date('Ymd') . '_' . uniqid();
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION['orders'][$orderId] = [
            'id' => $orderId,
            'items' => $cartItems,
            'customer' => $customerInfo,
            'payment' => $paymentInfo,
            'subtotal' => $this->calculateCartTotal($cartItems),
            'taxes' => $this->calculateTaxes($this->calculateCartTotal($cartItems)),
            'total' => $this->calculateFinalTotal($cartItems),
            'status' => 'completed',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        return $orderId;
    }
    
    /**
     * Get order by ID
     */
    private function getOrder($orderId)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        return $_SESSION['orders'][$orderId] ?? null;
    }
    
    /**
     * Clear cart after successful order
     */
    private function clearCart()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION['cart'] = [];
    }
    
    /**
     * Get "You might like" recommendations based on order
     */
    private function getRecommendations($order)
    {
        // TODO: Implement smart recommendations based on order history and preferences
        // For now, return some sample recommendations
        
        return [
            [
                'name' => 'Chocolate Chip Cookie',
                'price' => 2.50,
                'image' => '/assets/pastries/chocolate-chip-cookie.jpg',
                'description' => 'Fresh baked chocolate chip cookie'
            ],
            [
                'name' => 'Caramel Macchiato',
                'price' => 4.75,
                'image' => '/assets/drinks/caramel-macchiato.jpg',
                'description' => 'Rich espresso with caramel and steamed milk'
            ],
            [
                'name' => 'Blueberry Muffin',
                'price' => 2.25,
                'image' => '/assets/pastries/blueberry-muffin.jpg',
                'description' => 'Fluffy muffin with fresh blueberries'
            ]
        ];
    }
}
