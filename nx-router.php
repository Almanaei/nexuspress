<?php
/**
 * NexusPress Production Router
 * Handles clean URLs and WordPress compatibility redirects
 */

// Only execute in PHP's built-in server
if (php_sapi_name() === 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $file = __DIR__ . $path;
    
    // Handle WordPress compatibility redirects (wp-* to nx-*)
    if (preg_match('#^/wp-(.*)#', $path, $matches)) {
        // Build the NexusPress equivalent URL with proper 301 redirect
        $nx_path = '/nx-' . $matches[1];
        $query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
        $redirect_url = $nx_path . ($query ? '?' . $query : '');
        
        header('Location: ' . $redirect_url, true, 301);
        exit;
    }
    
    // Serve static files directly
    if (is_file($file) && !preg_match('/\.php$/', $file)) {
        return false;
    }
    
    // Handle clean URLs for assets
    if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|ico|woff|woff2|ttf|svg|eot)$/', $path)) {
        return false;
    }
    
    // Block access to sensitive files
    if (preg_match('/\.(sql|bak|config|cache|log|sh|inc|env)$/', $path)) {
        header('HTTP/1.0 403 Forbidden');
        exit('403 Forbidden');
    }
    
    // Handle front controller
    include 'index.php';
}