<?php
/**
 * NexusPress Direct Admin Dashboard Access
 * 
 * This file provides direct access to the NexusPress admin dashboard for development,
 * bypassing normal authentication for testing purposes.
 */

// For development only
define('NX_DEVELOPMENT', true);
define('NX_SKIP_AUTH', true);

// Set a cookie to remember that we've authenticated
setcookie('nx_logged_in', 'true', time() + 86400, '/');

// Basic path handling
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);

// Add a notice that this is a direct access point
echo '<div style="background-color: #d63638; color: #fff; padding: 10px; text-align: center; position: fixed; top: 0; left: 0; right: 0; z-index: 99999;">';
echo 'DIRECT ADMIN ACCESS: Using development login bypass. DO NOT USE IN PRODUCTION!';
echo '</div>';

// Include the actual admin file
require_once __DIR__ . '/index.php'; 