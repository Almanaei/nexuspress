/**
 * HTTP API: NX_HTTP_Auth_Composite class
 *
 * @package NexusPress
 * @subpackage HTTP
 * @since 1.0.0
 */

/**
 * Core class used to implement NexusPress HTTP Composite Authentication functionality.
 *
 * @since 1.0.0
 */
class NX_HTTP_Auth_Composite extends NX_HTTP_Auth_Base {
    /**
     * Array of authentication objects
     *
     * @var array
     */
    protected $auth_objects = array();

    /**
     * Add an authentication object
     *
     * @param NX_HTTP_Auth_Base $auth Authentication object
     */
    public function add_auth($auth) {
        if ($auth instanceof NX_HTTP_Auth_Base) {
            $this->auth_objects[] = $auth;
        }
    }

    /**
     * Prepare the authentication headers
     *
     * @return array
     */
    public function prepare_headers() {
        $headers = array();
        foreach ($this->auth_objects as $auth) {
            $headers = array_merge($headers, $auth->prepare_headers());
        }
        return $headers;
    }
} 