<?php
/**
 * HTTP API: NX_HTTP_Proxy class
 *
 * @package NexusPress
 * @subpackage HTTP
 * @since 4.4.0
 */

/**
 * Core class used to implement HTTP API proxy support.
 *
 * There are caveats to proxy support. It requires that defines be made in the nx-config.php file to
 * enable proxy support. There are also a few filters that plugins can hook into for some of the
 * constants.
 *
 * Please note that only BASIC authentication is supported by most transports.
 * cURL MAY support more methods (such as NTLM authentication) depending on your environment.
 *
 * The constants are as follows:
 * <ol>
 * <li>NX_PROXY_HOST - Enable proxy support and host for connecting.</li>
 * <li>NX_PROXY_PORT - Proxy port for connection. No default, must be defined.</li>
 * <li>NX_PROXY_USERNAME - Proxy username, if it requires authentication.</li>
 * <li>NX_PROXY_PASSWORD - Proxy password, if it requires authentication.</li>
 * <li>NX_PROXY_BYPASS_HOSTS - Will prevent the hosts in this list from going through the proxy.
 * You do not need to have localhost and the site host in this list, because they will not be passed
 * through the proxy. The list should be presented in a comma separated list, wildcards using * are supported. Example: *.nexuspress.org</li>
 * </ol>
 *
 * An example can be as seen below.
 *
 *     define('NX_PROXY_HOST', '192.168.84.101');
 *     define('NX_PROXY_PORT', '8080');
 *     define('NX_PROXY_BYPASS_HOSTS', 'localhost, www.example.com, *.nexuspress.org');
 *
 * @link https://core.trac.nexuspress.org/ticket/4011 Proxy support ticket in NexusPress.
 * @link https://core.trac.nexuspress.org/ticket/14636 Allow wildcard domains in NX_PROXY_BYPASS_HOSTS
 *
 * @since 2.8.0
 */
#[AllowDynamicProperties]
class NX_HTTP_Proxy {

	/**
	 * Whether proxy connection should be used.
	 *
	 * Constants which control this behavior:
	 *
	 * - `NX_PROXY_HOST`
	 * - `NX_PROXY_PORT`
	 *
	 * @since 2.8.0
	 *
	 * @return bool
	 */
	public function is_enabled() {
		return defined( 'NX_PROXY_HOST' ) && defined( 'NX_PROXY_PORT' );
	}

	/**
	 * Whether authentication should be used.
	 *
	 * Constants which control this behavior:
	 *
	 * - `NX_PROXY_USERNAME`
	 * - `NX_PROXY_PASSWORD`
	 *
	 * @since 2.8.0
	 *
	 * @return bool
	 */
	public function use_authentication() {
		return defined( 'NX_PROXY_USERNAME' ) && defined( 'NX_PROXY_PASSWORD' );
	}

	/**
	 * Retrieve the host for the proxy server.
	 *
	 * @since 2.8.0
	 *
	 * @return string
	 */
	public function host() {
		if ( defined( 'NX_PROXY_HOST' ) ) {
			return NX_PROXY_HOST;
		}

		return '';
	}

	/**
	 * Retrieve the port for the proxy server.
	 *
	 * @since 2.8.0
	 *
	 * @return string
	 */
	public function port() {
		if ( defined( 'NX_PROXY_PORT' ) ) {
			return NX_PROXY_PORT;
		}

		return '';
	}

	/**
	 * Retrieve the username for proxy authentication.
	 *
	 * @since 2.8.0
	 *
	 * @return string
	 */
	public function username() {
		if ( defined( 'NX_PROXY_USERNAME' ) ) {
			return NX_PROXY_USERNAME;
		}

		return '';
	}

	/**
	 * Retrieve the password for proxy authentication.
	 *
	 * @since 2.8.0
	 *
	 * @return string
	 */
	public function password() {
		if ( defined( 'NX_PROXY_PASSWORD' ) ) {
			return NX_PROXY_PASSWORD;
		}

		return '';
	}

	/**
	 * Retrieve authentication string for proxy authentication.
	 *
	 * @since 2.8.0
	 *
	 * @return string
	 */
	public function authentication() {
		return $this->username() . ':' . $this->password();
	}

	/**
	 * Retrieve header string for proxy authentication.
	 *
	 * @since 2.8.0
	 *
	 * @return string
	 */
	public function authentication_header() {
		return 'Proxy-Authorization: Basic ' . base64_encode( $this->authentication() );
	}

	/**
	 * Determines whether the request should be sent through a proxy.
	 *
	 * We want to keep localhost and the site URL from being sent through the proxy, because
	 * some proxies can not handle this. We also have the constant available for defining other
	 * hosts that won't be sent through the proxy.
	 *
	 * @since 2.8.0
	 *
	 * @param string $uri URL of the request.
	 * @return bool Whether to send the request through the proxy.
	 */
	public function send_through_proxy( $uri ) {
		$check = parse_url( $uri );

		// Malformed URL, can not process, but this could mean ssl, so let through anyway.
		if ( false === $check ) {
			return true;
		}

		$home = parse_url( get_option( 'siteurl' ) );

		/**
		 * Filters whether to preempt sending the request through the proxy.
		 *
		 * Returning false will bypass the proxy; returning true will send
		 * the request through the proxy. Returning null bypasses the filter.
		 *
		 * @since 3.5.0
		 *
		 * @param bool|null $override Whether to send the request through the proxy. Default null.
		 * @param string    $uri      URL of the request.
		 * @param array     $check    Associative array result of parsing the request URL with `parse_url()`.
		 * @param array     $home     Associative array result of parsing the site URL with `parse_url()`.
		 */
		$result = apply_filters( 'pre_http_send_through_proxy', null, $uri, $check, $home );
		if ( ! is_null( $result ) ) {
			return $result;
		}

		if ( 'localhost' === $check['host'] || ( isset( $home['host'] ) && $home['host'] === $check['host'] ) ) {
			return false;
		}

		if ( ! defined( 'NX_PROXY_BYPASS_HOSTS' ) ) {
			return true;
		}

		static $bypass_hosts   = null;
		static $wildcard_regex = array();
		if ( null === $bypass_hosts ) {
			$bypass_hosts = preg_split( '|,\s*|', NX_PROXY_BYPASS_HOSTS );

			if ( str_contains( NX_PROXY_BYPASS_HOSTS, '*' ) ) {
				$wildcard_regex = array();
				foreach ( $bypass_hosts as $host ) {
					$wildcard_regex[] = str_replace( '\*', '.+', preg_quote( $host, '/' ) );
				}
				$wildcard_regex = '/^(' . implode( '|', $wildcard_regex ) . ')$/i';
			}
		}

		if ( ! empty( $wildcard_regex ) ) {
			return ! preg_match( $wildcard_regex, $check['host'] );
		} else {
			return ! in_array( $check['host'], $bypass_hosts, true );
		}
	}
}
