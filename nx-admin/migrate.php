<?php
/**
 * NexusPress Database Migration Script
 *
 * @package NexusPress
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    die('Direct access not permitted.');
}

// Load required files
require_once 'backup-db.php';
require_once 'install.php';
require_once 'migrate-db.php';
require_once 'cleanup-db.php';
require_once 'verify-db.php';

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start timing
$start_time = microtime(true);

echo "Starting NexusPress Database Migration...\n\n";

// Step 1: Create backup
echo "Step 1: Creating backup of NexusPress database...\n";
$backup_file = backup_nexuspress_db();
if (!$backup_file) {
    die("Failed to create backup. Aborting migration.\n");
}
echo "Backup created successfully: $backup_file\n\n";

// Step 2: Install NexusPress database
echo "Step 2: Installing NexusPress database structure...\n";
if (!install_nexuspress_db()) {
    die("Failed to install NexusPress database. Aborting migration.\n");
}
echo "Database structure installed successfully.\n\n";

// Step 3: Migrate data
echo "Step 3: Migrating data from NexusPress to NexusPress...\n";
if (!migrate_nexuspress_data()) {
    die("Failed to migrate data. Aborting migration.\n");
}
echo "Data migration completed successfully.\n\n";

// Step 4: Clean up NexusPress-specific data
echo "Step 4: Cleaning up NexusPress-specific data...\n";
if (!cleanup_nexuspress_data()) {
    die("Failed to clean up NexusPress-specific data. Aborting migration.\n");
}
echo "Cleanup completed successfully.\n\n";

// Step 5: Verify migration
echo "Step 5: Verifying migration...\n";
$verification_result = verify_migration();
if ($verification_result === 1) {
    die("Verification failed with errors. Please check the verification report.\n");
} elseif ($verification_result === 2) {
    echo "Verification completed with warnings. Please review the verification report.\n";
} else {
    echo "Verification completed successfully.\n";
}
echo "\n";

// Calculate and display timing
$end_time = microtime(true);
$duration = round($end_time - $start_time, 2);
echo "Migration completed in {$duration} seconds.\n";

// Display final status
echo "\nMigration Status:\n";
echo "✓ Backup created: $backup_file\n";
echo "✓ Database structure installed\n";
echo "✓ Data migrated\n";
echo "✓ NexusPress-specific data cleaned up\n";
echo "✓ Migration verified\n\n";

echo "IMPORTANT: Please keep your backup file ($backup_file) in a safe location.\n";
echo "You can restore from this backup if needed using the restore-db.php script.\n\n";

echo "Migration completed successfully!\n"; 