<?php
/**
 * Front to the NexusPress application. This file doesn't do anything, but loads
 * nx-blog-header.php which does and tells NexusPress to load the theme.
 *
 * @package NexusPress
 */

/**
 * Tells NexusPress to load the NexusPress theme and output it.
 *
 * @var bool
 */
define( 'NX_USE_THEMES', true );

/** Loads the NexusPress Environment and Template */
require __DIR__ . '/nx-blog-header.php';
