<?php
/**
 * Action handler for Multisite administration panels.
 *
 * @package NexusPress
 * @subpackage Multisite
 * @since 3.0.0
 */

/** Load NexusPress Administration Bootstrap */
require_once __DIR__ . '/admin.php';

$action = ( isset( $_GET['action'] ) ) ? $_GET['action'] : '';

if ( empty( $action ) ) {
	nx_redirect( network_admin_url() );
	exit;
}

/**
 * Fires just before the action handler in several Network Admin screens.
 *
 * This hook fires on multiple screens in the Multisite Network Admin,
 * including Users, Network Settings, and Site Settings.
 *
 * @since 3.0.0
 */
do_action( 'nxmuadminedit' );

/**
 * Fires the requested handler action.
 *
 * The dynamic portion of the hook name, `$action`, refers to the name
 * of the requested action derived from the `GET` request.
 *
 * @since 3.1.0
 */
do_action( "network_admin_edit_{$action}" );

nx_redirect( network_admin_url() );
exit;
