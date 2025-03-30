<?php
/**
 * Title: More posts
 * Slug: twentytwentyfive/more-posts
 * Description: Displays a list of posts with title and date.
 * Categories: query
 * Block Types: core/query
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group alignwide" style="padding-top:var(--nx--preset--spacing--60);padding-bottom:var(--nx--preset--spacing--60)">
	<!-- nx:heading {"align":"wide","style":{"typography":{"textTransform":"uppercase","fontStyle":"normal","fontWeight":"700","letterSpacing":"1.4px"}},"fontSize":"small"} -->
	<h2 class="nx-block-heading alignwide has-small-font-size" style="font-style:normal;font-weight:700;letter-spacing:1.4px;text-transform:uppercase"><?php esc_html_e( 'More posts', 'twentytwentyfive' ); ?></h2>
	<!-- /nx:heading -->

	<!-- nx:query {"query":{"perPage":4,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[]},"align":"wide","layout":{"type":"default"}} -->
	<div class="nx-block-query alignwide">
		<!-- nx:post-template {"align":"full","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"}} -->
			<!-- nx:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}},"border":{"bottom":{"color":"var:preset|color|accent-6","width":"1px"},"top":[],"right":[],"left":[]}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center","justifyContent":"space-between"}} -->
			<div class="nx-block-group alignfull" style="border-bottom-color:var(--nx--preset--color--accent-6);border-bottom-width:1px;padding-top:var(--nx--preset--spacing--30);padding-bottom:var(--nx--preset--spacing--30)">
				<!-- nx:post-title {"level":3,"isLink":true,"fontSize":"large"} /-->
				<!-- nx:post-date {"textAlign":"right","isLink":true} /-->
			</div>
			<!-- /nx:group -->
		<!-- /nx:post-template -->
	</div>
	<!-- /nx:query -->
</div>
<!-- /nx:group -->
