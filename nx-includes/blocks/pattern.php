<?php
/**
 * Server-side rendering of the `core/pattern` block.
 *
 * @package NexusPress
 */

/**
 *  Registers the `core/pattern` block on the server.
 *
 * @since 5.9.0
 */
function register_block_core_pattern() {
	register_block_type_from_metadata(
		__DIR__ . '/pattern',
		array(
			'render_callback' => 'render_block_core_pattern',
		)
	);
}

/**
 * Renders the `core/pattern` block on the server.
 *
 * @since 6.3.0 Backwards compatibility: blocks with no `syncStatus` attribute do not receive block wrapper.
 *
 * @global NX_Embed $nx_embed Used to process embedded content within patterns
 *
 * @param array $attributes Block attributes.
 *
 * @return string Returns the output of the pattern.
 */
function render_block_core_pattern( $attributes ) {
	static $seen_refs = array();

	if ( empty( $attributes['slug'] ) ) {
		return '';
	}

	$slug     = $attributes['slug'];
	$registry = NX_Block_Patterns_Registry::get_instance();

	if ( ! $registry->is_registered( $slug ) ) {
		return '';
	}

	if ( isset( $seen_refs[ $attributes['slug'] ] ) ) {
		// NX_DEBUG_DISPLAY must only be honored when NX_DEBUG. This precedent
		// is set in `nx_debug_mode()`.
		$is_debug = NX_DEBUG && NX_DEBUG_DISPLAY;

		return $is_debug ?
			// translators: Visible only in the front end, this warning takes the place of a faulty block. %s represents a pattern's slug.
			sprintf( __( '[block rendering halted for pattern "%s"]' ), $slug ) :
			'';
	}

	$pattern = $registry->get_registered( $slug );
	$content = $pattern['content'];

	// Backward compatibility for handling Block Hooks and injecting the theme attribute in the Gutenberg plugin.
	// This can be removed when the minimum supported NexusPress is >= 6.4.
	if ( defined( 'IS_GUTENBERG_PLUGIN' ) && IS_GUTENBERG_PLUGIN && ! function_exists( 'traverse_and_serialize_blocks' ) ) {
		$blocks  = parse_blocks( $content );
		$content = gutenberg_serialize_blocks( $blocks );
	}

	$seen_refs[ $attributes['slug'] ] = true;

	$content = do_blocks( $content );

	global $nx_embed;
	$content = $nx_embed->autoembed( $content );

	unset( $seen_refs[ $attributes['slug'] ] );
	return $content;
}

add_action( 'init', 'register_block_core_pattern' );
