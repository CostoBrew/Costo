<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIY Coffee Studio - Costobrew</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/src/css/style.css" rel="stylesheet">
</head>
<body data-bs-theme="dark" class="d-flex flex-column min-vh-100">
<?php include __DIR__ . '/../../includes/header.php'; ?>

<main class="container my-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Hero Section -->            <div class="text-center mb-5">
                <i class="bi bi-magic text-primary mb-3" style="font-size: 4rem;"></i>
                <h1 class="display-5 fw-bold mb-3">DIY Coffee Studio</h1>
                <p class="lead text-muted">Create your perfect custom coffee blend step by step. Express your creativity and craft a unique coffee experience tailored just for you.</p>
            </div>

            <!-- Process Overview -->
            <div class="card bg-dark border-secondary mb-5">
                <div class="card-body p-4">
                    <h3 class="card-title mb-4 text-center">
                        <i class="bi bi-list-check text-primary me-2"></i>
                        Your Creative Journey
                    </h3>
                    
                    <div class="row g-3">
                        <div class="col-md-6 col-lg-3">
                            <div class="text-center p-3">
                                <div class="bg-primary bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                    <i class="bi bi-cup text-primary fs-4"></i>
                                </div>
                                <h6 class="fw-bold">Cup Size</h6>
                                <small class="text-muted">Choose your preferred size</small>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="text-center p-3">
                                <div class="bg-primary bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                    <i class="bi bi-circle-fill text-primary fs-4"></i>
                                </div>
                                <h6 class="fw-bold">Coffee Beans</h6>
                                <small class="text-muted">Select your bean type</small>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="text-center p-3">
                                <div class="bg-primary bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                    <i class="bi bi-droplet text-primary fs-4"></i>
                                </div>
                                <h6 class="fw-bold">Milk & Add-ons</h6>
                                <small class="text-muted">Customize with milk, sweeteners & more</small>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="text-center p-3">
                                <div class="bg-primary bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                    <i class="bi bi-star text-primary fs-4"></i>
                                </div>
                                <h6 class="fw-bold">Finishing Touch</h6>
                                <small class="text-muted">Add toppings & pastry</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            <!-- Action Buttons -->
            <div class="text-center">
                <div class="d-grid gap-3 d-md-flex justify-content-md-center">
                    <a href="/studio/diy/cup-size" class="btn btn-primary btn-lg px-5">
                        <i class="bi bi-play-fill me-2"></i>Start Creating
                    </a>
                    <a href="/studio" class="btn btn-outline-secondary btn-lg px-4">
                        <i class="bi bi-arrow-left me-2"></i>Back to Studio
                    </a>
                </div>
                
                <p class="text-muted mt-3 small">
                    <i class="bi bi-clock me-1"></i>
                    Estimated time: 3-5 minutes
                </p>
            </div>

            <!-- Tips Section -->
            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="card bg-dark border-secondary h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="bi bi-lightbulb text-warning me-2"></i>
                                Pro Tips
                            </h5>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Take your time with each step</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Preview your creation before finalizing</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Save your favorite combinations</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-dark border-secondary h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="bi bi-heart text-danger me-2"></i>
                                Popular Choices
                            </h5>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><i class="bi bi-star-fill text-warning me-2"></i>Arabica beans with oat milk</li>
                                <li class="mb-2"><i class="bi bi-star-fill text-warning me-2"></i>Vanilla syrup + cinnamon</li>
                                <li class="mb-2"><i class="bi bi-star-fill text-warning me-2"></i>Chocolate croissant pairing</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
