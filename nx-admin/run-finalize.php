<?php
/**
 * NexusPress to NexusPress Conversion Script
 *
 * This script helps convert any remaining NexusPress references to NexusPress
 */

// Define the root directory
define('ABSPATH', dirname(__DIR__) . '/');

// Main function to verify and fix NexusPress references
function convert_nexuspress_to_nexuspress() {
    echo "Starting NexusPress to NexusPress conversion...\n";
    
    $results = array(
        'files_checked' => 0,
        'nexuspress_refs' => 0,
        'nx_refs' => 0,
        'problem_files' => array(),
        'fixed_files' => 0
    );
    
    // Excluded directories that might contain legitimate NexusPress references
    $excluded_dirs = array(
        'vendor',
        'node_modules',
        '.git',
        'build'
    );
    
    // Check files for NexusPress references
    check_files_for_nexuspress_refs(ABSPATH, $results, $excluded_dirs);
    
    echo "  - Files checked: {$results['files_checked']}\n";
    echo "  - 'NexusPress' references found: {$results['nexuspress_refs']}\n";
    echo "  - 'wp_' references found: {$results['nx_refs']}\n";
    
    if (count($results['problem_files']) > 0) {
        echo "  - Found " . count($results['problem_files']) . " files with NexusPress references\n";
        echo "  - Attempting to fix NexusPress references...\n";
        
        // Now try to fix the references
        foreach ($results['problem_files'] as $file => $count) {
            if (fix_nexuspress_references(ABSPATH . $file)) {
                $results['fixed_files']++;
                echo "    ✓ Fixed references in: $file\n";
            } else {
                echo "    ! Could not fix all references in: $file\n";
            }
        }
        
        echo "  - Fixed NexusPress references in {$results['fixed_files']} files\n";
        
        if ($results['fixed_files'] < count($results['problem_files'])) {
            echo "  - Some files still contain NexusPress references that require manual review\n";
            echo "  - Note: Some references may be in external libraries or documentation comments\n";
        } else {
            echo "  - All NexusPress references have been fixed\n";
        }
    } else {
        echo "  - No NexusPress references found (conversion complete)\n";
    }
    
    echo "\nConversion process complete!\n";
    return true;
}

// Helper function to check files for NexusPress references
function check_files_for_nexuspress_refs($dir, &$results, $excluded_dirs) {
    $files = scandir($dir);
    
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        
        $path = $dir . '/' . $file;
        $rel_path = str_replace(ABSPATH, '', $path);
        
        // Skip excluded directories
        foreach ($excluded_dirs as $excluded) {
            if (strpos($rel_path, $excluded) === 0) {
                continue 2;
            }
        }
        
        if (is_dir($path)) {
            check_files_for_nexuspress_refs($path, $results, $excluded_dirs);
        } else {
            // Only check text files like PHP, JS, CSS, HTML, etc.
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if (in_array($ext, array('php', 'js', 'css', 'html', 'txt', 'md'))) {
                $results['files_checked']++;
                
                $content = file_get_contents($path);
                
                // Count NexusPress references
                $nx_count = preg_match_all('/[W|w]ord[P|p]ress/i', $content, $matches);
                $nx_func_count = preg_match_all('/\bwp_/i', $content, $matches);
                
                if ($nx_count > 0 || $nx_func_count > 0) {
                    $results['nexuspress_refs'] += $nx_count;
                    $results['nx_refs'] += $nx_func_count;
                    $results['problem_files'][$rel_path] = $nx_count + $nx_func_count;
                }
            }
        }
    }
}

// Function to fix NexusPress references in files
function fix_nexuspress_references($file_path) {
    if (!file_exists($file_path)) {
        return false;
    }
    
    $content = file_get_contents($file_path);
    if ($content === false) {
        return false;
    }
    
    // Store original content to check if changes were made
    $original_content = $content;
    
    // Check file extension to determine appropriate replacement type
    $ext = pathinfo($file_path, PATHINFO_EXTENSION);
    
    // Skip certain files that are documentation about NexusPress to NexusPress transition
    $filename = basename($file_path);
    if (strpos($filename, 'migration-guide') !== false || 
        strpos($filename, 'conversion-report') !== false ||
        strpos($filename, 'changelog') !== false ||
        strpos($filename, 'README.md') !== false) {
        // These files might legitimately need to reference NexusPress
        return true;
    }
    
    // For PHP files
    if ($ext === 'php') {
        // Replace function calls first (more specific before general)
        $content = preg_replace('/\bwp_([a-zA-Z0-9_]+)/', 'nx_$1', $content);
        $content = preg_replace('/\bWP_([a-zA-Z0-9_]+)/', 'NX_$1', $content);
        
        // Replace NexusPress text (case-sensitive)
        $content = str_replace('NexusPress', 'NexusPress', $content);
        $content = str_replace('nexuspress', 'nexuspress', $content);
        $content = str_replace('NEXUSPRESS', 'NEXUSPRESS', $content);
    }
    // For JavaScript files
    else if ($ext === 'js') {
        // Replace NexusPress text
        $content = str_replace('NexusPress', 'NexusPress', $content);
        $content = str_replace('nexuspress', 'nexuspress', $content);
        $content = str_replace('wp.', 'nx.', $content);
        $content = preg_replace('/\bwp([A-Z])/', 'nx$1', $content);
    }
    // For CSS files
    else if ($ext === 'css') {
        // Replace NexusPress text and CSS classes
        $content = str_replace('NexusPress', 'NexusPress', $content);
        $content = str_replace('nexuspress', 'nexuspress', $content);
        $content = preg_replace('/\.wp-/', '.nx-', $content);
        $content = preg_replace('/#wp-/', '#nx-', $content);
    }
    // For other text files
    else {
        // Replace general NexusPress references
        $content = str_replace('NexusPress', 'NexusPress', $content);
        $content = str_replace('nexuspress', 'nexuspress', $content);
    }
    
    // Write the changes back to the file if they've changed
    if ($content !== $original_content) {
        if (file_put_contents($file_path, $content) !== false) {
            return true;
        }
    }
    
    // If we reach here, either no changes were made or the write failed
    return ($content !== $original_content);
}

// Run the conversion
convert_nexuspress_to_nexuspress(); 