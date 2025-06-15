<?php

/**
 * Coffee Studio Controller
 * Handles DIY Coffee (8 stages) and Premade Coffee (3 stages) with POS-like counter
 */

class CoffeeStudioController
{
    /**
     * Coffee Studio main page (selector between DIY and Premade)
     */
    public function index()
    {
        require_once __DIR__ . '/../view/studio/index.php';
    }
    
    // ========================================
    // DIY COFFEE - 8 STAGES
    // ========================================
    
    /**
     * Start DIY coffee creation
     */
    public function diyStart()
    {
        $this->initializeSession();
        require_once __DIR__ . '/../view/studio/diy/start.php';
    }
    
    /**
     * Stage 1: Coffee info page
     */
    public function diyInfo()
    {
        require_once __DIR__ . '/../view/studio/diy/info.php';
    }
    
    /**
     * Stage 2: Cup Size selection
     */
    public function diyCupSize()
    {
        $cupSizes = $this->getCupSizes();
        require_once __DIR__ . '/../view/studio/diy/cup-size.php';
    }
    
    /**
     * Stage 3: Coffee beans type
     */
    public function diyCoffeeBeans()
    {
        $coffeeBeans = $this->getCoffeeBeans();
        require_once __DIR__ . '/../view/studio/diy/coffee-beans.php';
    }
    
    /**
     * Stage 4: Milk Type
     */
    public function diyMilkType()
    {
        $milkTypes = $this->getMilkTypes();
        require_once __DIR__ . '/../view/studio/diy/milk-type.php';
    }
    
    /**
     * Stage 5: Sweeteners Type
     */
    public function diySweeteners()
    {
        $sweeteners = $this->getSweeteners();
        require_once __DIR__ . '/../view/studio/diy/sweeteners.php';
    }
    
    /**
     * Stage 6: Syrups / Flavored Syrups
     */
    public function diySyrups()
    {
        $syrups = $this->getSyrups();
        require_once __DIR__ . '/../view/studio/diy/syrups.php';
    }
    
    /**
     * Stage 7: Toppings
     */
    public function diyToppings()
    {
        $toppings = $this->getToppings();
        require_once __DIR__ . '/../view/studio/diy/toppings.php';
    }
    
    /**
     * Stage 8: Pastry
     */
    public function diyPastry()
    {
        $pastries = $this->getPastries();
        require_once __DIR__ . '/../view/studio/diy/pastry.php';
    }
    
    // ========================================
    // PREMADE COFFEE - 3 STAGES
    // ========================================
    
    /**
     * Start Premade coffee selection
     */
    public function premadeStart()
    {
        $this->initializeSession();
        require_once __DIR__ . '/../view/studio/premade/start.php';
    }
    
    /**
     * Stage 1: Cup Size
     */
    public function premadeCupSize()
    {
        $cupSizes = $this->getCupSizes();
        require_once __DIR__ . '/../view/studio/premade/cup-size.php';
    }
    
    /**
     * Stage 2: Coffee selection
     */
    public function premadeCoffee()
    {
        $premadeCoffees = $this->getPremadeCoffees();
        require_once __DIR__ . '/../view/studio/premade/coffee.php';
    }
    
    /**
     * Stage 3: Pastry
     */
    public function premadePastry()
    {
        $pastries = $this->getPastries();
        require_once __DIR__ . '/../view/studio/premade/pastry.php';
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
            
            $coffeeData = $_SESSION['coffee_builder'] ?? [];
            $customName = $_POST['custom_name'] ?? 'Custom Coffee';
            
            // TODO: Add to cart logic
            
            // Clear the coffee builder session
            unset($_SESSION['coffee_builder']);
            
            header('Location: /cart');
            exit;
        }
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
     * Get cup sizes with prices
     */
    private function getCupSizes()
    {
        return [
            ['name' => 'Small (8oz)', 'price' => 0.00],
            ['name' => 'Medium (12oz)', 'price' => 0.50],
            ['name' => 'Large (16oz)', 'price' => 1.00],
            ['name' => 'Extra Large (20oz)', 'price' => 1.50]
        ];
    }
    
    /**
     * Get coffee beans types
     */
    private function getCoffeeBeans()
    {
        return [
            ['name' => 'Arabica', 'price' => 0.00],
            ['name' => 'Robusta', 'price' => 0.25],
            ['name' => 'Colombian', 'price' => 0.50],
            ['name' => 'Ethiopian', 'price' => 0.75],
            ['name' => 'Brazilian', 'price' => 0.50]
        ];
    }
    
    /**
     * Get milk types
     */
    private function getMilkTypes()
    {
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
     * Get sweeteners
     */
    private function getSweeteners()
    {
        return [
            ['name' => 'None', 'price' => 0.00],
            ['name' => 'Sugar', 'price' => 0.00],
            ['name' => 'Honey', 'price' => 0.25],
            ['name' => 'Stevia', 'price' => 0.25],
            ['name' => 'Agave', 'price' => 0.30]
        ];
    }
    
    /**
     * Get syrups
     */
    private function getSyrups()
    {
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
     * Get toppings
     */
    private function getToppings()
    {
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
     * Get pastries
     */
    private function getPastries()
    {
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
     * Get premade coffees
     */
    private function getPremadeCoffees()
    {
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
