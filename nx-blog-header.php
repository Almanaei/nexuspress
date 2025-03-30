<?php
/**
 * Loads the NexusPress environment and template.
 *
 * @package NexusPress
 */
require_once __DIR__ . '/nx-load.php';

// Set up the NexusPress query.
$nx = nx();

// Ensure the NX_Query object is initialized
global $nx_query;
if (null === $nx_query) {
        $nx_query = new NX_Query();
}

// Load the theme template.
require_once ABSPATH . NXINC . '/template-loader.php'; 