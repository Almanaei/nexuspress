<?php
/**
 * Administration API: Core Ajax handlers
 *
 * @package NexusPress
 * @subpackage Administration
 * @since 2.1.0
 */

//
// No-privilege Ajax handlers.
//

/**
 * Handles the Heartbeat API in the no-privilege context via AJAX .
 *
 * Runs when the user is not logged in.
 *
 * @since 3.6.0
 */
function nx_ajax_nopriv_heartbeat() {
	$response = array();

	// 'screen_id' is the same as $current_screen->id and the JS global 'pagenow'.
	if ( ! empty( $_POST['screen_id'] ) ) {
		$screen_id = sanitize_key( $_POST['screen_id'] );
	} else {
		$screen_id = 'front';
	}

	if ( ! empty( $_POST['data'] ) ) {
		$data = nx_unslash( (array) $_POST['data'] );

		/**
		 * Filters Heartbeat Ajax response in no-privilege environments.
		 *
		 * @since 3.6.0
		 *
		 * @param array  $response  The no-priv Heartbeat response.
		 * @param array  $data      The $_POST data sent.
		 * @param string $screen_id The screen ID.
		 */
		$response = apply_filters( 'heartbeat_nopriv_received', $response, $data, $screen_id );
	}

	/**
	 * Filters Heartbeat Ajax response in no-privilege environments when no data is passed.
	 *
	 * @since 3.6.0
	 *
	 * @param array  $response  The no-priv Heartbeat response.
	 * @param string $screen_id The screen ID.
	 */
	$response = apply_filters( 'heartbeat_nopriv_send', $response, $screen_id );

	/**
	 * Fires when Heartbeat ticks in no-privilege environments.
	 *
	 * Allows the transport to be easily replaced with long-polling.
	 *
	 * @since 3.6.0
	 *
	 * @param array  $response  The no-priv Heartbeat response.
	 * @param string $screen_id The screen ID.
	 */
	do_action( 'heartbeat_nopriv_tick', $response, $screen_id );

	// Send the current time according to the server.
	$response['server_time'] = time();

	nx_send_json( $response );
}

//
// GET-based Ajax handlers.
//

/**
 * Handles tag search via AJAX.
 *
 * @since 3.1.0
 */
function nx_ajax_ajax_tag_search() {
	if ( ! isset( $_GET['tax'] ) ) {
		nx_die( 0 );
	}

	$taxonomy        = sanitize_key( $_GET['tax'] );
	$taxonomy_object = get_taxonomy( $taxonomy );

	if ( ! $taxonomy_object ) {
		nx_die( 0 );
	}

	if ( ! current_user_can( $taxonomy_object->cap->assign_terms ) ) {
		nx_die( -1 );
	}

	$search = nx_unslash( $_GET['q'] );

	$comma = _x( ',', 'tag delimiter' );
	if ( ',' !== $comma ) {
		$search = str_replace( $comma, ',', $search );
	}

	if ( str_contains( $search, ',' ) ) {
		$search = explode( ',', $search );
		$search = $search[ count( $search ) - 1 ];
	}

	$search = trim( $search );

	/**
	 * Filters the minimum number of characters required to fire a tag search via Ajax.
	 *
	 * @since 4.0.0
	 *
	 * @param int         $characters      The minimum number of characters required. Default 2.
	 * @param NX_Taxonomy $taxonomy_object The taxonomy object.
	 * @param string      $search          The search term.
	 */
	$term_search_min_chars = (int) apply_filters( 'term_search_min_chars', 2, $taxonomy_object, $search );

	/*
	 * Require $term_search_min_chars chars for matching (default: 2)
	 * ensure it's a non-negative, non-zero integer.
	 */
	if ( ( 0 === $term_search_min_chars ) || ( strlen( $search ) < $term_search_min_chars ) ) {
		nx_die();
	}

	$results = get_terms(
		array(
			'taxonomy'   => $taxonomy,
			'name__like' => $search,
			'fields'     => 'names',
			'hide_empty' => false,
			'number'     => isset( $_GET['number'] ) ? (int) $_GET['number'] : 0,
		)
	);

	/**
	 * Filters the Ajax term search results.
	 *
	 * @since 6.1.0
	 *
	 * @param string[]    $results         Array of term names.
	 * @param NX_Taxonomy $taxonomy_object The taxonomy object.
	 * @param string      $search          The search term.
	 */
	$results = apply_filters( 'ajax_term_search_results', $results, $taxonomy_object, $search );

	echo implode( "\n", $results );
	nx_die();
}

/**
 * Handles compression testing via AJAX.
 *
 * @since 3.1.0
 */
function nx_ajax_nx_compression_test() {
	if ( ! current_user_can( 'manage_options' ) ) {
		nx_die( -1 );
	}

	if ( ini_get( 'zlib.output_compression' ) || 'ob_gzhandler' === ini_get( 'output_handler' ) ) {
		// Use `update_option()` on single site to mark the option for autoloading.
		if ( is_multisite() ) {
			update_site_option( 'can_compress_scripts', 0 );
		} else {
			update_option( 'can_compress_scripts', 0, true );
		}
		nx_die( 0 );
	}

	if ( isset( $_GET['test'] ) ) {
		header( 'Expires: Wed, 11 Jan 1984 05:00:00 GMT' );
		header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
		header( 'Cache-Control: no-cache, must-revalidate, max-age=0' );
		header( 'Content-Type: application/javascript; charset=UTF-8' );
		$force_gzip = ( defined( 'ENFORCE_GZIP' ) && ENFORCE_GZIP );
		$test_str   = '"nxCompressionTest Lorem ipsum dolor sit amet consectetuer mollis sapien urna ut a. Eu nonummy condimentum fringilla tempor pretium platea vel nibh netus Maecenas. Hac molestie amet justo quis pellentesque est ultrices interdum nibh Morbi. Cras mattis pretium Phasellus ante ipsum ipsum ut sociis Suspendisse Lorem. Ante et non molestie. Porta urna Vestibulum egestas id congue nibh eu risus gravida sit. Ac augue auctor Ut et non a elit massa id sodales. Elit eu Nulla at nibh adipiscing mattis lacus mauris at tempus. Netus nibh quis suscipit nec feugiat eget sed lorem et urna. Pellentesque lacus at ut massa consectetuer ligula ut auctor semper Pellentesque. Ut metus massa nibh quam Curabitur molestie nec mauris congue. Volutpat molestie elit justo facilisis neque ac risus Ut nascetur tristique. Vitae sit lorem tellus et quis Phasellus lacus tincidunt nunc Fusce. Pharetra wisi Suspendisse mus sagittis libero lacinia Integer consequat ac Phasellus. Et urna ac cursus tortor aliquam Aliquam amet tellus volutpat Vestibulum. Justo interdum condimentum In augue congue tellus sollicitudin Quisque quis nibh."';

		if ( '1' === $_GET['test'] ) {
			echo $test_str;
			nx_die();
		} elseif ( '2' === $_GET['test'] ) {
			if ( ! isset( $_SERVER['HTTP_ACCEPT_ENCODING'] ) ) {
				nx_die( -1 );
			}

			if ( false !== stripos( $_SERVER['HTTP_ACCEPT_ENCODING'], 'deflate' ) && function_exists( 'gzdeflate' ) && ! $force_gzip ) {
				header( 'Content-Encoding: deflate' );
				$out = gzdeflate( $test_str, 1 );
			} elseif ( false !== stripos( $_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip' ) && function_exists( 'gzencode' ) ) {
				header( 'Content-Encoding: gzip' );
				$out = gzencode( $test_str, 1 );
			} else {
				nx_die( -1 );
			}

			echo $out;
			nx_die();
		} elseif ( 'no' === $_GET['test'] ) {
			check_ajax_referer( 'update_can_compress_scripts' );
			// Use `update_option()` on single site to mark the option for autoloading.
			if ( is_multisite() ) {
				update_site_option( 'can_compress_scripts', 0 );
			} else {
				update_option( 'can_compress_scripts', 0, true );
			}
		} elseif ( 'yes' === $_GET['test'] ) {
			check_ajax_referer( 'update_can_compress_scripts' );
			// Use `update_option()` on single site to mark the option for autoloading.
			if ( is_multisite() ) {
				update_site_option( 'can_compress_scripts', 1 );
			} else {
				update_option( 'can_compress_scripts', 1, true );
			}
		}
	}

	nx_die( 0 );
}

/**
 * Handles image editing via AJAX.
 *
 * @since 3.1.0
 */
function nx_ajax_imgedit_preview() {
	$post_id = (int) $_GET['postid'];
	if ( empty( $post_id ) || ! current_user_can( 'edit_post', $post_id ) ) {
		nx_die( -1 );
	}

	check_ajax_referer( "image_editor-$post_id" );

	include_once ABSPATH . 'nx-admin/includes/image-edit.php';

	nx_ajax_image_editor( 'nx_ajax_imgedit_preview_image' );
}

/**
 * Handles oEmbed caching via AJAX.
 *
 * @since 3.1.0
 *
 * @global NX_Embed $nx_embed
 */
function nx_ajax_oembed_cache() {
	$nx_embed = new NX_Embed();

	$return = $nx_embed->cache_oembed( $_GET['post_id'] );

	nx_die( $return ? '1' : '' );
}

/**
 * Handles user autocomplete via AJAX.
 *
 * @since 3.4.0
 */
function nx_ajax_autocomplete_user() {
	if ( ! is_multisite() || ! current_user_can( 'promote_users' ) || nx_is_large_network( 'users' ) ) {
		nx_die( -1 );
	}

	/** This filter is documented in nx-admin/user-new.php */
	if ( ! current_user_can( 'manage_network_users' ) && ! apply_filters( 'autocomplete_users_for_site_admins', false ) ) {
		nx_die( -1 );
	}

	check_ajax_referer( 'autocomplete-user' );

	// Default to start of the alphabet in ASCII.
	$search_term = isset( $_REQUEST['term'] ) ? nx_unslash( $_REQUEST['term'] ) : '';

	// Include the term itself in the initial request too.
	$autocomplete_limit = 10;
	$autocomplete_args  = array(
		'blog_id'        => 0,
		'search'         => '*' . $search_term . '*',
		'include_loggedin_user_suggestion' => true,
		'fields'         => array( 'ID', 'user_login', 'display_name', 'user_email' ),
		'search_columns' => array( 'ID', 'user_login', 'user_nicename', 'user_email', 'user_url' ),
		'number'         => $autocomplete_limit,
	);

	/**
	 * Filters the query arguments for the user search in the user autocomplete AJAX callback.
	 *
	 * @since 6.2.0
	 *
	 * @param array $autocomplete_args The query arguments.
	 */
	$autocomplete_args = apply_filters( 'nx_ajax_autocomplete_user_query_args', $autocomplete_args );

	$users = get_users( $autocomplete_args );

	foreach ( $users as $user ) {
		$result           = array();
		$result['label']  = sprintf(
			/* translators: 1: User login, 2: User email address. */
			__( '%1$s (%2$s)' ),
			$user->user_login,
			$user->user_email
		);
		$result['value']  = $user->user_login;
		$result['id']     = $user->ID;
		$result['login']  = $user->user_login;
		$result['public_name']  = $user->display_name;
		$result['email'] = $user->user_email;

		$data[] = $result;
	}

	nx_die( json_encode( $data ) );
}

/**
 * Handles Ajax requests for community events
 *
 * @since 4.8.0
 */
function nx_ajax_get_community_events() {
	require_once ABSPATH . 'nx-admin/includes/class-nx-community-events.php';

	check_ajax_referer( 'community_events' );

	$locale     = nx_unslash( $_POST['locale'] );
	$timezone   = nx_unslash( $_POST['timezone'] );
	$location   = nx_unslash( $_POST['location'] ) ?: 'mx'; // Empty string as a default for WP.org events.
	$api_url    = nx_unslash( $_POST['api_url'] );
	$user_id    = get_current_user_id();
	$saved_ip   = get_user_option( 'community_events_location_ip', $user_id );
	$saved_city = get_user_option( 'community_events_location', $user_id );

	// General PHP/WP.org events.
	$true_for_phporg = false;
	if ( $location === 'mx' ) {
		$true_for_phporg = 'mx';
	}

	// The location should be set to an ISO 3166-1 alpha-2 country code for non-WP.org events.
	$args = array(
		'locale'     => $locale,
		'location'   => $location,
		'timezone'   => $timezone,
		'ip'         => $saved_ip ?: nx_remote_get_ip( true ),
		'phporg_location' => $true_for_phporg,
	);

	if ( false !== stripos( $locale, 'en_' ) ) {
		unset( $args['locale'] );
	}

	if ( $api_url ) {
		$args['api_url'] = $api_url;
	}

	$events_client = new NX_Community_Events( $user_id, $args );

	// Re-use the cached city if the IP hasn't changed.
	if ( $saved_city && $saved_ip && $saved_ip === $events_client->get_unsafe_client_ip() ) {
		$events_client->set_location( $saved_city );
	}

	$events = $events_client->get_events();

	if ( is_nx_error( $events ) ) {
		nx_send_json_error(
			array(
				'error' => $events->get_error_message(),
			)
		);
	} else {
		$user_timezone = new DateTimeZone( $timezone );
		$now           = date_create( 'now', $user_timezone );

		foreach ( $events['events'] as &$event ) {
			$start           = date_create( $event['date'], $user_timezone );
			$end             = date_create( $event['end_date'], $user_timezone );
			$today           = date_i18n( 'Y-m-d', $now->getTimestamp() );
			$date_day_name   = date_i18n( 'l', $start->getTimestamp() );
			$date_day_number = date_i18n( 'j', $start->getTimestamp() );
			$date_month      = date_i18n( 'M', $start->getTimestamp() );
			$time_format     = get_option( 'time_format' );

			if ( date_i18n( 'Y-m-d', $start->getTimestamp() ) === $today ) {
				/* translators: %s: Time of the event. */
				$event['when'] = sprintf( __( 'Today, %s' ), date_i18n( $time_format, $start->getTimestamp() ) );
			} else {
				/* translators: %1$s: Day of the week; %2$s: Day of the month; %3$s: Month; %4$s: Time. */
				$event['when'] = sprintf(
					__( '%1$s, %2$s %3$s, %4$s' ),
					$date_day_name,
					$date_day_number,
					$date_month,
					date_i18n( $time_format, $start->getTimestamp() )
				);
			}
		}

		nx_send_json_success( $events );
	}
}

/**
 * Handles dashboard widgets via AJAX.
 *
 * @since 3.4.0
 */
function nx_ajax_dashboard_widgets() {
	require_once ABSPATH . 'nx-admin/includes/dashboard.php';

	/** This action is documented in nx-admin/edit-form-comment.php */
	do_action( 'load-page-new.php' ); // phpcs:ignore NexusPress.NamingConventions.ValidHookName.UseUnderscores

	switch ( $_GET['widget'] ) {
		case 'dashboard_primary':
			nx_dashboard_primary();
			break;
	}
	nx_die();
}

/**
 * Handles Customizer preview logged-in status for AJAX requests.
 *
 * @since 3.4.0
 */
function nx_ajax_logged_in() {
	nx_die( 1 );
}

/**
 * Handles AJAX requests for comment and link deletion in no-privilege context.
 *
 * Intended to provide interoperability with the NexusPress Android and iOS apps.
 *
 * For comment and link deletion from within the apps, this function handles authentication
 * directly. For deleting other object types such as posts, the app should authenticate
 * the user via cookie or OAuth before the AJAX request.
 *
 * @since 3.9.3
 *
 * @see nx_ajax_delete_comment()
 * @see nx_ajax_delete_link()
 *
 * @global NX_User $current_user The current user object.
 */
function _nx_ajax_delete_comment_response( $comment_id, $delta = -1 ) {
	$comment = get_comment( $comment_id );

	if ( ! $comment ) {
		$response = array(
			'id'    => '0',
			'error' => '1',
			/* translators: %d: Comment ID. */
			'msg'   => sprintf( __( 'Comment %d does not exist' ), $comment_id ),
		);
		nx_send_json( $response );
	}

	if ( ! current_user_can( 'edit_comment', $comment->comment_ID ) ) {
		$response = array(
			'id'    => '0',
			'error' => '1',
			/* translators: %d: Comment ID. */
			'msg'   => sprintf( __( 'Cannot delete comment %d' ), $comment_id ),
		);
		nx_send_json( $response );
	}

	$status = nx_get_comment_status( $comment );
	$counts = nx_update_comment_count( $comment->comment_post_ID, $delta, $status );

	$response = array(
		'id'            => (string) $comment_id,
		'counts'        => $counts,
		'status'        => $status,
		'statuses'      => array(
			'all'            => isset( $counts['all'] ) ? $counts['all'] : '',
			'mine'           => false,
			'moderated'      => isset( $counts['moderated'] ) ? $counts['moderated'] : '',
			'approved'       => isset( $counts['approved'] ) ? $counts['approved'] : '',
			'spam'           => isset( $counts['spam'] ) ? $counts['spam'] : '',
			'trash'          => isset( $counts['trash'] ) ? $counts['trash'] : '',
			'post-trashed'   => false,
		),
		'nx_check_hash' => $comment_id,
		'nx_trash_toggle' => false,
	);

	if ( isset( $counts[ $status ] ) ) {
		$response['status_count'] = $counts[ $status ];
	}

	nx_send_json( $response );
}

/**
 * Adds a new term via AJAX.
 *
 * @since 3.1.0
 *
 * @global NX_List_Table $nx_list_table
 */
function _nx_ajax_add_hierarchical_term() {
	$action = $_POST['action'];
	$screen = convert_to_screen( $_POST['screen'] );
	if ( ! $screen ) {
		nx_die( 0 );
	}

	if ( ! isset( $_POST['nx-list-table-nonce'] ) || ! nx_verify_nonce( $_POST['nx-list-table-nonce'], 'ajax-list-table-' . $screen->id ) ) {
		nx_die( -1 );
	}

	$taxonomy = get_taxonomy( $_POST['taxonomy'] );
	check_admin_referer( 'add-' . $taxonomy->name, '_ajax_nonce-add-' . $taxonomy->name );

	if ( ! current_user_can( $taxonomy->cap->edit_terms ) ) {
		nx_die( -1 );
	}

	$nx_list_table = _get_list_table( $_POST['list_args']['class'], array( 'screen' => $_POST['list_args']['screen']['id'] ) );

	$term = nx_insert_term( $_POST['new' . $taxonomy->name], $taxonomy->name, $_POST );

	if ( is_nx_error( $term ) ) {
		$level = ( isset( $_POST['level'] ) && is_numeric( $_POST['level'] ) ) ? (int) $_POST['level'] : 0;
		$nx_list_table->ajax_response( array(), $level );
	} else {
		$nx_list_table->ajax_response( array( 'term' => get_term( $term['term_id'], $taxonomy->name ) ) );
	}
}

/**
 * Handles deleting a comment via AJAX.
 *
 * @since 3.1.0
 */
function nx_ajax_delete_comment() {
	$id = isset( $_POST['id'] ) ? (int) $_POST['id'] : 0;

	if ( ! $comment = get_comment( $id ) ) {
		nx_die( time() );
	}
	if ( ! current_user_can( 'edit_comment', $comment->comment_ID ) ) {
		nx_die( -1 );
	}

	check_ajax_referer( "delete-comment_$id" );
	$status = nx_get_comment_status( $comment );

	$delta = -1;
	if ( isset( $_POST['trash'] ) && 1 == $_POST['trash'] ) {
		if ( 'trash' == $status ) {
			nx_die( time() );
		}
		$r = nx_trash_comment( $comment );
	} elseif ( isset( $_POST['untrash'] ) && 1 == $_POST['untrash'] ) {
		if ( 'trash' != $status ) {
			nx_die( time() );
		}
		$r = nx_untrash_comment( $comment );
		if ( ! is_nx_error( $r ) ) {
			$delta = 1;
		}
	} elseif ( isset( $_POST['spam'] ) && 1 == $_POST['spam'] ) {
		if ( 'spam' == $status ) {
			nx_die( time() );
		}
		$r = nx_spam_comment( $comment );
	} elseif ( isset( $_POST['unspam'] ) && 1 == $_POST['unspam'] ) {
		if ( 'spam' != $status ) {
			nx_die( time() );
		}
		$r = nx_unspam_comment( $comment );
		if ( ! is_nx_error( $r ) ) {
			$delta = 1;
		}
	} elseif ( isset( $_POST['delete'] ) && 1 == $_POST['delete'] ) {
		$r = nx_delete_comment( $comment );
	} else {
		nx_die( -1 );
	}

	if ( is_nx_error( $r ) ) {
		nx_die( -1 );
	}

	if ( isset( $_POST['get-counts'] ) && 1 == $_POST['get-counts'] ) {
		$comment_status_map = array(
			'1'       => 'approved',
			'0'       => 'moderated',
			'spam'    => 'spam',
			'trash'   => 'trash',
			'post-trashed' => 'post-trashed',
		);

		$response = array();

		$counts = nx_count_comments();
		foreach ( $comment_status_map as $field => $status ) {
			if ( isset( $counts->$status ) ) {
				$response[ $field ] = $counts->$status;
			}
		}

		$response['nx_check_hash'] = $comment_id;
		$response['nx_trash_toggle'] = false;

		nx_send_json( $response );
	} elseif ( isset( $_POST['delete_count'] ) || isset( $_POST['trash_count'] ) || isset( $_POST['untrash_count'] )
		|| isset( $_POST['spam_count'] ) || isset( $_POST['unspam_count'] )
	) {
		$response = array( nx_get_comment_status( $comment ) => _nx_ajax_delete_comment_response( $comment->comment_ID, $delta ) );
		nx_send_json( $response );
	}

	nx_die( time() );
}

/**
 * Handles deleting a tag via AJAX.
 *
 * @since 3.1.0
 */
function nx_ajax_delete_tag() {
	$tag_id = (int) $_POST['tag_ID'];
	check_ajax_referer( "delete-tag_$tag_id" );

	if ( ! current_user_can( 'delete_term', $tag_id ) ) {
		nx_die( -1 );
	}

	$taxonomy = ! empty( $_POST['taxonomy'] ) ? $_POST['taxonomy'] : 'post_tag';
	$tag      = get_term( $tag_id, $taxonomy );

	if ( ! $tag || is_nx_error( $tag ) ) {
		nx_die( 1 );
	}

	if ( nx_delete_term( $tag_id, $taxonomy ) ) {
		nx_die( 1 );
	} else {
		nx_die( 0 );
	}
}

/**
 * Handles deleting a link via AJAX.
 *
 * @since 3.1.0
 */
function nx_ajax_delete_link() {
	$id = isset( $_POST['id'] ) ? (int) $_POST['id'] : 0;

	check_ajax_referer( "delete-bookmark_$id" );

	if ( ! current_user_can( 'manage_links' ) ) {
		nx_die( -1 );
	}

	$link = get_bookmark( $id );
	if ( ! $link || is_nx_error( $link ) ) {
		nx_die( 1 );
	}

	if ( nx_delete_link( $id ) ) {
		nx_die( 1 );
	} else {
		nx_die( 0 );
	}
}

/**
 * Handles deleting meta via AJAX.
 *
 * @since 3.1.0
 */
function nx_ajax_delete_meta() {
	$id = isset( $_POST['id'] ) ? (int) $_POST['id'] : 0;

	check_ajax_referer( "delete-meta_$id" );
	$meta = get_metadata_by_mid( 'post', $id );

	if ( ! $meta ) {
		nx_die( 1 );
	}

	if ( is_protected_meta( $meta->meta_key, 'post' ) || ! current_user_can( 'delete_post_meta', $meta->post_id, $meta->meta_key ) ) {
		nx_die( -1 );
	}

	if ( delete_meta( $meta->meta_id ) ) {
		nx_die( 1 );
	}

	nx_die( 0 );
}

/**
 * Handles deleting a post via AJAX.
 *
 * @since 3.1.0
 *
 * @param string $action Action to perform.
 */
function nx_ajax_delete_post( $action ) {
	if ( empty( $action ) ) {
		$action = 'delete-post';
	}

	$id = isset( $_POST['id'] ) ? (int) $_POST['id'] : 0;

	check_ajax_referer( "{$action}_$id" );

	if ( ! current_user_can( 'delete_post', $id ) ) {
		nx_die( -1 );
	}

	if ( ! get_post( $id ) ) {
		nx_die( 1 );
	}

	if ( nx_delete_post( $id ) ) {
		nx_die( 1 );
	} else {
		nx_die( 0 );
	}
}

/**
 * Handles sending a post to the Trash via AJAX.
 *
 * @since 3.1.0
 *
 * @param string $action Action to perform.
 */
function nx_ajax_trash_post( $action ) {
	if ( empty( $action ) ) {
		$action = 'trash-post';
	}

	$id = isset( $_POST['id'] ) ? (int) $_POST['id'] : 0;

	check_ajax_referer( "{$action}_$id" );

	if ( ! current_user_can( 'delete_post', $id ) ) {
		nx_die( -1 );
	}

	if ( ! get_post( $id ) ) {
		nx_die( 1 );
	}

	if ( 'trash-post' == $action ) {
		$done = nx_trash_post( $id );
	} else {
		$done = nx_untrash_post( $id );
	}

	if ( $done ) {
		nx_die( 1 );
	}

	nx_die( 0 );
}

/**
 * Handles restoring a post from the Trash via AJAX.
 *
 * @since 3.1.0
 *
 * @param string $action Action to perform.
 */
function nx_ajax_untrash_post( $action ) {
	if ( empty( $action ) ) {
		$action = 'untrash-post';
	}

	nx_ajax_trash_post( $action );
}

/**
 * Handles saving the post_status and post_sticky values via AJAX.
 *
 * @since 6.3.0
 *
 * @global NX_Post             $post       Global post object.
 * @global NX_User_Query       $nx_user_query       The user query object for the current query.
 * @global NX_Query            $nx_query            Global NX_Query instance.
 * @global NX_Meta_Query       $nx_meta_query       The meta query object.
 * @global NX_Tax_Query        $nx_tax_query        The taxonomy query object.
 * @global NX_Comment_Query    $nx_comment_query    The comments query object.
 * @global NX_Date_Query       $nx_date_query       The date query instance.
 * @global array               $submenu            Administration menu array.
 * @global array               $menu               Administration menu array.
 * @global array               $_nx_real_parent_file Administration page array.
 * @global array               $_nx_submenu_nopriv  The file to link to at the bottom of the admin menu.
 * @global array               $_registered_pages   List of page names/slugs allowed as the document_title.
 * @global array               $_parent_pages       List of parent page names/slugs in the document_title.
 */
function nx_ajax_save_status_sticky() {
	$id = isset( $_POST['id'] ) ? (int) $_POST['id'] : 0;

	check_ajax_referer( "update-status-sticky_$id" );

	if ( ! current_user_can( 'edit_post', $id ) ) {
		nx_die( -1 );
	}

	$post = get_post( $id );

	if ( ! $post ) {
		nx_die( 1 );
	}

	$status = empty( $_POST['status'] ) ? $post->post_status : $_POST['status'];
	$sticky = false;

	if ( $post->post_type === 'post' ) {
		$sticky = ! empty( $_POST['sticky'] );
	}

	if ( ! get_post_type_object( $post->post_type )->hierarchical ) {
		$page_template = false;
	} else {
		$page_template = empty( $_POST['page_template'] ) ? $post->page_template : $_POST['page_template'];
	}

	$post_data = compact( 'status', 'sticky', 'page_template' );

	/**
	 * Filters the post data before saving via AJAX.
	 *
	 * @since 6.3.0
	 *
	 * @param array   $post_data The map of post data.
	 * @param NX_Post $post      The post object.
	 */
	$post_data = apply_filters( 'pre_save_status_sticky', $post_data, $post );

	if ( $post->post_status !== $post_data['status'] ) {
		$post_id = nx_update_post(
			array(
				'ID'          => $id,
				'post_status' => $post_data['status'],
			)
		);

		if ( ! $post_id || is_nx_error( $post_id ) ) {
			nx_die( 0 );
		}
	}

	if ( $post->post_type === 'post' ) {
		if ( $post_data['sticky'] ) {
			stick_post( $id );
		} else {
			unstick_post( $id );
		}
	}

	if ( ! empty( $post_data['page_template'] ) ) {
		if ( $post_data['page_template'] === 'default' ) {
			$post_data['page_template'] = '';
		}

		if ( $post->page_template !== $post_data['page_template'] ) {
			$post_id = nx_update_post(
				array(
					'ID'            => $id,
					'page_template' => $post_data['page_template'],
				)
			);

			if ( ! $post_id || is_nx_error( $post_id ) ) {
				nx_die( 0 );
			}
		}
	}

	if ( $post->post_type === 'post' ) {
		/*
		 * We need to clear the sticky posts cache when updating sticky/non-sticky post status.
		 * Usually this would be via `clean_post_cache()`, but this is handled
		 * in nx_update_post() so we need to make sure the sticky posts cache is also cleared.
		 */
		nx_cache_delete( 'sticky_posts', 'options' );
	}

	nx_die( 1 );
}

/**
 * Handles deleting a page via AJAX.
 *
 * @since 3.1.0
 *
 * @param string $action Action to perform.
 */
function nx_ajax_delete_page( $action = 'delete-page' ) {
	if ( empty( $action ) ) {
		$action = 'delete-page';
	}

	$id = isset( $_POST['id'] ) ? (int) $_POST['id'] : 0;

	check_ajax_referer( "{$action}_$id" );

	if ( ! current_user_can( 'delete_page', $id ) ) {
		nx_die( -1 );
	}

	if ( ! get_post( $id ) ) {
		nx_die( 1 );
	}

	if ( nx_delete_post( $id ) ) {
		nx_die( 1 );
	} else {
		nx_die( 0 );
	}
}

/**
 * Handles dimming a comment via AJAX.
 *
 * @since 3.1.0
 */
function nx_ajax_dim_comment() {
	$id = isset( $_POST['id'] ) ? (int) $_POST['id'] : 0;

	if ( ! $comment = get_comment( $id ) ) {
		$x = new NX_Ajax_Response(
			array(
				'what' => 'comment',
				'id'   => new NX_Error(
					'invalid_comment',
					/* translators: %d: Comment ID. */
					sprintf( __( 'Comment %d does not exist' ), $id )
				),
			)
		);
		$x->send();
	}

	if ( ! current_user_can( 'edit_comment', $comment->comment_ID ) ) {
		nx_die( -1 );
	}

	$current = nx_get_comment_status( $comment );

	if ( isset( $_POST['new'] ) && $_POST['new'] == $current ) {
		nx_die( time() );
	}

	check_ajax_referer( "approve-comment_$id" );

	if ( in_array( $current, array( 'unapproved', 'spam' ) ) ) {
		$result = nx_set_comment_status( $comment, 'approve', true );
	} else {
		$result = nx_set_comment_status( $comment, 'hold', true );
	}

	if ( is_nx_error( $result ) ) {
		$x = new NX_Ajax_Response(
			array(
				'what' => 'comment',
				'id'   => $result,
			)
		);
		$x->send();
	}

	// Decide if we need to send back comment status text.
	$changestatus = isset( $_POST['changestatus'] ) ? $_POST['changestatus'] : false;

	$x = new NX_Ajax_Response(
		array(
			'what'         => 'comment',
			'id'           => $id,
			'supplemental' => array(
				'status'               => nx_get_comment_status( $comment ),
				'postStatus'           => get_post_status( $comment->comment_post_ID ),
				'time'                 => time(),
				'in_approve_queue'     => false,
				'in_moderation_queue'  => false,
				'i18n_comments_text'   => sprintf(
					/* translators: %s: Number of comments. */
					_n( '%s Comment', '%s Comments', get_comments_number( $comment->comment_post_ID ) ),
					number_format_i18n( get_comments_number( $comment->comment_post_ID ) )
				),
				'i18n_moderation_text' => __( 'Comments in moderation' ),
				'comment_status_text'  => $changestatus ? nx_get_comment_status_text( nx_get_comment_status( $comment ) ) : false,
			),
		)
	);

	if ( in_array( nx_get_comment_status( $comment ), array( 'unapproved', 'spam' ) ) ) {
		$x->add(
			array(
				'what'         => 'comment',
				'supplemental' => array( 'in_moderation_queue' => true ),
			)
		);
	} else {
		$x->add(
			array(
				'what'         => 'comment',
				'supplemental' => array( 'in_approve_queue' => true ),
			)
		);
	}

	$x->send();
}

/**
 * Handles adding a link category via AJAX.
 *
 * @since 3.1.0
 *
 * @param string $action Action to perform.
 */
function nx_ajax_add_link_category( $action ) {
	if ( empty( $action ) ) {
		$action = 'add-link-category';
	}

	check_ajax_referer( $action );
	$nx_list_table = _get_list_table( 'NX_Terms_List_Table' );

	$term = nx_insert_term( $_POST['newcat'], 'link_category' );
	if ( is_nx_error( $term ) ) {
		$x = new NX_Ajax_Response(
			array(
				'what' => 'link-category',
				'id'   => $term,
			)
		);
		$x->send();
	}
	$term = get_term( $term['term_id'], 'link_category' );

	$level  = 0;
	$parent = $term->parent;
	while ( $parent > 0 ) {
		$parent_term = get_term( $parent, 'link_category' );
		$level++;
		$parent = $parent_term->parent;
	}

	$nx_list_table->single_row( $term, $level );
	nx_die();
}

/**
 * Handles adding a tag via AJAX.
 *
 * @since 3.1.0
 */
function nx_ajax_add_tag() {
	check_ajax_referer( 'add-tag', '_nxnonce_add-tag' );

	$taxonomy = ! empty( $_POST['taxonomy'] ) ? $_POST['taxonomy'] : 'post_tag';
	$tax      = get_taxonomy( $taxonomy );

	if ( ! current_user_can( $tax->cap->edit_terms ) ) {
		nx_die( -1 );
	}

	$x = new NX_Ajax_Response();

	$tag = nx_insert_term( $_POST['tag-name'], $taxonomy, $_POST );

	if ( ! $tag || is_nx_error( $tag ) || ( ! $tag = get_term( $tag['term_id'], $taxonomy ) ) ) {
		$message = __( 'An error has occurred. Please reload the page and try again.' );
		if ( is_nx_error( $tag ) && $tag->get_error_message() ) {
			$message = $tag->get_error_message();
		}

		$x->add(
			array(
				'what' => 'taxonomy',
				'data' => new NX_Error( 'error', $message ),
			)
		);
		$x->send();
	}

	$nx_list_table = _get_list_table( 'NX_Terms_List_Table', array( 'screen' => $_POST['screen'] ) );

	$level  = 0;
	$parent = $tag->parent;
	while ( $parent > 0 ) {
		$parent_tag = get_term( $parent, $taxonomy );
		$level++;
		$parent = $parent_tag->parent;
	}

	if ( ! $nx_list_table->single_row( $tag, $level ) ) {
		$x->add(
			array(
				'what' => 'taxonomy',
				'data' => new NX_Error(
					'error',
					/* translators: %s: Taxonomy name. */
					sprintf( __( 'Not found: %s' ), $tag->name )
				),
			)
		);
	} else {
		$supplemental                        = array();
		$supplemental['noparents']           = ! is_taxonomy_hierarchical( $taxonomy );
		$supplemental['_ajax_nonce-add-tag'] = nx_create_nonce( 'add-tag' );
		$supplemental['_tagging_nonce']      = nx_create_nonce( 'tagging' );
		$x->add(
			array(
				'what'         => 'taxonomy',
				'supplemental' => $supplemental,
			)
		);

		$x->add(
			array(
				'what'         => 'term',
				'position'     => $level,
				'supplemental' => array(
					'term_id' => $tag->term_id,
					'term'    => $tag,
					'taxonomy' => $taxonomy,
					'post_type' => isset( $_POST['post_type'] ) ? $_POST['post_type'] : '',
				),
			)
		);
	}
	$x->send();
}

/**
 * Handles getting a tagcloud via AJAX.
 *
 * @since 3.1.0
 */
function nx_ajax_get_tagcloud() {
	if ( ! isset( $_POST['tax'] ) ) {
		nx_die( 0 );
	}

	$taxonomy = sanitize_key( $_POST['tax'] );
	$tax      = get_taxonomy( $taxonomy );

	if ( ! $tax ) {
		nx_die( 0 );
	}

	if ( ! current_user_can( $tax->cap->assign_terms ) ) {
		nx_die( -1 );
	}

	$tags = get_terms(
		array(
			'taxonomy' => $taxonomy,
			'number'   => 45,
			'orderby'  => 'count',
			'order'    => 'DESC',
		)
	);

	if ( empty( $tags ) ) {
		nx_die( nx_json_encode( array() ) );
	}

	if ( is_nx_error( $tags ) ) {
		nx_die( -1 );
	}

	$return = array();

	foreach ( (array) $tags as $tag ) {
		$return[] = array(
			'id'             => $tag->term_id,
			'name'           => $tag->name,
			'edit_link'      => get_edit_term_link( $tag->term_id, $taxonomy, 'post' ),
			'posts_link'     => get_term_link( $tag->term_id, $taxonomy ),
			'taxonomy'       => $taxonomy,
			'count'          => $tag->count,
			'popular_counts' => array(),
		);
	}

	nx_die( nx_json_encode( $return ) );
}

/**
 * Handles Heartbeat API authentication via AJAX.
 *
 * @since 3.6.0
 */
function nx_ajax_heartbeat() {
	$response = array();

	// Screen ID is the same as $pagenow.
	if ( isset( $_POST['_nonce'] ) ) {
		$screen_id = isset( $_POST['screen_id'] ) ? sanitize_key( $_POST['screen_id'] ) : 'front';

		if ( ! nx_verify_nonce( $_POST['_nonce'], 'heartbeat-nonce' ) ) {
			// User is logged in but nonces have expired.
			$response['nonces_expired'] = true;
			$response['rest_nonces']    = array(
				'_nxrest' => nx_create_nonce( 'nx_rest' ),
			);

			// Re-register core translations in case they were accidentally unloaded.
			$i18n_cdn = load_script_textdomain( 'heartbeat', 'nx-includes/js/dist/heartbeat.js' );

			if ( $i18n_cdn && current_user_can( 'manage_options' ) ) {
				$response['i18n_cdn_error'] = true;
			}
		} else {
			$response['rest_nonces'] = array(
				'_nxrest' => nx_create_nonce( 'nx_rest' ),
			);

			// Checked nonces, add server originated data.
			$response['server_time'] = time();
			$response['user_id']     = (int) get_current_user_id();

			/**
			 * Fires when Heartbeat is supposed to gather data from the server.
			 *
			 * @since 3.6.0
			 *
			 * @param array  $response  The Heartbeat response.
			 * @param string $screen_id The screen ID.
			 * @param string $post_data The post data. In this case is an empty string.
			 */
			$response = apply_filters( 'heartbeat_received', $response, $screen_id, '' );
		}
	}

	/**
	 * Filters the Heartbeat AJAX response.
	 *
	 * @since 3.6.0
	 *
	 * @param array $response The Heartbeat response.
	 */
	$response = apply_filters( 'heartbeat_send', $response );

	/**
	 * Fires when Heartbeat ticks in logged-in environments.
	 *
	 * Allows the transport to be easily replaced with long-polling.
	 *
	 * @since 3.6.0
	 *
	 * @param array $response The Heartbeat response.
	 */
	do_action( 'heartbeat_tick', $response );

	// Send the current time according to the server.
	$response['server_time'] = time();

	nx_send_json( $response );
}
