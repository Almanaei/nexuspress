<?php
/**
 * Customize API: NX_Widget_Form_Customize_Control class
 *
 * @package NexusPress
 * @subpackage Customize
 * @since 4.4.0
 */

/**
 * Widget Form Customize Control class.
 *
 * @since 3.9.0
 *
 * @see NX_Customize_Control
 */
class NX_Widget_Form_Customize_Control extends NX_Customize_Control {
	/**
	 * Customize control type.
	 *
	 * @since 3.9.0
	 * @var string
	 */
	public $type = 'widget_form';

	/**
	 * Widget ID.
	 *
	 * @since 3.9.0
	 * @var string
	 */
	public $widget_id;

	/**
	 * Widget ID base.
	 *
	 * @since 3.9.0
	 * @var string
	 */
	public $widget_id_base;

	/**
	 * Sidebar ID.
	 *
	 * @since 3.9.0
	 * @var string
	 */
	public $sidebar_id;

	/**
	 * Widget status.
	 *
	 * @since 3.9.0
	 * @var bool True if new, false otherwise. Default false.
	 */
	public $is_new = false;

	/**
	 * Widget width.
	 *
	 * @since 3.9.0
	 * @var int
	 */
	public $width;

	/**
	 * Widget height.
	 *
	 * @since 3.9.0
	 * @var int
	 */
	public $height;

	/**
	 * Widget mode.
	 *
	 * @since 3.9.0
	 * @var bool True if wide, false otherwise. Default false.
	 */
	public $is_wide = false;

	/**
	 * Gather control params for exporting to JavaScript.
	 *
	 * @since 3.9.0
	 *
	 * @global array $nx_registered_widgets
	 */
	public function to_json() {
		global $nx_registered_widgets;

		parent::to_json();
		$exported_properties = array( 'widget_id', 'widget_id_base', 'sidebar_id', 'width', 'height', 'is_wide' );
		foreach ( $exported_properties as $key ) {
			$this->json[ $key ] = $this->$key;
		}

		// Get the widget_control and widget_content.
		require_once ABSPATH . 'nx-admin/includes/widgets.php';

		$widget = $nx_registered_widgets[ $this->widget_id ];
		if ( ! isset( $widget['params'][0] ) ) {
			$widget['params'][0] = array();
		}

		$args = array(
			'widget_id'   => $widget['id'],
			'widget_name' => $widget['name'],
		);

		$args                 = nx_list_widget_controls_dynamic_sidebar(
			array(
				0 => $args,
				1 => $widget['params'][0],
			)
		);
		$widget_control_parts = $this->manager->widgets->get_widget_control_parts( $args );

		$this->json['widget_control'] = $widget_control_parts['control'];
		$this->json['widget_content'] = $widget_control_parts['content'];
	}

	/**
	 * Override render_content to be no-op since content is exported via to_json for deferred embedding.
	 *
	 * @since 3.9.0
	 */
	public function render_content() {}

	/**
	 * Whether the current widget is rendered on the page.
	 *
	 * @since 4.0.0
	 *
	 * @return bool Whether the widget is rendered.
	 */
	public function active_callback() {
		return $this->manager->widgets->is_widget_rendered( $this->widget_id );
	}
}
