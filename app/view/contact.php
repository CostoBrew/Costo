<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Costobrew</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/src/css/style.css" rel="stylesheet">
</head>
<body data-bs-theme="dark" class="d-flex flex-column min-vh-100">
<?php include __DIR__ . '/includes/header.php'; ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo url('/contact'); ?>">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contact Content -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <h1 class="display-4 mb-4">Contact Us</h1>
                    <p class="lead">Get in touch with the Costobrew team</p>
                </div>

                <div class="row g-5">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <h3 class="card-title mb-4">Get In Touch</h3>
                                
                                <div class="mb-3">
                                    <i class="bi bi-geo-alt text-primary me-2"></i>
                                    <strong>Address:</strong><br>
                                    123 Coffee Street<br>
                                    Bean City, BC 12345
                                </div>

                                <div class="mb-3">
                                    <i class="bi bi-telephone text-primary me-2"></i>
                                    <strong>Phone:</strong><br>
                                    (555) 123-BREW
                                </div>

                                <div class="mb-3">
                                    <i class="bi bi-envelope text-primary me-2"></i>
                                    <strong>Email:</strong><br>
                                    hello@costobrew.com
                                </div>

                                <div class="mb-3">
                                    <i class="bi bi-clock text-primary me-2"></i>
                                    <strong>Hours:</strong><br>
                                    Mon-Fri: 6:00 AM - 8:00 PM<br>
                                    Sat-Sun: 7:00 AM - 9:00 PM
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <h3 class="card-title mb-4">Send us a message</h3>
                                
                                <p class="text-muted mb-4">
                                    <i class="bi bi-info-circle"></i> 
                                    Contact form functionality requires additional backend setup.
                                </p>

                                <form>
                                    <?php echo csrf_field(); ?>
                                    
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="subject" class="form-label">Subject</label>
                                        <input type="text" class="form-control" id="subject" name="subject" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="message" class="form-label">Message</label>
                                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-send"></i> Send Message
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    <?php include __DIR__ . '/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
