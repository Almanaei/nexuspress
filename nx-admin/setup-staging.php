<?php
/**
 * NexusPress Staging Environment Setup Script
 *
 * @package NexusPress
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    die('Direct access not permitted.');
}

// Start timing
$start_time = microtime(true);

echo "Starting staging environment setup...\n\n";

// Configuration
$staging_dir = dirname(__DIR__) . '/staging';
$staging_db = DB_NAME . '_staging';
$staging_url = 'http://localhost/staging';

// Create staging directory
echo "Creating staging directory...\n";
if (!file_exists($staging_dir)) {
    if (!mkdir($staging_dir, 0755, true)) {
        die("Failed to create staging directory: $staging_dir\n");
    }
    echo "Created staging directory: $staging_dir\n";
} else {
    echo "Staging directory already exists\n";
}

// Copy files to staging
echo "\nCopying files to staging...\n";
$files_to_copy = array(
    'nx-admin',
    'nx-content',
    'nx-includes',
    'nx-config.php',
    'nx-settings.php',
    'nx-load.php',
    'nx-login.php',
    'nx-cron.php',
    '.htaccess',
    'index.php'
);

foreach ($files_to_copy as $file) {
    $source = dirname(__DIR__) . '/' . $file;
    $destination = $staging_dir . '/' . $file;
    
    if (is_dir($source)) {
        if (!file_exists($destination)) {
            if (!mkdir($destination, 0755, true)) {
                die("Failed to create directory: $destination\n");
            }
        }
        
        // Copy directory contents
        $dir = new RecursiveDirectoryIterator($source);
        $iterator = new RecursiveIteratorIterator($dir);
        foreach ($iterator as $item) {
            if ($item->isFile()) {
                $target = $destination . '/' . $iterator->getSubPathName();
                $target_dir = dirname($target);
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0755, true);
                }
                copy($item->getPathname(), $target);
            }
        }
    } else {
        if (file_exists($source)) {
            copy($source, $destination);
        }
    }
    echo "Copied $file\n";
}

// Create staging database
echo "\nCreating staging database...\n";
$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Drop existing staging database if it exists
$db->query("DROP DATABASE IF EXISTS `$staging_db`");

// Create new staging database
if (!$db->query("CREATE DATABASE `$staging_db`")) {
    die("Failed to create staging database: " . $db->error . "\n");
}
echo "Created staging database: $staging_db\n";

// Copy production database to staging
echo "\nCopying production database to staging...\n";
$backup_file = $staging_dir . '/staging_backup.sql';
$command = sprintf(
    'mysqldump -h %s -u %s %s %s > %s',
    escapeshellarg(DB_HOST),
    escapeshellarg(DB_USER),
    DB_PASSWORD ? '-p' . escapeshellarg(DB_PASSWORD) : '',
    escapeshellarg(DB_NAME),
    escapeshellarg($backup_file)
);

exec($command, $output, $return_var);
if ($return_var !== 0) {
    die("Failed to create database backup: " . implode("\n", $output) . "\n");
}

// Import backup to staging database
$command = sprintf(
    'mysql -h %s -u %s %s %s < %s',
    escapeshellarg(DB_HOST),
    escapeshellarg(DB_USER),
    DB_PASSWORD ? '-p' . escapeshellarg(DB_PASSWORD) : '',
    escapeshellarg($staging_db),
    escapeshellarg($backup_file)
);

exec($command, $output, $return_var);
if ($return_var !== 0) {
    die("Failed to import database to staging: " . implode("\n", $output) . "\n");
}
echo "Database copied successfully\n";

// Update staging configuration
echo "\nUpdating staging configuration...\n";
$config_file = $staging_dir . '/nx-config.php';
$config_content = file_get_contents($config_file);

// Update database name
$config_content = str_replace(
    "define('DB_NAME', '" . DB_NAME . "')",
    "define('DB_NAME', '$staging_db')",
    $config_content
);

// Update site URL
$config_content = str_replace(
    "define('SITE_URL', '" . SITE_URL . "')",
    "define('SITE_URL', '$staging_url')",
    $config_content
);

// Update table prefix
$config_content = str_replace(
    "\$table_prefix = '" . TABLE_PREFIX . "'",
    "\$table_prefix = 'staging_'",
    $config_content
);

file_put_contents($config_file, $config_content);
echo "Configuration updated successfully\n";

// Create .htaccess for staging
echo "\nCreating staging .htaccess...\n";
$htaccess_content = <<<EOT
# NexusPress Staging Environment
RewriteEngine On
RewriteBase /staging/

# Handle front controller pattern
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [L]

# Prevent access to sensitive files
<FilesMatch "^\.">
    Order allow,deny
    Deny from all
</FilesMatch>

# Prevent access to sensitive directories
<FilesMatch "^(nx-config\.php|nx-settings\.php|nx-load\.php)$">
    Order allow,deny
    Deny from all
</FilesMatch>
EOT;

file_put_contents($staging_dir . '/.htaccess', $htaccess_content);
echo "Created staging .htaccess\n";

// Create staging environment file
echo "\nCreating staging environment file...\n";
$env_content = <<<EOT
<?php
/**
 * NexusPress Staging Environment Configuration
 *
 * @package NexusPress
 */

// Environment
define('NX_ENV', 'staging');

// Debug mode
define('NX_DEBUG', true);

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Disable caching
define('NX_CACHE', false);

// Disable external API calls
define('NX_DISABLE_API', true);
EOT;

file_put_contents($staging_dir . '/nx-env.php', $env_content);
echo "Created staging environment file\n";

// Calculate and display timing
$end_time = microtime(true);
$duration = round($end_time - $start_time, 2);
echo "\nStaging environment setup completed in {$duration} seconds.\n";

echo "\nStaging Environment Details:\n";
echo "Directory: $staging_dir\n";
echo "Database: $staging_db\n";
echo "URL: $staging_url\n";
echo "Table Prefix: staging_\n\n";

echo "Next steps:\n";
echo "1. Configure your web server to serve the staging directory\n";
echo "2. Update your hosts file if needed\n";
echo "3. Run the migration scripts in the staging environment\n";
echo "4. Test all functionality in the staging environment\n\n";

echo "Staging environment setup completed successfully!\n"; 