<?php
/**
 * Dependencies API: NX_Styles class
 *
 * @since 2.6.0
 *
 * @package NexusPress
 * @subpackage Dependencies
 */

/**
 * Core class used to register styles.
 *
 * @since 2.6.0
 *
 * @see NX_Dependencies
 */
class NX_Styles extends NX_Dependencies {
    /**
     * Base URL for styles.
     *
     * Full URL with trailing slash.
     *
     * @since 2.6.0
     * @var string
     */
    public $base_url;

    /**
     * URL of the content directory.
     *
     * @since 2.8.0
     * @var string
     */
    public $content_url;

    /**
     * Default version string for stylesheets.
     *
     * @since 2.6.0
     * @var string
     */
    public $default_version;

    /**
     * The current text direction.
     *
     * @since 2.6.0
     * @var string
     */
    public $text_direction = 'ltr';

    /**
     * Constructor.
     *
     * @since 2.6.0
     */
    public function __construct() {
        /**
         * Fires when the NX_Styles instance is initialized.
         *
         * @since 2.6.0
         *
         * @param NX_Styles $nx_styles NX_Styles instance (passed by reference).
         */
        do_action_ref_array( 'nx_default_styles', array( &$this ) );
    }

    /**
     * @see NX_Dependencies::do_item()
     */
    public function do_item( $handle, $group = false ) {
        // ... existing code ...
    }

    /**
     * @see NX_Dependencies::all_deps()
     */
    public function all_deps( $handles, $recursion = false, $group = false ) {
        // ... existing code ...
    }

    /**
     * @see NX_Dependencies::do_items()
     */
    public function do_items( $handles = false, $group = false ) {
        // ... existing code ...
    }
}