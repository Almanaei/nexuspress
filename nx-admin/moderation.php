<?php
/**
 * Comment Moderation Administration Screen.
 *
 * Redirects to edit-comments.php?comment_status=moderated.
 *
 * @package NexusPress
 * @subpackage Administration
 */
require_once dirname( __DIR__ ) . '/nx-load.php';
nx_redirect( admin_url( 'edit-comments.php?comment_status=moderated' ) );
exit;
