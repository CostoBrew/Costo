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
                <div class="text-center mb-4 print-compact-header">
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
                                    
                                    <?php if (isset($item['customization_data']) && !empty($item['customization_data'])): ?>
                                        <div class="customizations mb-3">
                                            <h6 class="text-muted mb-2">
                                                <i class="bi bi-gear me-1"></i>Customizations:
                                            </h6>
                                            <div class="customization-details">
                                                <?php
                                                $customData = is_string($item['customization_data'])
                                                    ? json_decode($item['customization_data'], true)
                                                    : $item['customization_data'];

                                                if ($customData):
                                                ?>
                                                    <div class="row g-2">
                                                        <?php
                                                        // Helper functions (using anonymous functions to avoid redeclaration)
                                                        $getDisplayValue = function($item) {
                                                            if (is_array($item) && isset($item['name'])) {
                                                                return $item['name'];
                                                            } elseif (is_array($item) && isset($item['value'])) {
                                                                return $item['value'];
                                                            } elseif (is_string($item)) {
                                                                return $item;
                                                            }
                                                            return 'N/A';
                                                        };

                                                        $getPrice = function($item) {
                                                            if (is_array($item) && isset($item['price'])) {
                                                                return ' (+₱' . number_format($item['price'], 2) . ')';
                                                            }
                                                            return '';
                                                        };

                                                        // Display customizations in organized way
                                                        if (isset($customData['cup'])):
                                                            $cupValue = $getDisplayValue($customData['cup']);
                                                            $cupPrice = $getPrice($customData['cup']);
                                                        ?>
                                                            <div class="col-md-6 mb-2">
                                                                <div class="customization-item p-2 bg-light rounded">
                                                                    <small class="text-muted d-block">Cup Size</small>
                                                                    <strong class="text-coffee"><?= htmlspecialchars($cupValue) ?><?= $cupPrice ?></strong>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>

                                                        <?php if (isset($customData['beans'])):
                                                            $beansValue = $getDisplayValue($customData['beans']);
                                                            $beansPrice = $getPrice($customData['beans']);
                                                        ?>
                                                            <div class="col-md-6 mb-2">
                                                                <div class="customization-item p-2 bg-light rounded">
                                                                    <small class="text-muted d-block">Coffee Beans</small>
                                                                    <strong class="text-coffee"><?= htmlspecialchars($beansValue) ?><?= $beansPrice ?></strong>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>

                                                        <?php if (isset($customData['coffee'])):
                                                            $coffeeValue = $getDisplayValue($customData['coffee']);
                                                            $coffeePrice = $getPrice($customData['coffee']);
                                                        ?>
                                                            <div class="col-md-6 mb-2">
                                                                <div class="customization-item p-2 bg-light rounded">
                                                                    <small class="text-muted d-block">Coffee Type</small>
                                                                    <strong class="text-coffee"><?= htmlspecialchars($coffeeValue) ?><?= $coffeePrice ?></strong>
                                                                </div>
                                            </div>
                                                        <?php endif; ?>

                                                        <?php if (isset($customData['milk']) && !empty($customData['milk'])):
                                                            $milkValue = $getDisplayValue($customData['milk']);
                                                            $milkPrice = $getPrice($customData['milk']);
                                                        ?>
                                                            <div class="col-md-6 mb-2">
                                                                <div class="customization-item p-2 bg-light rounded">
                                                                    <small class="text-muted d-block">Milk</small>
                                                                    <strong class="text-coffee"><?= htmlspecialchars($milkValue) ?><?= $milkPrice ?></strong>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>

                                                        <?php if (isset($customData['sweetener']) && !empty($customData['sweetener'])):
                                                            $sweetenerValue = $getDisplayValue($customData['sweetener']);
                                                            $sweetenerPrice = $getPrice($customData['sweetener']);
                                                        ?>
                                                            <div class="col-md-6 mb-2">
                                                                <div class="customization-item p-2 bg-light rounded">
                                                                    <small class="text-muted d-block">Sweetener</small>
                                                                    <strong class="text-coffee"><?= htmlspecialchars($sweetenerValue) ?><?= $sweetenerPrice ?></strong>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>

                                                        <?php if (isset($customData['syrup']) && !empty($customData['syrup'])):
                                                            $syrupValue = $getDisplayValue($customData['syrup']);
                                                            $syrupPrice = $getPrice($customData['syrup']);
                                                        ?>
                                                            <div class="col-md-6 mb-2">
                                                                <div class="customization-item p-2 bg-light rounded">
                                                                    <small class="text-muted d-block">Syrup</small>
                                                                    <strong class="text-coffee"><?= htmlspecialchars($syrupValue) ?><?= $syrupPrice ?></strong>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>

                                                        <?php if (isset($customData['topping']) && !empty($customData['topping'])):
                                                            $toppingValue = $getDisplayValue($customData['topping']);
                                                            $toppingPrice = $getPrice($customData['topping']);
                                                        ?>
                                                            <div class="col-md-6 mb-2">
                                                                <div class="customization-item p-2 bg-light rounded">
                                                                    <small class="text-muted d-block">Topping</small>
                                                                    <strong class="text-coffee"><?= htmlspecialchars($toppingValue) ?><?= $toppingPrice ?></strong>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>

                                                        <?php if (isset($customData['pastry']) && !empty($customData['pastry'])):
                                                            $pastryValue = $getDisplayValue($customData['pastry']);
                                                            $pastryPrice = $getPrice($customData['pastry']);
                                                        ?>
                                                            <div class="col-md-6 mb-2">
                                                                <div class="customization-item p-2 bg-light rounded">
                                                                    <small class="text-muted d-block">Pastry</small>
                                                                    <strong class="text-coffee"><?= htmlspecialchars($pastryValue) ?><?= $pastryPrice ?></strong>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>

                                                        <?php
                                                        // Handle premade coffee customizations
                                                        if (isset($customData['size'])):
                                                            $sizeValue = $getDisplayValue($customData['size']);
                                                            $sizePrice = $getPrice($customData['size']);
                                                        ?>
                                                            <div class="col-md-6 mb-2">
                                                                <div class="customization-item p-2 bg-light rounded">
                                                                    <small class="text-muted d-block">Size</small>
                                                                    <strong class="text-coffee"><?= htmlspecialchars($sizeValue) ?><?= $sizePrice ?></strong>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>

                                                        <?php if (isset($customData['temperature'])):
                                                            $tempValue = $getDisplayValue($customData['temperature']);
                                                        ?>
                                                            <div class="col-md-6 mb-2">
                                                                <div class="customization-item p-2 bg-light rounded">
                                                                    <small class="text-muted d-block">Temperature</small>
                                                                    <strong class="text-coffee"><?= htmlspecialchars($tempValue) ?></strong>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>

                                                        <?php if (isset($customData['extras']) && is_array($customData['extras'])): ?>
                                                            <div class="col-12 mb-2">
                                                                <div class="customization-item p-2 bg-light rounded">
                                                                    <small class="text-muted d-block">Extras</small>
                                                                    <div class="d-flex flex-wrap gap-1">
                                                                        <?php foreach ($customData['extras'] as $extra):
                                                                            $extraValue = $getDisplayValue($extra);
                                                                            $extraPrice = $getPrice($extra);
                                                                        ?>
                                                                            <span class="badge bg-coffee text-white">
                                                                                <?= htmlspecialchars($extraValue) ?><?= $extraPrice ?>
                                                                            </span>
                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>
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
                        <button onclick="printReceipt()" class="btn btn-outline-dark rounded-pill btn-sm">
                            <i class="bi bi-printer me-2"></i>Print Receipt (9x13cm - Single Page)
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

<script>
function printReceipt() {
    // Add print-specific class to body for additional styling
    document.body.classList.add('printing-receipt');

    // Trigger print
    window.print();

    // Remove class after print dialog
    setTimeout(() => {
        document.body.classList.remove('printing-receipt');
    }, 1000);
}

// Optional: Auto-focus print button for keyboard accessibility
document.addEventListener('DOMContentLoaded', function() {
    // Add keyboard shortcut for printing (Ctrl+P)
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'p') {
            e.preventDefault();
            printReceipt();
        }
    });
});
</script>

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

/* Customization styling */
.customization-item {
    border: 1px solid #e9ecef;
    transition: all 0.2s ease;
}

.customization-item:hover {
    border-color: #8B4513;
    box-shadow: 0 2px 4px rgba(139, 69, 19, 0.1);
}

.customization-item small {
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.customization-item strong {
    font-size: 0.9rem;
    font-weight: 600;
}

.badge.bg-coffee {
    background-color: #8B4513 !important;
    font-size: 0.75rem;
    padding: 0.4em 0.6em;
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
    /* Hide non-essential elements */
    .navbar, .footer, .sidebar-content {
        display: none !important;
    }

    /* Set page size to 9 x 13 cm - STRICT single page only */
    @page {
        size: 9cm 13cm;
        margin: 0.2cm;
    }

    /* Reset body and container for print - 9x13cm optimization */
    body {
        background: white !important;
        font-size: 9px !important;
        line-height: 1.2 !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden !important;
    }

    .container-fluid {
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .main-content {
        padding: 0 !important;
    }

    .col-lg-8 {
        width: 100% !important;
        padding: 0 !important;
    }

    /* STRICT single page receipt container - 9x13cm */
    .receipt-container {
        background: white !important;
        box-shadow: none !important;
        border: none !important;
        padding: 0.05cm !important;
        margin: 0 !important;
        height: 12.6cm !important;
        max-height: 12.6cm !important;
        width: 8.6cm !important;
        max-width: 8.6cm !important;
        overflow: hidden !important;
        display: flex !important;
        flex-direction: column !important;
        page-break-after: avoid !important;
        page-break-inside: avoid !important;
    }

    .form-bg {
        background: white !important;
        box-shadow: none !important;
        border: none !important;
        padding: 0 !important;
    }

    /* MINIMAL header for single page constraint */
    .text-center h1 {
        font-size: 12px !important;
        margin-bottom: 2px !important;
        line-height: 1.0 !important;
    }

    .success-icon {
        display: none !important; /* Hide icon to save space */
    }

    .lead {
        font-size: 8px !important;
        margin-bottom: 2px !important;
        line-height: 1.0 !important;
    }

    .print-compact-header {
        margin-bottom: 4px !important;
        padding: 0 !important;
    }

    /* MINIMAL order header for single page */
    .order-header {
        padding: 3px !important;
        margin-bottom: 3px !important;
        background: #f8f9fa !important;
        border: 1px solid #dee2e6 !important;
    }

    .order-header .row {
        margin: 0 !important;
    }

    .order-header .col-md-4 {
        padding: 1px !important;
        margin-bottom: 1px !important;
    }

    .order-header h6 {
        font-size: 7px !important;
        margin-bottom: 0px !important;
        font-weight: 600 !important;
        line-height: 1.0 !important;
    }

    .order-header p {
        font-size: 7px !important;
        margin-bottom: 0px !important;
        line-height: 1.0 !important;
    }

    .order-header .h5 {
        font-size: 8px !important;
        line-height: 1.0 !important;
    }

    .order-header i {
        font-size: 7px !important;
    }

    /* MINIMAL order items for single page */
    .order-items-section h3 {
        font-size: 9px !important;
        margin-bottom: 2px !important;
        line-height: 1.0 !important;
    }

    .receipt-item-card {
        padding: 2px !important;
        margin-bottom: 2px !important;
        background: white !important;
        border: 1px solid #dee2e6 !important;
    }

    .receipt-item-card h5 {
        font-size: 8px !important;
        margin-bottom: 1px !important;
        line-height: 1.0 !important;
    }

    .receipt-item-card .d-flex {
        align-items: flex-start !important;
    }

    .item-total h4 {
        font-size: 8px !important;
        margin-bottom: 0 !important;
        line-height: 1.0 !important;
    }

    /* MINIMAL customizations for single page */
    .customizations h6 {
        font-size: 6px !important;
        margin-bottom: 1px !important;
        line-height: 1.0 !important;
    }

    .customization-item {
        padding: 1px !important;
        margin-bottom: 1px !important;
        border: 1px solid #e9ecef !important;
        background: #f8f9fa !important;
    }

    .customization-item small {
        font-size: 5px !important;
        line-height: 1.0 !important;
    }

    .customization-item strong {
        font-size: 5px !important;
        line-height: 1.0 !important;
    }

    .badge {
        font-size: 4px !important;
        padding: 1px 2px !important;
    }

    .customizations {
        margin-bottom: 1px !important;
    }

    /* Limit customization display */
    .customization-item:nth-child(n+7) {
        display: none !important; /* Hide beyond 6 customizations */
    }

    /* MINIMAL totals for single page */
    .order-totals {
        padding: 2px !important;
        margin-bottom: 2px !important;
        background: #f8f9fa !important;
        border: 1px solid #dee2e6 !important;
    }

    .order-totals .d-flex {
        margin-bottom: 1px !important;
    }

    .order-totals span {
        font-size: 6px !important;
        line-height: 1.0 !important;
    }

    .order-totals .h5 {
        font-size: 7px !important;
        line-height: 1.0 !important;
    }

    .order-totals .h4 {
        font-size: 8px !important;
        line-height: 1.0 !important;
    }

    /* MINIMAL delivery info for single page */
    .delivery-info {
        padding: 2px !important;
        margin-bottom: 0 !important;
        background: #f8f9fa !important;
        border: 1px solid #dee2e6 !important;
    }

    .delivery-info h5 {
        font-size: 7px !important;
        margin-bottom: 1px !important;
        line-height: 1.0 !important;
    }

    .delivery-info p {
        font-size: 5px !important;
        margin-bottom: 1px !important;
        line-height: 1.0 !important;
    }

    .delivery-info strong {
        font-size: 5px !important;
        line-height: 1.0 !important;
    }

    .delivery-info i {
        font-size: 6px !important;
    }

    /* Hide spacing elements */
    .pt-5, .pb-3 {
        padding: 0 !important;
    }

    .mb-4, .mb-3, .mb-2 {
        margin-bottom: 4px !important;
    }

    /* Ensure content fits in width */
    .row.g-4 {
        margin: 0 !important;
    }

    .col-md-6 {
        width: 50% !important;
        padding: 2px !important;
    }

    .col-md-4 {
        width: 33.333% !important;
        padding: 2px !important;
    }

    .col-12 {
        width: 100% !important;
        padding: 2px !important;
    }

    /* STRICT single page constraint for 9x13cm */
    .printing-receipt .receipt-container {
        max-height: 12.6cm !important;
        overflow: hidden !important;
    }

    /* Hide non-essential elements to save space */
    .delivery-info .col-md-6:last-child {
        display: none !important; /* Hide special instructions column */
    }

    .delivery-info .row {
        margin: 0 !important;
    }

    /* Make delivery info single column */
    .delivery-info .col-md-6:first-child {
        width: 100% !important;
    }

    /* Force single page layout */
    * {
        page-break-inside: avoid !important;
        page-break-after: avoid !important;
    }

    /* Ensure no content overflows */
    .receipt-container * {
        max-width: 100% !important;
        word-wrap: break-word !important;
        overflow-wrap: break-word !important;
    }

    /* Ensure customizations display in compact grid */
    .customization-details .row {
        margin: 0 !important;
    }

    .customization-details .col-md-6 {
        padding: 1px !important;
    }

    /* Optimize text spacing */
    h1, h2, h3, h4, h5, h6 {
        line-height: 1.1 !important;
        margin-top: 0 !important;
    }

    p {
        line-height: 1.2 !important;
        margin-bottom: 2px !important;
    }

    /* Ensure badges don't wrap */
    .badge {
        white-space: nowrap !important;
        display: inline-block !important;
    }

    /* Compact the customization grid further */
    .customizations .row.g-2 {
        --bs-gutter-x: 2px !important;
        --bs-gutter-y: 1px !important;
    }

    /* Ensure single page layout */
    .order-items-section {
        flex: 1 !important;
        overflow: hidden !important;
    }

    /* STRICT item limit for single page */
    .receipt-item-card:nth-child(n+4) {
        display: none !important; /* Hide items beyond 3rd to ensure single page */
    }

    /* Add ellipsis for overflow text */
    .customization-item strong,
    .customization-item small {
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
    }

    /* ABSOLUTE single page enforcement */
    html, body {
        height: 13cm !important;
        max-height: 13cm !important;
        overflow: hidden !important;
    }

    .container-fluid,
    .main-content,
    .col-lg-8 {
        height: 100% !important;
        max-height: 100% !important;
        overflow: hidden !important;
    }

    /* Hide any potential overflow content */
    .order-items-section {
        max-height: 6cm !important;
        overflow: hidden !important;
    }

    /* Compress spacing even more */
    .mb-1, .mb-2, .mb-3, .mb-4, .mb-5 {
        margin-bottom: 1px !important;
    }

    .pt-1, .pt-2, .pt-3, .pt-4, .pt-5 {
        padding-top: 1px !important;
    }

    .pb-1, .pb-2, .pb-3, .pb-4, .pb-5 {
        padding-bottom: 1px !important;
    }
}
</style>
</body>
</html>
