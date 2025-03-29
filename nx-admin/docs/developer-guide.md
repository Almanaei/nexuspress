# NexusPress Developer Guide

## Overview
This guide provides comprehensive information for developers working with NexusPress, including coding standards, best practices, and development workflows.

## Development Environment Setup

### Prerequisites
1. PHP 7.4 or higher
2. MySQL 5.6 or higher
3. Git version control
4. Composer package manager
5. Node.js and npm
6. PHPUnit for testing

### Local Development Setup
```bash
# Clone the repository
git clone https://github.com/your-org/nexuspress.git

# Install dependencies
composer install
npm install

# Set up development environment
cp nx-config-sample.php nx-config.php
php nx-admin/install.php
```

## Coding Standards

### PHP Standards
1. Follow PSR-12 coding style
2. Use type declarations
3. Document all functions and classes
4. Follow SOLID principles
5. Use meaningful variable names

### Example Code Structure
```php
/**
 * Class description
 *
 * @package NexusPress
 * @subpackage Core
 */
class NX_Example_Class {
    /**
     * Property description
     *
     * @var string
     */
    private $property;

    /**
     * Method description
     *
     * @param string $param Parameter description
     * @return bool Return description
     */
    public function example_method(string $param): bool {
        // Implementation
    }
}
```

## Core Development

### File Organization
```
nx-includes/
├── core/           # Core functionality
├── admin/          # Admin interface
├── api/            # API endpoints
├── database/       # Database operations
├── security/       # Security features
└── utils/          # Utility functions
```

### Core Classes
1. `NX_Core` - Main system class
2. `NX_Database` - Database operations
3. `NX_Security` - Security features
4. `NX_API` - API handling
5. `NX_Admin` - Admin interface

### Hook System
```php
// Adding actions
add_action('nx_init', 'my_callback');

// Adding filters
add_filter('the_content', 'my_filter');

// Removing actions
remove_action('nx_init', 'my_callback');

// Removing filters
remove_filter('the_content', 'my_filter');
```

## Plugin Development

### Plugin Structure
```
my-plugin/
├── my-plugin.php
├── includes/
├── admin/
├── public/
├── assets/
└── tests/
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
 */
```

### Plugin Class
```php
class NX_My_Plugin {
    /**
     * Plugin instance
     *
     * @var NX_My_Plugin
     */
    private static $instance;

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
        add_action('nx_init', array($this, 'init'));
    }

    /**
     * Initialize plugin
     */
    public function init(): void {
        // Plugin initialization
    }
}
```

## Theme Development

### Theme Structure
```
my-theme/
├── style.css
├── functions.php
├── index.php
├── header.php
├── footer.php
├── sidebar.php
├── assets/
└── templates/
```

### Theme Header
```css
/*
Theme Name: My Theme
Theme URI: https://example.com/themes/my-theme
Author: Your Name
Author URI: https://example.com
Description: Theme description
Version: 1.0.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: my-theme
*/
```

### Theme Functions
```php
/**
 * Theme setup
 */
function nx_theme_setup(): void {
    // Add theme support
    nx_add_theme_support('title-tag');
    nx_add_theme_support('post-thumbnails');
    nx_add_theme_support('custom-logo');

    // Register menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'my-theme'),
        'footer' => __('Footer Menu', 'my-theme'),
    ));
}
add_action('nx_after_setup_theme', 'nx_theme_setup');
```

## API Development

### REST API Endpoints
```php
/**
 * Register REST API endpoint
 */
function nx_register_api_endpoint(): void {
    register_rest_route('nx/v2', '/my-endpoint', array(
        'methods' => 'GET',
        'callback' => 'nx_handle_endpoint',
        'permission_callback' => 'nx_check_permission',
    ));
}
add_action('nx_rest_api_init', 'nx_register_api_endpoint');

/**
 * Handle endpoint request
 *
 * @param NX_REST_Request $request Request object
 * @return NX_REST_Response Response object
 */
function nx_handle_endpoint(NX_REST_Request $request): NX_REST_Response {
    // Handle request
    return new NX_REST_Response($data);
}
```

## Database Development

### Database Operations
```php
/**
 * Database operation example
 */
function nx_database_example(): void {
    global $nxdb;

    // Insert data
    $nxdb->insert(
        $nxdb->posts,
        array(
            'post_title' => 'Example Post',
            'post_content' => 'Example Content',
        ),
        array('%s', '%s')
    );

    // Update data
    $nxdb->update(
        $nxdb->posts,
        array('post_title' => 'Updated Title'),
        array('ID' => 1),
        array('%s'),
        array('%d')
    );

    // Delete data
    $nxdb->delete($nxdb->posts, array('ID' => 1), array('%d'));
}
```

## Testing

### Unit Testing
```php
/**
 * Test class
 */
class NX_Test_Example extends NX_UnitTestCase {
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

### Integration Testing
```php
/**
 * Integration test class
 */
class NX_Integration_Test extends NX_IntegrationTestCase {
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

## Security

### Security Best Practices
1. Validate and sanitize input
2. Use nonces for forms
3. Check user capabilities
4. Escape output
5. Use prepared statements

### Example Security Implementation
```php
/**
 * Secure function example
 */
function nx_secure_example(string $input): string {
    // Validate input
    if (!nx_validate_input($input)) {
        return '';
    }

    // Sanitize input
    $sanitized = nx_sanitize_input($input);

    // Check permissions
    if (!nx_check_permission('edit_posts')) {
        return '';
    }

    // Process data
    $result = nx_process_data($sanitized);

    // Escape output
    return nx_escape_output($result);
}
```

## Performance

### Performance Optimization
1. Use caching
2. Optimize database queries
3. Minimize HTTP requests
4. Use lazy loading
5. Implement asset optimization

### Example Performance Implementation
```php
/**
 * Performance optimized function
 */
function nx_performance_example(): void {
    // Use caching
    $cache_key = 'nx_cache_key';
    $cached_data = nx_cache_get($cache_key);

    if (false === $cached_data) {
        // Optimize query
        global $nxdb;
        $data = $nxdb->get_results(
            $nxdb->prepare(
                "SELECT * FROM {$nxdb->posts} WHERE post_status = %s",
                'publish'
            )
        );

        // Cache results
        nx_cache_set($cache_key, $data, 3600);
    }
}
```

## Deployment

### Deployment Process
1. Version control
2. Automated testing
3. Code review
4. Staging deployment
5. Production deployment

### Deployment Checklist
1. Run tests
2. Check coding standards
3. Update version numbers
4. Create changelog
5. Tag release

## Support
For additional developer support:
- Check the documentation
- Review code examples
- Contact technical support
- Join the developer community 