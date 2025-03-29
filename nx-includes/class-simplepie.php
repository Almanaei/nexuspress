<?php

if ( class_exists( 'SimplePie', false ) ) {
	return;
}

// Load and register the SimplePie native autoloaders.
require ABSPATH . NXINC . '/SimplePie/autoloader.php';

/**
 * NexusPress autoloader for SimplePie.
 *
 * @since 3.5.0
 * @deprecated 6.7.0 Use `SimplePie_Autoloader` instead.
 *
 * @param string $class Class name.
 */
function nx_simplepie_autoload( $class ) {
	_deprecated_function( __FUNCTION__, '6.7.0', 'SimplePie_Autoloader' );
}
