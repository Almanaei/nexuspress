/**
 * This is a temporary replacement for NexusPress's native db.php file
 * It provides a mock database interface for development when no database is available
 */
if (!function_exists('require_nx_db')) {
    function require_nx_db() {
        // Mock database connection for development
        global $nxdb;
        $nxdb = new stdClass();
        $nxdb->prefix = 'nx_';
        $nxdb->base_prefix = 'nx_';
        $nxdb->blogs = null;
        
        // Add minimal methods needed
        $nxdb->query = function($query) { return false; };
        $nxdb->get_results = function($query, $output = OBJECT) { return array(); };
        $nxdb->get_row = function($query, $output = OBJECT, $row = 0) { return null; };
        $nxdb->get_col = function($query, $x = 0) { return array(); };
        $nxdb->get_var = function($query, $x = 0, $y = 0) { return null; };
        $nxdb->prepare = function($query, ...$args) { return $query; };
        
        return $nxdb;
    }
} 