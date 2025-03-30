<?php
/**
 * Title: Comments
 * Slug: twentytwentyfive/comments
 * Description: Comments area with comments list, pagination, and comment form.
 * Categories: text
 * Block Types: core/comments
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:comments {"className":"nx-block-comments-query-loop","style":{"spacing":{"margin":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}}} -->
<div class="nx-block-comments nx-block-comments-query-loop" style="margin-top:var(--nx--preset--spacing--70);margin-bottom:var(--nx--preset--spacing--70)">
	<!-- nx:heading {"fontSize":"x-large"} -->
	<h2 class="nx-block-heading has-x-large-font-size"><?php esc_html_e( 'Comments', 'twentytwentyfive' ); ?></h2>
	<!-- /nx:heading -->
	<!-- nx:comments-title {"level":3,"fontSize":"large"} /-->
	<!-- nx:comment-template -->
	<!-- nx:group {"style":{"spacing":{"margin":{"top":"0","bottom":"var:preset|spacing|50"}}}} -->
	<div class="nx-block-group" style="margin-top:0;margin-bottom:var(--nx--preset--spacing--50)">
		<!-- nx:group {"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
		<div class="nx-block-group">
			<!-- nx:avatar {"size":50} /-->
			<!-- nx:group -->
			<div class="nx-block-group">
				<!-- nx:comment-date /-->
				<!-- nx:comment-author-name /-->
				<!-- nx:comment-content /-->
				<!-- nx:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
				<div class="nx-block-group">
					<!-- nx:comment-edit-link /-->
					<!-- nx:comment-reply-link /-->
				</div>
				<!-- /nx:group -->
			</div>
			<!-- /nx:group -->
		</div>
		<!-- /nx:group -->
	</div>
	<!-- /nx:group -->
	<!-- /nx:comment-template -->

	<!-- nx:comments-pagination {"layout":{"type":"flex","justifyContent":"space-between"}} -->
	<!-- nx:comments-pagination-previous /-->
	<!-- nx:comments-pagination-next /-->
	<!-- /nx:comments-pagination -->

	<!-- nx:post-comments-form /-->
</div>
<!-- /nx:comments -->
