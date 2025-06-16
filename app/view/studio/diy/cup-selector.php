<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIY Coffee - Stage 2: Cup Size - Costobrew</title>
</head>
<body>
    <div class="studio-container">
        <div class="progress-bar">
            <div class="progress-step completed">1. Info</div>
            <div class="progress-step active">2. Cup Size</div>
            <div class="progress-step">3. Coffee Beans</div>
            <div class="progress-step">4. Milk Type</div>
            <div class="progress-step">5. Sweeteners</div>
            <div class="progress-step">6. Syrups</div>
            <div class="progress-step">7. Toppings</div>
            <div class="progress-step">8. Pastry</div>
        </div>
        
        <div class="stage-content">
            <h1>Choose Your Cup Size</h1>
            <p>Select the perfect size for your coffee creation</p>
            
            <div class="options-grid">
                <?php foreach ($cupSizes as $size): ?>
                    <div class="option-card" data-option="cup_size" data-value="<?= htmlspecialchars($size['name']) ?>" data-price="<?= $size['price'] ?>">
                        <div class="option-image">
                            <!-- Cup size image would go here -->
                            <div class="cup-icon">☕</div>
                        </div>
                        <h3><?= htmlspecialchars($size['name']) ?></h3>
                        <p class="option-price">
                            <?php if ($size['price'] > 0): ?>
                                +$<?= number_format($size['price'], 2) ?>
                            <?php else: ?>
                                Included
                            <?php endif; ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="pos-counter">
            <h3>Order Summary</h3>
            <div class="order-items">
                <div class="base-item">
                    <span>Base Coffee</span>
                    <span>$3.00</span>
                </div>
            </div>
            <div class="order-total">
                <strong>Total: $<span id="total">3.00</span></strong>
            </div>
        </div>
        
        <div class="navigation">
            <a href="/studio/diy/info" class="btn-back">← Previous</a>
            <a href="/studio/diy/coffee-beans" class="btn-next">Next →</a>
        </div>
    </div>
    
    <script>
        // JavaScript for POS counter functionality
        document.addEventListener('DOMContentLoaded', function() {
            const options = document.querySelectorAll('.option-card');
            let currentTotal = 3.00;
            
            options.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove active class from all options of this type
                    const optionType = this.dataset.option;
                    document.querySelectorAll(`[data-option="${optionType}"]`).forEach(o => o.classList.remove('active'));
                    
                    // Add active class to selected option
                    this.classList.add('active');
                    
                    // Update total (simplified - would need to track all selections)
                    const price = parseFloat(this.dataset.price);
                    // Update total calculation logic here
                    
                    document.getElementById('total').textContent = currentTotal.toFixed(2);
                });
            });
        });
    </script>
</body>
</html>
