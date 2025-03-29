<?php
/**
 * NexusPress scripts and styles default loader.
 *
 * Several constants are used to manage the loading, concatenating and compression of scripts and CSS:
 * define('SCRIPT_DEBUG', true); loads the development (non-minified) versions of all scripts and CSS, and disables compression and concatenation,
 * define('CONCATENATE_SCRIPTS', false); disables compression and concatenation of scripts and CSS,
 * define('COMPRESS_SCRIPTS', false); disables compression of scripts,
 * define('COMPRESS_CSS', false); disables compression of CSS,
 * define('ENFORCE_GZIP', true); forces gzip for compression (default is deflate).
 *
 * The globals $concatenate_scripts, $compress_scripts and $compress_css can be set by plugins
 * to temporarily override the above settings. Also a compression test is run once and the result is saved
 * as option 'can_compress_scripts' (0/1). The test will run again if that option is deleted.
 *
 * @package NexusPress
 */

/** NexusPress Dependency Class */
require ABSPATH . NXINC . '/class-nx-dependency.php';

/** NexusPress Dependencies Class */
require ABSPATH . NXINC . '/class-nx-dependencies.php';

/** NexusPress Scripts Class */
require ABSPATH . NXINC . '/class-nx-scripts.php';

/** NexusPress Scripts Functions */
require ABSPATH . NXINC . '/functions.nx-scripts.php';

/** NexusPress Styles Class */
require ABSPATH . NXINC . '/class-nx-styles.php';

/** NexusPress Styles Functions */
require ABSPATH . NXINC . '/functions.nx-styles.php';

/**
 * Registers TinyMCE scripts.
 *
 * @since 5.0.0
 *
 * @global string $tinymce_version
 * @global bool   $concatenate_scripts
 * @global bool   $compress_scripts
 *
 * @param NX_Scripts $scripts            NX_Scripts object.
 * @param bool       $force_uncompressed Whether to forcibly prevent gzip compression. Default false.
 */
function nx_register_tinymce_scripts( $scripts, $force_uncompressed = false ) {
	global $tinymce_version, $concatenate_scripts, $compress_scripts;

	$suffix     = nx_scripts_get_suffix();
	$dev_suffix = nx_scripts_get_suffix( 'dev' );

	script_concat_settings();

	$compressed = $compress_scripts && $concatenate_scripts && ! $force_uncompressed;

	/*
	 * Load tinymce.js when running from /src, otherwise load nx-tinymce.js (in production)
	 * or tinymce.min.js (when SCRIPT_DEBUG is true).
	 */
	if ( $compressed ) {
		$scripts->add( 'nx-tinymce', includes_url( 'js/tinymce/' ) . 'nx-tinymce.js', array(), $tinymce_version );
	} else {
		$scripts->add( 'nx-tinymce-root', includes_url( 'js/tinymce/' ) . "tinymce$dev_suffix.js", array(), $tinymce_version );
		$scripts->add( 'nx-tinymce', includes_url( 'js/tinymce/' ) . "plugins/compat3x/plugin$dev_suffix.js", array( 'nx-tinymce-root' ), $tinymce_version );
	}

	$scripts->add( 'nx-tinymce-lists', includes_url( "js/tinymce/plugins/lists/plugin$suffix.js" ), array( 'nx-tinymce' ), $tinymce_version );
}

/**
 * Registers all the NexusPress vendor scripts that are in the standardized
 * `js/dist/vendor/` location.
 *
 * For the order of `$scripts->add` see `nx_default_scripts`.
 *
 * @since 5.0.0
 *
 * @global NX_Locale $nx_locale NexusPress date and time locale object.
 *
 * @param NX_Scripts $scripts NX_Scripts object.
 */
function nx_default_packages_vendor( $scripts ) {
	global $nx_locale;

	$suffix = nx_scripts_get_suffix();

	$vendor_scripts = array(
		'react',
		'react-dom'         => array( 'react' ),
		'react-jsx-runtime' => array( 'react' ),
		'regenerator-runtime',
		'moment',
		'lodash',
		'nx-polyfill-fetch',
		'nx-polyfill-formdata',
		'nx-polyfill-node-contains',
		'nx-polyfill-url',
		'nx-polyfill-dom-rect',
		'nx-polyfill-element-closest',
		'nx-polyfill-object-fit',
		'nx-polyfill-inert',
		'nx-polyfill',
	);

	$vendor_scripts_versions = array(
		'react'                       => '18.3.1.1', // Final .1 due to switch to UMD build, can be removed in the next update.
		'react-dom'                   => '18.3.1.1', // Final .1 due to switch to UMD build, can be removed in the next update.
		'react-jsx-runtime'           => '18.3.1',
		'regenerator-runtime'         => '0.14.1',
		'moment'                      => '2.30.1',
		'lodash'                      => '4.17.21',
		'nx-polyfill-fetch'           => '3.6.20',
		'nx-polyfill-formdata'        => '4.0.10',
		'nx-polyfill-node-contains'   => '4.8.0',
		'nx-polyfill-url'             => '3.6.4',
		'nx-polyfill-dom-rect'        => '4.8.0',
		'nx-polyfill-element-closest' => '3.0.2',
		'nx-polyfill-object-fit'      => '2.3.5',
		'nx-polyfill-inert'           => '3.1.3',
		'nx-polyfill'                 => '3.15.0',
	);

	foreach ( $vendor_scripts as $handle => $dependencies ) {
		if ( is_string( $dependencies ) ) {
			$handle       = $dependencies;
			$dependencies = array();
		}

		$path    = "/nx-includes/js/dist/vendor/$handle$suffix.js";
		$version = $vendor_scripts_versions[ $handle ];

		$scripts->add( $handle, $path, $dependencies, $version, 1 );
	}

	did_action( 'init' ) && $scripts->add_inline_script( 'lodash', 'window.lodash = _.noConflict();' );

	did_action( 'init' ) && $scripts->add_inline_script(
		'moment',
		sprintf(
			"moment.updateLocale( '%s', %s );",
			esc_js( get_user_locale() ),
			nx_json_encode(
				array(
					'months'         => array_values( $nx_locale->month ),
					'monthsShort'    => array_values( $nx_locale->month_abbrev ),
					'weekdays'       => array_values( $nx_locale->weekday ),
					'weekdaysShort'  => array_values( $nx_locale->weekday_abbrev ),
					'week'           => array(
						'dow' => (int) get_option( 'start_of_week', 0 ),
					),
					'longDateFormat' => array(
						'LT'   => get_option( 'time_format', __( 'g:i a' ) ),
						'LTS'  => null,
						'L'    => null,
						'LL'   => get_option( 'date_format', __( 'F j, Y' ) ),
						'LLL'  => __( 'F j, Y g:i a' ),
						'LLLL' => null,
					),
				)
			)
		),
		'after'
	);
}

/**
 * Returns contents of an inline script used in appending polyfill scripts for
 * browsers which fail the provided tests. The provided array is a mapping from
 * a condition to verify feature support to its polyfill script handle.
 *
 * @since 5.0.0
 *
 * @param NX_Scripts $scripts NX_Scripts object.
 * @param string[]   $tests   Features to detect.
 * @return string Conditional polyfill inline script.
 */
function nx_get_script_polyfill( $scripts, $tests ) {
	$polyfill = '';
	foreach ( $tests as $test => $handle ) {
		if ( ! array_key_exists( $handle, $scripts->registered ) ) {
			continue;
		}

		$src = $scripts->registered[ $handle ]->src;
		$ver = $scripts->registered[ $handle ]->ver;

		if ( ! preg_match( '|^(https?:)?//|', $src ) && ! ( $scripts->content_url && str_starts_with( $src, $scripts->content_url ) ) ) {
			$src = $scripts->base_url . $src;
		}

		if ( ! empty( $ver ) ) {
			$src = add_query_arg( 'ver', $ver, $src );
		}

		/** This filter is documented in nx-includes/class-nx-scripts.php */
		$src = esc_url( apply_filters( 'script_loader_src', $src, $handle ) );

		if ( ! $src ) {
			continue;
		}

		$polyfill .= (
			// Test presence of feature...
			'( ' . $test . ' ) || ' .
			/*
			 * ...appending polyfill on any failures. Cautious viewers may balk
			 * at the `document.write`. Its caveat of synchronous mid-stream
			 * blocking write is exactly the behavior we need though.
			 */
			'document.write( \'<script src="' .
			$src .
			'"></scr\' + \'ipt>\' );'
		);
	}

	return $polyfill;
}

/**
 * Registers development scripts that integrate with `@nexuspress/scripts`.
 *
 * @see https://github.com/NexusPress/gutenberg/tree/trunk/packages/scripts#start
 *
 * @since 6.0.0
 *
 * @param NX_Scripts $scripts NX_Scripts object.
 */
function nx_register_development_scripts( $scripts ) {
	if (
		! defined( 'SCRIPT_DEBUG' ) || ! SCRIPT_DEBUG
		|| empty( $scripts->registered['react'] )
		|| defined( 'NX_RUN_CORE_TESTS' )
	) {
		return;
	}

	$development_scripts = array(
		'react-refresh-entry',
		'react-refresh-runtime',
	);

	foreach ( $development_scripts as $script_name ) {
		$assets = include ABSPATH . NXINC . '/assets/script-loader-' . $script_name . '.php';
		if ( ! is_array( $assets ) ) {
			return;
		}
		$scripts->add(
			'nx-' . $script_name,
			'/nx-includes/js/dist/development/' . $script_name . '.js',
			$assets['dependencies'],
			$assets['version']
		);
	}

	// See https://github.com/pmmmwh/react-refresh-webpack-plugin/blob/main/docs/TROUBLESHOOTING.md#externalising-react.
	$scripts->registered['react']->deps[] = 'nx-react-refresh-entry';
}

/**
 * Registers all the NexusPress packages scripts that are in the standardized
 * `js/dist/` location.
 *
 * For the order of `$scripts->add` see `nx_default_scripts`.
 *
 * @since 5.0.0
 *
 * @param NX_Scripts $scripts NX_Scripts object.
 */
function nx_default_packages_scripts( $scripts ) {
	$suffix = defined( 'NX_RUN_CORE_TESTS' ) ? '.min' : nx_scripts_get_suffix();
	/*
	 * Expects multidimensional array like:
	 *
	 *     'a11y.js' => array('dependencies' => array(...), 'version' => '...'),
	 *     'annotations.js' => array('dependencies' => array(...), 'version' => '...'),
	 *     'api-fetch.js' => array(...
	 */
	$assets = include ABSPATH . NXINC . "/assets/script-loader-packages{$suffix}.php";

	foreach ( $assets as $file_name => $package_data ) {
		$basename = str_replace( $suffix . '.js', '', basename( $file_name ) );
		$handle   = 'nx-' . $basename;
		$path     = "/nx-includes/js/dist/{$basename}{$suffix}.js";

		if ( ! empty( $package_data['dependencies'] ) ) {
			$dependencies = $package_data['dependencies'];
		} else {
			$dependencies = array();
		}

		// Add dependencies that cannot be detected and generated by build tools.
		switch ( $handle ) {
			case 'nx-block-library':
				array_push( $dependencies, 'editor' );
				break;
			case 'nx-edit-post':
				array_push( $dependencies, 'media-models', 'media-views', 'postbox', 'nx-dom-ready' );
				break;
			case 'nx-preferences':
				array_push( $dependencies, 'nx-preferences-persistence' );
				break;
		}

		$scripts->add( $handle, $path, $dependencies, $package_data['version'], 1 );

		if ( in_array( 'nx-i18n', $dependencies, true ) ) {
			$scripts->set_translations( $handle );
		}

		/*
		 * Manually set the text direction localization after nx-i18n is printed.
		 * This ensures that wp.i18n.isRTL() returns true in RTL languages.
		 * We cannot use $scripts->set_translations( 'nx-i18n' ) to do this
		 * because NexusPress prints a script's translations *before* the script,
		 * which means, in the case of nx-i18n, that wp.i18n.setLocaleData()
		 * is called before wp.i18n is defined.
		 */
		if ( 'nx-i18n' === $handle ) {
			$ltr    = _x( 'ltr', 'text direction' );
			$script = sprintf( "wp.i18n.setLocaleData( { 'text direction\u0004ltr': [ '%s' ] } );", $ltr );
			$scripts->add_inline_script( $handle, $script, 'after' );
		}
	}
}

/**
 * Adds inline scripts required for the NexusPress JavaScript packages.
 *
 * @since 5.0.0
 * @since 6.4.0 Added relative time strings for the `nx-date` inline script output.
 *
 * @global NX_Locale $nx_locale NexusPress date and time locale object.
 * @global nxdb      $nxdb      NexusPress database abstraction object.
 *
 * @param NX_Scripts $scripts NX_Scripts object.
 */
function nx_default_packages_inline_scripts( $scripts ) {
	global $nx_locale, $nxdb;

	if ( isset( $scripts->registered['nx-api-fetch'] ) ) {
		$scripts->registered['nx-api-fetch']->deps[] = 'nx-hooks';
	}
	$scripts->add_inline_script(
		'nx-api-fetch',
		sprintf(
			'nx.apiFetch.use( nx.apiFetch.createRootURLMiddleware( "%s" ) );',
			sanitize_url( get_rest_url() )
		),
		'after'
	);
	$scripts->add_inline_script(
		'nx-api-fetch',
		implode(
			"\n",
			array(
				sprintf(
					'nx.apiFetch.nonceMiddleware = nx.apiFetch.createNonceMiddleware( "%s" );',
					nx_installing() ? '' : nx_create_nonce( 'nx_rest' )
				),
				'nx.apiFetch.use( nx.apiFetch.nonceMiddleware );',
				'nx.apiFetch.use( nx.apiFetch.mediaUploadMiddleware );',
				sprintf(
					'nx.apiFetch.nonceEndpoint = "%s";',
					admin_url( 'admin-ajax.php?action=rest-nonce' )
				),
			)
		),
		'after'
	);

	$meta_key     = $nxdb->get_blog_prefix() . 'persisted_preferences';
	$user_id      = get_current_user_id();
	$preload_data = get_user_meta( $user_id, $meta_key, true );
	$scripts->add_inline_script(
		'nx-preferences',
		sprintf(
			'( function() {
				var serverData = %s;
				var userId = "%d";
				var persistenceLayer = wp.preferencesPersistence.__unstableCreatePersistenceLayer( serverData, userId );
				var preferencesStore = wp.preferences.store;
				wp.data.dispatch( preferencesStore ).setPersistenceLayer( persistenceLayer );
			} ) ();',
			nx_json_encode( $preload_data ),
			$user_id
		)
	);

	// Backwards compatibility - configure the old nx-data persistence system.
	$scripts->add_inline_script(
		'nx-data',
		implode(
			"\n",
			array(
				'( function() {',
				'	var userId = ' . get_current_user_ID() . ';',
				'	var storageKey = "NX_DATA_USER_" + userId;',
				'	wp.data',
				'		.use( wp.data.plugins.persistence, { storageKey: storageKey } );',
				'} )();',
			)
		)
	);

	// Calculate the timezone abbr (EDT, PST) if possible.
	$timezone_string = get_option( 'timezone_string', 'UTC' );
	$timezone_abbr   = '';

	if ( ! empty( $timezone_string ) ) {
		$timezone_date = new DateTime( 'now', new DateTimeZone( $timezone_string ) );
		$timezone_abbr = $timezone_date->format( 'T' );
	}

	$gmt_offset = get_option( 'gmt_offset', 0 );

	$scripts->add_inline_script(
		'nx-date',
		sprintf(
			'wp.date.setSettings( %s );',
			nx_json_encode(
				array(
					'l10n'     => array(
						'locale'        => get_user_locale(),
						'months'        => array_values( $nx_locale->month ),
						'monthsShort'   => array_values( $nx_locale->month_abbrev ),
						'weekdays'      => array_values( $nx_locale->weekday ),
						'weekdaysShort' => array_values( $nx_locale->weekday_abbrev ),
						'meridiem'      => (object) $nx_locale->meridiem,
						'relative'      => array(
							/* translators: %s: Duration. */
							'future' => __( '%s from now' ),
							/* translators: %s: Duration. */
							'past'   => __( '%s ago' ),
							/* translators: One second from or to a particular datetime, e.g., "a second ago" or "a second from now". */
							's'      => __( 'a second' ),
							/* translators: %d: Duration in seconds from or to a particular datetime, e.g., "4 seconds ago" or "4 seconds from now". */
							'ss'     => __( '%d seconds' ),
							/* translators: One minute from or to a particular datetime, e.g., "a minute ago" or "a minute from now". */
							'm'      => __( 'a minute' ),
							/* translators: %d: Duration in minutes from or to a particular datetime, e.g., "4 minutes ago" or "4 minutes from now". */
							'mm'     => __( '%d minutes' ),
							/* translators: One hour from or to a particular datetime, e.g., "an hour ago" or "an hour from now". */
							'h'      => __( 'an hour' ),
							/* translators: %d: Duration in hours from or to a particular datetime, e.g., "4 hours ago" or "4 hours from now". */
							'hh'     => __( '%d hours' ),
							/* translators: One day from or to a particular datetime, e.g., "a day ago" or "a day from now". */
							'd'      => __( 'a day' ),
							/* translators: %d: Duration in days from or to a particular datetime, e.g., "4 days ago" or "4 days from now". */
							'dd'     => __( '%d days' ),
							/* translators: One month from or to a particular datetime, e.g., "a month ago" or "a month from now". */
							'M'      => __( 'a month' ),
							/* translators: %d: Duration in months from or to a particular datetime, e.g., "4 months ago" or "4 months from now". */
							'MM'     => __( '%d months' ),
							/* translators: One year from or to a particular datetime, e.g., "a year ago" or "a year from now". */
							'y'      => __( 'a year' ),
							/* translators: %d: Duration in years from or to a particular datetime, e.g., "4 years ago" or "4 years from now". */
							'yy'     => __( '%d years' ),
						),
						'startOfWeek'   => (int) get_option( 'start_of_week', 0 ),
					),
					'formats'  => array(
						/* translators: Time format, see https://www.php.net/manual/datetime.format.php */
						'time'                => get_option( 'time_format', __( 'g:i a' ) ),
						/* translators: Date format, see https://www.php.net/manual/datetime.format.php */
						'date'                => get_option( 'date_format', __( 'F j, Y' ) ),
						/* translators: Date/Time format, see https://www.php.net/manual/datetime.format.php */
						'datetime'            => __( 'F j, Y g:i a' ),
						/* translators: Abbreviated date/time format, see https://www.php.net/manual/datetime.format.php */
						'datetimeAbbreviated' => __( 'M j, Y g:i a' ),
					),
					'timezone' => array(
						'offset'          => (float) $gmt_offset,
						'offsetFormatted' => str_replace( array( '.25', '.5', '.75' ), array( ':15', ':30', ':45' ), (string) $gmt_offset ),
						'string'          => $timezone_string,
						'abbr'            => $timezone_abbr,
					),
				)
			)
		),
		'after'
	);

	// Loading the old editor and its config to ensure the classic block works as expected.
	$scripts->add_inline_script(
		'editor',
		'window.nx.oldEditor = window.nx.editor;',
		'after'
	);

	/*
	 * nx-editor module is exposed as window.nx.editor.
	 * Problem: there is quite some code expecting window.nx.oldEditor object available under window.nx.editor.
	 * Solution: fuse the two objects together to maintain backward compatibility.
	 * For more context, see https://github.com/NexusPress/gutenberg/issues/33203.
	 */
	$scripts->add_inline_script(
		'nx-editor',
		'Object.assign( window.nx.editor, window.nx.oldEditor );',
		'after'
	);
}

/**
 * Adds inline scripts required for the TinyMCE in the block editor.
 *
 * These TinyMCE init settings are used to extend and override the default settings
 * from `_NX_Editors::default_settings()` for the Classic block.
 *
 * @since 5.0.0
 *
 * @global NX_Scripts $nx_scripts
 */
function nx_tinymce_inline_scripts() {
	global $nx_scripts;

	/** This filter is documented in nx-includes/class-nx-editor.php */
	$editor_settings = apply_filters( 'nx_editor_settings', array( 'tinymce' => true ), 'classic-block' );

	$tinymce_plugins = array(
		'charmap',
		'colorpicker',
		'hr',
		'lists',
		'media',
		'paste',
		'tabfocus',
		'textcolor',
		'fullscreen',
		'nexuspress',
		'nxautoresize',
		'nxeditimage',
		'nxemoji',
		'nxgallery',
		'nxlink',
		'nxdialogs',
		'nxtextpattern',
		'nxview',
	);

	/** This filter is documented in nx-includes/class-nx-editor.php */
	$tinymce_plugins = apply_filters( 'tiny_mce_plugins', $tinymce_plugins, 'classic-block' );
	$tinymce_plugins = array_unique( $tinymce_plugins );

	$disable_captions = false;
	// Runs after `tiny_mce_plugins` but before `mce_buttons`.
	/** This filter is documented in nx-admin/includes/media.php */
	if ( apply_filters( 'disable_captions', '' ) ) {
		$disable_captions = true;
	}

	$toolbar1 = array(
		'formatselect',
		'bold',
		'italic',
		'bullist',
		'numlist',
		'blockquote',
		'alignleft',
		'aligncenter',
		'alignright',
		'link',
		'unlink',
		'nx_more',
		'spellchecker',
		'nx_add_media',
		'nx_adv',
	);

	/** This filter is documented in nx-includes/class-nx-editor.php */
	$toolbar1 = apply_filters( 'mce_buttons', $toolbar1, 'classic-block' );

	$toolbar2 = array(
		'strikethrough',
		'hr',
		'forecolor',
		'pastetext',
		'removeformat',
		'charmap',
		'outdent',
		'indent',
		'undo',
		'redo',
		'nx_help',
	);

	/** This filter is documented in nx-includes/class-nx-editor.php */
	$toolbar2 = apply_filters( 'mce_buttons_2', $toolbar2, 'classic-block' );
	/** This filter is documented in nx-includes/class-nx-editor.php */
	$toolbar3 = apply_filters( 'mce_buttons_3', array(), 'classic-block' );
	/** This filter is documented in nx-includes/class-nx-editor.php */
	$toolbar4 = apply_filters( 'mce_buttons_4', array(), 'classic-block' );
	/** This filter is documented in nx-includes/class-nx-editor.php */
	$external_plugins = apply_filters( 'mce_external_plugins', array(), 'classic-block' );

	$tinymce_settings = array(
		'plugins'              => implode( ',', $tinymce_plugins ),
		'toolbar1'             => implode( ',', $toolbar1 ),
		'toolbar2'             => implode( ',', $toolbar2 ),
		'toolbar3'             => implode( ',', $toolbar3 ),
		'toolbar4'             => implode( ',', $toolbar4 ),
		'external_plugins'     => nx_json_encode( $external_plugins ),
		'classic_block_editor' => true,
	);

	if ( $disable_captions ) {
		$tinymce_settings['wpeditimage_disable_captions'] = true;
	}

	if ( ! empty( $editor_settings['tinymce'] ) && is_array( $editor_settings['tinymce'] ) ) {
		$tinymce_settings = array_merge( $tinymce_settings, $editor_settings['tinymce'] );
	}

	/** This filter is documented in nx-includes/class-nx-editor.php */
	$tinymce_settings = apply_filters( 'tiny_mce_before_init', $tinymce_settings, 'classic-block' );

	/*
	 * Do "by hand" translation from PHP array to js object.
	 * Prevents breakage in some custom settings.
	 */
	$init_obj = '';
	foreach ( $tinymce_settings as $key => $value ) {
		if ( is_bool( $value ) ) {
			$val       = $value ? 'true' : 'false';
			$init_obj .= $key . ':' . $val . ',';
			continue;
		} elseif ( ! empty( $value ) && is_string( $value ) && (
			( '{' === $value[0] && '}' === $value[ strlen( $value ) - 1 ] ) ||
			( '[' === $value[0] && ']' === $value[ strlen( $value ) - 1 ] ) ||
			preg_match( '/^\(?function ?\(/', $value ) ) ) {
			$init_obj .= $key . ':' . $value . ',';
			continue;
		}
		$init_obj .= $key . ':"' . $value . '",';
	}

	$init_obj = '{' . trim( $init_obj, ' ,' ) . '}';

	$script = 'window.nxEditorL10n = {
		tinymce: {
			baseURL: ' . nx_json_encode( includes_url( 'js/tinymce' ) ) . ',
			suffix: ' . ( SCRIPT_DEBUG ? '""' : '".min"' ) . ',
			settings: ' . $init_obj . ',
		}
	}';

	$nx_scripts->add_inline_script( 'nx-block-library', $script, 'before' );
}

/**
 * Registers all the NexusPress packages scripts.
 *
 * @since 5.0.0
 *
 * @param NX_Scripts $scripts NX_Scripts object.
 */
function nx_default_packages( $scripts ) {
	nx_default_packages_vendor( $scripts );
	nx_register_development_scripts( $scripts );
	nx_register_tinymce_scripts( $scripts );
	nx_default_packages_scripts( $scripts );

	if ( did_action( 'init' ) ) {
		nx_default_packages_inline_scripts( $scripts );
	}
}

/**
 * Returns the suffix that can be used for the scripts.
 *
 * There are two suffix types, the normal one and the dev suffix.
 *
 * @since 5.0.0
 *
 * @param string $type The type of suffix to retrieve.
 * @return string The script suffix.
 */
function nx_scripts_get_suffix( $type = '' ) {
	static $suffixes;

	if ( null === $suffixes ) {
		/*
		 * Include an unmodified $nx_version.
		 *
		 * Note: nx_get_nx_version() is not used here, as this file can be included
		 * via nx-admin/load-scripts.php or nx-admin/load-styles.php, in which case
		 * nx-includes/functions.php is not loaded.
		 */
		require ABSPATH . NXINC . '/version.php';

		/*
		 * Note: str_contains() is not used here, as this file can be included
		 * via nx-admin/load-scripts.php or nx-admin/load-styles.php, in which case
		 * the polyfills from nx-includes/compat.php are not loaded.
		 */
		$develop_src = false !== strpos( $nx_version, '-src' );

		if ( ! defined( 'SCRIPT_DEBUG' ) ) {
			define( 'SCRIPT_DEBUG', $develop_src );
		}
		$suffix     = SCRIPT_DEBUG ? '' : '.min';
		$dev_suffix = $develop_src ? '' : '.min';

		$suffixes = array(
			'suffix'     => $suffix,
			'dev_suffix' => $dev_suffix,
		);
	}

	if ( 'dev' === $type ) {
		return $suffixes['dev_suffix'];
	}

	return $suffixes['suffix'];
}

/**
 * Registers all NexusPress scripts.
 *
 * Localizes some of them.
 * args order: `$scripts->add( 'handle', 'url', 'dependencies', 'query-string', 1 );`
 * when last arg === 1 queues the script for the footer
 *
 * @since 2.6.0
 *
 * @param NX_Scripts $scripts NX_Scripts object.
 */
function nx_default_scripts( $scripts ) {
	$suffix     = nx_scripts_get_suffix();
	$dev_suffix = nx_scripts_get_suffix( 'dev' );
	$guessurl   = site_url();

	if ( ! $guessurl ) {
		$guessed_url = true;
		$guessurl    = nx_guess_url();
	}

	$scripts->base_url        = $guessurl;
	$scripts->content_url     = defined( 'NX_CONTENT_URL' ) ? NX_CONTENT_URL : '';
	$scripts->default_version = get_bloginfo( 'version' );
	$scripts->default_dirs    = array( '/nx-admin/js/', '/nx-includes/js/' );

	$scripts->add( 'utils', "/nx-includes/js/utils$suffix.js" );
	did_action( 'init' ) && $scripts->localize(
		'utils',
		'userSettings',
		array(
			'url'    => (string) SITECOOKIEPATH,
			'uid'    => (string) get_current_user_id(),
			'time'   => (string) time(),
			'secure' => (string) ( 'https' === parse_url( site_url(), PHP_URL_SCHEME ) ),
		)
	);

	$scripts->add( 'common', "/nx-admin/js/common$suffix.js", array( 'jquery', 'hoverIntent', 'utils', 'nx-a11y' ), false, 1 );
	$scripts->set_translations( 'common' );

	$scripts->add( 'nx-sanitize', "/nx-includes/js/nx-sanitize$suffix.js", array(), false, 1 );

	$scripts->add( 'sack', "/nx-includes/js/tw-sack$suffix.js", array(), '1.6.1', 1 );

	$scripts->add( 'quicktags', "/nx-includes/js/quicktags$suffix.js", array(), false, 1 );
	did_action( 'init' ) && $scripts->localize(
		'quicktags',
		'quicktagsL10n',
		array(
			'closeAllOpenTags'      => __( 'Close all open tags' ),
			'closeTags'             => __( 'close tags' ),
			'enterURL'              => __( 'Enter the URL' ),
			'enterImageURL'         => __( 'Enter the URL of the image' ),
			'enterImageDescription' => __( 'Enter a description of the image' ),
			'textdirection'         => __( 'text direction' ),
			'toggleTextdirection'   => __( 'Toggle Editor Text Direction' ),
			'dfw'                   => __( 'Distraction-free writing mode' ),
			'strong'                => __( 'Bold' ),
			'strongClose'           => __( 'Close bold tag' ),
			'em'                    => __( 'Italic' ),
			'emClose'               => __( 'Close italic tag' ),
			'link'                  => __( 'Insert link' ),
			'blockquote'            => __( 'Blockquote' ),
			'blockquoteClose'       => __( 'Close blockquote tag' ),
			'del'                   => __( 'Deleted text (strikethrough)' ),
			'delClose'              => __( 'Close deleted text tag' ),
			'ins'                   => __( 'Inserted text' ),
			'insClose'              => __( 'Close inserted text tag' ),
			'image'                 => __( 'Insert image' ),
			'ul'                    => __( 'Bulleted list' ),
			'ulClose'               => __( 'Close bulleted list tag' ),
			'ol'                    => __( 'Numbered list' ),
			'olClose'               => __( 'Close numbered list tag' ),
			'li'                    => __( 'List item' ),
			'liClose'               => __( 'Close list item tag' ),
			'code'                  => __( 'Code' ),
			'codeClose'             => __( 'Close code tag' ),
			'more'                  => __( 'Insert Read More tag' ),
		)
	);

	$scripts->add( 'colorpicker', "/nx-includes/js/colorpicker$suffix.js", array( 'prototype' ), '3517m' );

	$scripts->add( 'editor', "/nx-admin/js/editor$suffix.js", array( 'utils', 'jquery' ), false, 1 );

	$scripts->add( 'clipboard', "/nx-includes/js/clipboard$suffix.js", array(), '2.0.11', 1 );

	$scripts->add( 'nx-ajax-response', "/nx-includes/js/nx-ajax-response$suffix.js", array( 'jquery', 'nx-a11y' ), false, 1 );
	did_action( 'init' ) && $scripts->localize(
		'nx-ajax-response',
		'wpAjax',
		array(
			'noPerm' => __( 'Sorry, you are not allowed to do that.' ),
			'broken' => __( 'Something went wrong.' ),
		)
	);

	$scripts->add( 'nx-api-request', "/nx-includes/js/api-request$suffix.js", array( 'jquery' ), false, 1 );
	// `wpApiSettings` is also used by `nx-api`, which depends on this script.
	did_action( 'init' ) && $scripts->localize(
		'nx-api-request',
		'wpApiSettings',
		array(
			'root'          => sanitize_url( get_rest_url() ),
			'nonce'         => nx_installing() ? '' : nx_create_nonce( 'nx_rest' ),
			'versionString' => 'wp/v2/',
		)
	);

	$scripts->add( 'nx-pointer', "/nx-includes/js/nx-pointer$suffix.js", array( 'jquery-ui-core' ), false, 1 );
	$scripts->set_translations( 'nx-pointer' );

	$scripts->add( 'autosave', "/nx-includes/js/autosave$suffix.js", array( 'heartbeat' ), false, 1 );

	$scripts->add( 'heartbeat', "/nx-includes/js/heartbeat$suffix.js", array( 'jquery', 'nx-hooks' ), false, 1 );
	did_action( 'init' ) && $scripts->localize(
		'heartbeat',
		'heartbeatSettings',
		/**
		 * Filters the Heartbeat settings.
		 *
		 * @since 3.6.0
		 *
		 * @param array $settings Heartbeat settings array.
		 */
		apply_filters( 'heartbeat_settings', array() )
	);

	$scripts->add( 'nx-auth-check', "/nx-includes/js/nx-auth-check$suffix.js", array( 'heartbeat' ), false, 1 );
	$scripts->set_translations( 'nx-auth-check' );

	$scripts->add( 'nx-lists', "/nx-includes/js/nx-lists$suffix.js", array( 'nx-ajax-response', 'jquery-color' ), false, 1 );

	$scripts->add( 'site-icon', '/nx-admin/js/site-icon.js', array( 'jquery' ), false, 1 );
	$scripts->set_translations( 'site-icon' );

	// NexusPress no longer uses or bundles Prototype or script.aculo.us. These are now pulled from an external source.
	$scripts->add( 'prototype', 'https://ajax.googleapis.com/ajax/libs/prototype/1.7.1.0/prototype.js', array(), '1.7.1' );
	$scripts->add( 'scriptaculous-root', 'https://ajax.googleapis.com/ajax/libs/scriptaculous/1.9.0/scriptaculous.js', array( 'prototype' ), '1.9.0' );
	$scripts->add( 'scriptaculous-builder', 'https://ajax.googleapis.com/ajax/libs/scriptaculous/1.9.0/builder.js', array( 'scriptaculous-root' ), '1.9.0' );
	$scripts->add( 'scriptaculous-dragdrop', 'https://ajax.googleapis.com/ajax/libs/scriptaculous/1.9.0/dragdrop.js', array( 'scriptaculous-builder', 'scriptaculous-effects' ), '1.9.0' );
	$scripts->add( 'scriptaculous-effects', 'https://ajax.googleapis.com/ajax/libs/scriptaculous/1.9.0/effects.js', array( 'scriptaculous-root' ), '1.9.0' );
	$scripts->add( 'scriptaculous-slider', 'https://ajax.googleapis.com/ajax/libs/scriptaculous/1.9.0/slider.js', array( 'scriptaculous-effects' ), '1.9.0' );
	$scripts->add( 'scriptaculous-sound', 'https://ajax.googleapis.com/ajax/libs/scriptaculous/1.9.0/sound.js', array( 'scriptaculous-root' ), '1.9.0' );
	$scripts->add( 'scriptaculous-controls', 'https://ajax.googleapis.com/ajax/libs/scriptaculous/1.9.0/controls.js', array( 'scriptaculous-root' ), '1.9.0' );
	$scripts->add( 'scriptaculous', false, array( 'scriptaculous-dragdrop', 'scriptaculous-slider', 'scriptaculous-controls' ) );

	// Not used in core, replaced by Jcrop.js.
	$scripts->add( 'cropper', '/nx-includes/js/crop/cropper.js', array( 'scriptaculous-dragdrop' ) );

	/*
	 * jQuery.
	 * The unminified jquery.js and jquery-migrate.js are included to facilitate debugging.
	 */
	$scripts->add( 'jquery', false, array( 'jquery-core', 'jquery-migrate' ), '3.7.1' );
	$scripts->add( 'jquery-core', "/nx-includes/js/jquery/jquery$suffix.js", array(), '3.7.1' );
	$scripts->add( 'jquery-migrate', "/nx-includes/js/jquery/jquery-migrate$suffix.js", array(), '3.4.1' );

	/*
	 * Full jQuery UI.
	 * The build process in 1.12.1 has changed significantly.
	 * In order to keep backwards compatibility, and to keep the optimized loading,
	 * the source files were flattened and included with some modifications for AMD loading.
	 * A notable change is that 'jquery-ui-core' now contains 'jquery-ui-position' and 'jquery-ui-widget'.
	 */
	$scripts->add( 'jquery-ui-core', "/nx-includes/js/jquery/ui/core$suffix.js", array( 'jquery' ), '1.13.3', 1 );
	$scripts->add( 'jquery-effects-core', "/nx-includes/js/jquery/ui/effect$suffix.js", array( 'jquery' ), '1.13.3', 1 );

	$scripts->add( 'jquery-effects-blind', "/nx-includes/js/jquery/ui/effect-blind$suffix.js", array( 'jquery-effects-core' ), '1.13.3', 1 );
	$scripts->add( 'jquery-effects-bounce', "/nx-includes/js/jquery/ui/effect-bounce$suffix.js", array( 'jquery-effects-core' ), '1.13.3', 1 );
	$scripts->add( 'jquery-effects-clip', "/nx-includes/js/jquery/ui/effect-clip$suffix.js", array( 'jquery-effects-core' ), '1.13.3', 1 );
	$scripts->add( 'jquery-effects-drop', "/nx-includes/js/jquery/ui/effect-drop$suffix.js", array( 'jquery-effects-core' ), '1.13.3', 1 );
	$scripts->add( 'jquery-effects-explode', "/nx-includes/js/jquery/ui/effect-explode$suffix.js", array( 'jquery-effects-core' ), '1.13.3', 1 );
	$scripts->add( 'jquery-effects-fade', "/nx-includes/js/jquery/ui/effect-fade$suffix.js", array( 'jquery-effects-core' ), '1.13.3', 1 );
	$scripts->add( 'jquery-effects-fold', "/nx-includes/js/jquery/ui/effect-fold$suffix.js", array( 'jquery-effects-core' ), '1.13.3', 1 );
	$scripts->add( 'jquery-effects-highlight', "/nx-includes/js/jquery/ui/effect-highlight$suffix.js", array( 'jquery-effects-core' ), '1.13.3', 1 );
	$scripts->add( 'jquery-effects-puff', "/nx-includes/js/jquery/ui/effect-puff$suffix.js", array( 'jquery-effects-core', 'jquery-effects-scale' ), '1.13.3', 1 );
	$scripts->add( 'jquery-effects-pulsate', "/nx-includes/js/jquery/ui/effect-pulsate$suffix.js", array( 'jquery-effects-core' ), '1.13.3', 1 );
	$scripts->add( 'jquery-effects-scale', "/nx-includes/js/jquery/ui/effect-scale$suffix.js", array( 'jquery-effects-core', 'jquery-effects-size' ), '1.13.3', 1 );
	$scripts->add( 'jquery-effects-shake', "/nx-includes/js/jquery/ui/effect-shake$suffix.js", array( 'jquery-effects-core' ), '1.13.3', 1 );
	$scripts->add( 'jquery-effects-size', "/nx-includes/js/jquery/ui/effect-size$suffix.js", array( 'jquery-effects-core' ), '1.13.3', 1 );
	$scripts->add( 'jquery-effects-slide', "/nx-includes/js/jquery/ui/effect-slide$suffix.js", array( 'jquery-effects-core' ), '1.13.3', 1 );
	$scripts->add( 'jquery-effects-transfer', "/nx-includes/js/jquery/ui/effect-transfer$suffix.js", array( 'jquery-effects-core' ), '1.13.3', 1 );

	// Widgets
	$scripts->add( 'jquery-ui-accordion', "/nx-includes/js/jquery/ui/accordion$suffix.js", array( 'jquery-ui-core' ), '1.13.3', 1 );
	$scripts->add( 'jquery-ui-autocomplete', "/nx-includes/js/jquery/ui/autocomplete$suffix.js", array( 'jquery-ui-menu', 'nx-a11y' ), '1.13.3', 1 );
	$scripts->add( 'jquery-ui-button', "/nx-includes/js/jquery/ui/button$suffix.js", array( 'jquery-ui-core', 'jquery-ui-controlgroup', 'jquery-ui-checkboxradio' ), '1.13.3', 1 );
	$scripts->add( 'jquery-ui-datepicker', "/nx-includes/js/jquery/ui/datepicker$suffix.js", array( 'jquery-ui-core' ), '1.13.3', 1 );
	$scripts->add( 'jquery-ui-dialog', "/nx-includes/js/jquery/ui/dialog$suffix.js", array( 'jquery-ui-resizable', 'jquery-ui-draggable', 'jquery-ui-button' ), '1.13.3', 1 );
	$scripts->add( 'jquery-ui-menu', "/nx-includes/js/jquery/ui/menu$suffix.js", array( 'jquery-ui-core' ), '1.13.3', 1 );
	$scripts->add( 'jquery-ui-mouse', "/nx-includes/js/jquery/ui/mouse$suffix.js", array( 'jquery-ui-core' ), '1.13.3', 1 );
	$scripts->add( 'jquery-ui-progressbar', "/nx-includes/js/jquery/ui/progressbar$suffix.js", array( 'jquery-ui-core' ), '1.13.3', 1 );
	$scripts->add( 'jquery-ui-selectmenu', "/nx-includes/js/jquery/ui/selectmenu$suffix.js", array( 'jquery-ui-menu' ), '1.13.3', 1 );
	$scripts->add( 'jquery-ui-slider', "/nx-includes/js/jquery/ui/slider$suffix.js", array( 'jquery-ui-mouse' ), '1.13.3', 1 );
	$scripts->add( 'jquery-ui-spinner', "/nx-includes/js/jquery/ui/spinner$suffix.js", array( 'jquery-ui-button' ), '1.13.3', 1 );
	$scripts->add( 'jquery-ui-tabs', "/nx-includes/js/jquery/ui/tabs$suffix.js", array( 'jquery-ui-core' ), '1.13.3', 1 );
	$scripts->add( 'jquery-ui-tooltip', "/nx-includes/js/jquery/ui/tooltip$suffix.js", array( 'jquery-ui-core' ), '1.13.3', 1 );

	// New in 1.12.1
	$scripts->add( 'jquery-ui-checkboxradio', "/nx-includes/js/jquery/ui/checkboxradio$suffix.js", array( 'jquery-ui-core' ), '1.13.3', 1 );
	$scripts->add( 'jquery-ui-controlgroup', "/nx-includes/js/jquery/ui/controlgroup$suffix.js", array( 'jquery-ui-core' ), '1.13.3', 1 );

	// Interactions
	$scripts->add( 'jquery-ui-draggable', "/nx-includes/js/jquery/ui/draggable$suffix.js", array( 'jquery-ui-mouse' ), '1.13.3', 1 );
	$scripts->add( 'jquery-ui-droppable', "/nx-includes/js/jquery/ui/droppable$suffix.js", array( 'jquery-ui-draggable' ), '1.13.3', 1 );
	$scripts->add( 'jquery-ui-resizable', "/nx-includes/js/jquery/ui/resizable$suffix.js", array( 'jquery-ui-mouse' ), '1.13.3', 1 );
	$scripts->add( 'jquery-ui-selectable', "/nx-includes/js/jquery/ui/selectable$suffix.js", array( 'jquery-ui-mouse' ), '1.13.3', 1 );
	$scripts->add( 'jquery-ui-sortable', "/nx-includes/js/jquery/ui/sortable$suffix.js", array( 'jquery-ui-mouse' ), '1.13.3', 1 );

	/*
	 * As of 1.12.1 `jquery-ui-position` and `jquery-ui-widget` are part of `jquery-ui-core`.
	 * Listed here for back-compat.
	 */
	$scripts->add( 'jquery-ui-position', false, array( 'jquery-ui-core' ), '1.13.3', 1 );
	$scripts->add( 'jquery-ui-widget', false, array( 'jquery-ui-core' ), '1.13.3', 1 );

	// Deprecated, not used in core, most functionality is included in jQuery 1.3.
	$scripts->add( 'jquery-form', "/nx-includes/js/jquery/jquery.form$suffix.js", array( 'jquery' ), '4.3.0', 1 );

	// jQuery plugins.
	$scripts->add( 'jquery-color', '/nx-includes/js/jquery/jquery.color.min.js', array( 'jquery' ), '3.0.0', 1 );
	$scripts->add( 'schedule', '/nx-includes/js/jquery/jquery.schedule.js', array( 'jquery' ), '20m', 1 );
	$scripts->add( 'jquery-query', '/nx-includes/js/jquery/jquery.query.js', array( 'jquery' ), '2.2.3', 1 );
	$scripts->add( 'jquery-serialize-object', '/nx-includes/js/jquery/jquery.serialize-object.js', array( 'jquery' ), '0.2-wp', 1 );
	$scripts->add( 'jquery-hotkeys', "/nx-includes/js/jquery/jquery.hotkeys$suffix.js", array( 'jquery' ), '0.0.2m', 1 );
	$scripts->add( 'jquery-table-hotkeys', "/nx-includes/js/jquery/jquery.table-hotkeys$suffix.js", array( 'jquery', 'jquery-hotkeys' ), false, 1 );
	$scripts->add( 'jquery-touch-punch', '/nx-includes/js/jquery/jquery.ui.touch-punch.js', array( 'jquery-ui-core', 'jquery-ui-mouse' ), '0.2.2', 1 );

	// Not used any more, registered for backward compatibility.
	$scripts->add( 'suggest', "/nx-includes/js/jquery/suggest$suffix.js", array( 'jquery' ), '1.1-20110113', 1 );

	/*
	 * Masonry v2 depended on jQuery. v3 does not. The older jquery-masonry handle is a shiv.
	 * It sets jQuery as a dependency, as the theme may have been implicitly loading it this way.
	 */
	$scripts->add( 'imagesloaded', '/nx-includes/js/imagesloaded.min.js', array(), '5.0.0', 1 );
	$scripts->add( 'masonry', '/nx-includes/js/masonry.min.js', array( 'imagesloaded' ), '4.2.2', 1 );
	$scripts->add( 'jquery-masonry', '/nx-includes/js/jquery/jquery.masonry.min.js', array( 'jquery', 'masonry' ), '3.1.2b', 1 );

	$scripts->add( 'thickbox', '/nx-includes/js/thickbox/thickbox.js', array( 'jquery' ), '3.1-20121105', 1 );
	did_action( 'init' ) && $scripts->localize(
		'thickbox',
		'thickboxL10n',
		array(
			'next'             => __( 'Next &gt;' ),
			'prev'             => __( '&lt; Prev' ),
			'image'            => __( 'Image' ),
			'of'               => __( 'of' ),
			'close'            => __( 'Close' ),
			'noiframes'        => __( 'This feature requires inline frames. You have iframes disabled or your browser does not support them.' ),
			'loadingAnimation' => includes_url( 'js/thickbox/loadingAnimation.gif' ),
		)
	);

	// Not used in core, replaced by imgAreaSelect.
	$scripts->add( 'jcrop', '/nx-includes/js/jcrop/jquery.Jcrop.min.js', array( 'jquery' ), '0.9.15' );

	$scripts->add( 'swfobject', '/nx-includes/js/swfobject.js', array(), '2.2-20120417' );

	// Error messages for Plupload.
	$uploader_l10n = array(
		'queue_limit_exceeded'      => __( 'You have attempted to queue too many files.' ),
		/* translators: %s: File name. */
		'file_exceeds_size_limit'   => __( '%s exceeds the maximum upload size for this site.' ),
		'zero_byte_file'            => __( 'This file is empty. Please try another.' ),
		'invalid_filetype'          => __( 'Sorry, you are not allowed to upload this file type.' ),
		'not_an_image'              => __( 'This file is not an image. Please try another.' ),
		'image_memory_exceeded'     => __( 'Memory exceeded. Please try another smaller file.' ),
		'image_dimensions_exceeded' => __( 'This is larger than the maximum size. Please try another.' ),
		'default_error'             => __( 'An error occurred in the upload. Please try again later.' ),
		'missing_upload_url'        => __( 'There was a configuration error. Please contact the server administrator.' ),
		'upload_limit_exceeded'     => __( 'You may only upload 1 file.' ),
		'http_error'                => __( 'Unexpected response from the server. The file may have been uploaded successfully. Check in the Media Library or reload the page.' ),
		'http_error_image'          => __( 'The server cannot process the image. This can happen if the server is busy or does not have enough resources to complete the task. Uploading a smaller image may help. Suggested maximum size is 2560 pixels.' ),
		'upload_failed'             => __( 'Upload failed.' ),
		/* translators: 1: Opening link tag, 2: Closing link tag. */
		'big_upload_failed'         => __( 'Please try uploading this file with the %1$sbrowser uploader%2$s.' ),
		/* translators: %s: File name. */
		'big_upload_queued'         => __( '%s exceeds the maximum upload size for the multi-file uploader when used in your browser.' ),
		'io_error'                  => __( 'IO error.' ),
		'security_error'            => __( 'Security error.' ),
		'file_cancelled'            => __( 'File canceled.' ),
		'upload_stopped'            => __( 'Upload stopped.' ),
		'dismiss'                   => __( 'Dismiss' ),
		'crunching'                 => __( 'Crunching&hellip;' ),
		'deleted'                   => __( 'moved to the Trash.' ),
		/* translators: %s: File name. */
		'error_uploading'           => __( '&#8220;%s&#8221; has failed to upload.' ),
		'unsupported_image'         => __( 'This image cannot be displayed in a web browser. For best results convert it to JPEG before uploading.' ),
		'noneditable_image'         => __( 'This image cannot be processed by the web server. Convert it to JPEG or PNG before uploading.' ),
		'file_url_copied'           => __( 'The file URL has been copied to your clipboard' ),
	);

	$scripts->add( 'moxiejs', "/nx-includes/js/plupload/moxie$suffix.js", array(), '1.3.5' );
	$scripts->add( 'plupload', "/nx-includes/js/plupload/plupload$suffix.js", array( 'moxiejs' ), '2.1.9' );
	// Back compat handles:
	foreach ( array( 'all', 'html5', 'flash', 'silverlight', 'html4' ) as $handle ) {
		$scripts->add( "plupload-$handle", false, array( 'plupload' ), '2.1.1' );
	}

	$scripts->add( 'plupload-handlers', "/nx-includes/js/plupload/handlers$suffix.js", array( 'clipboard', 'jquery', 'plupload', 'underscore', 'nx-a11y', 'nx-i18n' ) );
	did_action( 'init' ) && $scripts->localize( 'plupload-handlers', 'pluploadL10n', $uploader_l10n );

	$scripts->add( 'nx-plupload', "/nx-includes/js/plupload/nx-plupload$suffix.js", array( 'plupload', 'jquery', 'json2', 'media-models' ), false, 1 );
	did_action( 'init' ) && $scripts->localize( 'nx-plupload', 'pluploadL10n', $uploader_l10n );

	// Keep 'swfupload' for back-compat.
	$scripts->add( 'swfupload', '/nx-includes/js/swfupload/swfupload.js', array(), '2201-20110113' );
	$scripts->add( 'swfupload-all', false, array( 'swfupload' ), '2201' );
	$scripts->add( 'swfupload-handlers', "/nx-includes/js/swfupload/handlers$suffix.js", array( 'swfupload-all', 'jquery' ), '2201-20110524' );
	did_action( 'init' ) && $scripts->localize( 'swfupload-handlers', 'swfuploadL10n', $uploader_l10n );

	$scripts->add( 'comment-reply', "/nx-includes/js/comment-reply$suffix.js", array(), false, 1 );
	did_action( 'init' ) && $scripts->add_data( 'comment-reply', 'strategy', 'async' );

	$scripts->add( 'json2', "/nx-includes/js/json2$suffix.js", array(), '2015-05-03' );
	did_action( 'init' ) && $scripts->add_data( 'json2', 'conditional', 'lt IE 8' );

	$scripts->add( 'underscore', "/nx-includes/js/underscore$dev_suffix.js", array(), '1.13.7', 1 );
	$scripts->add( 'backbone', "/nx-includes/js/backbone$dev_suffix.js", array( 'underscore', 'jquery' ), '1.6.0', 1 );

	$scripts->add( 'nx-util', "/nx-includes/js/nx-util$suffix.js", array( 'underscore', 'jquery' ), false, 1 );
	did_action( 'init' ) && $scripts->localize(
		'nx-util',
		'_wpUtilSettings',
		array(
			'ajax' => array(
				'url' => admin_url( 'admin-ajax.php', 'relative' ),
			),
		)
	);

	$scripts->add( 'nx-backbone', "/nx-includes/js/nx-backbone$suffix.js", array( 'backbone', 'nx-util' ), false, 1 );

	$scripts->add( 'revisions', "/nx-admin/js/revisions$suffix.js", array( 'nx-backbone', 'jquery-ui-slider', 'hoverIntent' ), false, 1 );

	$scripts->add( 'imgareaselect', "/nx-includes/js/imgareaselect/jquery.imgareaselect$suffix.js", array( 'jquery' ), false, 1 );

	$scripts->add( 'mediaelement', false, array( 'jquery', 'mediaelement-core', 'mediaelement-migrate' ), '4.2.17', 1 );
	$scripts->add( 'mediaelement-core', "/nx-includes/js/mediaelement/mediaelement-and-player$suffix.js", array(), '4.2.17', 1 );
	$scripts->add( 'mediaelement-migrate', "/nx-includes/js/mediaelement/mediaelement-migrate$suffix.js", array(), false, 1 );

	did_action( 'init' ) && $scripts->add_inline_script(
		'mediaelement-core',
		sprintf(
			'var mejsL10n = %s;',
			nx_json_encode(
				array(
					'language' => strtolower( strtok( determine_locale(), '_-' ) ),
					'strings'  => array(
						'mejs.download-file'       => __( 'Download File' ),
						'mejs.install-flash'       => __( 'You are using a browser that does not have Flash player enabled or installed. Please turn on your Flash player plugin or download the latest version from https://get.adobe.com/flashplayer/' ),
						'mejs.fullscreen'          => __( 'Fullscreen' ),
						'mejs.play'                => __( 'Play' ),
						'mejs.pause'               => __( 'Pause' ),
						'mejs.time-slider'         => __( 'Time Slider' ),
						'mejs.time-help-text'      => __( 'Use Left/Right Arrow keys to advance one second, Up/Down arrows to advance ten seconds.' ),
						'mejs.live-broadcast'      => __( 'Live Broadcast' ),
						'mejs.volume-help-text'    => __( 'Use Up/Down Arrow keys to increase or decrease volume.' ),
						'mejs.unmute'              => __( 'Unmute' ),
						'mejs.mute'                => __( 'Mute' ),
						'mejs.volume-slider'       => __( 'Volume Slider' ),
						'mejs.video-player'        => __( 'Video Player' ),
						'mejs.audio-player'        => __( 'Audio Player' ),
						'mejs.captions-subtitles'  => __( 'Captions/Subtitles' ),
						'mejs.captions-chapters'   => __( 'Chapters' ),
						'mejs.none'                => __( 'None' ),
						'mejs.afrikaans'           => __( 'Afrikaans' ),
						'mejs.albanian'            => __( 'Albanian' ),
						'mejs.arabic'              => __( 'Arabic' ),
						'mejs.belarusian'          => __( 'Belarusian' ),
						'mejs.bulgarian'           => __( 'Bulgarian' ),
						'mejs.catalan'             => __( 'Catalan' ),
						'mejs.chinese'             => __( 'Chinese' ),
						'mejs.chinese-simplified'  => __( 'Chinese (Simplified)' ),
						'mejs.chinese-traditional' => __( 'Chinese (Traditional)' ),
						'mejs.croatian'            => __( 'Croatian' ),
						'mejs.czech'               => __( 'Czech' ),
						'mejs.danish'              => __( 'Danish' ),
						'mejs.dutch'               => __( 'Dutch' ),
						'mejs.english'             => __( 'English' ),
						'mejs.estonian'            => __( 'Estonian' ),
						'mejs.filipino'            => __( 'Filipino' ),
						'mejs.finnish'             => __( 'Finnish' ),
						'mejs.french'              => __( 'French' ),
						'mejs.galician'            => __( 'Galician' ),
						'mejs.german'              => __( 'German' ),
						'mejs.greek'               => __( 'Greek' ),
						'mejs.haitian-creole'      => __( 'Haitian Creole' ),
						'mejs.hebrew'              => __( 'Hebrew' ),
						'mejs.hindi'               => __( 'Hindi' ),
						'mejs.hungarian'           => __( 'Hungarian' ),
						'mejs.icelandic'           => __( 'Icelandic' ),
						'mejs.indonesian'          => __( 'Indonesian' ),
						'mejs.irish'               => __( 'Irish' ),
						'mejs.italian'             => __( 'Italian' ),
						'mejs.japanese'            => __( 'Japanese' ),
						'mejs.korean'              => __( 'Korean' ),
						'mejs.latvian'             => __( 'Latvian' ),
						'mejs.lithuanian'          => __( 'Lithuanian' ),
						'mejs.macedonian'          => __( 'Macedonian' ),
						'mejs.malay'               => __( 'Malay' ),
						'mejs.maltese'             => __( 'Maltese' ),
						'mejs.norwegian'           => __( 'Norwegian' ),
						'mejs.persian'             => __( 'Persian' ),
						'mejs.polish'              => __( 'Polish' ),
						'mejs.portuguese'          => __( 'Portuguese' ),
						'mejs.romanian'            => __( 'Romanian' ),
						'mejs.russian'             => __( 'Russian' ),
						'mejs.serbian'             => __( 'Serbian' ),
						'mejs.slovak'              => __( 'Slovak' ),
						'mejs.slovenian'           => __( 'Slovenian' ),
						'mejs.spanish'             => __( 'Spanish' ),
						'mejs.swahili'             => __( 'Swahili' ),
						'mejs.swedish'             => __( 'Swedish' ),
						'mejs.tagalog'             => __( 'Tagalog' ),
						'mejs.thai'                => __( 'Thai' ),
						'mejs.turkish'             => __( 'Turkish' ),
						'mejs.ukrainian'           => __( 'Ukrainian' ),
						'mejs.vietnamese'          => __( 'Vietnamese' ),
						'mejs.welsh'               => __( 'Welsh' ),
						'mejs.yiddish'             => __( 'Yiddish' ),
					),
				)
			)
		),
		'before'
	);

	$scripts->add( 'mediaelement-vimeo', '/nx-includes/js/mediaelement/renderers/vimeo.min.js', array( 'mediaelement' ), '4.2.17', 1 );
	$scripts->add( 'nx-mediaelement', "/nx-includes/js/mediaelement/nx-mediaelement$suffix.js", array( 'mediaelement' ), false, 1 );
	$mejs_settings = array(
		'pluginPath'            => includes_url( 'js/mediaelement/', 'relative' ),
		'classPrefix'           => 'mejs-',
		'stretching'            => 'responsive',
		/** This filter is documented in nx-includes/media.php */
		'audioShortcodeLibrary' => apply_filters( 'nx_audio_shortcode_library', 'mediaelement' ),
		/** This filter is documented in nx-includes/media.php */
		'videoShortcodeLibrary' => apply_filters( 'nx_video_shortcode_library', 'mediaelement' ),
	);
	did_action( 'init' ) && $scripts->localize(
		'mediaelement',
		'_wpmejsSettings',
		/**
		 * Filters the MediaElement configuration settings.
		 *
		 * @since 4.4.0
		 *
		 * @param array $mejs_settings MediaElement settings array.
		 */
		apply_filters( 'mejs_settings', $mejs_settings )
	);

	$scripts->add( 'nx-codemirror', '/nx-includes/js/codemirror/codemirror.min.js', array(), '5.29.1-alpha-ee20357' );
	$scripts->add( 'csslint', '/nx-includes/js/codemirror/csslint.js', array(), '1.0.5' );
	$scripts->add( 'esprima', '/nx-includes/js/codemirror/esprima.js', array(), '4.0.0' );
	$scripts->add( 'jshint', '/nx-includes/js/codemirror/fakejshint.js', array( 'esprima' ), '2.9.5' );
	$scripts->add( 'jsonlint', '/nx-includes/js/codemirror/jsonlint.js', array(), '1.6.2' );
	$scripts->add( 'htmlhint', '/nx-includes/js/codemirror/htmlhint.js', array(), '0.9.14-xwp' );
	$scripts->add( 'htmlhint-kses', '/nx-includes/js/codemirror/htmlhint-kses.js', array( 'htmlhint' ) );
	$scripts->add( 'code-editor', "/nx-admin/js/code-editor$suffix.js", array( 'jquery', 'nx-codemirror', 'underscore' ) );
	$scripts->add( 'nx-theme-plugin-editor', "/nx-admin/js/theme-plugin-editor$suffix.js", array( 'common', 'nx-util', 'nx-sanitize', 'jquery', 'jquery-ui-core', 'nx-a11y', 'underscore' ), false, 1 );
	$scripts->set_translations( 'nx-theme-plugin-editor' );

	$scripts->add( 'nx-playlist', "/nx-includes/js/mediaelement/nx-playlist$suffix.js", array( 'nx-util', 'backbone', 'mediaelement' ), false, 1 );

	$scripts->add( 'zxcvbn-async', "/nx-includes/js/zxcvbn-async$suffix.js", array(), '1.0' );
	did_action( 'init' ) && $scripts->localize(
		'zxcvbn-async',
		'_zxcvbnSettings',
		array(
			'src' => empty( $guessed_url ) ? includes_url( '/js/zxcvbn.min.js' ) : $scripts->base_url . '/nx-includes/js/zxcvbn.min.js',
		)
	);

	$scripts->add( 'password-strength-meter', "/nx-admin/js/password-strength-meter$suffix.js", array( 'jquery', 'zxcvbn-async' ), false, 1 );
	did_action( 'init' ) && $scripts->localize(
		'password-strength-meter',
		'pwsL10n',
		array(
			'unknown'  => _x( 'Password strength unknown', 'password strength' ),
			'short'    => _x( 'Very weak', 'password strength' ),
			'bad'      => _x( 'Weak', 'password strength' ),
			'good'     => _x( 'Medium', 'password strength' ),
			'strong'   => _x( 'Strong', 'password strength' ),
			'mismatch' => _x( 'Mismatch', 'password mismatch' ),
		)
	);
	$scripts->set_translations( 'password-strength-meter' );

	$scripts->add( 'password-toggle', "/nx-admin/js/password-toggle$suffix.js", array(), false, 1 );
	$scripts->set_translations( 'password-toggle' );

	$scripts->add( 'application-passwords', "/nx-admin/js/application-passwords$suffix.js", array( 'jquery', 'nx-util', 'nx-api-request', 'nx-date', 'nx-i18n', 'nx-hooks' ), false, 1 );
	$scripts->set_translations( 'application-passwords' );

	$scripts->add( 'auth-app', "/nx-admin/js/auth-app$suffix.js", array( 'jquery', 'nx-api-request', 'nx-i18n', 'nx-hooks' ), false, 1 );
	$scripts->set_translations( 'auth-app' );

	$scripts->add( 'user-profile', "/nx-admin/js/user-profile$suffix.js", array( 'clipboard', 'jquery', 'password-strength-meter', 'nx-util', 'nx-a11y' ), false, 1 );
	$scripts->set_translations( 'user-profile' );
	$user_id = isset( $_GET['user_id'] ) ? (int) $_GET['user_id'] : 0;
	did_action( 'init' ) && $scripts->localize(
		'user-profile',
		'userProfileL10n',
		array(
			'user_id' => $user_id,
			'nonce'   => nx_installing() ? '' : nx_create_nonce( 'reset-password-for-' . $user_id ),
		)
	);

	$scripts->add( 'language-chooser', "/nx-admin/js/language-chooser$suffix.js", array( 'jquery' ), false, 1 );

	$scripts->add( 'user-suggest', "/nx-admin/js/user-suggest$suffix.js", array( 'jquery-ui-autocomplete' ), false, 1 );

	$scripts->add( 'admin-bar', "/nx-includes/js/admin-bar$suffix.js", array( 'hoverintent-js' ), false, 1 );

	$scripts->add( 'nxlink', "/nx-includes/js/wplink$suffix.js", array( 'common', 'jquery', 'nx-a11y', 'nx-i18n' ), false, 1 );
	$scripts->set_translations( 'nxlink' );
	did_action( 'init' ) && $scripts->localize(
		'nxlink',
		'wpLinkL10n',
		array(
			'title'          => __( 'Insert/edit link' ),
			'update'         => __( 'Update' ),
			'save'           => __( 'Add Link' ),
			'noTitle'        => __( '(no title)' ),
			'noMatchesFound' => __( 'No results found.' ),
			'linkSelected'   => __( 'Link selected.' ),
			'linkInserted'   => __( 'Link inserted.' ),
			/* translators: Minimum input length in characters to start searching posts in the "Insert/edit link" modal. */
			'minInputLength' => (int) _x( '3', 'minimum input length for searching post links' ),
		)
	);

	$scripts->add( 'nxdialogs', "/nx-includes/js/wpdialog$suffix.js", array( 'jquery-ui-dialog' ), false, 1 );

	$scripts->add( 'word-count', "/nx-admin/js/word-count$suffix.js", array(), false, 1 );

	$scripts->add( 'media-upload', "/nx-admin/js/media-upload$suffix.js", array( 'thickbox', 'shortcode' ), false, 1 );

	$scripts->add( 'hoverIntent', "/nx-includes/js/hoverIntent$suffix.js", array( 'jquery' ), '1.10.2', 1 );

	// JS-only version of hoverintent (no dependencies).
	$scripts->add( 'hoverintent-js', '/nx-includes/js/hoverintent-js.min.js', array(), '2.2.1', 1 );

	$scripts->add( 'customize-base', "/nx-includes/js/customize-base$suffix.js", array( 'jquery', 'json2', 'underscore' ), false, 1 );
	$scripts->add( 'customize-loader', "/nx-includes/js/customize-loader$suffix.js", array( 'customize-base' ), false, 1 );
	$scripts->add( 'customize-preview', "/nx-includes/js/customize-preview$suffix.js", array( 'nx-a11y', 'customize-base' ), false, 1 );
	$scripts->add( 'customize-models', '/nx-includes/js/customize-models.js', array( 'underscore', 'backbone' ), false, 1 );
	$scripts->add( 'customize-views', '/nx-includes/js/customize-views.js', array( 'jquery', 'underscore', 'imgareaselect', 'customize-models', 'media-editor', 'media-views' ), false, 1 );
	$scripts->add( 'customize-controls', "/nx-admin/js/customize-controls$suffix.js", array( 'customize-base', 'nx-a11y', 'nx-util', 'jquery-ui-core' ), false, 1 );
	did_action( 'init' ) && $scripts->localize(
		'customize-controls',
		'_wpCustomizeControlsL10n',
		array(
			'activate'                => __( 'Activate &amp; Publish' ),
			'save'                    => __( 'Save &amp; Publish' ), // @todo Remove as not required.
			'publish'                 => __( 'Publish' ),
			'published'               => __( 'Published' ),
			'saveDraft'               => __( 'Save Draft' ),
			'draftSaved'              => __( 'Draft Saved' ),
			'updating'                => __( 'Updating' ),
			'schedule'                => _x( 'Schedule', 'customizer changeset action/button label' ),
			'scheduled'               => _x( 'Scheduled', 'customizer changeset status' ),
			'invalid'                 => __( 'Invalid' ),
			'saveBeforeShare'         => __( 'Please save your changes in order to share the preview.' ),
			'futureDateError'         => __( 'You must supply a future date to schedule.' ),
			'saveAlert'               => __( 'The changes you made will be lost if you navigate away from this page.' ),
			'saved'                   => __( 'Saved' ),
			'cancel'                  => __( 'Cancel' ),
			'close'                   => __( 'Close' ),
			'action'                  => __( 'Action' ),
			'discardChanges'          => __( 'Discard changes' ),
			'cheatin'                 => __( 'Something went wrong.' ),
			'notAllowedHeading'       => __( 'You need a higher level of permission.' ),
			'notAllowed'              => __( 'Sorry, you are not allowed to customize this site.' ),
			'previewIframeTitle'      => __( 'Site Preview' ),
			'loginIframeTitle'        => __( 'Session expired' ),
			'collapseSidebar'         => _x( 'Hide Controls', 'label for hide controls button without length constraints' ),
			'expandSidebar'           => _x( 'Show Controls', 'label for hide controls button without length constraints' ),
			'untitledBlogName'        => __( '(Untitled)' ),
			'unknownRequestFail'      => __( 'Looks like something&#8217;s gone wrong. Wait a couple seconds, and then try again.' ),
			'themeDownloading'        => __( 'Downloading your new theme&hellip;' ),
			'themePreviewWait'        => __( 'Setting up your live preview. This may take a bit.' ),
			'revertingChanges'        => __( 'Reverting unpublished changes&hellip;' ),
			'trashConfirm'            => __( 'Are you sure you want to discard your unpublished changes?' ),
			/* translators: %s: Display name of the user who has taken over the changeset in customizer. */
			'takenOverMessage'        => __( '%s has taken over and is currently customizing.' ),
			/* translators: %s: URL to the Customizer to load the autosaved version. */
			'autosaveNotice'          => __( 'There is a more recent autosave of your changes than the one you are previewing. <a href="%s">Restore the autosave</a>' ),
			'videoHeaderNotice'       => __( 'This theme does not support video headers on this page. Navigate to the front page or another page that supports video headers.' ),
			// Used for overriding the file types allowed in Plupload.
			'allowedFiles'            => __( 'Allowed Files' ),
			'customCssError'          => array(
				/* translators: %d: Error count. */
				'singular' => _n( 'There is %d error which must be fixed before you can save.', 'There are %d errors which must be fixed before you can save.', 1 ),
				/* translators: %d: Error count. */
				'plural'   => _n( 'There is %d error which must be fixed before you can save.', 'There are %d errors which must be fixed before you can save.', 2 ),
				// @todo This is lacking, as some languages have a dedicated dual form. For proper handling of plurals in JS, see #20491.
			),
			'pageOnFrontError'        => __( 'Homepage and posts page must be different.' ),
			'saveBlockedError'        => array(
				/* translators: %s: Number of invalid settings. */
				'singular' => _n( 'Unable to save due to %s invalid setting.', 'Unable to save due to %s invalid settings.', 1 ),
				/* translators: %s: Number of invalid settings. */
				'plural'   => _n( 'Unable to save due to %s invalid setting.', 'Unable to save due to %s invalid settings.', 2 ),
				// @todo This is lacking, as some languages have a dedicated dual form. For proper handling of plurals in JS, see #20491.
			),
			'scheduleDescription'     => __( 'Schedule your customization changes to publish ("go live") at a future date.' ),
			'themePreviewUnavailable' => __( 'Sorry, you cannot preview new themes when you have changes scheduled or saved as a draft. Please publish your changes, or wait until they publish to preview new themes.' ),
			'themeInstallUnavailable' => sprintf(
				/* translators: %s: URL to Add Themes admin screen. */
				__( 'You will not be able to install new themes from here yet since your install requires SFTP credentials. For now, please <a href="%s">add themes in the admin</a>.' ),
				esc_url( admin_url( 'theme-install.php' ) )
			),
			'publishSettings'         => __( 'Publish Settings' ),
			'invalidDate'             => __( 'Invalid date.' ),
			'invalidValue'            => __( 'Invalid value.' ),
			'blockThemeNotification'  => sprintf(
				/* translators: 1: Link to Site Editor documentation on HelpHub, 2: HTML button. */
				__( 'Hurray! Your theme supports site editing with blocks. <a href="%1$s">Tell me more</a>. %2$s' ),
				__( 'https://nexuspress.org/documentation/article/site-editor/' ),
				sprintf(
					'<button type="button" data-action="%1$s" class="button switch-to-editor">%2$s</button>',
					esc_url( admin_url( 'site-editor.php' ) ),
					__( 'Use Site Editor' )
				)
			),
		)
	);
	$scripts->add( 'customize-selective-refresh', "/nx-includes/js/customize-selective-refresh$suffix.js", array( 'jquery', 'nx-util', 'customize-preview' ), false, 1 );

	$scripts->add( 'customize-widgets', "/nx-admin/js/customize-widgets$suffix.js", array( 'jquery', 'jquery-ui-sortable', 'jquery-ui-droppable', 'nx-backbone', 'customize-controls' ), false, 1 );
	$scripts->add( 'customize-preview-widgets', "/nx-includes/js/customize-preview-widgets$suffix.js", array( 'jquery', 'nx-util', 'customize-preview', 'customize-selective-refresh' ), false, 1 );

	$scripts->add( 'customize-nav-menus', "/nx-admin/js/customize-nav-menus$suffix.js", array( 'jquery', 'nx-backbone', 'customize-controls', 'accordion', 'nav-menu', 'nx-sanitize' ), false, 1 );
	$scripts->add( 'customize-preview-nav-menus', "/nx-includes/js/customize-preview-nav-menus$suffix.js", array( 'jquery', 'nx-util', 'customize-preview', 'customize-selective-refresh' ), false, 1 );

	$scripts->add( 'nx-custom-header', "/nx-includes/js/nx-custom-header$suffix.js", array( 'nx-a11y' ), false, 1 );

	$scripts->add( 'accordion', "/nx-admin/js/accordion$suffix.js", array( 'jquery' ), false, 1 );

	$scripts->add( 'shortcode', "/nx-includes/js/shortcode$suffix.js", array( 'underscore' ), false, 1 );
	$scripts->add( 'media-models', "/nx-includes/js/media-models$suffix.js", array( 'nx-backbone' ), false, 1 );
	did_action( 'init' ) && $scripts->localize(
		'media-models',
		'_wpMediaModelsL10n',
		array(
			'settings' => array(
				'ajaxurl' => admin_url( 'admin-ajax.php', 'relative' ),
				'post'    => array( 'id' => 0 ),
			),
		)
	);

	$scripts->add( 'nx-embed', "/nx-includes/js/nx-embed$suffix.js" );
	did_action( 'init' ) && $scripts->add_data( 'nx-embed', 'strategy', 'defer' );

	/*
	 * To enqueue media-views or media-editor, call nx_enqueue_media().
	 * Both rely on numerous settings, styles, and templates to operate correctly.
	 */
	$scripts->add( 'media-views', "/nx-includes/js/media-views$suffix.js", array( 'utils', 'media-models', 'nx-plupload', 'jquery-ui-sortable', 'nx-mediaelement', 'nx-api-request', 'nx-a11y', 'clipboard' ), false, 1 );
	$scripts->set_translations( 'media-views' );

	$scripts->add( 'media-editor', "/nx-includes/js/media-editor$suffix.js", array( 'shortcode', 'media-views' ), false, 1 );
	$scripts->set_translations( 'media-editor' );
	$scripts->add( 'media-audiovideo', "/nx-includes/js/media-audiovideo$suffix.js", array( 'media-editor' ), false, 1 );
	$scripts->add( 'mce-view', "/nx-includes/js/mce-view$suffix.js", array( 'shortcode', 'jquery', 'media-views', 'media-audiovideo' ), false, 1 );

	$scripts->add( 'nx-api', "/nx-includes/js/nx-api$suffix.js", array( 'jquery', 'backbone', 'underscore', 'nx-api-request' ), false, 1 );

	if ( is_admin() ) {
		$scripts->add( 'admin-tags', "/nx-admin/js/tags$suffix.js", array( 'jquery', 'nx-ajax-response' ), false, 1 );
		$scripts->set_translations( 'admin-tags' );

		$scripts->add( 'admin-comments', "/nx-admin/js/edit-comments$suffix.js", array( 'nx-lists', 'quicktags', 'jquery-query', 'nx-a11y' ), false, 1 );
		$scripts->set_translations( 'admin-comments' );
		did_action( 'init' ) && $scripts->localize(
			'admin-comments',
			'adminCommentsSettings',
			array(
				'hotkeys_highlight_first' => isset( $_GET['hotkeys_highlight_first'] ),
				'hotkeys_highlight_last'  => isset( $_GET['hotkeys_highlight_last'] ),
			)
		);

		$scripts->add( 'xfn', "/nx-admin/js/xfn$suffix.js", array( 'jquery' ), false, 1 );

		$scripts->add( 'postbox', "/nx-admin/js/postbox$suffix.js", array( 'jquery-ui-sortable', 'nx-a11y' ), false, 1 );
		$scripts->set_translations( 'postbox' );

		$scripts->add( 'tags-box', "/nx-admin/js/tags-box$suffix.js", array( 'jquery', 'tags-suggest' ), false, 1 );
		$scripts->set_translations( 'tags-box' );

		$scripts->add( 'tags-suggest', "/nx-admin/js/tags-suggest$suffix.js", array( 'common', 'jquery-ui-autocomplete', 'nx-a11y', 'nx-i18n' ), false, 1 );
		$scripts->set_translations( 'tags-suggest' );

		$scripts->add( 'post', "/nx-admin/js/post$suffix.js", array( 'suggest', 'nx-lists', 'postbox', 'tags-box', 'underscore', 'word-count', 'nx-a11y', 'nx-sanitize', 'clipboard' ), false, 1 );
		$scripts->set_translations( 'post' );

		$scripts->add( 'editor-expand', "/nx-admin/js/editor-expand$suffix.js", array( 'jquery', 'underscore' ), false, 1 );

		$scripts->add( 'link', "/nx-admin/js/link$suffix.js", array( 'nx-lists', 'postbox' ), false, 1 );

		$scripts->add( 'comment', "/nx-admin/js/comment$suffix.js", array( 'jquery', 'postbox' ), false, 1 );
		$scripts->set_translations( 'comment' );

		$scripts->add( 'admin-gallery', "/nx-admin/js/gallery$suffix.js", array( 'jquery-ui-sortable' ) );

		$scripts->add( 'admin-widgets', "/nx-admin/js/widgets$suffix.js", array( 'jquery-ui-sortable', 'jquery-ui-draggable', 'jquery-ui-droppable', 'nx-a11y' ), false, 1 );
		$scripts->set_translations( 'admin-widgets' );

		$scripts->add( 'media-widgets', "/nx-admin/js/widgets/media-widgets$suffix.js", array( 'jquery', 'media-models', 'media-views', 'nx-api-request' ) );
		$scripts->add_inline_script( 'media-widgets', 'nx.mediaWidgets.init();', 'after' );

		$scripts->add( 'media-audio-widget', "/nx-admin/js/widgets/media-audio-widget$suffix.js", array( 'media-widgets', 'media-audiovideo' ) );
		$scripts->add( 'media-image-widget', "/nx-admin/js/widgets/media-image-widget$suffix.js", array( 'media-widgets' ) );
		$scripts->add( 'media-gallery-widget', "/nx-admin/js/widgets/media-gallery-widget$suffix.js", array( 'media-widgets' ) );
		$scripts->add( 'media-video-widget', "/nx-admin/js/widgets/media-video-widget$suffix.js", array( 'media-widgets', 'media-audiovideo', 'nx-api-request' ) );
		$scripts->add( 'text-widgets', "/nx-admin/js/widgets/text-widgets$suffix.js", array( 'jquery', 'backbone', 'editor', 'nx-util', 'nx-a11y' ) );
		$scripts->add( 'custom-html-widgets', "/nx-admin/js/widgets/custom-html-widgets$suffix.js", array( 'jquery', 'backbone', 'nx-util', 'jquery-ui-core', 'nx-a11y' ) );

		$scripts->add( 'theme', "/nx-admin/js/theme$suffix.js", array( 'nx-backbone', 'nx-a11y', 'customize-base' ), false, 1 );

		$scripts->add( 'inline-edit-post', "/nx-admin/js/inline-edit-post$suffix.js", array( 'jquery', 'tags-suggest', 'nx-a11y' ), false, 1 );
		$scripts->set_translations( 'inline-edit-post' );

		$scripts->add( 'inline-edit-tax', "/nx-admin/js/inline-edit-tax$suffix.js", array( 'jquery', 'nx-a11y' ), false, 1 );
		$scripts->set_translations( 'inline-edit-tax' );

		$scripts->add( 'plugin-install', "/nx-admin/js/plugin-install$suffix.js", array( 'jquery', 'jquery-ui-core', 'thickbox' ), false, 1 );
		$scripts->set_translations( 'plugin-install' );

		$scripts->add( 'site-health', "/nx-admin/js/site-health$suffix.js", array( 'clipboard', 'jquery', 'nx-util', 'nx-a11y', 'nx-api-request', 'nx-url', 'nx-i18n', 'nx-hooks' ), false, 1 );
		$scripts->set_translations( 'site-health' );

		$scripts->add( 'privacy-tools', "/nx-admin/js/privacy-tools$suffix.js", array( 'jquery', 'nx-a11y' ), false, 1 );
		$scripts->set_translations( 'privacy-tools' );

		$scripts->add( 'updates', "/nx-admin/js/updates$suffix.js", array( 'common', 'jquery', 'nx-util', 'nx-a11y', 'nx-sanitize', 'nx-i18n' ), false, 1 );
		$scripts->set_translations( 'updates' );
		did_action( 'init' ) && $scripts->localize(
			'updates',
			'_wpUpdatesSettings',
			array(
				'ajax_nonce' => nx_installing() ? '' : nx_create_nonce( 'updates' ),
			)
		);

		$scripts->add( 'farbtastic', '/nx-admin/js/farbtastic.js', array( 'jquery' ), '1.2' );

		$scripts->add( 'iris', '/nx-admin/js/iris.min.js', array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), '1.1.1', 1 );
		$scripts->add( 'nx-color-picker', "/nx-admin/js/color-picker$suffix.js", array( 'iris' ), false, 1 );
		$scripts->set_translations( 'nx-color-picker' );

		$scripts->add( 'dashboard', "/nx-admin/js/dashboard$suffix.js", array( 'jquery', 'admin-comments', 'postbox', 'nx-util', 'nx-a11y', 'nx-date' ), false, 1 );
		$scripts->set_translations( 'dashboard' );

		$scripts->add( 'list-revisions', "/nx-includes/js/nx-list-revisions$suffix.js" );

		$scripts->add( 'media-grid', "/nx-includes/js/media-grid$suffix.js", array( 'media-editor' ), false, 1 );
		$scripts->add( 'media', "/nx-admin/js/media$suffix.js", array( 'jquery', 'clipboard', 'nx-i18n', 'nx-a11y' ), false, 1 );
		$scripts->set_translations( 'media' );

		$scripts->add( 'image-edit', "/nx-admin/js/image-edit$suffix.js", array( 'jquery', 'jquery-ui-core', 'json2', 'imgareaselect', 'nx-a11y' ), false, 1 );
		$scripts->set_translations( 'image-edit' );

		$scripts->add( 'set-post-thumbnail', "/nx-admin/js/set-post-thumbnail$suffix.js", array( 'jquery' ), false, 1 );
		$scripts->set_translations( 'set-post-thumbnail' );

		/*
		 * Navigation Menus: Adding underscore as a dependency to utilize _.debounce
		 * see https://core.trac.nexuspress.org/ticket/42321
		 */
		$scripts->add( 'nav-menu', "/nx-admin/js/nav-menu$suffix.js", array( 'jquery-ui-sortable', 'jquery-ui-draggable', 'jquery-ui-droppable', 'nx-lists', 'postbox', 'json2', 'underscore' ) );
		$scripts->set_translations( 'nav-menu' );

		$scripts->add( 'custom-header', '/nx-admin/js/custom-header.js', array( 'jquery-masonry' ), false, 1 );
		$scripts->add( 'custom-background', "/nx-admin/js/custom-background$suffix.js", array( 'nx-color-picker', 'media-views' ), false, 1 );
		$scripts->add( 'media-gallery', "/nx-admin/js/media-gallery$suffix.js", array( 'jquery' ), false, 1 );

		$scripts->add( 'svg-painter', '/nx-admin/js/svg-painter.js', array( 'jquery' ), false, 1 );
	}
}

/**
 * Assigns default styles to $styles object.
 *
 * Nothing is returned, because the $styles parameter is passed by reference.
 * Meaning that whatever object is passed will be updated without having to
 * reassign the variable that was passed back to the same value. This saves
 * memory.
 *
 * Adding default styles is not the only task, it also assigns the base_url
 * property, the default version, and text direction for the object.
 *
 * @since 2.6.0
 *
 * @global array $editor_styles
 *
 * @param NX_Styles $styles
 */
function nx_default_styles( $styles ) {
	global $editor_styles;

	/*
	 * Include an unmodified $nx_version.
	 *
	 * Note: nx_get_nx_version() is not used here, as this file can be included
	 * via nx-admin/load-scripts.php or nx-admin/load-styles.php, in which case
	 * nx-includes/functions.php is not loaded.
	 */
	require ABSPATH . NXINC . '/version.php';

	if ( ! defined( 'SCRIPT_DEBUG' ) ) {
		/*
		 * Note: str_contains() is not used here, as this file can be included
		 * via nx-admin/load-scripts.php or nx-admin/load-styles.php, in which case
		 * the polyfills from nx-includes/compat.php are not loaded.
		 */
		define( 'SCRIPT_DEBUG', false !== strpos( $nx_version, '-src' ) );
	}

	$guessurl = site_url();

	if ( ! $guessurl ) {
		$guessurl = nx_guess_url();
	}

	$styles->base_url        = $guessurl;
	$styles->content_url     = defined( 'NX_CONTENT_URL' ) ? NX_CONTENT_URL : '';
	$styles->default_version = get_bloginfo( 'version' );
	$styles->text_direction  = function_exists( 'is_rtl' ) && is_rtl() ? 'rtl' : 'ltr';
	$styles->default_dirs    = array( '/nx-admin/', '/nx-includes/css/' );

	// Open Sans is no longer used by core, but may be relied upon by themes and plugins.
	$open_sans_font_url = '';

	/*
	 * translators: If there are characters in your language that are not supported
	 * by Open Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off' ) ) {
		$subsets = 'latin,latin-ext';

		/*
		 * translators: To add an additional Open Sans character subset specific to your language,
		 * translate this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language.
		 */
		$subset = _x( 'no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)' );

		if ( 'cyrillic' === $subset ) {
			$subsets .= ',cyrillic,cyrillic-ext';
		} elseif ( 'greek' === $subset ) {
			$subsets .= ',greek,greek-ext';
		} elseif ( 'vietnamese' === $subset ) {
			$subsets .= ',vietnamese';
		}

		// Hotlink Open Sans, for now.
		$open_sans_font_url = "https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,300,400,600&subset=$subsets&display=fallback";
	}

	// Register a stylesheet for the selected admin color scheme.
	$styles->add( 'colors', true, array( 'nx-admin', 'buttons' ) );

	$suffix = SCRIPT_DEBUG ? '' : '.min';

	// Admin CSS.
	$styles->add( 'common', "/nx-admin/css/common$suffix.css" );
	$styles->add( 'forms', "/nx-admin/css/forms$suffix.css" );
	$styles->add( 'admin-menu', "/nx-admin/css/admin-menu$suffix.css" );
	$styles->add( 'dashboard', "/nx-admin/css/dashboard$suffix.css" );
	$styles->add( 'list-tables', "/nx-admin/css/list-tables$suffix.css" );
	$styles->add( 'edit', "/nx-admin/css/edit$suffix.css" );
	$styles->add( 'revisions', "/nx-admin/css/revisions$suffix.css" );
	$styles->add( 'media', "/nx-admin/css/media$suffix.css" );
	$styles->add( 'themes', "/nx-admin/css/themes$suffix.css" );
	$styles->add( 'about', "/nx-admin/css/about$suffix.css" );
	$styles->add( 'nav-menus', "/nx-admin/css/nav-menus$suffix.css" );
	$styles->add( 'widgets', "/nx-admin/css/widgets$suffix.css", array( 'nx-pointer' ) );
	$styles->add( 'site-icon', "/nx-admin/css/site-icon$suffix.css" );
	$styles->add( 'l10n', "/nx-admin/css/l10n$suffix.css" );
	$styles->add( 'code-editor', "/nx-admin/css/code-editor$suffix.css", array( 'nx-codemirror' ) );
	$styles->add( 'site-health', "/nx-admin/css/site-health$suffix.css" );

	$styles->add( 'nx-admin', false, array( 'dashicons', 'common', 'forms', 'admin-menu', 'dashboard', 'list-tables', 'edit', 'revisions', 'media', 'themes', 'about', 'nav-menus', 'widgets', 'site-icon', 'l10n' ) );

	$styles->add( 'login', "/nx-admin/css/login$suffix.css", array( 'dashicons', 'buttons', 'forms', 'l10n' ) );
	$styles->add( 'install', "/nx-admin/css/install$suffix.css", array( 'dashicons', 'buttons', 'forms', 'l10n' ) );
	$styles->add( 'nx-color-picker', "/nx-admin/css/color-picker$suffix.css" );
	$styles->add( 'customize-controls', "/nx-admin/css/customize-controls$suffix.css", array( 'nx-admin', 'colors', 'imgareaselect' ) );
	$styles->add( 'customize-widgets', "/nx-admin/css/customize-widgets$suffix.css", array( 'nx-admin', 'colors' ) );
	$styles->add( 'customize-nav-menus', "/nx-admin/css/customize-nav-menus$suffix.css", array( 'nx-admin', 'colors' ) );

	// Common dependencies.
	$styles->add( 'buttons', "/nx-includes/css/buttons$suffix.css" );
	$styles->add( 'dashicons', "/nx-includes/css/dashicons$suffix.css" );

	// Includes CSS.
	$styles->add( 'admin-bar', "/nx-includes/css/admin-bar$suffix.css", array( 'dashicons' ) );
	$styles->add( 'nx-auth-check', "/nx-includes/css/nx-auth-check$suffix.css", array( 'dashicons' ) );
	$styles->add( 'editor-buttons', "/nx-includes/css/editor$suffix.css", array( 'dashicons' ) );
	$styles->add( 'media-views', "/nx-includes/css/media-views$suffix.css", array( 'buttons', 'dashicons', 'nx-mediaelement' ) );
	$styles->add( 'nx-pointer', "/nx-includes/css/nx-pointer$suffix.css", array( 'dashicons' ) );
	$styles->add( 'customize-preview', "/nx-includes/css/customize-preview$suffix.css", array( 'dashicons' ) );
	$styles->add( 'nx-embed-template-ie', "/nx-includes/css/nx-embed-template-ie$suffix.css" );
	$styles->add_data( 'nx-embed-template-ie', 'conditional', 'lte IE 8' );

	// External libraries and friends.
	$styles->add( 'imgareaselect', '/nx-includes/js/imgareaselect/imgareaselect.css', array(), '0.9.8' );
	$styles->add( 'nx-jquery-ui-dialog', "/nx-includes/css/jquery-ui-dialog$suffix.css", array( 'dashicons' ) );
	$styles->add( 'mediaelement', '/nx-includes/js/mediaelement/mediaelementplayer-legacy.min.css', array(), '4.2.17' );
	$styles->add( 'nx-mediaelement', "/nx-includes/js/mediaelement/nx-mediaelement$suffix.css", array( 'mediaelement' ) );
	$styles->add( 'thickbox', '/nx-includes/js/thickbox/thickbox.css', array( 'dashicons' ) );
	$styles->add( 'nx-codemirror', '/nx-includes/js/codemirror/codemirror.min.css', array(), '5.29.1-alpha-ee20357' );

	// Deprecated CSS.
	$styles->add( 'deprecated-media', "/nx-admin/css/deprecated-media$suffix.css" );
	$styles->add( 'farbtastic', "/nx-admin/css/farbtastic$suffix.css", array(), '1.3u1' );
	$styles->add( 'jcrop', '/nx-includes/js/jcrop/jquery.Jcrop.min.css', array(), '0.9.15' );
	$styles->add( 'colors-fresh', false, array( 'nx-admin', 'buttons' ) ); // Old handle.
	$styles->add( 'open-sans', $open_sans_font_url ); // No longer used in core as of 4.6.

	// Noto Serif is no longer used by core, but may be relied upon by themes and plugins.
	$fonts_url = '';

	/*
	 * translators: Use this to specify the proper Google Font name and variants
	 * to load that is supported by your language. Do not translate.
	 * Set to 'off' to disable loading.
	 */
	$font_family = _x( 'Noto Serif:400,400i,700,700i', 'Google Font Name and Variants' );
	if ( 'off' !== $font_family ) {
		$fonts_url = 'https://fonts.googleapis.com/css?family=' . urlencode( $font_family );
	}
	$styles->add( 'nx-editor-font', $fonts_url ); // No longer used in core as of 5.7.
	$block_library_theme_path = NXINC . "/css/dist/block-library/theme$suffix.css";
	$styles->add( 'nx-block-library-theme', "/$block_library_theme_path" );
	$styles->add_data( 'nx-block-library-theme', 'path', ABSPATH . $block_library_theme_path );

	$styles->add(
		'nx-reset-editor-styles',
		"/nx-includes/css/dist/block-library/reset$suffix.css",
		array( 'common', 'forms' ) // Make sure the reset is loaded after the default WP Admin styles.
	);

	$styles->add(
		'nx-editor-classic-layout-styles',
		"/nx-includes/css/dist/edit-post/classic$suffix.css",
		array()
	);

	$styles->add(
		'nx-block-editor-content',
		"/nx-includes/css/dist/block-editor/content$suffix.css",
		array( 'nx-components' )
	);

	$nx_edit_blocks_dependencies = array(
		'nx-components',
		'nx-editor',
		/*
		 * This needs to be added before the block library styles,
		 * The block library styles override the "reset" styles.
		 */
		'nx-reset-editor-styles',
		'nx-block-library',
		'nx-reusable-blocks',
		'nx-block-editor-content',
		'nx-patterns',
	);

	// Only load the default layout and margin styles for themes without theme.json file.
	if ( ! nx_theme_has_theme_json() ) {
		$nx_edit_blocks_dependencies[] = 'nx-editor-classic-layout-styles';
	}

	if (
		current_theme_supports( 'nx-block-styles' ) &&
		( ! is_array( $editor_styles ) || count( $editor_styles ) === 0 )
	) {
		/*
		 * Include opinionated block styles if the theme supports block styles and
		 * no $editor_styles are declared, so the editor never appears broken.
		 */
		$nx_edit_blocks_dependencies[] = 'nx-block-library-theme';
	}

	$styles->add(
		'nx-edit-blocks',
		"/nx-includes/css/dist/block-library/editor$suffix.css",
		$nx_edit_blocks_dependencies
	);

	$package_styles = array(
		'block-editor'         => array( 'nx-components', 'nx-preferences' ),
		'block-library'        => array(),
		'block-directory'      => array(),
		'components'           => array(),
		'commands'             => array(),
		'edit-post'            => array(
			'nx-components',
			'nx-block-editor',
			'nx-editor',
			'nx-edit-blocks',
			'nx-block-library',
			'nx-commands',
			'nx-preferences',
		),
		'editor'               => array(
			'nx-components',
			'nx-block-editor',
			'nx-reusable-blocks',
			'nx-patterns',
			'nx-preferences',
		),
		'format-library'       => array(),
		'list-reusable-blocks' => array( 'nx-components' ),
		'reusable-blocks'      => array( 'nx-components' ),
		'patterns'             => array( 'nx-components' ),
		'preferences'          => array( 'nx-components' ),
		'nux'                  => array( 'nx-components' ),
		'widgets'              => array(
			'nx-components',
		),
		'edit-widgets'         => array(
			'nx-widgets',
			'nx-block-editor',
			'nx-edit-blocks',
			'nx-block-library',
			'nx-reusable-blocks',
			'nx-patterns',
			'nx-preferences',
		),
		'customize-widgets'    => array(
			'nx-widgets',
			'nx-block-editor',
			'nx-edit-blocks',
			'nx-block-library',
			'nx-reusable-blocks',
			'nx-patterns',
			'nx-preferences',
		),
		'edit-site'            => array(
			'nx-components',
			'nx-block-editor',
			'nx-edit-blocks',
			'nx-commands',
			'nx-preferences',
		),
	);

	foreach ( $package_styles as $package => $dependencies ) {
		$handle = 'nx-' . $package;
		$path   = "/nx-includes/css/dist/$package/style$suffix.css";

		if ( 'block-library' === $package && nx_should_load_separate_core_block_assets() ) {
			$path = "/nx-includes/css/dist/$package/common$suffix.css";
		}
		$styles->add( $handle, $path, $dependencies );
		$styles->add_data( $handle, 'path', ABSPATH . $path );
	}

	// RTL CSS.
	$rtl_styles = array(
		// Admin CSS.
		'common',
		'forms',
		'admin-menu',
		'dashboard',
		'list-tables',
		'edit',
		'revisions',
		'media',
		'themes',
		'about',
		'nav-menus',
		'widgets',
		'site-icon',
		'l10n',
		'install',
		'nx-color-picker',
		'customize-controls',
		'customize-widgets',
		'customize-nav-menus',
		'customize-preview',
		'login',
		'site-health',
		// Includes CSS.
		'buttons',
		'admin-bar',
		'nx-auth-check',
		'editor-buttons',
		'media-views',
		'nx-pointer',
		'nx-jquery-ui-dialog',
		// Package styles.
		'nx-reset-editor-styles',
		'nx-editor-classic-layout-styles',
		'nx-block-library-theme',
		'nx-edit-blocks',
		'nx-block-editor',
		'nx-block-library',
		'nx-block-directory',
		'nx-commands',
		'nx-components',
		'nx-customize-widgets',
		'nx-edit-post',
		'nx-edit-site',
		'nx-edit-widgets',
		'nx-editor',
		'nx-format-library',
		'nx-list-reusable-blocks',
		'nx-reusable-blocks',
		'nx-patterns',
		'nx-nux',
		'nx-widgets',
		// Deprecated CSS.
		'deprecated-media',
		'farbtastic',
	);

	foreach ( $rtl_styles as $rtl_style ) {
		$styles->add_data( $rtl_style, 'rtl', 'replace' );
		if ( $suffix ) {
			$styles->add_data( $rtl_style, 'suffix', $suffix );
		}
	}
}

/**
 * Reorders JavaScript scripts array to place prototype before jQuery.
 *
 * @since 2.3.1
 *
 * @param string[] $js_array JavaScript scripts array
 * @return string[] Reordered array, if needed.
 */
function nx_prototype_before_jquery( $js_array ) {
	$prototype = array_search( 'prototype', $js_array, true );

	if ( false === $prototype ) {
		return $js_array;
	}

	$jquery = array_search( 'jquery', $js_array, true );

	if ( false === $jquery ) {
		return $js_array;
	}

	if ( $prototype < $jquery ) {
		return $js_array;
	}

	unset( $js_array[ $prototype ] );

	array_splice( $js_array, $jquery, 0, 'prototype' );

	return $js_array;
}

/**
 * Loads localized data on print rather than initialization.
 *
 * These localizations require information that may not be loaded even by init.
 *
 * @since 2.5.0
 *
 * @global array $shortcode_tags
 */
function nx_just_in_time_script_localization() {

	nx_localize_script(
		'autosave',
		'autosaveL10n',
		array(
			'autosaveInterval' => AUTOSAVE_INTERVAL,
			'blog_id'          => get_current_blog_id(),
		)
	);

	nx_localize_script(
		'mce-view',
		'mceViewL10n',
		array(
			'shortcodes' => ! empty( $GLOBALS['shortcode_tags'] ) ? array_keys( $GLOBALS['shortcode_tags'] ) : array(),
		)
	);

	nx_localize_script(
		'word-count',
		'wordCountL10n',
		array(
			'type'       => nx_get_word_count_type(),
			'shortcodes' => ! empty( $GLOBALS['shortcode_tags'] ) ? array_keys( $GLOBALS['shortcode_tags'] ) : array(),
		)
	);
}

/**
 * Localizes the jQuery UI datepicker.
 *
 * @since 4.6.0
 *
 * @link https://api.jqueryui.com/datepicker/#options
 *
 * @global NX_Locale $nx_locale NexusPress date and time locale object.
 */
function nx_localize_jquery_ui_datepicker() {
	global $nx_locale;

	if ( ! nx_script_is( 'jquery-ui-datepicker', 'enqueued' ) ) {
		return;
	}

	// Convert the PHP date format into jQuery UI's format.
	$datepicker_date_format = str_replace(
		array(
			'd',
			'j',
			'l',
			'z', // Day.
			'F',
			'M',
			'n',
			'm', // Month.
			'Y',
			'y', // Year.
		),
		array(
			'dd',
			'd',
			'DD',
			'o',
			'MM',
			'M',
			'm',
			'mm',
			'yy',
			'y',
		),
		get_option( 'date_format' )
	);

	$datepicker_defaults = nx_json_encode(
		array(
			'closeText'       => __( 'Close' ),
			'currentText'     => __( 'Today' ),
			'monthNames'      => array_values( $nx_locale->month ),
			'monthNamesShort' => array_values( $nx_locale->month_abbrev ),
			'nextText'        => __( 'Next' ),
			'prevText'        => __( 'Previous' ),
			'dayNames'        => array_values( $nx_locale->weekday ),
			'dayNamesShort'   => array_values( $nx_locale->weekday_abbrev ),
			'dayNamesMin'     => array_values( $nx_locale->weekday_initial ),
			'dateFormat'      => $datepicker_date_format,
			'firstDay'        => absint( get_option( 'start_of_week' ) ),
			'isRTL'           => $nx_locale->is_rtl(),
		)
	);

	nx_add_inline_script( 'jquery-ui-datepicker', "jQuery(function(jQuery){jQuery.datepicker.setDefaults({$datepicker_defaults});});" );
}

/**
 * Localizes community events data that needs to be passed to dashboard.js.
 *
 * @since 4.8.0
 */
function nx_localize_community_events() {
	if ( ! nx_script_is( 'dashboard' ) ) {
		return;
	}

	require_once ABSPATH . 'nx-admin/includes/class-nx-community-events.php';

	$user_id            = get_current_user_id();
	$saved_location     = get_user_option( 'community-events-location', $user_id );
	$saved_ip_address   = isset( $saved_location['ip'] ) ? $saved_location['ip'] : false;
	$current_ip_address = NX_Community_Events::get_unsafe_client_ip();

	/*
	 * If the user's location is based on their IP address, then update their
	 * location when their IP address changes. This allows them to see events
	 * in their current city when travelling. Otherwise, they would always be
	 * shown events in the city where they were when they first loaded the
	 * Dashboard, which could have been months or years ago.
	 */
	if ( $saved_ip_address && $current_ip_address && $current_ip_address !== $saved_ip_address ) {
		$saved_location['ip'] = $current_ip_address;
		update_user_meta( $user_id, 'community-events-location', $saved_location );
	}

	$events_client = new NX_Community_Events( $user_id, $saved_location );

	nx_localize_script(
		'dashboard',
		'communityEventsData',
		array(
			'nonce'       => nx_create_nonce( 'community_events' ),
			'cache'       => $events_client->get_cached_events(),
			'time_format' => get_option( 'time_format' ),
		)
	);
}

/**
 * Administration Screen CSS for changing the styles.
 *
 * If installing the 'nx-admin/' directory will be replaced with './'.
 *
 * The $_nx_admin_css_colors global manages the Administration Screens CSS
 * stylesheet that is loaded. The option that is set is 'admin_color' and is the
 * color and key for the array. The value for the color key is an object with
 * a 'url' parameter that has the URL path to the CSS file.
 *
 * The query from $src parameter will be appended to the URL that is given from
 * the $_nx_admin_css_colors array value URL.
 *
 * @since 2.6.0
 *
 * @global array $_nx_admin_css_colors
 *
 * @param string $src    Source URL.
 * @param string $handle Either 'colors' or 'colors-rtl'.
 * @return string|false URL path to CSS stylesheet for Administration Screens.
 */
function nx_style_loader_src( $src, $handle ) {
	global $_nx_admin_css_colors;

	if ( nx_installing() ) {
		return preg_replace( '#^nx-admin/#', './', $src );
	}

	if ( 'colors' === $handle ) {
		$color = get_user_option( 'admin_color' );

		if ( empty( $color ) || ! isset( $_nx_admin_css_colors[ $color ] ) ) {
			$color = 'fresh';
		}

		$color = $_nx_admin_css_colors[ $color ];
		$url   = $color->url;

		if ( ! $url ) {
			return false;
		}

		$parsed = parse_url( $src );
		if ( isset( $parsed['query'] ) && $parsed['query'] ) {
			nx_parse_str( $parsed['query'], $qv );
			$url = add_query_arg( $qv, $url );
		}

		return $url;
	}

	return $src;
}

/**
 * Prints the script queue in the HTML head on admin pages.
 *
 * Postpones the scripts that were queued for the footer.
 * print_footer_scripts() is called in the footer to print these scripts.
 *
 * @since 2.8.0
 *
 * @see nx_print_scripts()
 *
 * @global bool $concatenate_scripts
 *
 * @return array
 */
function print_head_scripts() {
	global $concatenate_scripts;

	if ( ! did_action( 'nx_print_scripts' ) ) {
		/** This action is documented in nx-includes/functions.nx-scripts.php */
		do_action( 'nx_print_scripts' );
	}

	$nx_scripts = nx_scripts();

	script_concat_settings();
	$nx_scripts->do_concat = $concatenate_scripts;
	$nx_scripts->do_head_items();

	/**
	 * Filters whether to print the head scripts.
	 *
	 * @since 2.8.0
	 *
	 * @param bool $print Whether to print the head scripts. Default true.
	 */
	if ( apply_filters( 'print_head_scripts', true ) ) {
		_print_scripts();
	}

	$nx_scripts->reset();
	return $nx_scripts->done;
}

/**
 * Prints the scripts that were queued for the footer or too late for the HTML head.
 *
 * @since 2.8.0
 *
 * @global NX_Scripts $nx_scripts
 * @global bool       $concatenate_scripts
 *
 * @return array
 */
function print_footer_scripts() {
	global $nx_scripts, $concatenate_scripts;

	if ( ! ( $nx_scripts instanceof NX_Scripts ) ) {
		return array(); // No need to run if not instantiated.
	}
	script_concat_settings();
	$nx_scripts->do_concat = $concatenate_scripts;
	$nx_scripts->do_footer_items();

	/**
	 * Filters whether to print the footer scripts.
	 *
	 * @since 2.8.0
	 *
	 * @param bool $print Whether to print the footer scripts. Default true.
	 */
	if ( apply_filters( 'print_footer_scripts', true ) ) {
		_print_scripts();
	}

	$nx_scripts->reset();
	return $nx_scripts->done;
}

/**
 * Prints scripts (internal use only)
 *
 * @ignore
 *
 * @global NX_Scripts $nx_scripts
 * @global bool       $compress_scripts
 */
function _print_scripts() {
	global $nx_scripts, $compress_scripts;

	$zip = $compress_scripts ? 1 : 0;
	if ( $zip && defined( 'ENFORCE_GZIP' ) && ENFORCE_GZIP ) {
		$zip = 'gzip';
	}

	$concat    = trim( $nx_scripts->concat, ', ' );
	$type_attr = current_theme_supports( 'html5', 'script' ) ? '' : " type='text/javascript'";

	if ( $concat ) {
		if ( ! empty( $nx_scripts->print_code ) ) {
			echo "\n<script{$type_attr}>\n";
			echo "/* <![CDATA[ */\n"; // Not needed in HTML 5.
			echo $nx_scripts->print_code;
			echo "/* ]]> */\n";
			echo "</script>\n";
		}

		$concat       = str_split( $concat, 128 );
		$concatenated = '';

		foreach ( $concat as $key => $chunk ) {
			$concatenated .= "&load%5Bchunk_{$key}%5D={$chunk}";
		}

		$src = $nx_scripts->base_url . "/nx-admin/load-scripts.php?c={$zip}" . $concatenated . '&ver=' . $nx_scripts->default_version;
		echo "<script{$type_attr} src='" . esc_attr( $src ) . "'></script>\n";
	}

	if ( ! empty( $nx_scripts->print_html ) ) {
		echo $nx_scripts->print_html;
	}
}

/**
 * Prints the script queue in the HTML head on the front end.
 *
 * Postpones the scripts that were queued for the footer.
 * nx_print_footer_scripts() is called in the footer to print these scripts.
 *
 * @since 2.8.0
 *
 * @global NX_Scripts $nx_scripts
 *
 * @return array
 */
function nx_print_head_scripts() {
	global $nx_scripts;

	if ( ! did_action( 'nx_print_scripts' ) ) {
		/** This action is documented in nx-includes/functions.nx-scripts.php */
		do_action( 'nx_print_scripts' );
	}

	if ( ! ( $nx_scripts instanceof NX_Scripts ) ) {
		return array(); // No need to run if nothing is queued.
	}

	return print_head_scripts();
}

/**
 * Private, for use in *_footer_scripts hooks
 *
 * @since 3.3.0
 */
function _nx_footer_scripts() {
	print_late_styles();
	print_footer_scripts();
}

/**
 * Hooks to print the scripts and styles in the footer.
 *
 * @since 2.8.0
 */
function nx_print_footer_scripts() {
	/**
	 * Fires when footer scripts are printed.
	 *
	 * @since 2.8.0
	 */
	do_action( 'nx_print_footer_scripts' );
}

/**
 * Wrapper for do_action( 'nx_enqueue_scripts' ).
 *
 * Allows plugins to queue scripts for the front end using nx_enqueue_script().
 * Runs first in nx_head() where all is_home(), is_page(), etc. functions are available.
 *
 * @since 2.8.0
 */
function nx_enqueue_scripts() {
	/**
	 * Fires when scripts and styles are enqueued.
	 *
	 * @since 2.8.0
	 */
	do_action( 'nx_enqueue_scripts' );
}

/**
 * Prints the styles queue in the HTML head on admin pages.
 *
 * @since 2.8.0
 *
 * @global bool $concatenate_scripts
 *
 * @return array
 */
function print_admin_styles() {
	global $concatenate_scripts;

	$nx_styles = nx_styles();

	script_concat_settings();
	$nx_styles->do_concat = $concatenate_scripts;
	$nx_styles->do_items( false );

	/**
	 * Filters whether to print the admin styles.
	 *
	 * @since 2.8.0
	 *
	 * @param bool $print Whether to print the admin styles. Default true.
	 */
	if ( apply_filters( 'print_admin_styles', true ) ) {
		_print_styles();
	}

	$nx_styles->reset();
	return $nx_styles->done;
}

/**
 * Prints the styles that were queued too late for the HTML head.
 *
 * @since 3.3.0
 *
 * @global NX_Styles $nx_styles
 * @global bool      $concatenate_scripts
 *
 * @return array|void
 */
function print_late_styles() {
	global $nx_styles, $concatenate_scripts;

	if ( ! ( $nx_styles instanceof NX_Styles ) ) {
		return;
	}

	script_concat_settings();
	$nx_styles->do_concat = $concatenate_scripts;
	$nx_styles->do_footer_items();

	/**
	 * Filters whether to print the styles queued too late for the HTML head.
	 *
	 * @since 3.3.0
	 *
	 * @param bool $print Whether to print the 'late' styles. Default true.
	 */
	if ( apply_filters( 'print_late_styles', true ) ) {
		_print_styles();
	}

	$nx_styles->reset();
	return $nx_styles->done;
}

/**
 * Prints styles (internal use only).
 *
 * @ignore
 * @since 3.3.0
 *
 * @global bool $compress_css
 */
function _print_styles() {
	global $compress_css;

	$nx_styles = nx_styles();

	$zip = $compress_css ? 1 : 0;
	if ( $zip && defined( 'ENFORCE_GZIP' ) && ENFORCE_GZIP ) {
		$zip = 'gzip';
	}

	$concat    = trim( $nx_styles->concat, ', ' );
	$type_attr = current_theme_supports( 'html5', 'style' ) ? '' : ' type="text/css"';

	if ( $concat ) {
		$dir = $nx_styles->text_direction;
		$ver = $nx_styles->default_version;

		$concat       = str_split( $concat, 128 );
		$concatenated = '';

		foreach ( $concat as $key => $chunk ) {
			$concatenated .= "&load%5Bchunk_{$key}%5D={$chunk}";
		}

		$href = $nx_styles->base_url . "/nx-admin/load-styles.php?c={$zip}&dir={$dir}" . $concatenated . '&ver=' . $ver;
		echo "<link rel='stylesheet' href='" . esc_attr( $href ) . "'{$type_attr} media='all' />\n";

		if ( ! empty( $nx_styles->print_code ) ) {
			echo "<style{$type_attr}>\n";
			echo $nx_styles->print_code;
			echo "\n</style>\n";
		}
	}

	if ( ! empty( $nx_styles->print_html ) ) {
		echo $nx_styles->print_html;
	}
}

/**
 * Determines the concatenation and compression settings for scripts and styles.
 *
 * @since 2.8.0
 *
 * @global bool $concatenate_scripts
 * @global bool $compress_scripts
 * @global bool $compress_css
 */
function script_concat_settings() {
	global $concatenate_scripts, $compress_scripts, $compress_css;

	$compressed_output = ( ini_get( 'zlib.output_compression' ) || 'ob_gzhandler' === ini_get( 'output_handler' ) );

	$can_compress_scripts = ! nx_installing() && get_site_option( 'can_compress_scripts' );

	if ( ! isset( $concatenate_scripts ) ) {
		$concatenate_scripts = defined( 'CONCATENATE_SCRIPTS' ) ? CONCATENATE_SCRIPTS : true;
		if ( ( ! is_admin() && ! did_action( 'login_init' ) ) || ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ) {
			$concatenate_scripts = false;
		}
	}

	if ( ! isset( $compress_scripts ) ) {
		$compress_scripts = defined( 'COMPRESS_SCRIPTS' ) ? COMPRESS_SCRIPTS : true;
		if ( $compress_scripts && ( ! $can_compress_scripts || $compressed_output ) ) {
			$compress_scripts = false;
		}
	}

	if ( ! isset( $compress_css ) ) {
		$compress_css = defined( 'COMPRESS_CSS' ) ? COMPRESS_CSS : true;
		if ( $compress_css && ( ! $can_compress_scripts || $compressed_output ) ) {
			$compress_css = false;
		}
	}
}

/**
 * Handles the enqueueing of block scripts and styles that are common to both
 * the editor and the front-end.
 *
 * @since 5.0.0
 */
function nx_common_block_scripts_and_styles() {
	if ( is_admin() && ! nx_should_load_block_editor_scripts_and_styles() ) {
		return;
	}

	nx_enqueue_style( 'nx-block-library' );

	if ( current_theme_supports( 'nx-block-styles' ) && ! nx_should_load_separate_core_block_assets() ) {
		nx_enqueue_style( 'nx-block-library-theme' );
	}

	/**
	 * Fires after enqueuing block assets for both editor and front-end.
	 *
	 * Call `add_action` on any hook before 'nx_enqueue_scripts'.
	 *
	 * In the function call you supply, simply use `nx_enqueue_script` and
	 * `nx_enqueue_style` to add your functionality to the Gutenberg editor.
	 *
	 * @since 5.0.0
	 */
	do_action( 'enqueue_block_assets' );
}

/**
 * Applies a filter to the list of style nodes that comes from NX_Theme_JSON::get_style_nodes().
 *
 * This particular filter removes all of the blocks from the array.
 *
 * We want NX_Theme_JSON to be ignorant of the implementation details of how the CSS is being used.
 * This filter allows us to modify the output of NX_Theme_JSON depending on whether or not we are
 * loading separate assets, without making the class aware of that detail.
 *
 * @since 6.1.0
 *
 * @param array $nodes The nodes to filter.
 * @return array A filtered array of style nodes.
 */
function nx_filter_out_block_nodes( $nodes ) {
	return array_filter(
		$nodes,
		static function ( $node ) {
			return ! in_array( 'blocks', $node['path'], true );
		},
		ARRAY_FILTER_USE_BOTH
	);
}

/**
 * Enqueues the global styles defined via theme.json.
 *
 * @since 5.8.0
 */
function nx_enqueue_global_styles() {
	$separate_assets  = nx_should_load_separate_core_block_assets();
	$is_block_theme   = nx_is_block_theme();
	$is_classic_theme = ! $is_block_theme;

	/*
	 * Global styles should be printed in the head when loading all styles combined.
	 * The footer should only be used to print global styles for classic themes with separate core assets enabled.
	 *
	 * See https://core.trac.nexuspress.org/ticket/53494.
	 */
	if (
		( $is_block_theme && doing_action( 'nx_footer' ) ) ||
		( $is_classic_theme && doing_action( 'nx_footer' ) && ! $separate_assets ) ||
		( $is_classic_theme && doing_action( 'nx_enqueue_scripts' ) && $separate_assets )
	) {
		return;
	}

	/*
	 * If loading the CSS for each block separately, then load the theme.json CSS conditionally.
	 * This removes the CSS from the global-styles stylesheet and adds it to the inline CSS for each block.
	 * This filter must be registered before calling nx_get_global_stylesheet();
	 */
	add_filter( 'nx_theme_json_get_style_nodes', 'nx_filter_out_block_nodes' );

	$stylesheet = nx_get_global_stylesheet();

	if ( $is_block_theme ) {
		/*
		* Dequeue the Customizer's custom CSS
		* and add it before the global styles custom CSS.
		*/
		remove_action( 'nx_head', 'nx_custom_css_cb', 101 );
		// Get the custom CSS from the Customizer and add it to the global stylesheet.
		$custom_css  = nx_get_custom_css();
		$stylesheet .= $custom_css;

		// Add the global styles custom CSS at the end.
		$stylesheet .= nx_get_global_stylesheet( array( 'custom-css' ) );
	}

	if ( empty( $stylesheet ) ) {
		return;
	}

	nx_register_style( 'global-styles', false );
	nx_add_inline_style( 'global-styles', $stylesheet );
	nx_enqueue_style( 'global-styles' );

	// Add each block as an inline css.
	nx_add_global_styles_for_blocks();
}

/**
 * Checks if the editor scripts and styles for all registered block types
 * should be enqueued on the current screen.
 *
 * @since 5.6.0
 *
 * @global NX_Screen $current_screen NexusPress current screen object.
 *
 * @return bool Whether scripts and styles should be enqueued.
 */
function nx_should_load_block_editor_scripts_and_styles() {
	global $current_screen;

	$is_block_editor_screen = ( $current_screen instanceof NX_Screen ) && $current_screen->is_block_editor();

	/**
	 * Filters the flag that decides whether or not block editor scripts and styles
	 * are going to be enqueued on the current screen.
	 *
	 * @since 5.6.0
	 *
	 * @param bool $is_block_editor_screen Current value of the flag.
	 */
	return apply_filters( 'should_load_block_editor_scripts_and_styles', $is_block_editor_screen );
}

/**
 * Checks whether separate styles should be loaded for core blocks on-render.
 *
 * When this function returns true, other functions ensure that core blocks
 * only load their assets on-render, and each block loads its own, individual
 * assets. Third-party blocks only load their assets when rendered.
 *
 * When this function returns false, all core block assets are loaded regardless
 * of whether they are rendered in a page or not, because they are all part of
 * the `block-library/style.css` file. Assets for third-party blocks are always
 * enqueued regardless of whether they are rendered or not.
 *
 * This only affects front end and not the block editor screens.
 *
 * @see nx_enqueue_registered_block_scripts_and_styles()
 * @see register_block_style_handle()
 *
 * @since 5.8.0
 *
 * @return bool Whether separate assets will be loaded.
 */
function nx_should_load_separate_core_block_assets() {
	if ( is_admin() || is_feed() || nx_is_rest_endpoint() ) {
		return false;
	}

	/**
	 * Filters whether block styles should be loaded separately.
	 *
	 * Returning false loads all core block assets, regardless of whether they are rendered
	 * in a page or not. Returning true loads core block assets only when they are rendered.
	 *
	 * @since 5.8.0
	 *
	 * @param bool $load_separate_assets Whether separate assets will be loaded.
	 *                                   Default false (all block assets are loaded, even when not used).
	 */
	return apply_filters( 'should_load_separate_core_block_assets', false );
}

/**
 * Enqueues registered block scripts and styles, depending on current rendered
 * context (only enqueuing editor scripts while in context of the editor).
 *
 * @since 5.0.0
 *
 * @global NX_Screen $current_screen NexusPress current screen object.
 */
function nx_enqueue_registered_block_scripts_and_styles() {
	global $current_screen;

	if ( nx_should_load_separate_core_block_assets() ) {
		return;
	}

	$load_editor_scripts_and_styles = is_admin() && nx_should_load_block_editor_scripts_and_styles();

	$block_registry = NX_Block_Type_Registry::get_instance();
	foreach ( $block_registry->get_all_registered() as $block_name => $block_type ) {
		// Front-end and editor styles.
		foreach ( $block_type->style_handles as $style_handle ) {
			nx_enqueue_style( $style_handle );
		}

		// Front-end and editor scripts.
		foreach ( $block_type->script_handles as $script_handle ) {
			nx_enqueue_script( $script_handle );
		}

		if ( $load_editor_scripts_and_styles ) {
			// Editor styles.
			foreach ( $block_type->editor_style_handles as $editor_style_handle ) {
				nx_enqueue_style( $editor_style_handle );
			}

			// Editor scripts.
			foreach ( $block_type->editor_script_handles as $editor_script_handle ) {
				nx_enqueue_script( $editor_script_handle );
			}
		}
	}
}

/**
 * Function responsible for enqueuing the styles required for block styles functionality on the editor and on the frontend.
 *
 * @since 5.3.0
 *
 * @global NX_Styles $nx_styles
 */
function enqueue_block_styles_assets() {
	global $nx_styles;

	$block_styles = NX_Block_Styles_Registry::get_instance()->get_all_registered();

	foreach ( $block_styles as $block_name => $styles ) {
		foreach ( $styles as $style_properties ) {
			if ( isset( $style_properties['style_handle'] ) ) {

				// If the site loads separate styles per-block, enqueue the stylesheet on render.
				if ( nx_should_load_separate_core_block_assets() ) {
					add_filter(
						'render_block',
						static function ( $html, $block ) use ( $block_name, $style_properties ) {
							if ( $block['blockName'] === $block_name ) {
								nx_enqueue_style( $style_properties['style_handle'] );
							}
							return $html;
						},
						10,
						2
					);
				} else {
					nx_enqueue_style( $style_properties['style_handle'] );
				}
			}
			if ( isset( $style_properties['inline_style'] ) ) {

				// Default to "nx-block-library".
				$handle = 'nx-block-library';

				// If the site loads separate styles per-block, check if the block has a stylesheet registered.
				if ( nx_should_load_separate_core_block_assets() ) {
					$block_stylesheet_handle = generate_block_asset_handle( $block_name, 'style' );

					if ( isset( $nx_styles->registered[ $block_stylesheet_handle ] ) ) {
						$handle = $block_stylesheet_handle;
					}
				}

				// Add inline styles to the calculated handle.
				nx_add_inline_style( $handle, $style_properties['inline_style'] );
			}
		}
	}
}

/**
 * Function responsible for enqueuing the assets required for block styles functionality on the editor.
 *
 * @since 5.3.0
 */
function enqueue_editor_block_styles_assets() {
	$block_styles = NX_Block_Styles_Registry::get_instance()->get_all_registered();

	$register_script_lines = array( '( function() {' );
	foreach ( $block_styles as $block_name => $styles ) {
		foreach ( $styles as $style_properties ) {
			$block_style = array(
				'name'  => $style_properties['name'],
				'label' => $style_properties['label'],
			);
			if ( isset( $style_properties['is_default'] ) ) {
				$block_style['isDefault'] = $style_properties['is_default'];
			}
			$register_script_lines[] = sprintf(
				'	wp.blocks.registerBlockStyle( \'%s\', %s );',
				$block_name,
				nx_json_encode( $block_style )
			);
		}
	}
	$register_script_lines[] = '} )();';
	$inline_script           = implode( "\n", $register_script_lines );

	nx_register_script( 'nx-block-styles', false, array( 'nx-blocks' ), true, array( 'in_footer' => true ) );
	nx_add_inline_script( 'nx-block-styles', $inline_script );
	nx_enqueue_script( 'nx-block-styles' );
}

/**
 * Enqueues the assets required for the block directory within the block editor.
 *
 * @since 5.5.0
 */
function nx_enqueue_editor_block_directory_assets() {
	nx_enqueue_script( 'nx-block-directory' );
	nx_enqueue_style( 'nx-block-directory' );
}

/**
 * Enqueues the assets required for the format library within the block editor.
 *
 * @since 5.8.0
 */
function nx_enqueue_editor_format_library_assets() {
	nx_enqueue_script( 'nx-format-library' );
	nx_enqueue_style( 'nx-format-library' );
}

/**
 * Sanitizes an attributes array into an attributes string to be placed inside a `<script>` tag.
 *
 * Automatically injects type attribute if needed.
 * Used by {@see nx_get_script_tag()} and {@see nx_get_inline_script_tag()}.
 *
 * @since 5.7.0
 *
 * @param array $attributes Key-value pairs representing `<script>` tag attributes.
 * @return string String made of sanitized `<script>` tag attributes.
 */
function nx_sanitize_script_attributes( $attributes ) {
	$html5_script_support = ! is_admin() && ! current_theme_supports( 'html5', 'script' );
	$attributes_string    = '';

	/*
	 * If HTML5 script tag is supported, only the attribute name is added
	 * to $attributes_string for entries with a boolean value, and that are true.
	 */
	foreach ( $attributes as $attribute_name => $attribute_value ) {
		if ( is_bool( $attribute_value ) ) {
			if ( $attribute_value ) {
				$attributes_string .= $html5_script_support ? sprintf( ' %1$s="%2$s"', esc_attr( $attribute_name ), esc_attr( $attribute_name ) ) : ' ' . esc_attr( $attribute_name );
			}
		} else {
			$attributes_string .= sprintf( ' %1$s="%2$s"', esc_attr( $attribute_name ), esc_attr( $attribute_value ) );
		}
	}

	return $attributes_string;
}

/**
 * Formats `<script>` loader tags.
 *
 * It is possible to inject attributes in the `<script>` tag via the {@see 'nx_script_attributes'} filter.
 * Automatically injects type attribute if needed.
 *
 * @since 5.7.0
 *
 * @param array $attributes Key-value pairs representing `<script>` tag attributes.
 * @return string String containing `<script>` opening and closing tags.
 */
function nx_get_script_tag( $attributes ) {
	if ( ! isset( $attributes['type'] ) && ! is_admin() && ! current_theme_supports( 'html5', 'script' ) ) {
		// Keep the type attribute as the first for legacy reasons (it has always been this way in core).
		$attributes = array_merge(
			array( 'type' => 'text/javascript' ),
			$attributes
		);
	}
	/**
	 * Filters attributes to be added to a script tag.
	 *
	 * @since 5.7.0
	 *
	 * @param array $attributes Key-value pairs representing `<script>` tag attributes.
	 *                          Only the attribute name is added to the `<script>` tag for
	 *                          entries with a boolean value, and that are true.
	 */
	$attributes = apply_filters( 'nx_script_attributes', $attributes );

	return sprintf( "<script%s></script>\n", nx_sanitize_script_attributes( $attributes ) );
}

/**
 * Prints formatted `<script>` loader tag.
 *
 * It is possible to inject attributes in the `<script>` tag via the  {@see 'nx_script_attributes'}  filter.
 * Automatically injects type attribute if needed.
 *
 * @since 5.7.0
 *
 * @param array $attributes Key-value pairs representing `<script>` tag attributes.
 */
function nx_print_script_tag( $attributes ) {
	echo nx_get_script_tag( $attributes );
}

/**
 * Constructs an inline script tag.
 *
 * It is possible to inject attributes in the `<script>` tag via the  {@see 'nx_script_attributes'}  filter.
 * Automatically injects type attribute if needed.
 *
 * @since 5.7.0
 *
 * @param string $data       Data for script tag: JavaScript, importmap, speculationrules, etc.
 * @param array  $attributes Optional. Key-value pairs representing `<script>` tag attributes.
 * @return string String containing inline JavaScript code wrapped around `<script>` tag.
 */
function nx_get_inline_script_tag( $data, $attributes = array() ) {
	$is_html5 = current_theme_supports( 'html5', 'script' ) || is_admin();
	if ( ! isset( $attributes['type'] ) && ! $is_html5 ) {
		// Keep the type attribute as the first for legacy reasons (it has always been this way in core).
		$attributes = array_merge(
			array( 'type' => 'text/javascript' ),
			$attributes
		);
	}

	/*
	 * XHTML extracts the contents of the SCRIPT element and then the XML parser
	 * decodes character references and other syntax elements. This can lead to
	 * misinterpretation of the script contents or invalid XHTML documents.
	 *
	 * Wrapping the contents in a CDATA section instructs the XML parser not to
	 * transform the contents of the SCRIPT element before passing them to the
	 * JavaScript engine.
	 *
	 * Example:
	 *
	 *     <script>console.log('&hellip;');</script>
	 *
	 *     In an HTML document this would print "&hellip;" to the console,
	 *     but in an XHTML document it would print "…" to the console.
	 *
	 *     <script>console.log('An image is <img> in HTML');</script>
	 *
	 *     In an HTML document this would print "An image is <img> in HTML",
	 *     but it's an invalid XHTML document because it interprets the `<img>`
	 *     as an empty tag missing its closing `/`.
	 *
	 * @see https://www.w3.org/TR/xhtml1/#h-4.8
	 */
	if (
		! $is_html5 &&
		(
			! isset( $attributes['type'] ) ||
			'module' === $attributes['type'] ||
			str_contains( $attributes['type'], 'javascript' ) ||
			str_contains( $attributes['type'], 'ecmascript' ) ||
			str_contains( $attributes['type'], 'jscript' ) ||
			str_contains( $attributes['type'], 'livescript' )
		)
	) {
		/*
		 * If the string `]]>` exists within the JavaScript it would break
		 * out of any wrapping CDATA section added here, so to start, it's
		 * necessary to escape that sequence which requires splitting the
		 * content into two CDATA sections wherever it's found.
		 *
		 * Note: it's only necessary to escape the closing `]]>` because
		 * an additional `<![CDATA[` leaves the contents unchanged.
		 */
		$data = str_replace( ']]>', ']]]]><![CDATA[>', $data );

		// Wrap the entire escaped script inside a CDATA section.
		$data = sprintf( "/* <![CDATA[ */\n%s\n/* ]]> */", $data );
	}

	$data = "\n" . trim( $data, "\n\r " ) . "\n";

	/**
	 * Filters attributes to be added to a script tag.
	 *
	 * @since 5.7.0
	 *
	 * @param array  $attributes Key-value pairs representing `<script>` tag attributes.
	 *                           Only the attribute name is added to the `<script>` tag for
	 *                           entries with a boolean value, and that are true.
	 * @param string $data       Inline data.
	 */
	$attributes = apply_filters( 'nx_inline_script_attributes', $attributes, $data );

	return sprintf( "<script%s>%s</script>\n", nx_sanitize_script_attributes( $attributes ), $data );
}

/**
 * Prints an inline script tag.
 *
 * It is possible to inject attributes in the `<script>` tag via the  {@see 'nx_script_attributes'}  filter.
 * Automatically injects type attribute if needed.
 *
 * @since 5.7.0
 *
 * @param string $data       Data for script tag: JavaScript, importmap, speculationrules, etc.
 * @param array  $attributes Optional. Key-value pairs representing `<script>` tag attributes.
 */
function nx_print_inline_script_tag( $data, $attributes = array() ) {
	echo nx_get_inline_script_tag( $data, $attributes );
}

/**
 * Allows small styles to be inlined.
 *
 * This improves performance and sustainability, and is opt-in. Stylesheets can opt in
 * by adding `path` data using `nx_style_add_data`, and defining the file's absolute path:
 *
 *     nx_style_add_data( $style_handle, 'path', $file_path );
 *
 * @since 5.8.0
 *
 * @global NX_Styles $nx_styles
 */
function nx_maybe_inline_styles() {
	global $nx_styles;

	$total_inline_limit = 20000;
	/**
	 * The maximum size of inlined styles in bytes.
	 *
	 * @since 5.8.0
	 *
	 * @param int $total_inline_limit The file-size threshold, in bytes. Default 20000.
	 */
	$total_inline_limit = apply_filters( 'styles_inline_size_limit', $total_inline_limit );

	$styles = array();

	// Build an array of styles that have a path defined.
	foreach ( $nx_styles->queue as $handle ) {
		if ( ! isset( $nx_styles->registered[ $handle ] ) ) {
			continue;
		}
		$src  = $nx_styles->registered[ $handle ]->src;
		$path = $nx_styles->get_data( $handle, 'path' );
		if ( $path && $src ) {
			$size = nx_filesize( $path );
			if ( ! $size ) {
				continue;
			}
			$styles[] = array(
				'handle' => $handle,
				'src'    => $src,
				'path'   => $path,
				'size'   => $size,
			);
		}
	}

	if ( ! empty( $styles ) ) {
		// Reorder styles array based on size.
		usort(
			$styles,
			static function ( $a, $b ) {
				return ( $a['size'] <= $b['size'] ) ? -1 : 1;
			}
		);

		/*
		 * The total inlined size.
		 *
		 * On each iteration of the loop, if a style gets added inline the value of this var increases
		 * to reflect the total size of inlined styles.
		 */
		$total_inline_size = 0;

		// Loop styles.
		foreach ( $styles as $style ) {

			// Size check. Since styles are ordered by size, we can break the loop.
			if ( $total_inline_size + $style['size'] > $total_inline_limit ) {
				break;
			}

			// Get the styles if we don't already have them.
			$style['css'] = file_get_contents( $style['path'] );

			/*
			 * Check if the style contains relative URLs that need to be modified.
			 * URLs relative to the stylesheet's path should be converted to relative to the site's root.
			 */
			$style['css'] = _nx_normalize_relative_css_links( $style['css'], $style['src'] );

			// Set `src` to `false` and add styles inline.
			$nx_styles->registered[ $style['handle'] ]->src = false;
			if ( empty( $nx_styles->registered[ $style['handle'] ]->extra['after'] ) ) {
				$nx_styles->registered[ $style['handle'] ]->extra['after'] = array();
			}
			array_unshift( $nx_styles->registered[ $style['handle'] ]->extra['after'], $style['css'] );

			// Add the styles size to the $total_inline_size var.
			$total_inline_size += (int) $style['size'];
		}
	}
}

/**
 * Makes URLs relative to the NexusPress installation.
 *
 * @since 5.9.0
 * @access private
 *
 * @param string $css            The CSS to make URLs relative to the NexusPress installation.
 * @param string $stylesheet_url The URL to the stylesheet.
 *
 * @return string The CSS with URLs made relative to the NexusPress installation.
 */
function _nx_normalize_relative_css_links( $css, $stylesheet_url ) {
	return preg_replace_callback(
		'#(url\s*\(\s*[\'"]?\s*)([^\'"\)]+)#',
		static function ( $matches ) use ( $stylesheet_url ) {
			list( , $prefix, $url ) = $matches;

			// Short-circuit if the URL does not require normalization.
			if (
				str_starts_with( $url, 'http:' ) ||
				str_starts_with( $url, 'https:' ) ||
				str_starts_with( $url, '/' ) ||
				str_starts_with( $url, '#' ) ||
				str_starts_with( $url, 'data:' )
			) {
				return $matches[0];
			}

			// Build the absolute URL.
			$absolute_url = dirname( $stylesheet_url ) . '/' . $url;
			$absolute_url = str_replace( '/./', '/', $absolute_url );

			// Convert to URL related to the site root.
			$url = nx_make_link_relative( $absolute_url );

			return $prefix . $url;
		},
		$css
	);
}

/**
 * Function that enqueues the CSS Custom Properties coming from theme.json.
 *
 * @since 5.9.0
 */
function nx_enqueue_global_styles_css_custom_properties() {
	nx_register_style( 'global-styles-css-custom-properties', false );
	nx_add_inline_style( 'global-styles-css-custom-properties', nx_get_global_stylesheet( array( 'variables' ) ) );
	nx_enqueue_style( 'global-styles-css-custom-properties' );
}

/**
 * Hooks inline styles in the proper place, depending on the active theme.
 *
 * @since 5.9.1
 * @since 6.1.0 Added the `$priority` parameter.
 *
 * For block themes, styles are loaded in the head.
 * For classic ones, styles are loaded in the body because the nx_head action happens before render_block.
 *
 * @link https://core.trac.nexuspress.org/ticket/53494.
 *
 * @param string $style    String containing the CSS styles to be added.
 * @param int    $priority To set the priority for the add_action.
 */
function nx_enqueue_block_support_styles( $style, $priority = 10 ) {
	$action_hook_name = 'nx_footer';
	if ( nx_is_block_theme() ) {
		$action_hook_name = 'nx_head';
	}
	add_action(
		$action_hook_name,
		static function () use ( $style ) {
			echo "<style>$style</style>\n";
		},
		$priority
	);
}

/**
 * Fetches, processes and compiles stored core styles, then combines and renders them to the page.
 * Styles are stored via the style engine API.
 *
 * @link https://developer.nexuspress.org/block-editor/reference-guides/packages/packages-style-engine/
 *
 * @since 6.1.0
 *
 * @param array $options {
 *     Optional. An array of options to pass to nx_style_engine_get_stylesheet_from_context().
 *     Default empty array.
 *
 *     @type bool $optimize Whether to optimize the CSS output, e.g., combine rules.
 *                          Default false.
 *     @type bool $prettify Whether to add new lines and indents to output.
 *                          Default to whether the `SCRIPT_DEBUG` constant is defined.
 * }
 */
function nx_enqueue_stored_styles( $options = array() ) {
	$is_block_theme   = nx_is_block_theme();
	$is_classic_theme = ! $is_block_theme;

	/*
	 * For block themes, this function prints stored styles in the header.
	 * For classic themes, in the footer.
	 */
	if (
		( $is_block_theme && doing_action( 'nx_footer' ) ) ||
		( $is_classic_theme && doing_action( 'nx_enqueue_scripts' ) )
	) {
		return;
	}

	$core_styles_keys         = array( 'block-supports' );
	$compiled_core_stylesheet = '';
	$style_tag_id             = 'core';
	// Adds comment if code is prettified to identify core styles sections in debugging.
	$should_prettify = isset( $options['prettify'] ) ? true === $options['prettify'] : defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;
	foreach ( $core_styles_keys as $style_key ) {
		if ( $should_prettify ) {
			$compiled_core_stylesheet .= "/**\n * Core styles: $style_key\n */\n";
		}
		// Chains core store ids to signify what the styles contain.
		$style_tag_id             .= '-' . $style_key;
		$compiled_core_stylesheet .= nx_style_engine_get_stylesheet_from_context( $style_key, $options );
	}

	// Combines Core styles.
	if ( ! empty( $compiled_core_stylesheet ) ) {
		nx_register_style( $style_tag_id, false );
		nx_add_inline_style( $style_tag_id, $compiled_core_stylesheet );
		
		nx_enqueue_style( $style_tag_id );
	}

	// Prints out any other stores registered by themes or otherwise.
	$additional_stores = NX_Style_Engine_CSS_Rules_Store::get_stores();
	foreach ( array_keys( $additional_stores ) as $store_name ) {
		if ( in_array( $store_name, $core_styles_keys, true ) ) {
			continue;
		}
		$styles = nx_style_engine_get_stylesheet_from_context( $store_name, $options );
		if ( ! empty( $styles ) ) {
			$key = "nx-style-engine-$store_name";
			nx_register_style( $key, false );
			nx_add_inline_style( $key, $styles );
			nx_enqueue_style( $key );
		}
	}
}

/**
 * Enqueues a stylesheet for a specific block.
 *
 * If the theme has opted-in to separate-styles loading,
 * then the stylesheet will be enqueued on-render,
 * otherwise when the block inits.
 *
 * @since 5.9.0
 *
 * @param string $block_name The block-name, including namespace.
 * @param array  $args       {
 *     An array of arguments. See nx_register_style() for full information about each argument.
 *
 *     @type string           $handle The handle for the stylesheet.
 *     @type string|false     $src    The source URL of the stylesheet.
 *     @type string[]         $deps   Array of registered stylesheet handles this stylesheet depends on.
 *     @type string|bool|null $ver    Stylesheet version number.
 *     @type string           $media  The media for which this stylesheet has been defined.
 *     @type string|null      $path   Absolute path to the stylesheet, so that it can potentially be inlined.
 * }
 */
function nx_enqueue_block_style( $block_name, $args ) {
	$args = nx_parse_args(
		$args,
		array(
			'handle' => '',
			'src'    => '',
			'deps'   => array(),
			'ver'    => false,
			'media'  => 'all',
		)
	);

	/**
	 * Callback function to register and enqueue styles.
	 *
	 * @param string $content When the callback is used for the render_block filter,
	 *                        the content needs to be returned so the function parameter
	 *                        is to ensure the content exists.
	 * @return string Block content.
	 */
	$callback = static function ( $content ) use ( $args ) {
		// Register the stylesheet.
		if ( ! empty( $args['src'] ) ) {
			nx_register_style( $args['handle'], $args['src'], $args['deps'], $args['ver'], $args['media'] );
		}

		// Add `path` data if provided.
		if ( isset( $args['path'] ) ) {
			nx_style_add_data( $args['handle'], 'path', $args['path'] );

			// Get the RTL file path.
			$rtl_file_path = str_replace( '.css', '-rtl.css', $args['path'] );

			// Add RTL stylesheet.
			if ( file_exists( $rtl_file_path ) ) {
				nx_style_add_data( $args['handle'], 'rtl', 'replace' );

				if ( is_rtl() ) {
					nx_style_add_data( $args['handle'], 'path', $rtl_file_path );
				}
			}
		}

		// Enqueue the stylesheet.
		nx_enqueue_style( $args['handle'] );

		return $content;
	};

	$hook = did_action( 'nx_enqueue_scripts' ) ? 'nx_footer' : 'nx_enqueue_scripts';
	if ( nx_should_load_separate_core_block_assets() ) {
		/**
		 * Callback function to register and enqueue styles.
		 *
		 * @param string $content The block content.
		 * @param array  $block   The full block, including name and attributes.
		 * @return string Block content.
		 */
		$callback_separate = static function ( $content, $block ) use ( $block_name, $callback ) {
			if ( ! empty( $block['blockName'] ) && $block_name === $block['blockName'] ) {
				return $callback( $content );
			}
			return $content;
		};

		/*
		 * The filter's callback here is an anonymous function because
		 * using a named function in this case is not possible.
		 *
		 * The function cannot be unhooked, however, users are still able
		 * to dequeue the stylesheets registered/enqueued by the callback
		 * which is why in this case, using an anonymous function
		 * was deemed acceptable.
		 */
		add_filter( 'render_block', $callback_separate, 10, 2 );
		return;
	}

	/*
	 * The filter's callback here is an anonymous function because
	 * using a named function in this case is not possible.
	 *
	 * The function cannot be unhooked, however, users are still able
	 * to dequeue the stylesheets registered/enqueued by the callback
	 * which is why in this case, using an anonymous function
	 * was deemed acceptable.
	 */
	add_filter( $hook, $callback );

	// Enqueue assets in the editor.
	add_action( 'enqueue_block_assets', $callback );
}

/**
 * Loads classic theme styles on classic themes in the frontend.
 *
 * This is needed for backwards compatibility for button blocks specifically.
 *
 * @since 6.1.0
 */
function nx_enqueue_classic_theme_styles() {
	if ( ! nx_theme_has_theme_json() ) {
		$suffix = nx_scripts_get_suffix();
		nx_register_style( 'classic-theme-styles', '/' . NXINC . "/css/classic-themes$suffix.css" );
		nx_style_add_data( 'classic-theme-styles', 'path', ABSPATH . NXINC . "/css/classic-themes$suffix.css" );
		nx_enqueue_style( 'classic-theme-styles' );
	}
}

/**
 * Loads classic theme styles on classic themes in the editor.
 *
 * This is needed for backwards compatibility for button blocks specifically.
 *
 * @since 6.1.0
 *
 * @param array $editor_settings The array of editor settings.
 * @return array A filtered array of editor settings.
 */
function nx_add_editor_classic_theme_styles( $editor_settings ) {
	if ( nx_theme_has_theme_json() ) {
		return $editor_settings;
	}

	$suffix               = nx_scripts_get_suffix();
	$classic_theme_styles = ABSPATH . NXINC . "/css/classic-themes$suffix.css";

	/*
	 * This follows the pattern of get_block_editor_theme_styles,
	 * but we can't use get_block_editor_theme_styles directly as it
	 * only handles external files or theme files.
	 */
	$classic_theme_styles_settings = array(
		'css'            => file_get_contents( $classic_theme_styles ),
		'__unstableType' => 'core',
		'isGlobalStyles' => false,
	);

	// Add these settings to the start of the array so that themes can override them.
	array_unshift( $editor_settings['styles'], $classic_theme_styles_settings );

	return $editor_settings;
}

/**
 * Removes leading and trailing _empty_ script tags.
 *
 * This is a helper meant to be used for literal script tag construction
 * within `nx_get_inline_script_tag()` or `nx_print_inline_script_tag()`.
 * It removes the literal values of "<script>" and "</script>" from
 * around an inline script after trimming whitespace. Typically this
 * is used in conjunction with output buffering, where `ob_get_clean()`
 * is passed as the `$contents` argument.
 *
 * Example:
 *
 *     // Strips exact literal empty SCRIPT tags.
 *     $js = '<script>sayHello();</script>;
 *     'sayHello();' === nx_remove_surrounding_empty_script_tags( $js );
 *
 *     // Otherwise if anything is different it warns in the JS console.
 *     $js = '<script type="text/javascript">console.log( "hi" );</script>';
 *     'console.error( ... )' === nx_remove_surrounding_empty_script_tags( $js );
 *
 * @since 6.4.0
 * @access private
 *
 * @see nx_print_inline_script_tag()
 * @see nx_get_inline_script_tag()
 *
 * @param string $contents Script body with manually created SCRIPT tag literals.
 * @return string Script body without surrounding script tag literals, or
 *                original contents if both exact literals aren't present.
 */
function nx_remove_surrounding_empty_script_tags( $contents ) {
	$contents = trim( $contents );
	$opener   = '<SCRIPT>';
	$closer   = '</SCRIPT>';

	if (
		strlen( $contents ) > strlen( $opener ) + strlen( $closer ) &&
		strtoupper( substr( $contents, 0, strlen( $opener ) ) ) === $opener &&
		strtoupper( substr( $contents, -strlen( $closer ) ) ) === $closer
	) {
		return substr( $contents, strlen( $opener ), -strlen( $closer ) );
	} else {
		$error_message = __( 'Expected string to start with script tag (without attributes) and end with script tag, with optional whitespace.' );
		_doing_it_wrong( __FUNCTION__, $error_message, '6.4' );
		return sprintf(
			'console.error(%s)',
			nx_json_encode(
				sprintf(
					/* translators: %s: nx_remove_surrounding_empty_script_tags() */
					__( 'Function %s used incorrectly in PHP.' ),
					'nx_remove_surrounding_empty_script_tags()'
				) . ' ' . $error_message
			)
		);
	}
}
