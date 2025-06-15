<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community - Costobrew</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/src/css/style.css" rel="stylesheet">
</head>
<body data-bs-theme="dark" class="d-flex flex-column min-vh-100">
<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="container my-5 flex-grow-1">
    <div class="community-container">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="mb-3">
                    <i class="bi bi-people me-2"></i>Community Creations
                </h1>
                <p class="lead">Discover amazing coffee creations made by our community members!</p>
            </div>
        </div>
        
        <div class="community-products">
            <div class="row">
                <?php if (!empty($communityProducts)): ?>
                    <?php foreach ($communityProducts as $product): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card bg-dark border-secondary h-100">
                                <div class="product-image">
                                    <img src="<?= htmlspecialchars($product['image']) ?>" 
                                         alt="<?= htmlspecialchars($product['name']) ?>" 
                                         class="card-img-top" style="height: 250px; object-fit: cover;">
                                </div>
                                
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                                    <p class="creator text-muted mb-2">
                                        <i class="bi bi-person me-1"></i>Created by: <?= htmlspecialchars($product['creator']) ?>
                                    </p>
                                    <p class="description card-text"><?= htmlspecialchars($product['description']) ?></p>
                                    
                                    <div class="product-rating mb-2">
                                        <span class="rating text-warning">
                                            <i class="bi bi-star-fill"></i> <?= number_format($product['rating'], 1) ?>
                                        </span>
                                    </div>
                                    
                                    <div class="product-price mb-3">
                                        <span class="h5 text-success">$<?= number_format($product['price'], 2) ?></span>
                                    </div>
                                    
                                    <div class="product-actions mt-auto">
                                        <div class="d-grid gap-2">
                                            <a href="/community/product/<?= $product['id'] ?>" class="btn btn-outline-primary">
                                                <i class="bi bi-eye me-1"></i>View Details
                                            </a>
                                            <button class="btn btn-primary" data-product-id="<?= $product['id'] ?>">
                                                <i class="bi bi-cart-plus me-1"></i>Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="card bg-dark border-secondary text-center py-5">
                            <div class="card-body">
                                <i class="bi bi-cup text-muted" style="font-size: 4rem;"></i>
                                <h3 class="mt-3">No Community Products Yet</h3>
                                <p class="text-muted mb-4">No community products available at the moment.</p>
                                <p class="text-muted mb-4">Be the first to create and share your custom coffee creation!</p>
                                <a href="/studio" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-2"></i>Create Your Coffee
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
