<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?> - Community - Costobrew</title>
</head>
<body>
    <div class="product-detail-container">
        <div class="product-detail">
            <div class="product-image-large">
                <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
            </div>
            
            <div class="product-details">
                <h1><?= htmlspecialchars($product['name']) ?></h1>
                <p class="creator">Created by: <strong><?= htmlspecialchars($product['creator']) ?></strong></p>
                
                <div class="rating-section">
                    <span class="rating"><?= number_format($product['rating'], 1) ?> ⭐</span>
                    <span class="rating-count">(Based on community votes)</span>
                </div>
                
                <div class="description-section">
                    <h3>Description</h3>
                    <p><?= htmlspecialchars($product['description']) ?></p>
                </div>
                
                <div class="ingredients-section">
                    <h3>Ingredients</h3>
                    <ul>
                        <li>Premium Arabica Coffee Beans</li>
                        <li>Steamed Milk</li>
                        <li>Vanilla Syrup</li>
                        <li>Extra Foam</li>
                    </ul>
                </div>
                
                <div class="price-section">
                    <span class="price">$<?= number_format($product['price'], 2) ?></span>
                </div>
                
                <div class="actions-section">
                    <button class="btn-add-cart btn-large" data-product-id="<?= $product['id'] ?>">
                        Add to Cart - $<?= number_format($product['price'], 2) ?>
                    </button>
                    
                    <button class="btn-customize">Customize This Recipe</button>
                </div>
                
                <div class="creator-section">
                    <h3>About the Creator</h3>
                    <p><?= htmlspecialchars($product['creator']) ?> is a coffee enthusiast who loves experimenting with different flavors and combinations.</p>
                </div>
            </div>
        </div>
        
        <div class="related-products">
            <h3>Other Community Creations</h3>
            <div class="related-grid">
                <!-- Related products would be loaded here -->
                <p>Discover more amazing community creations...</p>
            </div>
        </div>
        
        <div class="back-nav">
            <a href="/community" class="btn-back">← Back to Community</a>
        </div>
    </div>
</body>
</html>
