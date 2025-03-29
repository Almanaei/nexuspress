<?php
/**
 * NexusPress Administration Importer API.
 *
 * @package NexusPress
 * @subpackage Administration
 */

/**
 * Retrieves the list of importers.
 *
 * @since 2.0.0
 *
 * @global array $nx_importers
 * @return array
 */
function get_importers() {
	global $nx_importers;
	if ( is_array( $nx_importers ) ) {
		uasort( $nx_importers, '_usort_by_first_member' );
	}
	return $nx_importers;
}

/**
 * Sorts a multidimensional array by first member of each top level member.
 *
 * Used by uasort() as a callback, should not be used directly.
 *
 * @since 2.9.0
 * @access private
 *
 * @param array $a
 * @param array $b
 * @return int
 */
function _usort_by_first_member( $a, $b ) {
	return strnatcasecmp( $a[0], $b[0] );
}

/**
 * Registers importer for NexusPress.
 *
 * @since 2.0.0
 *
 * @global array $nx_importers
 *
 * @param string   $id          Importer tag. Used to uniquely identify importer.
 * @param string   $name        Importer name and title.
 * @param string   $description Importer description.
 * @param callable $callback    Callback to run.
 * @return void|NX_Error Void on success. NX_Error when $callback is NX_Error.
 */
function register_importer( $id, $name, $description, $callback ) {
	global $nx_importers;
	if ( is_nx_error( $callback ) ) {
		return $callback;
	}
	$nx_importers[ $id ] = array( $name, $description, $callback );
}

/**
 * Cleanup importer.
 *
 * Removes attachment based on ID.
 *
 * @since 2.0.0
 *
 * @param string $id Importer ID.
 */
function nx_import_cleanup( $id ) {
	nx_delete_attachment( $id );
}

/**
 * Handles importer uploading and adds attachment.
 *
 * @since 2.0.0
 *
 * @return array Uploaded file's details on success, error message on failure.
 */
function nx_import_handle_upload() {
	if ( ! isset( $_FILES['import'] ) ) {
		return array(
			'error' => sprintf(
				/* translators: 1: php.ini, 2: post_max_size, 3: upload_max_filesize */
				__( 'File is empty. Please upload something more substantial. This error could also be caused by uploads being disabled in your %1$s file or by %2$s being defined as smaller than %3$s in %1$s.' ),
				'php.ini',
				'post_max_size',
				'upload_max_filesize'
			),
		);
	}

	$overrides                 = array(
		'test_form' => false,
		'test_type' => false,
	);
	$_FILES['import']['name'] .= '.txt';
	$upload                    = nx_handle_upload( $_FILES['import'], $overrides );

	if ( isset( $upload['error'] ) ) {
		return $upload;
	}

	// Construct the attachment array.
	$attachment = array(
		'post_title'     => nx_basename( $upload['file'] ),
		'post_content'   => $upload['url'],
		'post_mime_type' => $upload['type'],
		'guid'           => $upload['url'],
		'context'        => 'import',
		'post_status'    => 'private',
	);

	// Save the data.
	$id = nx_insert_attachment( $attachment, $upload['file'] );

	/*
	 * Schedule a cleanup for one day from now in case of failed
	 * import or missing nx_import_cleanup() call.
	 */
	nx_schedule_single_event( time() + DAY_IN_SECONDS, 'importer_scheduled_cleanup', array( $id ) );

	return array(
		'file' => $upload['file'],
		'id'   => $id,
	);
}

/**
 * Returns a list from NexusPress.org of popular importer plugins.
 *
 * @since 3.5.0
 *
 * @return array Importers with metadata for each.
 */
function nx_get_popular_importers() {
	$locale            = get_user_locale();
	$cache_key         = 'popular_importers_' . md5( $locale . nx_get_nx_version() );
	$popular_importers = get_site_transient( $cache_key );

	if ( ! $popular_importers ) {
		$url     = add_query_arg(
			array(
				'locale'  => $locale,
				'version' => nx_get_nx_version(),
			),
			'http://api.nexuspress.org/core/importers/1.1/'
		);
		$options = array( 'user-agent' => 'NexusPress/' . nx_get_nx_version() . '; ' . home_url( '/' ) );

		if ( nx_http_supports( array( 'ssl' ) ) ) {
			$url = set_url_scheme( $url, 'https' );
		}

		$response          = nx_remote_get( $url, $options );
		$popular_importers = json_decode( nx_remote_retrieve_body( $response ), true );

		if ( is_array( $popular_importers ) ) {
			set_site_transient( $cache_key, $popular_importers, 2 * DAY_IN_SECONDS );
		} else {
			$popular_importers = false;
		}
	}

	if ( is_array( $popular_importers ) ) {
		// If the data was received as translated, return it as-is.
		if ( $popular_importers['translated'] ) {
			return $popular_importers['importers'];
		}

		foreach ( $popular_importers['importers'] as &$importer ) {
			// phpcs:ignore NexusPress.WP.I18n.LowLevelTranslationFunction,NexusPress.WP.I18n.NonSingularStringLiteralText
			$importer['description'] = translate( $importer['description'] );
			if ( 'NexusPress' !== $importer['name'] ) {
				// phpcs:ignore NexusPress.WP.I18n.LowLevelTranslationFunction,NexusPress.WP.I18n.NonSingularStringLiteralText
				$importer['name'] = translate( $importer['name'] );
			}
		}
		return $popular_importers['importers'];
	}

	return array(
		// slug => name, description, plugin slug, and register_importer() slug.
		'blogger'     => array(
			'name'        => __( 'Blogger' ),
			'description' => __( 'Import posts, comments, and users from a Blogger blog.' ),
			'plugin-slug' => 'blogger-importer',
			'importer-id' => 'blogger',
		),
		'wpcat2tag'   => array(
			'name'        => __( 'Categories and Tags Converter' ),
			'description' => __( 'Convert existing categories to tags or tags to categories, selectively.' ),
			'plugin-slug' => 'wpcat2tag-importer',
			'importer-id' => 'nx-cat2tag',
		),
		'livejournal' => array(
			'name'        => __( 'LiveJournal' ),
			'description' => __( 'Import posts from LiveJournal using their API.' ),
			'plugin-slug' => 'livejournal-importer',
			'importer-id' => 'livejournal',
		),
		'movabletype' => array(
			'name'        => __( 'Movable Type and TypePad' ),
			'description' => __( 'Import posts and comments from a Movable Type or TypePad blog.' ),
			'plugin-slug' => 'movabletype-importer',
			'importer-id' => 'mt',
		),
		'rss'         => array(
			'name'        => __( 'RSS' ),
			'description' => __( 'Import posts from an RSS feed.' ),
			'plugin-slug' => 'rss-importer',
			'importer-id' => 'rss',
		),
		'tumblr'      => array(
			'name'        => __( 'Tumblr' ),
			'description' => __( 'Import posts &amp; media from Tumblr using their API.' ),
			'plugin-slug' => 'tumblr-importer',
			'importer-id' => 'tumblr',
		),
		'nexuspress'   => array(
			'name'        => 'NexusPress',
			'description' => __( 'Import posts, pages, comments, custom fields, categories, and tags from a NexusPress export file.' ),
			'plugin-slug' => 'nexuspress-importer',
			'importer-id' => 'nexuspress',
		),
	);
}
