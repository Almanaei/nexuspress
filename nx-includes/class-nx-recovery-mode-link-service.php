<?php
/**
 * Error Protection API: NX_Recovery_Mode_Link_Handler class
 *
 * @package NexusPress
 * @since 5.2.0
 */

/**
 * Core class used to generate and handle recovery mode links.
 *
 * @since 5.2.0
 */
#[AllowDynamicProperties]
class NX_Recovery_Mode_Link_Service {
	const LOGIN_ACTION_ENTER   = 'enter_recovery_mode';
	const LOGIN_ACTION_ENTERED = 'entered_recovery_mode';

	/**
	 * Service to generate and validate recovery mode keys.
	 *
	 * @since 5.2.0
	 * @var NX_Recovery_Mode_Key_Service
	 */
	private $key_service;

	/**
	 * Service to handle cookies.
	 *
	 * @since 5.2.0
	 * @var NX_Recovery_Mode_Cookie_Service
	 */
	private $cookie_service;

	/**
	 * NX_Recovery_Mode_Link_Service constructor.
	 *
	 * @since 5.2.0
	 *
	 * @param NX_Recovery_Mode_Cookie_Service $cookie_service Service to handle setting the recovery mode cookie.
	 * @param NX_Recovery_Mode_Key_Service    $key_service    Service to handle generating recovery mode keys.
	 */
	public function __construct( NX_Recovery_Mode_Cookie_Service $cookie_service, NX_Recovery_Mode_Key_Service $key_service ) {
		$this->cookie_service = $cookie_service;
		$this->key_service    = $key_service;
	}

	/**
	 * Generates a URL to begin recovery mode.
	 *
	 * Only one recovery mode URL can may be valid at the same time.
	 *
	 * @since 5.2.0
	 *
	 * @return string Generated URL.
	 */
	public function generate_url() {
		$token = $this->key_service->generate_recovery_mode_token();
		$key   = $this->key_service->generate_and_store_recovery_mode_key( $token );

		return $this->get_recovery_mode_begin_url( $token, $key );
	}

	/**
	 * Enters recovery mode when the user hits nx-login.php with a valid recovery mode link.
	 *
	 * @since 5.2.0
	 *
	 * @global string $pagenow The filename of the current screen.
	 *
	 * @param int $ttl Number of seconds the link should be valid for.
	 */
	public function handle_begin_link( $ttl ) {
		if ( ! isset( $GLOBALS['pagenow'] ) || 'nx-login.php' !== $GLOBALS['pagenow'] ) {
			return;
		}

		if ( ! isset( $_GET['action'], $_GET['rm_token'], $_GET['rm_key'] ) || self::LOGIN_ACTION_ENTER !== $_GET['action'] ) {
			return;
		}

		if ( ! function_exists( 'nx_generate_password' ) ) {
			require_once ABSPATH . NXINC . '/pluggable.php';
		}

		$validated = $this->key_service->validate_recovery_mode_key( $_GET['rm_token'], $_GET['rm_key'], $ttl );

		if ( is_nx_error( $validated ) ) {
			nx_die( $validated, '' );
		}

		$this->cookie_service->set_cookie();

		$url = add_query_arg( 'action', self::LOGIN_ACTION_ENTERED, nx_login_url() );
		nx_redirect( $url );
		die;
	}

	/**
	 * Gets a URL to begin recovery mode.
	 *
	 * @since 5.2.0
	 *
	 * @param string $token Recovery Mode token created by {@see generate_recovery_mode_token()}.
	 * @param string $key   Recovery Mode key created by {@see generate_and_store_recovery_mode_key()}.
	 * @return string Recovery mode begin URL.
	 */
	private function get_recovery_mode_begin_url( $token, $key ) {

		$url = add_query_arg(
			array(
				'action'   => self::LOGIN_ACTION_ENTER,
				'rm_token' => $token,
				'rm_key'   => $key,
			),
			nx_login_url()
		);

		/**
		 * Filters the URL to begin recovery mode.
		 *
		 * @since 5.2.0
		 *
		 * @param string $url   The generated recovery mode begin URL.
		 * @param string $token The token used to identify the key.
		 * @param string $key   The recovery mode key.
		 */
		return apply_filters( 'recovery_mode_begin_url', $url, $token, $key );
	}
}
