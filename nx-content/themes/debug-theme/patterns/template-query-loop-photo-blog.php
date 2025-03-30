<?php
/**
 * Title: Photo blog posts
 * Slug: twentytwentyfive/template-query-loop-photo-blog
 * Categories: query
 * Block Types: core/query
 * Viewport width: 1400
 * Description: A list of posts, 3 columns, with only featured images.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:query {"query":{"perPage":9,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true,"taxQuery":null,"parents":[]},"align":"wide","layout":{"type":"default"}} -->
<div class="nx-block-query alignwide">
		<!-- nx:group {"layout":{"type":"constrained"}} -->
		<div class="nx-block-group">
		<!-- nx:query-no-results -->
		<!-- nx:paragraph {"align":"center"} -->
		<p class="has-text-align-center"><?php echo esc_html_x( 'Sorry, but nothing was found. Please try a search with different keywords.', 'Message explaining that there are no results returned from a search.', 'twentytwentyfive' ); ?></p>
		<!-- /nx:paragraph -->
		<!-- /nx:query-no-results -->
	</div>
	<!-- /nx:group -->

	<!-- nx:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"default"}} -->
	<div class="nx-block-group" style="padding-top:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50);">
		<!-- nx:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"grid","columnCount":null,"minimumColumnWidth":"23rem"}} -->
			<!-- nx:post-featured-image {"isLink":true,"aspectRatio":"1"} /-->
		<!-- /nx:post-template -->
	</div>
	<!-- /nx:group -->

	<!-- nx:group {"layout":{"type":"default"}} -->
	<div class="nx-block-group">
		<!-- nx:query-pagination {"paginationArrow":"arrow","align":"full","layout":{"type":"flex","justifyContent":"space-between"}} -->
		<!-- nx:query-pagination-previous /-->
		<!-- nx:query-pagination-numbers /-->
		<!-- nx:query-pagination-next /-->
		<!-- /nx:query-pagination -->
	</div>
	<!-- /nx:group -->
</div>
<!-- /nx:query -->
