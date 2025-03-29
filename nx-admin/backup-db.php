<?php
/**
 * NexusPress Database Backup Script
 *
 * This script creates a backup of the NexusPress database before migration.
 *
 * @package NexusPress
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Create a backup of the NexusPress database
 *
 * @return string|false The backup file path on success, false on failure
 */
function backup_nexuspress_db() {
    global $nxdb;
    
    // Create backup directory if it doesn't exist
    $backup_dir = dirname(__DIR__) . '/nx-backups';
    if (!file_exists($backup_dir)) {
        mkdir($backup_dir, 0755, true);
    }
    
    // Generate backup filename with timestamp
    $timestamp = date('Y-m-d_H-i-s');
    $backup_file = $backup_dir . '/nx_backup_' . $timestamp . '.sql';
    
    // Get database credentials
    $db_name = DB_NAME;
    $db_user = DB_USER;
    $db_pass = DB_PASSWORD;
    $db_host = DB_HOST;
    
    // Create backup using mysqldump
    $command = sprintf(
        'mysqldump --user=%s --password=%s --host=%s %s > %s',
        escapeshellarg($db_user),
        escapeshellarg($db_pass),
        escapeshellarg($db_host),
        escapeshellarg($db_name),
        escapeshellarg($backup_file)
    );
    
    exec($command, $output, $return_var);
    
    if ($return_var !== 0) {
        error_log("Failed to create database backup: " . implode("\n", $output));
        return false;
    }
    
    // Verify backup file exists and is not empty
    if (!file_exists($backup_file) || filesize($backup_file) === 0) {
        error_log("Backup file is missing or empty");
        return false;
    }
    
    return $backup_file;
}

// Load configuration
require_once '../nx-config.php';

// Set backup directory
$backup_dir = dirname(__DIR__) . '/nx-backups';
if (!file_exists($backup_dir)) {
    mkdir($backup_dir, 0755, true);
}

// Generate backup filename with timestamp
$timestamp = date('Y-m-d_H-i-s');
$backup_file = $backup_dir . '/nexuspress_backup_' . $timestamp . '.sql';

// Create backup using mysqldump
$command = sprintf(
    'mysqldump --host=%s --user=%s --password=%s nexuspress > %s',
    escapeshellarg(DB_HOST),
    escapeshellarg(DB_USER),
    escapeshellarg(DB_PASSWORD),
    escapeshellarg($backup_file)
);

echo "Creating database backup...\n";
exec($command, $output, $return_var);

if ($return_var === 0) {
    echo "Database backup created successfully at: $backup_file\n";
    
    // Compress the backup file
    $zip_file = $backup_file . '.zip';
    $zip = new ZipArchive();
    
    if ($zip->open($zip_file, ZipArchive::CREATE) === TRUE) {
        $zip->addFile($backup_file, basename($backup_file));
        $zip->close();
        echo "Backup compressed successfully at: $zip_file\n";
        
        // Remove the uncompressed SQL file
        unlink($backup_file);
        echo "Uncompressed backup file removed\n";
    } else {
        echo "Failed to compress backup file\n";
    }
} else {
    echo "Failed to create database backup\n";
    echo "Error output:\n";
    print_r($output);
}

// Create a backup of the configuration file
$config_backup = $backup_dir . '/nx-config_backup_' . $timestamp . '.php';
copy(dirname(__DIR__) . '/nx-config.php', $config_backup);
echo "Configuration file backup created at: $config_backup\n";

// Create a backup of the .htaccess file if it exists
$htaccess_file = dirname(__DIR__) . '/.htaccess';
if (file_exists($htaccess_file)) {
    $htaccess_backup = $backup_dir . '/htaccess_backup_' . $timestamp . '.txt';
    copy($htaccess_file, $htaccess_backup);
    echo ".htaccess file backup created at: $htaccess_backup\n";
}

// Create a backup of the nx-content directory if it exists
$nx_content_dir = dirname(__DIR__) . '/nx-content';
if (file_exists($nx_content_dir)) {
    $content_backup = $backup_dir . '/nx-content_backup_' . $timestamp . '.zip';
    $zip = new ZipArchive();
    
    if ($zip->open($content_backup, ZipArchive::CREATE) === TRUE) {
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($nx_content_dir),
            RecursiveIteratorIterator::LEAVES_ONLY
        );
        
        foreach ($files as $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($nx_content_dir) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
        
        $zip->close();
        echo "nx-content directory backup created at: $content_backup\n";
    } else {
        echo "Failed to create nx-content directory backup\n";
    }
}

// Create a backup log file
$log_file = $backup_dir . '/backup_log_' . $timestamp . '.txt';
$log_content = "Backup completed at: " . date('Y-m-d H:i:s') . "\n";
$log_content .= "Backup files created:\n";
$log_content .= "- Database backup: " . basename($zip_file) . "\n";
$log_content .= "- Configuration backup: " . basename($config_backup) . "\n";
if (file_exists($htaccess_file)) {
    $log_content .= "- .htaccess backup: " . basename($htaccess_backup) . "\n";
}
if (file_exists($nx_content_dir)) {
    $log_content .= "- nx-content backup: " . basename($content_backup) . "\n";
}
file_put_contents($log_file, $log_content);
echo "Backup log created at: $log_file\n";

echo "\nBackup process completed successfully!\n"; 