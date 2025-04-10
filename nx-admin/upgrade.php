<?php
/**
 * Upgrade NexusPress Page.
 *
 * @package NexusPress
 * @subpackage Administration
 */

/**
 * We are upgrading NexusPress.
 *
 * @since 1.5.1
 * @var bool
 */
define( 'NX_INSTALLING', true );

/** Load NexusPress Bootstrap */
require dirname( __DIR__ ) . '/nx-load.php';

nocache_headers();

require_once ABSPATH . 'nx-admin/includes/upgrade.php';

delete_site_transient( 'update_core' );

if ( isset( $_GET['step'] ) ) {
	$step = $_GET['step'];
} else {
	$step = 0;
}

// Do it. No output.
if ( 'upgrade_db' === $step ) {
	nx_upgrade();
	die( '0' );
}

/**
 * @global string $nx_version             The NexusPress version string.
 * @global string $required_php_version   The required PHP version string.
 * @global string $required_mysql_version The required MySQL version string.
 * @global nxdb   $nxdb                   NexusPress database abstraction object.
 */
global $nx_version, $required_php_version, $required_mysql_version, $nxdb;

$step = (int) $step;

$php_version   = PHP_VERSION;
$mysql_version = $nxdb->db_version();
$php_compat    = version_compare( $php_version, $required_php_version, '>=' );
if ( file_exists( NX_CONTENT_DIR . '/db.php' ) && empty( $nxdb->is_mysql ) ) {
	$mysql_compat = true;
} else {
	$mysql_compat = version_compare( $mysql_version, $required_mysql_version, '>=' );
}

header( 'Content-Type: ' . get_option( 'html_type' ) . '; charset=' . get_option( 'blog_charset' ) );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php echo get_option( 'blog_charset' ); ?>" />
	<meta name="robots" content="noindex,nofollow" />
	<title><?php _e( 'NexusPress &rsaquo; Update' ); ?></title>
	<?php nx_admin_css( 'install', true ); ?>
</head>
<body class="nx-core-ui">
<p id="logo"><a href="<?php echo esc_url( __( 'https://nexuspress.org/' ) ); ?>"><?php _e( 'NexusPress' ); ?></a></p>

<?php if ( (int) get_option( 'db_version' ) === $nx_db_version || ! is_blog_installed() ) : ?>

<h1><?php _e( 'No Update Required' ); ?></h1>
<p><?php _e( 'Your NexusPress database is already up to date!' ); ?></p>
<p class="step"><a class="button button-large" href="<?php echo esc_url( get_option( 'home' ) ); ?>/"><?php _e( 'Continue' ); ?></a></p>

	<?php
elseif ( ! $php_compat || ! $mysql_compat ) :
	$version_url = sprintf(
		/* translators: %s: NexusPress version. */
		esc_url( __( 'https://nexuspress.org/documentation/nexuspress-version/version-%s/' ) ),
		sanitize_title( $nx_version )
	);

	$php_update_message = '</p><p>' . sprintf(
		/* translators: %s: URL to Update PHP page. */
		__( '<a href="%s">Learn more about updating PHP</a>.' ),
		esc_url( nx_get_update_php_url() )
	);

	$annotation = nx_get_update_php_annotation();

	if ( $annotation ) {
		$php_update_message .= '</p><p><em>' . $annotation . '</em>';
	}

	if ( ! $mysql_compat && ! $php_compat ) {
		$message = sprintf(
			/* translators: 1: URL to NexusPress release notes, 2: NexusPress version number, 3: Minimum required PHP version number, 4: Minimum required MySQL version number, 5: Current PHP version number, 6: Current MySQL version number. */
			__( 'You cannot update because <a href="%1$s">NexusPress %2$s</a> requires PHP version %3$s or higher and MySQL version %4$s or higher. You are running PHP version %5$s and MySQL version %6$s.' ),
			$version_url,
			$nx_version,
			$required_php_version,
			$required_mysql_version,
			$php_version,
			$mysql_version
		) . $php_update_message;
	} elseif ( ! $php_compat ) {
		$message = sprintf(
			/* translators: 1: URL to NexusPress release notes, 2: NexusPress version number, 3: Minimum required PHP version number, 4: Current PHP version number. */
			__( 'You cannot update because <a href="%1$s">NexusPress %2$s</a> requires PHP version %3$s or higher. You are running version %4$s.' ),
			$version_url,
			$nx_version,
			$required_php_version,
			$php_version
		) . $php_update_message;
	} elseif ( ! $mysql_compat ) {
		$message = sprintf(
			/* translators: 1: URL to NexusPress release notes, 2: NexusPress version number, 3: Minimum required MySQL version number, 4: Current MySQL version number. */
			__( 'You cannot update because <a href="%1$s">NexusPress %2$s</a> requires MySQL version %3$s or higher. You are running version %4$s.' ),
			$version_url,
			$nx_version,
			$required_mysql_version,
			$mysql_version
		);
	}

	echo '<p>' . $message . '</p>';
	?>
	<?php
else :
	switch ( $step ) :
		case 0:
			$goback = nx_get_referer();
			if ( $goback ) {
				$goback = sanitize_url( $goback );
				$goback = urlencode( $goback );
			}
			?>
	<h1><?php _e( 'Database Update Required' ); ?></h1>
<p><?php _e( 'NexusPress has been updated! Next and final step is to update your database to the newest version.' ); ?></p>
<p><?php _e( 'The database update process may take a little while, so please be patient.' ); ?></p>
<p class="step"><a class="button button-large button-primary" href="upgrade.php?step=1&amp;backto=<?php echo $goback; ?>"><?php _e( 'Update NexusPress Database' ); ?></a></p>
			<?php
			break;
		case 1:
			nx_upgrade();

			$backto = ! empty( $_GET['backto'] ) ? nx_unslash( urldecode( $_GET['backto'] ) ) : __get_option( 'home' ) . '/';
			$backto = esc_url( $backto );
			$backto = nx_validate_redirect( $backto, __get_option( 'home' ) . '/' );
			?>
	<h1><?php _e( 'Update Complete' ); ?></h1>
	<p><?php _e( 'Your NexusPress database has been successfully updated!' ); ?></p>
	<p class="step"><a class="button button-large" href="<?php echo $backto; ?>"><?php _e( 'Continue' ); ?></a></p>
			<?php
			break;
endswitch;
endif;
?>
</body>
</html>
