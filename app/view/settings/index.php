<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Costobrew</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/src/css/style.css" rel="stylesheet">
</head>
<body data-bs-theme="dark" class="d-flex flex-column min-vh-100">
<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="container my-5 flex-grow-1">
    <div class="settings-container">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">
                    <i class="bi bi-gear me-2"></i>Settings
                </h1>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-3">
                <div class="card bg-dark border-secondary">
                    <div class="card-body">
                        <h5 class="card-title">Settings Menu</h5>
                        <nav class="settings-nav">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <a href="/settings/account" class="text-decoration-none d-flex align-items-center">
                                        <i class="bi bi-person me-2"></i>Account Information
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="/settings/security" class="text-decoration-none d-flex align-items-center">
                                        <i class="bi bi-shield-lock me-2"></i>Security
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="/settings/notifications" class="text-decoration-none d-flex align-items-center">
                                        <i class="bi bi-bell me-2"></i>Notifications
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="/settings/cookies" class="text-decoration-none d-flex align-items-center">
                                        <i class="bi bi-cookie me-2"></i>Cookie Policy
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            
            <div class="col-md-9">
                <div class="card bg-dark border-secondary">
                    <div class="card-body">
                        <h5 class="card-title">Welcome to Settings</h5>
                        <p class="card-text">Select a settings category from the menu to get started.</p>
                        
                        <div class="row mt-4">
                            <div class="col-md-6 mb-3">
                                <div class="card bg-secondary">
                                    <div class="card-body text-center">
                                        <i class="bi bi-person-circle fs-1 text-primary"></i>
                                        <h6 class="mt-2">Account</h6>
                                        <p class="small">Manage your profile and personal information</p>
                                        <a href="/settings/account" class="btn btn-primary btn-sm">Manage Account</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card bg-secondary">
                                    <div class="card-body text-center">
                                        <i class="bi bi-shield-check fs-1 text-success"></i>
                                        <h6 class="mt-2">Security</h6>
                                        <p class="small">Update your security settings and password</p>
                                        <a href="/settings/security" class="btn btn-success btn-sm">Security Settings</a>
                                    </div>
                                </div>
                            </div>
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
