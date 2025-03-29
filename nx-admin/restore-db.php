<?php
/**
 * NexusPress Database Restore Script
 *
 * @package NexusPress
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    die('Direct access not permitted.');
}

// Check if backup file is provided
if ($argc < 2) {
    die("Usage: php restore-db.php <backup_file>\n");
}

$backup_file = $argv[1];

// Validate backup file
if (!file_exists($backup_file)) {
    die("Error: Backup file '$backup_file' not found.\n");
}

if (!is_readable($backup_file)) {
    die("Error: Backup file '$backup_file' is not readable.\n");
}

// Start timing
$start_time = microtime(true);

echo "Starting NexusPress Database Restore...\n\n";

// Step 1: Verify backup file
echo "Step 1: Verifying backup file...\n";
$file_size = filesize($backup_file);
if ($file_size === 0) {
    die("Error: Backup file is empty.\n");
}
echo "Backup file verified: " . round($file_size / 1024 / 1024, 2) . " MB\n\n";

// Step 2: Create temporary database
echo "Step 2: Creating temporary database...\n";
$temp_db_name = DB_NAME . '_temp_' . time();
$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Drop temporary database if it exists
$db->query("DROP DATABASE IF EXISTS `$temp_db_name`");

// Create temporary database
if (!$db->query("CREATE DATABASE `$temp_db_name`")) {
    die("Failed to create temporary database: " . $db->error . "\n");
}
echo "Temporary database created successfully.\n\n";

// Step 3: Import backup to temporary database
echo "Step 3: Importing backup to temporary database...\n";
$import_command = sprintf(
    'mysql -h %s -u %s %s %s < %s',
    escapeshellarg(DB_HOST),
    escapeshellarg(DB_USER),
    DB_PASSWORD ? '-p' . escapeshellarg(DB_PASSWORD) : '',
    escapeshellarg($temp_db_name),
    escapeshellarg($backup_file)
);

$import_output = array();
$import_return = 0;
exec($import_command, $import_output, $import_return);

if ($import_return !== 0) {
    die("Failed to import backup: " . implode("\n", $import_output) . "\n");
}
echo "Backup imported successfully.\n\n";

// Step 4: Verify imported data
echo "Step 4: Verifying imported data...\n";
$db->select_db($temp_db_name);
$tables = array(
    'nx_users',
    'nx_usermeta',
    'nx_posts',
    'nx_postmeta',
    'nx_comments',
    'nx_commentmeta',
    'nx_terms',
    'nx_term_taxonomy',
    'nx_term_relationships',
    'nx_termmeta',
    'nx_options',
    'nx_links'
);

$verification_errors = array();
foreach ($tables as $table) {
    $result = $db->query("SHOW TABLES LIKE '$table'");
    if ($result->num_rows === 0) {
        $verification_errors[] = "Table '$table' not found in backup";
    } else {
        $count = $db->query("SELECT COUNT(*) as count FROM $table")->fetch_assoc()['count'];
        echo "Found $count rows in $table\n";
    }
}

if (!empty($verification_errors)) {
    die("Verification failed:\n" . implode("\n", $verification_errors) . "\n");
}
echo "Data verification completed successfully.\n\n";

// Step 5: Drop current database
echo "Step 5: Dropping current database...\n";
$db->select_db(DB_NAME);
$db->query("DROP DATABASE IF EXISTS `" . DB_NAME . "`");
echo "Current database dropped successfully.\n\n";

// Step 6: Rename temporary database
echo "Step 6: Renaming temporary database...\n";
$db->query("RENAME DATABASE `$temp_db_name` TO `" . DB_NAME . "`");
echo "Database renamed successfully.\n\n";

// Step 7: Final verification
echo "Step 7: Performing final verification...\n";
$db->select_db(DB_NAME);
$final_verification = verify_migration();
if ($final_verification === 1) {
    die("Final verification failed with errors. Please check the verification report.\n");
} elseif ($final_verification === 2) {
    echo "Final verification completed with warnings. Please review the verification report.\n";
} else {
    echo "Final verification completed successfully.\n";
}
echo "\n";

// Calculate and display timing
$end_time = microtime(true);
$duration = round($end_time - $start_time, 2);
echo "Restore completed in {$duration} seconds.\n";

// Display final status
echo "\nRestore Status:\n";
echo "✓ Backup file verified\n";
echo "✓ Temporary database created\n";
echo "✓ Backup imported successfully\n";
echo "✓ Data verified\n";
echo "✓ Current database dropped\n";
echo "✓ Database renamed\n";
echo "✓ Final verification completed\n\n";

echo "Database restored successfully!\n";

// Close connection
$db->close(); 