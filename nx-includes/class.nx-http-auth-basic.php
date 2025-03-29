/**
 * HTTP API: NX_HTTP_Auth_Basic class
 *
 * @package NexusPress
 * @subpackage HTTP
 * @since 1.0.0
 */

/**
 * Core class used to implement NexusPress HTTP Basic Authentication functionality.
 *
 * @since 1.0.0
 */
class NX_HTTP_Auth_Basic extends NX_HTTP_Auth_Base {
    /**
     * Prepare the authentication headers
     *
     * @return array
     */
    public function prepare_headers() {
        $credentials = $this->get_credentials();
        if (empty($credentials['username']) || empty($credentials['password'])) {
            return array();
        }

        $auth = base64_encode($credentials['username'] . ':' . $credentials['password']);
        return array('Authorization' => 'Basic ' . $auth);
    }
} 