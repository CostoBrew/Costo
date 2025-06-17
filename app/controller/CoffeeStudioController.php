<?php

/**
 * Coffee Studio Controller
 * Handles DIY Coffee (7 stages) and Premade Coffee (3 stages) with POS-like counter
 */

class CoffeeStudioController
{    /**
     * Coffee Studio main page (selector between DIY and Premade)
     */
    public function index()
    {
        require_once __DIR__ . '/../view/studio/index.php';
    }
      // ========================================
    // DIY COFFEE - 7 STAGES
    // ========================================
      /**
     * Start DIY coffee creation - New single-page approach
     */
    public function diyStart()
    {
        $this->initializeSession();
        require_once __DIR__ . '/../view/studio/diy/index.php';
    }
      /**
     * Stage 1: Cup Size selection
     */
    public function diyCupSize()
    {
        $cupSizes = $this->getCupSizes();
        require_once __DIR__ . '/../view/studio/diy/cup-selector.php';
    }
      /**
     * Stage 2: Coffee beans type
     */
    public function diyCoffeeBeans()
    {
        $coffeeBeans = $this->getCoffeeBeans();
        require_once __DIR__ . '/../view/studio/diy/beans-selector.php';
    }
    
    /**
     * Stage 3: Milk Type
     */
    public function diyMilkType()
    {
        $milkTypes = $this->getMilkTypes();
        require_once __DIR__ . '/../view/studio/diy/milk-selector.php';
    }
    
    /**
     * Stage 4: Sweeteners Type
     */
    public function diySweeteners()
    {
        $sweeteners = $this->getSweeteners();
        require_once __DIR__ . '/../view/studio/diy/sweeteners-selector.php';
    }
    
    /**
     * Stage 5: Syrups / Flavored Syrups
     */
    public function diySyrups()
    {
        $syrups = $this->getSyrups();
        require_once __DIR__ . '/../view/studio/diy/syrup-selector.php';
    }
    
    /**
     * Stage 6: Toppings
     */
    public function diyToppings()
    {
        $toppings = $this->getToppings();
        require_once __DIR__ . '/../view/studio/diy/toppings-selector.php';
    }
    
    /**
     * Stage 7: Pastry
     */
    public function diyPastry()
    {
        $pastries = $this->getPastries();
        require_once __DIR__ . '/../view/studio/diy/pastry-selector.php';
    }
      // ========================================
    // PREMADE COFFEE - 3 STAGES
    // ========================================
    
    /**
     * Start Premade coffee selection - Unified 3-stage process
     */
    public function premadeStart()
    {
        $this->initializeSession();
        require_once __DIR__ . '/../view/studio/premade/index.php';
    }
    
    /**
     * Stage 1: Cup Size
     */
    public function premadeCupSize()
    {
        $cupSizes = $this->getCupSizes();
        require_once __DIR__ . '/../view/studio/premade/cup-selector.php';
    }
    
    /**
     * Stage 2: Coffee selection
     */
    public function premadeCoffee()
    {
        $premadeCoffees = $this->getPremadeCoffees();
        require_once __DIR__ . '/../view/studio/premade/coffee-selector.php';
    }
    
    /**
     * Stage 3: Pastry
     */
    public function premadePastry()
    {
        $pastries = $this->getPastries();
        require_once __DIR__ . '/../view/studio/premade/pastry-selector.php';
    }
    
    // ========================================
    // STUDIO FUNCTIONALITY
    // ========================================
    
    /**
     * Update selection (AJAX endpoint)
     */
    public function updateSelection()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $type = $_POST['type'] ?? '';
            $value = $_POST['value'] ?? '';
            $price = floatval($_POST['price'] ?? 0);
            
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            $_SESSION['coffee_builder'][$type] = [
                'value' => $value,
                'price' => $price
            ];
            
            // Return updated total
            $total = $this->calculateTotal();
            
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'total' => $total]);
            exit;
        }
    }
      /**
     * Add created coffee to cart
     */
    public function addToCart()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            // Handle JSON request from new DIY interface
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);
            
            if ($data && isset($data['type']) && $data['type'] === 'diy_coffee') {
                $coffeeBuilder = $data['build'];
                $total = floatval($data['total']);
                
                // Create cart item
                $cartItem = [
                    'id' => uniqid('diy_'),
                    'type' => 'diy_coffee',
                    'name' => 'Custom DIY Coffee',
                    'build' => $coffeeBuilder,
                    'price' => $total,
                    'quantity' => 1,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                
                // Add to session cart
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }
                
                $_SESSION['cart'][] = $cartItem;
                
                // Clear the coffee builder session
                unset($_SESSION['coffee_builder']);
                
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Coffee added to cart']);
                exit;
            }
            
            // Fallback for old format
            $coffeeData = $_SESSION['coffee_builder'] ?? [];
            $customName = $_POST['custom_name'] ?? 'Custom Coffee';
            
            // TODO: Add to cart logic for old format
            
            // Clear the coffee builder session
            unset($_SESSION['coffee_builder']);
            
            header('Location: /cart');
            exit;
        }
    }
      /**
     * Direct checkout from studio (bypassing cart)
     */
    public function directCheckout()
    {
        // Set JSON header early
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                
                // Handle JSON request from studio interface
                $input = file_get_contents('php://input');
                $data = json_decode($input, true);
                
                if (!$data) {
                    echo json_encode(['success' => false, 'message' => 'Invalid JSON data']);
                    exit;
                }
                
                if (!isset($data['type'])) {
                    echo json_encode(['success' => false, 'message' => 'Missing order type']);
                    exit;
                }
                
                $total = floatval($data['total'] ?? 0);
                
                if ($total <= 0) {
                    echo json_encode(['success' => false, 'message' => 'Invalid total amount']);
                    exit;
                }                // Create order item based on type
                if ($data['type'] === 'diy_coffee') {
                    $orderItem = [
                        'id' => uniqid('diy_'),
                        'type' => 'diy_coffee',
                        'item_type' => 'diy', // For checkout view compatibility
                        'name' => 'Custom DIY Coffee',
                        'custom_data' => [
                            'name' => 'Custom DIY Coffee',
                            'type' => 'diy_coffee'
                        ],
                        'build' => $data['build'] ?? [],
                        'ingredients' => $data['ingredients'] ?? [],
                        'price' => $total,
                        'subtotal' => $data['subtotal'] ?? 0,
                        'deliveryFee' => $data['deliveryFee'] ?? 50,
                        'vatAmount' => $data['vatAmount'] ?? 0,
                        'quantity' => 1,
                        'created_at' => date('Y-m-d H:i:s')
                    ];                } else if ($data['type'] === 'premade_coffee') {
                    $coffeeName = $data['coffee_name'] ?? 'Premade Coffee';
                    $orderItem = [
                        'id' => uniqid('premade_'),
                        'type' => 'premade_coffee',
                        'item_type' => 'premade', // For checkout view compatibility
                        'name' => $coffeeName,
                        'custom_data' => [
                            'name' => $coffeeName,
                            'type' => 'premade_coffee'
                        ],
                        'build' => $data['build'] ?? [],
                        'price' => $total,
                        'subtotal' => $data['subtotal'] ?? 0,
                        'deliveryFee' => $data['deliveryFee'] ?? 50,
                        'vatAmount' => $data['vatAmount'] ?? 0,
                        'quantity' => 1,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                } else {
                    echo json_encode(['success' => false, 'message' => 'Invalid order type']);
                    exit;
                }
                
                // Store order item in session for checkout
                $_SESSION['direct_checkout_item'] = $orderItem;
                
                // Clear the coffee builder session
                unset($_SESSION['coffee_builder']);
                
                echo json_encode(['success' => true, 'redirect' => '/checkout']);
                exit;
                
            } catch (Exception $e) {
                error_log("Direct checkout error: " . $e->getMessage());
                echo json_encode(['success' => false, 'message' => 'Server error occurred']);
                exit;
            }
        }
        
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        exit;
    }
    
    // ========================================
    // HELPER METHODS
    // ========================================
    
    /**
     * Initialize coffee builder session
     */
    private function initializeSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['coffee_builder'])) {
            $_SESSION['coffee_builder'] = [];
        }
    }
    
    /**
     * Calculate total price
     */
    private function calculateTotal()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $total = 0;
        $items = $_SESSION['coffee_builder'] ?? [];
        
        foreach ($items as $item) {
            $total += $item['price'] ?? 0;
        }
        
        return $total;
    }
      /**
     * Get cup sizes with prices (from database or fallback to hardcoded)
     */
    private function getCupSizes()
    {
        try {
            require_once __DIR__ . '/../config/database.php';
            DatabaseConfig::loadEnvironment();
            $pdo = DatabaseConfig::getConnection();
            
            $sql = "SELECT name, price FROM studio_ingredients WHERE category = 'cup_size' AND is_available = 1 ORDER BY sort_order";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $sizes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (!empty($sizes)) {
                return $sizes;
            }
        } catch (Exception $e) {
            error_log("Database cup sizes retrieval failed: " . $e->getMessage());
        }
        
        // Fallback to hardcoded values
        return [
            ['name' => 'Small (8oz)', 'price' => 0.00],
            ['name' => 'Medium (12oz)', 'price' => 0.50],
            ['name' => 'Large (16oz)', 'price' => 1.00],
            ['name' => 'Extra Large (20oz)', 'price' => 1.50]
        ];
    }
    
    /**
     * Get coffee beans types (from database or fallback to hardcoded)
     */
    private function getCoffeeBeans()
    {
        try {
            require_once __DIR__ . '/../config/database.php';
            DatabaseConfig::loadEnvironment();
            $pdo = DatabaseConfig::getConnection();
            
            $sql = "SELECT name, price FROM studio_ingredients WHERE category = 'coffee_beans' AND is_available = 1 ORDER BY sort_order";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $beans = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (!empty($beans)) {
                return $beans;
            }
        } catch (Exception $e) {
            error_log("Database coffee beans retrieval failed: " . $e->getMessage());
        }
        
        // Fallback to hardcoded values
        return [
            ['name' => 'Arabica', 'price' => 0.00],
            ['name' => 'Robusta', 'price' => 0.25],
            ['name' => 'Colombian', 'price' => 0.50],
            ['name' => 'Ethiopian', 'price' => 0.75],
            ['name' => 'Brazilian', 'price' => 0.50]
        ];
    }
    
    /**
     * Get milk types (from database or fallback to hardcoded)
     */
    private function getMilkTypes()
    {
        try {
            require_once __DIR__ . '/../config/database.php';
            DatabaseConfig::loadEnvironment();
            $pdo = DatabaseConfig::getConnection();
            
            $sql = "SELECT name, price FROM studio_ingredients WHERE category = 'milk_type' AND is_available = 1 ORDER BY sort_order";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $milkTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (!empty($milkTypes)) {
                return $milkTypes;
            }
        } catch (Exception $e) {
            error_log("Database milk types retrieval failed: " . $e->getMessage());
        }
        
        // Fallback to hardcoded values
        return [
            ['name' => 'Whole Milk', 'price' => 0.00],
            ['name' => 'Skim Milk', 'price' => 0.00],
            ['name' => 'Almond Milk', 'price' => 0.50],
            ['name' => 'Soy Milk', 'price' => 0.50],
            ['name' => 'Oat Milk', 'price' => 0.60],
            ['name' => 'Coconut Milk', 'price' => 0.50]
        ];
    }
    
    /**
     * Get sweeteners (from database or fallback to hardcoded)
     */
    private function getSweeteners()
    {
        try {
            require_once __DIR__ . '/../config/database.php';
            DatabaseConfig::loadEnvironment();
            $pdo = DatabaseConfig::getConnection();
            
            $sql = "SELECT name, price FROM studio_ingredients WHERE category = 'sweeteners' AND is_available = 1 ORDER BY sort_order";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $sweeteners = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (!empty($sweeteners)) {
                return $sweeteners;
            }
        } catch (Exception $e) {
            error_log("Database sweeteners retrieval failed: " . $e->getMessage());
        }
        
        // Fallback to hardcoded values
        return [
            ['name' => 'None', 'price' => 0.00],
            ['name' => 'Sugar', 'price' => 0.00],
            ['name' => 'Honey', 'price' => 0.25],
            ['name' => 'Stevia', 'price' => 0.25],
            ['name' => 'Agave', 'price' => 0.30]
        ];
    }
    
    /**
     * Get syrups (from database or fallback to hardcoded)
     */
    private function getSyrups()
    {
        try {
            require_once __DIR__ . '/../config/database.php';
            DatabaseConfig::loadEnvironment();
            $pdo = DatabaseConfig::getConnection();
            
            $sql = "SELECT name, price FROM studio_ingredients WHERE category = 'syrups' AND is_available = 1 ORDER BY sort_order";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $syrups = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (!empty($syrups)) {
                return $syrups;
            }
        } catch (Exception $e) {
            error_log("Database syrups retrieval failed: " . $e->getMessage());
        }
        
        // Fallback to hardcoded values
        return [
            ['name' => 'None', 'price' => 0.00],
            ['name' => 'Vanilla', 'price' => 0.50],
            ['name' => 'Caramel', 'price' => 0.50],
            ['name' => 'Hazelnut', 'price' => 0.50],
            ['name' => 'Cinnamon', 'price' => 0.50],
            ['name' => 'Peppermint', 'price' => 0.60]
        ];
    }
    
    /**
     * Get toppings (from database or fallback to hardcoded)
     */
    private function getToppings()
    {
        try {
            require_once __DIR__ . '/../config/database.php';
            DatabaseConfig::loadEnvironment();
            $pdo = DatabaseConfig::getConnection();
            
            $sql = "SELECT name, price FROM studio_ingredients WHERE category = 'toppings' AND is_available = 1 ORDER BY sort_order";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $toppings = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (!empty($toppings)) {
                return $toppings;
            }
        } catch (Exception $e) {
            error_log("Database toppings retrieval failed: " . $e->getMessage());
        }
        
        // Fallback to hardcoded values
        return [
            ['name' => 'None', 'price' => 0.00],
            ['name' => 'Whipped Cream', 'price' => 0.50],
            ['name' => 'Extra Foam', 'price' => 0.25],
            ['name' => 'Cinnamon Powder', 'price' => 0.25],
            ['name' => 'Chocolate Shavings', 'price' => 0.50],
            ['name' => 'Marshmallows', 'price' => 0.50]
        ];
    }
    
    /**
     * Get pastries (from database or fallback to hardcoded)
     */
    private function getPastries()
    {
        try {
            require_once __DIR__ . '/../config/database.php';
            DatabaseConfig::loadEnvironment();
            $pdo = DatabaseConfig::getConnection();
            
            $sql = "SELECT name, price FROM studio_ingredients WHERE category = 'pastries' AND is_available = 1 ORDER BY sort_order";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $pastries = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (!empty($pastries)) {
                return $pastries;
            }
        } catch (Exception $e) {
            error_log("Database pastries retrieval failed: " . $e->getMessage());
        }
        
        // Fallback to hardcoded values
        return [
            ['name' => 'None', 'price' => 0.00],
            ['name' => 'Croissant', 'price' => 2.50],
            ['name' => 'Muffin', 'price' => 2.00],
            ['name' => 'Danish', 'price' => 2.75],
            ['name' => 'Bagel', 'price' => 1.50],
            ['name' => 'Scone', 'price' => 2.25]
        ];
    }
    
    /**
     * Get premade coffees (from database or fallback to hardcoded)
     */
    private function getPremadeCoffees()
    {
        try {
            require_once __DIR__ . '/../config/database.php';
            DatabaseConfig::loadEnvironment();
            $pdo = DatabaseConfig::getConnection();
            
            $sql = "SELECT name, price FROM studio_ingredients WHERE category = 'premade_coffee' AND is_available = 1 ORDER BY sort_order";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $premadeCoffees = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (!empty($premadeCoffees)) {
                return $premadeCoffees;
            }
        } catch (Exception $e) {
            error_log("Database premade coffees retrieval failed: " . $e->getMessage());
        }
        
        // Fallback to hardcoded values
        return [
            ['name' => 'Americano', 'price' => 3.00],
            ['name' => 'Latte', 'price' => 4.50],
            ['name' => 'Cappuccino', 'price' => 4.00],
            ['name' => 'Mocha', 'price' => 5.00],
            ['name' => 'Macchiato', 'price' => 4.75],
            ['name' => 'Frappuccino', 'price' => 5.50]
        ];
    }
}
