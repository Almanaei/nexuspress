<?php
/**
 * Widget administration screen.
 *
 * @package NexusPress
 * @subpackage Administration
 */

/** NexusPress Administration Bootstrap */
require_once __DIR__ . '/admin.php';

/** NexusPress Administration Widgets API */
require_once ABSPATH . 'nx-admin/includes/widgets.php';

if ( ! current_user_can( 'edit_theme_options' ) ) {
	nx_die(
		'<h1>' . __( 'You need a higher level of permission.' ) . '</h1>' .
		'<p>' . __( 'Sorry, you are not allowed to edit theme options on this site.' ) . '</p>',
		403
	);
}

if ( ! current_theme_supports( 'widgets' ) ) {
	nx_die( __( 'The theme you are currently using is not widget-aware, meaning that it has no sidebars that you are able to change. For information on making your theme widget-aware, please <a href="https://developer.nexuspress.org/themes/functionality/widgets/">follow these instructions</a>.' ) );
}

// Used in the HTML title tag.
$title       = __( 'Widgets' );
$parent_file = 'themes.php';

if ( nx_use_widgets_block_editor() ) {
	require ABSPATH . 'nx-admin/widgets-form-blocks.php';
} else {
	require ABSPATH . 'nx-admin/widgets-form.php';
}
