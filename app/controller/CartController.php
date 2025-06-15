<?php

/**
 * Shopping Cart Controller
 * Handles cart operations (add, remove, update, clear)
 */

class CartController
{
    /**
     * Display shopping cart
     */
    public function index()
    {
        $cartItems = $this->getCartItems();
        $cartTotal = $this->calculateCartTotal($cartItems);
        
        require_once __DIR__ . '/../view/cart/index.php';
    }
    
    /**
     * Add item to cart
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $itemId = $_POST['item_id'] ?? '';
            $itemType = $_POST['item_type'] ?? ''; // 'diy', 'premade', 'pastry'
            $quantity = intval($_POST['quantity'] ?? 1);
            $customData = $_POST['custom_data'] ?? [];
            
            $this->addToCart($itemId, $itemType, $quantity, $customData);
            
            // Return JSON response for AJAX calls
            if (isset($_POST['ajax'])) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Item added to cart']);
                exit;
            }
            
            header('Location: /cart');
            exit;
        }
    }
    
    /**
     * Remove item from cart
     */
    public function remove()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartItemId = $_POST['cart_item_id'] ?? '';
            
            $this->removeFromCart($cartItemId);
            
            if (isset($_POST['ajax'])) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Item removed from cart']);
                exit;
            }
            
            header('Location: /cart');
            exit;
        }
    }
    
    /**
     * Update cart item quantity
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartItemId = $_POST['cart_item_id'] ?? '';
            $newQuantity = intval($_POST['quantity'] ?? 1);
            
            $this->updateCartItemQuantity($cartItemId, $newQuantity);
            
            if (isset($_POST['ajax'])) {
                $cartItems = $this->getCartItems();
                $cartTotal = $this->calculateCartTotal($cartItems);
                
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true, 
                    'message' => 'Cart updated',
                    'cartTotal' => $cartTotal
                ]);
                exit;
            }
            
            header('Location: /cart');
            exit;
        }
    }
    
    /**
     * Clear entire cart
     */
    public function clear()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->clearCart();
            
            if (isset($_POST['ajax'])) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Cart cleared']);
                exit;
            }
            
            header('Location: /cart');
            exit;
        }
    }
    
    // ========================================
    // HELPER METHODS
    // ========================================
    
    /**
     * Get cart items for current user
     */
    private function getCartItems()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // TODO: Replace with database query for logged-in users
        // For now, use session storage
        return $_SESSION['cart'] ?? [];
    }
    
    /**
     * Add item to cart
     */
    private function addToCart($itemId, $itemType, $quantity, $customData = [])
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        $cartItem = [
            'id' => uniqid(),
            'item_id' => $itemId,
            'item_type' => $itemType,
            'quantity' => $quantity,
            'custom_data' => $customData,
            'price' => $this->calculateItemPrice($itemType, $customData),
            'added_at' => date('Y-m-d H:i:s')
        ];
        
        $_SESSION['cart'][] = $cartItem;
    }
    
    /**
     * Remove item from cart
     */
    private function removeFromCart($cartItemId)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($cartItemId) {
                return $item['id'] !== $cartItemId;
            });
            
            // Reindex array
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
    }
    
    /**
     * Update cart item quantity
     */
    private function updateCartItemQuantity($cartItemId, $newQuantity)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['id'] === $cartItemId) {
                    $item['quantity'] = max(1, $newQuantity); // Minimum quantity is 1
                    break;
                }
            }
        }
    }
    
    /**
     * Clear entire cart
     */
    private function clearCart()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION['cart'] = [];
    }
    
    /**
     * Calculate total price for cart
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
     * Calculate price for individual item
     */
    private function calculateItemPrice($itemType, $customData)
    {
        // Base price calculation
        $basePrice = 3.00; // Default base price
        
        if ($itemType === 'diy') {
            // Calculate DIY coffee price based on selections
            foreach ($customData as $selection) {
                $basePrice += $selection['price'] ?? 0;
            }
        } elseif ($itemType === 'premade') {
            // Get premade coffee price
            $basePrice = $customData['coffee_price'] ?? 3.00;
            $basePrice += $customData['pastry_price'] ?? 0;
        }
        
        return $basePrice;
    }
}
