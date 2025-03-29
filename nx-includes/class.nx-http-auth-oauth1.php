/**
 * HTTP API: NX_HTTP_Auth_OAuth1 class
 *
 * @package NexusPress
 * @subpackage HTTP
 * @since 1.0.0
 */

/**
 * Core class used to implement NexusPress HTTP OAuth1 Authentication functionality.
 *
 * @since 1.0.0
 */
class NX_HTTP_Auth_OAuth1 extends NX_HTTP_Auth_Base {
    /**
     * Prepare the authentication headers
     *
     * @return array
     */
    public function prepare_headers() {
        $credentials = $this->get_credentials();
        if (empty($credentials['consumer_key']) || empty($credentials['consumer_secret'])) {
            return array();
        }

        // Generate OAuth1 parameters
        $timestamp = time();
        $nonce = md5(uniqid());
        
        $params = array(
            'oauth_consumer_key' => $credentials['consumer_key'],
            'oauth_nonce' => $nonce,
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => $timestamp,
            'oauth_version' => '1.0'
        );

        if (!empty($credentials['token'])) {
            $params['oauth_token'] = $credentials['token'];
        }

        // Generate signature
        $base_string = $this->build_base_string($credentials['uri'], $params);
        $key = $credentials['consumer_secret'] . '&' . (!empty($credentials['token_secret']) ? $credentials['token_secret'] : '');
        $signature = base64_encode(hash_hmac('sha1', $base_string, $key, true));
        $params['oauth_signature'] = $signature;

        // Build Authorization header
        $auth = 'OAuth ';
        $auth_parts = array();
        foreach ($params as $key => $value) {
            $auth_parts[] = sprintf('%s="%s"', $key, rawurlencode($value));
        }
        $auth .= implode(', ', $auth_parts);

        return array('Authorization' => $auth);
    }

    /**
     * Build the base string for OAuth1 signature
     *
     * @param string $uri Request URI
     * @param array $params OAuth parameters
     * @return string
     */
    protected function build_base_string($uri, $params) {
        ksort($params);
        $parts = array();
        foreach ($params as $key => $value) {
            $parts[] = rawurlencode($key) . '=' . rawurlencode($value);
        }
        return 'GET&' . rawurlencode($uri) . '&' . rawurlencode(implode('&', $parts));
    }
} 