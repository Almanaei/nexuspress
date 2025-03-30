<?php
/**
 * Loads the NexusPress environment and template.
 *
 * @package NexusPress
 */

if (!file_exists(__DIR__ . '/nx-load.php')) {
    die("Error: nx-load.php not found. Please ensure NexusPress is properly installed.");
}

// Load the NexusPress environment.
require_once __DIR__ . '/nx-load.php';

// Define NX_TEMPLATE_PATH constant to point to the correct theme directory
if (!defined('NX_TEMPLATE_PATH')) {
    define('NX_TEMPLATE_PATH', 'nx-content/themes');
}

// Set up the NexusPress query loop.
nx();

// Load the theme template.
require_once ABSPATH . NXINC . '/template-loader.php'; 