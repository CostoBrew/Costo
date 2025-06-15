<?php

/**
 * Main Coffee Controller
 * Handles coffee-related operations
 */

require_once __DIR__ . '/../model/Coffee.php';

class CoffeeController
{
    private $coffeeModel;

    public function __construct()
    {
        $this->coffeeModel = new Coffee();
    }

    /**
     * Display all coffees (menu)
     */
    public function index()
    {
        try {
            // For now, we'll use sample data since database might not be set up
            $coffees = $this->getSampleCoffees();
            
            // If database is connected, use this instead:
            // $coffees = $this->coffeeModel->getAvailable();
            
            require_once __DIR__ . '/../view/menu.php';
        } catch (Exception $e) {
            error_log('Coffee index error: ' . $e->getMessage());
            
            // Fallback to sample data
            $coffees = $this->getSampleCoffees();
            require_once __DIR__ . '/../view/menu.php';
        }
    }

    /**
     * Display single coffee
     */
    public function show($id)
    {
        try {
            // For now, use sample data
            $coffee = $this->getSampleCoffee($id);
            
            // If database is connected, use this instead:
            // $coffee = $this->coffeeModel->find($id);
            
            if (!$coffee) {
                http_response_code(404);
                require_once __DIR__ . '/../view/errors/404.php';
                return;
            }
            
            require_once __DIR__ . '/../view/coffee-detail.php';
        } catch (Exception $e) {
            error_log('Coffee show error: ' . $e->getMessage());
            http_response_code(500);
            require_once __DIR__ . '/../view/errors/500.php';
        }
    }

    /**
     * Get sample coffee data for testing
     */
    private function getSampleCoffees()
    {
        return [
            [
                'id' => 1,
                'name' => 'Ethiopian Single Origin',
                'description' => 'Bright and fruity with notes of blueberry and chocolate',
                'price' => 24.99,
                'type' => 'Single Origin',
                'stock' => 50,
                'image' => 'https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=300&h=200&fit=crop'
            ],
            [
                'id' => 2,
                'name' => 'Colombian Medium Roast',
                'description' => 'Smooth and balanced with caramel sweetness',
                'price' => 19.99,
                'type' => 'Medium Roast',
                'stock' => 75,
                'image' => 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=300&h=200&fit=crop'
            ],
            [
                'id' => 3,
                'name' => 'French Roast Dark',
                'description' => 'Bold and intense with smoky undertones',
                'price' => 22.99,
                'type' => 'Dark Roast',
                'stock' => 30,
                'image' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?w=300&h=200&fit=crop'
            ],
            [
                'id' => 4,
                'name' => 'Espresso Blend',
                'description' => 'Perfect for espresso with rich crema',
                'price' => 26.99,
                'type' => 'Espresso',
                'stock' => 40,
                'image' => 'https://images.unsplash.com/photo-1510707577719-ae7c14805e3a?w=300&h=200&fit=crop'
            ]
        ];
    }

    /**
     * Get sample single coffee
     */
    private function getSampleCoffee($id)
    {
        $coffees = $this->getSampleCoffees();
        
        foreach ($coffees as $coffee) {
            if ($coffee['id'] == $id) {
                return $coffee;
            }
        }
        
        return null;
    }
}