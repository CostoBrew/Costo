<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Costobrew</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/src/css/style.css" rel="stylesheet">
</head>
<body data-bs-theme="dark" class="d-flex flex-column min-vh-100">
<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="container my-5 flex-grow-1">
    <div class="checkout-container">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="mb-3">
                    <i class="bi bi-credit-card me-2"></i>Checkout
                </h1>
            </div>
        </div>
        
        <div class="checkout-content">
            <div class="order-summary">
                <h2>Order Summary</h2>
                
                <div class="order-items">
                    <?php if (empty($cartItems)): ?>
                        <div class="empty-cart">
                            <p>No items in your order. <a href="/menu">Browse our menu</a> or visit the <a href="/studio">Coffee Studio</a>.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($cartItems as $item): ?>
                        <div class="checkout-item">
                            <div class="item-info">
                                <?php
                                // Get item name with fallbacks
                                $itemName = 'Custom Coffee';
                                if (isset($item['custom_data']['name'])) {
                                    $itemName = $item['custom_data']['name'];
                                } elseif (isset($item['name'])) {
                                    $itemName = $item['name'];
                                }
                                
                                // Get item type with fallbacks
                                $itemType = 'Custom';
                                if (isset($item['item_type'])) {
                                    $itemType = ucfirst($item['item_type']);
                                } elseif (isset($item['type'])) {
                                    $type = $item['type'];
                                    if (strpos($type, 'diy') !== false) {
                                        $itemType = 'DIY';
                                    } elseif (strpos($type, 'premade') !== false) {
                                        $itemType = 'Premade';
                                    } else {
                                        $itemType = ucfirst($type);
                                    }
                                }
                                ?>
                                <h4><?= htmlspecialchars($itemName) ?></h4>
                                <p class="item-type"><?= htmlspecialchars($itemType) ?> Coffee</p>
                                <p class="quantity">Quantity: <?= intval($item['quantity'] ?? 1) ?></p>
                            </div>
                            <div class="item-total">
                                $<?= number_format(floatval($item['price'] ?? 0) * intval($item['quantity'] ?? 1), 2) ?>
                            </div>
                        </div>                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                  <div class="order-totals">
                    <?php if (!empty($cartItems)): ?>
                        <div class="total-row">
                            <span>Subtotal:</span>
                            <span>$<?= number_format($cartTotal ?? 0, 2) ?></span>
                        </div>
                        <div class="total-row">
                            <span>Tax (8%):</span>
                            <span>$<?= number_format($taxes ?? 0, 2) ?></span>
                        </div>
                        <div class="total-row final">
                            <span><strong>Total:</strong></span>
                            <span><strong>$<?= number_format($finalTotal ?? 0, 2) ?></strong></span>
                        </div>
                    <?php else: ?>
                        <div class="total-row final">
                            <span><strong>Total:</strong></span>
                            <span><strong>$0.00</strong></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
              <div class="checkout-form">
                <?php if (!empty($cartItems)): ?>
                    <form action="/checkout/process" method="POST">
                <?php else: ?>
                    <div class="disabled-form">
                        <p class="text-muted">Add items to your cart to proceed with checkout.</p>
                    </div>
                    <form action="/checkout/process" method="POST" style="display: none;">
                <?php endif; ?>
                    <div class="form-section">
                        <h3>Customer Information</h3>
                        
                        <div class="form-group">
                            <label for="customer_name">Full Name:</label>
                            <input type="text" id="customer_name" name="customer_name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="customer_email">Email:</label>
                            <input type="email" id="customer_email" name="customer_email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="customer_phone">Phone:</label>
                            <input type="tel" id="customer_phone" name="customer_phone">
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h3>Payment Information</h3>
                        
                        <div class="payment-methods">
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="cash" checked>
                                <span>Cash Payment</span>
                            </label>
                            
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="card">
                                <span>Credit/Debit Card</span>
                            </label>
                        </div>
                        
                        <div class="card-details" style="display: none;">
                            <div class="form-group">
                                <label for="card_number">Card Number:</label>
                                <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456">
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="card_expiry">Expiry Date:</label>
                                    <input type="text" id="card_expiry" name="card_expiry" placeholder="MM/YY">
                                </div>
                                
                                <div class="form-group">
                                    <label for="card_cvv">CVV:</label>
                                    <input type="text" id="card_cvv" name="card_cvv" placeholder="123">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h3>Order Type</h3>
                        
                        <div class="order-type-options">
                            <label class="order-option">
                                <input type="radio" name="order_type" value="pickup" checked>
                                <span>Pickup</span>
                            </label>
                            
                            <label class="order-option">
                                <input type="radio" name="order_type" value="dine_in">
                                <span>Dine In</span>
                            </label>
                        </div>
                    </div>
                    
                    <?php if (isset($errorMessage)): ?>
                        <div class="error-message">
                            <?= htmlspecialchars($errorMessage) ?>
                        </div>
                    <?php endif; ?>
                      <div class="checkout-actions">
                        <?php if (isset($_SESSION['direct_checkout_item'])): ?>
                            <a href="/studio" class="btn-secondary">Back to Studio</a>
                        <?php else: ?>
                            <a href="/cart" class="btn-secondary">Back to Cart</a>
                        <?php endif; ?>
                        <?php if (!empty($cartItems)): ?>
                            <button type="submit" class="btn-primary">Complete Order</button>
                        <?php else: ?>
                            <button type="button" class="btn-primary" disabled>No Items to Order</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
            const cardDetails = document.querySelector('.card-details');
            
            paymentMethods.forEach(method => {
                method.addEventListener('change', function() {
                    if (this.value === 'card') {                        cardDetails.style.display = 'block';
                        cardDetails.querySelectorAll('input').forEach(input => input.required = true);
                    } else {
                        cardDetails.style.display = 'none';
                        cardDetails.querySelectorAll('input').forEach(input => input.required = false);
                    }
                });
            });
        });
    </script>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
