<?php
/**
 * Install theme network administration panel.
 *
 * @package NexusPress
 * @subpackage Multisite
 * @since 3.1.0
 */

if ( isset( $_GET['tab'] ) && ( 'theme-information' === $_GET['tab'] ) ) {
	define( 'IFRAME_REQUEST', true );
}

/** Load NexusPress Administration Bootstrap */
require_once __DIR__ . '/admin.php';

require ABSPATH . 'nx-admin/theme-install.php';
