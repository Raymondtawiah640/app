# Laravel Application Deployment Guide

## Prerequisites
- Web server (Apache/Nginx)
- PHP 8.1 or higher
- MySQL or compatible database
- Composer
- Node.js and npm (for asset compilation)

## Step 1: Prepare Application Locally
```bash
# Install dependencies
composer install --optimize-autoloader --no-dev

# Build assets
npm run build

# Set production environment
# Edit .env file:
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

## Step 2: Upload Files to Server
- Upload all project files to your web server
- Exclude `node_modules/` directory
- Use FTP, SCP, or hosting file manager
- Ensure `public/` directory is web-accessible

## Step 3: Configure Server Environment
```bash
# On server, copy environment file
cp .env.example .env

# Edit .env with production values:
APP_NAME="Your App Name"
APP_ENV=production
APP_KEY=  # Will generate later
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_db_username
DB_PASSWORD=your_db_password

# Other settings as needed
```

## Step 4: Install Dependencies on Server
```bash
# Install PHP dependencies
composer install --optimize-autoloader --no-dev
```

## Step 5: Generate Application Key
```bash
php artisan key:generate
```

## Step 6: Database Setup
```bash
# Run migrations
php artisan migrate

# Optional: Seed database
php artisan db:seed
```

## Step 7: Optimize Application
```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Create storage link for file uploads
php artisan storage:link
```

## Step 8: Set File Permissions
```bash
# Set proper permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# Ensure web server can write to these directories
# chown -R www-data:www-data storage/
# chown -R www-data:www-data bootstrap/cache/
```

## Step 9: Web Server Configuration

### Apache
- Ensure `.htaccess` exists in `public/` directory
- Point document root to `public/` directory

### Nginx Example
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/your/app/public;

    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

## Step 10: SSL Certificate
- Obtain SSL certificate (Let's Encrypt recommended)
- Configure HTTPS
- Update APP_URL to use https://

## Step 11: Testing
- Visit your domain
- Test all functionality:
  - Home page
  - Registration
  - Login
  - Authentication flow
- Check browser console for errors
- Verify database connections

## Step 12: Monitoring & Maintenance
- Set up error logging
- Configure backups
- Monitor server resources
- Keep dependencies updated

## Troubleshooting
- Clear caches if issues: `php artisan cache:clear`
- Check logs: `storage/logs/laravel.log`
- Verify file permissions
- Ensure database connectivity

## Security Checklist
- [ ] APP_DEBUG=false in production
- [ ] Secure APP_KEY generated
- [ ] Database credentials not in version control
- [ ] File permissions correct
- [ ] SSL certificate installed
- [ ] Regular backups configured
- [ ] Dependencies updated regularly