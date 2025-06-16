# Costobrew Coffee Studio Web Application

A modern, secure web application for coffee enthusiasts built with PHP and Firebase Authentication.

## Features

- 🔥 **Firebase Authentication** - Secure user registration and login
- ☕ **Coffee Studio** - DIY and premade coffee customization
- 🛍️ **Shopping Cart** - Add and manage coffee orders
- 👥 **Community** - Browse coffee products and reviews
- ⚙️ **User Settings** - Account management and preferences
- 🔒 **Security** - CSRF protection, rate limiting, and secure headers
- 📱 **Responsive Design** - Beautiful UI with Bootstrap and custom styling

## Requirements

- PHP 7.4 or higher
- Composer
- Web server (Apache/Nginx)
- Firebase project

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/costobrew.git
cd costobrew
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Setup

1. Copy the environment example file:
```bash
cp .env.example .env
```

2. Update the `.env` file with your configuration:
```env
# Application Environment
APP_ENV=development
APP_URL=http://localhost:8000

# Database Configuration
DB_HOST=localhost
DB_PORT=3306
DB_NAME=costobrew_v2
DB_USER=root
DB_PASS=your_password
DB_CHARSET=utf8mb4

# Firebase Authentication
FIREBASE_PROJECT_ID=your-firebase-project-id
FIREBASE_SERVICE_ACCOUNT_PATH=./config/firebase-service-account.json
REQUIRE_EMAIL_VERIFICATION=false
MAX_TOKEN_AGE=3600
USER_RATE_LIMIT=100
```

### 4. Firebase Setup

Firebase authentication is required for user management. Follow these steps:

#### Option 1: Use the Setup Wizard
1. Start your web server
2. Visit `http://localhost:8000/firebase-setup.php`
3. Follow the step-by-step instructions

#### Option 2: Manual Setup
1. Go to [Firebase Console](https://console.firebase.google.com/)
2. Create a new project
3. Enable Authentication with Email/Password
4. Create a service account:
   - Go to Project Settings → Service Accounts
   - Generate new private key
   - Download the JSON file
   - Save as `config/firebase-service-account.json`
5. Get your web app config:
   - Project Settings → General → Your apps
   - Add web app
   - Copy the config object
6. Update the Firebase config in:
   - `app/view/auth/login.php`
   - `app/view/auth/signup.php`

### 5. Database Setup (Optional)

If you're using a database, create the database and update the connection details in `.env`.

### 6. Web Server Configuration

#### Apache
Make sure your `.htaccess` file has the following content:
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]

# Security headers
Header always set X-Frame-Options DENY
Header always set X-Content-Type-Options nosniff
Header always set X-XSS-Protection "1; mode=block"
Header always set Referrer-Policy "strict-origin-when-cross-origin"

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
