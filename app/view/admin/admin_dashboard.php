<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CostoBrew</title>
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
            display: flex;
            min-height: calc(100vh - 140px);
        }

        .admin-sidebar {
            background-color: rgba(200, 195, 168, 0.8);
            width: 250px;
            padding: 20px 0;
            border-radius: 0 0 0 20px;
        }

        .admin-main {
            flex: 1;
            padding: 30px;
            background-color: rgba(235, 230, 203, 0.7);
            border-radius: 0 0 20px 0;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 5px;
        }

        .sidebar-menu a {
            display: block;
            padding: 15px 25px;
            color: #333;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 400;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: rgba(139, 69, 19, 0.1);
            color: #8B4513;
            border-left: 4px solid #8B4513;
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

        .admin-stats {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 20px;
            flex: 1;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #8B4513;
        }

        .stat-label {
            color: #666;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Admin Header -->
        <div class="admin-header">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img src="/src/assets/CBL2.png" alt="CostoBrew" height="30" class="me-3">
                    <div>
                        <h4 class="mb-0">Admin Dashboard</h4>
                        <small class="text-muted">Welcome back, Administrator</small>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <span class="me-3">
                        <strong><?= htmlspecialchars($_SESSION['user_email'] ?? 'Admin') ?></strong>
                    </span>
                    <a href="/logout" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                    </a>
                </div>
            </div>
        </div>

        <!-- Admin Content -->
        <div class="admin-content">
            <!-- Sidebar -->
            <div class="admin-sidebar">
                <ul class="sidebar-menu">
                    <li><a href="/admin" class="active"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                    <li><a href="/admin/orders"><i class="bi bi-bag me-2"></i>Orders</a></li>
                    <li><a href="/admin/menu"><i class="bi bi-cup-hot me-2"></i>Menu</a></li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="admin-main">
                <!-- Statistics Cards -->
                <div class="admin-stats">
                    <div class="stat-card">
                        <div class="stat-number"><?= $stats['total_orders'] ?? 0 ?></div>
                        <div class="stat-label">Total Orders</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?= $stats['pending_orders'] ?? 0 ?></div>
                        <div class="stat-label">Pending Orders</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">₱<?= number_format($stats['total_revenue'] ?? 0, 2) ?></div>
                        <div class="stat-label">Total Revenue</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?= $stats['total_customers'] ?? 0 ?></div>
                        <div class="stat-label">Total Customers</div>
                    </div>
                </div>

                <!-- Orders Table -->
                <div class="orders-table">
                    <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                        <h5 class="mb-0">Recent Orders</h5>
                        <div class="d-flex gap-2">
                            <button class="btn btn-coffee btn-sm" onclick="refreshOrders()">
                                <i class="bi bi-arrow-clockwise me-1"></i>Refresh
                            </button>
                            <button class="btn btn-success btn-sm" onclick="addNewOrder()">
                                <i class="bi bi-plus me-1"></i>Add Order
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Order</th>
                                    <th>Type</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($orders)): ?>
                                    <?php foreach ($orders as $order): ?>
                                        <tr data-order-id="<?= $order['id'] ?>">
                                            <td>
                                                <strong><?= htmlspecialchars($order['customer_name']) ?></strong><br>
                                                <small class="text-muted"><?= htmlspecialchars($order['customer_email']) ?></small>
                                            </td>
                                            <td>
                                                <strong>#<?= htmlspecialchars($order['order_number'] ?? $order['id']) ?></strong><br>
                                                <small class="text-muted"><?= htmlspecialchars(substr($order['item_names'] ?? 'Coffee Order', 0, 30)) ?><?= strlen($order['item_names'] ?? '') > 30 ? '...' : '' ?></small>
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
                                            <td><?= date('m/d/Y', strtotime($order['created_at'])) ?></td>
                                            <td>
                                                <span class="status-badge status-<?= strtolower($order['order_status']) ?>">
                                                    <?= ucfirst($order['order_status']) ?>
                                                </span>
                                            </td>
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
    </div>

    <!-- Edit Order Modal -->
    <div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editOrderModalLabel">Edit Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editOrderForm">
                        <input type="hidden" id="editOrderId">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editCustomerName" class="form-label">Customer Name</label>
                                    <input type="text" class="form-control" id="editCustomerName" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editCustomerEmail" class="form-label">Customer Email</label>
                                    <input type="email" class="form-control" id="editCustomerEmail" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editCustomerPhone" class="form-label">Customer Phone</label>
                                    <input type="text" class="form-control" id="editCustomerPhone">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editOrderStatus" class="form-label">Order Status</label>
                                    <select class="form-control" id="editOrderStatus" required>
                                        <option value="pending">Pending</option>
                                        <option value="confirmed">Confirmed</option>
                                        <option value="preparing">Preparing</option>
                                        <option value="ready">Ready</option>
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editPaymentStatus" class="form-label">Payment Status</label>
                                    <select class="form-control" id="editPaymentStatus" required>
                                        <option value="pending">Pending</option>
                                        <option value="paid">Paid</option>
                                        <option value="failed">Failed</option>
                                        <option value="refunded">Refunded</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="editSpecialInstructions" class="form-label">Special Instructions</label>
                            <textarea class="form-control" id="editSpecialInstructions" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-coffee" onclick="saveOrderChanges()">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Order Modal -->
    <div class="modal fade" id="viewOrderModal" tabindex="-1" aria-labelledby="viewOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewOrderModalLabel">Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Order Information</h6>
                            <p><strong>Order Number:</strong> <span id="viewOrderNumber"></span></p>
                            <p><strong>Date:</strong> <span id="viewOrderDate"></span></p>
                            <p><strong>Status:</strong> <span id="viewOrderStatus"></span></p>
                            <p><strong>Payment Status:</strong> <span id="viewPaymentStatus"></span></p>
                        </div>
                        <div class="col-md-6">
                            <h6>Customer Information</h6>
                            <p><strong>Name:</strong> <span id="viewCustomerName"></span></p>
                            <p><strong>Email:</strong> <span id="viewCustomerEmail"></span></p>
                            <p><strong>Phone:</strong> <span id="viewCustomerPhone"></span></p>
                        </div>
                    </div>

                    <hr>

                    <h6>Order Items</h6>
                    <div id="viewOrderItems" class="mb-3">
                        <!-- Order items will be populated here -->
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h6>Special Instructions</h6>
                            <p id="viewSpecialInstructions"></p>
                        </div>
                        <div class="col-md-6">
                            <h6>Order Summary</h6>
                            <p><strong>Subtotal:</strong> <span id="viewSubtotal"></span></p>
                            <p><strong>Tax:</strong> <span id="viewTaxAmount"></span></p>
                            <p><strong>Total:</strong> <span id="viewTotalAmount"></span></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Admin Dashboard JavaScript -->
    <script>
        // Refresh orders
        function refreshOrders() {
            location.reload();
        }

        // Add new order
        function addNewOrder() {
            // Open modal or redirect to add order page
            alert('Add new order functionality will be implemented');
        }

        // Edit order
        function editOrder(orderId) {
            // Fetch order details and populate edit modal
            fetch('/admin/orders/' + orderId + '/details', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    populateEditModal(data.order);
                    const editModal = new bootstrap.Modal(document.getElementById('editOrderModal'));
                    editModal.show();
                } else {
                    alert('Error loading order details: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error loading order details');
            });
        }

        // Populate edit modal with order data
        function populateEditModal(order) {
            document.getElementById('editOrderId').value = order.id;
            document.getElementById('editCustomerName').value = order.customer_name;
            document.getElementById('editCustomerEmail').value = order.customer_email;
            document.getElementById('editCustomerPhone').value = order.customer_phone || '';
            document.getElementById('editOrderStatus').value = order.order_status;
            document.getElementById('editPaymentStatus').value = order.payment_status;
            document.getElementById('editSpecialInstructions').value = order.special_instructions || '';
        }

        // Save order changes
        function saveOrderChanges() {
            const orderId = document.getElementById('editOrderId').value;
            const formData = {
                customer_name: document.getElementById('editCustomerName').value,
                customer_email: document.getElementById('editCustomerEmail').value,
                customer_phone: document.getElementById('editCustomerPhone').value,
                order_status: document.getElementById('editOrderStatus').value,
                payment_status: document.getElementById('editPaymentStatus').value,
                special_instructions: document.getElementById('editSpecialInstructions').value
            };

            fetch('/admin/orders/' + orderId + '/update', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Order updated successfully');
                    const editModal = bootstrap.Modal.getInstance(document.getElementById('editOrderModal'));
                    editModal.hide();
                    location.reload(); // Refresh the page to show updated data
                } else {
                    alert('Error updating order: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating order');
            });
        }

        // View order details
        function viewOrder(orderId) {
            // Fetch order details and show in view modal
            fetch('/admin/orders/' + orderId + '/details', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    populateViewModal(data.order);
                    const viewModal = new bootstrap.Modal(document.getElementById('viewOrderModal'));
                    viewModal.show();
                } else {
                    alert('Error loading order details: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error loading order details');
            });
        }

        // Populate view modal with order data
        function populateViewModal(order) {
            document.getElementById('viewOrderNumber').textContent = order.order_number || order.id;
            document.getElementById('viewCustomerName').textContent = order.customer_name;
            document.getElementById('viewCustomerEmail').textContent = order.customer_email;
            document.getElementById('viewCustomerPhone').textContent = order.customer_phone || 'N/A';
            document.getElementById('viewOrderStatus').textContent = order.order_status;
            document.getElementById('viewPaymentStatus').textContent = order.payment_status;
            document.getElementById('viewOrderDate').textContent = new Date(order.created_at).toLocaleString();
            document.getElementById('viewSubtotal').textContent = '₱' + parseFloat(order.subtotal || 0).toFixed(2);
            document.getElementById('viewTaxAmount').textContent = '₱' + parseFloat(order.tax_amount || 0).toFixed(2);
            document.getElementById('viewTotalAmount').textContent = '₱' + parseFloat(order.total_amount || 0).toFixed(2);
            document.getElementById('viewSpecialInstructions').textContent = order.special_instructions || 'None';

            // Display order items
            const itemsContainer = document.getElementById('viewOrderItems');
            itemsContainer.innerHTML = '';
            if (order.items && order.items.length > 0) {
                order.items.forEach(item => {
                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'border rounded p-3 mb-3 bg-light';

                    let customizationHtml = '';

                    // Parse and display customization data
                    if (item.customization_data) {
                        let customData;
                        try {
                            // Handle both string and object customization data
                            customData = typeof item.customization_data === 'string'
                                ? JSON.parse(item.customization_data)
                                : item.customization_data;
                        } catch (e) {
                            customData = item.customization_data;
                        }

                        if (customData && typeof customData === 'object') {
                            customizationHtml = '<div class="mt-2"><strong>Customization Details:</strong><ul class="list-unstyled ms-3 mt-1">';

                            // Helper function to extract display value
                            function getDisplayValue(item) {
                                if (typeof item === 'object' && item !== null) {
                                    return item.name || item.value || JSON.stringify(item);
                                }
                                return item || '';
                            }

                            // Helper function to extract price
                            function getPrice(item) {
                                if (typeof item === 'object' && item !== null && item.price) {
                                    return ` (₱${item.price})`;
                                }
                                return '';
                            }

                            // Handle DIY coffee customization
                            if (customData.build || customData.cup || customData.beans || customData.coffee) {
                                if (customData.cup) {
                                    const cupValue = getDisplayValue(customData.cup);
                                    const cupPrice = getPrice(customData.cup);
                                    customizationHtml += `<li><span class="badge bg-secondary me-2">Cup:</span>${cupValue}${cupPrice}</li>`;
                                }
                                if (customData.beans) {
                                    const beansValue = getDisplayValue(customData.beans);
                                    const beansPrice = getPrice(customData.beans);
                                    customizationHtml += `<li><span class="badge bg-primary me-2">Beans:</span>${beansValue}${beansPrice}</li>`;
                                }
                                if (customData.coffee) {
                                    const coffeeValue = getDisplayValue(customData.coffee);
                                    const coffeePrice = getPrice(customData.coffee);
                                    customizationHtml += `<li><span class="badge bg-primary me-2">Coffee:</span>${coffeeValue}${coffeePrice}</li>`;
                                }
                                if (customData.milk) {
                                    const milkValue = getDisplayValue(customData.milk);
                                    const milkPrice = getPrice(customData.milk);
                                    if (milkValue) customizationHtml += `<li><span class="badge bg-info me-2">Milk:</span>${milkValue}${milkPrice}</li>`;
                                }
                                if (customData.sweetener) {
                                    const sweetenerValue = getDisplayValue(customData.sweetener);
                                    const sweetenerPrice = getPrice(customData.sweetener);
                                    if (sweetenerValue) customizationHtml += `<li><span class="badge bg-warning me-2">Sweetener:</span>${sweetenerValue}${sweetenerPrice}</li>`;
                                }
                                if (customData.syrup) {
                                    const syrupValue = getDisplayValue(customData.syrup);
                                    const syrupPrice = getPrice(customData.syrup);
                                    if (syrupValue) customizationHtml += `<li><span class="badge bg-success me-2">Syrup:</span>${syrupValue}${syrupPrice}</li>`;
                                }
                                if (customData.topping) {
                                    const toppingValue = getDisplayValue(customData.topping);
                                    const toppingPrice = getPrice(customData.topping);
                                    if (toppingValue) customizationHtml += `<li><span class="badge bg-danger me-2">Topping:</span>${toppingValue}${toppingPrice}</li>`;
                                }
                                if (customData.pastry) {
                                    const pastryValue = getDisplayValue(customData.pastry);
                                    const pastryPrice = getPrice(customData.pastry);
                                    customizationHtml += `<li><span class="badge bg-dark me-2">Pastry:</span>${pastryValue}${pastryPrice}</li>`;
                                }
                            }

                            // Handle premade coffee customization
                            if (customData.size) {
                                const sizeValue = getDisplayValue(customData.size);
                                const sizePrice = getPrice(customData.size);
                                customizationHtml += `<li><span class="badge bg-primary me-2">Size:</span>${sizeValue}${sizePrice}</li>`;
                            }
                            if (customData.temperature) {
                                const tempValue = getDisplayValue(customData.temperature);
                                customizationHtml += `<li><span class="badge bg-info me-2">Temperature:</span>${tempValue}</li>`;
                            }
                            if (customData.extras && Array.isArray(customData.extras)) {
                                customData.extras.forEach(extra => {
                                    const extraValue = getDisplayValue(extra);
                                    const extraPrice = getPrice(extra);
                                    customizationHtml += `<li><span class="badge bg-success me-2">Extra:</span>${extraValue}${extraPrice}</li>`;
                                });
                            }

                            // Handle any other custom fields
                            Object.keys(customData).forEach(key => {
                                if (!['build', 'cup', 'beans', 'coffee', 'milk', 'sweetener', 'syrup', 'topping', 'pastry', 'size', 'temperature', 'extras', 'name', 'type'].includes(key)) {
                                    const value = customData[key];
                                    if (value && value !== null && value !== '') {
                                        const displayValue = getDisplayValue(value);
                                        const priceValue = getPrice(value);
                                        if (displayValue) {
                                            customizationHtml += `<li><span class="badge bg-secondary me-2">${key.charAt(0).toUpperCase() + key.slice(1)}:</span>${displayValue}${priceValue}</li>`;
                                        }
                                    }
                                }
                            });

                            customizationHtml += '</ul></div>';
                        } else if (customData) {
                            customizationHtml = `<div class="mt-2"><strong>Customization:</strong> <span class="text-muted">${customData}</span></div>`;
                        }
                    }

                    itemDiv.innerHTML = `
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">${item.item_name}</h6>
                                <div class="d-flex gap-2 mb-2">
                                    <span class="badge bg-outline-primary">${item.item_type}</span>
                                    <span class="badge bg-outline-secondary">Qty: ${item.quantity}</span>
                                </div>
                                ${customizationHtml}
                                ${item.special_instructions ? '<div class="mt-2"><strong>Special Instructions:</strong> <span class="text-muted">' + item.special_instructions + '</span></div>' : ''}
                            </div>
                            <div class="text-end ms-3">
                                <div class="fw-bold">₱${parseFloat(item.total_price).toFixed(2)}</div>
                                <small class="text-muted">₱${parseFloat(item.unit_price || item.total_price / item.quantity).toFixed(2)} each</small>
                            </div>
                        </div>
                    `;
                    itemsContainer.appendChild(itemDiv);
                });
            } else {
                itemsContainer.innerHTML = '<p class="text-muted">No items found</p>';
            }
        }

        // Delete order
        function deleteOrder(orderId) {
            if (confirm('Are you sure you want to delete order #' + orderId + '? This action cannot be undone.')) {
                // Send delete request
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
                        // Remove row from table
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

        // Auto-refresh every 30 seconds
        setInterval(function() {
            // Only refresh if user is still on the page
            if (document.visibilityState === 'visible') {
                refreshOrders();
            }
        }, 30000);

        // Check for URL parameters on page load
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const editOrderId = urlParams.get('edit');
            const viewOrderId = urlParams.get('view');

            if (editOrderId) {
                // Auto-open edit modal
                setTimeout(() => editOrder(editOrderId), 500);
                // Clean URL
                window.history.replaceState({}, document.title, window.location.pathname);
            } else if (viewOrderId) {
                // Auto-open view modal
                setTimeout(() => viewOrder(viewOrderId), 500);
                // Clean URL
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        });
    </script>
</body>
</html>