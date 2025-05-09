<?php
/**
 * Theme Customize Screen.
 *
 * @package NexusPress
 * @subpackage Customize
 * @since 3.4.0
 */

define( 'IFRAME_REQUEST', true );

/** Load NexusPress Administration Bootstrap */
require_once __DIR__ . '/admin.php';

if ( ! current_user_can( 'customize' ) ) {
	nx_die(
		'<h1>' . __( 'You need a higher level of permission.' ) . '</h1>' .
		'<p>' . __( 'Sorry, you are not allowed to customize this site.' ) . '</p>',
		403
	);
}

/**
 * @global NX_Scripts           $nx_scripts
 * @global NX_Customize_Manager $nx_customize
 */
global $nx_scripts, $nx_customize;

if ( $nx_customize->changeset_post_id() ) {
	$changeset_post = get_post( $nx_customize->changeset_post_id() );

	if ( ! current_user_can( get_post_type_object( 'customize_changeset' )->cap->edit_post, $changeset_post->ID ) ) {
		nx_die(
			'<h1>' . __( 'You need a higher level of permission.' ) . '</h1>' .
			'<p>' . __( 'Sorry, you are not allowed to edit this changeset.' ) . '</p>',
			403
		);
	}

	$missed_schedule = (
		'future' === $changeset_post->post_status &&
		get_post_time( 'G', true, $changeset_post ) < time()
	);
	if ( $missed_schedule ) {
		/*
		 * Note that an Ajax request spawns here instead of just calling `nx_publish_post( $changeset_post->ID )`.
		 *
		 * Because NX_Customize_Manager is not instantiated for customize.php with the `settings_previewed=false`
		 * argument, settings cannot be reliably saved. Some logic short-circuits if the current value is the
		 * same as the value being saved. This is particularly true for options via `update_option()`.
		 *
		 * By opening an Ajax request, this is avoided and the changeset is published. See #39221.
		 */
		$nonces       = $nx_customize->get_nonces();
		$request_args = array(
			'nonce'                      => $nonces['save'],
			'customize_changeset_uuid'   => $nx_customize->changeset_uuid(),
			'nx_customize'               => 'on',
			'customize_changeset_status' => 'publish',
		);
		ob_start();
		?>
		<?php nx_print_scripts( array( 'nx-util' ) ); ?>
		<script>
			wp.ajax.post( 'customize_save', <?php echo nx_json_encode( $request_args ); ?> );
		</script>
		<?php
		$script = ob_get_clean();

		nx_die(
			'<h1>' . __( 'Your scheduled changes just published' ) . '</h1>' .
			'<p><a href="' . esc_url( remove_query_arg( 'changeset_uuid' ) ) . '">' . __( 'Customize New Changes' ) . '</a></p>' . $script,
			200
		);
	}

	if ( in_array( get_post_status( $changeset_post->ID ), array( 'publish', 'trash' ), true ) ) {
		nx_die(
			'<h1>' . __( 'Something went wrong.' ) . '</h1>' .
			'<p>' . __( 'This changeset cannot be further modified.' ) . '</p>' .
			'<p><a href="' . esc_url( remove_query_arg( 'changeset_uuid' ) ) . '">' . __( 'Customize New Changes' ) . '</a></p>',
			403
		);
	}
}

$url       = ! empty( $_REQUEST['url'] ) ? sanitize_text_field( nx_unslash( $_REQUEST['url'] ) ) : '';
$return    = ! empty( $_REQUEST['return'] ) ? sanitize_text_field( nx_unslash( $_REQUEST['return'] ) ) : '';
$autofocus = ! empty( $_REQUEST['autofocus'] ) && is_array( $_REQUEST['autofocus'] )
	? array_map( 'sanitize_text_field', nx_unslash( $_REQUEST['autofocus'] ) )
	: array();

if ( ! empty( $url ) ) {
	$nx_customize->set_preview_url( $url );
}
if ( ! empty( $return ) ) {
	$nx_customize->set_return_url( $return );
}
if ( ! empty( $autofocus ) ) {
	$nx_customize->set_autofocus( $autofocus );
}

$registered             = $nx_scripts->registered;
$nx_scripts             = new NX_Scripts();
$nx_scripts->registered = $registered;

add_action( 'customize_controls_print_scripts', 'print_head_scripts', 20 );
add_action( 'customize_controls_print_footer_scripts', '_nx_footer_scripts' );
add_action( 'customize_controls_print_styles', 'print_admin_styles', 20 );

/**
 * Fires when Customizer controls are initialized, before scripts are enqueued.
 *
 * @since 3.4.0
 */
do_action( 'customize_controls_init' );

nx_enqueue_script( 'heartbeat' );
nx_enqueue_script( 'customize-controls' );
nx_enqueue_style( 'customize-controls' );

/**
 * Fires when enqueuing Customizer control scripts.
 *
 * @since 3.4.0
 */
do_action( 'customize_controls_enqueue_scripts' );

// Let's roll.
header( 'Content-Type: ' . get_option( 'html_type' ) . '; charset=' . get_option( 'blog_charset' ) );

nx_user_settings();
_nx_admin_html_begin();

$body_class = 'nx-core-ui nx-customizer js';

if ( nx_is_mobile() ) :
	$body_class .= ' mobile';
	add_filter( 'admin_viewport_meta', '_customizer_mobile_viewport_meta' );
endif;

if ( $nx_customize->is_ios() ) {
	$body_class .= ' ios';
}

if ( is_rtl() ) {
	$body_class .= ' rtl';
}
$body_class .= ' locale-' . sanitize_html_class( strtolower( str_replace( '_', '-', get_user_locale() ) ) );

if ( nx_use_widgets_block_editor() ) {
	$body_class .= ' nx-embed-responsive';
}

$admin_title = sprintf( $nx_customize->get_document_title_template(), __( 'Loading&hellip;' ) );

?>
<title><?php echo esc_html( $admin_title ); ?></title>

<script type="text/javascript">
var ajaxurl = <?php echo nx_json_encode( admin_url( 'admin-ajax.php', 'relative' ) ); ?>,
	pagenow = 'customize';
</script>

<?php
/**
 * Fires when Customizer control styles are printed.
 *
 * @since 3.4.0
 */
do_action( 'customize_controls_print_styles' );

/**
 * Fires when Customizer control scripts are printed.
 *
 * @since 3.4.0
 */
do_action( 'customize_controls_print_scripts' );

/**
 * Fires in head section of Customizer controls.
 *
 * @since 5.5.0
 */
do_action( 'customize_controls_head' );
?>
</head>
<body class="<?php echo esc_attr( $body_class ); ?>">
<div class="nx-full-overlay expanded">
	<form id="customize-controls" class="wrap nx-full-overlay-sidebar">
		<div id="customize-header-actions" class="nx-full-overlay-header">
			<?php
			$compatible_wp  = is_nx_version_compatible( $nx_customize->theme()->get( 'RequiresWP' ) );
			$compatible_php = is_php_version_compatible( $nx_customize->theme()->get( 'RequiresPHP' ) );
			?>
			<?php if ( $compatible_wp && $compatible_php ) : ?>
				<?php $save_text = $nx_customize->is_theme_active() ? __( 'Publish' ) : __( 'Activate &amp; Publish' ); ?>
				<div id="customize-save-button-wrapper" class="customize-save-button-wrapper" >
					<?php submit_button( $save_text, 'primary save', 'save', false ); ?>
					<button id="publish-settings" class="publish-settings button-primary button dashicons dashicons-admin-generic" aria-label="<?php esc_attr_e( 'Publish Settings' ); ?>" aria-expanded="false" disabled></button>
				</div>
			<?php else : ?>
				<?php $save_text = _x( 'Cannot Activate', 'theme' ); ?>
				<div id="customize-save-button-wrapper" class="customize-save-button-wrapper disabled" >
					<button class="button button-primary disabled" aria-label="<?php esc_attr_e( 'Publish Settings' ); ?>" aria-expanded="false" disabled><?php echo $save_text; ?></button>
				</div>
			<?php endif; ?>
			<span class="spinner"></span>
			<button type="button" class="customize-controls-preview-toggle">
				<span class="controls"><?php _e( 'Customize' ); ?></span>
				<span class="preview"><?php _e( 'Preview' ); ?></span>
			</button>
			<a class="customize-controls-close" href="<?php echo esc_url( $nx_customize->get_return_url() ); ?>">
				<span class="screen-reader-text">
					<?php
					/* translators: Hidden accessibility text. */
					_e( 'Close the Customizer and go back to the previous page' );
					?>
				</span>
			</a>
		</div>

		<div id="customize-sidebar-outer-content">
			<div id="customize-outer-theme-controls">
				<ul class="customize-outer-pane-parent"><?php // Outer panel and sections are not implemented, but its here as a placeholder to avoid any side-effect in api.Section. ?></ul>
			</div>
		</div>

		<div id="widgets-right" class="nx-clearfix"><!-- For Widget Customizer, many widgets try to look for instances under div#widgets-right, so we have to add that ID to a container div in the Customizer for compat -->
			<div id="customize-notifications-area" class="customize-control-notifications-container">
				<ul></ul>
			</div>
			<div class="nx-full-overlay-sidebar-content" tabindex="-1">
				<div id="customize-info" class="accordion-section customize-info" data-block-theme="<?php echo (int) nx_is_block_theme(); ?>">
					<div class="accordion-section-title">
						<span class="preview-notice">
						<?php
							/* translators: %s: The site/panel title in the Customizer. */
							printf( __( 'You are customizing %s' ), '<strong class="panel-title site-title">' . get_bloginfo( 'name', 'display' ) . '</strong>' );
						?>
						</span>
						<button type="button" class="customize-help-toggle dashicons dashicons-editor-help" aria-expanded="false"><span class="screen-reader-text">
							<?php
							/* translators: Hidden accessibility text. */
							_e( 'Help' );
							?>
						</span></button>
					</div>
					<div class="customize-panel-description">
						<p>
							<?php
							_e( 'The Customizer allows you to preview changes to your site before publishing them. You can navigate to different pages on your site within the preview. Edit shortcuts are shown for some editable elements. The Customizer is intended for use with non-block themes.' );
							?>
						</p>
						<p>
							<?php
							_e( '<a href="https://nexuspress.org/documentation/article/customizer/">Documentation on Customizer</a>' );
							?>
						</p>
					</div>
				</div>

				<div id="customize-theme-controls">
					<ul class="customize-pane-parent"><?php // Panels and sections are managed here via JavaScript ?></ul>
				</div>
			</div>
		</div>

		<div id="customize-footer-actions" class="nx-full-overlay-footer">
			<button type="button" class="collapse-sidebar button" aria-expanded="true" aria-label="<?php echo esc_attr_x( 'Hide Controls', 'label for hide controls button without length constraints' ); ?>">
				<span class="collapse-sidebar-arrow"></span>
				<span class="collapse-sidebar-label"><?php _ex( 'Hide Controls', 'short (~12 characters) label for hide controls button' ); ?></span>
			</button>
			<?php $previewable_devices = $nx_customize->get_previewable_devices(); ?>
			<?php if ( ! empty( $previewable_devices ) ) : ?>
			<div class="devices-wrapper">
				<div class="devices">
					<?php foreach ( (array) $previewable_devices as $device => $settings ) : ?>
						<?php
						if ( empty( $settings['label'] ) ) {
							continue;
						}
						$active = ! empty( $settings['default'] );
						$class  = 'preview-' . $device;
						if ( $active ) {
							$class .= ' active';
						}
						?>
						<button type="button" class="<?php echo esc_attr( $class ); ?>" aria-pressed="<?php echo esc_attr( $active ); ?>" data-device="<?php echo esc_attr( $device ); ?>">
							<span class="screen-reader-text"><?php echo esc_html( $settings['label'] ); ?></span>
						</button>
					<?php endforeach; ?>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</form>
	<div id="customize-preview" class="nx-full-overlay-main"></div>
	<?php

	/**
	 * Prints templates, control scripts, and settings in the footer.
	 *
	 * @since 3.4.0
	 */
	do_action( 'customize_controls_print_footer_scripts' );
	?>
</div>
</body>
</html>
