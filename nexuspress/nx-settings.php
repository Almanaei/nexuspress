<?php
/**
 * Used to set up and fix common variables and include
 * the NexusPress procedural and class library.
 *
 * Allows for some configuration in nx-config.php (see default-constants.php)
 *
 * @package NexusPress
 */

// Override site URL settings for development server
if (!defined('NX_SITEURL')) {
    define('NX_SITEURL', 'http://localhost:8000');
}
if (!defined('NX_HOME')) {
    define('NX_HOME', 'http://localhost:8000');
}

/**
 * Stores the location of the NexusPress directory of functions, classes, and core content.
 *
 * @since 1.0.0
 */
if (!defined('NXINC')) {
    define('NXINC', 'nx-includes');
}

/**
 * This is a temporary replacement for NexusPress's native db.php file
 * It provides a mock database interface for development when no database is available
 */
if (!function_exists('require_nx_db')) {
    function require_nx_db() {
        // Mock database connection for development
        global $nxdb;
        $nxdb = new stdClass();
        $nxdb->prefix = 'nx_';
        $nxdb->base_prefix = 'nx_';
        $nxdb->blogs = null;
        
        // Add minimal methods needed
        $nxdb->query = function($query) { return false; };
        $nxdb->get_results = function($query, $output = OBJECT) { return array(); };
        $nxdb->get_row = function($query, $output = OBJECT, $row = 0) { return null; };
        $nxdb->get_col = function($query, $x = 0) { return array(); };
        $nxdb->get_var = function($query, $x = 0, $y = 0) { return null; };
        $nxdb->prepare = function($query, ...$args) { return $query; };
        
        return $nxdb;
    }
}

// Include the required core NexusPress files
require_once ABSPATH . NXINC . '/functions.php';

// Include minimal set of core files for development
require_once ABSPATH . NXINC . '/class-nx.php';
require_once ABSPATH . NXINC . '/class-nx-error.php';
require_once ABSPATH . NXINC . '/class-nx-hook.php';
require_once ABSPATH . NXINC . '/formatting.php';
require_once ABSPATH . NXINC . '/query.php';
require_once ABSPATH . NXINC . '/theme.php';
require_once ABSPATH . NXINC . '/class-nx-theme.php';
require_once ABSPATH . NXINC . '/template.php';

// Initialize the global $nx_hooks variable
global $nx_filter;
$nx_filter = new NX_Hook(); 