# NexusPress Security Best Practices Guide

## Overview
This guide outlines comprehensive security best practices for NexusPress, including system hardening, data protection, and threat prevention strategies.

## System Security

### File Permissions
```bash
# Set correct file permissions
find /path/to/nexuspress -type d -exec chmod 755 {} \;
find /path/to/nexuspress -type f -exec chmod 644 {} \;

# Set special permissions for uploads
chmod 755 /path/to/nexuspress/nx-content/uploads
chmod 644 /path/to/nexuspress/nx-content/uploads/*

# Protect sensitive files
chmod 600 /path/to/nexuspress/nx-config.php
chmod 600 /path/to/nexuspress/.htaccess
```

### Directory Protection
```apache
# Protect sensitive directories
<DirectoryMatch "^/path/to/nexuspress/nx-admin/">
    Order deny,allow
    Deny from all
</DirectoryMatch>

# Protect configuration files
<FilesMatch "^(nx-config\.php|\.htaccess)$">
    Order deny,allow
    Deny from all
</FilesMatch>
```

### PHP Security
```php
// Disable PHP execution in uploads
<Directory "/path/to/nexuspress/nx-content/uploads">
    php_flag engine off
</Directory>

// Set secure PHP settings
php_value upload_max_filesize 10M
php_value post_max_size 10M
php_value max_execution_time 300
php_value max_input_time 300
```

## Authentication Security

### Password Policies
```php
/**
 * Enforce strong password policy
 */
function nx_enforce_password_policy($errors, $update, $user) {
    if ($update) {
        return $errors;
    }

    $password = $_POST['pass1'];
    
    // Minimum length
    if (strlen($password) < 12) {
        $errors->add('password_too_short', __('Password must be at least 12 characters long.'));
    }
    
    // Complexity requirements
    if (!preg_match('/[A-Z]/', $password)) {
        $errors->add('password_no_uppercase', __('Password must contain at least one uppercase letter.'));
    }
    if (!preg_match('/[a-z]/', $password)) {
        $errors->add('password_no_lowercase', __('Password must contain at least one lowercase letter.'));
    }
    if (!preg_match('/[0-9]/', $password)) {
        $errors->add('password_no_number', __('Password must contain at least one number.'));
    }
    if (!preg_match('/[^A-Za-z0-9]/', $password)) {
        $errors->add('password_no_special', __('Password must contain at least one special character.'));
    }
    
    return $errors;
}
add_filter('nx_registration_errors', 'nx_enforce_password_policy', 10, 3);
```

### Login Security
```php
/**
 * Implement login security measures
 */
function nx_login_security() {
    // Limit login attempts
    $ip = $_SERVER['REMOTE_ADDR'];
    $attempts = get_transient('login_attempts_' . $ip);
    
    if ($attempts >= 5) {
        return new NX_Error('too_many_attempts', __('Too many failed attempts. Please try again later.'));
    }
    
    // Track failed attempts
    if (isset($_POST['log']) && isset($_POST['pwd'])) {
        $user = get_user_by('login', $_POST['log']);
        if (!$user || !nx_check_password($_POST['pwd'], $user->user_pass)) {
            $attempts = $attempts ? $attempts + 1 : 1;
            set_transient('login_attempts_' . $ip, $attempts, 3600);
        }
    }
    
    return $user;
}
add_filter('nx_authenticate', 'nx_login_security', 10, 1);
```

### Two-Factor Authentication
```php
/**
 * Implement two-factor authentication
 */
function nx_two_factor_auth($user) {
    if (!isset($_POST['two_factor_code'])) {
        return new NX_Error('two_factor_required', __('Two-factor authentication code required.'));
    }
    
    $code = $_POST['two_factor_code'];
    $secret = get_user_meta($user->ID, 'two_factor_secret', true);
    
    if (!nx_verify_totp($secret, $code)) {
        return new NX_Error('invalid_code', __('Invalid two-factor authentication code.'));
    }
    
    return $user;
}
add_filter('nx_authenticate', 'nx_two_factor_auth', 20, 1);
```

## Data Security

### Input Validation
```php
/**
 * Validate input data
 */
function nx_validate_input($data, $type = 'text') {
    switch ($type) {
        case 'email':
            return filter_var($data, FILTER_VALIDATE_EMAIL);
        case 'url':
            return filter_var($data, FILTER_VALIDATE_URL);
        case 'int':
            return filter_var($data, FILTER_VALIDATE_INT);
        case 'float':
            return filter_var($data, FILTER_VALIDATE_FLOAT);
        case 'text':
        default:
            return sanitize_text_field($data);
    }
}
```

### Output Sanitization
```php
/**
 * Sanitize output data
 */
function nx_sanitize_output($data, $type = 'text') {
    switch ($type) {
        case 'html':
            return nx_kses_post($data);
        case 'url':
            return esc_url($data);
        case 'attr':
            return esc_attr($data);
        case 'text':
        default:
            return esc_html($data);
    }
}
```

### SQL Injection Prevention
```php
/**
 * Prepare SQL queries
 */
function nx_prepare_query($query, $args) {
    global $nxdb;
    return $nxdb->prepare($query, $args);
}

// Example usage
$user_id = 1;
$query = nx_prepare_query(
    "SELECT * FROM {$nxdb->users} WHERE ID = %d",
    $user_id
);
```

## API Security

### REST API Security
```php
/**
 * Secure REST API endpoints
 */
function nx_secure_rest_api() {
    // Require authentication for all endpoints
    add_filter('nx_rest_authentication_errors', function($result) {
        if (!empty($result)) {
            return $result;
        }
        
        if (!is_user_logged_in()) {
            return new NX_Error(
                'rest_not_logged_in',
                __('You must be logged in to access this endpoint.'),
                array('status' => 401)
            );
        }
        
        return $result;
    });
    
    // Rate limiting
    add_filter('nx_rest_pre_dispatch', function($result, $server, $request) {
        $ip = $_SERVER['REMOTE_ADDR'];
        $rate_limit = 100; // requests per minute
        
        $requests = get_transient('api_requests_' . $ip);
        if ($requests >= $rate_limit) {
            return new NX_Error(
                'rest_rate_limit_exceeded',
                __('Rate limit exceeded. Please try again later.'),
                array('status' => 429)
            );
        }
        
        set_transient('api_requests_' . $ip, $requests + 1, 60);
        return $result;
    }, 10, 3);
}
add_action('nx_rest_api_init', 'nx_secure_rest_api');
```

### CORS Security
```php
/**
 * Configure CORS headers
 */
function nx_cors_headers() {
    header('Access-Control-Allow-Origin: https://trusted-domain.com');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    header('Access-Control-Max-Age: 86400');
}
add_action('nx_init', 'nx_cors_headers');
```

## Content Security

### XSS Prevention
```php
/**
 * Implement XSS protection
 */
function nx_xss_protection() {
    // Add security headers
    header('X-XSS-Protection: 1; mode=block');
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    
    // Content Security Policy
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline';");
}
add_action('nx_init', 'nx_xss_protection');
```

### File Upload Security
```php
/**
 * Secure file uploads
 */
function nx_secure_upload($file) {
    // Verify file type
    $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if (!in_array($file_ext, $allowed_types)) {
        return new NX_Error('invalid_file_type', __('Invalid file type.'));
    }
    
    // Verify file size
    $max_size = 5 * 1024 * 1024; // 5MB
    if ($file['size'] > $max_size) {
        return new NX_Error('file_too_large', __('File too large.'));
    }
    
    // Scan for malware
    if (!nx_scan_file($file['tmp_name'])) {
        return new NX_Error('malware_detected', __('Malware detected.'));
    }
    
    return $file;
}
add_filter('nx_handle_upload', 'nx_secure_upload');
```

## Monitoring and Logging

### Security Logging
```php
/**
 * Log security events
 */
function nx_security_log($event, $data = array()) {
    $log_entry = array(
        'timestamp' => current_time('mysql'),
        'event' => $event,
        'data' => $data,
        'ip' => $_SERVER['REMOTE_ADDR'],
        'user_id' => get_current_user_id(),
    );
    
    $logs = get_option('nx_security_logs', array());
    array_unshift($logs, $log_entry);
    $logs = array_slice($logs, 0, 1000); // Keep last 1000 entries
    
    update_option('nx_security_logs', $logs);
}
```

### Security Monitoring
```php
/**
 * Monitor for security threats
 */
function nx_security_monitor() {
    // Check for failed login attempts
    $failed_logins = get_option('nx_failed_logins', array());
    foreach ($failed_logins as $ip => $attempts) {
        if ($attempts >= 5) {
            nx_security_log('brute_force_attempt', array('ip' => $ip));
        }
    }
    
    // Check for file changes
    $file_checksums = get_option('nx_file_checksums', array());
    foreach ($file_checksums as $file => $checksum) {
        if (md5_file($file) !== $checksum) {
            nx_security_log('file_modified', array('file' => $file));
        }
    }
}
add_action('nx_cron_hourly', 'nx_security_monitor');
```

## Backup and Recovery

### Automated Backups
```php
/**
 * Schedule automated backups
 */
function nx_schedule_backups() {
    if (!nx_next_scheduled('nx_backup_daily')) {
        nx_schedule_event(time(), 'daily', 'nx_backup_daily');
    }
}
add_action('nx_init', 'nx_schedule_backups');

/**
 * Perform backup
 */
function nx_perform_backup() {
    $backup_dir = NX_CONTENT_DIR . '/nx-backups';
    if (!file_exists($backup_dir)) {
        nx_mkdir_p($backup_dir);
    }
    
    $filename = $backup_dir . '/backup-' . date('Y-m-d-H-i-s') . '.sql';
    
    // Backup database
    $command = sprintf(
        'mysqldump -u%s -p%s %s > %s',
        DB_USER,
        DB_PASSWORD,
        DB_NAME,
        $filename
    );
    
    exec($command, $output, $return_var);
    
    if ($return_var !== 0) {
        nx_security_log('backup_failed', array('error' => $output));
    }
}
add_action('nx_backup_daily', 'nx_perform_backup');
```

### Recovery Procedures
```php
/**
 * Restore from backup
 */
function nx_restore_backup($backup_file) {
    if (!file_exists($backup_file)) {
        return new NX_Error('backup_not_found', __('Backup file not found.'));
    }
    
    // Verify backup integrity
    if (!nx_verify_backup($backup_file)) {
        return new NX_Error('invalid_backup', __('Invalid backup file.'));
    }
    
    // Restore database
    $command = sprintf(
        'mysql -u%s -p%s %s < %s',
        DB_USER,
        DB_PASSWORD,
        DB_NAME,
        $backup_file
    );
    
    exec($command, $output, $return_var);
    
    if ($return_var !== 0) {
        return new NX_Error('restore_failed', __('Failed to restore backup.'));
    }
    
    return true;
}
```

## Security Checklist
- [ ] Enable SSL/TLS
- [ ] Set secure file permissions
- [ ] Implement strong password policies
- [ ] Enable two-factor authentication
- [ ] Configure security headers
- [ ] Implement rate limiting
- [ ] Set up security logging
- [ ] Enable automated backups
- [ ] Configure firewall rules
- [ ] Regular security audits
- [ ] Keep system updated
- [ ] Monitor error logs
- [ ] Implement access controls
- [ ] Secure API endpoints
- [ ] Regular vulnerability scans

## Support
For additional security support:
- Review security documentation
- Contact security team
- Report security vulnerabilities
- Stay updated with security patches
- Follow security best practices 