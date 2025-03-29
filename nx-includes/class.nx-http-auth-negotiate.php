/**
 * HTTP API: NX_HTTP_Auth_Negotiate class
 *
 * @package NexusPress
 * @subpackage HTTP
 * @since 1.0.0
 */

/**
 * Core class used to implement NexusPress HTTP Negotiate Authentication functionality.
 *
 * @since 1.0.0
 */
class NX_HTTP_Auth_Negotiate extends NX_HTTP_Auth_Base {
    /**
     * Prepare the authentication headers
     *
     * @return array
     */
    public function prepare_headers() {
        $credentials = $this->get_credentials();
        if (empty($credentials['token'])) {
            return array();
        }

        return array('Authorization' => 'Negotiate ' . $credentials['token']);
    }
} 