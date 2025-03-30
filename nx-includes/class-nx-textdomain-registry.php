<?php
/**
 * Locale API: NX_Textdomain_Registry class.
 *
 * @package NexusPress
 * @subpackage i18n
 * @since 6.1.0
 */

/**
 * Core class used for registering text domains.
 *
 * @since 6.1.0
 */
class NX_Textdomain_Registry {
    /**
     * List of domains and all their language directory paths.
     *
     * @since 6.1.0
     * @var array
     */
    protected $domains = array();

    /**
     * List of domains and their cached language directory paths.
     *
     * @since 6.1.0
     * @var array
     */
    protected $cached_paths = array();

    /**
     * Constructor.
     *
     * @since 6.1.0
     */
    public function __construct() {
        add_filter( 'upgrader_post_install', array( $this, 'on_upgrader_post_install' ), 10, 3 );
    }

    /**
     * Gets the path(s) to the translation files that should be loaded for the given text domain.
     *
     * @since 6.1.0
     *
     * @param string $domain Text domain.
     * @return string[] Array of language directory paths.
     */
    public function get( $domain ) {
        if ( isset( $this->cached_paths[ $domain ] ) ) {
            return $this->cached_paths[ $domain ];
        }

        $paths = array();

        if ( isset( $this->domains[ $domain ] ) ) {
            $paths = $this->domains[ $domain ];
        }

        $cache_key = 'translation_files_' . md5( $domain );
        $files     = nx_cache_get( $cache_key, 'translation_files' );

        if ( false === $files ) {
            $files = array();

            foreach ( $paths as $path ) {
                $files = array_merge( $files, glob( $path . '/*.mo' ) );
            }

            nx_cache_set( $cache_key, $files, 'translation_files', HOUR_IN_SECONDS );
        }

        $this->cached_paths[ $domain ] = $files;

        return $files;
    }

    /**
     * Determines whether any translations have been registered for the given text domain.
     *
     * @since 6.1.0
     *
     * @param string $domain Text domain.
     * @return bool Whether any translations have been registered.
     */
    public function has( $domain ) {
        return ! empty( $this->domains[ $domain ] );
    }

    /**
     * Registers a language directory for the given text domain.
     *
     * @since 6.1.0
     *
     * @param string $domain Text domain.
     * @param string $path   Language directory path.
     */
    public function register( $domain, $path ) {
        if ( ! isset( $this->domains[ $domain ] ) ) {
            $this->domains[ $domain ] = array();
        }

        $this->domains[ $domain ][] = untrailingslashit( $path );
        unset( $this->cached_paths[ $domain ] );
    }

    /**
     * Unregisters all language directories for the given text domain.
     *
     * @since 6.1.0
     *
     * @param string $domain Text domain.
     */
    public function unregister( $domain ) {
        unset( $this->domains[ $domain ], $this->cached_paths[ $domain ] );
    }

    /**
     * Resets the registry.
     *
     * @since 6.1.0
     */
    public function reset() {
        $this->domains      = array();
        $this->cached_paths = array();
    }

    /**
     * Invalidates the cached paths when upgrading translations.
     *
     * @since 6.1.0
     *
     * @param bool|NX_Error $result     Installation result.
     * @param array         $hook_extra Extra arguments passed to hooked filters.
     * @param array         $data       Installation result data.
     * @return bool|NX_Error The passed-in $result parameter.
     */
    public function on_upgrader_post_install( $result, $hook_extra, $data ) {
        if ( ! is_array( $hook_extra ) || ! isset( $hook_extra['translations'] ) || ! is_array( $hook_extra['translations'] ) ) {
            return $result;
        }

        $translation_types = array_unique( nx_list_pluck( $hook_extra['translations'], 'type' ) );

        if ( ! empty( $translation_types ) ) {
            if ( in_array( 'plugin', $translation_types, true ) ) {
                nx_cache_delete( md5( NX_LANG_DIR . '/plugins/' ), 'translation_files' );
            }
            if ( in_array( 'theme', $translation_types, true ) ) {
                nx_cache_delete( md5( NX_LANG_DIR . '/themes/' ), 'translation_files' );
            }
            if ( in_array( 'core', $translation_types, true ) ) {
                nx_cache_delete( md5( NX_LANG_DIR . '/' ), 'translation_files' );
            }
        }

        return $result;
    }

    /**
     * Gets the list of directories that are searched for translations.
     *
     * @since 6.1.0
     *
     * @return string[] Array of language directory paths.
     */
    public function get_directories() {
        return array(
            NX_LANG_DIR . '/plugins',
            NX_LANG_DIR . '/themes',
            NX_LANG_DIR,
        );
    }
    
    /**
     * Initializes the registry with default text domains.
     *
     * @since 6.1.0
     */
    public function init() {
        // Register NexusPress core text domains
        $this->register('default', NX_LANG_DIR);
        
        // Register plugin text domains directory
        $this->register('plugins', NX_LANG_DIR . '/plugins');
        
        // Register theme text domains directory
        $this->register('themes', NX_LANG_DIR . '/themes');
    }
}