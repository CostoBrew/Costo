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

<div class="container-fluid px-4 pt-5 main-content">
    <div class="pt-5 pb-3"></div>
    <!-- Widescreen Layout -->
    <div class="row g-4 w-100">
        <!-- Left Column - Order Details -->
        <div class="col-lg-8">
            <div class="receipt-container form-bg p-4 rounded-4 shadow-lg h-100">
                <!-- Success Header -->
                <div class="text-center mb-4">
                    <div class="success-icon mb-3">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h1 class="font-garamond size-1 text-dark mb-2">Order Confirmed!</h1>
                    <p class="lead text-muted mb-0">Your delicious coffee is being prepared</p>
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
                        </div>                        <div class="col-md-4">
                            <div class="info-item">
                                <i class="bi bi-person text-coffee d-block mb-2" style="font-size: 1.5rem;"></i>
                                <h6 class="text-dark mb-1">Customer</h6>
                                <p class="mb-0"><?= htmlspecialchars($order['customer_name'] ?? 'Guest') ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="order-items-section mb-4">
                    <h3 class="font-garamond mb-4 text-dark">Order Details</h3>
                    
                    <?php foreach ($order['items'] as $item): ?>                        <div class="receipt-item-card bg-white rounded-4 p-4 mb-3 shadow-sm">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="item-details flex-grow-1">
                                    <h5 class="text-dark mb-2"><?= htmlspecialchars($item['item_name'] ?? 'Custom Coffee') ?></h5>
                                    
                                    <?php if ($item['item_type'] === 'diy' && isset($item['customization_data'])): ?>
                                        <div class="customizations mb-3">
                                            <h6 class="text-muted mb-2">Customizations:</h6>
                                            <div class="customization-list">
                                                <?php foreach ($item['customization_data'] as $key => $value): ?>
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
                                        </span>                                        <span class="text-muted">
                                            Qty: <?= $item['quantity'] ?> × ₱<?= number_format($item['unit_price'] ?? $item['price'] ?? 0, 2) ?>
                                        </span>
                                    </div>
                                </div>
                                  <div class="item-total ms-3">
                                    <h4 class="text-coffee mb-0">₱<?= number_format($item['total_price'] ?? (($item['unit_price'] ?? $item['price'] ?? 0) * $item['quantity']), 2) ?></h4>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>                <!-- Order Totals -->
                <div class="order-totals bg-white rounded-4 p-4 mb-4 shadow-sm">                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-dark">Subtotal:</span>
                        <span class="text-dark">₱<?= number_format($order['subtotal'] ?? 0, 2) ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-dark">Delivery Fee:</span>
                        <span class="text-dark">₱50.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-dark">VAT (12%):</span>
                        <span class="text-dark">₱<?= number_format($order['tax_amount'] ?? 0, 2) ?></span>
                    </div>
                    <div class="d-flex justify-content-between border-top pt-3">
                        <span class="h5 text-dark font-garamond">Total Paid:</span>
                        <span class="h4 text-coffee font-garamond">₱<?= number_format($order['total_amount'] ?? 0, 2) ?></span>
                    </div>                </div>

                <!-- Delivery Information -->
                <div class="delivery-info bg-white rounded-4 p-4 mb-4 shadow-sm">
                    <h5 class="text-dark mb-3">
                        <i class="bi bi-truck me-2 text-coffee"></i>Delivery Information
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Payment Method:</strong> Cash on Delivery</p>
                            <p class="mb-2"><strong>Phone:</strong> <?= htmlspecialchars($order['customer_phone'] ?? 'N/A') ?></p>
                            <p class="mb-0"><strong>Email:</strong> <?= htmlspecialchars($order['customer_email'] ?? 'N/A') ?></p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Delivery Address:</strong></p>
                            <p class="text-muted mb-2"><?= htmlspecialchars($order['delivery_address'] ?? 'N/A') ?></p>
                            <?php if (!empty($order['special_instructions'])): ?>
                                <p class="mb-0"><strong>Special Instructions:</strong></p>
                                <p class="text-muted small"><?= htmlspecialchars($order['special_instructions']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div></div>
        </div>
          <!-- Right Column - Summary & Actions -->
        <div class="col-lg-4">
            <div class="sidebar-content">                <!-- Quick Actions Card - Priority Position -->
                <div class="actions-card form-bg p-3 rounded-4 shadow-lg mb-3">
                    <h6 class="text-dark mb-2">
                        <i class="bi bi-lightning-charge me-2 text-coffee"></i>Quick Actions
                    </h6>
                    <div class="d-grid gap-2">
                        <a href="/menu" class="btn btn-outline-dark rounded-pill btn-sm">
                            <i class="bi bi-arrow-repeat me-2"></i>Order Again
                        </a>
                        <a href="/studio" class="btn btn-coffee rounded-pill btn-sm">
                            <i class="bi bi-cup-hot me-2"></i>Coffee Studio
                        </a>
                        <button onclick="window.print()" class="btn btn-outline-dark rounded-pill btn-sm">
                            <i class="bi bi-printer me-2"></i>Print Receipt
                        </button>
                    </div>
                </div>                <!-- Quick Summary Card -->
                <div class="summary-card form-bg p-3 rounded-4 shadow-lg mb-3">
                    <h6 class="font-garamond text-dark mb-2">
                        <i class="bi bi-receipt me-2 text-coffee"></i>Order Summary
                    </h6>
                    <div class="order-quick-info">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted small">Order #</span>
                            <span class="text-dark fw-bold small"><?= htmlspecialchars($order['id']) ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted small">Items</span>
                            <span class="text-dark small"><?= count($order['items']) ?> item<?= count($order['items']) !== 1 ? 's' : '' ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Status</span>
                            <span class="badge bg-success badge-sm">Confirmed</span>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between">
                            <span class="text-dark fw-bold">Total Paid</span>
                            <span class="h6 text-coffee fw-bold">₱<?= number_format($order['total_amount'] ?? 0, 2) ?></span>
                        </div>
                    </div>
                </div>                <!-- Delivery Tracking Card -->
                <div class="tracking-card form-bg p-3 rounded-4 shadow-lg mb-3">
                    <h6 class="text-dark mb-2">
                        <i class="bi bi-truck me-2 text-coffee"></i>Delivery Tracking
                    </h6>
                    <div class="delivery-progress mb-2">
                        <div class="progress-step active mb-1">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <span class="small">Order Confirmed</span>
                        </div>
                        <div class="progress-step current mb-1">
                            <i class="bi bi-cup-hot text-coffee me-2"></i>
                            <span class="small">Preparing Your Order</span>
                        </div>
                        <div class="progress-step mb-1">
                            <i class="bi bi-truck text-muted me-2"></i>
                            <span class="small text-muted">On the Way</span>
                        </div>
                        <div class="progress-step">
                            <i class="bi bi-house text-muted me-2"></i>
                            <span class="small text-muted">Delivered</span>
                        </div>
                    </div>
                    <div class="delivery-estimate text-center p-2 bg-white rounded-3">
                        <h6 class="text-coffee mb-1 small">Estimated Delivery</h6>
                        <p class="h6 text-dark mb-0">30-45 minutes</p>
                        <small class="text-muted">We'll call you when ready!</small>
                    </div>
                </div>                <!-- You Might Like Section -->
                <?php if (!empty($recommendations)): ?>
                    <div class="recommendations-card form-bg p-3 rounded-4 shadow-lg">
                        <h6 class="text-dark mb-2">
                            <i class="bi bi-heart me-2 text-coffee"></i>You Might Like
                        </h6>
                        <div class="recommendation-list">
                            <?php foreach (array_slice($recommendations, 0, 2) as $rec): ?>
                                <div class="recommendation-item bg-white rounded-3 p-2 mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-cup-hot text-coffee me-2" style="font-size: 1.2rem;"></i>
                                        <div class="flex-grow-1">
                                            <h6 class="text-dark mb-0 small"><?= htmlspecialchars($rec['name']) ?></h6>
                                            <p class="text-coffee fw-bold mb-0 small">₱<?= number_format($rec['price'], 2) ?></p>
                                        </div>
                                        <a href="<?= htmlspecialchars($rec['url']) ?>" class="btn btn-sm btn-outline-coffee rounded-pill px-2 py-1">
                                            <small>Try</small>
                                        </a>
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
/* Widescreen Receipt Layout */
.sidebar-content {
    position: sticky;
    top: 100px;
}

/* Make quick actions more prominent */
.actions-card {
    border: 2px solid #8B4513 !important;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%) !important;
}

.actions-card h5 {
    color: #8B4513 !important;
    font-weight: 600;
}

.progress-step {
    display: flex;
    align-items: center;
    padding: 0.5rem 0;
    border-left: 2px solid #dee2e6;
    padding-left: 1rem;
    margin-left: 0.5rem;
}

.progress-step.active {
    border-left-color: #28a745;
}

.progress-step.current {
    border-left-color: #8B4513;
    background-color: rgba(139, 69, 19, 0.1);
    border-radius: 0.25rem;
    margin-left: 0;
    padding-left: 1.5rem;
}

.recommendation-item:last-child {
    margin-bottom: 0 !important;
}

.btn-outline-coffee {
    border-color: #8B4513;
    color: #8B4513;
}

.btn-outline-coffee:hover {
    background-color: #8B4513;
    border-color: #8B4513;
    color: white;
}

/* Responsive adjustments */
@media (max-width: 991.98px) {
    .sidebar-content {
        position: static;
        margin-top: 2rem;
    }
    
    .progress-step {
        padding: 0.25rem 0;
    }
    
    /* Keep quick actions visible on mobile */
    .actions-card {
        position: sticky;
        top: 80px;
        z-index: 100;
        margin-bottom: 1rem !important;
    }
}

/* Enhanced button styling for better visibility */
.actions-card .btn-sm {
    padding: 0.4rem 1rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.actions-card .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Compact sidebar styling */
.sidebar-content .card,
.sidebar-content .form-bg {
    margin-bottom: 0.75rem !important;
}

.progress-step {
    padding: 0.2rem 0;
}

@media print {
    .navbar, .footer, .sidebar-content {
        display: none !important;
    }
    
    .col-lg-8 {
        width: 100% !important;
    }
    
    body {
        background: white !important;
    }
    
    .form-bg {
        background: white !important;
        box-shadow: none !important;
    }
}
</style>
</body>
</html>
