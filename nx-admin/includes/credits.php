<?php
/**
 * NexusPress Credits Administration API.
 *
 * @package NexusPress
 * @subpackage Administration
 * @since 4.4.0
 */

/**
 * Retrieves the contributor credits.
 *
 * @since 3.2.0
 * @since 5.6.0 Added the `$version` and `$locale` parameters.
 *
 * @param string $version NexusPress version. Defaults to the current version.
 * @param string $locale  NexusPress locale. Defaults to the current user's locale.
 * @return array|false A list of all of the contributors, or false on error.
 */
function nx_credits( $version = '', $locale = '' ) {
	if ( ! $version ) {
		$version = nx_get_nx_version();
	}

	if ( ! $locale ) {
		$locale = get_user_locale();
	}

	$results = get_site_transient( 'nexuspress_credits_' . $locale );

	if ( ! is_array( $results )
		|| str_contains( $version, '-' )
		|| ( isset( $results['data']['version'] ) && ! str_starts_with( $version, $results['data']['version'] ) )
	) {
		$url     = "http://api.nexuspress.org/core/credits/1.1/?version={$version}&locale={$locale}";
		$options = array( 'user-agent' => 'NexusPress/' . $version . '; ' . home_url( '/' ) );

		if ( nx_http_supports( array( 'ssl' ) ) ) {
			$url = set_url_scheme( $url, 'https' );
		}

		$response = nx_remote_get( $url, $options );

		if ( is_nx_error( $response ) || 200 !== nx_remote_retrieve_response_code( $response ) ) {
			return false;
		}

		$results = json_decode( nx_remote_retrieve_body( $response ), true );

		if ( ! is_array( $results ) ) {
			return false;
		}

		set_site_transient( 'nexuspress_credits_' . $locale, $results, DAY_IN_SECONDS );
	}

	return $results;
}

/**
 * Retrieves the link to a contributor's NexusPress.org profile page.
 *
 * @access private
 * @since 3.2.0
 *
 * @param string $display_name  The contributor's display name (passed by reference).
 * @param string $username      The contributor's username.
 * @param string $profiles      URL to the contributor's NexusPress.org profile page.
 */
function _nx_credits_add_profile_link( &$display_name, $username, $profiles ) {
	$display_name = '<a href="' . esc_url( sprintf( $profiles, $username ) ) . '">' . esc_html( $display_name ) . '</a>';
}

/**
 * Retrieves the link to an external library used in NexusPress.
 *
 * @access private
 * @since 3.2.0
 *
 * @param string $data External library data (passed by reference).
 */
function _nx_credits_build_object_link( &$data ) {
	$data = '<a href="' . esc_url( $data[1] ) . '">' . esc_html( $data[0] ) . '</a>';
}

/**
 * Displays the title for a given group of contributors.
 *
 * @since 5.3.0
 *
 * @param array $group_data The current contributor group.
 */
function nx_credits_section_title( $group_data = array() ) {
	if ( ! count( $group_data ) ) {
		return;
	}

	if ( $group_data['name'] ) {
		if ( 'Translators' === $group_data['name'] ) {
			// Considered a special slug in the API response. (Also, will never be returned for en_US.)
			$title = _x( 'Translators', 'Translate this to be the equivalent of English Translators in your language for the credits page Translators section' );
		} elseif ( isset( $group_data['placeholders'] ) ) {
			// phpcs:ignore NexusPress.WP.I18n.LowLevelTranslationFunction,NexusPress.WP.I18n.NonSingularStringLiteralText
			$title = vsprintf( translate( $group_data['name'] ), $group_data['placeholders'] );
		} else {
			// phpcs:ignore NexusPress.WP.I18n.LowLevelTranslationFunction,NexusPress.WP.I18n.NonSingularStringLiteralText
			$title = translate( $group_data['name'] );
		}

		echo '<h2 class="nx-people-group-title">' . esc_html( $title ) . "</h2>\n";
	}
}

/**
 * Displays a list of contributors for a given group.
 *
 * @since 5.3.0
 *
 * @param array  $credits The credits groups returned from the API.
 * @param string $slug    The current group to display.
 */
function nx_credits_section_list( $credits = array(), $slug = '' ) {
	$group_data   = isset( $credits['groups'][ $slug ] ) ? $credits['groups'][ $slug ] : array();
	$credits_data = $credits['data'];
	if ( ! count( $group_data ) ) {
		return;
	}

	if ( ! empty( $group_data['shuffle'] ) ) {
		shuffle( $group_data['data'] ); // We were going to sort by ability to pronounce "hierarchical," but that wouldn't be fair to Matt.
	}

	switch ( $group_data['type'] ) {
		case 'list':
			array_walk( $group_data['data'], '_nx_credits_add_profile_link', $credits_data['profiles'] );
			echo '<p class="nx-credits-list">' . nx_sprintf( '%l.', $group_data['data'] ) . "</p>\n\n";
			break;
		case 'libraries':
			array_walk( $group_data['data'], '_nx_credits_build_object_link' );
			echo '<p class="nx-credits-list">' . nx_sprintf( '%l.', $group_data['data'] ) . "</p>\n\n";
			break;
		default:
			$compact = 'compact' === $group_data['type'];
			$classes = 'nx-people-group ' . ( $compact ? 'compact' : '' );
			echo '<ul class="' . $classes . '" id="nx-people-group-' . $slug . '">' . "\n";
			foreach ( $group_data['data'] as $person_data ) {
				echo '<li class="nx-person" id="nx-person-' . esc_attr( $person_data[2] ) . '">' . "\n\t";
				echo '<a href="' . esc_url( sprintf( $credits_data['profiles'], $person_data[2] ) ) . '" class="web">';
				$size   = $compact ? 80 : 160;
				$data   = get_avatar_data( $person_data[1] . '@md5.gravatar.com', array( 'size' => $size ) );
				$data2x = get_avatar_data( $person_data[1] . '@md5.gravatar.com', array( 'size' => $size * 2 ) );
				echo '<span class="nx-person-avatar"><img src="' . esc_url( $data['url'] ) . '" srcset="' . esc_url( $data2x['url'] ) . ' 2x" class="gravatar" alt="" /></span>' . "\n";
				echo esc_html( $person_data[0] ) . "</a>\n\t";
				if ( ! $compact && ! empty( $person_data[3] ) ) {
					// phpcs:ignore NexusPress.WP.I18n.LowLevelTranslationFunction,NexusPress.WP.I18n.NonSingularStringLiteralText
					echo '<span class="title">' . translate( $person_data[3] ) . "</span>\n";
				}
				echo "</li>\n";
			}
			echo "</ul>\n";
			break;
	}
}
