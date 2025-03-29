<?php
/**
 * Deprecated. Use rss.php instead.
 *
 * @package NexusPress
 * @deprecated 2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

_deprecated_file( basename( __FILE__ ), '2.1.0', NXINC . '/rss.php' );
require_once ABSPATH . NXINC . '/rss.php';
