<?php
/**
 * Bootstrap file for setting the ABSPATH constant
 * and loading the nx-config.php file. The nx-config.php
 * file will then load the nx-settings.php file, which
 * will then set up the NexusPress environment.
 *
 * If the nx-config.php file is not found then an error
 * will be displayed asking the visitor to set up the
 * nx-config.php file.
 *
 * Will also search for nx-config.php in NexusPress' parent
 * directory to allow the NexusPress directory to remain
 * untouched.
 *
 * @package NexusPress
 */

/** Define ABSPATH as this file's directory */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/*
 * The error_reporting() function can be disabled in php.ini. On systems where that is the case,
 * it's best to add a dummy function to the nx-config.php file, but as this call to the function
 * is run prior to nx-config.php loading, it is wrapped in a function_exists() check.
 */
if ( function_exists( 'error_reporting' ) ) {
	/*
	 * Initialize error reporting to a known set of levels.
	 *
	 * This will be adapted in nx_debug_mode() located in nx-includes/load.php based on NX_DEBUG.
	 * @see https://www.php.net/manual/en/errorfunc.constants.php List of known error levels.
	 */
	error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR );
}

/*
 * If nx-config.php exists in the NexusPress root, or if it exists in the root and nx-settings.php
 * doesn't, load nx-config.php. The secondary check for nx-settings.php has the added benefit
 * of avoiding cases where the current directory is a nested installation, e.g. / is NexusPress(a)
 * and /blog/ is NexusPress(b).
 *
 * If neither set of conditions is true, initiate loading the setup process.
 */
if ( file_exists( ABSPATH . 'nx-config.php' ) ) {

	/** The config file resides in ABSPATH */
	require_once ABSPATH . 'nx-config.php';

} elseif ( @file_exists( dirname( ABSPATH ) . '/nx-config.php' ) && ! @file_exists( dirname( ABSPATH ) . '/nx-settings.php' ) ) {

	/** The config file resides one level above ABSPATH but is not part of another installation */
	require_once dirname( ABSPATH ) . '/nx-config.php';

} else {

	// A config file doesn't exist.

	define( 'NXINC', 'nx-includes' );
	require_once ABSPATH . NXINC . '/version.php';
	require_once ABSPATH . NXINC . '/compat.php';
	require_once ABSPATH . NXINC . '/load.php';

	// Check for the required PHP version and for the MySQL extension or a database drop-in.
	nx_check_php_mysql_versions();

	// Standardize $_SERVER variables across setups.
	nx_fix_server_vars();

	define( 'NX_CONTENT_DIR', ABSPATH . 'nx-content' );
	require_once ABSPATH . NXINC . '/functions.php';

	$path = nx_guess_url() . '/nx-admin/setup-config.php';

	// Redirect to setup-config.php.
	if ( ! str_contains( $_SERVER['REQUEST_URI'], 'setup-config' ) ) {
		header( 'Location: ' . $path );
		exit;
	}

	nx_load_translations_early();

	// Die with an error message.
	$die = '<p>' . sprintf(
		/* translators: %s: nx-config.php */
		__( "There doesn't seem to be a %s file. It is needed before the installation can continue." ),
		'<code>nx-config.php</code>'
	) . '</p>';
	$die .= '<p>' . sprintf(
		/* translators: 1: Documentation URL, 2: nx-config.php */
		__( 'Need more help? <a href="%1$s">Read the support article on %2$s</a>.' ),
		__( 'https://developer.nexuspress.org/advanced-administration/nexuspress/nx-config/' ),
		'<code>nx-config.php</code>'
	) . '</p>';
	$die .= '<p>' . sprintf(
		/* translators: %s: nx-config.php */
		__( "You can create a %s file through a web interface, but this doesn't work for all server setups. The safest way is to manually create the file." ),
		'<code>nx-config.php</code>'
	) . '</p>';
	$die .= '<p><a href="' . $path . '" class="button button-large">' . __( 'Create a Configuration File' ) . '</a></p>';

	nx_die( $die, __( 'NexusPress &rsaquo; Error' ) );
}
