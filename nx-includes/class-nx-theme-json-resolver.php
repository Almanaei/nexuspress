<?php
/**
 * NX_Theme_JSON_Resolver class
 *
 * @package NexusPress
 * @subpackage Theme
 * @since 5.8.0
 */

/**
 * Class that abstracts the processing of the different data sources
 * for site-level config and offers an API to work with them.
 *
 * @since 5.8.0
 */
class NX_Theme_JSON_Resolver {
    /**
     * Container for data coming from core.
     *
     * @since 5.8.0
     * @var NX_Theme_JSON
     */
    protected static $core = null;

    /**
     * Container for data coming from the theme.
     *
     * @since 5.8.0
     * @var NX_Theme_JSON
     */
    protected static $theme = null;

    /**
     * Whether or not the theme supports theme.json.
     *
     * @since 5.8.0
     * @var bool
     */
    protected static $theme_has_support = null;

    /**
     * Container for data coming from the user.
     *
     * @since 5.8.0
     * @var NX_Theme_JSON
     */
    protected static $user = null;

    /**
     * Processes a file that adheres to the theme.json schema
     * and returns an array with its contents, or a void array if none found.
     *
     * @since 5.8.0
     *
     * @param string $file_path Path to file. Empty if no file.
     * @return array Contents that adhere to the theme.json schema.
     */
    protected static function read_json_file( $file_path ) {
        $config = array();
        if ( $file_path ) {
            $decoded_file = nx_json_file_decode( $file_path, array( 'associative' => true ) );
            if ( is_array( $decoded_file ) ) {
                $config = $decoded_file;
            }
        }
        return $config;
    }

    /**
     * Returns a data structure used in theme.json translation.
     *
     * @since 5.8.0
     *
     * @return array An array of theme.json fields that are translatable and the keys that are translatable
     */
    protected static function get_translation_schema() {
        if ( null === static::$i18n_schema ) {
            $i18n_schema = nx_json_file_decode( __DIR__ . '/theme-i18n.json' );
            static::$i18n_schema = $i18n_schema;
        }
        return static::$i18n_schema;
    }

    /**
     * Returns core data.
     *
     * @since 5.8.0
     *
     * @return NX_Theme_JSON Entity that holds core data.
     */
    public static function get_core_data() {
        if ( null !== static::$core ) {
            return static::$core;
        }

        $config = static::read_json_file( __DIR__ . '/theme.json' );

        $theme_json = apply_filters( 'nx_theme_json_data_default', new NX_Theme_JSON_Data( $config, 'default' ) );
        $config     = $theme_json->get_data();

        /**
         * Backward compatibility for extenders returning a NX_Theme_JSON_Data
         * compatible class that is not a NX_Theme_JSON_Data object.
         */
        if ( $theme_json instanceof NX_Theme_JSON_Data ) {
            $config = $theme_json->get_data();
        }

        static::$core = new NX_Theme_JSON( $config, 'default' );

        return static::$core;
    }

    /**
     * Returns theme data.
     *
     * @since 5.8.0
     *
     * @param array $options Options to pass to get_theme_data.
     * @return NX_Theme_JSON Entity that holds theme data.
     */
    public static function get_theme_data( $options = array() ) {
        if ( null === static::$theme ) {
            $options = nx_parse_args( $options, array( 'with_supports' => true ) );

            $theme_json_data = array();
            if ( $options['with_supports'] ) {
                $theme_json_data = static::get_from_editor_settings();
            }

            $nx_theme        = nx_get_theme();
            $theme_json_file = $nx_theme->get_file_path( 'theme.json' );
            $theme_json_data = static::read_json_file( $theme_json_file );
            $theme_json_data = static::translate( $theme_json_data, $nx_theme->get( 'TextDomain' ) );

            if ( empty( $theme_json_data ) ) {
                $theme_json_data = array( 'version' => NX_Theme_JSON::LATEST_SCHEMA );
            }

            static::$theme = new NX_Theme_JSON( $theme_json_data );
        }

        return static::$theme;
    }

    /**
     * Returns data from editor settings.
     *
     * @since 5.8.0
     *
     * @return array Editor settings data.
     */
    protected static function get_from_editor_settings() {
        $theme_json_data = array();

        $registry = NX_Block_Type_Registry::get_instance();
        $blocks   = $registry->get_all_registered();
        foreach ( $blocks as $block_name => $block_type ) {
            if ( isset( $block_type->supports ) ) {
                $theme_json_data['blocks'][ $block_name ] = array(
                    'supports' => $block_type->supports,
                );
            }
        }

        return $theme_json_data;
    }
} 