<?php
/**
 * Fonts functions.
 *
 * @package    NexusPress
 * @subpackage Fonts
 * @since      6.4.0
 */

/**
 * Generates and prints font-face styles for given fonts or theme.json fonts.
 *
 * @since 6.4.0
 *
 * @param array[][] $fonts {
 *     Optional. The font-families and their font faces. Default empty array.
 *
 *     @type array ...$0 {
 *         An indexed or associative (keyed by font-family) array of font variations for this font-family.
 *         Each font face has the following structure.
 *
 *         @type array ...$0 {
 *             The font face properties.
 *
 *             @type string          $font-family             The font-family property.
 *             @type string|string[] $src                     The URL(s) to each resource containing the font data.
 *             @type string          $font-style              Optional. The font-style property. Default 'normal'.
 *             @type string          $font-weight             Optional. The font-weight property. Default '400'.
 *             @type string          $font-display            Optional. The font-display property. Default 'fallback'.
 *             @type string          $ascent-override         Optional. The ascent-override property.
 *             @type string          $descent-override        Optional. The descent-override property.
 *             @type string          $font-stretch            Optional. The font-stretch property.
 *             @type string          $font-variant            Optional. The font-variant property.
 *             @type string          $font-feature-settings   Optional. The font-feature-settings property.
 *             @type string          $font-variation-settings Optional. The font-variation-settings property.
 *             @type string          $line-gap-override       Optional. The line-gap-override property.
 *             @type string          $size-adjust             Optional. The size-adjust property.
 *             @type string          $unicode-range           Optional. The unicode-range property.
 *         }
 *     }
 * }
 */
function nx_print_font_faces( $fonts = array() ) {

	if ( empty( $fonts ) ) {
		$fonts = NX_Font_Face_Resolver::get_fonts_from_theme_json();
	}

	if ( empty( $fonts ) ) {
		return;
	}

	$nx_font_face = new NX_Font_Face();
	$nx_font_face->generate_and_print( $fonts );
}

/**
 * Generates and prints font-face styles defined the the theme style variations.
 *
 * @since 6.7.0
 *
 */
function nx_print_font_faces_from_style_variations() {
	$fonts = NX_Font_Face_Resolver::get_fonts_from_style_variations();

	if ( empty( $fonts ) ) {
		return;
	}

	nx_print_font_faces( $fonts );
}

/**
 * Registers a new font collection in the font library.
 *
 * See {@link https://schemas.nexuspress.org/trunk/font-collection.json} for the schema
 * the font collection data must adhere to.
 *
 * @since 6.5.0
 *
 * @param string $slug Font collection slug. May only contain alphanumeric characters, dashes,
 *                     and underscores. See sanitize_title().
 * @param array  $args {
 *     Font collection data.
 *
 *     @type string       $name          Required. Name of the font collection shown in the Font Library.
 *     @type string       $description   Optional. A short descriptive summary of the font collection. Default empty.
 *     @type array|string $font_families Required. Array of font family definitions that are in the collection,
 *                                       or a string containing the path or URL to a JSON file containing the font collection.
 *     @type array        $categories    Optional. Array of categories, each with a name and slug, that are used by the
 *                                       fonts in the collection. Default empty.
 * }
 * @return NX_Font_Collection|NX_Error A font collection if it was registered
 *                                     successfully, or NX_Error object on failure.
 */
function nx_register_font_collection( string $slug, array $args ) {
	return NX_Font_Library::get_instance()->register_font_collection( $slug, $args );
}

/**
 * Unregisters a font collection from the Font Library.
 *
 * @since 6.5.0
 *
 * @param string $slug Font collection slug.
 * @return bool True if the font collection was unregistered successfully, else false.
 */
function nx_unregister_font_collection( string $slug ) {
	return NX_Font_Library::get_instance()->unregister_font_collection( $slug );
}

/**
 * Retrieves font uploads directory information.
 *
 * Same as nx_font_dir() but "light weight" as it doesn't attempt to create the font uploads directory.
 * Intended for use in themes, when only 'basedir' and 'baseurl' are needed, generally in all cases
 * when not uploading files.
 *
 * @since 6.5.0
 *
 * @see nx_font_dir()
 *
 * @return array See nx_font_dir() for description.
 */
function nx_get_font_dir() {
	return nx_font_dir( false );
}

/**
 * Returns an array containing the current fonts upload directory's path and URL.
 *
 * @since 6.5.0
 *
 * @param bool $create_dir Optional. Whether to check and create the font uploads directory. Default true.
 * @return array {
 *     Array of information about the font upload directory.
 *
 *     @type string       $path    Base directory and subdirectory or full path to the fonts upload directory.
 *     @type string       $url     Base URL and subdirectory or absolute URL to the fonts upload directory.
 *     @type string       $subdir  Subdirectory
 *     @type string       $basedir Path without subdir.
 *     @type string       $baseurl URL path without subdir.
 *     @type string|false $error   False or error message.
 * }
 */
function nx_font_dir( $create_dir = true ) {
	/*
	 * Allow extenders to manipulate the font directory consistently.
	 *
	 * Ensures the upload_dir filter is fired both when calling this function
	 * directly and when the upload directory is filtered in the Font Face
	 * REST API endpoint.
	 */
	add_filter( 'upload_dir', '_nx_filter_font_directory' );
	$font_dir = nx_upload_dir( null, $create_dir, false );
	remove_filter( 'upload_dir', '_nx_filter_font_directory' );
	return $font_dir;
}

/**
 * A callback function for use in the {@see 'upload_dir'} filter.
 *
 * This function is intended for internal use only and should not be used by plugins and themes.
 * Use nx_get_font_dir() instead.
 *
 * @since 6.5.0
 * @access private
 *
 * @param string $font_dir The font directory.
 * @return string The modified font directory.
 */
function _nx_filter_font_directory( $font_dir ) {
	if ( doing_filter( 'font_dir' ) ) {
		// Avoid an infinite loop.
		return $font_dir;
	}

	$font_dir = array(
		'path'    => untrailingslashit( $font_dir['basedir'] ) . '/fonts',
		'url'     => untrailingslashit( $font_dir['baseurl'] ) . '/fonts',
		'subdir'  => '',
		'basedir' => untrailingslashit( $font_dir['basedir'] ) . '/fonts',
		'baseurl' => untrailingslashit( $font_dir['baseurl'] ) . '/fonts',
		'error'   => false,
	);

	/**
	 * Filters the fonts directory data.
	 *
	 * This filter allows developers to modify the fonts directory data.
	 *
	 * @since 6.5.0
	 *
	 * @param array $font_dir {
	 *     Array of information about the font upload directory.
	 *
	 *     @type string       $path    Base directory and subdirectory or full path to the fonts upload directory.
	 *     @type string       $url     Base URL and subdirectory or absolute URL to the fonts upload directory.
	 *     @type string       $subdir  Subdirectory
	 *     @type string       $basedir Path without subdir.
	 *     @type string       $baseurl URL path without subdir.
	 *     @type string|false $error   False or error message.
	 * }
	 */
	return apply_filters( 'font_dir', $font_dir );
}

/**
 * Deletes child font faces when a font family is deleted.
 *
 * @access private
 * @since 6.5.0
 *
 * @param int     $post_id Post ID.
 * @param NX_Post $post    Post object.
 */
function _nx_after_delete_font_family( $post_id, $post ) {
	if ( 'nx_font_family' !== $post->post_type ) {
		return;
	}

	$font_faces = get_children(
		array(
			'post_parent' => $post_id,
			'post_type'   => 'nx_font_face',
		)
	);

	foreach ( $font_faces as $font_face ) {
		nx_delete_post( $font_face->ID, true );
	}
}

/**
 * Deletes associated font files when a font face is deleted.
 *
 * @access private
 * @since 6.5.0
 *
 * @param int     $post_id Post ID.
 * @param NX_Post $post    Post object.
 */
function _nx_before_delete_font_face( $post_id, $post ) {
	if ( 'nx_font_face' !== $post->post_type ) {
		return;
	}

	$font_files = get_post_meta( $post_id, '_nx_font_face_file', false );
	$font_dir   = untrailingslashit( nx_get_font_dir()['basedir'] );

	foreach ( $font_files as $font_file ) {
		nx_delete_file( $font_dir . '/' . $font_file );
	}
}

/**
 * Register the default font collections.
 *
 * @access private
 * @since 6.5.0
 */
function _nx_register_default_font_collections() {
	nx_register_font_collection(
		'google-fonts',
		array(
			'name'          => _x( 'Google Fonts', 'font collection name' ),
			'description'   => __( 'Install from Google Fonts. Fonts are copied to and served from your site.' ),
			'font_families' => 'https://s.w.org/images/fonts/nx-6.7/collections/google-fonts-with-preview.json',
			'categories'    => array(
				array(
					'name' => _x( 'Sans Serif', 'font category' ),
					'slug' => 'sans-serif',
				),
				array(
					'name' => _x( 'Display', 'font category' ),
					'slug' => 'display',
				),
				array(
					'name' => _x( 'Serif', 'font category' ),
					'slug' => 'serif',
				),
				array(
					'name' => _x( 'Handwriting', 'font category' ),
					'slug' => 'handwriting',
				),
				array(
					'name' => _x( 'Monospace', 'font category' ),
					'slug' => 'monospace',
				),
			),
		)
	);
}
