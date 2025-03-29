<?php
/**
 * NexusPress Local Development Server
 * 
 * This script helps you quickly run NexusPress on your local machine for testing.
 */

// Configuration
$host = 'localhost';
$port = 8000;
$root = __DIR__; // Current directory

// Display header
echo "\n";
echo "╔═══════════════════════════════════════════════════════════╗\n";
echo "║                NexusPress Local Test Server               ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n\n";

// Check PHP version
echo "Checking PHP version... ";
if (version_compare(PHP_VERSION, '7.4', '<')) {
    echo "ERROR\n";
    echo "PHP 7.4 or higher is required. Your version: " . PHP_VERSION . "\n";
    exit(1);
}
echo "OK (v" . PHP_VERSION . ")\n";

// Check if required PHP extensions are available
echo "Checking required PHP extensions... ";
$required_extensions = ['mysqli', 'xml', 'json', 'ctype', 'mbstring'];
$missing_extensions = [];

foreach ($required_extensions as $ext) {
    if (!extension_loaded($ext)) {
        $missing_extensions[] = $ext;
    }
}

if (!empty($missing_extensions)) {
    echo "ERROR\n";
    echo "Missing required PHP extensions: " . implode(', ', $missing_extensions) . "\n";
    echo "Please enable these extensions in your php.ini file.\n";
    exit(1);
}
echo "OK\n";

// Check for sample config
echo "Checking for configuration file... ";
if (!file_exists('nx-config-sample.php')) {
    echo "ERROR\n";
    echo "Could not find nx-config-sample.php. Make sure you're running this script from the NexusPress root directory.\n";
    exit(1);
}
echo "OK\n";

// Check if nx-config.php exists, and create it if not
echo "Checking for nx-config.php... ";
if (!file_exists('nx-config.php')) {
    echo "NOT FOUND\n";
    echo "Creating a temporary configuration file...\n";
    
    // Create a basic configuration for testing
    $config_content = file_get_contents('nx-config-sample.php');
    $config_content = str_replace('database_name_here', 'nexuspress', $config_content);
    $config_content = str_replace('username_here', 'root', $config_content);
    $config_content = str_replace('password_here', '', $config_content);
    $config_content = str_replace('localhost', $host, $config_content);
    $config_content = str_replace('\'NX_DEBUG\', false', '\'NX_DEBUG\', true', $config_content);
    
    // Add unique salts
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_ []{}<>~`+=,.;:/?|';
    $salts = [
        'AUTH_KEY',
        'SECURE_AUTH_KEY',
        'LOGGED_IN_KEY',
        'NONCE_KEY',
        'AUTH_SALT',
        'SECURE_AUTH_SALT',
        'LOGGED_IN_SALT',
        'NONCE_SALT'
    ];

    foreach ($salts as $salt) {
        $salt_string = '';
        for ($i = 0; $i < 64; $i++) {
            $salt_string .= substr($chars, rand(0, strlen($chars) - 1), 1);
        }
        $config_content = preg_replace(
            "/define\\( *'$salt' *, *'put your unique phrase here' *\\);/",
            "define('$salt', '$salt_string');",
            $config_content
        );
    }

    file_put_contents('nx-config.php', $config_content);
    echo "Created nx-config.php with default settings. You'll need to update this with your database information.\n";
} else {
    echo "OK\n";
}

// Create router file to handle requests properly
echo "Creating router file... ";
$router_content = <<<'PHP'
<?php
// NexusPress router for the PHP built-in web server
if (php_sapi_name() === 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $file = __DIR__ . $path;
    
    // Serve static files directly
    if (is_file($file) && !preg_match('/\.php$/', $file)) {
        return false;
    }
    
    // Handle clean URLs
    if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|ico)$/', $path)) {
        return false;
    }
    
    // Handle front controller
    include 'index.php';
}
PHP;

file_put_contents('nx-router.php', $router_content);
echo "OK\n";

// Display information to the user
echo "\n";
echo "╔═══════════════════════════════════════════════════════════╗\n";
echo "║                       NEXT STEPS                          ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n\n";

echo "1. Make sure you have set up a MySQL database named 'nexuspress'.\n";
echo "2. Update nx-config.php with your database credentials if needed.\n";
echo "3. Starting the NexusPress server on http://{$host}:{$port}\n";
echo "4. Access that URL in your browser to complete the NexusPress installation.\n";
echo "5. Press Ctrl+C at any time to stop the server.\n\n";

echo "Starting server, please wait...\n";
sleep(2);

// Start PHP's built-in web server - fix for Windows paths with spaces
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    // On Windows, wrap the PHP binary path in quotes
    $command = '"' . PHP_BINARY . '" -S ' . $host . ':' . $port . ' nx-router.php';
} else {
    // On Unix systems
    $command = PHP_BINARY . ' -S ' . $host . ':' . $port . ' nx-router.php';
}

echo "\n";
echo "╔═══════════════════════════════════════════════════════════╗\n";
echo "║  SERVER STARTING: http://{$host}:{$port}                       ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n\n";

passthru($command); 