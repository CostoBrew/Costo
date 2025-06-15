<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Studio - Costobrew</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/src/css/style.css" rel="stylesheet">
</head>
<body data-bs-theme="dark" class="d-flex flex-column min-vh-100">
<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="container my-5 flex-grow-1">
    <div class="studio-container">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1 class="mb-3">
                    <i class="bi bi-cup me-2"></i>Coffee Studio
                </h1>
                <p class="lead">Create your perfect coffee experience</p>
            </div>
        </div>
        
        <div class="studio-options">
            <div class="row g-4 mb-5">
                <div class="col-lg-6">
                    <div class="card bg-dark border-secondary h-100">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="bi bi-palette text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h2 class="card-title">DIY Coffee</h2>
                            <p class="card-text mb-4">Build your custom coffee from scratch with complete control over every ingredient.</p>
                            
                            <ul class="list-unstyled text-start mb-4">
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>8 Customization Stages</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Choose your coffee beans</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Select milk type & sweeteners</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Add syrups & toppings</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Pick a perfect pastry</li>
                            </ul>
                            
                            <a href="/studio/diy" class="btn btn-primary btn-lg">
                                <i class="bi bi-plus-circle me-2"></i>Start DIY Creation
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="card bg-dark border-secondary h-100">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="bi bi-award text-warning" style="font-size: 3rem;"></i>
                            </div>
                            <h2 class="card-title">Premade Coffee</h2>
                            <p class="card-text mb-4">Choose from our expertly crafted coffee recipes and customize the basics.</p>
                            
                            <ul class="list-unstyled text-start mb-4">
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>3 Simple Stages</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Select cup size</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Choose from premium recipes</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Add a pastry</li>
                            </ul>
                            
                            <a href="/studio/premade" class="btn btn-warning btn-lg">
                                <i class="bi bi-star me-2"></i>Choose Premade
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="studio-info">
            <div class="row">
                <div class="col-12">
                    <div class="card bg-secondary border-0">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-calculator text-info mb-3" style="font-size: 2.5rem;"></i>
                            <h3 class="card-title">POS-Style Counter</h3>
                            <p class="card-text">
                                Watch your order total update in real-time as you make your selections. 
                                See exactly what you're paying for with transparent pricing on every option.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
