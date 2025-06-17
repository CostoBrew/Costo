<?php

/**
 * Checkout Controller
 * Handles checkout process, payment, and receipt display with "You might like" suggestions
 */

class CheckoutController
{    /**
     * Display checkout page with order summary
     */
    public function index()
    {
        $cartItems = $this->getCartItems();        
        // Allow empty cart to show the checkout page with empty state
        // User will see "No items in your order" message
          if ($this->isDirectCheckout($cartItems)) {
            // For direct checkout, use the pre-calculated values from Coffee Studio
            $cartItem = $cartItems[0]; // Only one item in direct checkout
            $cartTotal = $cartItem['subtotal'] ?? 0;
            $deliveryFee = $cartItem['deliveryFee'] ?? 50;
            $taxes = $cartItem['vatAmount'] ?? 0;
            $finalTotal = $cartItem['price'] ?? 0;
        } else {
            // Regular cart calculation
            $cartTotal = $this->calculateCartTotal($cartItems);
            $deliveryFee = 50; // Standard delivery fee
            $subtotalWithDelivery = $cartTotal + $deliveryFee;
            $taxes = $this->calculateTaxes($subtotalWithDelivery);
            $finalTotal = $subtotalWithDelivery + $taxes;
        }
        
        require_once __DIR__ . '/../view/checkout/index.php';
    }
      /**
     * Process checkout and create order
     */    public function process()
    {
        // Start output buffering early to prevent header issues
        if (!ob_get_level()) {
            ob_start();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $cartItems = $this->getCartItems();
                
                if (empty($cartItems)) {
                    ob_clean();
                    header('Location: /cart');
                    exit;
                }
                  // Get customer and delivery info
                $customerInfo = [
                    'name' => $_POST['customer_name'] ?? '',
                    'email' => $_POST['customer_email'] ?? '',
                    'phone' => $_POST['customer_phone'] ?? '',
                    'delivery_address' => $_POST['delivery_address'] ?? '',
                    'delivery_notes' => $_POST['delivery_notes'] ?? ''
                ];
                  // Always cash on delivery for Philippines
                $paymentInfo = [
                    'method' => 'cash',  // Fixed to match database enum
                    'order_type' => 'delivery'
                ];
                
                // Process payment (placeholder)
                $paymentResult = $this->processPayment($paymentInfo, $this->calculateFinalTotal($cartItems));                if ($paymentResult['success']) {
                    // Create order
                    $orderId = $this->createOrder($cartItems, $customerInfo, $paymentInfo);
                    
                    // Clear cart after successful order
                    $this->clearCart();
                    
                    // Clean output buffer and redirect to receipt
                    ob_clean();
                    header("Location: /checkout/receipt/{$orderId}");
                    exit;
                } else {
                    // Handle payment failure - clean output before showing form
                    ob_clean();
                    $errorMessage = $paymentResult['message'];
                    require_once __DIR__ . '/../view/checkout/index.php';
                    return;
                }
            } catch (Exception $e) {
                error_log("Checkout process error: " . $e->getMessage());
                ob_clean();
                $errorMessage = "An error occurred during checkout. Please try again.";
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
     * Get cart items from session (including direct checkout items)
     */    private function getCartItems()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check for direct checkout item first (single item from studio)
        if (isset($_SESSION['direct_checkout_item'])) {
            return [$_SESSION['direct_checkout_item']];
        }
        
        // Fallback to regular cart items
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
     * Check if cart contains direct checkout items (from Coffee Studio)
     */
    private function isDirectCheckout($cartItems)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if this is a direct checkout from studio
        return isset($_SESSION['direct_checkout_item']);
    }
    
    /**
     * Calculate taxes (12% VAT for Philippines)
     */
    private function calculateTaxes($subtotal)
    {
        return $subtotal * 0.12; // 12% VAT rate for Philippines
    }
    
    /**
     * Calculate final total with taxes
     */
    private function calculateFinalTotal($cartItems)
    {
        // For direct checkout from Coffee Studio, the total already includes delivery + VAT
        if ($this->isDirectCheckout($cartItems)) {
            return $this->calculateCartTotal($cartItems);
        }
        
        // For regular cart items, add delivery and VAT
        $subtotal = $this->calculateCartTotal($cartItems);
        $deliveryFee = 50; // ₱50 delivery fee
        $subtotalWithDelivery = $subtotal + $deliveryFee;
        $taxes = $this->calculateTaxes($subtotalWithDelivery);
        return $subtotalWithDelivery + $taxes;
    }
    
    /**
     * Process payment (placeholder implementation)
     */    private function processPayment($paymentInfo, $amount)
    {
        // TODO: Implement actual payment processing
        // For now, simulate successful payment
        
        if ($paymentInfo['method'] === 'cash' || $paymentInfo['method'] === 'cash_on_delivery') {
            return ['success' => true, 'transaction_id' => 'COD_' . uniqid()];
        }
        
        if ($paymentInfo['method'] === 'card') {
            // Simulate card processing
            if (empty($paymentInfo['card_number'])) {
                return ['success' => false, 'message' => 'Card number is required'];
            }
            
            return ['success' => true, 'transaction_id' => 'CARD_' . uniqid()];
        }
        
        return ['success' => false, 'message' => 'Invalid payment method: ' . $paymentInfo['method']];
    }/**
     * Create order in database
     */    private function createOrder($cartItems, $customerInfo, $paymentInfo)
    {        
        try {
            // Load models
            require_once __DIR__ . '/../model/BaseModel.php';
            require_once __DIR__ . '/../model/Order.php';            // Get user ID if logged in - Now supports Firebase string IDs
            $userId = $_SESSION['user_id'] ?? null;            // Calculate totals
            if ($this->isDirectCheckout($cartItems)) {
                // For direct checkout, use pre-calculated values from Coffee Studio
                $cartItem = $cartItems[0];
                $subtotal = $cartItem['subtotal'] ?? 0;
                $taxAmount = $cartItem['vatAmount'] ?? 0;
                $totalAmount = $cartItem['price'] ?? 0;
            } else {
                // Regular cart calculation
                $subtotal = $this->calculateCartTotal($cartItems);
                $taxAmount = $this->calculateTaxes($subtotal);
                $totalAmount = $subtotal + $taxAmount;
            }// Prepare order data
            $orderData = [
                'user_id' => $userId,
                'order_number' => Order::generateOrderNumber(),
                'customer_name' => $customerInfo['name'],
                'customer_email' => $customerInfo['email'],
                'customer_phone' => $customerInfo['phone'],
                'order_type' => $_POST['order_type'] ?? 'delivery',
                'payment_method' => $paymentInfo['method'],
                'payment_status' => 'paid',
                'order_status' => 'confirmed',
                'subtotal' => $subtotal ?? 0,  // Ensure subtotal is always set
                'tax_amount' => $taxAmount ?? 0,
                'total_amount' => $totalAmount ?? 0,
                'delivery_address' => $customerInfo['delivery_address'] ?? '',
                'session_id' => session_id(),
                'special_instructions' => $_POST['special_instructions'] ?? null
            ];
            
            error_log("Order data prepared: " . json_encode($orderData));// Prepare order items
            $orderItems = [];
            foreach ($cartItems as $item) {
                // Determine item name with fallbacks
                $itemName = $item['name'] ?? $item['custom_data']['name'] ?? 'Custom Coffee';
                
                $unitPrice = $item['price'] ?? $item['total'] ?? 0;
                $quantity = $item['quantity'] ?? 1;
                $totalPrice = $unitPrice * $quantity;
                  // Debug logging
                error_log("Creating order item: name=$itemName, unit_price=$unitPrice, quantity=$quantity, total_price=$totalPrice");
                
                $orderItems[] = [
                    'item_type' => $this->determineItemType($item),
                    'item_name' => $itemName,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $totalPrice,
                    'customization_data' => $this->prepareCustomizationData($item),
                    'special_instructions' => $item['special_instructions'] ?? null
                ];
            }            // Create order using the Order model
            $orderId = Order::createOrderWithItems($orderData, $orderItems);
            
            return $orderId;} catch (Exception $e) {
            // Log detailed error information
            error_log("Order creation failed: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            error_log("Order data: " . json_encode($orderData ?? 'undefined'));
            error_log("Order items: " . json_encode($orderItems ?? 'undefined'));
            
            return $this->createSessionOrder($cartItems, $customerInfo, $paymentInfo);
        }
    }
      /**
     * Determine item type based on cart item data
     */
    private function determineItemType($item)
    {
        if (isset($item['type'])) {
            switch ($item['type']) {
                case 'diy_coffee':
                    return 'diy_coffee';
                case 'premade_coffee':
                    return 'premade_coffee';
                case 'pastry':
                    return 'pastry';
                default:
                    return 'menu_item';
            }
        }
        
        // Fallback logic based on item properties
        if (isset($item['build'])) {
            return 'diy_coffee';
        }
        
        return 'menu_item';
    }
    
    /**
     * Prepare customization data for database storage
     */
    private function prepareCustomizationData($item)
    {
        $customization = [];
        
        // Handle DIY coffee builds
        if (isset($item['build'])) {
            $customization = $item['build'];
        }
        
        // Handle other customizations
        if (isset($item['customizations'])) {
            $customization = array_merge($customization, $item['customizations']);
        }
        
        // Add metadata
        if (isset($item['special_instructions'])) {
            $customization['special_instructions'] = $item['special_instructions'];
        }
        
        return $customization;
    }
    
    /**
     * Fallback session-based order creation
     */
    private function createSessionOrder($cartItems, $customerInfo, $paymentInfo)
    {
        $orderId = 'ORD_' . date('Ymd') . '_' . uniqid();
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION['orders'][$orderId] = [
            'id' => $orderId,
            'order_number' => $orderId,
            'items' => $cartItems,
            'customer_name' => $customerInfo['name'],
            'customer_email' => $customerInfo['email'],
            'customer_phone' => $customerInfo['phone'],
            'payment_method' => $paymentInfo['method'],
            'subtotal' => $this->calculateCartTotal($cartItems),
            'tax_amount' => $this->calculateTaxes($this->calculateCartTotal($cartItems)),
            'total_amount' => $this->calculateFinalTotal($cartItems),
            'order_status' => 'completed',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        return $orderId;
    }/**
     * Get order by ID
     */
    private function getOrder($orderId)
    {        // Try to get order from database first
        try {
            require_once __DIR__ . '/../model/BaseModel.php';
            require_once __DIR__ . '/../model/Order.php';
            
            // Check if orderId is numeric (database ID) or string (session ID or order number)
            if (is_numeric($orderId)) {
                $order = Order::getOrderWithItems($orderId);
            } else {
                $order = Order::getOrderByNumber($orderId);
            }
            
            if ($order) {
                return $order;
            }
        } catch (Exception $e) {
            // Log error and fall back to session
            error_log("Database order retrieval failed: " . $e->getMessage());
        }
        
        // Fallback to session storage
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
        
        // Clear both cart and direct checkout items
        $_SESSION['cart'] = [];
        unset($_SESSION['direct_checkout_item']);
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
