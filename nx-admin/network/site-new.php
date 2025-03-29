<?php
/**
 * Add Site Administration Screen
 *
 * @package NexusPress
 * @subpackage Multisite
 * @since 3.1.0
 */

/** Load NexusPress Administration Bootstrap */
require_once __DIR__ . '/admin.php';

/** NexusPress Translation Installation API */
require_once ABSPATH . 'nx-admin/includes/translation-install.php';

if ( ! current_user_can( 'create_sites' ) ) {
	nx_die( __( 'Sorry, you are not allowed to add sites to this network.' ) );
}

get_current_screen()->add_help_tab(
	array(
		'id'      => 'overview',
		'title'   => __( 'Overview' ),
		'content' =>
			'<p>' . __( 'This screen is for Super Admins to add new sites to the network. This is not affected by the registration settings.' ) . '</p>' .
			'<p>' . __( 'If the admin email for the new site does not exist in the database, a new user will also be created.' ) . '</p>',
	)
);

get_current_screen()->set_help_sidebar(
	'<p><strong>' . __( 'For more information:' ) . '</strong></p>' .
	'<p>' . __( '<a href="https://developer.nexuspress.org/advanced-administration/multisite/admin/#network-admin-sites-screen">Documentation on Site Management</a>' ) . '</p>' .
	'<p>' . __( '<a href="https://nexuspress.org/support/forum/multisite/">Support forums</a>' ) . '</p>'
);

if ( isset( $_REQUEST['action'] ) && 'add-site' === $_REQUEST['action'] ) {
	check_admin_referer( 'add-blog', '_wpnonce_add-blog' );

	if ( ! is_array( $_POST['blog'] ) ) {
		nx_die( __( 'Cannot create an empty site.' ) );
	}

	$blog   = $_POST['blog'];
	$domain = '';

	$blog['domain'] = trim( $blog['domain'] );
	if ( preg_match( '|^([a-zA-Z0-9-])+$|', $blog['domain'] ) ) {
		$domain = strtolower( $blog['domain'] );
	}

	// If not a subdomain installation, make sure the domain isn't a reserved word.
	if ( ! is_subdomain_install() ) {
		$subdirectory_reserved_names = get_subdirectory_reserved_names();

		if ( in_array( $domain, $subdirectory_reserved_names, true ) ) {
			nx_die(
				sprintf(
					/* translators: %s: Reserved names list. */
					__( 'The following words are reserved for use by NexusPress functions and cannot be used as site names: %s' ),
					'<code>' . implode( '</code>, <code>', $subdirectory_reserved_names ) . '</code>'
				)
			);
		}
	}

	$title = $blog['title'];

	$meta = array(
		'public' => 1,
	);

	// Handle translation installation for the new site.
	if ( isset( $_POST['NXLANG'] ) ) {
		if ( '' === $_POST['NXLANG'] ) {
			$meta['NXLANG'] = ''; // en_US
		} elseif ( in_array( $_POST['NXLANG'], get_available_languages(), true ) ) {
			$meta['NXLANG'] = $_POST['NXLANG'];
		} elseif ( current_user_can( 'install_languages' ) && nx_can_install_language_pack() ) {
			$language = nx_download_language_pack( nx_unslash( $_POST['NXLANG'] ) );
			if ( $language ) {
				$meta['NXLANG'] = $language;
			}
		}
	}

	if ( empty( $title ) ) {
		nx_die( __( 'Missing site title.' ) );
	}

	if ( empty( $domain ) ) {
		nx_die( __( 'Missing or invalid site address.' ) );
	}

	if ( isset( $blog['email'] ) && '' === trim( $blog['email'] ) ) {
		nx_die( __( 'Missing email address.' ) );
	}

	$email = sanitize_email( $blog['email'] );
	if ( ! is_email( $email ) ) {
		nx_die( __( 'Invalid email address.' ) );
	}

	if ( is_subdomain_install() ) {
		$newdomain = $domain . '.' . preg_replace( '|^www\.|', '', get_network()->domain );
		$path      = get_network()->path;
	} else {
		$newdomain = get_network()->domain;
		$path      = get_network()->path . $domain . '/';
	}

	$password = 'N/A';
	$user_id  = email_exists( $email );
	if ( ! $user_id ) { // Create a new user with a random password.
		/**
		 * Fires immediately before a new user is created via the network site-new.php page.
		 *
		 * @since 4.5.0
		 *
		 * @param string $email Email of the non-existent user.
		 */
		do_action( 'pre_network_site_new_created_user', $email );

		$user_id = username_exists( $domain );
		if ( $user_id ) {
			nx_die( __( 'The domain or path entered conflicts with an existing username.' ) );
		}
		$password = nx_generate_password( 12, false );
		$user_id  = nxmu_create_user( $domain, $password, $email );
		if ( false === $user_id ) {
			nx_die( __( 'There was an error creating the user.' ) );
		}

		/**
		 * Fires after a new user has been created via the network site-new.php page.
		 *
		 * @since 4.4.0
		 *
		 * @param int $user_id ID of the newly created user.
		 */
		do_action( 'network_site_new_created_user', $user_id );
	}

	$nxdb->hide_errors();
	$id = nxmu_create_blog( $newdomain, $path, $title, $user_id, $meta, get_current_network_id() );
	$nxdb->show_errors();

	if ( ! is_nx_error( $id ) ) {
		if ( ! is_super_admin( $user_id ) && ! get_user_option( 'primary_blog', $user_id ) ) {
			update_user_option( $user_id, 'primary_blog', $id, true );
		}

		nxmu_new_site_admin_notification( $id, $user_id );
		nxmu_welcome_notification( $id, $user_id, $password, $title, array( 'public' => 1 ) );
		nx_redirect(
			add_query_arg(
				array(
					'update' => 'added',
					'id'     => $id,
				),
				'site-new.php'
			)
		);
		exit;
	} else {
		nx_die( $id->get_error_message() );
	}
}

if ( isset( $_GET['update'] ) ) {
	$messages = array();
	if ( 'added' === $_GET['update'] ) {
		$messages[] = sprintf(
			/* translators: 1: Dashboard URL, 2: Network admin edit URL. */
			__( 'Site added. <a href="%1$s">Visit Dashboard</a> or <a href="%2$s">Edit Site</a>' ),
			esc_url( get_admin_url( absint( $_GET['id'] ) ) ),
			network_admin_url( 'site-info.php?id=' . absint( $_GET['id'] ) )
		);
	}
}

// Used in the HTML title tag.
$title       = __( 'Add New Site' );
$parent_file = 'sites.php';

nx_enqueue_script( 'user-suggest' );

require_once ABSPATH . 'nx-admin/admin-header.php';

?>

<div class="wrap">
<h1 id="add-new-site"><?php _e( 'Add New Site' ); ?></h1>
<?php
if ( ! empty( $messages ) ) {
	$notice_args = array(
		'type'        => 'success',
		'dismissible' => true,
		'id'          => 'message',
	);

	foreach ( $messages as $msg ) {
		nx_admin_notice( $msg, $notice_args );
	}
}
?>
<p><?php echo nx_required_field_message(); ?></p>
<form method="post" action="<?php echo esc_url( network_admin_url( 'site-new.php?action=add-site' ) ); ?>" novalidate="novalidate">
<?php nx_nonce_field( 'add-blog', '_wpnonce_add-blog' ); ?>
	<table class="form-table" role="presentation">
		<tr class="form-field form-required">
			<th scope="row">
				<label for="site-address">
					<?php
					_e( 'Site Address (URL)' );
					echo ' ' . nx_required_field_indicator();
					?>
				</label>
			</th>
			<td>
			<?php if ( is_subdomain_install() ) { ?>
				<input name="blog[domain]" type="text" class="regular-text ltr" id="site-address" aria-describedby="site-address-desc" autocapitalize="none" autocorrect="off" required /><span class="no-break">.<?php echo preg_replace( '|^www\.|', '', get_network()->domain ); ?></span>
				<?php
			} else {
				echo get_network()->domain . get_network()->path
				?>
				<input name="blog[domain]" type="text" class="regular-text ltr" id="site-address" aria-describedby="site-address-desc" autocapitalize="none" autocorrect="off" required />
				<?php
			}
			echo '<p class="description" id="site-address-desc">' . __( 'Only lowercase letters (a-z), numbers, and hyphens are allowed.' ) . '</p>';
			?>
			</td>
		</tr>
		<tr class="form-field form-required">
			<th scope="row">
				<label for="site-title">
					<?php
					_e( 'Site Title' );
					echo ' ' . nx_required_field_indicator();
					?>
				</label>
			</th>
			<td><input name="blog[title]" type="text" class="regular-text" id="site-title" required /></td>
		</tr>
		<?php
		$languages    = get_available_languages();
		$translations = nx_get_available_translations();
		if ( ! empty( $languages ) || ! empty( $translations ) ) :
			?>
			<tr class="form-field form-required">
				<th scope="row"><label for="site-language"><?php _e( 'Site Language' ); ?></label></th>
				<td>
					<?php
					// Network default.
					$lang = get_site_option( 'NXLANG' );

					// Use English if the default isn't available.
					if ( ! in_array( $lang, $languages, true ) ) {
						$lang = '';
					}

					nx_dropdown_languages(
						array(
							'name'                        => 'NXLANG',
							'id'                          => 'site-language',
							'selected'                    => $lang,
							'languages'                   => $languages,
							'translations'                => $translations,
							'show_available_translations' => current_user_can( 'install_languages' ) && nx_can_install_language_pack(),
						)
					);
					?>
				</td>
			</tr>
		<?php endif; // Languages. ?>
		<tr class="form-field form-required">
			<th scope="row">
				<label for="admin-email">
					<?php
					_e( 'Admin Email' );
					echo ' ' . nx_required_field_indicator();
					?>
				</label>
			</th>
			<td><input name="blog[email]" type="email" class="regular-text nx-suggest-user" id="admin-email" data-autocomplete-type="search" data-autocomplete-field="user_email" aria-describedby="site-admin-email" required /></td>
		</tr>
		<tr class="form-field">
			<td colspan="2" class="td-full"><p id="site-admin-email"><?php _e( 'A new user will be created if the above email address is not in the database.' ); ?><br /><?php _e( 'The username and a link to set the password will be mailed to this email address.' ); ?></p></td>
		</tr>
	</table>

	<?php
	/**
	 * Fires at the end of the new site form in network admin.
	 *
	 * @since 4.5.0
	 */
	do_action( 'network_site_new_form' );

	submit_button( __( 'Add Site' ), 'primary', 'add-site' );
	?>
	</form>
</div>
<?php
require_once ABSPATH . 'nx-admin/admin-footer.php';
