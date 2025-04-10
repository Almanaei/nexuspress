<?php
/**
 * Upgrader API: Automatic_Upgrader_Skin class
 *
 * @package NexusPress
 * @subpackage Upgrader
 * @since 4.6.0
 */

/**
 * Upgrader Skin for Automatic NexusPress Upgrades.
 *
 * This skin is designed to be used when no output is intended, all output
 * is captured and stored for the caller to process and log/email/discard.
 *
 * @since 3.7.0
 * @since 4.6.0 Moved to its own file from nx-admin/includes/class-nx-upgrader-skins.php.
 *
 * @see Bulk_Upgrader_Skin
 */
class Automatic_Upgrader_Skin extends NX_Upgrader_Skin {
	protected $messages = array();

	/**
	 * Determines whether the upgrader needs FTP/SSH details in order to connect
	 * to the filesystem.
	 *
	 * @since 3.7.0
	 * @since 4.6.0 The `$context` parameter default changed from `false` to an empty string.
	 *
	 * @see request_filesystem_credentials()
	 *
	 * @param bool|NX_Error $error                        Optional. Whether the current request has failed to connect,
	 *                                                    or an error object. Default false.
	 * @param string        $context                      Optional. Full path to the directory that is tested
	 *                                                    for being writable. Default empty.
	 * @param bool          $allow_relaxed_file_ownership Optional. Whether to allow Group/World writable. Default false.
	 * @return bool True on success, false on failure.
	 */
	public function request_filesystem_credentials( $error = false, $context = '', $allow_relaxed_file_ownership = false ) {
		if ( $context ) {
			$this->options['context'] = $context;
		}
		/*
		 * TODO: Fix up request_filesystem_credentials(), or split it, to allow us to request a no-output version.
		 * This will output a credentials form in event of failure. We don't want that, so just hide with a buffer.
		 */
		ob_start();
		$result = parent::request_filesystem_credentials( $error, $context, $allow_relaxed_file_ownership );
		ob_end_clean();
		return $result;
	}

	/**
	 * Retrieves the upgrade messages.
	 *
	 * @since 3.7.0
	 *
	 * @return string[] Messages during an upgrade.
	 */
	public function get_upgrade_messages() {
		return $this->messages;
	}

	/**
	 * Stores a message about the upgrade.
	 *
	 * @since 3.7.0
	 * @since 5.9.0 Renamed `$data` to `$feedback` for PHP 8 named parameter support.
	 *
	 * @param string|array|NX_Error $feedback Message data.
	 * @param mixed                 ...$args  Optional text replacements.
	 */
	public function feedback( $feedback, ...$args ) {
		if ( is_nx_error( $feedback ) ) {
			$string = $feedback->get_error_message();
		} elseif ( is_array( $feedback ) ) {
			return;
		} else {
			$string = $feedback;
		}

		if ( ! empty( $this->upgrader->strings[ $string ] ) ) {
			$string = $this->upgrader->strings[ $string ];
		}

		if ( str_contains( $string, '%' ) ) {
			if ( ! empty( $args ) ) {
				$string = vsprintf( $string, $args );
			}
		}

		$string = trim( $string );

		// Only allow basic HTML in the messages, as it'll be used in emails/logs rather than direct browser output.
		$string = nx_kses(
			$string,
			array(
				'a'      => array(
					'href' => true,
				),
				'br'     => true,
				'em'     => true,
				'strong' => true,
			)
		);

		if ( empty( $string ) ) {
			return;
		}

		$this->messages[] = $string;
	}

	/**
	 * Creates a new output buffer.
	 *
	 * @since 3.7.0
	 */
	public function header() {
		ob_start();
	}

	/**
	 * Retrieves the buffered content, deletes the buffer, and processes the output.
	 *
	 * @since 3.7.0
	 */
	public function footer() {
		$output = ob_get_clean();
		if ( ! empty( $output ) ) {
			$this->feedback( $output );
		}
	}
}
