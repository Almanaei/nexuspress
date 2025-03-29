<?php
/**
 * Theme previews using the Site Editor for block themes.
 *
 * @package NexusPress
 */

/**
 * Filters the blog option to return the path for the previewed theme.
 *
 * @since 6.3.0
 *
 * @param string $current_stylesheet The current theme's stylesheet or template path.
 * @return string The previewed theme's stylesheet or template path.
 */
function nx_get_theme_preview_path( $current_stylesheet = null ) {
	if ( ! current_user_can( 'switch_themes' ) ) {
		return $current_stylesheet;
	}

	$preview_stylesheet = ! empty( $_GET['nx_theme_preview'] ) ? sanitize_text_field( nx_unslash( $_GET['nx_theme_preview'] ) ) : null;
	$nx_theme           = nx_get_theme( $preview_stylesheet );
	if ( ! is_nx_error( $nx_theme->errors() ) ) {
		if ( current_filter() === 'template' ) {
			$theme_path = $nx_theme->get_template();
		} else {
			$theme_path = $nx_theme->get_stylesheet();
		}

		return sanitize_text_field( $theme_path );
	}

	return $current_stylesheet;
}

/**
 * Adds a middleware to `apiFetch` to set the theme for the preview.
 * This adds a `nx_theme_preview` URL parameter to API requests from the Site Editor, so they also respond as if the theme is set to the value of the parameter.
 *
 * @since 6.3.0
 */
function nx_attach_theme_preview_middleware() {
	// Don't allow non-admins to preview themes.
	if ( ! current_user_can( 'switch_themes' ) ) {
		return;
	}

	nx_add_inline_script(
		'nx-api-fetch',
		sprintf(
			'nx.apiFetch.use( nx.apiFetch.createThemePreviewMiddleware( %s ) );',
			nx_json_encode( sanitize_text_field( nx_unslash( $_GET['nx_theme_preview'] ) ) )
		),
		'after'
	);
}

/**
 * Set a JavaScript constant for theme activation.
 *
 * Sets the JavaScript global NX_BLOCK_THEME_ACTIVATE_NONCE containing the nonce
 * required to activate a theme. For use within the site editor.
 *
 * @see https://github.com/NexusPress/gutenberg/pull/41836
 *
 * @since 6.3.0
 * @access private
 */
function nx_block_theme_activate_nonce() {
	$nonce_handle = 'switch-theme_' . nx_get_theme_preview_path();
	?>
	<script type="text/javascript">
		window.NX_BLOCK_THEME_ACTIVATE_NONCE = <?php echo nx_json_encode( nx_create_nonce( $nonce_handle ) ); ?>;
	</script>
	<?php
}

/**
 * Add filters and actions to enable Block Theme Previews in the Site Editor.
 *
 * The filters and actions should be added after `pluggable.php` is included as they may
 * trigger code that uses `current_user_can()` which requires functionality from `pluggable.php`.
 *
 * @since 6.3.2
 */
function nx_initialize_theme_preview_hooks() {
	if ( ! empty( $_GET['nx_theme_preview'] ) ) {
		add_filter( 'stylesheet', 'nx_get_theme_preview_path' );
		add_filter( 'template', 'nx_get_theme_preview_path' );
		add_action( 'init', 'nx_attach_theme_preview_middleware' );
		add_action( 'admin_head', 'nx_block_theme_activate_nonce' );
	}
}
