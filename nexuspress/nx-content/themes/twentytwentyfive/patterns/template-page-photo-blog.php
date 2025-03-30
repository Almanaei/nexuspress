<?php
/**
 * Title: Photo blog page
 * Slug: twentytwentyfive/template-page-photo-blog
 * Template Types: page
 * Viewport width: 1400
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:template-part {"slug":"header"} /-->

<!-- nx:group {"tagName":"main","style":{"spacing":{"margin":{"top":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<main class="nx-block-group" style="margin-top:var(--nx--preset--spacing--60)">
	<!-- nx:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
	<div class="nx-block-group alignfull" style="padding-top:var(--nx--preset--spacing--60);padding-bottom:var(--nx--preset--spacing--60)">
		<!-- nx:post-title {"textAlign":"center","level":1,"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|60"}}},"fontSize":"x-large"} /-->
		<!-- nx:post-featured-image {"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|60"}}}} /-->
		<!-- nx:post-content {"align":"full","layout":{"type":"constrained"}} /-->
	</div>
	<!-- /nx:group -->
</main>
<!-- /nx:group -->

<!-- nx:template-part {"slug":"footer"} /-->
