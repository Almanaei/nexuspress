<?php
/**
 * Loads the correct template based on the visitor's url
 *
 * @package NexusPress
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Set a safety flag to ensure we're in the template loader
define('NX_TEMPLATE_LOADER', true);

// Don't load templates if not using themes
if (!nx_using_themes()) {
    return;
}

/**
 * Filter whether to allow 'HEAD' requests to generate content.
 * Provides a significant performance bump by not processing the template engine for HEAD requests.
 * Enabled by default.
 */
if ('HEAD' === $_SERVER['REQUEST_METHOD'] && apply_filters('nx_template_loader_disable_head', true)) {
    return;
}

// For user-specific content, add a cache-control header
$no_cache = false;

// Get the path to the template file
$template = false;
$stylesheet = '';
$template_path = '';

// Try to load a template based on the request
if (is_embed()) {
    $template = get_embed_template();
} elseif (is_404()) {
    $template = get_404_template();
} elseif (is_search()) {
    $template = get_search_template();
} elseif (is_front_page()) {
    $template = get_front_page_template();
} elseif (is_home()) {
    $template = get_home_template();
} elseif (is_privacy_policy()) {
    $template = get_privacy_policy_template();
} elseif (is_post_type_archive()) {
    $template = get_post_type_archive_template();
} elseif (is_tax()) {
    $template = get_taxonomy_template();
} elseif (is_attachment()) {
    $template = get_attachment_template();
} elseif (is_singular()) {
    $template = get_singular_template();
} elseif (is_category()) {
    $template = get_category_template();
} elseif (is_tag()) {
    $template = get_tag_template();
} elseif (is_author()) {
    $template = get_author_template();
} elseif (is_date()) {
    $template = get_date_template();
} elseif (is_archive()) {
    $template = get_archive_template();
} else {
    $template = get_index_template();
}

/**
 * For debugging: Display template path
 */
if (defined('NX_DEBUG') && NX_DEBUG && defined('NX_DEBUG_DISPLAY') && NX_DEBUG_DISPLAY) {
    error_log('Loading template: ' . ($template ? $template : 'No template found'));
}

/**
 * Filter the path of the current template.
 */
$template = apply_filters('template_include', $template);

if ($template) {
    if (is_array($template)) {
        foreach ($template as $template_file) {
            if (validate_file($template_file) === 0) {
                include $template_file;
            }
        }
    } elseif (validate_file($template) === 0) {
        include $template;
    }
} 