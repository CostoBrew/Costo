<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - Costobrew</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/src/css/style.css" rel="stylesheet">
</head>
<body data-bs-theme="dark" class="d-flex flex-column min-vh-100">
<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="container my-5 flex-grow-1">
    <div class="orders-container">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="mb-3">
                    <i class="bi bi-bag me-2"></i>Your Order History
                </h1>
            </div>
        </div>
        
        <?php if (!empty($orders)): ?>
            <div class="orders-list">
                <?php foreach ($orders as $order): ?>
                    <div class="order-card">
                        <div class="order-header">
                            <div class="order-id">
                                <h3>Order #<?= htmlspecialchars($order['id']) ?></h3>
                                <p class="order-date"><?= date('M j, Y g:i A', strtotime($order['created_at'])) ?></p>
                            </div>
                            
                            <div class="order-status">
                                <span class="status-badge status-<?= strtolower($order['status']) ?>">
                                    <?= ucfirst($order['status']) ?>
                                </span>
                            </div>
                            
                            <div class="order-total">
                                <strong>$<?= number_format($order['total'], 2) ?></strong>
                            </div>
                        </div>
                        
                        <div class="order-items-preview">
                            <?php $itemCount = count($order['items']); ?>
                            <?php foreach (array_slice($order['items'], 0, 2) as $item): ?>
                                <div class="item-preview">
                                    <span class="item-name"><?= htmlspecialchars($item['custom_data']['name'] ?? 'Custom Coffee') ?></span>
                                    <span class="item-quantity">×<?= $item['quantity'] ?></span>
                                </div>
                            <?php endforeach; ?>
                            
                            <?php if ($itemCount > 2): ?>
                                <div class="item-preview more-items">
                                    <span>+<?= $itemCount - 2 ?> more item<?= $itemCount > 3 ? 's' : '' ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="order-actions">
                            <a href="/orders/<?= $order['id'] ?>" class="btn-view">View Details</a>
                            <button class="btn-reorder" data-order-id="<?= $order['id'] ?>">Reorder</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
        <?php else: ?>
            <div class="no-orders">
                <h2>No orders yet</h2>
                <p>Start your coffee journey by creating your first custom blend!</p>
                <a href="/studio" class="btn-primary">Create Your First Coffee</a>
            </div>
        <?php endif; ?>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle reorder functionality
            document.querySelectorAll('.btn-reorder').forEach(btn => {
                btn.addEventListener('click', function() {
                    const orderId = this.dataset.orderId;
                    
                    if (confirm('Add all items from this order to your cart?')) {
                        // AJAX call to reorder
                        reorderItems(orderId);
                    }                });
            });
        });
        
        function reorderItems(orderId) {
            // TODO: Implement reorder functionality
            alert('Items added to cart!');
            window.location.href = '/cart';
        }
    </script>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
