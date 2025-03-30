# NexusPress Production Deployment Guide

This package contains a production-ready version of NexusPress, prepared according to the comprehensive deployment checklist. All development files, debug tools, and unnecessary scripts have been removed.

## Contents of the Package

- Core NexusPress files
- Production-optimized `.htaccess` files
- Security-hardened configuration file
- Production verification script

## Deployment Instructions

### 1. Server Requirements

- PHP 8.0 or higher
- MySQL 5.7 or higher (or MariaDB 10.3+)
- Apache with mod_rewrite enabled (or Nginx with proper rewrite rules)
- SSL certificate for your domain

### 2. Database Setup

1. Create a new MySQL database for NexusPress
2. Create a database user with limited permissions:
   - `SELECT`, `INSERT`, `UPDATE`, `DELETE`, `CREATE`, `ALTER`, `INDEX`, `DROP`
3. Note the database name, username, and password for configuration

### 3. Configuration

1. Extract the NexusPress production package to your web server's document root
2. Edit `nx-config.php` and update the following:
   - Database connection details (`DB_NAME`, `DB_USER`, `DB_PASSWORD`, `DB_HOST`)
   - Generate new security keys and salts from https://api.nexuspress.org/secret-key/1.1/salt/
   - Update `NX_SITEURL` and `NX_HOME` to match your production domain
   - Update `COOKIE_DOMAIN` to match your domain

### 4. Permissions

Set the following file permissions:
- Directories: `755` (rwxr-xr-x)
- Files: `644` (rw-r--r--)
- Configuration files: `440` (r--r-----)

```bash
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;
chmod 440 nx-config.php
chmod -R 755 nx-content/uploads
chmod -R 755 nx-content/upgrade
```

### 5. Verification

1. Upload and run the included `production-verify.php` script by accessing it in your browser
2. Check for any warnings or errors and address them
3. DELETE the verification script after use to prevent information disclosure

### 6. Final Steps

1. Test the site thoroughly:
   - Front-end functionality
   - Admin login and dashboard
   - WordPress compatibility redirects
   - Security headers (using a tool like https://securityheaders.com)

2. Set up maintenance procedures:
   - Regular backups (database and files)
   - Security monitoring
   - Update procedure

## Troubleshooting

If you encounter issues during deployment, refer to the `DEPLOYMENT.md` file for a comprehensive list of common problems and their solutions.

Key areas to check:
- Database connection issues
- File permissions
- SSL configuration
- Web server rewrite rules

## Security Notes

This production package includes many security enhancements:

1. File editing is disabled in the admin (`DISALLOW_FILE_EDIT` = true)
2. Plugin/theme installations are disabled (`DISALLOW_FILE_MODS` = true)
3. Admin area requires HTTPS (`FORCE_SSL_ADMIN` = true)
4. Debugging is disabled (`NX_DEBUG` = false)
5. Development mode is disabled (`NX_DEVELOPMENT` = false)
6. Secure cookies are enabled (`COOKIE_HTTPONLY` and `COOKIE_SECURE` = true)
7. Security headers are set in `.htaccess` files

## Contact

For assistance with deployment or issues with the production package, contact your system administrator or NexusPress support. 