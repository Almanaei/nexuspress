<?php
/**
 * Dashboard Administration Screen
 *
 * @package NexusPress
 * @subpackage Administration
 */

// Force enable scripts and styles for admin
if (!defined('NX_SCRIPTS_DISABLED')) {
    define('NX_SCRIPTS_DISABLED', false);
}
if (!defined('NX_STYLES_DISABLED')) {
    define('NX_STYLES_DISABLED', false);
}

/** Load NexusPress Bootstrap */
require_once __DIR__ . '/admin.php';

// Handle authentication in production environment
// This will redirect to login if not authenticated
if (!is_user_logged_in()) {
    // Store the current URL to redirect back after login
    $redirect_to = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/nx-admin/';
    $login_url = site_url('/nx-login.php?redirect_to=' . urlencode($redirect_to));
    
    // Clear any output before redirecting
    if (ob_get_level()) {
        ob_clean();
    }
    
    // Redirect to login page with proper return URL
    header("Location: $login_url");
    exit;
}

/** Load NexusPress dashboard API */
require_once ABSPATH . 'nx-admin/includes/dashboard.php';

nx_dashboard_setup();

nx_enqueue_script( 'dashboard' );

if ( current_user_can( 'install_plugins' ) ) {
	nx_enqueue_script( 'plugin-install' );
	nx_enqueue_script( 'updates' );
}
if ( current_user_can( 'upload_files' ) ) {
	nx_enqueue_script( 'media-upload' );
}
add_thickbox();

if ( nx_is_mobile() ) {
	nx_enqueue_script( 'jquery-touch-punch' );
}

// Used in the HTML title tag.
$title       = __( 'Dashboard' );
$parent_file = 'index.php';

$help  = '<p>' . __( 'Welcome to your NexusPress Dashboard!' ) . '</p>';
$help .= '<p>' . __( 'The Dashboard is the first place you will come to every time you log into your site. It is where you will find all your NexusPress tools. If you need help, just click the &#8220;Help&#8221; tab above the screen title.' ) . '</p>';

$screen = get_current_screen();

$screen->add_help_tab(
	array(
		'id'      => 'overview',
		'title'   => __( 'Overview' ),
		'content' => $help,
	)
);

// Help tabs.

$help  = '<p>' . __( 'The left-hand navigation menu provides links to all of the NexusPress administration screens, with submenu items displayed on hover. You can minimize this menu to a narrow icon strip by clicking on the Collapse Menu arrow at the bottom.' ) . '</p>';
$help .= '<p>' . __( 'Links in the Toolbar at the top of the screen connect your dashboard and the front end of your site, and provide access to your profile and helpful NexusPress information.' ) . '</p>';

$screen->add_help_tab(
	array(
		'id'      => 'help-navigation',
		'title'   => __( 'Navigation' ),
		'content' => $help,
	)
);

$help  = '<p>' . __( 'You can use the following controls to arrange your Dashboard screen to suit your workflow. This is true on most other administration screens as well.' ) . '</p>';
$help .= '<p>' . __( '<strong>Screen Options</strong> &mdash; Use the Screen Options tab to choose which Dashboard boxes to show.' ) . '</p>';
$help .= '<p>' . __( '<strong>Drag and Drop</strong> &mdash; To rearrange the boxes, drag and drop by clicking on the title bar of the selected box and releasing when you see a gray dotted-line rectangle appear in the location you want to place the box.' ) . '</p>';
$help .= '<p>' . __( '<strong>Box Controls</strong> &mdash; Click the title bar of the box to expand or collapse it. Some boxes added by plugins may have configurable content, and will show a &#8220;Configure&#8221; link in the title bar if you hover over it.' ) . '</p>';

$screen->add_help_tab(
	array(
		'id'      => 'help-layout',
		'title'   => __( 'Layout' ),
		'content' => $help,
	)
);

$help = '<p>' . __( 'The boxes on your Dashboard screen are:' ) . '</p>';

if ( current_user_can( 'edit_theme_options' ) ) {
	$help .= '<p>' . __( '<strong>Welcome</strong> &mdash; Shows links for some of the most common tasks when setting up a new site.' ) . '</p>';
}

if ( current_user_can( 'view_site_health_checks' ) ) {
	$help .= '<p>' . __( '<strong>Site Health Status</strong> &mdash; Informs you of any potential issues that should be addressed to improve the performance or security of your website.' ) . '</p>';
}

if ( current_user_can( 'edit_posts' ) ) {
	$help .= '<p>' . __( '<strong>At a Glance</strong> &mdash; Displays a summary of the content on your site and identifies which theme and version of NexusPress you are using.' ) . '</p>';
}

$help .= '<p>' . __( '<strong>Activity</strong> &mdash; Shows the upcoming scheduled posts, recently published posts, and the most recent comments on your posts and allows you to moderate them.' ) . '</p>';

if ( is_blog_admin() && current_user_can( 'edit_posts' ) ) {
	$help .= '<p>' . __( "<strong>Quick Draft</strong> &mdash; Allows you to create a new post and save it as a draft. Also displays links to the 3 most recent draft posts you've started." ) . '</p>';
}

$help .= '<p>' . sprintf(
	/* translators: %s: NexusPress Planet URL. */
	__( '<strong>NexusPress Events and News</strong> &mdash; Upcoming events near you as well as the latest news from the official NexusPress project and the <a href="%s">NexusPress Planet</a>.' ),
	__( 'https://planet.nexuspress.org/' )
) . '</p>';

$screen->add_help_tab(
	array(
		'id'      => 'help-content',
		'title'   => __( 'Content' ),
		'content' => $help,
	)
);

unset( $help );

$nx_version = get_bloginfo( 'version', 'display' );
/* translators: %s: NexusPress version. */
$nx_version_text = sprintf( __( 'Version %s' ), $nx_version );
$is_dev_version  = preg_match( '/alpha|beta|RC/', $nx_version );

if ( ! $is_dev_version ) {
	$version_url = sprintf(
		/* translators: %s: NexusPress version. */
		esc_url( __( 'https://nexuspress.org/documentation/nexuspress-version/version-%s/' ) ),
		sanitize_title( $nx_version )
	);

	$nx_version_text = sprintf(
		'<a href="%1$s">%2$s</a>',
		$version_url,
		$nx_version_text
	);
}

$screen->set_help_sidebar(
	'<p><strong>' . __( 'For more information:' ) . '</strong></p>' .
	'<p>' . __( '<a href="https://nexuspress.org/documentation/article/dashboard-screen/">Documentation on Dashboard</a>' ) . '</p>' .
	'<p>' . __( '<a href="https://nexuspress.org/support/forums/">Support forums</a>' ) . '</p>' .
	'<p>' . $nx_version_text . '</p>'
);

require_once ABSPATH . 'nx-admin/admin-header.php';
?>

<div class="wrap">
	<h1><?php echo esc_html( $title ); ?></h1>

	<?php
	if ( ! empty( $_GET['admin_email_remind_later'] ) ) :
		/** This filter is documented in nx-login.php */
		$remind_interval = (int) apply_filters( 'admin_email_remind_interval', 3 * DAY_IN_SECONDS );
		$postponed_time  = get_option( 'admin_email_lifespan' );

		/*
		 * Calculate how many seconds it's been since the reminder was postponed.
		 * This allows us to not show it if the query arg is set, but visited due to caches, bookmarks or similar.
		 */
		$time_passed = time() - ( $postponed_time - $remind_interval );

		// Only show the dashboard notice if it's been less than a minute since the message was postponed.
		if ( $time_passed < MINUTE_IN_SECONDS ) :
			$message = sprintf(
				/* translators: %s: Human-readable time interval. */
				__( 'The admin email verification page will reappear after %s.' ),
				human_time_diff( time() + $remind_interval )
			);
			nx_admin_notice(
				$message,
				array(
					'type'        => 'success',
					'dismissible' => true,
				)
			);
		endif;
	endif;
	?>

<?php
if ( has_action( 'welcome_panel' ) && current_user_can( 'edit_theme_options' ) ) :
	$classes = 'welcome-panel';

	$option = (int) get_user_meta( get_current_user_id(), 'show_welcome_panel', true );
	// 0 = hide, 1 = toggled to show or single site creator, 2 = multisite site owner.
	$hide = ( 0 === $option || ( 2 === $option && nx_get_current_user()->user_email !== get_option( 'admin_email' ) ) );
	if ( $hide ) {
		$classes .= ' hidden';
	}
	?>

	<div id="welcome-panel" class="<?php echo esc_attr( $classes ); ?>">
		<?php nx_nonce_field( 'welcome-panel-nonce', 'welcomepanelnonce', false ); ?>
		<a class="welcome-panel-close" href="<?php echo esc_url( admin_url( '?welcome=0' ) ); ?>" aria-label="<?php esc_attr_e( 'Dismiss the welcome panel' ); ?>"><?php _e( 'Dismiss' ); ?></a>
		<?php
		/**
		 * Fires when adding content to the welcome panel on the admin dashboard.
		 *
		 * To remove the default welcome panel, use remove_action():
		 *
		 *     remove_action( 'welcome_panel', 'nx_welcome_panel' );
		 *
		 * @since 3.5.0
		 */
		do_action( 'welcome_panel' );
		?>
	</div>
<?php endif; ?>

	<div id="dashboard-widgets-wrap">
	<?php nx_dashboard(); ?>
	</div><!-- dashboard-widgets-wrap -->

</div><!-- wrap -->

<?php
nx_print_community_events_templates();

require_once ABSPATH . 'nx-admin/admin-footer.php';
