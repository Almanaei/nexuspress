<?php
/**
 * Blocks API: NX_Block_Editor_Context class
 *
 * @package NexusPress
 * @since 5.8.0
 */

/**
 * Contains information about a block editor being rendered.
 *
 * @since 5.8.0
 */
#[AllowDynamicProperties]
final class NX_Block_Editor_Context {
	/**
	 * String that identifies the block editor being rendered. Can be one of:
	 *
	 * - `'core/edit-post'`         - The post editor at `/nx-admin/edit.php`.
	 * - `'core/edit-widgets'`      - The widgets editor at `/nx-admin/widgets.php`.
	 * - `'core/customize-widgets'` - The widgets editor at `/nx-admin/customize.php`.
	 * - `'core/edit-site'`         - The site editor at `/nx-admin/site-editor.php`.
	 *
	 * Defaults to 'core/edit-post'.
	 *
	 * @since 6.0.0
	 *
	 * @var string
	 */
	public $name = 'core/edit-post';

	/**
	 * The post being edited by the block editor. Optional.
	 *
	 * @since 5.8.0
	 *
	 * @var NX_Post|null
	 */
	public $post = null;

	/**
	 * Constructor.
	 *
	 * Populates optional properties for a given block editor context.
	 *
	 * @since 5.8.0
	 *
	 * @param array $settings The list of optional settings to expose in a given context.
	 */
	public function __construct( array $settings = array() ) {
		if ( isset( $settings['name'] ) ) {
			$this->name = $settings['name'];
		}
		if ( isset( $settings['post'] ) ) {
			$this->post = $settings['post'];
		}
	}
}
