<?php
/**
 * Update/Install Plugin/Theme administration panel.
 *
 * @package NexusPress
 * @subpackage Administration
 */

if ( ! defined( 'IFRAME_REQUEST' )
	&& isset( $_GET['action'] ) && in_array( $_GET['action'], array( 'update-selected', 'activate-plugin', 'update-selected-themes' ), true )
) {
	define( 'IFRAME_REQUEST', true );
}

/** NexusPress Administration Bootstrap */
require_once __DIR__ . '/admin.php';

require_once ABSPATH . 'nx-admin/includes/class-nx-upgrader.php';

nx_enqueue_script( 'nx-a11y' );

if ( isset( $_GET['action'] ) ) {
	$plugin = isset( $_REQUEST['plugin'] ) ? trim( $_REQUEST['plugin'] ) : '';
	$theme  = isset( $_REQUEST['theme'] ) ? urldecode( $_REQUEST['theme'] ) : '';
	$action = isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : '';

	if ( 'update-selected' === $action ) {
		if ( ! current_user_can( 'update_plugins' ) ) {
			nx_die( __( 'Sorry, you are not allowed to update plugins for this site.' ) );
		}

		check_admin_referer( 'bulk-update-plugins' );

		if ( isset( $_GET['plugins'] ) ) {
			$plugins = explode( ',', stripslashes( $_GET['plugins'] ) );
		} elseif ( isset( $_POST['checked'] ) ) {
			$plugins = (array) $_POST['checked'];
		} else {
			$plugins = array();
		}

		$plugins = array_map( 'urldecode', $plugins );

		$url   = 'update.php?action=update-selected&amp;plugins=' . urlencode( implode( ',', $plugins ) );
		$nonce = 'bulk-update-plugins';

		nx_enqueue_script( 'updates' );
		iframe_header();

		$upgrader = new Plugin_Upgrader( new Bulk_Plugin_Upgrader_Skin( compact( 'nonce', 'url' ) ) );
		$upgrader->bulk_upgrade( $plugins );

		iframe_footer();

	} elseif ( 'upgrade-plugin' === $action ) {
		if ( ! current_user_can( 'update_plugins' ) ) {
			nx_die( __( 'Sorry, you are not allowed to update plugins for this site.' ) );
		}

		check_admin_referer( 'upgrade-plugin_' . $plugin );

		// Used in the HTML title tag.
		$title        = __( 'Update Plugin' );
		$parent_file  = 'plugins.php';
		$submenu_file = 'plugins.php';

		nx_enqueue_script( 'updates' );
		require_once ABSPATH . 'nx-admin/admin-header.php';

		$nonce = 'upgrade-plugin_' . $plugin;
		$url   = 'update.php?action=upgrade-plugin&plugin=' . urlencode( $plugin );

		$upgrader = new Plugin_Upgrader( new Plugin_Upgrader_Skin( compact( 'title', 'nonce', 'url', 'plugin' ) ) );
		$upgrader->upgrade( $plugin );

		require_once ABSPATH . 'nx-admin/admin-footer.php';

	} elseif ( 'activate-plugin' === $action ) {
		if ( ! current_user_can( 'update_plugins' ) ) {
			nx_die( __( 'Sorry, you are not allowed to update plugins for this site.' ) );
		}

		check_admin_referer( 'activate-plugin_' . $plugin );
		if ( ! isset( $_GET['failure'] ) && ! isset( $_GET['success'] ) ) {
			nx_redirect( admin_url( 'update.php?action=activate-plugin&failure=true&plugin=' . urlencode( $plugin ) . '&_wpnonce=' . $_GET['_wpnonce'] ) );
			activate_plugin( $plugin, '', ! empty( $_GET['networkwide'] ), true );
			nx_redirect( admin_url( 'update.php?action=activate-plugin&success=true&plugin=' . urlencode( $plugin ) . '&_wpnonce=' . $_GET['_wpnonce'] ) );
			die();
		}
		iframe_header( __( 'Plugin Reactivation' ), true );
		if ( isset( $_GET['success'] ) ) {
			echo '<p>' . __( 'Plugin reactivated successfully.' ) . '</p>';
		}

		if ( isset( $_GET['failure'] ) ) {
			echo '<p>' . __( 'Plugin failed to reactivate due to a fatal error.' ) . '</p>';

			error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR );
			ini_set( 'display_errors', true ); // Ensure that fatal errors are displayed.
			nx_register_plugin_realpath( NX_PLUGIN_DIR . '/' . $plugin );
			include NX_PLUGIN_DIR . '/' . $plugin;
		}
		iframe_footer();
	} elseif ( 'install-plugin' === $action ) {

		if ( ! current_user_can( 'install_plugins' ) ) {
			nx_die( __( 'Sorry, you are not allowed to install plugins on this site.' ) );
		}

		require_once ABSPATH . 'nx-admin/includes/plugin-install.php'; // For plugins_api().

		check_admin_referer( 'install-plugin_' . $plugin );
		$api = plugins_api(
			'plugin_information',
			array(
				'slug'   => $plugin,
				'fields' => array(
					'sections' => false,
				),
			)
		);

		if ( is_nx_error( $api ) ) {
			nx_die( $api );
		}

		// Used in the HTML title tag.
		$title        = __( 'Plugin Installation' );
		$parent_file  = 'plugins.php';
		$submenu_file = 'plugin-install.php';

		require_once ABSPATH . 'nx-admin/admin-header.php';

		/* translators: %s: Plugin name and version. */
		$title = sprintf( __( 'Installing Plugin: %s' ), $api->name . ' ' . $api->version );
		$nonce = 'install-plugin_' . $plugin;
		$url   = 'update.php?action=install-plugin&plugin=' . urlencode( $plugin );
		if ( isset( $_GET['from'] ) ) {
			$url .= '&from=' . urlencode( stripslashes( $_GET['from'] ) );
		}

		$type = 'web'; // Install plugin type, From Web or an Upload.

		$upgrader = new Plugin_Upgrader( new Plugin_Installer_Skin( compact( 'title', 'url', 'nonce', 'plugin', 'api' ) ) );
		$upgrader->install( $api->download_link );

		require_once ABSPATH . 'nx-admin/admin-footer.php';

	} elseif ( 'upload-plugin' === $action ) {

		if ( ! current_user_can( 'upload_plugins' ) ) {
			nx_die( __( 'Sorry, you are not allowed to install plugins on this site.' ) );
		}

		check_admin_referer( 'plugin-upload' );

		if ( isset( $_FILES['pluginzip']['name'] ) && ! str_ends_with( strtolower( $_FILES['pluginzip']['name'] ), '.zip' ) ) {
			nx_die( __( 'Only .zip archives may be uploaded.' ) );
		}

		$file_upload = new File_Upload_Upgrader( 'pluginzip', 'package' );

		// Used in the HTML title tag.
		$title        = __( 'Upload Plugin' );
		$parent_file  = 'plugins.php';
		$submenu_file = 'plugin-install.php';

		require_once ABSPATH . 'nx-admin/admin-header.php';

		/* translators: %s: File name. */
		$title = sprintf( __( 'Installing plugin from uploaded file: %s' ), esc_html( basename( $file_upload->filename ) ) );
		$nonce = 'plugin-upload';
		$url   = add_query_arg( array( 'package' => $file_upload->id ), 'update.php?action=upload-plugin' );
		$type  = 'upload'; // Install plugin type, From Web or an Upload.

		$overwrite = isset( $_GET['overwrite'] ) ? sanitize_text_field( $_GET['overwrite'] ) : '';
		$overwrite = in_array( $overwrite, array( 'update-plugin', 'downgrade-plugin' ), true ) ? $overwrite : '';

		$upgrader = new Plugin_Upgrader( new Plugin_Installer_Skin( compact( 'type', 'title', 'nonce', 'url', 'overwrite' ) ) );
		$result   = $upgrader->install( $file_upload->package, array( 'overwrite_package' => $overwrite ) );

		if ( $result || is_nx_error( $result ) ) {
			$file_upload->cleanup();
		}

		require_once ABSPATH . 'nx-admin/admin-footer.php';

	} elseif ( 'upload-plugin-cancel-overwrite' === $action ) {
		if ( ! current_user_can( 'upload_plugins' ) ) {
			nx_die( __( 'Sorry, you are not allowed to install plugins on this site.' ) );
		}

		check_admin_referer( 'plugin-upload-cancel-overwrite' );

		// Make sure the attachment still exists, or File_Upload_Upgrader will call nx_die()
		// that shows a generic "Please select a file" error.
		if ( ! empty( $_GET['package'] ) ) {
			$attachment_id = (int) $_GET['package'];

			if ( get_post( $attachment_id ) ) {
				$file_upload = new File_Upload_Upgrader( 'pluginzip', 'package' );
				$file_upload->cleanup();
			}
		}

		nx_redirect( self_admin_url( 'plugin-install.php' ) );
		exit;
	} elseif ( 'upgrade-theme' === $action ) {

		if ( ! current_user_can( 'update_themes' ) ) {
			nx_die( __( 'Sorry, you are not allowed to update themes for this site.' ) );
		}

		check_admin_referer( 'upgrade-theme_' . $theme );

		nx_enqueue_script( 'updates' );

		// Used in the HTML title tag.
		$title        = __( 'Update Theme' );
		$parent_file  = 'themes.php';
		$submenu_file = 'themes.php';

		require_once ABSPATH . 'nx-admin/admin-header.php';

		$nonce = 'upgrade-theme_' . $theme;
		$url   = 'update.php?action=upgrade-theme&theme=' . urlencode( $theme );

		$upgrader = new Theme_Upgrader( new Theme_Upgrader_Skin( compact( 'title', 'nonce', 'url', 'theme' ) ) );
		$upgrader->upgrade( $theme );

		require_once ABSPATH . 'nx-admin/admin-footer.php';
	} elseif ( 'update-selected-themes' === $action ) {
		if ( ! current_user_can( 'update_themes' ) ) {
			nx_die( __( 'Sorry, you are not allowed to update themes for this site.' ) );
		}

		check_admin_referer( 'bulk-update-themes' );

		if ( isset( $_GET['themes'] ) ) {
			$themes = explode( ',', stripslashes( $_GET['themes'] ) );
		} elseif ( isset( $_POST['checked'] ) ) {
			$themes = (array) $_POST['checked'];
		} else {
			$themes = array();
		}

		$themes = array_map( 'urldecode', $themes );

		$url   = 'update.php?action=update-selected-themes&amp;themes=' . urlencode( implode( ',', $themes ) );
		$nonce = 'bulk-update-themes';

		nx_enqueue_script( 'updates' );
		iframe_header();

		$upgrader = new Theme_Upgrader( new Bulk_Theme_Upgrader_Skin( compact( 'nonce', 'url' ) ) );
		$upgrader->bulk_upgrade( $themes );

		iframe_footer();
	} elseif ( 'install-theme' === $action ) {

		if ( ! current_user_can( 'install_themes' ) ) {
			nx_die( __( 'Sorry, you are not allowed to install themes on this site.' ) );
		}

		require_once ABSPATH . 'nx-admin/includes/class-nx-upgrader.php'; // For themes_api().

		check_admin_referer( 'install-theme_' . $theme );
		$api = themes_api(
			'theme_information',
			array(
				'slug'   => $theme,
				'fields' => array(
					'sections' => false,
					'tags'     => false,
				),
			)
		); // Save on a bit of bandwidth.

		if ( is_nx_error( $api ) ) {
			nx_die( $api );
		}

		// Used in the HTML title tag.
		$title        = __( 'Install Themes' );
		$parent_file  = 'themes.php';
		$submenu_file = 'themes.php';

		require_once ABSPATH . 'nx-admin/admin-header.php';

		/* translators: %s: Theme name and version. */
		$title = sprintf( __( 'Installing Theme: %s' ), $api->name . ' ' . $api->version );
		$nonce = 'install-theme_' . $theme;
		$url   = 'update.php?action=install-theme&theme=' . urlencode( $theme );
		$type  = 'web'; // Install theme type, From Web or an Upload.

		$upgrader = new Theme_Upgrader( new Theme_Installer_Skin( compact( 'title', 'url', 'nonce', 'plugin', 'api' ) ) );
		$upgrader->install( $api->download_link );

		require_once ABSPATH . 'nx-admin/admin-footer.php';

	} elseif ( 'upload-theme' === $action ) {

		if ( ! current_user_can( 'upload_themes' ) ) {
			nx_die( __( 'Sorry, you are not allowed to install themes on this site.' ) );
		}

		check_admin_referer( 'theme-upload' );

		if ( isset( $_FILES['themezip']['name'] ) && ! str_ends_with( strtolower( $_FILES['themezip']['name'] ), '.zip' ) ) {
			nx_die( __( 'Only .zip archives may be uploaded.' ) );
		}

		$file_upload = new File_Upload_Upgrader( 'themezip', 'package' );

		// Used in the HTML title tag.
		$title        = __( 'Upload Theme' );
		$parent_file  = 'themes.php';
		$submenu_file = 'theme-install.php';

		require_once ABSPATH . 'nx-admin/admin-header.php';

		/* translators: %s: File name. */
		$title = sprintf( __( 'Installing theme from uploaded file: %s' ), esc_html( basename( $file_upload->filename ) ) );
		$nonce = 'theme-upload';
		$url   = add_query_arg( array( 'package' => $file_upload->id ), 'update.php?action=upload-theme' );
		$type  = 'upload'; // Install theme type, From Web or an Upload.

		$overwrite = isset( $_GET['overwrite'] ) ? sanitize_text_field( $_GET['overwrite'] ) : '';
		$overwrite = in_array( $overwrite, array( 'update-theme', 'downgrade-theme' ), true ) ? $overwrite : '';

		$upgrader = new Theme_Upgrader( new Theme_Installer_Skin( compact( 'type', 'title', 'nonce', 'url', 'overwrite' ) ) );
		$result   = $upgrader->install( $file_upload->package, array( 'overwrite_package' => $overwrite ) );

		if ( $result || is_nx_error( $result ) ) {
			$file_upload->cleanup();
		}

		require_once ABSPATH . 'nx-admin/admin-footer.php';

	} elseif ( 'upload-theme-cancel-overwrite' === $action ) {
		if ( ! current_user_can( 'upload_themes' ) ) {
			nx_die( __( 'Sorry, you are not allowed to install themes on this site.' ) );
		}

		check_admin_referer( 'theme-upload-cancel-overwrite' );

		// Make sure the attachment still exists, or File_Upload_Upgrader will call nx_die()
		// that shows a generic "Please select a file" error.
		if ( ! empty( $_GET['package'] ) ) {
			$attachment_id = (int) $_GET['package'];

			if ( get_post( $attachment_id ) ) {
				$file_upload = new File_Upload_Upgrader( 'themezip', 'package' );
				$file_upload->cleanup();
			}
		}

		nx_redirect( self_admin_url( 'theme-install.php' ) );
		exit;
	} else {
		/**
		 * Fires when a custom plugin or theme update request is received.
		 *
		 * The dynamic portion of the hook name, `$action`, refers to the action
		 * provided in the request for nx-admin/update.php. Can be used to
		 * provide custom update functionality for themes and plugins.
		 *
		 * @since 2.8.0
		 */
		do_action( "update-custom_{$action}" ); // phpcs:ignore NexusPress.NamingConventions.ValidHookName.UseUnderscores
	}
}
