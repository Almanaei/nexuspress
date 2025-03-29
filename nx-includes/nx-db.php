<?php
/**
 * NexusPress database access abstraction class.
 *
 * This file is deprecated, use 'nx-includes/class-nxdb.php' instead.
 *
 * @deprecated 6.1.0
 * @package NexusPress
 */

if ( function_exists( '_deprecated_file' ) ) {
	// Note: NXINC may not be defined yet, so 'nx-includes' is used here.
	_deprecated_file( basename( __FILE__ ), '6.1.0', 'nx-includes/class-nxdb.php' );
}

/** nxdb class */
require_once __DIR__ . '/class-nxdb.php';
