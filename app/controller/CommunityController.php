<?php

/**
 * Community Controller
 * Handles community page and community product views
 */

class CommunityController
{
    /**
     * Display community page with community-made products
     */
    public function index()
    {
        // Get all community products
        $communityProducts = $this->getCommunityProducts();
        
        require_once __DIR__ . '/../view/community/index.php';
    }
    
    /**
     * View specific community product
     */
    public function viewProduct($productId)
    {
        // Get specific community product by ID
        $product = $this->getCommunityProduct($productId);
        
        if (!$product) {
            http_response_code(404);
            require_once __DIR__ . '/../view/errors/404.php';
            return;
        }
        
        require_once __DIR__ . '/../view/community/product.php';
    }
    
    /**
     * Get sample community products (placeholder)
     */
    private function getCommunityProducts()
    {
        // TODO: Replace with actual database query
        return [
            [
                'id' => 1,
                'name' => 'Vanilla Dream Latte',
                'creator' => 'CoffeeExpert123',
                'description' => 'A smooth vanilla latte with extra foam',
                'rating' => 4.5,
                'price' => 5.99,
                'image' => '/assets/community/vanilla-dream.jpg'
            ],
            [
                'id' => 2,
                'name' => 'Caramel Twist Frappuccino',
                'creator' => 'BaristaPro',
                'description' => 'Cold brew with caramel swirl and whipped cream',
                'rating' => 4.8,
                'price' => 6.49,
                'image' => '/assets/community/caramel-twist.jpg'
            ]
        ];
    }
    
    /**
     * Get specific community product
     */
    private function getCommunityProduct($id)
    {
        $products = $this->getCommunityProducts();
        
        foreach ($products as $product) {
            if ($product['id'] == $id) {
                return $product;
            }
        }
        
        return null;
    }
}
