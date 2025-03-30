<?php
/**
 * Title: Link format
 * Slug: twentytwentyfive/format-link
 * Categories: twentytwentyfive_post-format
 * Description: A link post format with a description and an emphasized link for key content.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"className":"is-style-section-3","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group is-style-section-3" style="padding-top:var(--nx--preset--spacing--40);padding-right:var(--nx--preset--spacing--40);padding-bottom:var(--nx--preset--spacing--40);padding-left:var(--nx--preset--spacing--40)">
	<!-- nx:paragraph {"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}}} -->
	<p style="font-style:normal;font-weight:700"><?php esc_html_e( 'The Stories Book, a fine collection of moments in time featuring photographs from Louis Fleckenstein, Paul Strand and Asahachi Kōno, is available for pre-order', 'twentytwentyfive' ); ?></p>
	<!-- /nx:paragraph -->

	<!-- nx:group {"fontSize":"medium","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
	<div class="nx-block-group has-medium-font-size">
		<!-- nx:paragraph -->
		<p><a href="#"><?php esc_html_e( 'https://example.com', 'twentytwentyfive' ); ?></a></p>
		<!-- /nx:paragraph -->
		</div>
	<!-- /nx:group -->
</div>
<!-- /nx:group -->
