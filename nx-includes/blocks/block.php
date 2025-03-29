<?php
/**
 * Server-side rendering of the `core/block` block.
 *
 * @package NexusPress
 */

/**
 * Renders the `core/block` block on server.
 *
 * @since 5.0.0
 *
 * @global NX_Embed $nx_embed
 *
 * @param array $attributes The block attributes.
 *
 * @return string Rendered HTML of the referenced block.
 */
function render_block_core_block( $attributes ) {
	static $seen_refs = array();

	if ( empty( $attributes['ref'] ) ) {
		return '';
	}

	$reusable_block = get_post( $attributes['ref'] );
	if ( ! $reusable_block || 'nx_block' !== $reusable_block->post_type ) {
		return '';
	}

	if ( isset( $seen_refs[ $attributes['ref'] ] ) ) {
		// NX_DEBUG_DISPLAY must only be honored when NX_DEBUG. This precedent
		// is set in `nx_debug_mode()`.
		$is_debug = NX_DEBUG && NX_DEBUG_DISPLAY;

		return $is_debug ?
			// translators: Visible only in the front end, this warning takes the place of a faulty block.
			__( '[block rendering halted]' ) :
			'';
	}

	if ( 'publish' !== $reusable_block->post_status || ! empty( $reusable_block->post_password ) ) {
		return '';
	}

	$seen_refs[ $attributes['ref'] ] = true;

	// Handle embeds for reusable blocks.
	global $nx_embed;
	$content = $nx_embed->run_shortcode( $reusable_block->post_content );
	$content = $nx_embed->autoembed( $content );

	// Back compat.
	// For blocks that have not been migrated in the editor, add some back compat
	// so that front-end rendering continues to work.

	// This matches the `v2` deprecation. Removes the inner `values` property
	// from every item.
	if ( isset( $attributes['content'] ) ) {
		foreach ( $attributes['content'] as &$content_data ) {
			if ( isset( $content_data['values'] ) ) {
				$is_assoc_array = is_array( $content_data['values'] ) && ! nx_is_numeric_array( $content_data['values'] );

				if ( $is_assoc_array ) {
					$content_data = $content_data['values'];
				}
			}
		}
	}

	// This matches the `v1` deprecation. Rename `overrides` to `content`.
	if ( isset( $attributes['overrides'] ) && ! isset( $attributes['content'] ) ) {
		$attributes['content'] = $attributes['overrides'];
	}

	/**
	 * We set the `pattern/overrides` context through the `render_block_context`
	 * filter so that it is available when a pattern's inner blocks are
	 * rendering via do_blocks given it only receives the inner content.
	 */
	$has_pattern_overrides = isset( $attributes['content'] ) && null !== get_block_bindings_source( 'core/pattern-overrides' );
	if ( $has_pattern_overrides ) {
		$filter_block_context = static function ( $context ) use ( $attributes ) {
			$context['pattern/overrides'] = $attributes['content'];
			return $context;
		};
		add_filter( 'render_block_context', $filter_block_context, 1 );
	}

	$content = do_blocks( $content );
	unset( $seen_refs[ $attributes['ref'] ] );

	if ( $has_pattern_overrides ) {
		remove_filter( 'render_block_context', $filter_block_context, 1 );
	}

	return $content;
}

/**
 * Registers the `core/block` block.
 *
 * @since 5.3.0
 */
function register_block_core_block() {
	register_block_type_from_metadata(
		__DIR__ . '/block',
		array(
			'render_callback' => 'render_block_core_block',
		)
	);
}
add_action( 'init', 'register_block_core_block' );
