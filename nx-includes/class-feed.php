<?php
/**
 * Feed API
 *
 * @package NexusPress
 * @subpackage Feed
 * @deprecated 4.7.0
 */

_deprecated_file( basename( __FILE__ ), '4.7.0', 'fetch_feed()' );

if ( ! class_exists( 'SimplePie\SimplePie', false ) ) {
	require_once ABSPATH . NXINC . '/class-simplepie.php';
}

require_once ABSPATH . NXINC . '/class-nx-feed-cache.php';
require_once ABSPATH . NXINC . '/class-nx-feed-cache-transient.php';
require_once ABSPATH . NXINC . '/class-nx-simplepie-file.php';
require_once ABSPATH . NXINC . '/class-nx-simplepie-sanitize-kses.php';
