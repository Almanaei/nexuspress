<?php
/**
 * Title: List of posts, 1 column
 * Slug: twentytwentyfive/template-query-loop
 * Categories: query
 * Block Types: core/query
 * Description: A list of posts, 1 column, with featured image and post date.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:query {"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true,"taxQuery":null,"parents":[]},"align":"full","layout":{"type":"default"}} -->
<div class="nx-block-query alignfull">
	<!-- nx:post-template {"align":"full","layout":{"type":"default"}} -->
		<!-- nx:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
		<div class="nx-block-group alignfull" style="padding-top:var(--nx--preset--spacing--60);padding-bottom:var(--nx--preset--spacing--60)">
			<!-- nx:post-featured-image {"isLink":true,"aspectRatio":"3/2"} /-->
			<!-- nx:post-title {"isLink":true,"fontSize":"x-large"} /-->
			<!-- nx:post-content {"align":"full","fontSize":"medium","layout":{"type":"constrained"}} /-->
			<!-- nx:post-date {"isLink":true,"style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}},"fontSize":"small"} /-->
		</div>
		<!-- /nx:group -->
	<!-- /nx:post-template -->
	<!-- nx:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
	<div class="nx-block-group" style="padding-top:var(--nx--preset--spacing--60);padding-bottom:var(--nx--preset--spacing--60)">
		<!-- nx:query-no-results -->
		<!-- nx:paragraph -->
		<p><?php echo esc_html_x( 'Sorry, but nothing was found. Please try a search with different keywords.', 'Message explaining that there are no results returned from a search.', 'twentytwentyfive' ); ?></p>
		<!-- /nx:paragraph -->
		<!-- /nx:query-no-results -->
	</div>
	<!-- /nx:group -->
	<!-- nx:group {"align":"wide","layout":{"type":"constrained"}} -->
	<div class="nx-block-group alignwide">
		<!-- nx:query-pagination {"paginationArrow":"arrow","align":"wide","layout":{"type":"flex","justifyContent":"space-between"}} -->
			<!-- nx:query-pagination-previous /-->
			<!-- nx:query-pagination-numbers /-->
			<!-- nx:query-pagination-next /-->
		<!-- /nx:query-pagination -->
	</div>
	<!-- /nx:group -->
</div>
<!-- /nx:query -->
