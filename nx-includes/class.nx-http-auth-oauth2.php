/**
 * HTTP API: NX_HTTP_Auth_OAuth2 class
 *
 * @package NexusPress
 * @subpackage HTTP
 * @since 1.0.0
 */

/**
 * Core class used to implement NexusPress HTTP OAuth2 Authentication functionality.
 *
 * @since 1.0.0
 */
class NX_HTTP_Auth_OAuth2 extends NX_HTTP_Auth_Base {
    /**
     * Prepare the authentication headers
     *
     * @return array
     */
    public function prepare_headers() {
        $credentials = $this->get_credentials();
        if (empty($credentials['access_token'])) {
            return array();
        }

        return array('Authorization' => 'Bearer ' . $credentials['access_token']);
    }
} 