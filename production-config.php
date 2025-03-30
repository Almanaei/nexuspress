<?php
/**
 * NexusPress Production Configuration - Template
 * 
 * Copy this file to nx-config.php and fill in your production database credentials.
 * Additionally, it contains important security settings for production use.
 */

// ** Database settings - You MUST fill these out for production ** //
define('DB_NAME', 'nexuspress_prod');
define('DB_USER', 'nexuspress_dbuser');
define('DB_PASSWORD', 'your_strong_password_here');
define('DB_HOST', 'localhost'); // Usually 'localhost', but check with your hosting provider
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');

// ** Authentication Unique Keys and Salts - CHANGE THESE! ** //
// Generate them at: https://api.nexuspress.org/secret-key/1.1/salt/
define('AUTH_KEY',         'put_your_unique_phrase_here');
define('SECURE_AUTH_KEY',  'put_your_unique_phrase_here');
define('LOGGED_IN_KEY',    'put_your_unique_phrase_here');
define('NONCE_KEY',        'put_your_unique_phrase_here');
define('AUTH_SALT',        'put_your_unique_phrase_here');
define('SECURE_AUTH_SALT', 'put_your_unique_phrase_here');
define('LOGGED_IN_SALT',   'put_your_unique_phrase_here');
define('NONCE_SALT',       'put_your_unique_phrase_here');

// ** Production Hardening Settings ** //
// Disable file editing from admin
define('DISALLOW_FILE_EDIT', true);

// Disable installing/updating plugins and themes from the admin
define('DISALLOW_FILE_MODS', true);

// Force logins to use SSL
define('FORCE_SSL_ADMIN', true);
define('FORCE_SSL_LOGIN', true);

// Limit post revisions to conserve database space (5-10 is usually sufficient)
define('NX_POST_REVISIONS', 5);

// Increase memory limit if needed (check with your hosting provider)
define('NX_MEMORY_LIMIT', '128M');

// Disable auto-updates (manage these manually in production)
define('AUTOMATIC_UPDATER_DISABLED', true);

// Disable development/debugging settings in production
define('NX_DEBUG', false);
define('NX_DEBUG_LOG', false);
define('NX_DEBUG_DISPLAY', false);
define('SAVEQUERIES', false);
define('SCRIPT_DEBUG', false);

// Disable development mode completely
define('NX_DEVELOPMENT', false);
define('NX_DEVELOPMENT_MODE', false);
define('NX_DIRECT_ADMIN_ACCESS', false);

// Block external HTTP requests (uncomment if you don't need external connections)
// define('NX_HTTP_BLOCK_EXTERNAL', true);

// Site URLs - Update these for your production site
define('NX_SITEURL', 'https://www.yourdomain.com');
define('NX_HOME', 'https://www.yourdomain.com');

// Production database table prefix (don't use 'nx_' - use something random for security)
$table_prefix = 'nx_prd_';

// Cookie settings
define('COOKIE_DOMAIN', '.yourdomain.com'); // Include the dot for subdomains
define('COOKIE_HTTPONLY', true);
define('COOKIE_SECURE', true);

// Set the absolute path to the NexusPress directory
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

// Define a custom content directory (optional, for shared hosting environments)
// define('NX_CONTENT_DIR', '/path/to/custom/content');
// define('NX_CONTENT_URL', 'https://www.yourdomain.com/custom-content');

/* That's all, stop editing! Happy publishing. */

/** Sets up NexusPress vars and included files. */
require_once ABSPATH . 'nx-settings.php'; 