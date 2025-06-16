<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Internal Server Error | Costobrew</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/src/css/style.css" rel="stylesheet">
</head>
<body data-bs-theme="dark" class="d-flex flex-column min-vh-100">
    <?php include __DIR__ . '/../includes/header.php'; ?>
    
    <main class="container my-5 flex-grow-1 d-flex align-items-center justify-content-center">
        <div class="text-center">
            <div class="mb-4">
                <i class="bi bi-exclamation-triangle-fill text-warning" style="font-size: 6rem;"></i>
            </div>
            
            <h1 class="display-4 fw-bold mb-3 text-warning">500</h1>
            <h2 class="h3 mb-4">Internal Server Error</h2>
            
            <p class="lead mb-4 text-muted">
                Oops! Something went wrong on our end. Our coffee machines seem to be having a technical difficulty.
            </p>
            
            <div class="row justify-content-center mb-5">
                <div class="col-md-8">
                    <div class="card bg-dark border-secondary">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="bi bi-tools me-2"></i>
                                What can you do?
                            </h5>
                            <ul class="list-unstyled text-start">
                                <li class="mb-2">
                                    <i class="bi bi-arrow-clockwise text-primary me-2"></i>
                                    Try refreshing the page
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-clock text-primary me-2"></i>
                                    Wait a few minutes and try again
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-house text-primary me-2"></i>
                                    Go back to the home page
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-envelope text-primary me-2"></i>
                                    Contact our support team if the problem persists
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                <a href="/" class="btn btn-primary btn-lg">
                    <i class="bi bi-house me-2"></i>
                    Back to Home
                </a>
                <a href="javascript:history.back()" class="btn btn-outline-secondary btn-lg">
                    <i class="bi bi-arrow-left me-2"></i>
                    Go Back
                </a>
                <a href="/#contact" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-envelope me-2"></i>
                    Contact Support
                </a>
            </div>
            
            <div class="mt-5 text-muted">
                <small>
                    Error occurred at: <?= date('Y-m-d H:i:s') ?>
                </small>
            </div>
        </div>
    </main>
    
    <?php include __DIR__ . '/../includes/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
