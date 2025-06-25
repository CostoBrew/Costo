<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Menu - CostoBrew Admin</title>
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
        
        .menu-table {
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
        
        .status-available {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-unavailable {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        
        .btn-sm {
            padding: 5px 10px;
            font-size: 0.8em;
        }
        
        .coffee-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
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
                        <h4 class="mb-0">Manage Menu</h4>
                        <small class="text-muted">Coffee menu management</small>
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

        <!-- Menu Content -->
        <div class="admin-content">
            <!-- Menu Categories Tabs -->
            <ul class="nav nav-tabs mb-4" id="menuTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="diy-tab" data-bs-toggle="tab" data-bs-target="#diy-components" type="button" role="tab">
                        <i class="bi bi-tools me-2"></i>DIY Components
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="premade-tab" data-bs-toggle="tab" data-bs-target="#premade-coffees" type="button" role="tab">
                        <i class="bi bi-cup-hot me-2"></i>Premade Coffees
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="menuTabContent">
                <!-- DIY Components Tab -->
                <div class="tab-pane fade show active" id="diy-components" role="tabpanel">
                    <!-- DIY Component Categories -->
                    <div class="row g-4">
                        <!-- Cups -->
                        <div class="col-md-6">
                            <div class="menu-table">
                                <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                                    <h6 class="mb-0"><i class="bi bi-cup me-2"></i>Cup Sizes</h6>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm mb-0">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Size</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($menuData['cups'] ?? [] as $cup): ?>
                                                <tr>
                                                    <td><strong><?= htmlspecialchars($cup['name']) ?></strong></td>
                                                    <td><?= htmlspecialchars($cup['size']) ?></td>
                                                    <td>₱<?= number_format($cup['price'], 2) ?></td>
                                                    <td>
                                                        <span class="status-badge status-<?= $cup['available'] ? 'available' : 'unavailable' ?>">
                                                            <?= $cup['available'] ? 'Available' : 'Unavailable' ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="action-buttons">
                                                            <button class="btn btn-primary btn-sm" onclick="editItem('cups', <?= $cup['id'] ?>)" title="Edit">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>
                                                            <button class="btn btn-danger btn-sm" onclick="deleteItem('cups', <?= $cup['id'] ?>)" title="Delete">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Coffee Beans -->
                        <div class="col-md-6">
                            <div class="menu-table">
                                <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                                    <h6 class="mb-0"><i class="bi bi-circle-fill me-2"></i>Coffee Beans</h6>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm mb-0">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($menuData['beans'] ?? [] as $bean): ?>
                                                <tr>
                                                    <td><strong><?= htmlspecialchars($bean['name']) ?></strong></td>
                                                    <td><?= htmlspecialchars($bean['type']) ?></td>
                                                    <td>₱<?= number_format($bean['price'], 2) ?></td>
                                                    <td>
                                                        <span class="status-badge status-<?= $bean['available'] ? 'available' : 'unavailable' ?>">
                                                            <?= $bean['available'] ? 'Available' : 'Unavailable' ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="action-buttons">
                                                            <button class="btn btn-primary btn-sm" onclick="editItem('beans', <?= $bean['id'] ?>)" title="Edit">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>
                                                            <button class="btn btn-danger btn-sm" onclick="deleteItem('beans', <?= $bean['id'] ?>)" title="Delete">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Milk Options -->
                        <div class="col-md-6">
                            <div class="menu-table">
                                <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                                    <h6 class="mb-0"><i class="bi bi-droplet me-2"></i>Milk Options</h6>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm mb-0">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($menuData['milk'] ?? [] as $milk): ?>
                                                <tr>
                                                    <td><strong><?= htmlspecialchars($milk['name']) ?></strong></td>
                                                    <td><?= htmlspecialchars($milk['type']) ?></td>
                                                    <td>₱<?= number_format($milk['price'], 2) ?></td>
                                                    <td>
                                                        <span class="status-badge status-<?= $milk['available'] ? 'available' : 'unavailable' ?>">
                                                            <?= $milk['available'] ? 'Available' : 'Unavailable' ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="action-buttons">
                                                            <button class="btn btn-primary btn-sm" onclick="editItem('milk', <?= $milk['id'] ?>)" title="Edit">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>
                                                            <button class="btn btn-danger btn-sm" onclick="deleteItem('milk', <?= $milk['id'] ?>)" title="Delete">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Sweeteners -->
                        <div class="col-md-6">
                            <div class="menu-table">
                                <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                                    <h6 class="mb-0"><i class="bi bi-heart me-2"></i>Sweeteners</h6>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm mb-0">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($menuData['sweeteners'] ?? [] as $sweetener): ?>
                                                <tr>
                                                    <td><strong><?= htmlspecialchars($sweetener['name']) ?></strong></td>
                                                    <td><?= htmlspecialchars($sweetener['type']) ?></td>
                                                    <td>₱<?= number_format($sweetener['price'], 2) ?></td>
                                                    <td>
                                                        <span class="status-badge status-<?= $sweetener['available'] ? 'available' : 'unavailable' ?>">
                                                            <?= $sweetener['available'] ? 'Available' : 'Unavailable' ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="action-buttons">
                                                            <button class="btn btn-primary btn-sm" onclick="editItem('sweeteners', <?= $sweetener['id'] ?>)" title="Edit">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>
                                                            <button class="btn btn-danger btn-sm" onclick="deleteItem('sweeteners', <?= $sweetener['id'] ?>)" title="Delete">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Syrups -->
                        <div class="col-md-6">
                            <div class="menu-table">
                                <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                                    <h6 class="mb-0"><i class="bi bi-droplet-fill me-2"></i>Syrups</h6>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm mb-0">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Flavor</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($menuData['syrups'] ?? [] as $syrup): ?>
                                                <tr>
                                                    <td><strong><?= htmlspecialchars($syrup['name']) ?></strong></td>
                                                    <td><?= htmlspecialchars($syrup['flavor']) ?></td>
                                                    <td>₱<?= number_format($syrup['price'], 2) ?></td>
                                                    <td>
                                                        <span class="status-badge status-<?= $syrup['available'] ? 'available' : 'unavailable' ?>">
                                                            <?= $syrup['available'] ? 'Available' : 'Unavailable' ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="action-buttons">
                                                            <button class="btn btn-primary btn-sm" onclick="editItem('syrups', <?= $syrup['id'] ?>)" title="Edit">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>
                                                            <button class="btn btn-danger btn-sm" onclick="deleteItem('syrups', <?= $syrup['id'] ?>)" title="Delete">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Toppings -->
                        <div class="col-md-6">
                            <div class="menu-table">
                                <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                                    <h6 class="mb-0"><i class="bi bi-star me-2"></i>Toppings</h6>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm mb-0">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($menuData['toppings'] ?? [] as $topping): ?>
                                                <tr>
                                                    <td><strong><?= htmlspecialchars($topping['name']) ?></strong></td>
                                                    <td><?= htmlspecialchars($topping['type']) ?></td>
                                                    <td>₱<?= number_format($topping['price'], 2) ?></td>
                                                    <td>
                                                        <span class="status-badge status-<?= $topping['available'] ? 'available' : 'unavailable' ?>">
                                                            <?= $topping['available'] ? 'Available' : 'Unavailable' ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="action-buttons">
                                                            <button class="btn btn-primary btn-sm" onclick="editItem('toppings', <?= $topping['id'] ?>)" title="Edit">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>
                                                            <button class="btn btn-danger btn-sm" onclick="deleteItem('toppings', <?= $topping['id'] ?>)" title="Delete">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Pastries -->
                        <div class="col-md-6">
                            <div class="menu-table">
                                <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                                    <h6 class="mb-0"><i class="bi bi-cake me-2"></i>Pastries</h6>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm mb-0">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($menuData['pastries'] ?? [] as $pastry): ?>
                                                <tr>
                                                    <td><strong><?= htmlspecialchars($pastry['name']) ?></strong></td>
                                                    <td><?= htmlspecialchars($pastry['type']) ?></td>
                                                    <td>₱<?= number_format($pastry['price'], 2) ?></td>
                                                    <td>
                                                        <span class="status-badge status-<?= $pastry['available'] ? 'available' : 'unavailable' ?>">
                                                            <?= $pastry['available'] ? 'Available' : 'Unavailable' ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="action-buttons">
                                                            <button class="btn btn-primary btn-sm" onclick="editItem('pastries', <?= $pastry['id'] ?>)" title="Edit">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>
                                                            <button class="btn btn-danger btn-sm" onclick="deleteItem('pastries', <?= $pastry['id'] ?>)" title="Delete">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Premade Coffees Tab -->
                <div class="tab-pane fade" id="premade-coffees" role="tabpanel">
                    <div class="menu-table">
                        <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                            <h5 class="mb-0">Premade Coffee Menu</h5>
                            <div class="d-flex gap-2">
                                <button class="btn btn-coffee btn-sm" onclick="refreshMenu()">
                                    <i class="bi bi-arrow-clockwise me-1"></i>Refresh
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Base Price</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($premadeCoffees)): ?>
                                        <?php foreach ($premadeCoffees as $coffee): ?>
                                            <tr data-coffee-id="<?= $coffee['id'] ?>">
                                                <td>
                                                    <img src="<?= htmlspecialchars($coffee['image'] ?? '/src/assets/default-coffee.jpg') ?>"
                                                         alt="<?= htmlspecialchars($coffee['name']) ?>"
                                                         class="coffee-image">
                                                </td>
                                                <td>
                                                    <strong><?= htmlspecialchars($coffee['name']) ?></strong>
                                                </td>
                                                <td>
                                                    <small class="text-muted"><?= htmlspecialchars(substr($coffee['description'] ?? '', 0, 60)) ?><?= strlen($coffee['description'] ?? '') > 60 ? '...' : '' ?></small>
                                                </td>
                                                <td><strong>₱<?= number_format($coffee['base_price'], 2) ?></strong></td>
                                                <td><?= htmlspecialchars($coffee['category'] ?? 'Coffee') ?></td>
                                                <td>
                                                    <?php if ($coffee['is_available'] ?? 1): ?>
                                                        <span class="status-badge status-available">Available</span>
                                                    <?php else: ?>
                                                        <span class="status-badge status-unavailable">Unavailable</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <button class="btn btn-primary btn-sm" onclick="editPremadeCoffee(<?= $coffee['id'] ?>)" title="Edit">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <button class="btn btn-info btn-sm" onclick="viewPremadeCoffee(<?= $coffee['id'] ?>)" title="View">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                        <button class="btn btn-danger btn-sm" onclick="deletePremadeCoffee(<?= $coffee['id'] ?>)" title="Delete">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <i class="bi bi-cup fs-1 text-muted"></i>
                                                <p class="text-muted mt-2">No premade coffees found</p>
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
    </div>

    <!-- Add/Edit Item Modal -->
    <div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="itemModalLabel">Edit Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="itemForm">
                        <input type="hidden" id="itemId" name="itemId">
                        <input type="hidden" id="itemCategory" name="category">

                        <div class="mb-3">
                            <label for="itemName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="itemName" name="name" required>
                        </div>

                        <div class="mb-3" id="sizeField" style="display: none;">
                            <label for="itemSize" class="form-label">Size</label>
                            <input type="text" class="form-control" id="itemSize" name="size">
                        </div>

                        <div class="mb-3" id="typeField" style="display: none;">
                            <label for="itemType" class="form-label">Type</label>
                            <input type="text" class="form-control" id="itemType" name="type">
                        </div>

                        <div class="mb-3" id="flavorField" style="display: none;">
                            <label for="itemFlavor" class="form-label">Flavor</label>
                            <input type="text" class="form-control" id="itemFlavor" name="flavor">
                        </div>

                        <div class="mb-3">
                            <label for="itemPrice" class="form-label">Price (₱)</label>
                            <input type="number" class="form-control" id="itemPrice" name="price" step="0.01" min="0" required>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="itemAvailable" name="available" checked>
                                <label class="form-check-label" for="itemAvailable">
                                    Available
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveItemBtn">Save Item</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Premade Coffee Modal -->
    <div class="modal fade" id="premadeCoffeeModal" tabindex="-1" aria-labelledby="premadeCoffeeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="premadeCoffeeModalLabel">Edit Premade Coffee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="premadeCoffeeForm">
                        <input type="hidden" id="coffeeId" name="coffeeId">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="coffeeName" class="form-label">Coffee Name</label>
                                    <input type="text" class="form-control" id="coffeeName" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="coffeeCategory" class="form-label">Category</label>
                                    <select class="form-control" id="coffeeCategory" name="category" required>
                                        <option value="">Select Category</option>
                                        <option value="Espresso-based">Espresso-based</option>
                                        <option value="Milk-based">Milk-based</option>
                                        <option value="Specialty">Specialty</option>
                                        <option value="Chocolate">Chocolate</option>
                                        <option value="Cold Brew">Cold Brew</option>
                                        <option value="Seasonal">Seasonal</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="coffeeDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="coffeeDescription" name="description" rows="3" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="coffeePrice" class="form-label">Base Price (₱)</label>
                                    <input type="number" class="form-control" id="coffeePrice" name="base_price" step="0.01" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="coffeeImage" class="form-label">Image URL</label>
                                    <input type="url" class="form-control" id="coffeeImage" name="image" placeholder="/src/assets/coffee.jpg">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="coffeeAvailable" name="is_available" checked>
                                <label class="form-check-label" for="coffeeAvailable">
                                    Available
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveCoffeeBtn">Save Coffee</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Menu Management JavaScript -->
    <script>
        // Refresh menu
        function refreshMenu() {
            location.reload();
        }

        // DIY Component Management
        function editItem(category, itemId) {
            openItemModal(category, itemId);
        }

        // Open item modal for editing
        function openItemModal(category, itemId) {
            const modal = new bootstrap.Modal(document.getElementById('itemModal'));
            const modalTitle = document.getElementById('itemModalLabel');
            const form = document.getElementById('itemForm');

            // Reset form
            form.reset();
            document.getElementById('itemCategory').value = category;

            // Show/hide fields based on category
            showHideFields(category);

            // Edit mode only
            modalTitle.textContent = `Edit ${category.charAt(0).toUpperCase() + category.slice(1)} Item`;
            document.getElementById('itemId').value = itemId;

            // Load item data
            loadItemData(category, itemId);

            modal.show();
        }

        // Show/hide fields based on category
        function showHideFields(category) {
            const sizeField = document.getElementById('sizeField');
            const typeField = document.getElementById('typeField');
            const flavorField = document.getElementById('flavorField');

            // Hide all optional fields first
            sizeField.style.display = 'none';
            typeField.style.display = 'none';
            flavorField.style.display = 'none';

            // Show relevant fields based on category
            switch(category) {
                case 'cups':
                    sizeField.style.display = 'block';
                    break;
                case 'beans':
                case 'milk':
                case 'sweeteners':
                case 'toppings':
                case 'pastries':
                    typeField.style.display = 'block';
                    break;
                case 'syrups':
                    flavorField.style.display = 'block';
                    break;
            }
        }

        // Load item data for editing
        function loadItemData(category, itemId) {
            fetch(`/admin/menu/${category}/${itemId}/edit`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const item = data.data;
                        document.getElementById('itemName').value = item.name || '';
                        document.getElementById('itemSize').value = item.size || '';
                        document.getElementById('itemType').value = item.type || '';
                        document.getElementById('itemFlavor').value = item.flavor || '';
                        document.getElementById('itemPrice').value = item.price || '';
                        document.getElementById('itemAvailable').checked = item.available || false;
                    } else {
                        alert('Error loading item data: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading item data');
                });
        }

        function deleteItem(category, itemId) {
            if (confirm(`Are you sure you want to delete this ${category}? This action cannot be undone.`)) {
                fetch(`/admin/menu/${category}/${itemId}/delete`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload(); // Refresh to update the display
                    } else {
                        alert('Error deleting item: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting item');
                });
            }
        }

        // Save item (edit only)
        function saveItem() {
            const form = document.getElementById('itemForm');
            const formData = new FormData(form);
            const category = formData.get('category');
            const itemId = formData.get('itemId');

            if (!itemId) {
                alert('Error: No item ID found for editing');
                return;
            }

            const itemData = {
                name: formData.get('name'),
                size: formData.get('size'),
                type: formData.get('type'),
                flavor: formData.get('flavor'),
                price: parseFloat(formData.get('price')),
                available: formData.get('available') === 'on'
            };

            fetch(`/admin/menu/${category}/${itemId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(itemData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    bootstrap.Modal.getInstance(document.getElementById('itemModal')).hide();
                    location.reload();
                } else {
                    alert('Error updating item: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating item');
            });
        }

        // Premade Coffee Management
        function editPremadeCoffee(coffeeId) {
            openPremadeCoffeeModal(coffeeId);
        }

        function viewPremadeCoffee(coffeeId) {
            alert('View premade coffee details functionality will be implemented for coffee #' + coffeeId);
        }

        // Open premade coffee modal for editing
        function openPremadeCoffeeModal(coffeeId) {
            const modal = new bootstrap.Modal(document.getElementById('premadeCoffeeModal'));
            const modalTitle = document.getElementById('premadeCoffeeModalLabel');
            const form = document.getElementById('premadeCoffeeForm');

            // Reset form
            form.reset();

            // Edit mode only
            modalTitle.textContent = 'Edit Premade Coffee';
            document.getElementById('coffeeId').value = coffeeId;
            // Load coffee data would go here

            modal.show();
        }

        // Save premade coffee (edit only)
        function savePremadeCoffee() {
            const form = document.getElementById('premadeCoffeeForm');
            const formData = new FormData(form);
            const coffeeId = formData.get('coffeeId');

            if (!coffeeId) {
                alert('Error: No coffee ID found for editing');
                return;
            }

            const coffeeData = {
                name: formData.get('name'),
                description: formData.get('description'),
                base_price: parseFloat(formData.get('base_price')),
                category: formData.get('category'),
                image: formData.get('image'),
                is_available: formData.get('is_available') === 'on'
            };

            fetch(`/admin/coffees/${coffeeId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(coffeeData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    bootstrap.Modal.getInstance(document.getElementById('premadeCoffeeModal')).hide();
                    location.reload();
                } else {
                    alert('Error updating coffee: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating coffee');
            });
        }

        function deletePremadeCoffee(coffeeId) {
            if (confirm('Are you sure you want to delete premade coffee #' + coffeeId + '? This action cannot be undone.')) {
                fetch('/admin/coffees/' + coffeeId + '/delete', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const row = document.querySelector(`tr[data-coffee-id="${coffeeId}"]`);
                        if (row) {
                            row.remove();
                        }
                        alert('Premade coffee deleted successfully');
                    } else {
                        alert('Error deleting premade coffee: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting premade coffee');
                });
            }
        }

        // Tab management and event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap tabs
            const triggerTabList = [].slice.call(document.querySelectorAll('#menuTabs button'));
            triggerTabList.forEach(function (triggerEl) {
                const tabTrigger = new bootstrap.Tab(triggerEl);

                triggerEl.addEventListener('click', function (event) {
                    event.preventDefault();
                    tabTrigger.show();
                });
            });

            // Add event listeners for save buttons
            document.getElementById('saveItemBtn').addEventListener('click', saveItem);
            document.getElementById('saveCoffeeBtn').addEventListener('click', savePremadeCoffee);

            // Form validation
            document.getElementById('itemForm').addEventListener('submit', function(e) {
                e.preventDefault();
                saveItem();
            });

            document.getElementById('premadeCoffeeForm').addEventListener('submit', function(e) {
                e.preventDefault();
                savePremadeCoffee();
            });
        });
    </script>
</body>
</html>
