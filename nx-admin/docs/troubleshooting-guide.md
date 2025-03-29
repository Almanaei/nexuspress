# NexusPress Troubleshooting Guide

## Overview
This guide provides solutions for common issues and problems that may arise during the use of NexusPress. It includes step-by-step instructions for diagnosing and resolving various system, database, and application-related issues.

## Common Issues

### System Issues

#### White Screen of Death
**Symptoms:**
- Blank white screen
- No error messages
- Page fails to load

**Solutions:**
1. Enable debug mode in `nx-config.php`:
```php
define('NX_DEBUG', true);
define('NX_DEBUG_LOG', true);
define('NX_DEBUG_DISPLAY', true);
```

2. Check error logs:
```bash
tail -f /path/to/debug.log
```

3. Verify PHP version compatibility:
```php
if (version_compare(PHP_VERSION, '7.4.0', '<')) {
    die('NexusPress requires PHP 7.4 or higher.');
}
```

4. Check memory limits:
```php
define('NX_MEMORY_LIMIT', '256M');
```

#### Database Connection Issues
**Symptoms:**
- Database connection errors
- Unable to connect to database
- Database queries failing

**Solutions:**
1. Verify database credentials in `nx-config.php`:
```php
define('DB_NAME', 'your_database_name');
define('DB_USER', 'your_database_user');
define('DB_PASSWORD', 'your_database_password');
define('DB_HOST', 'localhost');
```

2. Test database connection:
```php
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$connection) {
    die('Database connection failed: ' . mysqli_connect_error());
}
```

3. Check database permissions:
```sql
GRANT ALL PRIVILEGES ON your_database_name.* TO 'your_database_user'@'localhost';
FLUSH PRIVILEGES;
```

### Content Issues

#### Missing Content
**Symptoms:**
- Posts or pages not displaying
- Media files missing
- Content not saving

**Solutions:**
1. Check file permissions:
```bash
chmod 755 /path/to/nx-content
chmod 644 /path/to/nx-content/*.php
```

2. Verify database tables:
```sql
SHOW TABLES LIKE 'nx_%';
```

3. Check content relationships:
```php
$post_id = get_the_ID();
$meta = get_post_meta($post_id);
var_dump($meta);
```

#### Media Upload Issues
**Symptoms:**
- Unable to upload media
- Media files not displaying
- Upload errors

**Solutions:**
1. Check upload directory permissions:
```bash
chmod 755 /path/to/nx-content/uploads
chmod 644 /path/to/nx-content/uploads/*
```

2. Verify PHP upload settings:
```ini
upload_max_filesize = 64M
post_max_size = 64M
max_execution_time = 300
```

3. Test upload directory:
```php
$upload_dir = nx_upload_dir();
if (!is_writable($upload_dir['basedir'])) {
    die('Upload directory is not writable.');
}
```

### Performance Issues

#### Slow Page Load
**Symptoms:**
- Pages taking too long to load
- Server response time high
- Resource-intensive operations

**Solutions:**
1. Enable caching:
```php
define('NX_CACHE', true);
define('NX_CACHE_TIME', 3600);
```

2. Optimize database queries:
```php
$nxdb->query('SET SESSION query_cache_type = 1');
```

3. Enable object caching:
```php
define('NX_OBJECT_CACHE', true);
```

#### High Server Load
**Symptoms:**
- Server CPU usage high
- Memory usage excessive
- Multiple concurrent users

**Solutions:**
1. Implement rate limiting:
```php
function nx_rate_limit() {
    $ip = $_SERVER['REMOTE_ADDR'];
    $rate_limit = 100; // requests per minute
    $cache_key = 'rate_limit_' . $ip;
    
    $requests = nx_cache_get($cache_key);
    if ($requests >= $rate_limit) {
        nx_die('Rate limit exceeded.');
    }
    
    nx_cache_incr($cache_key, 1, '', 60);
}
```

2. Optimize resource usage:
```php
function nx_optimize_resources() {
    if (!is_admin()) {
        nx_dequeue_style('nx-block-library');
        nx_dequeue_script('nx-embed');
    }
}
add_action('nx_enqueue_scripts', 'nx_optimize_resources', 100);
```

### Security Issues

#### Login Problems
**Symptoms:**
- Unable to log in
- Password reset not working
- Account locked

**Solutions:**
1. Reset password:
```php
$user_id = get_user_by('email', 'user@example.com')->ID;
nx_set_password('new_password', $user_id);
```

2. Check login attempts:
```php
function nx_check_login_attempts($user, $password) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $attempts = get_transient('login_attempts_' . $ip);
    
    if ($attempts >= 5) {
        return new NX_Error('too_many_attempts', 'Too many failed attempts.');
    }
    
    return $user;
}
add_filter('nx_authenticate', 'nx_check_login_attempts', 10, 2);
```

3. Verify user roles:
```php
$user = nx_get_current_user();
if (!in_array('administrator', $user->roles)) {
    nx_die('Access denied.');
}
```

#### Malware Issues
**Symptoms:**
- Unauthorized code changes
- Suspicious redirects
- Unknown files

**Solutions:**
1. Scan for malware:
```php
function nx_scan_for_malware() {
    $suspicious_patterns = array(
        'eval\s*\(',
        'base64_decode\s*\(',
        'system\s*\(',
    );
    
    $files = glob(ABSPATH . '**/*.php');
    foreach ($files as $file) {
        $content = file_get_contents($file);
        foreach ($suspicious_patterns as $pattern) {
            if (preg_match('/' . $pattern . '/', $content)) {
                error_log('Suspicious code found in: ' . $file);
            }
        }
    }
}
```

2. Verify file integrity:
```php
function nx_verify_file_integrity() {
    $checksums = get_option('nx_file_checksums');
    foreach ($checksums as $file => $checksum) {
        if (md5_file($file) !== $checksum) {
            error_log('File integrity check failed: ' . $file);
        }
    }
}
```

### Plugin Issues

#### Plugin Conflicts
**Symptoms:**
- Plugins not working
- Function conflicts
- JavaScript errors

**Solutions:**
1. Check plugin compatibility:
```php
function nx_check_plugin_compatibility($plugin) {
    $required_version = '1.0.0';
    $plugin_data = get_plugin_data($plugin);
    
    if (version_compare($plugin_data['Version'], $required_version, '<')) {
        return false;
    }
    
    return true;
}
```

2. Resolve function conflicts:
```php
if (!function_exists('conflicting_function')) {
    function conflicting_function() {
        // Implementation
    }
}
```

3. Debug JavaScript:
```php
function nx_debug_scripts() {
    if (NX_DEBUG) {
        nx_enqueue_script('nx-debug', '/path/to/debug.js', array('jquery'));
    }
}
add_action('nx_enqueue_scripts', 'nx_debug_scripts');
```

### Theme Issues

#### Theme Display Problems
**Symptoms:**
- Layout broken
- Styles not loading
- Template errors

**Solutions:**
1. Check theme compatibility:
```php
function nx_check_theme_compatibility() {
    $theme = nx_get_theme();
    if (!$theme->exists()) {
        return false;
    }
    
    return true;
}
```

2. Verify template hierarchy:
```php
function nx_debug_template_hierarchy() {
    global $template;
    error_log('Template file: ' . $template);
}
add_action('nx_template_include', 'nx_debug_template_hierarchy');
```

3. Test theme functions:
```php
function nx_test_theme_functions() {
    if (!function_exists('nx_setup')) {
        error_log('Theme setup function missing');
    }
}
add_action('nx_after_setup_theme', 'nx_test_theme_functions');
```

## Debugging Tools

### Debug Mode
```php
// Enable debug mode
define('NX_DEBUG', true);
define('NX_DEBUG_LOG', true);
define('NX_DEBUG_DISPLAY', true);

// Log errors
error_log('Debug message');
```

### Query Monitor
```php
// Enable query monitoring
define('NX_SAVEQUERIES', true);

// Display queries
global $nxdb;
print_r($nxdb->queries);
```

### Error Logging
```php
// Custom error logging
function nx_log_error($message, $data = array()) {
    error_log(sprintf(
        '[NexusPress Error] %s: %s',
        $message,
        json_encode($data)
    ));
}
```

## Support Resources
- Check the documentation
- Review error logs
- Contact technical support
- Join the developer community
- Submit bug reports
- Request feature enhancements 