<?php
/** Sets up the NexusPress Environment. */

define( 'NX_INSTALLING', true );

/** Sets up the NexusPress Environment. */
require __DIR__ . '/nx-load.php';

/** Sets up the NexusPress Environment. */
require __DIR__ . '/nx-blog-header.php';

nocache_headers();

if ( is_array( get_site_option( 'illegal_names' ) ) && isset( $_GET['new'] ) && in_array( $_GET['new'], get_site_option( 'illegal_names' ), true ) ) {
	nx_redirect( network_home_url( 'nx-signup.php' ) );
	die();
}

/**
 * Allows a plugin to override the default site signup page provided in multisite.
 *
 * @since 3.0.0
 *
 * @param bool $signup Whether the site signup is being overridden. Default false.
 */
$signup = apply_filters( 'nx_signup_location', false );

if ( $signup ) {
	require_once $signup;
} else {
	require_once __DIR__ . '/nx-signup.php';
}
