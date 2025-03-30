<?php
/**
 * Title: Text-only blog, posts
 * Slug: twentytwentyfive/template-query-loop-text-blog
 * Inserter: no
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:query {"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true,"taxQuery":null,"parents":[]},"align":"wide","layout":{"type":"default"}} -->
<div class="nx-block-query alignwide">
	<!-- nx:group {"layout":{"type":"constrained"}} -->
	<div class="nx-block-group">
		<!-- nx:query-no-results {"align":"wide","fontSize":"medium"} -->
			<!-- nx:paragraph -->
			<p><?php echo esc_html_x( 'Sorry, but nothing was found. Please try a search with different keywords.', 'Message explaining that there are no results returned from a search.', 'twentytwentyfive' ); ?></p>
			<!-- /nx:paragraph -->
		<!-- /nx:query-no-results -->
	</div>
	<!-- /nx:group -->
	<!-- nx:post-template {"align":"full","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"}} -->
		<!-- nx:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}},"border":{"bottom":{"color":"var:preset|color|accent-6","width":"1px"},"top":{},"right":{},"left":{}}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center","justifyContent":"space-between"}} -->
		<div class="nx-block-group alignfull" style="border-bottom-color:var(--nx--preset--color--accent-6);border-bottom-width:1px;padding-top:var(--nx--preset--spacing--30);padding-bottom:var(--nx--preset--spacing--30)">
			<!-- nx:post-title {"isLink":true,"fontSize":"large"} /-->
			<!-- nx:post-date {"textAlign":"right","isLink":true,"fontSize":"small"} /-->
		</div>
		<!-- /nx:group -->
	<!-- /nx:post-template -->

	<!-- nx:spacer {"height":"var:preset|spacing|30"} -->
	<div style="height:var(--nx--preset--spacing--30)" aria-hidden="true" class="nx-block-spacer"></div>
	<!-- /nx:spacer -->

	<!-- nx:group {"align":"full","style":{"spacing":{"margin":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
	<div class="nx-block-group alignfull" style="margin-top:var(--nx--preset--spacing--40);margin-bottom:var(--nx--preset--spacing--40);">
		<!-- nx:query-pagination {"align":"full","style":{"typography":{"fontStyle":"normal","fontWeight":"400"}},"layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
		<!-- nx:query-pagination-previous /-->
		<!-- nx:query-pagination-numbers /-->
		<!-- nx:query-pagination-next /-->
		<!-- /nx:query-pagination -->
	</div>
	<!-- /nx:group -->
</div>
<!-- /nx:query -->
