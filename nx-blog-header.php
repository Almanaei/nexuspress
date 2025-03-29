<?php
/**
 * Loads the NexusPress environment and template.
 *
 * @package NexusPress
 */

if ( ! isset( $nx_did_header ) ) {

	$nx_did_header = true;

	// Load the NexusPress library.
	require_once __DIR__ . '/nx-load.php';

	// Set up the NexusPress query.
	nx();

	// Load the theme template.
	require_once ABSPATH . NXINC . '/template-loader.php';

}
