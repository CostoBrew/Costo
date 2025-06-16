    <!-- Global Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark navi-bg fixed-top">
        <div class="container-fluid px-5 py-3">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="/src/assets/CBL2.png" alt="CostoBrew" height="20" class="me-2">
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Nav Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Left side nav links (next to logo) -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>                    <li class="nav-item">
                        <a class="nav-link" href="/studio">Coffee Studio</a>
                    </li><li class="nav-item">
                        <a class="nav-link" href="/#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#contact">Contact</a>
                    </li>
                </ul>

                <!-- Right side nav links (cart + user menu) -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="/cart">
                            <i class="bi bi-cart fs-5"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">0</span>
                        </a>
                    </li>                    <li class="nav-item dropdown">
                        <?php
                        // Check if user is logged in
                        if (session_status() === PHP_SESSION_NONE) {
                            session_start();
                        }
                        
                        $isLoggedIn = isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated'] === true;
                        $userName = $_SESSION['user_name'] ?? '';
                        $userEmail = $_SESSION['user_email'] ?? '';
                        
                        if ($isLoggedIn) {
                            // Show user name or email if name is not available
                            $displayName = !empty($userName) ? $userName : $userEmail;
                            $firstName = !empty($userName) ? explode(' ', $userName)[0] : explode('@', $userEmail)[0];
                        ?>
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle fs-5 me-2"></i>
                                <span class="d-none d-md-inline"><?= htmlspecialchars($firstName) ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                                <li class="dropdown-header">
                                    <small class="text-muted">Signed in as</small><br>
                                    <strong><?= htmlspecialchars($displayName) ?></strong>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/settings">
                                    <i class="bi bi-gear me-2"></i>Settings
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="/logout">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </a></li>
                            </ul>
                        <?php } else { ?>
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle fs-5"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                                <li><a class="dropdown-item" href="/login">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Login
                                </a></li>
                                <li><a class="dropdown-item" href="/signup">
                                    <i class="bi bi-person-plus me-2"></i>Sign Up
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li class="dropdown-item-text text-muted">
                                    <small>Please login to access your account</small>
                                </li>
                            </ul>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>