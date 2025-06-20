<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Costobrew</title>
    <!-- Load fonts first -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@160..700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/src/css/style.css" rel="stylesheet">
</head>
<body data-bs-theme="dark" class="d-flex flex-column min-vh-100 text-dark mainbg">
<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="container py-4">
    <div class="pt-5 mt-5"></div>
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <div class="form-bg p-4 rounded-4 shadow-lg">
                <div class="text-dark mb-3">
                    <h1 class="font-garamond size-1 mb-2">
                        <i class="bi bi-credit-card me-3"></i>Checkout
                    </h1>
                    <p class="lead mb-0">Review your order and confirm delivery details</p>
                </div>            <!-- Order Summary Section -->
            <div class="order-summary-section mb-4">
                <h3 class="font-garamond mb-3 text-dark">Order Summary</h3>
                
                <?php if (empty($cartItems)): ?>
                    <div class="empty-cart-state text-center py-4">
                        <i class="bi bi-cup-hot" style="font-size: 3rem; color: #8B4513; opacity: 0.5;"></i>
                        <h4 class="mt-3 text-dark">No items in your order</h4>
                        <p class="text-muted mb-3">Start building your perfect coffee experience</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="/menu" class="btn btn-coffee rounded-pill">Browse Menu</a>
                            <a href="/studio" class="btn btn-outline-dark rounded-pill">Coffee Studio</a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="order-items-list">
                        <?php foreach ($cartItems as $item): ?>
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
                            ?>                            <div class="checkout-item-card bg-white rounded-4 p-3 mb-2 shadow-sm">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="item-details flex-grow-1">
                                        <h5 class="text-dark mb-2"><?= htmlspecialchars($itemName) ?></h5>
                                        
                                        <?php if (isset($item['ingredients']) && !empty($item['ingredients'])): ?>
                                            <div class="ingredients-list mb-3">
                                                <h6 class="text-muted mb-2">Your Selections:</h6>
                                                <div class="ingredient-badges">
                                                    <?php foreach ($item['ingredients'] as $ingredient): ?>
                                                        <span class="badge bg-light text-dark me-2 mb-1">
                                                            <strong><?= ucfirst($ingredient['category']) ?>:</strong> 
                                                            <?= htmlspecialchars($ingredient['name']) ?>
                                                            <?php if ($ingredient['price'] > 0): ?>
                                                                (+₱<?= number_format($ingredient['price'], 2) ?>)
                                                            <?php endif; ?>
                                                        </span>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="badge bg-coffee text-white px-3 py-2"><?= htmlspecialchars($itemType) ?> Coffee</span>
                                            <span class="text-muted">Qty: <?= intval($item['quantity'] ?? 1) ?></span>
                                        </div>
                                    </div>
                                    <div class="item-price ms-3">
                                        <h4 class="text-coffee mb-0">₱<?= number_format(floatval($item['price'] ?? 0) * intval($item['quantity'] ?? 1), 2) ?></h4>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>                    <!-- Order Totals -->
                    <div class="order-totals bg-white rounded-4 p-3 mt-3">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-dark">Subtotal:</span>
                            <span class="text-dark">₱<?= number_format($cartTotal ?? 0, 2) ?></span>
                        </div>                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-dark">Delivery Fee:</span>
                            <span class="text-dark">₱<?= number_format($deliveryFee ?? 50, 2) ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-dark">VAT (12%):</span>
                            <span class="text-dark">₱<?= number_format($taxes ?? 0, 2) ?></span>
                        </div>
                        <div class="d-flex justify-content-between border-top pt-3">
                            <span class="h5 text-dark font-garamond">Total:</span>
                            <span class="h4 text-coffee font-garamond">₱<?= number_format($finalTotal ?? 0, 2) ?></span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Customer Information Form -->            <?php if (!empty($cartItems)): ?>
                <form action="/checkout/process" method="POST" class="checkout-form">
                    <?php 
                    // Generate CSRF token
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    if (!isset($_SESSION['csrf_token'])) {
                        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                    }
                    ?>
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    
                    <div class="customer-info-section">
                        <h3 class="font-garamond mb-3 text-dark">Delivery Information</h3>
                        <p class="text-muted mb-3">
                            <i class="bi bi-info-circle me-2"></i>
                            Currently using guest checkout. Customer information from user settings will be available after implementation.
                        </p>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="customer_name" class="form-label text-dark fw-semibold">Full Name *</label>
                                <input type="text" class="form-control rounded-3 border-2" 
                                       id="customer_name" name="customer_name" required 
                                       placeholder="Enter your full name">
                            </div>
                            <div class="col-md-6">
                                <label for="customer_phone" class="form-label text-dark fw-semibold">Phone Number *</label>
                                <input type="tel" class="form-control rounded-3 border-2" 
                                       id="customer_phone" name="customer_phone" required 
                                       placeholder="+63 9XX XXX XXXX">
                            </div>
                            <div class="col-12">
                                <label for="customer_email" class="form-label text-dark fw-semibold">Email Address *</label>
                                <input type="email" class="form-control rounded-3 border-2" 
                                       id="customer_email" name="customer_email" required 
                                       placeholder="your.email@example.com">
                            </div>
                            <div class="col-12">
                                <label for="delivery_address" class="form-label text-dark fw-semibold">Delivery Address *</label>
                                <textarea class="form-control rounded-3 border-2" 
                                          id="delivery_address" name="delivery_address" rows="2" required 
                                          placeholder="Enter complete delivery address with landmarks"></textarea>
                            </div>
                            <div class="col-12">
                                <label for="delivery_notes" class="form-label text-dark fw-semibold">Special Instructions</label>
                                <textarea class="form-control rounded-3 border-2" 
                                          id="delivery_notes" name="delivery_notes" rows="2" 
                                          placeholder="Any special delivery instructions (optional)"></textarea>
                            </div>
                        </div>
                    </div>                    <!-- Order Summary -->
                    <div class="order-summary-footer mt-4 pt-3 border-top">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                            <div class="order-info">
                                <p class="mb-1 text-dark">
                                    <i class="bi bi-truck me-2 text-coffee"></i>
                                    <strong>Cash on Delivery</strong> • Delivery within 30-45 minutes
                                </p>
                                <p class="mb-0 text-muted small">
                                    <i class="bi bi-shield-check me-2"></i>
                                    Your order is secure and will be freshly prepared
                                </p>
                            </div>
                            <div class="order-actions d-flex gap-3">
                                <?php if (isset($_SESSION['direct_checkout_item'])): ?>
                                    <a href="/studio" class="btn btn-outline-dark rounded-pill px-4 py-2">
                                        <i class="bi bi-arrow-left me-2"></i>Back to Studio
                                    </a>
                                <?php else: ?>
                                    <a href="/cart" class="btn btn-outline-dark rounded-pill px-4 py-2">
                                        <i class="bi bi-arrow-left me-2"></i>Back to Cart
                                    </a>
                                <?php endif; ?>
                                <button type="submit" class="btn btn-coffee rounded-pill px-5 py-2">
                                    <i class="bi bi-check-circle me-2"></i>Complete Order
                                </button>
                            </div>
                        </div>
                    </div>                    <?php if (isset($errorMessage)): ?>
                        <div class="alert alert-danger rounded-4 mt-3">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <?= htmlspecialchars($errorMessage) ?>
                        </div>
                    <?php endif; ?>
                </form>
            <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
