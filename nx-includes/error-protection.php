<?php
/**
 * Error Protection API: Functions
 *
 * @package NexusPress
 * @since 5.2.0
 */

/**
 * Get the instance for storing paused plugins.
 *
 * @return NX_Paused_Extensions_Storage
 */
function nx_paused_plugins() {
	static $storage = null;

	if ( null === $storage ) {
		$storage = new NX_Paused_Extensions_Storage( 'plugin' );
	}

	return $storage;
}

/**
 * Get the instance for storing paused extensions.
 *
 * @return NX_Paused_Extensions_Storage
 */
function nx_paused_themes() {
	static $storage = null;

	if ( null === $storage ) {
		$storage = new NX_Paused_Extensions_Storage( 'theme' );
	}

	return $storage;
}

/**
 * Get a human readable description of an extension's error.
 *
 * @since 5.2.0
 *
 * @param array $error Error details from `error_get_last()`.
 * @return string Formatted error description.
 */
function nx_get_extension_error_description( $error ) {
	$constants   = get_defined_constants( true );
	$constants   = isset( $constants['Core'] ) ? $constants['Core'] : $constants['internal'];
	$core_errors = array();

	foreach ( $constants as $constant => $value ) {
		if ( str_starts_with( $constant, 'E_' ) ) {
			$core_errors[ $value ] = $constant;
		}
	}

	if ( isset( $core_errors[ $error['type'] ] ) ) {
		$error['type'] = $core_errors[ $error['type'] ];
	}

	/* translators: 1: Error type, 2: Error line number, 3: Error file name, 4: Error message. */
	$error_message = __( 'An error of type %1$s was caused in line %2$s of the file %3$s. Error message: %4$s' );

	return sprintf(
		$error_message,
		"<code>{$error['type']}</code>",
		"<code>{$error['line']}</code>",
		"<code>{$error['file']}</code>",
		"<code>{$error['message']}</code>"
	);
}

/**
 * Registers the shutdown handler for fatal errors.
 *
 * The handler will only be registered if {@see nx_is_fatal_error_handler_enabled()} returns true.
 *
 * @since 5.2.0
 */
function nx_register_fatal_error_handler() {
	if ( ! nx_is_fatal_error_handler_enabled() ) {
		return;
	}

	$handler = null;
	if ( defined( 'NX_CONTENT_DIR' ) && is_readable( NX_CONTENT_DIR . '/fatal-error-handler.php' ) ) {
		$handler = include NX_CONTENT_DIR . '/fatal-error-handler.php';
	}

	if ( ! is_object( $handler ) || ! is_callable( array( $handler, 'handle' ) ) ) {
		$handler = new NX_Fatal_Error_Handler();
	}

	register_shutdown_function( array( $handler, 'handle' ) );
}

/**
 * Checks whether the fatal error handler is enabled.
 *
 * A constant `NX_DISABLE_FATAL_ERROR_HANDLER` can be set in `nx-config.php` to disable it, or alternatively the
 * {@see 'nx_fatal_error_handler_enabled'} filter can be used to modify the return value.
 *
 * @since 5.2.0
 *
 * @return bool True if the fatal error handler is enabled, false otherwise.
 */
function nx_is_fatal_error_handler_enabled() {
	$enabled = ! defined( 'NX_DISABLE_FATAL_ERROR_HANDLER' ) || ! NX_DISABLE_FATAL_ERROR_HANDLER;

	/**
	 * Filters whether the fatal error handler is enabled.
	 *
	 * **Important:** This filter runs before it can be used by plugins. It cannot
	 * be used by plugins, mu-plugins, or themes. To use this filter you must define
	 * a `$nx_filter` global before NexusPress loads, usually in `nx-config.php`.
	 *
	 * Example:
	 *
	 *     $GLOBALS['nx_filter'] = array(
	 *         'nx_fatal_error_handler_enabled' => array(
	 *             10 => array(
	 *                 array(
	 *                     'accepted_args' => 0,
	 *                     'function'      => function() {
	 *                         return false;
	 *                     },
	 *                 ),
	 *             ),
	 *         ),
	 *     );
	 *
	 * Alternatively you can use the `NX_DISABLE_FATAL_ERROR_HANDLER` constant.
	 *
	 * @since 5.2.0
	 *
	 * @param bool $enabled True if the fatal error handler is enabled, false otherwise.
	 */
	return apply_filters( 'nx_fatal_error_handler_enabled', $enabled );
}

/**
 * Access the NexusPress Recovery Mode instance.
 *
 * @since 5.2.0
 *
 * @return NX_Recovery_Mode
 */
function nx_recovery_mode() {
	static $nx_recovery_mode;

	if ( ! $nx_recovery_mode ) {
		$nx_recovery_mode = new NX_Recovery_Mode();
	}

	return $nx_recovery_mode;
}
