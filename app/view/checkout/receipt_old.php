<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - Order <?= htmlspecialchars($order['id']) ?> - Costobrew</title>
</head>
<body>
    <div class="receipt-container">
        <div class="receipt">
            <div class="receipt-header">
                <h1>Costobrew Coffee Shop</h1>
                <p>Thank you for your order!</p>
                <div class="order-info">
                    <p><strong>Order #:</strong> <?= htmlspecialchars($order['id']) ?></p>
                    <p><strong>Date:</strong> <?= date('M j, Y g:i A', strtotime($order['created_at'])) ?></p>
                    <p><strong>Customer:</strong> <?= htmlspecialchars($order['customer']['name']) ?></p>
                </div>
            </div>
            
            <div class="receipt-items">
                <h3>Order Details</h3>
                
                <?php foreach ($order['items'] as $item): ?>
                    <div class="receipt-item">
                        <div class="item-details">
                            <h4><?= htmlspecialchars($item['custom_data']['name'] ?? 'Custom Coffee') ?></h4>
                            
                            <?php if ($item['item_type'] === 'diy'): ?>
                                <ul class="item-customizations">
                                    <?php foreach ($item['custom_data'] as $key => $value): ?>
                                        <?php if ($key !== 'name'): ?>
                                            <li><?= htmlspecialchars($key) ?>: <?= htmlspecialchars($value['value'] ?? $value) ?></li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                            
                            <p class="item-quantity">Qty: <?= $item['quantity'] ?> × $<?= number_format($item['price'], 2) ?></p>
                        </div>
                        
                        <div class="item-total">
                            $<?= number_format($item['price'] * $item['quantity'], 2) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="receipt-totals">
                <div class="total-row">
                    <span>Subtotal:</span>
                    <span>$<?= number_format($order['subtotal'], 2) ?></span>
                </div>
                <div class="total-row">
                    <span>Tax:</span>
                    <span>$<?= number_format($order['taxes'], 2) ?></span>
                </div>
                <div class="total-row final">
                    <span><strong>Total Paid:</strong></span>
                    <span><strong>$<?= number_format($order['total'], 2) ?></strong></span>
                </div>
            </div>
            
            <div class="payment-info">
                <p><strong>Payment Method:</strong> <?= ucfirst($order['payment']['method']) ?></p>
                <p><strong>Status:</strong> <?= ucfirst($order['status']) ?></p>
            </div>
            
            <div class="receipt-footer">
                <p>Your order is being prepared!</p>
                <p>Estimated pickup time: 10-15 minutes</p>
            </div>
        </div>
        
        <div class="you-might-like">
            <h3>You Might Also Like</h3>
            
            <div class="suggestions-grid">
                <?php foreach ($suggestions as $suggestion): ?>
                    <div class="suggestion-card">
                        <div class="suggestion-image">
                            <img src="<?= htmlspecialchars($suggestion['image']) ?>" alt="<?= htmlspecialchars($suggestion['name']) ?>">
                        </div>
                        
                        <div class="suggestion-info">
                            <h4><?= htmlspecialchars($suggestion['name']) ?></h4>
                            <p><?= htmlspecialchars($suggestion['description']) ?></p>
                            <div class="suggestion-price">
                                <span>$<?= number_format($suggestion['price'], 2) ?></span>
                                <button class="btn-add-suggestion" data-item="<?= htmlspecialchars($suggestion['name']) ?>">
                                    Add to Next Order
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="receipt-actions">
            <button onclick="window.print()" class="btn-secondary">Print Receipt</button>
            <a href="/orders" class="btn-secondary">View All Orders</a>
            <a href="/studio" class="btn-primary">Create Another Coffee</a>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle suggestion additions
            document.querySelectorAll('.btn-add-suggestion').forEach(btn => {
                btn.addEventListener('click', function() {
                    const itemName = this.dataset.item;
                    alert(`${itemName} added to your favorites for next time!`);
                    this.textContent = 'Added ✓';
                    this.disabled = true;
                });
            });
        });
    </script>
</body>
</html>
