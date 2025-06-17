<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - Order <?= htmlspecialchars($order['id']) ?> - Costobrew</title>
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

<div class="container-fluid px-5 pt-5 main-content">
    <div class="pt-5 pb-3"></div>
    <div class="row justify-content-center w-100">
        <div class="col-lg-8 col-xl-6">
            <div class="receipt-container form-bg p-5 rounded-4 shadow-lg">
                <!-- Success Header -->
                <div class="text-center mb-5">
                    <div class="success-icon mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h1 class="font-garamond size-1 text-dark mb-3">Order Confirmed!</h1>
                    <p class="lead text-muted">Your delicious coffee is being prepared</p>
                </div>

                <!-- Order Information -->
                <div class="order-header bg-white rounded-4 p-4 mb-4 shadow-sm">
                    <div class="row text-center">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="info-item">
                                <i class="bi bi-receipt text-coffee d-block mb-2" style="font-size: 1.5rem;"></i>
                                <h6 class="text-dark mb-1">Order Number</h6>
                                <p class="font-garamond h5 text-coffee mb-0">#<?= htmlspecialchars($order['id']) ?></p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="info-item">
                                <i class="bi bi-clock text-coffee d-block mb-2" style="font-size: 1.5rem;"></i>
                                <h6 class="text-dark mb-1">Order Time</h6>
                                <p class="mb-0"><?= date('M j, Y', strtotime($order['created_at'])) ?></p>
                                <small class="text-muted"><?= date('g:i A', strtotime($order['created_at'])) ?></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <i class="bi bi-person text-coffee d-block mb-2" style="font-size: 1.5rem;"></i>
                                <h6 class="text-dark mb-1">Customer</h6>
                                <p class="mb-0"><?= htmlspecialchars($order['customer']['name']) ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="order-items-section mb-4">
                    <h3 class="font-garamond mb-4 text-dark">Order Details</h3>
                    
                    <?php foreach ($order['items'] as $item): ?>
                        <div class="receipt-item-card bg-white rounded-4 p-4 mb-3 shadow-sm">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="item-details flex-grow-1">
                                    <h5 class="text-dark mb-2"><?= htmlspecialchars($item['custom_data']['name'] ?? 'Custom Coffee') ?></h5>
                                    
                                    <?php if ($item['item_type'] === 'diy' && isset($item['custom_data'])): ?>
                                        <div class="customizations mb-3">
                                            <h6 class="text-muted mb-2">Customizations:</h6>
                                            <div class="customization-list">
                                                <?php foreach ($item['custom_data'] as $key => $value): ?>
                                                    <?php if ($key !== 'name' && $key !== 'type'): ?>
                                                        <span class="badge bg-light text-dark me-2 mb-1">
                                                            <?= htmlspecialchars($key) ?>: <?= htmlspecialchars($value['value'] ?? $value) ?>
                                                        </span>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="badge bg-coffee text-white px-3 py-2">
                                            <?= ucfirst($item['item_type']) ?> Coffee
                                        </span>
                                        <span class="text-muted">
                                            Qty: <?= $item['quantity'] ?> × ₱<?= number_format($item['price'], 2) ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="item-total ms-3">
                                    <h4 class="text-coffee mb-0">₱<?= number_format($item['price'] * $item['quantity'], 2) ?></h4>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Order Totals -->
                <div class="order-totals bg-white rounded-4 p-4 mb-4 shadow-sm">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-dark">Subtotal:</span>
                        <span class="text-dark">₱<?= number_format($order['subtotal'], 2) ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-dark">Tax (12%):</span>
                        <span class="text-dark">₱<?= number_format($order['tax'], 2) ?></span>
                    </div>
                    <div class="d-flex justify-content-between border-top pt-3">
                        <span class="h5 text-dark font-garamond">Total Paid:</span>
                        <span class="h4 text-coffee font-garamond">₱<?= number_format($order['total'], 2) ?></span>
                    </div>
                </div>

                <!-- Delivery Information -->
                <div class="delivery-info bg-white rounded-4 p-4 mb-4 shadow-sm">
                    <h5 class="text-dark mb-3">
                        <i class="bi bi-truck me-2 text-coffee"></i>Delivery Information
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Payment Method:</strong> Cash on Delivery</p>
                            <p class="mb-2"><strong>Phone:</strong> <?= htmlspecialchars($order['customer']['phone']) ?></p>
                            <p class="mb-0"><strong>Email:</strong> <?= htmlspecialchars($order['customer']['email']) ?></p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Delivery Address:</strong></p>
                            <p class="text-muted mb-2"><?= htmlspecialchars($order['customer']['delivery_address'] ?? 'N/A') ?></p>
                            <?php if (!empty($order['customer']['delivery_notes'])): ?>
                                <p class="mb-0"><strong>Special Instructions:</strong></p>
                                <p class="text-muted small"><?= htmlspecialchars($order['customer']['delivery_notes']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Delivery Status -->
                <div class="delivery-status text-center py-4">
                    <div class="status-timeline mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="status-step active">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <small class="d-block mt-1">Order Confirmed</small>
                            </div>
                            <div class="status-line"></div>
                            <div class="status-step">
                                <i class="bi bi-cup-hot text-coffee"></i>
                                <small class="d-block mt-1">Preparing</small>
                            </div>
                            <div class="status-line"></div>
                            <div class="status-step">
                                <i class="bi bi-truck text-muted"></i>
                                <small class="d-block mt-1">On the Way</small>
                            </div>
                            <div class="status-line"></div>
                            <div class="status-step">
                                <i class="bi bi-house text-muted"></i>
                                <small class="d-block mt-1">Delivered</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="estimated-delivery mb-4">
                        <h5 class="text-coffee font-garamond">Estimated Delivery</h5>
                        <p class="text-dark h4 mb-1">30-45 minutes</p>
                        <p class="text-muted">We'll call you when your order is on the way!</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="receipt-actions text-center">
                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                        <a href="/menu" class="btn btn-outline-dark rounded-pill px-4 py-2">
                            <i class="bi bi-arrow-repeat me-2"></i>Order Again
                        </a>
                        <a href="/studio" class="btn btn-coffee rounded-pill px-4 py-2">
                            <i class="bi bi-cup-hot me-2"></i>Coffee Studio
                        </a>
                        <button onclick="window.print()" class="btn btn-outline-dark rounded-pill px-4 py-2">
                            <i class="bi bi-printer me-2"></i>Print Receipt
                        </button>
                    </div>
                </div>

                <!-- You Might Like Section -->
                <?php if (!empty($recommendations)): ?>
                    <div class="recommendations-section mt-5 pt-4 border-top">
                        <h4 class="font-garamond text-dark mb-4 text-center">You Might Also Like</h4>
                        <div class="row g-3">
                            <?php foreach (array_slice($recommendations, 0, 3) as $rec): ?>
                                <div class="col-md-4">
                                    <div class="recommendation-card bg-white rounded-3 p-3 text-center shadow-sm">
                                        <i class="bi bi-cup-hot text-coffee mb-2" style="font-size: 2rem;"></i>
                                        <h6 class="text-dark"><?= htmlspecialchars($rec['name']) ?></h6>
                                        <p class="text-coffee fw-bold">₱<?= number_format($rec['price'], 2) ?></p>
                                        <a href="<?= htmlspecialchars($rec['url']) ?>" class="btn btn-sm btn-coffee rounded-pill">Try It</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
@media print {
    .navbar, .footer, .receipt-actions, .recommendations-section {
        display: none !important;
    }
    
    body {
        background: white !important;
    }
    
    .form-bg {
        background: white !important;
        box-shadow: none !important;
    }
}

.status-timeline {
    position: relative;
}

.status-step {
    flex: 1;
    text-align: center;
    position: relative;
    z-index: 2;
}

.status-step i {
    font-size: 1.5rem;
    background: white;
    padding: 0.5rem;
    border-radius: 50%;
}

.status-line {
    height: 2px;
    background: #dee2e6;
    flex: 1;
    margin: 0 1rem;
    margin-top: 1.5rem;
    position: relative;
    z-index: 1;
}

.status-step.active .status-line {
    background: #8B4513;
}
</style>
</body>
</html>
