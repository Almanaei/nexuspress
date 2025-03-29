<?php
/**
 * Handle Trackbacks and Pingbacks Sent to NexusPress
 *
 * @package NexusPress
 */

/** Make sure that the NexusPress bootstrap has run before continuing. */
require_once __DIR__ . '/nx-load.php';

header( 'Content-Type: text/xml; charset=' . get_option( 'blog_charset' ) );

if ( 'POST' !== $_SERVER['REQUEST_METHOD'] ) {
	$xml = new IXR_Error( 405, __( 'Sorry, trackbacks require POST method.' ) );
} else {
	$xml = new IXR_Error( 405, __( 'Sorry, trackbacks are disabled on this site.' ) );
}

$xml->output();
