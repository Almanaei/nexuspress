<?php
/**
 * Theme, template, and stylesheet functions.
 *
 * @package NexusPress
 * @subpackage Theme
 */

/**
 * Returns an array of NX_Theme objects based on the arguments.
 *
 * Despite advances over get_themes(), this function is quite expensive, and grows
 * linearly with additional themes. Stick to nx_get_theme() if possible.
 *
 * @since 3.4.0
 *
 * @global array $nx_theme_directories
 *
 * @param array $args {
 *     Optional. The search arguments.
 *
 *     @type mixed $errors  True to return themes with errors, false to return
 *                          themes without errors, null to return all themes.
 *                          Default false.
 *     @type mixed $allowed (Multisite) True to return only allowed themes for a site.
 *                          False to return only disallowed themes for a site.
 *                          'site' to return only site-allowed themes.
 *                          'network' to return only network-allowed themes.
 *                          Null to return all themes. Default null.
 *     @type int   $blog_id (Multisite) The blog ID used to calculate which themes
 *                          are allowed. Default 0, synonymous for the current blog.
 * }
 * @return NX_Theme[] Array of NX_Theme objects.
 */
// ... existing code ... 