<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | Costobrew</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/src/css/style.css" rel="stylesheet">
</head>
<body data-bs-theme="dark" class="d-flex flex-column min-vh-100">
<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="container my-5 flex-grow-1 d-flex align-items-center justify-content-center">
    <div class="text-center">
        <div class="mb-4">
            <i class="bi bi-cup-hot-fill text-primary" style="font-size: 6rem;"></i>
        </div>
        <h1 class="display-1 fw-bold text-primary">404</h1>
        <h2 class="mb-4">Oops! Page Not Found</h2>
        <p class="lead mb-4">
            Looks like this page took a coffee break and never came back!<br>
            The page you're looking for doesn't exist.
        </p>        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="/" class="btn btn-primary btn-lg">
                <i class="bi bi-house me-2"></i>Go Home
            </a>
            <a href="/studio" class="btn btn-outline-primary btn-lg">
                <i class="bi bi-cup me-2"></i>Coffee Studio
            </a>
            <a href="/menu" class="btn btn-outline-secondary btn-lg">
                <i class="bi bi-menu-button-wide me-2"></i>Browse Menu
            </a>
        </div>
        
        <div class="mt-5">
            <p class="text-muted">
                Need help? <a href="/contact" class="text-decoration-none">Contact us</a> 
                or check out our <a href="/help" class="text-decoration-none">help center</a>.
            </p>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
            padding: 3rem;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            max-width: 500px;
            margin: 20px;
        }
        .error-code {
            font-size: 6rem;
            font-weight: bold;
            color: #667eea;
            margin: 0;
            line-height: 1;
        }
        .error-message {
            font-size: 1.5rem;
            color: #4a5568;
            margin: 1rem 0 2rem;
        }
        .error-description {
            color: #718096;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            transition: background 0.3s ease;
        }
        .btn:hover {
            background: #5a67d8;
        }
        .coffee-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="coffee-icon">☕</div>
        <h1 class="error-code">404</h1>
        <h2 class="error-message">Page Not Found</h2>
        <p class="error-description">
            Sorry, the page you're looking for doesn't exist. 
            It might have been moved, deleted, or you entered the wrong URL.
        </p>
        <a href="<?php echo url('/'); ?>" class="btn">Back to Home</a>
    </div>
</body>
</html>
