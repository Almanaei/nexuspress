# NexusPress Production Deployment Checklist

This document outlines the comprehensive steps required to ensure NexusPress is 100% ready for production deployment.

## Pre-Deployment Verification

- [ ] Remove all development-specific files:
  - [ ] `nx-admin/dev-dashboard.php`
  - [ ] `nx-admin/dev-stubs.php`
  - [ ] `nx-admin/dev-override.php`
  - [ ] `nx-admin/dev-bootstrap.php`
  - [ ] `nx-admin/dev-simple-admin.php`
  - [ ] `nx-admin/dev-skip-upgrade.php`
  - [ ] `nx-admin/nx-dashboard.php` (if only used for development)
  - [ ] `dev-router.php`
  - [ ] `dev-simple-admin.php`
  - [ ] `debug.php`
  - [ ] `debug-loader.php`
  - [ ] `debug-template.php`
  - [ ] `error-monitor.php` 
  - [ ] `start-error-monitor.sh` and `start-error-monitor.bat`
  - [ ] `test-error.php`
  - [ ] Any other `dev-*` or `debug-*` files not needed in production

- [ ] Configure production database credentials:
  - [ ] Copy `production-config.php` to `nx-config.php`
  - [ ] Update database connection details (DB_NAME, DB_USER, DB_PASSWORD, DB_HOST)
  - [ ] Generate new security keys and salts using the provided URL
  - [ ] Update site URLs to match production domain
  - [ ] Update table prefix (for security)

- [ ] Security hardening:
  - [ ] Ensure `DISALLOW_FILE_EDIT` is set to `true` in production
  - [ ] Ensure `DISALLOW_FILE_MODS` is set to `true` in production 
  - [ ] Set `FORCE_SSL_ADMIN` to `true` to force HTTPS for admin area
  - [ ] Set `NX_DEBUG` to `false` in production
  - [ ] Set `NX_DEBUG_DISPLAY` to `false` in production
  - [ ] Set `NX_DEBUG_LOG` to `false` in production (or a specific path)
  - [ ] Ensure no `NX_DEVELOPMENT` or `NX_DEVELOPMENT_MODE` constants are defined or set them to false
  - [ ] Remove or set `NX_DIRECT_ADMIN_ACCESS` to `false`

## Code Verification

- [ ] Search for and remove development backdoors:
  - [ ] Search for `NX_DEVELOPMENT` and make sure it's not enabled
  - [ ] Search for `NX_DEBUG` and ensure it's set to false
  - [ ] Search for authentication bypasses in admin files
  - [ ] Check for hardcoded credentials

- [ ] Verify `.htaccess` files:
  - [ ] Main `.htaccess` has proper WordPress → NexusPress 301 redirects
  - [ ] Admin `.htaccess` has proper security headers
  - [ ] Force HTTPS for admin areas
  - [ ] Protect sensitive files

- [ ] File permissions check:
  - [ ] Plan to set proper file permissions on the server:
    - [ ] Directories: 755 (rwxr-xr-x)
    - [ ] Files: 644 (rw-r--r--)
    - [ ] Configuration files: 440 (r--r-----)

## Deployment Process

1. **Prepare Files for Upload**
   - [ ] Create a clean production copy without:
     - [ ] Version control (.git) folders
     - [ ] Development files and tools
     - [ ] Backup files (*.bak, etc.)
     - [ ] Log files and temporary files
   - [ ] Run optimizations if needed (minify JS/CSS, etc.)

2. **Database Setup**
   - [ ] Create production database
   - [ ] Create database user with limited permissions (SELECT, INSERT, UPDATE, DELETE)
   - [ ] Import database schema and initial data

3. **File Upload**
   - [ ] Upload all files to production server
   - [ ] Set proper file permissions
   - [ ] Double-check `.htaccess` files are properly uploaded

4. **Web Server Configuration**
   - [ ] Ensure web server is configured to use HTTPS
   - [ ] Set up proper caching headers
   - [ ] Configure any needed redirects at the web server level

5. **Testing**
   - [ ] Test front-end functionality
   - [ ] Test admin login and redirects
   - [ ] Test WordPress compatibility redirects (wp-admin → nx-admin)
   - [ ] Test forms and key functionality
   - [ ] Verify proper security headers are being set

## Final Verification

- [ ] Security scan:
  - [ ] Scan for any remaining development files
  - [ ] Verify no debug information is displayed
  - [ ] Check all admin pages require proper authentication
  - [ ] Verify WordPress compatibility redirects work correctly

- [ ] Performance check:
  - [ ] Verify caching is working correctly
  - [ ] Check page load speeds
  - [ ] Verify site doesn't show PHP errors/warnings

- [ ] Authentication flow:
  - [ ] Verify login works correctly
  - [ ] Test login redirects
  - [ ] Confirm logout functionality
  - [ ] Test password reset flow

## Post-Deployment Tasks

- [ ] Set up regular backups
- [ ] Configure monitoring
- [ ] Setup security scanning
- [ ] Document any custom configurations

## Final Verification Script

```php
<?php
/**
 * NexusPress Production Verification Script
 * 
 * Upload this file to your production server, run it once, and then delete it.
 * This script checks for common production security issues.
 */

// Set strict error reporting for the test
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>NexusPress Production Security Verification</h1>";

// Check if running in production environment
$is_production = true;
if (defined('NX_DEVELOPMENT') && NX_DEVELOPMENT) {
    echo "<p style='color:red'>❌ NX_DEVELOPMENT is set to true. This should be false in production.</p>";
    $is_production = false;
} else {
    echo "<p style='color:green'>✅ NX_DEVELOPMENT is properly disabled.</p>";
}

// Check for debug settings
if (defined('NX_DEBUG') && NX_DEBUG) {
    echo "<p style='color:red'>❌ NX_DEBUG is enabled. This should be disabled in production.</p>";
    $is_production = false;
} else {
    echo "<p style='color:green'>✅ NX_DEBUG is properly disabled.</p>";
}

if (defined('NX_DEBUG_DISPLAY') && NX_DEBUG_DISPLAY) {
    echo "<p style='color:red'>❌ NX_DEBUG_DISPLAY is enabled. This should be disabled in production.</p>";
    $is_production = false;
} else {
    echo "<p style='color:green'>✅ NX_DEBUG_DISPLAY is properly disabled.</p>";
}

// Check for development files
$dev_files = [
    'dev-router.php',
    'dev-simple-admin.php',
    'debug.php',
    'debug-loader.php',
    'error-monitor.php',
    'test-error.php',
    'nx-admin/dev-stubs.php',
    'nx-admin/dev-override.php',
    'nx-admin/dev-bootstrap.php',
    'nx-admin/dev-simple-admin.php'
];

$dev_files_found = [];
foreach ($dev_files as $file) {
    if (file_exists($file)) {
        $dev_files_found[] = $file;
    }
}

if (!empty($dev_files_found)) {
    echo "<p style='color:red'>❌ Development files found: " . implode(', ', $dev_files_found) . ". These should be removed in production.</p>";
    $is_production = false;
} else {
    echo "<p style='color:green'>✅ No development files found.</p>";
}

// Check security settings
if (defined('DISALLOW_FILE_EDIT') && DISALLOW_FILE_EDIT) {
    echo "<p style='color:green'>✅ DISALLOW_FILE_EDIT is properly enabled.</p>";
} else {
    echo "<p style='color:red'>❌ DISALLOW_FILE_EDIT should be set to true in production.</p>";
    $is_production = false;
}

if (defined('DISALLOW_FILE_MODS') && DISALLOW_FILE_MODS) {
    echo "<p style='color:green'>✅ DISALLOW_FILE_MODS is properly enabled.</p>";
} else {
    echo "<p style='color:red'>❌ DISALLOW_FILE_MODS should be set to true in production.</p>";
    $is_production = false;
}

if (defined('FORCE_SSL_ADMIN') && FORCE_SSL_ADMIN) {
    echo "<p style='color:green'>✅ FORCE_SSL_ADMIN is properly enabled.</p>";
} else {
    echo "<p style='color:red'>❌ FORCE_SSL_ADMIN should be set to true in production.</p>";
    $is_production = false;
}

// Check for HTTPS
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    echo "<p style='color:green'>✅ Site is running over HTTPS.</p>";
} else {
    echo "<p style='color:red'>❌ Site is not using HTTPS. HTTPS should be enforced in production.</p>";
    $is_production = false;
}

// Final verdict
if ($is_production) {
    echo "<h2 style='color:green'>✅ All checks passed! This environment appears to be properly configured for production.</h2>";
} else {
    echo "<h2 style='color:red'>❌ This environment has issues that should be fixed before going into production. See the details above.</h2>";
}

echo "<p><strong>IMPORTANT:</strong> Delete this file immediately after use.</p>";
```

## Troubleshooting Common Issues

### Login Redirect Loops
1. Check `.htaccess` files are properly uploaded and recognized
2. Verify SSL configuration
3. Check cookies are being properly set and read
4. Verify authentication constants in nx-config.php

### Database Connection Issues
1. Verify database credentials in `nx-config.php`
2. Check database server is accessible from web server
3. Confirm database user has proper permissions

### File Permission Issues
1. Check file permissions for key files
2. Ensure web server user has proper access to required directories

### 500 Internal Server Errors
1. Check server error logs
2. Verify `.htaccess` syntax is compatible with hosting environment
3. Temporarily enable error logging (not display) to identify specific error 

## Removal Script

```
find . -name "dev-*.php" -o -name "debug*.php" -o -name "*error*.php" | grep -v "nx-includes/class" | xargs rm -f
rm -f start-error-monitor.sh start-error-monitor.bat start-nexuspress.sh start-nexuspress.bat 