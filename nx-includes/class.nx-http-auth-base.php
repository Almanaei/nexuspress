/**
 * HTTP API: NX_HTTP_Auth_Base class
 *
 * @package NexusPress
 * @subpackage HTTP
 * @since 1.0.0
 */

/**
 * Core class used to implement base NexusPress HTTP Authentication functionality.
 *
 * @since 1.0.0
 */
abstract class NX_HTTP_Auth_Base {
    /**
     * Authentication credentials
     *
     * @var array
     */
    protected $credentials = array();

    /**
     * Constructor
     *
     * @param array $credentials Authentication credentials
     */
    public function __construct($credentials = array()) {
        $this->credentials = $credentials;
    }

    /**
     * Get the authentication credentials
     *
     * @return array
     */
    public function get_credentials() {
        return $this->credentials;
    }

    /**
     * Set the authentication credentials
     *
     * @param array $credentials Authentication credentials
     */
    public function set_credentials($credentials) {
        $this->credentials = $credentials;
    }

    /**
     * Prepare the authentication headers
     *
     * @return array
     */
    abstract public function prepare_headers();
} 