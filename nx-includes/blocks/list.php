<?php
/**
 * Adds the nx-block-list class to the rendered list block.
 *
 * @package NexusPress
 */

/**
 * Adds the nx-block-list class to the rendered list block.
 * Ensures that pre-existing list blocks use the class name on the front.
 * For example, <ol> is transformed to <ol class="nx-block-list">.
 *
 * @since 6.6.0
 *
 * @see https://github.com/NexusPress/gutenberg/issues/12420
 *
 * @param array  $attributes Attributes of the block being rendered.
 * @param string $content Content of the block being rendered.
 *
 * @return string The content of the block being rendered.
 */
function block_core_list_render( $attributes, $content ) {
	if ( ! $content ) {
		return $content;
	}

	$processor = new NX_HTML_Tag_Processor( $content );

	$list_tags = array( 'OL', 'UL' );
	while ( $processor->next_tag() ) {
		if ( in_array( $processor->get_tag(), $list_tags, true ) ) {
			$processor->add_class( 'nx-block-list' );
			break;
		}
	}

	return $processor->get_updated_html();
}

/**
 * Registers the `core/list` block on server.
 *
 * @since 6.6.0
 */
function register_block_core_list() {
	register_block_type_from_metadata(
		__DIR__ . '/list',
		array(
			'render_callback' => 'block_core_list_render',
		)
	);
}

add_action( 'init', 'register_block_core_list' );
