<?php
/**
 * Title: Post navigation
 * Slug: twentytwentyfive/post-navigation
 * Categories: text
 * Description: Next and previous post links.
 * Block Types: core/post-navigation-link
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"align":"wide","style":{"spacing":{"margin":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"default"}} -->
<div class="nx-block-group alignwide" style="margin-top:var(--nx--preset--spacing--60);margin-bottom:var(--nx--preset--spacing--60);">
	<!-- nx:group {"ariaLabel":"<?php esc_attr_e( 'Post navigation', 'twentytwentyfive' ); ?>","tagName":"nav","align":"wide","style":{"border":{"top":{"color":"var:preset|color|accent-6","width":"1px"}},"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
	<nav class="nx-block-group alignwide" aria-label="<?php esc_attr_e( 'Post navigation', 'twentytwentyfive' ); ?>" style="border-top-color:var(--nx--preset--color--accent-6);border-top-width:1px;padding-top:var(--nx--preset--spacing--40);padding-bottom:var(--nx--preset--spacing--40)">
		<!-- nx:post-navigation-link {"type":"previous","showTitle":true,"arrow":"arrow"} /-->
		<!-- nx:post-navigation-link {"showTitle":true,"arrow":"arrow"} /-->
	</nav>
	<!-- /nx:group -->
</div>
<!-- /nx:group -->
