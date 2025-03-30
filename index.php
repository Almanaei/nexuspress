<?php
/**
 * Front to the NexusPress application. This file doesn't do anything, but loads
 * nx-blog-header.php which does and tells NexusPress to load the theme.
 *
 * @package NexusPress
 */

// Direct access check for admin pages
$request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (strpos($request_path, '/nx-admin') === 0) {
    // Check if user is logged in through a cookie
    $is_logged_in = isset($_COOKIE['nx_logged_in']) && $_COOKIE['nx_logged_in'] === 'true';
    
    if (!$is_logged_in) {
        // Not logged in, redirect to login
        $redirect_to = urlencode($request_path);
        header("Location: /nx-login.php?redirect_to={$redirect_to}");
        exit;
    } else {
        // Admin access required, include the admin file
        $admin_path = __DIR__ . '/nx-admin/index.php';
        if (file_exists($admin_path)) {
            require_once $admin_path;
            exit;
        }
    }
}

// Enable full error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start output buffering to catch any errors that might not be displayed
ob_start();

/**
 * Tells NexusPress to load the NexusPress theme and output it.
 *
 * @var bool
 */
define('NX_USE_THEMES', true);

// For development server, explicitly set site URL and enable debugging
if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '8000') {
    if (!defined('NX_SITEURL')) define('NX_SITEURL', 'http://localhost:8000');
    if (!defined('NX_HOME')) define('NX_HOME', 'http://localhost:8000');
    if (!defined('NX_DEBUG')) define('NX_DEBUG', true);
    if (!defined('NX_DEBUG_DISPLAY')) define('NX_DEBUG_DISPLAY', true);
    if (!defined('NX_DEBUG_LOG')) define('NX_DEBUG_LOG', true);
    if (!defined('SAVEQUERIES')) define('SAVEQUERIES', true);
}

// Set a flag to detect if we've reached the end of the file
$nexus_loaded = false;
$debug_output = "";

function capture_debug($message) {
    global $debug_output;
    $debug_output .= $message . "\n";
}

capture_debug("Starting NexusPress load process");

try {
    // Process request
    capture_debug("About to load nx-blog-header.php");
    
    /** Loads the NexusPress Environment and Template */
    require __DIR__ . '/nx-blog-header.php';
    
    capture_debug("nx-blog-header.php loaded successfully");
    $nexus_loaded = true;
} catch (Exception $e) {
    // Catch any exceptions during NexusPress load
    $error_message = "<h1>NexusPress Exception</h1>";
    $error_message .= "<p>Error: " . $e->getMessage() . "</p>";
    $error_message .= "<p>File: " . $e->getFile() . " (line " . $e->getLine() . ")</p>";
    $error_message .= "<pre>" . $e->getTraceAsString() . "</pre>";
    echo $error_message;
    capture_debug("Exception caught: " . $e->getMessage());
} catch (Error $e) {
    // Catch any PHP errors during NexusPress load
    $error_message = "<h1>PHP Error</h1>";
    $error_message .= "<p>Error: " . $e->getMessage() . "</p>";
    $error_message .= "<p>File: " . $e->getFile() . " (line " . $e->getLine() . ")</p>";
    $error_message .= "<pre>" . $e->getTraceAsString() . "</pre>";
    echo $error_message;
    capture_debug("PHP Error caught: " . $e->getMessage());
}

// Check if the buffer is empty (no output)
$buffer_content = ob_get_contents();
$is_buffer_empty = (trim($buffer_content) === '');
capture_debug("Buffer is " . ($is_buffer_empty ? "empty" : "not empty") . " (" . strlen($buffer_content) . " bytes)");

// If we get to the end of the file but the page is still empty, show fallback content
if (!$nexus_loaded || $is_buffer_empty) {
    capture_debug("NexusPress didn't output content, showing fallback");
    ob_clean(); // Clear the buffer if it contains error messages
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>NexusPress Site</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                color: #333;
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
            }
            h1 {
                color: #0073aa;
                border-bottom: 1px solid #eee;
                padding-bottom: 10px;
            }
            a {
                color: #0073aa;
                text-decoration: none;
            }
            a:hover {
                text-decoration: underline;
            }
            .button {
                display: inline-block;
                background: #0073aa;
                color: white;
                padding: 10px 15px;
                border-radius: 3px;
                margin-top: 20px;
            }
            .debug-link {
                margin-top: 30px;
                padding-top: 20px;
                border-top: 1px solid #eee;
            }
            .debug-info {
                background: #f8f9fa;
                padding: 15px;
                border: 1px solid #ddd;
                margin-top: 20px;
                font-family: monospace;
                white-space: pre-wrap;
            }
        </style>
    </head>
    <body>
        <h1>Welcome to NexusPress</h1>
        <p>Your NexusPress site is running, but there might be an issue with the theme or content display.</p>
        
        <h2>What to do next:</h2>
        <ol>
            <li>Check if you have activated a theme in the admin dashboard</li>
            <li>Verify that your theme's <code>index.php</code> file exists and is properly formatted</li>
            <li>Look for PHP errors in your server's error log</li>
            <li>Try deactivating plugins if you're experiencing conflicts</li>
        </ol>
        
        <p>If you're a developer setting up this site, make sure you have:</p>
        <ul>
            <li>Completed the NexusPress installation process</li>
            <li>Created at least one post or page</li>
            <li>Selected and activated a valid theme</li>
        </ul>
        
        <div class="debug-link">
            <p>For more detailed information, visit the <a href="debug.php">debug page</a>.</p>
            <p><a href="nx-admin/">Go to Admin Dashboard</a></p>
        </div>
        
        <div class="debug-info">
            <h3>Debug Information:</h3>
            <?php echo htmlspecialchars($debug_output); ?>
        </div>
    </body>
    </html>
    <?php
}

// Flush the output buffer to ensure content is sent to browser
ob_end_flush();
