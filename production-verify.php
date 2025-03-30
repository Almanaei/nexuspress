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

// Start output buffer to prevent partial output in case of errors
ob_start();

// Set content type to HTML
header('Content-Type: text/html; charset=utf-8');

// Function to check if a constant is defined and get its value
function check_constant($name, $expected_value = null, $should_be_true = null) {
    $result = [
        'name' => $name,
        'defined' => defined($name),
        'value' => defined($name) ? constant($name) : null,
        'status' => 'unknown'
    ];
    
    if (!$result['defined']) {
        $result['status'] = 'not_defined';
        return $result;
    }
    
    if ($expected_value !== null) {
        $result['expected'] = $expected_value;
        $result['status'] = ($result['value'] === $expected_value) ? 'ok' : 'wrong_value';
    } elseif ($should_be_true !== null) {
        $result['expected'] = true;
        if ($should_be_true) {
            $result['status'] = $result['value'] ? 'ok' : 'should_be_true';
        } else {
            $result['status'] = !$result['value'] ? 'ok' : 'should_be_false';
        }
    }
    
    return $result;
}

// Function to check if a file exists
function check_file_exists($path) {
    return [
        'path' => $path,
        'exists' => file_exists($path),
        'status' => file_exists($path) ? 'exists' : 'not_exists'
    ];
}

// Function to render a check result
function render_check($check, $ok_message, $error_message, $warning_message = null) {
    if ($check['status'] === 'ok') {
        echo "<li class='check-ok'>✅ {$ok_message}</li>";
        return 'ok';
    } elseif ($check['status'] === 'not_defined') {
        echo "<li class='check-warning'>⚠️ {$warning_message}</li>";
        return 'warning';
    } else {
        echo "<li class='check-error'>❌ {$error_message}</li>";
        return 'error';
    }
}

// Function to check for development files
function check_dev_files() {
    $dev_files = [
        'dev-router.php',
        'dev-simple-admin.php',
        'debug.php',
        'debug-loader.php',
        'debug-template.php',
        'error-monitor.php',
        'test-error.php',
        'nx-admin/dev-stubs.php',
        'nx-admin/dev-override.php',
        'nx-admin/dev-bootstrap.php',
        'nx-admin/dev-simple-admin.php',
        'nx-admin/dev-skip-upgrade.php',
        'nx-admin/nx-dashboard.php',
        'start-error-monitor.sh',
        'start-error-monitor.bat',
        'start-nexuspress.sh',
        'start-nexuspress.bat'
    ];
    
    $found_files = [];
    foreach ($dev_files as $file) {
        if (file_exists($file)) {
            $found_files[] = $file;
        }
    }
    
    return [
        'found_files' => $found_files,
        'status' => empty($found_files) ? 'ok' : 'files_found'
    ];
}

// Begin page output
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusPress Production Verification</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            line-height: 1.5;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #2c3e50;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        h2 {
            color: #2c3e50;
            margin-top: 30px;
        }
        .check-section {
            background: #f9f9f9;
            border-radius: 5px;
            padding: 15px 20px;
            margin-bottom: 20px;
        }
        .check-list {
            list-style-type: none;
            padding-left: 10px;
        }
        .check-ok {
            color: #27ae60;
        }
        .check-error {
            color: #e74c3c;
        }
        .check-warning {
            color: #f39c12;
        }
        .verdict {
            margin-top: 30px;
            padding: 15px;
            border-radius: 5px;
            font-weight: bold;
        }
        .verdict-ok {
            background-color: #d5f5e3;
            color: #27ae60;
        }
        .verdict-warning {
            background-color: #fef9e7;
            color: #f39c12;
        }
        .verdict-error {
            background-color: #fdedec;
            color: #e74c3c;
        }
        .delete-warning {
            background-color: #fdedec;
            color: #e74c3c;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>NexusPress Production Security Verification</h1>
    
    <p>This script checks if your NexusPress installation is properly configured for production.</p>
    
    <h2>Development Mode Checks</h2>
    <div class="check-section">
        <ul class="check-list">
            <?php
            $dev_mode_status = 'ok';
            
            // Check development mode constants
            $check = check_constant('NX_DEVELOPMENT', false, false);
            $result = render_check(
                $check,
                "NX_DEVELOPMENT is properly disabled.",
                "NX_DEVELOPMENT is set to true. It should be false in production.",
                "NX_DEVELOPMENT is not defined. It should be explicitly set to false in production."
            );
            if ($result !== 'ok') $dev_mode_status = $result;
            
            $check = check_constant('NX_DEVELOPMENT_MODE', false, false);
            $result = render_check(
                $check,
                "NX_DEVELOPMENT_MODE is properly disabled.",
                "NX_DEVELOPMENT_MODE is set to true. It should be false in production.",
                "NX_DEVELOPMENT_MODE is not defined. It should be explicitly set to false in production."
            );
            if ($result !== 'ok' && $dev_mode_status !== 'error') $dev_mode_status = $result;
            
            $check = check_constant('NX_DIRECT_ADMIN_ACCESS', false, false);
            $result = render_check(
                $check,
                "NX_DIRECT_ADMIN_ACCESS is properly disabled.",
                "NX_DIRECT_ADMIN_ACCESS is set to true. It should be false in production.",
                "NX_DIRECT_ADMIN_ACCESS is not defined. It should be explicitly set to false in production."
            );
            if ($result !== 'ok' && $dev_mode_status !== 'error') $dev_mode_status = $result;
            ?>
        </ul>
    </div>
    
    <h2>Debug Settings Checks</h2>
    <div class="check-section">
        <ul class="check-list">
            <?php
            $debug_status = 'ok';
            
            // Check debug constants
            $check = check_constant('NX_DEBUG', false, false);
            $result = render_check(
                $check,
                "NX_DEBUG is properly disabled.",
                "NX_DEBUG is enabled. It should be disabled in production.",
                "NX_DEBUG is not defined. It should be explicitly set to false in production."
            );
            if ($result !== 'ok') $debug_status = $result;
            
            $check = check_constant('NX_DEBUG_DISPLAY', false, false);
            $result = render_check(
                $check,
                "NX_DEBUG_DISPLAY is properly disabled.",
                "NX_DEBUG_DISPLAY is enabled. It should be disabled in production.",
                "NX_DEBUG_DISPLAY is not defined. It should be explicitly set to false in production."
            );
            if ($result !== 'ok' && $debug_status !== 'error') $debug_status = $result;
            
            $check = check_constant('NX_DEBUG_LOG', false, false);
            $result = render_check(
                $check,
                "NX_DEBUG_LOG is properly disabled.",
                "NX_DEBUG_LOG is enabled. You may want to disable it in production or set a specific path.",
                "NX_DEBUG_LOG is not defined. It should be explicitly set in production."
            );
            if ($result !== 'ok' && $debug_status !== 'error') $debug_status = $result;
            
            $check = check_constant('SAVEQUERIES', false, false);
            $result = render_check(
                $check,
                "SAVEQUERIES is properly disabled.",
                "SAVEQUERIES is enabled. It should be disabled in production for performance.",
                "SAVEQUERIES is not defined. It should be explicitly set to false in production."
            );
            if ($result !== 'ok' && $debug_status !== 'error') $debug_status = $result;
            
            $check = check_constant('SCRIPT_DEBUG', false, false);
            $result = render_check(
                $check,
                "SCRIPT_DEBUG is properly disabled.",
                "SCRIPT_DEBUG is enabled. It should be disabled in production.",
                "SCRIPT_DEBUG is not defined. It should be explicitly set to false in production."
            );
            if ($result !== 'ok' && $debug_status !== 'error') $debug_status = $result;
            ?>
        </ul>
    </div>
    
    <h2>Security Settings Checks</h2>
    <div class="check-section">
        <ul class="check-list">
            <?php
            $security_status = 'ok';
            
            // Check security constants
            $check = check_constant('DISALLOW_FILE_EDIT', true, true);
            $result = render_check(
                $check,
                "DISALLOW_FILE_EDIT is properly enabled.",
                "DISALLOW_FILE_EDIT is disabled. It should be enabled in production.",
                "DISALLOW_FILE_EDIT is not defined. It should be set to true in production."
            );
            if ($result !== 'ok') $security_status = $result;
            
            $check = check_constant('DISALLOW_FILE_MODS', true, true);
            $result = render_check(
                $check,
                "DISALLOW_FILE_MODS is properly enabled.",
                "DISALLOW_FILE_MODS is disabled. It should be enabled in production.",
                "DISALLOW_FILE_MODS is not defined. It should be set to true in production."
            );
            if ($result !== 'ok' && $security_status !== 'error') $security_status = $result;
            
            $check = check_constant('FORCE_SSL_ADMIN', true, true);
            $result = render_check(
                $check,
                "FORCE_SSL_ADMIN is properly enabled.",
                "FORCE_SSL_ADMIN is disabled. It should be enabled in production.",
                "FORCE_SSL_ADMIN is not defined. It should be set to true in production."
            );
            if ($result !== 'ok' && $security_status !== 'error') $security_status = $result;
            
            $check = check_constant('FORCE_SSL_LOGIN', true, true);
            $result = render_check(
                $check,
                "FORCE_SSL_LOGIN is properly enabled.",
                "FORCE_SSL_LOGIN is disabled. It should be enabled in production.",
                "FORCE_SSL_LOGIN is not defined. It should be set to true in production."
            );
            if ($result !== 'ok' && $security_status !== 'error') $security_status = $result;
            
            $check = check_constant('COOKIE_SECURE', true, true);
            $result = render_check(
                $check,
                "COOKIE_SECURE is properly enabled.",
                "COOKIE_SECURE is disabled. It should be enabled in production.",
                "COOKIE_SECURE is not defined. It should be set to true in production."
            );
            if ($result !== 'ok' && $security_status !== 'error') $security_status = $result;
            
            $check = check_constant('COOKIE_HTTPONLY', true, true);
            $result = render_check(
                $check,
                "COOKIE_HTTPONLY is properly enabled.",
                "COOKIE_HTTPONLY is disabled. It should be enabled in production.",
                "COOKIE_HTTPONLY is not defined. It should be set to true in production."
            );
            if ($result !== 'ok' && $security_status !== 'error') $security_status = $result;
            ?>
        </ul>
    </div>
    
    <h2>HTTPS Check</h2>
    <div class="check-section">
        <ul class="check-list">
            <?php
            $https_status = 'ok';
            
            // Check if site is using HTTPS
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                echo "<li class='check-ok'>✅ Site is running over HTTPS.</li>";
            } else {
                echo "<li class='check-error'>❌ Site is not using HTTPS. HTTPS should be enforced in production.</li>";
                $https_status = 'error';
            }
            ?>
        </ul>
    </div>
    
    <h2>Development Files Check</h2>
    <div class="check-section">
        <ul class="check-list">
            <?php
            $dev_files_check = check_dev_files();
            $dev_files_status = 'ok';
            
            if ($dev_files_check['status'] === 'ok') {
                echo "<li class='check-ok'>✅ No development files found.</li>";
            } else {
                echo "<li class='check-error'>❌ Development files found: " . implode(', ', $dev_files_check['found_files']) . ". These should be removed in production.</li>";
                $dev_files_status = 'error';
            }
            ?>
        </ul>
    </div>
    
    <h2>Configuration Files Check</h2>
    <div class="check-section">
        <ul class="check-list">
            <?php
            $config_status = 'ok';
            
            // Check if production-config.php exists (it should be copied to nx-config.php)
            $check = check_file_exists('production-config.php');
            if ($check['exists']) {
                echo "<li class='check-warning'>⚠️ 'production-config.php' still exists. After setting up your production configuration, this file should be removed.</li>";
                $config_status = 'warning';
            } else {
                echo "<li class='check-ok'>✅ 'production-config.php' template has been removed.</li>";
            }
            
            // Check if nx-config.php exists
            $check = check_file_exists('nx-config.php');
            if ($check['exists']) {
                echo "<li class='check-ok'>✅ 'nx-config.php' exists. Make sure it contains your production settings.</li>";
            } else {
                echo "<li class='check-error'>❌ 'nx-config.php' does not exist. You need to create it based on the production-config.php template.</li>";
                $config_status = 'error';
            }
            
            // Check .htaccess files
            $check = check_file_exists('.htaccess');
            if ($check['exists']) {
                echo "<li class='check-ok'>✅ Main '.htaccess' file exists.</li>";
            } else {
                echo "<li class='check-error'>❌ Main '.htaccess' file does not exist. It's required for proper URL handling and security.</li>";
                $config_status = 'error';
            }
            
            $check = check_file_exists('nx-admin/.htaccess');
            if ($check['exists']) {
                echo "<li class='check-ok'>✅ Admin '.htaccess' file exists.</li>";
            } else {
                echo "<li class='check-warning'>⚠️ Admin '.htaccess' file does not exist. It's recommended for enhanced admin security.</li>";
                if ($config_status !== 'error') $config_status = 'warning';
            }
            ?>
        </ul>
    </div>
    
    <?php
    // Determine overall status
    $overall_status = 'ok';
    if ($dev_mode_status === 'error' || $debug_status === 'error' || $security_status === 'error' || 
        $https_status === 'error' || $dev_files_status === 'error' || $config_status === 'error') {
        $overall_status = 'error';
    } elseif ($dev_mode_status === 'warning' || $debug_status === 'warning' || $security_status === 'warning' || 
              $config_status === 'warning') {
        $overall_status = 'warning';
    }
    
    // Display final verdict
    if ($overall_status === 'ok') {
        echo '<div class="verdict verdict-ok">✅ All checks passed! This environment appears to be properly configured for production.</div>';
    } elseif ($overall_status === 'warning') {
        echo '<div class="verdict verdict-warning">⚠️ This environment has some non-critical issues that should be addressed. See the details above.</div>';
    } else {
        echo '<div class="verdict verdict-error">❌ This environment has critical issues that must be fixed before going into production. See the details above.</div>';
    }
    ?>
    
    <div class="delete-warning">
        <p><strong>SECURITY ALERT:</strong> Delete this verification file immediately after use to prevent exposing system information!</p>
    </div>
</body>
</html>
<?php
// Flush output buffer
ob_end_flush();
?> 