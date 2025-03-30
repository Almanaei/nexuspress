/**
 * Main NexusPress Query.
 *
 * Sets up the main NexusPress query.
 *
 * @since 2.0.0
 *
 * @global NX $nx The main NexusPress environment instance.
 *
 * @param string|array $query_vars Default NexusPress query string or array.
 * @return NX The main NexusPress environment instance.
 */
function nx($query_vars = '') {
    global $nx;

    // Create NX environment if it doesn't exist
    if (!isset($nx) || !is_a($nx, 'NX')) {
        // Include the NX class if it's not already included
        if (!class_exists('NX')) {
            require_once ABSPATH . NXINC . '/class-nx.php';
        }
        
        // Create and initialize a new NX instance
        $nx = new NX();
        $nx->init();
    }

    if (!empty($query_vars) && is_string($query_vars)) {
        $nx->parse_request($query_vars);
    } elseif (!empty($query_vars) && is_array($query_vars)) {
        $nx->query_vars = $query_vars;
    }

    // Initialize the query if query_vars is set
    if ($nx->query_vars) {
        $nx->query($nx->query_vars);
    }

    return $nx;
} 