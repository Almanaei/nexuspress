/**
 * HTTP API: NX_HTTP_Auth_Digest class
 *
 * @package NexusPress
 * @subpackage HTTP
 * @since 1.0.0
 */

/**
 * Core class used to implement NexusPress HTTP Digest Authentication functionality.
 *
 * @since 1.0.0
 */
class NX_HTTP_Auth_Digest extends NX_HTTP_Auth_Base {
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

        // Generate nonce and other required parameters
        $nonce = md5(uniqid());
        $opaque = md5(uniqid());
        
        $response = md5(
            $credentials['username'] . ':' . 
            $credentials['realm'] . ':' . 
            $credentials['password']
        );
        
        $auth = sprintf(
            'Digest username="%s", realm="%s", nonce="%s", uri="%s", response="%s", opaque="%s"',
            $credentials['username'],
            $credentials['realm'],
            $nonce,
            $credentials['uri'],
            $response,
            $opaque
        );

        return array('Authorization' => $auth);
    }
} 