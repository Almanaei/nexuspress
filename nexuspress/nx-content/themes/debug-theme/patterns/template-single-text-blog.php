<?php
/**
 * Title: Text-only blog, single post
 * Slug: twentytwentyfive/template-single-text-blog
 * Template Types: posts, single
 * Viewport width: 1400
 * Inserter: no
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:template-part {"slug":"header"} /-->

<!-- nx:group {"tagName":"main","style":{"spacing":{"margin":{"top":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<main class="nx-block-group" style="margin-top:var(--nx--preset--spacing--60)">
	<!-- nx:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
	<div class="nx-block-group alignfull" style="padding-top:var(--nx--preset--spacing--60);">
		<!-- nx:post-title {"level":1} /-->
		<!-- nx:post-terms {"term":"category","style":{"typography":{"fontStyle":"normal","fontWeight":"400"}}} /-->
		<!-- nx:spacer {"height":"var:preset|spacing|50"} -->
		<div style="height:var(--nx--preset--spacing--50)" aria-hidden="true" class="nx-block-spacer"></div>
		<!-- /nx:spacer -->
		<!-- nx:post-content {"align":"full","layout":{"type":"constrained"}} /-->

		<!-- nx:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
		<div class="nx-block-group" style="padding-top:var(--nx--preset--spacing--60);padding-bottom:var(--nx--preset--spacing--60)">
		<!-- nx:post-terms {"term":"post_tag","separator":"  ","className":"is-style-post-terms-1"} /-->
		</div>
		<!-- /nx:group -->

		<!-- nx:group {"align":"full","style":{"spacing":{"padding":{"right":"var:preset|spacing|50","left":"var:preset|spacing|50"},"margin":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
		<div class="nx-block-group alignfull" style="margin-top:var(--nx--preset--spacing--60);margin-bottom:var(--nx--preset--spacing--60);padding-right:var(--nx--preset--spacing--50);padding-left:var(--nx--preset--spacing--50)">
			<!-- nx:group {"ariaLabel":"<?php esc_attr_e( 'Post navigation', 'twentytwentyfive' ); ?>","tagName":"nav","align":"wide","style":{"border":{"top":{"color":"var:preset|color|accent-6","width":"1px"},"right":[],"bottom":[],"left":[]},"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
			<nav class="nx-block-group alignwide" aria-label="<?php esc_attr_e( 'Post navigation', 'twentytwentyfive' ); ?>" style="border-top-color:var(--nx--preset--color--accent-6);border-top-width:1px;padding-top:var(--nx--preset--spacing--40);padding-bottom:var(--nx--preset--spacing--40)">
				<!-- nx:post-navigation-link {"type":"previous","showTitle":true,"arrow":"arrow"} /-->
				<!-- nx:post-navigation-link {"showTitle":true,"arrow":"arrow"} /-->
			</nav>
			<!-- /nx:group -->
		</div>
		<!-- /nx:group -->
		<!-- nx:pattern {"slug":"twentytwentyfive/comments"} /-->
	</div>
	<!-- /nx:group -->
</main>
<!-- /nx:group -->
<!-- nx:template-part {"slug":"footer"} /-->
