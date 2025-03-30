<?php
/**
 * Used to set up and fix common variables and include
 * the NexusPress procedural and class library.
 *
 * Allows for some configuration in nx-config.php (see default-constants.php)
 *
 * @package NexusPress
 */

// Override site URL settings for development server
if (!defined('NX_SITEURL')) {
	define('NX_SITEURL', 'http://localhost:8000');
}
if (!defined('NX_HOME')) {
	define('NX_HOME', 'http://localhost:8000');
}

/**
 * Stores the location of the NexusPress directory of functions, classes, and core content.
 *
 * @since 1.0.0
 */
define( 'NXINC', 'nx-includes' );

/**
 * Version information for the current NexusPress release.
 *
 * These can't be directly modified in nx-config.php, this is only done in
 * this file to ensure that they are kept up to date.
 *
 * @global string $nx_version             The NexusPress version string.
 * @global int    $nx_db_version          NexusPress database version.
 * @global string $tinymce_version        TinyMCE version.
 * @global string $required_php_version   The required PHP version string.
 * @global string $required_mysql_version The required MySQL version string.
 * @global string $nx_local_package       Local package location.
 */
global $nx_version, $nx_db_version, $tinymce_version, $required_php_version, $required_mysql_version, $nx_local_package;
require ABSPATH . NXINC . '/version.php';
require ABSPATH . NXINC . '/compat.php';
require ABSPATH . NXINC . '/load.php';

// Check for the required PHP version and for the MySQL extension or a database drop-in.
nx_check_php_mysql_versions();

// Include files required for initialization.
require ABSPATH . NXINC . '/class-nx-paused-extensions-storage.php';
require ABSPATH . NXINC . '/class-nx-exception.php';
require ABSPATH . NXINC . '/class-nx-fatal-error-handler.php';
require ABSPATH . NXINC . '/class-nx-recovery-mode-cookie-service.php';
require ABSPATH . NXINC . '/class-nx-recovery-mode-key-service.php';
require ABSPATH . NXINC . '/class-nx-recovery-mode-link-service.php';
require ABSPATH . NXINC . '/class-nx-recovery-mode-email-service.php';
require ABSPATH . NXINC . '/class-nx-recovery-mode.php';
require ABSPATH . NXINC . '/error-protection.php';
require ABSPATH . NXINC . '/default-constants.php';
require_once ABSPATH . NXINC . '/plugin.php';

/**
 * If not already configured, `$blog_id` will default to 1 in a single site
 * configuration. In multisite, it will be overridden by default in ms-settings.php.
 *
 * @since 2.0.0
 *
 * @global int $blog_id
 */
global $blog_id;

// Set initial default constants including NX_MEMORY_LIMIT, NX_MAX_MEMORY_LIMIT, NX_DEBUG, SCRIPT_DEBUG, NX_CONTENT_DIR and NX_CACHE.
nx_initial_constants();

// Register the shutdown handler for fatal errors as soon as possible.
nx_register_fatal_error_handler();

// NexusPress calculates offsets from UTC.
// phpcs:ignore NexusPress.DateTime.RestrictedFunctions.timezone_change_date_default_timezone_set
date_default_timezone_set( 'UTC' );

// Standardize $_SERVER variables across setups.
nx_fix_server_vars();

// Check if the site is in maintenance mode.
nx_maintenance();

// Start loading timer.
timer_start();

// Check if NX_DEBUG mode is enabled.
nx_debug_mode();

/**
 * Filters whether to enable loading of the advanced-cache.php drop-in.
 *
 * This filter runs before it can be used by plugins. It is designed for non-web
 * run-times. If false is returned, advanced-cache.php will never be loaded.
 *
 * @since 4.6.0
 *
 * @param bool $enable_advanced_cache Whether to enable loading advanced-cache.php (if present).
 *                                    Default true.
 */
if ( NX_CACHE && apply_filters( 'enable_loading_advanced_cache_dropin', true ) && file_exists( NX_CONTENT_DIR . '/advanced-cache.php' ) ) {
	// For an advanced caching plugin to use. Uses a static drop-in because you would only want one.
	include NX_CONTENT_DIR . '/advanced-cache.php';

	// Re-initialize any hooks added manually by advanced-cache.php.
	if ( $nx_filter ) {
		$nx_filter = NX_Hook::build_preinitialized_hooks( $nx_filter );
	}
}

// Define NX_LANG_DIR if not set.
nx_set_lang_dir();

// Load early NexusPress files.
require ABSPATH . NXINC . '/class-nx-list-util.php';
require ABSPATH . NXINC . '/class-nx-token-map.php';
require ABSPATH . NXINC . '/formatting.php';
require ABSPATH . NXINC . '/meta.php';
require ABSPATH . NXINC . '/functions.php';
require ABSPATH . NXINC . '/class-nx-meta-query.php';
require ABSPATH . NXINC . '/class-nx-matchesmapregex.php';
require ABSPATH . NXINC . '/class-nx.php';
require ABSPATH . NXINC . '/class-nx-error.php';
require ABSPATH . NXINC . '/pomo/mo.php';
require ABSPATH . NXINC . '/l10n/class-nx-translation-controller.php';
require ABSPATH . NXINC . '/l10n/class-nx-translations.php';
require ABSPATH . NXINC . '/l10n/class-nx-translation-file.php';
require ABSPATH . NXINC . '/l10n/class-nx-translation-file-mo.php';
require ABSPATH . NXINC . '/l10n/class-nx-translation-file-php.php';

/**
 * @global nxdb $nxdb NexusPress database abstraction object.
 */
global $nxdb;
// Temporarily disabled database connection - this will be handled by our mock in load.php
require_nx_db();

/**
 * @since 3.3.0
 *
 * @global string $table_prefix The database table prefix.
 */
$GLOBALS['table_prefix'] = $table_prefix;

// Set the database table prefix and the format specifiers for database table columns.
nx_set_nxdb_vars();

// Start the NexusPress object cache, or an external object cache if the drop-in is present.
nx_start_object_cache();

// For development, redirect upgrade.php to our custom admin page
if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/nx-admin/upgrade.php') !== false) {
    header('Location: ' . NX_SITEURL . '/admin.php');
    exit;
}

// Attach the default filters.
require ABSPATH . NXINC . '/default-filters.php';

// Initialize multisite if enabled.
if ( is_multisite() ) {
	require ABSPATH . NXINC . '/class-nx-site-query.php';
	require ABSPATH . NXINC . '/class-nx-network-query.php';
	require ABSPATH . NXINC . '/ms-blogs.php';
	require ABSPATH . NXINC . '/ms-settings.php';
} elseif ( ! defined( 'MULTISITE' ) ) {
	define( 'MULTISITE', false );
}

register_shutdown_function( 'shutdown_action_hook' );

// Stop most of NexusPress from being loaded if SHORTINIT is enabled.
if ( SHORTINIT ) {
	return false;
}

// Load the L10n library.
require_once ABSPATH . NXINC . '/l10n.php';
require_once ABSPATH . NXINC . '/class-nx-textdomain-registry.php';
require_once ABSPATH . NXINC . '/class-nx-locale.php';
require_once ABSPATH . NXINC . '/class-nx-locale-switcher.php';

// Run the installer if NexusPress is not installed.
nx_not_installed();

// Load most of NexusPress.
require ABSPATH . NXINC . '/class-nx-walker.php';
require ABSPATH . NXINC . '/class-nx-ajax-response.php';
require ABSPATH . NXINC . '/capabilities.php';
require ABSPATH . NXINC . '/class-nx-roles.php';
require ABSPATH . NXINC . '/class-nx-role.php';
require ABSPATH . NXINC . '/class-nx-user.php';
require ABSPATH . NXINC . '/class-nx-query.php';
require ABSPATH . NXINC . '/query.php';
require ABSPATH . NXINC . '/class-nx-date-query.php';
require ABSPATH . NXINC . '/theme.php';
require ABSPATH . NXINC . '/class-nx-theme.php';
require ABSPATH . NXINC . '/class-nx-theme-json-schema.php';
require ABSPATH . NXINC . '/class-nx-theme-json-data.php';
require ABSPATH . NXINC . '/class-nx-theme-json.php';
require ABSPATH . NXINC . '/class-nx-theme-json-resolver.php';
require ABSPATH . NXINC . '/class-nx-duotone.php';
require ABSPATH . NXINC . '/global-styles-and-settings.php';
require ABSPATH . NXINC . '/class-nx-block-template.php';
require ABSPATH . NXINC . '/class-nx-block-templates-registry.php';
require ABSPATH . NXINC . '/block-template-utils.php';
require ABSPATH . NXINC . '/block-template.php';
require ABSPATH . NXINC . '/theme-templates.php';
require ABSPATH . NXINC . '/theme-previews.php';
require ABSPATH . NXINC . '/template.php';
require ABSPATH . NXINC . '/https-detection.php';
require ABSPATH . NXINC . '/https-migration.php';
require ABSPATH . NXINC . '/class-nx-user-request.php';
require ABSPATH . NXINC . '/user.php';
require ABSPATH . NXINC . '/class-nx-user-query.php';
require ABSPATH . NXINC . '/class-nx-session-tokens.php';
require ABSPATH . NXINC . '/class-nx-user-meta-session-tokens.php';
require ABSPATH . NXINC . '/general-template.php';
require ABSPATH . NXINC . '/link-template.php';
require ABSPATH . NXINC . '/author-template.php';
require ABSPATH . NXINC . '/robots-template.php';
require ABSPATH . NXINC . '/post.php';
require ABSPATH . NXINC . '/class-walker-page.php';
require ABSPATH . NXINC . '/class-walker-page-dropdown.php';
require ABSPATH . NXINC . '/class-nx-post-type.php';
require ABSPATH . NXINC . '/class-nx-post.php';
require ABSPATH . NXINC . '/post-template.php';
require ABSPATH . NXINC . '/revision.php';
require ABSPATH . NXINC . '/post-formats.php';
require ABSPATH . NXINC . '/post-thumbnail-template.php';
require ABSPATH . NXINC . '/category.php';
require ABSPATH . NXINC . '/class-walker-category.php';
require ABSPATH . NXINC . '/class-walker-category-dropdown.php';
require ABSPATH . NXINC . '/category-template.php';
require ABSPATH . NXINC . '/comment.php';
require ABSPATH . NXINC . '/class-nx-comment.php';
require ABSPATH . NXINC . '/class-nx-comment-query.php';
require ABSPATH . NXINC . '/class-walker-comment.php';
require ABSPATH . NXINC . '/comment-template.php';
require ABSPATH . NXINC . '/rewrite.php';
require ABSPATH . NXINC . '/class-nx-rewrite.php';
require ABSPATH . NXINC . '/feed.php';
require ABSPATH . NXINC . '/bookmark.php';
require ABSPATH . NXINC . '/bookmark-template.php';
require ABSPATH . NXINC . '/kses.php';
require ABSPATH . NXINC . '/cron.php';
require ABSPATH . NXINC . '/deprecated.php';
require ABSPATH . NXINC . '/script-loader.php';
require ABSPATH . NXINC . '/taxonomy.php';
require ABSPATH . NXINC . '/class-nx-taxonomy.php';
require ABSPATH . NXINC . '/class-nx-term.php';
require ABSPATH . NXINC . '/class-nx-term-query.php';
require ABSPATH . NXINC . '/class-nx-tax-query.php';
require ABSPATH . NXINC . '/update.php';
require ABSPATH . NXINC . '/canonical.php';
require ABSPATH . NXINC . '/shortcodes.php';
require ABSPATH . NXINC . '/embed.php';
require ABSPATH . NXINC . '/class-nx-embed.php';
require ABSPATH . NXINC . '/class-nx-oembed.php';
require ABSPATH . NXINC . '/class-nx-oembed-controller.php';
require ABSPATH . NXINC . '/media.php';
require ABSPATH . NXINC . '/http.php';
require ABSPATH . NXINC . '/html-api/html5-named-character-references.php';
require ABSPATH . NXINC . '/html-api/class-nx-html-attribute-token.php';
require ABSPATH . NXINC . '/html-api/class-nx-html-span.php';
require ABSPATH . NXINC . '/html-api/class-nx-html-doctype-info.php';
require ABSPATH . NXINC . '/html-api/class-nx-html-text-replacement.php';
require ABSPATH . NXINC . '/html-api/class-nx-html-decoder.php';
require ABSPATH . NXINC . '/html-api/class-nx-html-tag-processor.php';
require ABSPATH . NXINC . '/html-api/class-nx-html-unsupported-exception.php';
require ABSPATH . NXINC . '/html-api/class-nx-html-active-formatting-elements.php';
require ABSPATH . NXINC . '/html-api/class-nx-html-open-elements.php';
require ABSPATH . NXINC . '/html-api/class-nx-html-token.php';
require ABSPATH . NXINC . '/html-api/class-nx-html-stack-event.php';
require ABSPATH . NXINC . '/html-api/class-nx-html-processor-state.php';
require ABSPATH . NXINC . '/html-api/class-nx-html-processor.php';
require ABSPATH . NXINC . '/class-nx-http.php';
require ABSPATH . NXINC . '/class-nx-http-streams.php';
require ABSPATH . NXINC . '/class-nx-http-curl.php';
require ABSPATH . NXINC . '/class-nx-http-proxy.php';
require ABSPATH . NXINC . '/class-nx-http-cookie.php';
require ABSPATH . NXINC . '/class-nx-http-encoding.php';
require ABSPATH . NXINC . '/class-nx-http-response.php';
require ABSPATH . NXINC . '/class-nx-http-requests-response.php';
require ABSPATH . NXINC . '/class-nx-http-requests-hooks.php';
require ABSPATH . NXINC . '/widgets.php';
require ABSPATH . NXINC . '/class-nx-widget.php';
require ABSPATH . NXINC . '/class-nx-widget-factory.php';
require ABSPATH . NXINC . '/nav-menu-template.php';
require ABSPATH . NXINC . '/nav-menu.php';
require ABSPATH . NXINC . '/admin-bar.php';
require ABSPATH . NXINC . '/class-nx-application-passwords.php';
require ABSPATH . NXINC . '/rest-api.php';
require ABSPATH . NXINC . '/rest-api/class-nx-rest-server.php';
require ABSPATH . NXINC . '/rest-api/class-nx-rest-response.php';
require ABSPATH . NXINC . '/rest-api/class-nx-rest-request.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-posts-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-attachments-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-global-styles-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-post-types-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-post-statuses-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-revisions-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-global-styles-revisions-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-template-revisions-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-autosaves-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-template-autosaves-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-taxonomies-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-terms-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-menu-items-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-menus-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-menu-locations-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-users-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-comments-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-search-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-blocks-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-block-types-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-block-renderer-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-settings-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-themes-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-plugins-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-block-directory-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-edit-site-export-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-pattern-directory-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-block-patterns-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-block-pattern-categories-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-application-passwords-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-sidebars-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-widget-types-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-widgets-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-templates-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-url-details-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-navigation-fallback-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-font-families-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-font-faces-controller.php';
require ABSPATH . NXINC . '/rest-api/endpoints/class-nx-rest-font-collections-controller.php';
require ABSPATH . NXINC . '/rest-api/fields/class-nx-rest-meta-fields.php';
require ABSPATH . NXINC . '/rest-api/fields/class-nx-rest-comment-meta-fields.php';
require ABSPATH . NXINC . '/rest-api/fields/class-nx-rest-post-meta-fields.php';
require ABSPATH . NXINC . '/rest-api/fields/class-nx-rest-term-meta-fields.php';
require ABSPATH . NXINC . '/rest-api/fields/class-nx-rest-user-meta-fields.php';
require ABSPATH . NXINC . '/rest-api/search/class-nx-rest-search-handler.php';
require ABSPATH . NXINC . '/rest-api/search/class-nx-rest-post-search-handler.php';
require ABSPATH . NXINC . '/rest-api/search/class-nx-rest-term-search-handler.php';
require ABSPATH . NXINC . '/rest-api/search/class-nx-rest-post-format-search-handler.php';
require ABSPATH . NXINC . '/sitemaps.php';
require ABSPATH . NXINC . '/sitemaps/class-nx-sitemaps.php';
require ABSPATH . NXINC . '/sitemaps/class-nx-sitemaps-index.php';
require ABSPATH . NXINC . '/sitemaps/class-nx-sitemaps-provider.php';
require ABSPATH . NXINC . '/sitemaps/class-nx-sitemaps-registry.php';
require ABSPATH . NXINC . '/sitemaps/class-nx-sitemaps-renderer.php';
require ABSPATH . NXINC . '/sitemaps/class-nx-sitemaps-stylesheet.php';
require ABSPATH . NXINC . '/sitemaps/providers/class-nx-sitemaps-posts.php';
require ABSPATH . NXINC . '/sitemaps/providers/class-nx-sitemaps-taxonomies.php';
require ABSPATH . NXINC . '/sitemaps/providers/class-nx-sitemaps-users.php';
require ABSPATH . NXINC . '/class-nx-block-bindings-source.php';
require ABSPATH . NXINC . '/class-nx-block-bindings-registry.php';
require ABSPATH . NXINC . '/class-nx-block-editor-context.php';
require ABSPATH . NXINC . '/class-nx-block-type.php';
require ABSPATH . NXINC . '/class-nx-block-pattern-categories-registry.php';
require ABSPATH . NXINC . '/class-nx-block-patterns-registry.php';
require ABSPATH . NXINC . '/class-nx-block-styles-registry.php';
require ABSPATH . NXINC . '/class-nx-block-type-registry.php';
require ABSPATH . NXINC . '/class-nx-block.php';
require ABSPATH . NXINC . '/class-nx-block-list.php';
require ABSPATH . NXINC . '/class-nx-block-metadata-registry.php';
require ABSPATH . NXINC . '/class-nx-block-parser-block.php';
require ABSPATH . NXINC . '/class-nx-block-parser-frame.php';
require ABSPATH . NXINC . '/class-nx-block-parser.php';
require ABSPATH . NXINC . '/class-nx-classic-to-block-menu-converter.php';
require ABSPATH . NXINC . '/class-nx-navigation-fallback.php';
require ABSPATH . NXINC . '/block-bindings.php';
require ABSPATH . NXINC . '/block-bindings/pattern-overrides.php';
require ABSPATH . NXINC . '/block-bindings/post-meta.php';
require ABSPATH . NXINC . '/blocks.php';
require ABSPATH . NXINC . '/blocks/index.php';
require ABSPATH . NXINC . '/block-editor.php';
require ABSPATH . NXINC . '/block-patterns.php';
require ABSPATH . NXINC . '/class-nx-block-supports.php';
require ABSPATH . NXINC . '/block-supports/utils.php';
require ABSPATH . NXINC . '/block-supports/align.php';
require ABSPATH . NXINC . '/block-supports/custom-classname.php';
require ABSPATH . NXINC . '/block-supports/generated-classname.php';
require ABSPATH . NXINC . '/block-supports/settings.php';
require ABSPATH . NXINC . '/block-supports/elements.php';
require ABSPATH . NXINC . '/block-supports/colors.php';
require ABSPATH . NXINC . '/block-supports/typography.php';
require ABSPATH . NXINC . '/block-supports/border.php';
require ABSPATH . NXINC . '/block-supports/layout.php';
require ABSPATH . NXINC . '/block-supports/position.php';
require ABSPATH . NXINC . '/block-supports/spacing.php';
require ABSPATH . NXINC . '/block-supports/dimensions.php';
require ABSPATH . NXINC . '/block-supports/duotone.php';
require ABSPATH . NXINC . '/block-supports/shadow.php';
require ABSPATH . NXINC . '/block-supports/background.php';
require ABSPATH . NXINC . '/block-supports/block-style-variations.php';
require ABSPATH . NXINC . '/style-engine.php';
require ABSPATH . NXINC . '/style-engine/class-nx-style-engine.php';
require ABSPATH . NXINC . '/style-engine/class-nx-style-engine-css-declarations.php';
require ABSPATH . NXINC . '/style-engine/class-nx-style-engine-css-rule.php';
require ABSPATH . NXINC . '/style-engine/class-nx-style-engine-css-rules-store.php';
require ABSPATH . NXINC . '/style-engine/class-nx-style-engine-processor.php';
require ABSPATH . NXINC . '/fonts/class-nx-font-face-resolver.php';
require ABSPATH . NXINC . '/fonts/class-nx-font-collection.php';
require ABSPATH . NXINC . '/fonts/class-nx-font-face.php';
require ABSPATH . NXINC . '/fonts/class-nx-font-library.php';
require ABSPATH . NXINC . '/fonts/class-nx-font-utils.php';
require ABSPATH . NXINC . '/fonts.php';
require ABSPATH . NXINC . '/class-nx-script-modules.php';
require ABSPATH . NXINC . '/script-modules.php';
require ABSPATH . NXINC . '/interactivity-api/class-nx-interactivity-api.php';
require ABSPATH . NXINC . '/interactivity-api/class-nx-interactivity-api-directives-processor.php';
require ABSPATH . NXINC . '/interactivity-api/interactivity-api.php';
require ABSPATH . NXINC . '/class-nx-plugin-dependencies.php';

add_action( 'after_setup_theme', array( nx_script_modules(), 'add_hooks' ) );
add_action( 'after_setup_theme', array( nx_interactivity(), 'add_hooks' ) );

/**
 * @global NX_Embed $nx_embed NexusPress Embed object.
 */
$GLOBALS['nx_embed'] = new NX_Embed();

/**
 * NexusPress Textdomain Registry object.
 *
 * @since 6.1.0
 *
 * @global NX_Textdomain_Registry $nx_textdomain_registry NexusPress Textdomain Registry.
 */
// Create the registry only if the class exists
if (class_exists('NX_Textdomain_Registry')) {
	$GLOBALS['nx_textdomain_registry'] = new NX_Textdomain_Registry();
	if (method_exists($GLOBALS['nx_textdomain_registry'], 'init')) {
		$GLOBALS['nx_textdomain_registry']->init();
	}
} else {
	// Set to an empty object to prevent fatal errors
	$GLOBALS['nx_textdomain_registry'] = new stdClass();
}

// Load multisite-specific files.
if ( is_multisite() ) {
	require ABSPATH . NXINC . '/ms-functions.php';
	require ABSPATH . NXINC . '/ms-default-filters.php';
	require ABSPATH . NXINC . '/ms-deprecated.php';
}

// Define constants that rely on the API to obtain the default value.
// Define must-use plugin directory constants, which may be overridden in the sunrise.php drop-in.
nx_plugin_directory_constants();

/**
 * @global array $nx_plugin_paths
 */
$GLOBALS['nx_plugin_paths'] = array();

// Load must-use plugins.
foreach ( nx_get_mu_plugins() as $mu_plugin ) {
	$_nx_plugin_file = $mu_plugin;
	$mu_plugin = $_nx_plugin_file; // Avoid stomping of the $mu_plugin variable in a plugin.

	/**
	 * Fires once a single must-use plugin has loaded.
	 *
	 * @since 5.1.0
	 *
	 * @param string $mu_plugin Full path to the plugin's main file.
	 */
	do_action( 'mu_plugin_loaded', $mu_plugin );
}
unset( $mu_plugin, $_nx_plugin_file );

// Load network activated plugins.
if ( is_multisite() ) {
	foreach ( nx_get_active_network_plugins() as $network_plugin ) {
		nx_register_plugin_realpath( $network_plugin );
		$_nx_plugin_file = $network_plugin;
		$network_plugin = $_nx_plugin_file; // Avoid stomping of the $network_plugin variable in a plugin.

		/**
		 * Fires once a single network-activated plugin has loaded.
		 *
		 * @since 5.1.0
		 *
		 * @param string $network_plugin Full path to the plugin's main file.
		 */
		do_action( 'network_plugin_loaded', $network_plugin );
	}
	unset( $network_plugin, $_nx_plugin_file );
}

/**
 * Fires once all must-use and network-activated plugins have loaded.
 *
 * @since 2.8.0
 */
do_action( 'muplugins_loaded' );

if ( is_multisite() ) {
	ms_cookie_constants();
}

// Define constants after multisite is loaded.
nx_cookie_constants();

// Define and enforce our SSL constants.
nx_ssl_constants();

// Create common globals.
require ABSPATH . NXINC . '/vars.php';

// Make taxonomies and posts available to plugins and themes.
// @plugin authors: warning: these get registered again on the init hook.
create_initial_taxonomies();
create_initial_post_types();

nx_start_scraping_edited_file_errors();

// Register the default theme directory root.
register_theme_directory( get_theme_root() );

if ( ! is_multisite() && nx_is_fatal_error_handler_enabled() ) {
	// Handle users requesting a recovery mode link and initiating recovery mode.
	nx_recovery_mode()->initialize();
}

// Load active plugins.
foreach ( nx_get_active_and_valid_plugins() as $plugin ) {
	nx_register_plugin_realpath( $plugin );
	$_nx_plugin_file = $plugin;
	$plugin = $_nx_plugin_file; // Avoid stomping of the $plugin variable in a plugin.

	/**
	 * Fires once a single activated plugin has loaded.
	 *
	 * @since 5.1.0
	 *
	 * @param string $plugin Full path to the plugin's main file.
	 */
	do_action( 'plugin_loaded', $plugin );
}
unset( $plugin, $_nx_plugin_file );

// Load pluggable functions.
require ABSPATH . NXINC . '/pluggable.php';
require ABSPATH . NXINC . '/pluggable-deprecated.php';

// Set internal encoding.
nx_set_internal_encoding();

// Run nx_cache_postload() if object cache is enabled and the function exists.
if ( NX_CACHE && function_exists( 'nx_cache_postload' ) ) {
	nx_cache_postload();
}

/**
 * Fires after activated plugins have loaded.
 *
 * Pluggable functions are also available at this point in the loading order.
 *
 * @since 1.5.0
 */
do_action( 'plugins_loaded' );

// Define constants which affect functionality if not already defined.
nx_functionality_constants();

// Add magic quotes and set up $_REQUEST ( $_GET + $_POST ).
nx_magic_quotes();

/**
 * Fires when comment cookies are sanitized.
 *
 * @since 2.0.11
 */
do_action( 'sanitize_comment_cookies' );

/**
 * NexusPress Query object
 *
 * @global NX_Query $nx_the_query NexusPress Query object.
 */
global $nx_the_query;

/**
 * Use this global for NexusPress queries
 *
 * @global NX_Query $nx_query NexusPress Query object.
 */
global $nx_query;

/**
 * Holds the NexusPress Rewrite object for creating pretty URLs
 *
 * @global NX_Rewrite $nx_rewrite NexusPress rewrite component.
 */
global $nx_rewrite;

/**
 * NexusPress Object
 *
 * @global NX $nx Current NexusPress environment instance.
 */
global $nx;

/**
 * NexusPress Widget Factory Object
 *
 * @global NX_Widget_Factory $nx_widget_factory
 */
global $nx_widget_factory;

/**
 * NexusPress User Roles
 *
 * @global NX_Roles $nx_roles NexusPress role management object.
 */
global $nx_roles;

/**
 * Fires before the theme is loaded.
 *
 * @since 2.6.0
 */
do_action( 'setup_theme' );

// Define the template related constants and globals.
nx_templating_constants();
nx_set_template_globals();

// Load the default text localization domain.
load_default_textdomain();

$locale      = get_locale();
$locale_file = NX_LANG_DIR . "/$locale.php";
if ( ( 0 === validate_file( $locale ) ) && is_readable( $locale_file ) ) {
	require $locale_file;
}
unset( $locale_file );

/**
 * NexusPress Locale object for loading locale domain date and various strings.
 *
 * @global NX_Locale $nx_locale NexusPress date and time locale object.
 */
global $nx_locale;

/**
 * NexusPress Locale Switcher object for switching locales.
 *
 * @global NX_Locale_Switcher $nx_locale_switcher NexusPress locale switcher object.
 */
global $nx_locale_switcher;

// Load the functions for the active theme, for both parent and child theme if applicable.
foreach ( nx_get_active_and_valid_themes() as $theme ) {
	if ( file_exists( $theme . '/functions.php' ) ) {
		include $theme . '/functions.php';
	}
}
unset( $theme );

/**
 * Fires after the theme is loaded.
 *
 * @since 3.0.0
 */
do_action( 'after_setup_theme' );

// Create an instance of NX_Site_Health so that Cron events may fire.
if ( ! class_exists( 'NX_Site_Health' ) ) {
	require_once ABSPATH . 'nx-admin/includes/class-nx-site-health.php';
}
NX_Site_Health::get_instance();

// Set up current user.
if (isset($GLOBALS['nx']) && is_object($GLOBALS['nx']) && method_exists($GLOBALS['nx'], 'init')) {
	$GLOBALS['nx']->init();
} else {
	// Create a basic object if NX is not available
	$GLOBALS['nx'] = new stdClass();
	error_log('Warning: $GLOBALS[\'nx\'] was not properly initialized before nx-settings.php:666');
}

/**
 * Fires after NexusPress has finished loading but before any headers are sent.
 *
 * Most of NX is loaded at this stage, and the user is authenticated. NX continues
 * to load on the {@see 'init'} hook that follows (e.g. widgets), and many plugins instantiate
 * themselves on it for all sorts of reasons (e.g. they need a user, a taxonomy, etc.).
 *
 * If you wish to plug an action once NexusPress is loaded, use the {@see 'nx_loaded'} hook below.
 *
 * @since 1.5.0
 */
do_action( 'init' );

// Check site status.
if ( is_multisite() ) {
	$file = ms_site_check();
	if ( true !== $file ) {
		require $file;
		die();
	}
	unset( $file );
}

/**
 * This hook is fired once NX, all plugins, and the theme are fully loaded and instantiated.
 *
 * Ajax requests should use nx-admin/admin-ajax.php. admin-ajax.php can handle requests for
 * users not logged in.
 *
 * @link https://developer.nexuspress.org/plugins/javascript/ajax
 *
 * @since 3.0.0
 */
do_action( 'nx_loaded' );
