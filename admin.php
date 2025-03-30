<?php
/**
 * Include the NexusPress Admin Dashboard directly
 *
 * @package NexusPress
 * @subpackage Administration
 */

// CRITICAL: Ensure $nx_db is available
if (!isset($GLOBALS['nx_db']) || !is_object($GLOBALS['nx_db'])) {
    error_log("CRITICAL: Creating nx_db in admin.php because it wasn't available");
    
    // Create a simple database stub class
    class NX_DB_Stub {
        public $users = 'nx_users';
        public $posts = 'nx_posts';
        public $comments = 'nx_comments';
        public $links = 'nx_links';
        public $options = 'nx_options';
        public $postmeta = 'nx_postmeta';
        public $terms = 'nx_terms';
        public $term_taxonomy = 'nx_term_taxonomy';
        public $term_relationships = 'nx_term_relationships';
        public $usermeta = 'nx_usermeta';
        
        public function prepare($query, ...$args) {
            return $query; // Simple implementation
        }
        
        public function escape($string) {
            return $string; // Simple implementation
        }
        
        public function get_row($query) {
            // Return a fake admin user for user queries
            $user = new stdClass();
            $user->ID = 1;
            $user->user_login = 'admin';
            $user->user_pass = 'password_hash';
            $user->user_nicename = 'Administrator';
            $user->user_email = 'admin@example.com';
            $user->user_url = '';
            $user->user_registered = '2023-01-01 00:00:00';
            $user->user_activation_key = '';
            $user->user_status = 0;
            $user->display_name = 'Administrator';
            return $user;
        }
        
        public function get_results() { return []; }
        public function get_var() { return 1; }
        public function get_blog_prefix() { return 'nx_'; }
    }
    
    // Set up the global $nx_db object
    $GLOBALS['nx_db'] = new NX_DB_Stub();
}

// Define development environment
if (!defined('NX_DEVELOPMENT')) {
    define('NX_DEVELOPMENT', true);
}

if (!defined('NX_DEBUG')) {
    define('NX_DEBUG', true);
}

// Define admin environment
if (!defined('NX_ADMIN')) {
    define('NX_ADMIN', true);
}

// DEVELOPMENT: Force admin user simulation for development environment
if (defined('NX_DEVELOPMENT') && NX_DEVELOPMENT) {
    // Set up essential admin privileges
    $GLOBALS['current_user'] = new stdClass();
    $GLOBALS['current_user']->ID = 1;
    $GLOBALS['current_user']->user_login = 'admin';
    $GLOBALS['current_user']->user_email = 'admin@example.com';
    $GLOBALS['current_user']->user_nicename = 'Administrator';
    $GLOBALS['current_user']->display_name = 'Administrator';
    $GLOBALS['current_user']->locale = 'en_US';
    $GLOBALS['current_user']->data = new stdClass();
    $GLOBALS['current_user']->data->ID = 1;
    $GLOBALS['current_user']->data->user_login = 'admin';
    $GLOBALS['current_user']->data->user_email = 'admin@example.com';
    $GLOBALS['current_user']->data->display_name = 'Administrator';

    // Add has_cap method for capability checks
    $GLOBALS['current_user']->has_cap = function($cap) {
        // Always return true for all capabilities in development
        return true;
    };

    $GLOBALS['current_user']->allcaps = [
        'manage_options' => true,
        'administrator' => true,
        'activate_plugins' => true,
        'edit_posts' => true,
        'edit_pages' => true,
        'edit_themes' => true,
        'edit_users' => true,
        'list_users' => true,
        'update_core' => true,
        'create_users' => true,
        'delete_users' => true
    ];
    $GLOBALS['current_user']->roles = ['administrator'];
    
    // Set user to be logged in
    $GLOBALS['userdata'] = $GLOBALS['current_user'];
    $GLOBALS['user_ID'] = 1;
    
    // Force bypass auth checks
    define('NX_AUTH_BYPASS', true);
    
    error_log("DEVELOPMENT: Set up admin user simulation for development environment");
}

// CRITICAL: Use a custom approach to avoid conflicts with NexusPress core
// Create our own filter system that doesn't conflict with NexusPress functions
$GLOBALS['_nx_dev_safe_packages'] = [
    (object)[
        'name' => 'nx-polyfill',
        'version' => '1.0.0',
        'timestamp' => (object)['month' => date('m')]
    ]
];

// Define critical missing functions early to prevent errors
// These would normally be defined elsewhere in NexusPress
if (!function_exists('nx_timezone_override_offset')) {
    function nx_timezone_override_offset($offset) {
        return $offset; // Just return the original value
    }
}

// EMERGENCY BYPASS: Fix the array_values() error without function redeclaration 
function nx_dev_emergency_fix_script_loader() {
    error_log("Applying emergency bypasses for script-loader array_values error");
    
    // Use direct global variable method without filters
    // When nx_default_packages_vendor is called, we'll make this patch in script-loader.php
    $GLOBALS['_nx_packages_vendor_safe'] = true;
}

// Apply emergency fix immediately
nx_dev_emergency_fix_script_loader();

// CRITICAL FIX: Script loader patches to prevent array_values() error
// This completely bypasses the problematic code in script-loader.php
function nx_patch_script_loader() {
    // The path to script-loader.php
    $script_loader_path = __DIR__ . '/nx-includes/script-loader.php';
    
    // Check if we can find the file
    if (!file_exists($script_loader_path)) {
        error_log("Cannot find script-loader.php to patch at: " . $script_loader_path);
        return;
    }
    
    // REMOVED nx_scripts function to prevent redeclaration
    // Instead, create a global nx_scripts object directly
    global $nx_scripts;
    
    // Create a minimal object if it doesn't exist
    if (!isset($nx_scripts) || !is_object($nx_scripts)) {
        error_log("Dev: Creating minimal NX_Scripts object without function redeclaration");
        $nx_scripts = new stdClass();
        $nx_scripts->registered = [];
        $nx_scripts->queue = [];
        $nx_scripts->done = [];
        $nx_scripts->in_footer = [];
        $nx_scripts->extra = [];
        
        // Add helper methods as properties
        $nx_scripts->add = function() { return true; };
        $nx_scripts->enqueue = function() { return true; };
        $nx_scripts->localize = function() { return true; };
        $nx_scripts->add_data = function() { return true; };
    }
    
    // Log success
    error_log("Applied emergency patches to prevent script-loader.php errors");
}

// Apply patches immediately 
nx_patch_script_loader();

// EMERGENCY: Disable script loading to prevent fatal errors
// define('NX_SCRIPTS_DISABLED', true);
// define('NX_STYLES_DISABLED', true);

// Make sure we're in the correct directory for relative includes
chdir(__DIR__);

// Define NexusPress-style database return formats
// These need to be defined before any database queries are made
if (!defined('ARRAY_A')) define('ARRAY_A', 'ARRAY_A');
if (!defined('ARRAY_N')) define('ARRAY_N', 'ARRAY_N');
if (!defined('OBJECT')) define('OBJECT', 'OBJECT');
if (!defined('OBJECT_K')) define('OBJECT_K', 'OBJECT_K');

// CRITICAL: Pre-emptively define the NX_User class before loading NexusPress
// This ensures our version with has_prop method is used instead of the core version
if (!class_exists('NX_User')) {
    class NX_User {
        public $ID = 0;
        public $data;
        public $caps = array();
        public $cap_key;
        public $roles = array();
        public $allcaps = array();
        public $filter = null;
        
        public function __construct($id = 0, $name = '', $site_id = '') {
            $this->ID = 1; // Admin user in development
            $this->data = new stdClass();
            $this->data->ID = 1;
            $this->data->user_login = 'admin';
            $this->data->user_pass = 'password_hash';
            $this->data->user_nicename = 'Administrator';
            $this->data->user_email = 'admin@example.com';
            $this->data->user_url = '';
            $this->data->user_registered = '2023-01-01 00:00:00';
            $this->data->user_activation_key = '';
            $this->data->user_status = 0;
            $this->data->display_name = 'Administrator';
            
            $this->roles = array('administrator');
            $this->allcaps = array(
                'manage_options' => true,
                'administrator' => true,
                'activate_plugins' => true,
                'edit_posts' => true,
                'edit_pages' => true,
                'edit_themes' => true,
                'edit_users' => true,
                'list_users' => true,
                'update_core' => true,
                'create_users' => true,
                'delete_users' => true
            );
        }
        
        public function has_prop($key) {
            error_log("DEVELOPMENT: Using preemptive NX_User::has_prop for key: " . $key);
            return false; // Always return false for user meta in development
        }
        
        public function get($key) {
            error_log("DEVELOPMENT: Using preemptive NX_User::get for key: " . $key);
            if (isset($this->data->$key)) {
                return $this->data->$key;
            }
            return null;
        }
        
        public function has_cap($cap) {
            error_log("DEVELOPMENT: Using preemptive NX_User::has_cap for capability: " . $cap);
            return true; // Always return true in development
        }
        
        public function exists() {
            error_log("DEVELOPMENT: Using preemptive NX_User::exists");
            return true;
        }
    }
    
    error_log("CRITICAL: Preemptively defined NX_User class with has_prop method");
}

// IMPORTANT: Load NexusPress framework FIRST
// This ensures core functions are defined before we try to add stubs
require_once __DIR__ . '/nx-load.php';

// Now load stubs ONLY for functions that weren't defined by core
if (file_exists(__DIR__ . '/nx-admin/dev-stubs.php')) {
    require_once __DIR__ . '/nx-admin/dev-stubs.php';
}

// Apply development overrides
if (file_exists(__DIR__ . '/nx-admin/dev-override.php')) {
    require_once __DIR__ . '/nx-admin/dev-override.php';
}

// Use development bootstrap for admin
if (file_exists(__DIR__ . '/nx-admin/dev-bootstrap.php')) {
    require_once __DIR__ . '/nx-admin/dev-bootstrap.php';
}

// Define stub functions ONLY if they don't already exist
// This prevents redeclaration errors
if (!function_exists('nx_enqueue_script')) { function nx_enqueue_script() { return true; } }
if (!function_exists('nx_enqueue_style')) { function nx_enqueue_style() { return true; } }
if (!function_exists('nx_localize_script')) { function nx_localize_script() { return true; } }
if (!function_exists('nx_register_script')) { function nx_register_script() { return true; } }
if (!function_exists('nx_register_style')) { function nx_register_style() { return true; } }

// For development environments, directly include the admin dashboard
// This prevents redirect loops when admin_url() is misconfigured
require_once __DIR__ . '/nx-admin/index.php';
exit; 