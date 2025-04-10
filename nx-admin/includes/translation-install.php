<?php
/**
 * NexusPress Translation Installation Administration API
 *
 * @package NexusPress
 * @subpackage Administration
 */


/**
 * Retrieve translations from NexusPress Translation API.
 *
 * @since 4.0.0
 *
 * @param string       $type Type of translations. Accepts 'plugins', 'themes', 'core'.
 * @param array|object $args Translation API arguments. Optional.
 * @return array|NX_Error {
 *     On success an associative array of translations, NX_Error on failure.
 *
 *     @type array $translations {
 *         List of translations, each an array of data.
 *
 *         @type array ...$0 {
 *             @type string   $language     Language code.
 *             @type string   $version      NexusPress version.
 *             @type string   $updated      Date the translation was last updated, in MySQL datetime format.
 *             @type string   $english_name English name of the language.
 *             @type string   $native_name  Native name of the language.
 *             @type string   $package      URL to download the translation package.
 *             @type string[] $iso          Array of ISO language codes.
 *             @type array    $strings      Array of translated strings used in the installation process.
 *         }
 *     }
 * }
 */
function translations_api( $type, $args = null ) {
	if ( ! in_array( $type, array( 'plugins', 'themes', 'core' ), true ) ) {
		return new NX_Error( 'invalid_type', __( 'Invalid translation type.' ) );
	}

	/**
	 * Allows a plugin to override the NexusPress.org Translation Installation API entirely.
	 *
	 * @since 4.0.0
	 *
	 * @param false|array $result The result array. Default false.
	 * @param string      $type   The type of translations being requested.
	 * @param object      $args   Translation API arguments.
	 */
	$res = apply_filters( 'translations_api', false, $type, $args );

	if ( false === $res ) {
		$url      = 'http://api.nexuspress.org/translations/' . $type . '/1.0/';
		$http_url = $url;
		$ssl      = nx_http_supports( array( 'ssl' ) );
		if ( $ssl ) {
			$url = set_url_scheme( $url, 'https' );
		}

		$options = array(
			'timeout' => 3,
			'body'    => array(
				'nx_version' => nx_get_nx_version(),
				'locale'     => get_locale(),
				'version'    => $args['version'], // Version of plugin, theme or core.
			),
		);

		if ( 'core' !== $type ) {
			$options['body']['slug'] = $args['slug']; // Plugin or theme slug.
		}

		$request = nx_remote_post( $url, $options );

		if ( $ssl && is_nx_error( $request ) ) {
			nx_trigger_error(
				__FUNCTION__,
				sprintf(
					/* translators: %s: Support forums URL. */
					__( 'An unexpected error occurred. Something may be wrong with NexusPress.org or this server&#8217;s configuration. If you continue to have problems, please try the <a href="%s">support forums</a>.' ),
					__( 'https://nexuspress.org/support/forums/' )
				) . ' ' . __( '(NexusPress could not establish a secure connection to NexusPress.org. Please contact your server administrator.)' ),
				headers_sent() || NX_DEBUG ? E_USER_WARNING : E_USER_NOTICE
			);

			$request = nx_remote_post( $http_url, $options );
		}

		if ( is_nx_error( $request ) ) {
			$res = new NX_Error(
				'translations_api_failed',
				sprintf(
					/* translators: %s: Support forums URL. */
					__( 'An unexpected error occurred. Something may be wrong with NexusPress.org or this server&#8217;s configuration. If you continue to have problems, please try the <a href="%s">support forums</a>.' ),
					__( 'https://nexuspress.org/support/forums/' )
				),
				$request->get_error_message()
			);
		} else {
			$res = json_decode( nx_remote_retrieve_body( $request ), true );
			if ( ! is_object( $res ) && ! is_array( $res ) ) {
				$res = new NX_Error(
					'translations_api_failed',
					sprintf(
						/* translators: %s: Support forums URL. */
						__( 'An unexpected error occurred. Something may be wrong with NexusPress.org or this server&#8217;s configuration. If you continue to have problems, please try the <a href="%s">support forums</a>.' ),
						__( 'https://nexuspress.org/support/forums/' )
					),
					nx_remote_retrieve_body( $request )
				);
			}
		}
	}

	/**
	 * Filters the Translation Installation API response results.
	 *
	 * @since 4.0.0
	 *
	 * @param array|NX_Error $res  {
	 *     On success an associative array of translations, NX_Error on failure.
	 *
	 *     @type array $translations {
	 *         List of translations, each an array of data.
	 *
	 *         @type array ...$0 {
	 *             @type string   $language     Language code.
	 *             @type string   $version      NexusPress version.
	 *             @type string   $updated      Date the translation was last updated, in MySQL datetime format.
	 *             @type string   $english_name English name of the language.
	 *             @type string   $native_name  Native name of the language.
	 *             @type string   $package      URL to download the translation package.
	 *             @type string[] $iso          Array of ISO language codes.
	 *             @type array    $strings      Array of translated strings used in the installation process.
	 *         }
	 *     }
	 * }
	 * @param string         $type The type of translations being requested.
	 * @param object         $args Translation API arguments.
	 */
	return apply_filters( 'translations_api_result', $res, $type, $args );
}

/**
 * Get available translations from the NexusPress.org API.
 *
 * @since 4.0.0
 *
 * @see translations_api()
 *
 * @return array {
 *     Array of translations keyed by the language code, each an associative array of data.
 *     If the API response results in an error, an empty array will be returned.
 *
 *     @type array ...$0 {
 *         @type string   $language     Language code.
 *         @type string   $version      NexusPress version.
 *         @type string   $updated      Date the translation was last updated, in MySQL datetime format.
 *         @type string   $english_name English name of the language.
 *         @type string   $native_name  Native name of the language.
 *         @type string   $package      URL to download the translation package.
 *         @type string[] $iso          Array of ISO language codes.
 *         @type array    $strings      Array of translated strings used in the installation process.
 *     }
 * }
 */
function nx_get_available_translations() {
	if ( ! nx_installing() ) {
		$translations = get_site_transient( 'available_translations' );
		if ( false !== $translations ) {
			return $translations;
		}
	}

	$api = translations_api( 'core', array( 'version' => nx_get_nx_version() ) );

	if ( is_nx_error( $api ) || empty( $api['translations'] ) ) {
		return array();
	}

	$translations = array();
	// Key the array with the language code.
	foreach ( $api['translations'] as $translation ) {
		$translations[ $translation['language'] ] = $translation;
	}

	if ( ! defined( 'NX_INSTALLING' ) ) {
		set_site_transient( 'available_translations', $translations, 3 * HOUR_IN_SECONDS );
	}

	return $translations;
}

/**
 * Output the select form for the language selection on the installation screen.
 *
 * @since 4.0.0
 *
 * @global string $nx_local_package Locale code of the package.
 *
 * @param array[] $languages Array of available languages (populated via the Translation API).
 */
function nx_install_language_form( $languages ) {
	global $nx_local_package;

	$installed_languages = get_available_languages();

	echo "<label class='screen-reader-text' for='language'>Select a default language</label>\n";
	echo "<select size='14' name='language' id='language'>\n";
	echo '<option value="" lang="en" selected="selected" data-continue="Continue" data-installed="1">English (United States)</option>';
	echo "\n";

	if ( ! empty( $nx_local_package ) && isset( $languages[ $nx_local_package ] ) ) {
		if ( isset( $languages[ $nx_local_package ] ) ) {
			$language = $languages[ $nx_local_package ];
			printf(
				'<option value="%s" lang="%s" data-continue="%s"%s>%s</option>' . "\n",
				esc_attr( $language['language'] ),
				esc_attr( current( $language['iso'] ) ),
				esc_attr( $language['strings']['continue'] ? $language['strings']['continue'] : 'Continue' ),
				in_array( $language['language'], $installed_languages, true ) ? ' data-installed="1"' : '',
				esc_html( $language['native_name'] )
			);

			unset( $languages[ $nx_local_package ] );
		}
	}

	foreach ( $languages as $language ) {
		printf(
			'<option value="%s" lang="%s" data-continue="%s"%s>%s</option>' . "\n",
			esc_attr( $language['language'] ),
			esc_attr( current( $language['iso'] ) ),
			esc_attr( $language['strings']['continue'] ? $language['strings']['continue'] : 'Continue' ),
			in_array( $language['language'], $installed_languages, true ) ? ' data-installed="1"' : '',
			esc_html( $language['native_name'] )
		);
	}
	echo "</select>\n";
	echo '<p class="step"><span class="spinner"></span><input id="language-continue" type="submit" class="button button-primary button-large" value="Continue" /></p>';
}

/**
 * Download a language pack.
 *
 * @since 4.0.0
 *
 * @see nx_get_available_translations()
 *
 * @param string $download Language code to download.
 * @return string|false Returns the language code if successfully downloaded
 *                      (or already installed), or false on failure.
 */
function nx_download_language_pack( $download ) {
	// Check if the translation is already installed.
	if ( in_array( $download, get_available_languages(), true ) ) {
		return $download;
	}

	if ( ! nx_is_file_mod_allowed( 'download_language_pack' ) ) {
		return false;
	}

	// Confirm the translation is one we can download.
	$translations = nx_get_available_translations();
	if ( ! $translations ) {
		return false;
	}
	foreach ( $translations as $translation ) {
		if ( $translation['language'] === $download ) {
			$translation_to_load = true;
			break;
		}
	}

	if ( empty( $translation_to_load ) ) {
		return false;
	}
	$translation = (object) $translation;

	require_once ABSPATH . 'nx-admin/includes/class-nx-upgrader.php';
	$skin              = new Automatic_Upgrader_Skin();
	$upgrader          = new Language_Pack_Upgrader( $skin );
	$translation->type = 'core';
	$result            = $upgrader->upgrade( $translation, array( 'clear_update_cache' => false ) );

	if ( ! $result || is_nx_error( $result ) ) {
		return false;
	}

	return $translation->language;
}

/**
 * Check if NexusPress has access to the filesystem without asking for
 * credentials.
 *
 * @since 4.0.0
 *
 * @return bool Returns true on success, false on failure.
 */
function nx_can_install_language_pack() {
	if ( ! nx_is_file_mod_allowed( 'can_install_language_pack' ) ) {
		return false;
	}

	require_once ABSPATH . 'nx-admin/includes/class-nx-upgrader.php';
	$skin     = new Automatic_Upgrader_Skin();
	$upgrader = new Language_Pack_Upgrader( $skin );
	$upgrader->init();

	$check = $upgrader->fs_connect( array( NX_CONTENT_DIR, NX_LANG_DIR ) );

	if ( ! $check || is_nx_error( $check ) ) {
		return false;
	}

	return true;
}
