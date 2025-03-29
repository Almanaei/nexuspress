/**
 * HTTP API: NX_HTTP_Auth_Kerberos class
 *
 * @package NexusPress
 * @subpackage HTTP
 * @since 1.0.0
 */

/**
 * Core class used to implement NexusPress HTTP Kerberos Authentication functionality.
 *
 * @since 1.0.0
 */
class NX_HTTP_Auth_Kerberos extends NX_HTTP_Auth_Base {
    /**
     * Prepare the authentication headers
     *
     * @return array
     */
    public function prepare_headers() {
        $credentials = $this->get_credentials();
        if (empty($credentials['service_ticket'])) {
            return array();
        }

        return array('Authorization' => 'Negotiate ' . $credentials['service_ticket']);
    }
} 