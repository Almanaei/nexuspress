<?php
/**
 * Bootstrap file for setting the ABSPATH constant
 * and loading the nx-config.php file. The nx-config.php
 * file will then load the nx-settings.php file, which
 * will then set up the NexusPress environment.
 *
 * If the nx-config.php file is not found then an error
 * will be displayed asking the visitor to set up a nx-config.php
 * file.
 *
 * Will also search for nx-config.php in NexusPress' parent
 * directory to allow the NexusPress directory to remain
 * untouched.
 *
 * @package NexusPress
 */

/** Define ABSPATH as this file's directory */
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

// Set NXINC constant to point to nx-includes directory
if (!defined('NXINC')) {
    define('NXINC', 'nx-includes');
}

/*
 * If nx-config.php exists in the NexusPress root, or if it exists in the root and nx-settings.php
 * exists in the NexusPress root, load nx-config.php. The secondary check for nx-settings.php has been
 * added for the case where relocated nx-config.php does not load nx-settings.php.
 */
if (file_exists(ABSPATH . 'nx-config.php')) {
    
    /** The config file resides in ABSPATH */
    require_once ABSPATH . 'nx-config.php';
    
} elseif (@file_exists(dirname(ABSPATH) . '/nx-config.php') && @file_exists(ABSPATH . 'nx-settings.php')) {
    
    /** The config file resides one level above ABSPATH but nx-settings.php is present in ABSPATH */
    require_once dirname(ABSPATH) . '/nx-config.php';
    
} else {
    
    // A config file doesn't exist
    
    // Set a path for the link to the installer
    if (strpos($_SERVER['PHP_SELF'], 'nx-admin') !== false) {
        $path = '';
    } else {
        $path = 'nx-admin/';
    }
    
    // Die with an error message
    die(
        '<p>There doesn\'t seem to be a <code>nx-config.php</code> file. I need this before we can get started.</p>' .
        '<p>Need more help? <a href="https://nexuspress.org/support/article/editing-wp-config-php/">We got it</a>.</p>' .
        '<p>You can create a <code>nx-config.php</code> file through a web interface, but this doesn\'t work for all server setups. ' .
        'The safest way is to manually create the file.</p>' .
        '<p><a href="' . $path . 'setup-config.php" class="button button-large">Create a Configuration File</a></p>'
    );
} 