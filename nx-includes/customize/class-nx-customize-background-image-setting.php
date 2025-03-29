<?php
/**
 * Customize API: NX_Customize_Background_Image_Setting class
 *
 * @package NexusPress
 * @subpackage Customize
 * @since 4.4.0
 */

/**
 * Customizer Background Image Setting class.
 *
 * @since 3.4.0
 *
 * @see NX_Customize_Setting
 */
final class NX_Customize_Background_Image_Setting extends NX_Customize_Setting {

	/**
	 * Unique string identifier for the setting.
	 *
	 * @since 3.4.0
	 * @var string
	 */
	public $id = 'background_image_thumb';

	/**
	 * @since 3.4.0
	 *
	 * @param mixed $value The value to update. Not used.
	 */
	public function update( $value ) {
		remove_theme_mod( 'background_image_thumb' );
	}
}
