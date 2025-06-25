<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - CostoBrew Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/src/css/style.css" rel="stylesheet">
    <style>
        body {
            background-image: url('/src/assets/bglogin.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }
        
        .admin-container {
            background-color: rgba(235, 230, 203, 0.95);
            border-radius: 20px;
            margin: 20px;
            min-height: calc(100vh - 40px);
            backdrop-filter: blur(10px);
        }
        
        .admin-header {
            background-color: rgba(235, 230, 203, 0.9);
            border-radius: 20px 20px 0 0;
            padding: 20px 30px;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }
        
        .admin-content {
            padding: 30px;
        }
        
        .orders-table {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .table th {
            background-color: rgba(139, 69, 19, 0.1);
            border: none;
            font-weight: 600;
            color: #333;
            padding: 15px;
        }
        
        .table td {
            border: none;
            padding: 15px;
            vertical-align: middle;
        }
        
        .table tbody tr:hover {
            background-color: rgba(139, 69, 19, 0.05);
        }
        
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 500;
        }
        
        .status-confirmed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-completed {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        
        .btn-sm {
            padding: 5px 10px;
            font-size: 0.8em;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Admin Header -->
        <div class="admin-header">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <a href="/admin" class="text-decoration-none text-dark">
                        <img src="/src/assets/CBL2.png" alt="CostoBrew" height="30" class="me-3">
                    </a>
                    <div>
                        <h4 class="mb-0">Manage Orders</h4>
                        <small class="text-muted">Order management and tracking</small>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <a href="/admin" class="btn btn-outline-secondary btn-sm me-2">
                        <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
                    </a>
                    <a href="/logout" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                    </a>
                </div>
            </div>
        </div>

        <!-- Orders Content -->
        <div class="admin-content">
            <div class="orders-table">
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                    <h5 class="mb-0">All Orders</h5>
                    <div class="d-flex gap-2">
                        <button class="btn btn-coffee btn-sm" onclick="refreshOrders()">
                            <i class="bi bi-arrow-clockwise me-1"></i>Refresh
                        </button>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Type</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($orders)): ?>
                                <?php foreach ($orders as $order): ?>
                                    <tr data-order-id="<?= $order['id'] ?>">
                                        <td><strong>#<?= htmlspecialchars($order['order_number'] ?? $order['id']) ?></strong></td>
                                        <td>
                                            <strong><?= htmlspecialchars($order['customer_name']) ?></strong><br>
                                            <small class="text-muted"><?= htmlspecialchars($order['customer_email']) ?></small>
                                        </td>
                                        <td>
                                            <?php
                                            $coffeeType = $order['coffee_type'] ?? 'Other';
                                            $badgeClass = '';
                                            switch($coffeeType) {
                                                case 'DIY':
                                                    $badgeClass = 'bg-primary';
                                                    break;
                                                case 'Premade':
                                                    $badgeClass = 'bg-success';
                                                    break;
                                                case 'Pastry':
                                                    $badgeClass = 'bg-warning';
                                                    break;
                                                default:
                                                    $badgeClass = 'bg-secondary';
                                            }
                                            ?>
                                            <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($coffeeType) ?></span>
                                        </td>
                                        <td><?= htmlspecialchars($order['item_count'] ?? 1) ?> item(s)</td>
                                        <td><strong>₱<?= number_format($order['total_amount'], 2) ?></strong></td>
                                        <td>
                                            <span class="status-badge status-<?= strtolower($order['order_status']) ?>">
                                                <?= ucfirst($order['order_status']) ?>
                                            </span>
                                        </td>
                                        <td><?= date('m/d/Y H:i', strtotime($order['created_at'])) ?></td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn btn-primary btn-sm" onclick="editOrder(<?= $order['id'] ?>)" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-info btn-sm" onclick="viewOrder(<?= $order['id'] ?>)" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm" onclick="deleteOrder(<?= $order['id'] ?>)" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="bi bi-inbox fs-1 text-muted"></i>
                                        <p class="text-muted mt-2">No orders found</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Orders Management JavaScript -->
    <script>
        // Refresh orders
        function refreshOrders() {
            location.reload();
        }

        // Edit order
        function editOrder(orderId) {
            // Redirect to admin dashboard for editing (or implement similar modal here)
            window.location.href = '/admin?edit=' + orderId;
        }

        // View order details
        function viewOrder(orderId) {
            // Redirect to admin dashboard for viewing (or implement similar modal here)
            window.location.href = '/admin?view=' + orderId;
        }

        // Delete order
        function deleteOrder(orderId) {
            if (confirm('Are you sure you want to delete order #' + orderId + '? This action cannot be undone.')) {
                fetch('/admin/orders/' + orderId + '/delete', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const row = document.querySelector(`tr[data-order-id="${orderId}"]`);
                        if (row) {
                            row.remove();
                        }
                        alert('Order deleted successfully');
                    } else {
                        alert('Error deleting order: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting order');
                });
            }
        }
    </script>
</body>
</html>
