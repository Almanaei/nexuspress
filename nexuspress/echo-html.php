<?php
header("Content-Type: text/html");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusPress Debug Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #0073aa;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        pre {
            background: #f9f9f9;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 3px;
            overflow: auto;
        }
        .success {
            color: green;
            font-weight: bold;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>NexusPress Debug Page</h1>
        
        <h2>Basic HTML Test</h2>
        <p>If you can see this page, basic HTML output is working.</p>
        
        <h2>PHP Environment</h2>
        <p>PHP Version: <?php echo phpversion(); ?></p>
        <p>Memory Limit: <?php echo ini_get('memory_limit'); ?></p>
        <p>Output Buffering: <?php echo ini_get('output_buffering') ? 'On' : 'Off'; ?></p>
        <p>Display Errors: <?php echo ini_get('display_errors') ? 'On' : 'Off'; ?></p>
        
        <h2>Server Information</h2>
        <p>Server Software: <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'N/A'; ?></p>
        <p>Request URI: <?php echo $_SERVER['REQUEST_URI'] ?? 'N/A'; ?></p>
        <p>Request Method: <?php echo $_SERVER['REQUEST_METHOD'] ?? 'N/A'; ?></p>
        
        <h2>Config Constants</h2>
        <p>ABSPATH: <?php echo defined('ABSPATH') ? ABSPATH : 'Not defined'; ?></p>
        <p>NXINC: <?php echo defined('NXINC') ? NXINC : 'Not defined'; ?></p>
        <p>NX_SITEURL: <?php echo defined('NX_SITEURL') ? NX_SITEURL : 'Not defined'; ?></p>
        <p>NX_HOME: <?php echo defined('NX_HOME') ? NX_HOME : 'Not defined'; ?></p>
        <p>NX_USE_THEMES: <?php echo defined('NX_USE_THEMES') ? (NX_USE_THEMES ? 'true' : 'false') : 'Not defined'; ?></p>
        
        <h2>NexusPress Core Functions</h2>
        <p>nx() function exists: <?php echo function_exists('nx') ? '<span class="success">Yes</span>' : '<span class="error">No</span>'; ?></p>
        <p>nx_get_themes() function exists: <?php echo function_exists('nx_get_themes') ? '<span class="success">Yes</span>' : '<span class="error">No</span>'; ?></p>
        <p>nx_using_themes() function exists: <?php echo function_exists('nx_using_themes') ? '<span class="success">Yes</span>' : '<span class="error">No</span>'; ?></p>
    </div>
</body>
</html> 