# ☕ Costobrew - Coffee Studio Web Application

A modern, responsive web application for custom coffee blending and ordering, featuring Firebase authentication, Google Sign-In, and an interactive Coffee Studio for creating personalized coffee blends.

> 👥 **Team Project Setup:** This is a collaborative team project. Firebase configuration and environment files will be provided by the project lead. Follow the setup instructions below to get started.

## ✨ Features

- **🔥 Firebase Authentication** - Secure user authentication with Google Sign-In integration
- **☕ Coffee Studio** - Interactive DIY coffee blending and premade selections
- **🛒 Shopping Cart** - Add custom blends to cart and manage orders
- **📱 Responsive Design** - Mobile-first design with Bootstrap 5
- **🎨 Modern UI** - Apple Garamond typography and coffee-themed design
- **🔒 Security** - CSRF protection, rate limiting, and secure middleware

## 🚀 Quick Start

### Prerequisites

- **PHP 7.4+** (Recommended: PHP 8.1+)
- **Composer** (Dependency manager)
- **Git** (Version control)

> 📝 **Note:** This is a team project. Firebase keys and environment configuration will be provided by the project lead.

### 1. Clone & Install

```bash
# Clone the repository
git clone <team-repo-url> costobrew
cd costobrew

# Install PHP dependencies
composer install
```

### 2. Get Project Files from Team Lead

**Contact the project lead to obtain:**
- `.env` file (environment configuration)
- `config/firebase-service-account.json` (Firebase authentication keys)

Place these files in the project root and config directory respectively.

> ⚠️ **Important:** Never commit `.env` or Firebase service account files to version control!

### 3. Start Development Server

```bash
# Start PHP development server
php -S localhost:8000

# Application will be available at:
# http://localhost:8000
```

### 4. Verify Setup

1. Open browser to `http://localhost:8000`
2. Test Firebase authentication by trying to login/signup
3. Explore Coffee Studio features

> 🎉 **You're ready to develop!** The application should be running with full Firebase authentication.

### 4. Firebase Configuration

#### Step 1: Create Firebase Project
1. Go to [Firebase Console](https://console.firebase.google.com/)
2. Create a new project
3. Enable Authentication > Sign-in method > Google

#### Step 2: Get Service Account
1. Project Settings > Service Accounts
2. Generate new private key
3. Save as `config/firebase-service-account.json`

#### Step 3: Get Web Config
1. Project Settings > General > Your apps
2. Add web app and copy config
3. Update `.env` with the values

**Example `config/firebase-service-account.json`:**
```json
{
  "type": "service_account",
  "project_id": "your-project-id",
  "private_key_id": "...",
  "private_key": "...",
  "client_email": "...",
  "client_id": "...",
  "auth_uri": "...",
  "token_uri": "...",
  "auth_provider_x509_cert_url": "...",
  "client_x509_cert_url": "..."
}
```

> 📋 **Detailed Firebase setup instructions:** See `FIREBASE_SETUP.md`
> � **Google Sign-In setup instructions:** See `GOOGLE_SIGNIN_SETUP.md`

### 5. Web Server Configuration

#### Apache (.htaccess included)
```apache
# Ensure mod_rewrite is enabled
# .htaccess file is already configured
```

#### Nginx
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/costobrew;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

#### PHP Built-in Server (Development)
```bash
php -S localhost:8000 -t public index.php
```

### 6. File Permissions

```bash
# Make cache and logs writable
chmod -R 755 cache/
chmod -R 755 logs/

# Secure sensitive files
chmod 600 .env
chmod 600 config/firebase-service-account.json
```

## 📁 Project Structure

```
costobrew/
├── app/
│   ├── config/          # Configuration files
│   ├── controller/      # Application controllers
│   ├── core/           # Core framework files
│   ├── middleware/     # Security & auth middleware
│   ├── model/          # Data models
│   └── view/           # HTML templates
├── cache/              # Application cache
├── logs/               # Application logs
├── src/
│   ├── assets/         # Images & static files
│   ├── css/           # Stylesheets
│   └── js/            # JavaScript files
├── config/            # Firebase & external configs
├── .env               # Environment variables
├── .htaccess          # Apache configuration
├── composer.json      # PHP dependencies
└── index.php          # Application entry point
```

## 🔧 Development

### Running Locally
```bash
# Start PHP development server (this is what we use)
php -S localhost:8000
```

> 📝 **Team Note:** We use the PHP built-in development server for this project. No need for XAMPP/WAMP.

### Key URLs
- **Home:** `/`
- **Coffee Studio:** `/studio`
- **DIY Blends:** `/studio/diy`
- **Premade Blends:** `/studio/premade`
- **Login:** `/login`
- **Cart:** `/cart`

### Debugging
```bash
# Check PHP errors
tail -f logs/php-error.log

# Test Firebase connection
php -r "require 'vendor/autoload.php'; echo 'Dependencies loaded successfully';"
```

## 🛡️ Security Features

- **CSRF Protection** - All forms protected with CSRF tokens
- **Rate Limiting** - Prevents brute force attacks
- **Input Validation** - Server-side validation for all inputs
- **Secure Headers** - CSP, HSTS, and security headers
- **Firebase Auth** - Industry-standard authentication

## 📱 Browser Support

- **Chrome** 90+ ✅
- **Firefox** 88+ ✅
- **Safari** 14+ ✅
- **Edge** 90+ ✅
- **Mobile browsers** ✅

## 🚀 Production Deployment

### 1. Environment Setup
```bash
# Set production environment
APP_ENV=production
FIREBASE_DISABLE_SSL_VERIFY=false
```

### 2. Optimization
```bash
# Optimize Composer autoloader
composer install --no-dev --optimize-autoloader

# Clear development cache
rm -rf cache/*
```

### 3. Security Checklist
- [ ] Update all default passwords
- [ ] Enable HTTPS
- [ ] Configure proper file permissions
- [ ] Set up regular backups
- [ ] Monitor logs for security issues
- [ ] Update `.env` with production values

## 🔍 Troubleshooting

### Common Issues

**1. Firebase Authentication Not Working**
```bash
# Check service account file exists
ls -la config/firebase-service-account.json

# Verify environment variables
cat .env | grep FIREBASE
```

**2. Database Connection Issues**
```bash
# Test database connection
php -r "
$pdo = new PDO('mysql:host=localhost;dbname=costobrew_db', 'user', 'pass');
echo 'Database connected successfully';
"
```

**3. 404 Errors**
- Ensure `.htaccess` is in place for Apache
- Check web server URL rewriting is enabled
- Verify `index.php` is in the correct location

**4. Permission Errors**
```bash
# Fix file permissions
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod 600 .env config/firebase-service-account.json
```

## 📞 Support

For setup assistance or bug reports:
- **Email:** support@costobrew.com
- **Documentation:** Check `FIREBASE_SETUP.md` and `GOOGLE_SIGNIN_SETUP.md`

## 📄 License

This project is proprietary software. All rights reserved.

---

Made with ☕ by the Costobrew Team

# Prevent access to PHP files in certain directories
<FilesMatch "\.php$">
    <RequireAll>
        Require all denied
        <RequireAny>
            Require expr "%{REQUEST_URI} =~ m#^/index\.php#"
            Require expr "%{REQUEST_URI} =~ m#^/firebase-setup\.php#"
            Require expr "%{REQUEST_URI} =~ m#^/test-routes\.php#"
        </RequireAny>
    </RequireAll>
</FilesMatch>
```

#### Nginx
```nginx
server {
    listen 80;
    server_name localhost;
    root /path/to/costobrew;
    index index.php;

    # Security headers
    add_header X-Frame-Options DENY always;
    add_header X-Content-Type-Options nosniff always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;

    # Route all requests to index.php
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # PHP processing
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Deny access to sensitive files
    location ~ /\. {
        deny all;
    }
    
    location ~ /(config|app)/ {
        deny all;
    }
}
```

## Usage

### Starting the Application

1. Start your web server
2. Visit `http://localhost:8000`
3. Use `/firebase-setup.php` to verify your Firebase configuration
4. Register a new account or login

### Available Routes

#### Public Routes
- `/` - Homepage
- `/login` - User login
- `/signup` - User registration
- `/community` - Browse products
- `/community/product/{id}` - Product details

#### Protected Routes (Require Authentication)
- `/studio` - Coffee Studio main page
- `/studio/diy` - DIY coffee builder
- `/studio/premade` - Premade coffee selection
- `/cart` - Shopping cart
- `/checkout` - Order checkout
- `/orders` - Order history
- `/settings` - User settings

### API Endpoints
- `GET /api/auth/check` - Check authentication status
- `GET /api/auth/user` - Get current user info
- `POST /logout` - Logout user

## Security Features

- **Firebase Authentication** - Secure token-based authentication
- **CSRF Protection** - Prevents cross-site request forgery
- **Rate Limiting** - Prevents abuse and spam
- **Security Headers** - XSS protection, content type sniffing prevention
- **Input Validation** - Server-side validation for all inputs
- **Secure Sessions** - HTTP-only, secure cookies in production

## Project Structure

```
costobrew/
├── app/
│   ├── config/          # Configuration files
│   │   ├── database.php
│   │   └── firebase.php
│   ├── controller/      # Application controllers
│   ├── core/           # Core framework files
│   ├── middleware/     # Security and auth middleware
│   ├── model/          # Data models
│   └── view/           # HTML templates
├── config/             # Configuration directory
├── src/                # Static assets
│   ├── css/
│   ├── js/
│   └── assets/
├── vendor/             # Composer dependencies
├── .env                # Environment configuration
├── composer.json       # PHP dependencies
├── index.php          # Application entry point
└── firebase-setup.php # Firebase setup wizard
```

## Troubleshooting

### Firebase Issues
1. Check `firebase-setup.php` for configuration status
2. Verify service account file exists and has correct permissions
3. Ensure Firebase project has Authentication enabled
4. Check browser console for JavaScript errors

### Permission Issues
```bash
# Make sure web server can read files
chmod 644 .env
chmod 644 config/firebase-service-account.json
chmod -R 755 app/ src/
```

### Composer Issues
```bash
# Clear composer cache
composer clear-cache
composer install --no-cache
```

## Development

### Adding New Routes
```php
// In index.php
$router->get('/new-route', 'ControllerName@method', ['FirebaseAuthMiddleware']);
```

### Creating Middleware
```php
// In app/middleware/
class CustomMiddleware {
    public static function handle($request) {
        // Middleware logic
    }
}
```

### Environment Variables
All configuration should use environment variables defined in `.env`:
```php
$setting = $_ENV['SETTING_NAME'] ?? 'default_value';
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support and questions:
- Check the `/firebase-setup.php` page for configuration help
- Review the troubleshooting section above
- Create an issue on GitHub

---

**Note**: Make sure to keep your Firebase service account key secure and never commit it to version control!
