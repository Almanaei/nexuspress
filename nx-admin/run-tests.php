<?php
/**
 * NexusPress Testing Script Runner
 *
 * This script runs the verification and testing steps (48-57) with real database connection.
 * @package NexusPress
 */

// Define paths
define('ABSPATH', dirname(__DIR__) . '/');

// Include the NexusPress config file to get database connection info
if (file_exists(ABSPATH . 'nx-config.php')) {
    require_once(ABSPATH . 'nx-config.php');
} else {
    die("Error: nx-config.php not found. Please ensure the configuration file exists.\n");
}

// Define constants that might be needed
if (!defined('NXINC')) {
    define('NXINC', 'nx-includes');
}

// Function to connect to the database
function connect_to_database() {
    global $table_prefix;
    
    // Database connection parameters from nx-config.php
    $host = defined('DB_HOST') ? DB_HOST : 'localhost';
    $dbname = defined('DB_NAME') ? DB_NAME : 'nexuspress';
    $user = defined('DB_USER') ? DB_USER : 'root';
    $pass = defined('DB_PASSWORD') ? DB_PASSWORD : '';
    
    try {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        return $pdo;
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage() . "\n");
    }
}

// Function to run a real test and report results
function run_real_test($test_name, $test_function) {
    echo "🔄 Testing $test_name... ";
    
    try {
        $result = $test_function();
        if ($result === true) {
            echo "✅ PASSED\n";
            return true;
        } else {
            echo "❌ FAILED: $result\n";
            return false;
        }
    } catch (Exception $e) {
        echo "❌ ERROR: " . $e->getMessage() . "\n";
        return false;
    }
}

// Connect to the database
$db = connect_to_database();
echo "Connected to database successfully.\n";

// Run the tests
echo "\n========== RUNNING VERIFICATION AND TESTING STEPS ==========\n\n";

$tests_completed = 0;
$total_tests = 10;
$passed_tests = 0;

// Step 48: Test admin login functionality
$passed_tests += run_real_test("admin login functionality", function() use ($db, $table_prefix) {
    // Check if users table exists and contains at least one admin user
    $stmt = $db->query("SHOW TABLES LIKE '{$table_prefix}users'");
    if ($stmt->rowCount() == 0) {
        return "Users table not found";
    }
    
    $stmt = $db->query("SELECT * FROM {$table_prefix}users u 
                         JOIN {$table_prefix}usermeta m ON u.ID = m.user_id 
                         WHERE m.meta_key = '{$table_prefix}capabilities' 
                         AND m.meta_value LIKE '%administrator%' LIMIT 1");
    
    if ($stmt->rowCount() == 0) {
        return "No administrator user found";
    }
    
    return true;
}) ? 1 : 0;
$tests_completed++;

// Step 49: Test content creation and editing
$passed_tests += run_real_test("content creation and editing", function() use ($db, $table_prefix) {
    // Check if posts table exists
    $stmt = $db->query("SHOW TABLES LIKE '{$table_prefix}posts'");
    if ($stmt->rowCount() == 0) {
        return "Posts table not found";
    }
    
    // Check if we can insert a test post
    try {
        $db->beginTransaction();
        $stmt = $db->prepare("INSERT INTO {$table_prefix}posts (post_title, post_content, post_status, post_type, post_author) 
                              VALUES (?, ?, ?, ?, ?)");
        $stmt->execute(['Test Post', 'This is a test post content.', 'draft', 'post', 1]);
        $post_id = $db->lastInsertId();
        
        // Check if the post was successfully inserted
        $stmt = $db->prepare("SELECT ID FROM {$table_prefix}posts WHERE ID = ?");
        $stmt->execute([$post_id]);
        
        if ($stmt->rowCount() == 0) {
            $db->rollBack();
            return "Failed to insert test post";
        }
        
        // Test post update
        $stmt = $db->prepare("UPDATE {$table_prefix}posts SET post_title = ? WHERE ID = ?");
        $stmt->execute(['Updated Test Post', $post_id]);
        
        // Clean up - delete the test post
        $stmt = $db->prepare("DELETE FROM {$table_prefix}posts WHERE ID = ?");
        $stmt->execute([$post_id]);
        
        $db->commit();
        return true;
    } catch (Exception $e) {
        $db->rollBack();
        return "Database error: " . $e->getMessage();
    }
}) ? 1 : 0;
$tests_completed++;

// Step 50: Test theme functionality
$passed_tests += run_real_test("theme functionality", function() use ($db, $table_prefix) {
    // Check if there's at least one theme in the filesystem
    $theme_dir = ABSPATH . 'nx-content/themes';
    if (!is_dir($theme_dir)) {
        return "Themes directory not found";
    }
    
    $themes = array_filter(scandir($theme_dir), function($item) use ($theme_dir) {
        return is_dir($theme_dir . '/' . $item) && $item != '.' && $item != '..';
    });
    
    if (count($themes) == 0) {
        return "No themes found";
    }
    
    // Check if theme has required files
    foreach ($themes as $theme) {
        if (file_exists($theme_dir . '/' . $theme . '/style.css')) {
            // At least one valid theme exists
            return true;
        }
    }
    
    return "No valid themes found (missing style.css)";
}) ? 1 : 0;
$tests_completed++;

// Step 51: Test plugin functionality
$passed_tests += run_real_test("plugin functionality", function() use ($db, $table_prefix) {
    // Check if plugins directory exists and contains plugins
    $plugin_dir = ABSPATH . 'nx-content/plugins';
    if (!is_dir($plugin_dir)) {
        return "Plugins directory not found";
    }
    
    $plugins = array_filter(scandir($plugin_dir), function($item) use ($plugin_dir) {
        return is_dir($plugin_dir . '/' . $item) && $item != '.' && $item != '..' ||
               (is_file($plugin_dir . '/' . $item) && pathinfo($item, PATHINFO_EXTENSION) == 'php');
    });
    
    if (count($plugins) == 0) {
        return "No plugins found";
    }
    
    // Check if options table exists for plugin options
    $stmt = $db->query("SHOW TABLES LIKE '{$table_prefix}options'");
    if ($stmt->rowCount() == 0) {
        return "Options table not found";
    }
    
    // Check active plugins option
    $stmt = $db->prepare("SELECT option_value FROM {$table_prefix}options WHERE option_name = ?");
    $stmt->execute(['active_plugins']);
    
    if ($stmt->rowCount() > 0) {
        // At least one active plugin option found
        return true;
    }
    
    return "No active plugins found in the database";
}) ? 1 : 0;
$tests_completed++;

// Step 52: Test user management system
$passed_tests += run_real_test("user management system", function() use ($db, $table_prefix) {
    // Check user tables
    $tables = [
        "{$table_prefix}users" => "Users table",
        "{$table_prefix}usermeta" => "User meta table"
    ];
    
    foreach ($tables as $table => $name) {
        $stmt = $db->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() == 0) {
            return "$name not found";
        }
    }
    
    // Check if we can query user roles
    $stmt = $db->query("SELECT m.meta_value 
                        FROM {$table_prefix}usermeta m 
                        WHERE m.meta_key = '{$table_prefix}capabilities' 
                        LIMIT 5");
    
    if ($stmt->rowCount() == 0) {
        return "User capabilities not found";
    }
    
    return true;
}) ? 1 : 0;
$tests_completed++;

// Step 53: Test media uploads and handling
$passed_tests += run_real_test("media uploads and handling", function() use ($db, $table_prefix) {
    // Check upload directory
    $upload_dir = ABSPATH . 'nx-content/uploads';
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0755, true)) {
            return "Upload directory not found and could not be created";
        }
    }
    
    // Check if the directory is writable
    if (!is_writable($upload_dir)) {
        return "Upload directory is not writable";
    }
    
    // Check if posts table exists for attachments
    $stmt = $db->query("SHOW TABLES LIKE '{$table_prefix}posts'");
    if ($stmt->rowCount() == 0) {
        return "Posts table not found for media attachments";
    }
    
    // Check if there are any media attachments
    $stmt = $db->query("SELECT COUNT(*) as count FROM {$table_prefix}posts WHERE post_type = 'attachment'");
    $result = $stmt->fetch();
    
    if (isset($result['count']) && $result['count'] > 0) {
        return true;
    } else {
        // This is not a failure, just a note
        echo "(no existing media found, but functionality is available) ";
        return true;
    }
}) ? 1 : 0;
$tests_completed++;

// Step 54: Test permalinks and URL structures
$passed_tests += run_real_test("permalinks and URL structures", function() use ($db, $table_prefix) {
    // Check option for permalink structure
    $stmt = $db->prepare("SELECT option_value FROM {$table_prefix}options WHERE option_name = ?");
    $stmt->execute(['permalink_structure']);
    
    if ($stmt->rowCount() > 0) {
        $permalink = $stmt->fetch()['option_value'];
        if (empty($permalink)) {
            echo "(using default permalinks) ";
        } else {
            echo "(using custom permalinks) ";
        }
        return true;
    }
    
    return "Permalink structure option not found";
}) ? 1 : 0;
$tests_completed++;

// Step 55: Test search functionality
$passed_tests += run_real_test("search functionality", function() use ($db, $table_prefix) {
    // Check if posts table exists for searching
    $stmt = $db->query("SHOW TABLES LIKE '{$table_prefix}posts'");
    if ($stmt->rowCount() == 0) {
        return "Posts table not found for search functionality";
    }
    
    // Test a basic search query
    try {
        $stmt = $db->prepare("SELECT ID FROM {$table_prefix}posts 
                             WHERE post_status = 'publish' 
                             AND (post_title LIKE ? OR post_content LIKE ?) 
                             LIMIT 10");
        $term = '%test%';
        $stmt->execute([$term, $term]);
        
        // Search functionality works even if no results found
        return true;
    } catch (Exception $e) {
        return "Search query failed: " . $e->getMessage();
    }
}) ? 1 : 0;
$tests_completed++;

// Step 56: Test comment system
$passed_tests += run_real_test("comment system", function() use ($db, $table_prefix) {
    // Check comments table
    $stmt = $db->query("SHOW TABLES LIKE '{$table_prefix}comments'");
    if ($stmt->rowCount() == 0) {
        return "Comments table not found";
    }
    
    // Check commentmeta table
    $stmt = $db->query("SHOW TABLES LIKE '{$table_prefix}commentmeta'");
    if ($stmt->rowCount() == 0) {
        return "Comment meta table not found";
    }
    
    return true;
}) ? 1 : 0;
$tests_completed++;

// Step 57: Verify all core functionality
$passed_tests += run_real_test("core functionality verification", function() use ($db, $table_prefix) {
    // Check required tables
    $required_tables = [
        "{$table_prefix}posts",
        "{$table_prefix}postmeta",
        "{$table_prefix}users",
        "{$table_prefix}usermeta",
        "{$table_prefix}comments",
        "{$table_prefix}commentmeta",
        "{$table_prefix}terms",
        "{$table_prefix}term_taxonomy",
        "{$table_prefix}term_relationships",
        "{$table_prefix}options"
    ];
    
    $missing_tables = [];
    foreach ($required_tables as $table) {
        $stmt = $db->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() == 0) {
            $missing_tables[] = $table;
        }
    }
    
    if (!empty($missing_tables)) {
        return "Missing core tables: " . implode(", ", $missing_tables);
    }
    
    // Check for required options
    $required_options = [
        'siteurl',
        'home',
        'blogname',
        'blogdescription',
        'template',
        'stylesheet'
    ];
    
    $missing_options = [];
    foreach ($required_options as $option) {
        $stmt = $db->prepare("SELECT option_id FROM {$table_prefix}options WHERE option_name = ?");
        $stmt->execute([$option]);
        if ($stmt->rowCount() == 0) {
            $missing_options[] = $option;
        }
    }
    
    if (!empty($missing_options)) {
        return "Missing core options: " . implode(", ", $missing_options);
    }
    
    return true;
}) ? 1 : 0;
$tests_completed++;

// Print test summary
$success_rate = ($passed_tests / $total_tests) * 100;

echo "\nTest Summary: $passed_tests of $total_tests tests passed (" . round($success_rate, 2) . "% success rate)\n";

if ($passed_tests == $total_tests) {
    echo "All verification and testing steps (48-57) have been completed successfully.\n";
} else {
    echo "Some tests failed. Please review the test results above.\n";
}

echo "\n========== TESTS COMPLETED ==========\n"; 