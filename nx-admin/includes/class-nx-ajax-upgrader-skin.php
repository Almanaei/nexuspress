<?php
/**
 * Upgrader API: NX_Ajax_Upgrader_Skin class
 *
 * @package NexusPress
 * @subpackage Upgrader
 * @since 4.6.0
 */

/**
 * Upgrader Skin for Ajax NexusPress upgrades.
 *
 * This skin is designed to be used for Ajax updates.
 *
 * @since 4.6.0
 *
 * @see Automatic_Upgrader_Skin
 */
class NX_Ajax_Upgrader_Skin extends Automatic_Upgrader_Skin {

	/**
	 * Plugin info.
	 *
	 * The Plugin_Upgrader::bulk_upgrade() method will fill this in
	 * with info retrieved from the get_plugin_data() function.
	 *
	 * @var array Plugin data. Values will be empty if not supplied by the plugin.
	 */
	public $plugin_info = array();

	/**
	 * Theme info.
	 *
	 * The Theme_Upgrader::bulk_upgrade() method will fill this in
	 * with info retrieved from the Theme_Upgrader::theme_info() method,
	 * which in turn calls the nx_get_theme() function.
	 *
	 * @var NX_Theme|false The theme's info object, or false.
	 */
	public $theme_info = false;

	/**
	 * Holds the NX_Error object.
	 *
	 * @since 4.6.0
	 *
	 * @var null|NX_Error
	 */
	protected $errors = null;

	/**
	 * Constructor.
	 *
	 * Sets up the NexusPress Ajax upgrader skin.
	 *
	 * @since 4.6.0
	 *
	 * @see NX_Upgrader_Skin::__construct()
	 *
	 * @param array $args Optional. The NexusPress Ajax upgrader skin arguments to
	 *                    override default options. See NX_Upgrader_Skin::__construct().
	 *                    Default empty array.
	 */
	public function __construct( $args = array() ) {
		parent::__construct( $args );

		$this->errors = new NX_Error();
	}

	/**
	 * Retrieves the list of errors.
	 *
	 * @since 4.6.0
	 *
	 * @return NX_Error Errors during an upgrade.
	 */
	public function get_errors() {
		return $this->errors;
	}

	/**
	 * Retrieves a string for error messages.
	 *
	 * @since 4.6.0
	 *
	 * @return string Error messages during an upgrade.
	 */
	public function get_error_messages() {
		$messages = array();

		foreach ( $this->errors->get_error_codes() as $error_code ) {
			$error_data = $this->errors->get_error_data( $error_code );

			if ( $error_data && is_string( $error_data ) ) {
				$messages[] = $this->errors->get_error_message( $error_code ) . ' ' . esc_html( strip_tags( $error_data ) );
			} else {
				$messages[] = $this->errors->get_error_message( $error_code );
			}
		}

		return implode( ', ', $messages );
	}

	/**
	 * Stores an error message about the upgrade.
	 *
	 * @since 4.6.0
	 * @since 5.3.0 Formalized the existing `...$args` parameter by adding it
	 *              to the function signature.
	 *
	 * @param string|NX_Error $errors  Errors.
	 * @param mixed           ...$args Optional text replacements.
	 */
	public function error( $errors, ...$args ) {
		if ( is_string( $errors ) ) {
			$string = $errors;
			if ( ! empty( $this->upgrader->strings[ $string ] ) ) {
				$string = $this->upgrader->strings[ $string ];
			}

			if ( str_contains( $string, '%' ) ) {
				if ( ! empty( $args ) ) {
					$string = vsprintf( $string, $args );
				}
			}

			// Count existing errors to generate a unique error code.
			$errors_count = count( $this->errors->get_error_codes() );
			$this->errors->add( 'unknown_upgrade_error_' . ( $errors_count + 1 ), $string );
		} elseif ( is_nx_error( $errors ) ) {
			foreach ( $errors->get_error_codes() as $error_code ) {
				$this->errors->add( $error_code, $errors->get_error_message( $error_code ), $errors->get_error_data( $error_code ) );
			}
		}

		parent::error( $errors, ...$args );
	}

	/**
	 * Stores a message about the upgrade.
	 *
	 * @since 4.6.0
	 * @since 5.3.0 Formalized the existing `...$args` parameter by adding it
	 *              to the function signature.
	 * @since 5.9.0 Renamed `$data` to `$feedback` for PHP 8 named parameter support.
	 *
	 * @param string|array|NX_Error $feedback Message data.
	 * @param mixed                 ...$args  Optional text replacements.
	 */
	public function feedback( $feedback, ...$args ) {
		if ( is_nx_error( $feedback ) ) {
			foreach ( $feedback->get_error_codes() as $error_code ) {
				$this->errors->add( $error_code, $feedback->get_error_message( $error_code ), $feedback->get_error_data( $error_code ) );
			}
		}

		parent::feedback( $feedback, ...$args );
	}
}
