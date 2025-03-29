# NexusPress Plugin Development Guide

## Overview
This guide provides detailed information for developing plugins in NexusPress, including best practices, coding standards, and implementation examples.

## Plugin Structure

### Basic Structure
```
my-plugin/
├── my-plugin.php           # Main plugin file
├── includes/               # Core plugin classes
│   ├── class-admin.php
│   ├── class-public.php
│   └── class-core.php
├── admin/                  # Admin interface files
│   ├── css/
│   ├── js/
│   └── views/
├── public/                 # Public-facing files
│   ├── css/
│   ├── js/
│   └── views/
├── assets/                 # Shared assets
│   ├── images/
│   └── fonts/
├── languages/             # Translation files
├── templates/             # Template files
└── tests/                 # Test files
```

### Plugin Header
```php
/**
 * Plugin Name: My Plugin
 * Plugin URI: https://example.com/plugins/my-plugin
 * Description: Plugin description
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: my-plugin
 * Domain Path: /languages
 * Requires at least: 7.4
 * Requires PHP: 7.4
 */
```

## Plugin Development

### Main Plugin Class
```php
/**
 * Main plugin class
 *
 * @package MyPlugin
 */
class NX_My_Plugin {
    /**
     * Plugin instance
     *
     * @var NX_My_Plugin
     */
    private static $instance;

    /**
     * Plugin version
     *
     * @var string
     */
    private $version;

    /**
     * Get plugin instance
     *
     * @return NX_My_Plugin
     */
    public static function get_instance(): NX_My_Plugin {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
        $this->version = '1.0.0';
        $this->load_dependencies();
        $this->init_hooks();
    }

    /**
     * Load dependencies
     */
    private function load_dependencies(): void {
        require_once plugin_dir_path(__FILE__) . 'includes/class-admin.php';
        require_once plugin_dir_path(__FILE__) . 'includes/class-public.php';
        require_once plugin_dir_path(__FILE__) . 'includes/class-core.php';
    }

    /**
     * Initialize hooks
     */
    private function init_hooks(): void {
        add_action('nx_init', array($this, 'init'));
        add_action('nx_admin_init', array($this, 'admin_init'));
        add_action('nx_public_init', array($this, 'public_init'));
    }

    /**
     * Initialize plugin
     */
    public function init(): void {
        // Plugin initialization
    }

    /**
     * Initialize admin
     */
    public function admin_init(): void {
        // Admin initialization
    }

    /**
     * Initialize public
     */
    public function public_init(): void {
        // Public initialization
    }
}
```

### Admin Class
```php
/**
 * Admin class
 *
 * @package MyPlugin
 */
class NX_My_Plugin_Admin {
    /**
     * Initialize admin
     */
    public function init(): void {
        add_action('nx_admin_menu', array($this, 'add_menu_pages'));
        add_action('nx_admin_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    /**
     * Add menu pages
     */
    public function add_menu_pages(): void {
        add_menu_page(
            __('My Plugin', 'my-plugin'),
            __('My Plugin', 'my-plugin'),
            'manage_options',
            'my-plugin',
            array($this, 'render_main_page'),
            'dashicons-admin-generic',
            30
        );
    }

    /**
     * Enqueue scripts
     */
    public function enqueue_scripts(): void {
        nx_enqueue_style(
            'my-plugin-admin',
            plugin_dir_url(__FILE__) . 'admin/css/admin.css',
            array(),
            $this->version
        );

        nx_enqueue_script(
            'my-plugin-admin',
            plugin_dir_url(__FILE__) . 'admin/js/admin.js',
            array('jquery'),
            $this->version,
            true
        );
    }

    /**
     * Render main page
     */
    public function render_main_page(): void {
        require_once plugin_dir_path(__FILE__) . 'admin/views/main-page.php';
    }
}
```

### Public Class
```php
/**
 * Public class
 *
 * @package MyPlugin
 */
class NX_My_Plugin_Public {
    /**
     * Initialize public
     */
    public function init(): void {
        add_action('nx_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_filter('the_content', array($this, 'filter_content'));
    }

    /**
     * Enqueue scripts
     */
    public function enqueue_scripts(): void {
        nx_enqueue_style(
            'my-plugin-public',
            plugin_dir_url(__FILE__) . 'public/css/public.css',
            array(),
            $this->version
        );

        nx_enqueue_script(
            'my-plugin-public',
            plugin_dir_url(__FILE__) . 'public/js/public.js',
            array('jquery'),
            $this->version,
            true
        );
    }

    /**
     * Filter content
     *
     * @param string $content Post content
     * @return string Modified content
     */
    public function filter_content(string $content): string {
        // Modify content
        return $content;
    }
}
```

## Plugin Features

### Custom Post Types
```php
/**
 * Register custom post type
 */
function nx_register_custom_post_type(): void {
    register_post_type('my_custom_type', array(
        'labels' => array(
            'name' => __('Custom Types', 'my-plugin'),
            'singular_name' => __('Custom Type', 'my-plugin'),
        ),
        'public' => true,
        'show_in_menu' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'has_archive' => true,
        'rewrite' => array('slug' => 'custom-type'),
    ));
}
add_action('nx_init', 'nx_register_custom_post_type');
```

### Custom Taxonomies
```php
/**
 * Register custom taxonomy
 */
function nx_register_custom_taxonomy(): void {
    register_taxonomy('my_taxonomy', 'my_custom_type', array(
        'labels' => array(
            'name' => __('Custom Taxonomies', 'my-plugin'),
            'singular_name' => __('Custom Taxonomy', 'my-plugin'),
        ),
        'hierarchical' => true,
        'show_admin_column' => true,
        'rewrite' => array('slug' => 'custom-taxonomy'),
    ));
}
add_action('nx_init', 'nx_register_custom_taxonomy');
```

### Custom Meta Boxes
```php
/**
 * Add meta box
 */
function nx_add_meta_box(): void {
    add_meta_box(
        'my_meta_box',
        __('My Meta Box', 'my-plugin'),
        'nx_render_meta_box',
        'my_custom_type',
        'normal',
        'high'
    );
}
add_action('nx_add_meta_boxes', 'nx_add_meta_box');

/**
 * Render meta box
 *
 * @param NX_Post $post Post object
 */
function nx_render_meta_box($post): void {
    // Add nonce
    nx_nonce_field('my_meta_box', 'my_meta_box_nonce');

    // Get meta value
    $value = get_post_meta($post->ID, 'my_meta_key', true);

    // Render field
    ?>
    <p>
        <label for="my_meta_field"><?php _e('My Field', 'my-plugin'); ?></label>
        <input type="text" id="my_meta_field" name="my_meta_field" value="<?php echo esc_attr($value); ?>">
    </p>
    <?php
}
```

### Settings API
```php
/**
 * Register settings
 */
function nx_register_settings(): void {
    register_setting('my_plugin_options', 'my_plugin_settings');

    add_settings_section(
        'my_plugin_main_section',
        __('Main Settings', 'my-plugin'),
        'nx_section_callback',
        'my_plugin_options'
    );

    add_settings_field(
        'my_plugin_field',
        __('My Field', 'my-plugin'),
        'nx_field_callback',
        'my_plugin_options',
        'my_plugin_main_section'
    );
}
add_action('nx_admin_init', 'nx_register_settings');

/**
 * Section callback
 */
function nx_section_callback(): void {
    echo '<p>' . esc_html__('Main settings section description.', 'my-plugin') . '</p>';
}

/**
 * Field callback
 */
function nx_field_callback(): void {
    $options = get_option('my_plugin_settings');
    $value = isset($options['my_field']) ? $options['my_field'] : '';
    ?>
    <input type="text" name="my_plugin_settings[my_field]" value="<?php echo esc_attr($value); ?>">
    <?php
}
```

## Plugin Security

### Data Validation
```php
/**
 * Validate data
 *
 * @param mixed $data Data to validate
 * @return bool Whether data is valid
 */
function nx_validate_data($data): bool {
    if (!is_string($data)) {
        return false;
    }

    if (empty($data)) {
        return false;
    }

    return true;
}
```

### Data Sanitization
```php
/**
 * Sanitize data
 *
 * @param string $data Data to sanitize
 * @return string Sanitized data
 */
function nx_sanitize_data(string $data): string {
    return sanitize_text_field($data);
}
```

### Nonce Verification
```php
/**
 * Verify nonce
 *
 * @return bool Whether nonce is valid
 */
function nx_verify_nonce(): bool {
    if (!isset($_POST['my_nonce'])) {
        return false;
    }

    return nx_verify_nonce($_POST['my_nonce'], 'my_action');
}
```

## Plugin Performance

### Caching
```php
/**
 * Cache data
 *
 * @param string $key Cache key
 * @param mixed $data Data to cache
 * @return bool Whether caching was successful
 */
function nx_cache_data(string $key, $data): bool {
    return nx_cache_set($key, $data, 'my_plugin', 3600);
}

/**
 * Get cached data
 *
 * @param string $key Cache key
 * @return mixed Cached data
 */
function nx_get_cached_data(string $key) {
    return nx_cache_get($key, 'my_plugin');
}
```

### Database Optimization
```php
/**
 * Optimize database query
 *
 * @return array Query results
 */
function nx_optimized_query(): array {
    global $nxdb;

    return $nxdb->get_results(
        $nxdb->prepare(
            "SELECT * FROM {$nxdb->posts} WHERE post_status = %s LIMIT %d",
            'publish',
            10
        )
    );
}
```

## Plugin Testing

### Unit Tests
```php
/**
 * Test class
 */
class NX_My_Plugin_Test extends NX_UnitTestCase {
    /**
     * Test setup
     */
    public function setUp(): void {
        parent::setUp();
        // Test setup
    }

    /**
     * Test example
     */
    public function test_example(): void {
        $this->assertTrue(true);
    }
}
```

### Integration Tests
```php
/**
 * Integration test class
 */
class NX_My_Plugin_Integration_Test extends NX_IntegrationTestCase {
    /**
     * Test setup
     */
    public function setUp(): void {
        parent::setUp();
        // Test setup
    }

    /**
     * Test example
     */
    public function test_integration(): void {
        $this->assertTrue(true);
    }
}
```

## Plugin Deployment

### Version Control
```bash
# Initialize git repository
git init

# Add files
git add .

# Commit changes
git commit -m "Initial commit"

# Add remote
git remote add origin https://github.com/your-org/my-plugin.git

# Push changes
git push -u origin master
```

### Release Process
1. Update version number
2. Update changelog
3. Create release tag
4. Build release package
5. Deploy to repository

## Support
For additional plugin development support:
- Check the documentation
- Review code examples
- Contact technical support
- Join the developer community 