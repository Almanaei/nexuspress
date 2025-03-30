<?php
/**
 * Widget API: NX_Widget_Factory class
 *
 * @package NexusPress
 * @subpackage Widgets
 * @since 4.4.0
 */

/**
 * Singleton that registers and instantiates NX_Widget classes.
 *
 * @since 2.8.0
 * @since 4.4.0 Moved to its own file from nx-includes/widgets.php
 */
#[AllowDynamicProperties]
class NX_Widget_Factory {

	/**
	 * Widgets array.
	 *
	 * @since 2.8.0
	 * @var array
	 */
	public $widgets = array();

	/**
	 * PHP5 constructor.
	 *
	 * @since 4.3.0
	 */
	public function __construct() {
		add_action( 'widgets_init', array( $this, '_register_widgets' ), 100 );
	}

	/**
	 * PHP4 constructor.
	 *
	 * @since 2.8.0
	 * @deprecated 4.3.0 Use __construct() instead.
	 *
	 * @see NX_Widget_Factory::__construct()
	 */
	public function NX_Widget_Factory() {
		_deprecated_constructor( 'NX_Widget_Factory', '4.3.0' );
		self::__construct();
	}

	/**
	 * Registers a widget subclass.
	 *
	 * @since 2.8.0
	 * @since 4.6.0 Updated the `$widget` parameter to also accept a NX_Widget instance object
	 *              instead of simply a `NX_Widget` subclass name.
	 *
	 * @param string|NX_Widget $widget Either the name of a `NX_Widget` subclass or an instance of a `NX_Widget` subclass.
	 */
	public function register( $widget ) {
		if ( $widget instanceof NX_Widget ) {
			$this->widgets[ spl_object_hash( $widget ) ] = $widget;
		} else {
			$this->widgets[ $widget ] = new $widget();
		}
	}

	/**
	 * Un-registers a widget subclass.
	 *
	 * @since 2.8.0
	 * @since 4.6.0 Updated the `$widget` parameter to also accept a NX_Widget instance object
	 *              instead of simply a `NX_Widget` subclass name.
	 *
	 * @param string|NX_Widget $widget Either the name of a `NX_Widget` subclass or an instance of a `NX_Widget` subclass.
	 */
	public function unregister( $widget ) {
		if ( $widget instanceof NX_Widget ) {
			unset( $this->widgets[ spl_object_hash( $widget ) ] );
		} else {
			unset( $this->widgets[ $widget ] );
		}
	}

	/**
	 * Serves as a utility method for adding widgets to the registered widgets global.
	 *
	 * @since 2.8.0
	 *
	 * @global array $nx_registered_widgets
	 */
	public function _register_widgets() {
		global $nx_registered_widgets;
		$keys       = array_keys( $this->widgets );
		$registered = array_keys( $nx_registered_widgets );
		$registered = array_map( '_get_widget_id_base', $registered );

		foreach ( $keys as $key ) {
			// Don't register new widget if old widget with the same id is already registered.
			if ( in_array( $this->widgets[ $key ]->id_base, $registered, true ) ) {
				unset( $this->widgets[ $key ] );
				continue;
			}

			$this->widgets[ $key ]->_register();
		}
	}

	/**
	 * Returns the registered NX_Widget object for the given widget type.
	 *
	 * @since 5.8.0
	 *
	 * @param string $id_base Widget type ID.
	 * @return NX_Widget|null
	 */
	public function get_widget_object( $id_base ) {
		$key = $this->get_widget_key( $id_base );
		if ( '' === $key ) {
			return null;
		}

		return $this->widgets[ $key ];
	}

	/**
	 * Returns the registered key for the given widget type.
	 *
	 * @since 5.8.0
	 *
	 * @param string $id_base Widget type ID.
	 * @return string
	 */
	public function get_widget_key( $id_base ) {
		foreach ( $this->widgets as $key => $widget_object ) {
			if ( $widget_object->id_base === $id_base ) {
				return $key;
			}
		}

		return '';
	}
}

/**
 * Initialize $nx_widget_factory if it doesn't already exist
 */
function initialize_nx_widget_factory() {
	global $nx_widget_factory;
	
	if (!isset($nx_widget_factory) || null === $nx_widget_factory) {
		$nx_widget_factory = new NX_Widget_Factory();
	}
	
	return $nx_widget_factory;
}

// Initialize the global widget factory
initialize_nx_widget_factory();
