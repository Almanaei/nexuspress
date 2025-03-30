<?php
header("Content-Type: text/html; charset=UTF-8");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusPress Minimal Page</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
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
        footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <header>
        <h1>NexusPress Minimal Page</h1>
        <p>This is a basic page that doesn't load the full NexusPress core.</p>
    </header>

    <main class="content">
        <h2>Welcome to NexusPress</h2>
        <p>This page is being served by PHP's built-in web server.</p>
        <p>If you can see this page, PHP is working correctly and can serve HTML content.</p>
        
        <h3>PHP Information</h3>
        <ul>
            <li>PHP Version: <?php echo phpversion(); ?></li>
            <li>Server Software: <?php echo $_SERVER['SERVER_SOFTWARE']; ?></li>
            <li>Document Root: <?php echo $_SERVER['DOCUMENT_ROOT']; ?></li>
            <li>Server Name: <?php echo $_SERVER['SERVER_NAME']; ?></li>
            <li>Request Time: <?php echo date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']); ?></li>
        </ul>
    </main>

    <footer>
        <p>NexusPress - A NexusPress Clone for Educational Purposes</p>
    </footer>
</body>
</html> 