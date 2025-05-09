<?php
/**
 * Block support utility functions.
 *
 * @package NexusPress
 * @subpackage Block Supports
 * @since 6.0.0
 */

/**
 * Checks whether serialization of the current block's supported properties
 * should occur.
 *
 * @since 6.0.0
 * @access private
 *
 * @param NX_Block_Type $block_type  Block type.
 * @param string        $feature_set Name of block support feature set..
 * @param string        $feature     Optional name of individual feature to check.
 *
 * @return bool Whether to serialize block support styles & classes.
 */
function nx_should_skip_block_supports_serialization( $block_type, $feature_set, $feature = null ) {
	if ( ! is_object( $block_type ) || ! $feature_set ) {
		return false;
	}

	$path               = array( $feature_set, '__experimentalSkipSerialization' );
	$skip_serialization = _nx_array_get( $block_type->supports, $path, false );

	if ( is_array( $skip_serialization ) ) {
		return in_array( $feature, $skip_serialization, true );
	}

	return $skip_serialization;
}
