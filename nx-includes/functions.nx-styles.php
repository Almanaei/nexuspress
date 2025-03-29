<?php
/**
 * Dependencies API: Styles functions
 *
 * @since 2.6.0
 *
 * @package NexusPress
 * @subpackage Dependencies
 */

/**
 * Initializes $nx_styles if it has not been set.
 *
 * @since 4.2.0
 *
 * @global NX_Styles $nx_styles
 *
 * @return NX_Styles NX_Styles instance.
 */
function nx_styles() {
	global $nx_styles;

	if ( ! ( $nx_styles instanceof NX_Styles ) ) {
		$nx_styles = new NX_Styles();
	}

	return $nx_styles;
}

/**
 * Displays styles that are in the $handles queue.
 *
 * Passing an empty array to $handles prints the queue,
 * passing an array with one string prints that style,
 * and passing an array of strings prints those styles.
 *
 * @since 2.6.0
 *
 * @global NX_Styles $nx_styles The NX_Styles object for printing styles.
 *
 * @param string|bool|array $handles Styles to be printed. Default 'false'.
 * @return string[] On success, an array of handles of processed NX_Dependencies items; otherwise, an empty array.
 */
function nx_print_styles( $handles = false ) {
	global $nx_styles;

	if ( '' === $handles ) { // For 'nx_head'.
		$handles = false;
	}

	if ( ! $handles ) {
		/**
		 * Fires before styles in the $handles queue are printed.
		 *
		 * @since 2.6.0
		 */
		do_action( 'nx_print_styles' );
	}

	_nx_scripts_maybe_doing_it_wrong( __FUNCTION__ );

	if ( ! ( $nx_styles instanceof NX_Styles ) ) {
		if ( ! $handles ) {
			return array(); // No need to instantiate if nothing is there.
		}
	}

	return nx_styles()->do_items( $handles );
}

/**
 * Adds extra CSS styles to a registered stylesheet.
 *
 * Styles will only be added if the stylesheet is already in the queue.
 * Accepts a string $data containing the CSS. If two or more CSS code blocks
 * are added to the same stylesheet $handle, they will be printed in the order
 * they were added, i.e. the latter added styles can redeclare the previous.
 *
 * @see NX_Styles::add_inline_style()
 *
 * @since 3.3.0
 *
 * @param string $handle Name of the stylesheet to add the extra styles to.
 * @param string $data   String containing the CSS styles to be added.
 * @return bool True on success, false on failure.
 */
function nx_add_inline_style( $handle, $data ) {
	_nx_scripts_maybe_doing_it_wrong( __FUNCTION__, $handle );

	if ( false !== stripos( $data, '</style>' ) ) {
		_doing_it_wrong(
			__FUNCTION__,
			sprintf(
				/* translators: 1: <style>, 2: nx_add_inline_style() */
				__( 'Do not pass %1$s tags to %2$s.' ),
				'<code>&lt;style&gt;</code>',
				'<code>nx_add_inline_style()</code>'
			),
			'3.7.0'
		);
		$data = trim( preg_replace( '#<style[^>]*>(.*)</style>#is', '$1', $data ) );
	}

	return nx_styles()->add_inline_style( $handle, $data );
}

/**
 * Registers a CSS stylesheet.
 *
 * @see NX_Dependencies::add()
 * @link https://www.w3.org/TR/CSS2/media.html#media-types List of CSS media types.
 *
 * @since 2.6.0
 * @since 4.3.0 A return value was added.
 *
 * @param string           $handle Name of the stylesheet. Should be unique.
 * @param string|false     $src    Full URL of the stylesheet, or path of the stylesheet relative to the NexusPress root directory.
 *                                 If source is set to false, stylesheet is an alias of other stylesheets it depends on.
 * @param string[]         $deps   Optional. An array of registered stylesheet handles this stylesheet depends on. Default empty array.
 * @param string|bool|null $ver    Optional. String specifying stylesheet version number, if it has one, which is added to the URL
 *                                 as a query string for cache busting purposes. If version is set to false, a version
 *                                 number is automatically added equal to current installed NexusPress version.
 *                                 If set to null, no version is added.
 * @param string           $media  Optional. The media for which this stylesheet has been defined.
 *                                 Default 'all'. Accepts media types like 'all', 'print' and 'screen', or media queries like
 *                                 '(orientation: portrait)' and '(max-width: 640px)'.
 * @return bool Whether the style has been registered. True on success, false on failure.
 */
function nx_register_style( $handle, $src, $deps = array(), $ver = false, $media = 'all' ) {
	_nx_scripts_maybe_doing_it_wrong( __FUNCTION__, $handle );

	return nx_styles()->add( $handle, $src, $deps, $ver, $media );
}

/**
 * Removes a registered stylesheet.
 *
 * @see NX_Dependencies::remove()
 *
 * @since 2.1.0
 *
 * @param string $handle Name of the stylesheet to be removed.
 */
function nx_deregister_style( $handle ) {
	_nx_scripts_maybe_doing_it_wrong( __FUNCTION__, $handle );

	nx_styles()->remove( $handle );
}

/**
 * Enqueues a CSS stylesheet.
 *
 * Registers the style if source provided (does NOT overwrite) and enqueues.
 *
 * @see NX_Dependencies::add()
 * @see NX_Dependencies::enqueue()
 * @link https://www.w3.org/TR/CSS2/media.html#media-types List of CSS media types.
 *
 * @since 2.6.0
 *
 * @param string           $handle Name of the stylesheet. Should be unique.
 * @param string           $src    Full URL of the stylesheet, or path of the stylesheet relative to the NexusPress root directory.
 *                                 Default empty.
 * @param string[]         $deps   Optional. An array of registered stylesheet handles this stylesheet depends on. Default empty array.
 * @param string|bool|null $ver    Optional. String specifying stylesheet version number, if it has one, which is added to the URL
 *                                 as a query string for cache busting purposes. If version is set to false, a version
 *                                 number is automatically added equal to current installed NexusPress version.
 *                                 If set to null, no version is added.
 * @param string           $media  Optional. The media for which this stylesheet has been defined.
 *                                 Default 'all'. Accepts media types like 'all', 'print' and 'screen', or media queries like
 *                                 '(orientation: portrait)' and '(max-width: 640px)'.
 */
function nx_enqueue_style( $handle, $src = '', $deps = array(), $ver = false, $media = 'all' ) {
	_nx_scripts_maybe_doing_it_wrong( __FUNCTION__, $handle );

	$nx_styles = nx_styles();

	if ( $src ) {
		$_handle = explode( '?', $handle );
		$nx_styles->add( $_handle[0], $src, $deps, $ver, $media );
	}

	$nx_styles->enqueue( $handle );
}

/**
 * Removes a previously enqueued CSS stylesheet.
 *
 * @see NX_Dependencies::dequeue()
 *
 * @since 3.1.0
 *
 * @param string $handle Name of the stylesheet to be removed.
 */
function nx_dequeue_style( $handle ) {
	_nx_scripts_maybe_doing_it_wrong( __FUNCTION__, $handle );

	nx_styles()->dequeue( $handle );
}

/**
 * Checks whether a CSS stylesheet has been added to the queue.
 *
 * @since 2.8.0
 *
 * @param string $handle Name of the stylesheet.
 * @param string $status Optional. Status of the stylesheet to check. Default 'enqueued'.
 *                       Accepts 'enqueued', 'registered', 'queue', 'to_do', and 'done'.
 * @return bool Whether style is queued.
 */
function nx_style_is( $handle, $status = 'enqueued' ) {
	_nx_scripts_maybe_doing_it_wrong( __FUNCTION__, $handle );

	return (bool) nx_styles()->query( $handle, $status );
}

/**
 * Adds metadata to a CSS stylesheet.
 *
 * Works only if the stylesheet has already been registered.
 *
 * Possible values for $key and $value:
 * 'conditional' string      Comments for IE 6, lte IE 7 etc.
 * 'rtl'         bool|string To declare an RTL stylesheet.
 * 'suffix'      string      Optional suffix, used in combination with RTL.
 * 'alt'         bool        For rel="alternate stylesheet".
 * 'title'       string      For preferred/alternate stylesheets.
 * 'path'        string      The absolute path to a stylesheet. Stylesheet will
 *                           load inline when 'path' is set.
 *
 * @see NX_Dependencies::add_data()
 *
 * @since 3.6.0
 * @since 5.8.0 Added 'path' as an official value for $key.
 *              See {@see nx_maybe_inline_styles()}.
 *
 * @param string $handle Name of the stylesheet.
 * @param string $key    Name of data point for which we're storing a value.
 *                       Accepts 'conditional', 'rtl' and 'suffix', 'alt', 'title' and 'path'.
 * @param mixed  $value  String containing the CSS data to be added.
 * @return bool True on success, false on failure.
 */
function nx_style_add_data( $handle, $key, $value ) {
	return nx_styles()->add_data( $handle, $key, $value );
}
