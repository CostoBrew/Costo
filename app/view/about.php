<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Costobrew</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/src/css/style.css" rel="stylesheet">
</head>
<body data-bs-theme="dark" class="d-flex flex-column min-vh-100">
<?php include __DIR__ . '/includes/header.php'; ?>
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo url('/'); ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo url('/menu'); ?>">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo url('/about'); ?>">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo url('/contact'); ?>">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- About Content -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <h1 class="display-4 mb-4">About Costobrew</h1>
                    <p class="lead">Crafting exceptional coffee experiences since 2025</p>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body p-5">
                        <h3 class="mb-4">Our Story</h3>
                        <p class="mb-4">
                            Costobrew was born from a passion for exceptional coffee and innovative technology. 
                            Our custom-built PHP MVC framework demonstrates our commitment to crafting everything 
                            from scratch - just like our coffee.
                        </p>

                        <h3 class="mb-4">Our Mission</h3>
                        <p class="mb-4">
                            To deliver premium coffee experiences through cutting-edge technology, ensuring 
                            every cup tells a story of quality, passion, and innovation.
                        </p>

                        <h3 class="mb-4">What Makes Us Special</h3>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="d-flex">
                                    <i class="bi bi-code-square display-6 text-primary me-3"></i>
                                    <div>
                                        <h5>Custom Framework</h5>
                                        <p>Built with our own lightweight PHP MVC framework for optimal performance.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex">
                                    <i class="bi bi-shield-check display-6 text-success me-3"></i>
                                    <div>
                                        <h5>Security First</h5>
                                        <p>Enterprise-level security with CSRF protection, rate limiting, and more.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex">
                                    <i class="bi bi-lightning display-6 text-warning me-3"></i>
                                    <div>
                                        <h5>Fast & Efficient</h5>
                                        <p>Optimized for speed with minimal overhead and smart caching.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex">
                                    <i class="bi bi-cup-hot display-6 text-danger me-3"></i>
                                    <div>
                                        <h5>Premium Coffee</h5>
                                        <p>Hand-selected beans from the finest coffee regions worldwide.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-5">

                        <div class="text-center">
                            <h3 class="mb-4">Ready to Experience Costobrew?</h3>
                            <div class="d-flex gap-3 justify-content-center">
                                <a href="<?php echo url('/menu'); ?>" class="btn btn-primary">
                                    <i class="bi bi-cup-hot"></i> Browse Menu
                                </a>
                                <a href="<?php echo url('/contact'); ?>" class="btn btn-outline-primary">
                                    <i class="bi bi-envelope"></i> Contact Us
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container text-center">
            <p>&copy; 2025 Costobrew. Made with <i class="bi bi-heart text-danger"></i> and lots of coffee.</p>
        </div>
    </footer><?php include __DIR__ . '/includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
