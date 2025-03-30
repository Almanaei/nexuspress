<?php
/**
 * Pure index file - no NexusPress dependencies
 */

// Ensure we display errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set content type to HTML
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusPress - Pure PHP Page</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        h1, h2, h3 {
            color: #0073aa;
        }
        header {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .content {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin: 20px 0;
        }
        pre {
            background: #f5f5f5;
            border: 1px solid #ddd;
            padding: 15px;
            overflow: auto;
            font-size: 14px;
            line-height: 1.5;
        }
        .success {
            color: green;
            font-weight: bold;
        }
        .error {
            color: red;
            font-weight: bold;
        }
        .button {
            display: inline-block;
            padding: 8px 16px;
            background: #0073aa;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 10px;
        }
        footer {
            margin-top: 30px;
            border-top: 1px solid #eee;
            padding-top: 10px;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <header>
        <h1>NexusPress - Pure PHP Page</h1>
        <p>This page is completely standalone with no NexusPress dependencies.</p>
    </header>

    <div class="content">
        <h2>Server Information</h2>
        
        <h3>PHP Environment</h3>
        <ul>
            <li>PHP Version: <?php echo phpversion(); ?></li>
            <li>Server Software: <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?></li>
            <li>Request Time: <?php echo date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']); ?></li>
            <li>Memory Limit: <?php echo ini_get('memory_limit'); ?></li>
            <li>Max Execution Time: <?php echo ini_get('max_execution_time'); ?> seconds</li>
            <li>Display Errors: <?php echo ini_get('display_errors') ? 'On' : 'Off'; ?></li>
        </ul>

        <h3>Request Details</h3>
        <ul>
            <li>Request URI: <?php echo htmlspecialchars($_SERVER['REQUEST_URI'] ?? 'Unknown'); ?></li>
            <li>Request Method: <?php echo $_SERVER['REQUEST_METHOD'] ?? 'Unknown'; ?></li>
            <li>Query String: <?php echo htmlspecialchars($_SERVER['QUERY_STRING'] ?? 'None'); ?></li>
        </ul>

        <h3>Filesystem</h3>
        <?php
        // Check if we can access the filesystem
        $currentDir = __DIR__;
        $canAccessFiles = is_readable($currentDir);
        
        if ($canAccessFiles) {
            echo '<p class="success">Filesystem is accessible</p>';
            
            // List some files in the current directory
            echo '<h4>Current Directory: ' . htmlspecialchars($currentDir) . '</h4>';
            echo '<ul>';
            
            $fileList = scandir($currentDir);
            $filteredFiles = array_filter($fileList, function($file) {
                return !in_array($file, ['.', '..']) && is_file(__DIR__ . '/' . $file);
            });
            
            foreach ($filteredFiles as $file) {
                $size = filesize(__DIR__ . '/' . $file);
                $modified = date('Y-m-d H:i:s', filemtime(__DIR__ . '/' . $file));
                echo '<li>' . htmlspecialchars($file) . ' (' . formatBytes($size) . ', modified: ' . $modified . ')</li>';
            }
            
            echo '</ul>';
        } else {
            echo '<p class="error">Cannot access the filesystem</p>';
        }
        
        function formatBytes($bytes, $precision = 2) {
            $units = ['B', 'KB', 'MB', 'GB', 'TB'];
            $bytes = max($bytes, 0);
            $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
            $pow = min($pow, count($units) - 1);
            $bytes /= (1 << (10 * $pow));
            return round($bytes, $precision) . ' ' . $units[$pow];
        }
        ?>
    </div>

    <div class="content">
        <h2>Next Steps</h2>
        <p>Since you can see this page, the PHP development server is working correctly. You can now continue debugging the NexusPress issues.</p>
        
        <p>Try these debugging links:</p>
        <ul>
            <li><a href="/direct-html.php">Direct HTML Output</a> - Simple PHP page with no NexusPress dependencies</li>
            <li><a href="/debug-index.php">Debug Index</a> - Loads NexusPress core step by step with debugging</li>
            <li><a href="/minimal-index.php">Minimal Index</a> - Minimal NexusPress setup</li>
        </ul>
    </div>

    <footer>
        <p>NexusPress - A NexusPress Clone for Educational Purposes</p>
    </footer>
</body>
</html> 