<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Costobrew</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/src/css/style.css" rel="stylesheet">
</head>
<body data-bs-theme="dark" class="d-flex flex-column min-vh-100">
<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="container my-5 flex-grow-1">
    <div class="cart-container">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="mb-3">
                    <i class="bi bi-cart me-2"></i>Your Shopping Cart
                </h1>
            </div>
        </div>
        
        <?php if (!empty($cartItems)): ?>
            <div class="cart-items">
                <?php foreach ($cartItems as $item): ?>
                    <div class="cart-item" data-item-id="<?= $item['id'] ?>">
                        <div class="item-details">
                            <h3><?= htmlspecialchars($item['custom_data']['name'] ?? 'Custom Coffee') ?></h3>
                            
                            <?php if ($item['item_type'] === 'diy'): ?>
                                <div class="customizations">
                                    <p><strong>Customizations:</strong></p>
                                    <ul>
                                        <?php foreach ($item['custom_data'] as $key => $value): ?>
                                            <?php if ($key !== 'name'): ?>
                                                <li><?= htmlspecialchars($key) ?>: <?= htmlspecialchars($value['value'] ?? $value) ?></li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            
                            <p class="item-type"><?= ucfirst($item['item_type']) ?> Coffee</p>
                        </div>
                        
                        <div class="item-quantity">
                            <button class="qty-btn" data-action="decrease">-</button>
                            <input type="number" class="qty-input" value="<?= $item['quantity'] ?>" min="1">
                            <button class="qty-btn" data-action="increase">+</button>
                        </div>
                        
                        <div class="item-price">
                            <span class="unit-price">$<?= number_format($item['price'], 2) ?></span>
                            <span class="total-price">$<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                        </div>
                        
                        <div class="item-actions">
                            <button class="remove-item" data-item-id="<?= $item['id'] ?>">Remove</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="cart-summary">
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span>$<?= number_format($cartTotal, 2) ?></span>
                </div>
                <div class="summary-row">
                    <span>Tax (8%):</span>
                    <span>$<?= number_format($cartTotal * 0.08, 2) ?></span>
                </div>
                <div class="summary-row total">
                    <span><strong>Total:</strong></span>
                    <span><strong>$<?= number_format($cartTotal * 1.08, 2) ?></strong></span>
                </div>
            </div>
            
            <div class="cart-actions">
                <a href="/studio" class="btn-secondary">Continue Shopping</a>
                <a href="/checkout" class="btn-primary">Proceed to Checkout</a>
            </div>
            
        <?php else: ?>
            <div class="empty-cart">
                <h2>Your cart is empty</h2>
                <p>Start creating your perfect coffee in our Coffee Studio!</p>
                <a href="/studio" class="btn-primary">Go to Coffee Studio</a>
            </div>
        <?php endif; ?>
    </div>
    
    <script>
        // Cart functionality JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            // Quantity update handlers
            document.querySelectorAll('.qty-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const action = this.dataset.action;
                    const qtyInput = this.parentNode.querySelector('.qty-input');
                    let currentQty = parseInt(qtyInput.value);
                    
                    if (action === 'increase') {
                        qtyInput.value = currentQty + 1;
                    } else if (action === 'decrease' && currentQty > 1) {
                        qtyInput.value = currentQty - 1;
                    }
                    
                    // Update cart via AJAX
                    updateCartItem(this.closest('.cart-item').dataset.itemId, qtyInput.value);
                });
            });
            
            // Remove item handlers
            document.querySelectorAll('.remove-item').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (confirm('Remove this item from your cart?')) {
                        removeCartItem(this.dataset.itemId);
                    }
                });
            });
        });
          function updateCartItem(itemId, quantity) {
            // AJAX call to update cart
            console.log('Updating item', itemId, 'to quantity', quantity);
        }
        
        function removeCartItem(itemId) {
            // AJAX call to remove item
            console.log('Removing item', itemId);
        }
    </script>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
