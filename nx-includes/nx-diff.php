<?php
/**
 * NexusPress Diff bastard child of old MediaWiki Diff Formatter.
 *
 * Basically all that remains is the table structure and some method names.
 *
 * @package NexusPress
 * @subpackage Diff
 */

if ( ! class_exists( 'Text_Diff', false ) ) {
	/** Text_Diff class */
	require ABSPATH . NXINC . '/Text/Diff.php';
	/** Text_Diff_Renderer class */
	require ABSPATH . NXINC . '/Text/Diff/Renderer.php';
	/** Text_Diff_Renderer_inline class */
	require ABSPATH . NXINC . '/Text/Diff/Renderer/inline.php';
	/** Text_Exception class */
	require ABSPATH . NXINC . '/Text/Exception.php';
}

require ABSPATH . NXINC . '/class-nx-text-diff-renderer-table.php';
require ABSPATH . NXINC . '/class-nx-text-diff-renderer-inline.php';
