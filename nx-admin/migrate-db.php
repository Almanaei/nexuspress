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

// Connect to databases
$source_db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$nx_db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($source_db->connect_error || $nx_db->connect_error) {
    die('Connection failed: ' . ($source_db->connect_error ?: $nx_db->connect_error));
}

// Set character sets
$source_db->set_charset('utf8mb4');
$nx_db->set_charset('utf8mb4');

// Start timing
$start_time = microtime(true);

echo "Starting data migration...\n\n";

// Tables to migrate
$tables = array(
    'users' => 'nx_users',
    'usermeta' => 'nx_usermeta',
    'posts' => 'nx_posts',
    'postmeta' => 'nx_postmeta',
    'comments' => 'nx_comments',
    'commentmeta' => 'nx_commentmeta',
    'terms' => 'nx_terms',
    'term_taxonomy' => 'nx_term_taxonomy',
    'term_relationships' => 'nx_term_relationships',
    'termmeta' => 'nx_termmeta',
    'options' => 'nx_options',
    'links' => 'nx_links'
);

// Migration results
$results = array();

// Migrate each table
foreach ($tables as $source_table => $nx_table) {
    echo "Migrating $source_table to $nx_table...\n";
    
    // Get row count
    $count = $source_db->query("SELECT COUNT(*) as count FROM $source_table")->fetch_assoc()['count'];
    if ($count === 0) {
        echo "No data to migrate in $source_table\n";
        continue;
    }
    
    // Get table structure
    $source_structure = $source_db->query("DESCRIBE $source_table");
    $nx_structure = $nx_db->query("DESCRIBE $nx_table");
    
    if (!$source_structure || !$nx_structure) {
        $results[$source_table] = "ERROR: Could not get table structure";
        continue;
    }
    
    // Get column names
    $source_columns = array();
    $nx_columns = array();
    
    while ($row = $source_structure->fetch_assoc()) {
        $source_columns[] = $row['Field'];
    }
    
    while ($row = $nx_structure->fetch_assoc()) {
        $nx_columns[] = $row['Field'];
    }
    
    // Find common columns
    $common_columns = array_intersect($source_columns, $nx_columns);
    
    // Prepare insert statement
    $stmt = $nx_db->prepare("INSERT INTO $nx_table (" . implode(', ', $common_columns) . ") VALUES (" . str_repeat('?,', count($common_columns)-1) . "?)");
    
    if (!$stmt) {
        $results[$source_table] = "ERROR: Could not prepare statement: " . $nx_db->error;
        continue;
    }
    
    // Migrate data in chunks
    $chunk_size = 1000;
    $offset = 0;
    $migrated = 0;
    
    while ($offset < $count) {
        $data = $source_db->query("SELECT * FROM $source_table LIMIT $offset, $chunk_size");
        
        if (!$data) {
            $results[$source_table] = "ERROR: Could not fetch data: " . $source_db->error;
            break;
        }
        
        while ($row = $data->fetch_assoc()) {
            $values = array();
            foreach ($common_columns as $column) {
                $values[] = $row[$column];
            }
            
            $types = str_repeat('s', count($values));
            $stmt->bind_param($types, ...$values);
            
            if (!$stmt->execute()) {
                $results[$source_table] = "ERROR: Could not insert data: " . $stmt->error;
                break 2;
            }
            
            $migrated++;
        }
        
        $offset += $chunk_size;
    }
    
    $results[$source_table] = "OK: Migrated $migrated rows";
    echo "Completed migration of $source_table\n";
}

// Print summary
echo "\nMigration Summary:\n";
foreach ($results as $table => $result) {
    echo "$table: $result\n";
}

// Close connections
$source_db->close();
$nx_db->close();

// Calculate and display timing
$end_time = microtime(true);
$duration = round($end_time - $start_time, 2);
echo "\nMigration completed in {$duration} seconds.\n";

// Determine overall status
$has_errors = false;
foreach ($results as $result) {
    if (strpos($result, 'ERROR') !== false) {
        $has_errors = true;
        break;
    }
}

if ($has_errors) {
    echo "\nMigration failed with errors. Please check the summary above.\n";
    exit(1);
} else {
    echo "\nMigration completed successfully!\n";
    exit(0);
} 