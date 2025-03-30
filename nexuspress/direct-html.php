<?php
// This file is completely standalone and doesn't include any NexusPress files
header("Content-Type: text/html; charset=UTF-8");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direct PHP Output</title>
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
        h1 {
            color: #0073aa;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
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
    </style>
</head>
<body>
    <h1>Direct PHP Output</h1>
    <div class="content">
        <h2>PHP is working!</h2>
        <p>This is a direct PHP output without loading any NexusPress/NexusPress files.</p>
        
        <h3>PHP Information</h3>
        <ul>
            <li>PHP Version: <?php echo phpversion(); ?></li>
            <li>Server Software: <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?></li>
            <li>Request Time: <?php echo date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']); ?></li>
        </ul>

        <h3>Request Details</h3>
        <ul>
            <li>Request URI: <?php echo htmlspecialchars($_SERVER['REQUEST_URI'] ?? 'Unknown'); ?></li>
            <li>Request Method: <?php echo $_SERVER['REQUEST_METHOD'] ?? 'Unknown'; ?></li>
            <li>Query String: <?php echo htmlspecialchars($_SERVER['QUERY_STRING'] ?? 'None'); ?></li>
        </ul>

        <h3>GET Parameters</h3>
        <?php if (empty($_GET)): ?>
            <p>No GET parameters</p>
        <?php else: ?>
            <pre><?php print_r($_GET); ?></pre>
        <?php endif; ?>

        <h3>Server Variables</h3>
        <pre><?php 
        $safeServerVars = array_filter(
            $_SERVER, 
            function($key) {
                return !in_array(strtolower($key), [
                    'http_cookie', 'path', 'document_root', 'context_document_root',
                    'comspec', 'homedrive', 'homepath', 'path_translated',
                    'script_filename', 'systemdrive', 'systemroot', 'temp', 'tmp'
                ]);
            }, 
            ARRAY_FILTER_USE_KEY
        );
        print_r($safeServerVars); 
        ?></pre>
        
        <p class="success">If you can see this page with all the information above, PHP is working correctly and able to serve HTML content.</p>
    </div>
</body>
</html> 