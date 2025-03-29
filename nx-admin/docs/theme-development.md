# NexusPress Theme Development Guide

## Overview
This guide provides detailed information for developing themes in NexusPress, including best practices, coding standards, and implementation examples.

## Theme Structure

### Basic Structure
```
my-theme/
├── style.css              # Main theme stylesheet
├── functions.php          # Theme functions
├── index.php             # Main template file
├── header.php            # Header template
├── footer.php            # Footer template
├── sidebar.php           # Sidebar template
├── single.php            # Single post template
├── page.php              # Page template
├── archive.php           # Archive template
├── search.php            # Search results template
├── 404.php              # 404 error template
├── assets/              # Theme assets
│   ├── css/             # Additional stylesheets
│   ├── js/              # JavaScript files
│   ├── images/          # Theme images
│   └── fonts/           # Custom fonts
├── inc/                 # Include files
│   ├── customizer.php   # Theme customizer
│   ├── template-tags.php # Template functions
│   └── widgets.php      # Custom widgets
├── template-parts/      # Template parts
│   ├── content.php      # Post content
│   ├── content-page.php # Page content
│   └── content-none.php # No content found
├── languages/           # Translation files
└── templates/           # Custom templates
```

### Theme Header
```php
/**
 * Theme Name: My Theme
 * Theme URI: https://example.com/themes/my-theme
 * Description: Theme description
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: my-theme
 * Domain Path: /languages
 * Requires at least: 7.4
 * Requires PHP: 7.4
 */
```

## Theme Development

### Theme Setup
```php
/**
 * Theme setup
 */
function nx_theme_setup(): void {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'my-theme'),
        'footer' => __('Footer Menu', 'my-theme'),
    ));
}
add_action('nx_after_setup_theme', 'nx_theme_setup');
```

### Enqueue Scripts and Styles
```php
/**
 * Enqueue scripts and styles
 */
function nx_enqueue_scripts(): void {
    // Enqueue main stylesheet
    nx_enqueue_style(
        'my-theme-style',
        get_stylesheet_uri(),
        array(),
        nx_get_theme()->get('Version')
    );

    // Enqueue custom stylesheet
    nx_enqueue_style(
        'my-theme-custom',
        get_template_directory_uri() . '/assets/css/custom.css',
        array(),
        nx_get_theme()->get('Version')
    );

    // Enqueue custom JavaScript
    nx_enqueue_script(
        'my-theme-script',
        get_template_directory_uri() . '/assets/js/custom.js',
        array('jquery'),
        nx_get_theme()->get('Version'),
        true
    );

    // Localize script
    nx_localize_script('my-theme-script', 'myThemeData', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => nx_create_nonce('my_theme_nonce'),
    ));
}
add_action('nx_enqueue_scripts', 'nx_enqueue_scripts');
```

### Custom Widgets
```php
/**
 * Register custom widget
 */
class NX_My_Widget extends NX_Widget {
    /**
     * Widget constructor
     */
    public function __construct() {
        parent::__construct(
            'my_widget',
            __('My Widget', 'my-theme'),
            array('description' => __('A custom widget.', 'my-theme'))
        );
    }

    /**
     * Widget form
     *
     * @param array $instance Widget instance
     * @return void
     */
    public function form($instance): void {
        $title = isset($instance['title']) ? $instance['title'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                <?php _e('Title:', 'my-theme'); ?>
            </label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>"
                   type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }

    /**
     * Widget update
     *
     * @param array $new_instance New widget instance
     * @param array $old_instance Old widget instance
     * @return array Updated widget instance
     */
    public function update($new_instance, $old_instance): array {
        $instance = array();
        $instance['title'] = sanitize_text_field($new_instance['title']);
        return $instance;
    }

    /**
     * Widget display
     *
     * @param array $args Widget arguments
     * @param array $instance Widget instance
     * @return void
     */
    public function widget($args, $instance): void {
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'];
        }
        // Widget content
        echo $args['after_widget'];
    }
}

/**
 * Register widgets
 */
function nx_register_widgets(): void {
    register_widget('NX_My_Widget');
}
add_action('nx_widgets_init', 'nx_register_widgets');
```

### Custom Templates
```php
/**
 * Custom template tags
 */
function nx_custom_template_tag(): void {
    // Custom template tag implementation
}
```

### Template Parts
```php
/**
 * Get template part
 *
 * @param string $slug Template slug
 * @param string $name Template name
 * @return void
 */
function nx_get_template_part(string $slug, ?string $name = null): void {
    get_template_part($slug, $name);
}
```

## Theme Features

### Custom Post Types
```php
/**
 * Register custom post type
 */
function nx_register_custom_post_type(): void {
    register_post_type('my_custom_type', array(
        'labels' => array(
            'name' => __('Custom Types', 'my-theme'),
            'singular_name' => __('Custom Type', 'my-theme'),
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
            'name' => __('Custom Taxonomies', 'my-theme'),
            'singular_name' => __('Custom Taxonomy', 'my-theme'),
        ),
        'hierarchical' => true,
        'show_admin_column' => true,
        'rewrite' => array('slug' => 'custom-taxonomy'),
    ));
}
add_action('nx_init', 'nx_register_custom_taxonomy');
```

### Theme Customizer
```php
/**
 * Theme customizer
 *
 * @param NX_Customize_Manager $nx_customize Customizer object
 * @return void
 */
function nx_customize_register($nx_customize): void {
    // Add section
    $nx_customize->add_section('my_theme_section', array(
        'title' => __('My Theme Settings', 'my-theme'),
        'priority' => 30,
    ));

    // Add setting
    $nx_customize->add_setting('my_theme_setting', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    // Add control
    $nx_customize->add_control('my_theme_control', array(
        'label' => __('My Setting', 'my-theme'),
        'section' => 'my_theme_section',
        'settings' => 'my_theme_setting',
        'type' => 'text',
    ));
}
add_action('nx_customize_register', 'nx_customize_register');
```

## Theme Security

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

## Theme Performance

### Asset Optimization
```php
/**
 * Optimize assets
 */
function nx_optimize_assets(): void {
    // Minify CSS
    if (!is_admin()) {
        nx_enqueue_style(
            'my-theme-minified',
            get_template_directory_uri() . '/assets/css/minified.css',
            array(),
            nx_get_theme()->get('Version')
        );
    }

    // Minify JavaScript
    if (!is_admin()) {
        nx_enqueue_script(
            'my-theme-minified',
            get_template_directory_uri() . '/assets/js/minified.js',
            array('jquery'),
            nx_get_theme()->get('Version'),
            true
        );
    }
}
add_action('nx_enqueue_scripts', 'nx_optimize_assets');
```

### Lazy Loading
```php
/**
 * Add lazy loading
 */
function nx_add_lazy_loading(): void {
    add_filter('nx_post_thumbnail_html', function($html) {
        return str_replace('src=', 'loading="lazy" src=', $html);
    });
}
add_action('nx_init', 'nx_add_lazy_loading');
```

## Theme Testing

### Unit Tests
```php
/**
 * Test class
 */
class NX_My_Theme_Test extends NX_UnitTestCase {
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
class NX_My_Theme_Integration_Test extends NX_IntegrationTestCase {
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

## Theme Deployment

### Version Control
```bash
# Initialize git repository
git init

# Add files
git add .

# Commit changes
git commit -m "Initial commit"

# Add remote
git remote add origin https://github.com/your-org/my-theme.git

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
For additional theme development support:
- Check the documentation
- Review code examples
- Contact technical support
- Join the developer community 