# NexusPress Installation Guide

## Overview
This guide provides detailed instructions for installing NexusPress on your server. Follow these steps carefully to ensure a successful installation.

## Prerequisites
Before beginning the installation, ensure you have:
1. A web server (Apache or Nginx)
2. PHP 7.4 or higher
3. MySQL 5.6 or higher
4. Required PHP extensions
5. Sufficient disk space
6. Command-line access to your server

## Installation Steps

### 1. Download and Extract
1. Download the latest NexusPress release
2. Extract the files to your web server directory:
   ```bash
   tar -xzf nexuspress-latest.tar.gz
   mv nexuspress/* /path/to/your/web/root/
   ```

### 2. Set Permissions
1. Set directory permissions:
   ```bash
   chmod 755 /path/to/your/web/root/
   chmod 755 /path/to/your/web/root/nx-admin/
   chmod 755 /path/to/your/web/root/nx-content/
   chmod 755 /path/to/your/web/root/nx-includes/
   ```

2. Set file permissions:
   ```bash
   find /path/to/your/web/root/ -type f -exec chmod 644 {} \;
   ```

### 3. Create Configuration File
1. Copy the sample configuration file:
   ```bash
   cp nx-config-sample.php nx-config.php
   ```

2. Edit the configuration file:
   ```php
   // Database settings
   define('DB_NAME', 'your_database_name');
   define('DB_USER', 'your_database_user');
   define('DB_PASSWORD', 'your_database_password');
   define('DB_HOST', 'localhost');
   
   // Security keys
   define('AUTH_KEY',         'your-unique-phrase');
   define('SECURE_AUTH_KEY',  'your-unique-phrase');
   define('LOGGED_IN_KEY',    'your-unique-phrase');
   define('NONCE_KEY',        'your-unique-phrase');
   define('AUTH_SALT',        'your-unique-phrase');
   define('SECURE_AUTH_SALT', 'your-unique-phrase');
   define('LOGGED_IN_SALT',   'your-unique-phrase');
   define('NONCE_SALT',       'your-unique-phrase');
   
   // Database table prefix
   $table_prefix = 'nx_';
   
   // Site URL
   define('SITE_URL', 'https://your-domain.com');
   ```

### 4. Create Database
1. Create a new MySQL database:
   ```sql
   CREATE DATABASE your_database_name CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

2. Create a database user:
   ```sql
   CREATE USER 'your_database_user'@'localhost' IDENTIFIED BY 'your_database_password';
   GRANT ALL PRIVILEGES ON your_database_name.* TO 'your_database_user'@'localhost';
   FLUSH PRIVILEGES;
   ```

### 5. Run Installation Script
1. Navigate to the admin directory:
   ```bash
   cd nx-admin
   ```

2. Run the installation script:
   ```bash
   php install.php
   ```

### 6. Configure Web Server

#### Apache Configuration
1. Create or edit `.htaccess` file:
   ```apache
   RewriteEngine On
   RewriteBase /
   
   RewriteRule ^index\.php$ - [L]
   RewriteCond %{REQUEST_FILENAME} !-f
   RewriteCond %{REQUEST_FILENAME} !-d
   RewriteRule . /index.php [L]
   ```

2. Enable required modules:
   ```bash
   a2enmod rewrite
   a2enmod headers
   service apache2 restart
   ```

#### Nginx Configuration
1. Create server block configuration:
   ```nginx
   server {
       listen 80;
       server_name your-domain.com;
       root /path/to/your/web/root;
       index index.php;
   
       location / {
           try_files $uri $uri/ /index.php?$args;
       }
   
       location ~ \.php$ {
           include snippets/fastcgi-php.conf;
           fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
       }
   }
   ```

### 7. Final Configuration
1. Access the admin panel:
   - Visit: `https://your-domain.com/nx-admin/`
   - Log in with default credentials
   - Change the admin password

2. Configure site settings:
   - Site title
   - Site description
   - Time zone
   - Date format
   - Language

### 8. Security Setup
1. Set secure file permissions:
   ```bash
   chmod 600 nx-config.php
   chmod 600 .htaccess
   ```

2. Configure SSL certificate:
   ```bash
   certbot --apache -d your-domain.com
   ```

### 9. Post-Installation Tasks
1. Update all components:
   - Core system
   - Plugins
   - Themes

2. Configure backup system:
   ```bash
   php nx-admin/backup-db.php
   ```

3. Set up monitoring:
   - Error logging
   - Performance monitoring
   - Security monitoring

## Troubleshooting

### Common Issues
1. Database Connection Errors
   - Verify database credentials
   - Check MySQL service status
   - Confirm database exists

2. Permission Issues
   - Check file ownership
   - Verify directory permissions
   - Review web server configuration

3. 500 Internal Server Error
   - Check PHP error logs
   - Verify PHP version
   - Confirm required extensions

### Recovery Procedures
1. Restore from backup:
   ```bash
   php nx-admin/restore-db.php
   ```

2. Reset configuration:
   ```bash
   cp nx-config-sample.php nx-config.php
   ```

3. Verify installation:
   ```bash
   php nx-admin/verify-db.php
   ```

## Maintenance

### Regular Tasks
1. Database backups
2. System updates
3. Security patches
4. Performance optimization
5. Log rotation

### Update Process
1. Backup system
2. Download updates
3. Apply updates
4. Verify functionality
5. Test custom features

## Support
For additional support:
- Check the documentation
- Review error logs
- Contact technical support
- Join the community forum 