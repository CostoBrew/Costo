<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premade Coffee Studio - Costobrew</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/src/css/style.css" rel="stylesheet">
</head>
<body data-bs-theme="dark" class="d-flex flex-column min-vh-100">
<?php include __DIR__ . '/../../includes/header.php'; ?>

<main class="container my-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Hero Section -->
            <div class="text-center mb-5">
                <i class="bi bi-cup-hot text-primary mb-3" style="font-size: 4rem;"></i>
                <h1 class="display-5 fw-bold mb-3">Premade Coffee Studio</h1>
                <p class="lead text-muted">Choose from our expertly crafted coffee blends. Quick, easy, and perfectly balanced for your taste.</p>
            </div>

            <!-- Process Overview -->
            <div class="card bg-dark border-secondary mb-5">
                <div class="card-body p-4">
                    <h3 class="card-title mb-4 text-center">
                        <i class="bi bi-lightning text-primary me-2"></i>
                        Quick & Easy Process
                    </h3>
                    
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="text-center p-3">
                                <div class="bg-primary bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                    <span class="fw-bold text-primary fs-4">1</span>
                                </div>
                                <h6 class="fw-bold">Choose Cup Size</h6>
                                <small class="text-muted">Select your preferred size</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-3">
                                <div class="bg-primary bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                    <span class="fw-bold text-primary fs-4">2</span>
                                </div>
                                <h6 class="fw-bold">Pick Your Blend</h6>
                                <small class="text-muted">Expert curated coffee blends</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-3">
                                <div class="bg-primary bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                    <span class="fw-bold text-primary fs-4">3</span>
                                </div>
                                <h6 class="fw-bold">Add Pastry</h6>
                                <small class="text-muted">Perfect pairing (optional)</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Featured Blends Preview -->
            <div class="card bg-dark border-secondary mb-5">
                <div class="card-body p-4">
                    <h3 class="card-title mb-4 text-center">
                        <i class="bi bi-star text-warning me-2"></i>
                        Featured Blends
                    </h3>
                    
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="card bg-secondary h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-sunrise text-warning mb-2" style="font-size: 2rem;"></i>
                                    <h6 class="fw-bold">Morning Boost</h6>
                                    <small class="text-muted">Rich and energizing</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-secondary h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-heart text-danger mb-2" style="font-size: 2rem;"></i>
                                    <h6 class="fw-bold">Classic Comfort</h6>
                                    <small class="text-muted">Smooth and balanced</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-secondary h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-moon text-info mb-2" style="font-size: 2rem;"></i>
                                    <h6 class="fw-bold">Evening Decaf</h6>
                                    <small class="text-muted">Gentle and soothing</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center">
                <div class="d-grid gap-3 d-md-flex justify-content-md-center">
                    <a href="/studio/premade/cup-size" class="btn btn-primary btn-lg px-5">
                        <i class="bi bi-play-fill me-2"></i>Start Ordering
                    </a>
                    <a href="/studio" class="btn btn-outline-secondary btn-lg px-4">
                        <i class="bi bi-arrow-left me-2"></i>Back to Studio
                    </a>
                </div>
                
                <p class="text-muted mt-3 small">
                    <i class="bi bi-clock me-1"></i>
                    Estimated time: 1-2 minutes
                </p>
            </div>

            <!-- Benefits Section -->
            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="card bg-dark border-secondary h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="bi bi-award text-success me-2"></i>
                                Why Choose Premade?
                            </h5>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Expert crafted recipes</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Perfectly balanced flavors</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Quick ordering process</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Consistent quality</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-dark border-secondary h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="bi bi-clock-history text-info me-2"></i>
                                Perfect For
                            </h5>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><i class="bi bi-lightning-fill text-warning me-2"></i>Busy mornings</li>
                                <li class="mb-2"><i class="bi bi-lightning-fill text-warning me-2"></i>Quick coffee breaks</li>
                                <li class="mb-2"><i class="bi bi-lightning-fill text-warning me-2"></i>First-time customers</li>
                                <li class="mb-2"><i class="bi bi-lightning-fill text-warning me-2"></i>Tried & true favorites</li>
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
