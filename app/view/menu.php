<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Menu - Costobrew</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .coffee-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .coffee-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .price-tag {
            background: linear-gradient(45deg, #8B4513, #D2691E);
            color: white;
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: bold;
        }
        .stock-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo url('/'); ?>">
                <i class="bi bi-cup-hot"></i> Costobrew
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo url('/'); ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo url('/menu'); ?>">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo url('/about'); ?>">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo url('/contact'); ?>">Contact</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if (auth()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo url('/cart'); ?>">
                                <i class="bi bi-cart"></i> Cart
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo url('/dashboard'); ?>">Dashboard</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo url('/login'); ?>">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="bg-light py-5">
        <div class="container text-center">
            <h1 class="display-4 mb-3">
                <i class="bi bi-cup-hot text-primary"></i> Our Coffee Menu
            </h1>
            <p class="lead">Discover our carefully curated selection of premium coffees</p>
        </div>
    </div>

    <!-- Coffee Menu -->
    <div class="container my-5">
        <?php if (isset($coffees) && !empty($coffees)): ?>
            <div class="row g-4">
                <?php foreach ($coffees as $coffee): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card coffee-card h-100 position-relative">
                            <!-- Stock Badge -->
                            <?php if ($coffee['stock'] > 0): ?>
                                <span class="badge bg-success stock-badge">In Stock</span>
                            <?php else: ?>
                                <span class="badge bg-danger stock-badge">Out of Stock</span>
                            <?php endif; ?>

                            <!-- Coffee Image -->
                            <img src="<?php echo e($coffee['image']); ?>" 
                                 class="card-img-top" 
                                 alt="<?php echo e($coffee['name']); ?>"
                                 style="height: 200px; object-fit: cover;">

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo e($coffee['name']); ?></h5>
                                <p class="card-text flex-grow-1"><?php echo e($coffee['description']); ?></p>
                                
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="price-tag">$<?php echo number_format($coffee['price'], 2); ?></span>
                                        <small class="text-muted"><?php echo e($coffee['type']); ?></small>
                                    </div>

                                    <div class="d-grid gap-2">
                                        <a href="<?php echo url('/coffee/' . $coffee['id']); ?>" 
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-eye"></i> View Details
                                        </a>
                                        
                                        <?php if (auth() && $coffee['stock'] > 0): ?>
                                            <form method="POST" action="<?php echo url('/cart/add'); ?>">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="coffee_id" value="<?php echo $coffee['id']; ?>">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-primary btn-sm w-100">
                                                    <i class="bi bi-cart-plus"></i> Add to Cart
                                                </button>
                                            </form>
                                        <?php elseif (!auth()): ?>
                                            <a href="<?php echo url('/login'); ?>" class="btn btn-secondary btn-sm">
                                                <i class="bi bi-person"></i> Login to Order
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-secondary btn-sm" disabled>
                                                <i class="bi bi-x-circle"></i> Out of Stock
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-cup display-1 text-muted"></i>
                <h3 class="mt-3">No coffees available</h3>
                <p class="text-muted">Please check back later for our coffee selection.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container text-center">
            <p>&copy; 2025 Costobrew. Made with <i class="bi bi-heart text-danger"></i> and lots of coffee.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
