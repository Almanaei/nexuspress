<?php
/**
 * Front to the NexusPress application. This file doesn't do anything, but loads
 * nx-blog-header.php which does and tells NexusPress to load the theme.
 *
 * @package NexusPress
 */

// Enable error reporting in development
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

// For development server, explicitly set site URL if not already defined
if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '8000') {
    if (!defined('NX_SITEURL')) define('NX_SITEURL', 'http://localhost:8000');
    if (!defined('NX_HOME')) define('NX_HOME', 'http://localhost:8000');
}

/** Loads the NexusPress Environment and Template */
require __DIR__ . '/nx-blog-header.php';

// Flush the output buffer to ensure content is sent to browser
ob_end_flush(); 