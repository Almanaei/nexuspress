<?php
/**
 * Title: Sidebar
 * Slug: twentytwentyfive/hidden-sidebar
 * Inserter: no
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:heading {"style":{"typography":{"fontStyle":"normal","fontWeight":"600","textTransform":"uppercase","letterSpacing":"1.6px"}},"fontSize":"small"} -->
<h2 class="nx-block-heading has-small-font-size" style="font-style:normal;font-weight:600;letter-spacing:1.6px;text-transform:uppercase"><?php esc_html_e( 'Other Posts', 'twentytwentyfive' ); ?></h2>
<!-- /nx:heading -->

<!-- nx:spacer {"height":"var:preset|spacing|40"} -->
<div style="height:var(--nx--preset--spacing--40)" aria-hidden="true" class="nx-block-spacer"></div>
<!-- /nx:spacer -->

<!-- nx:query {"query":{"perPage":4,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[]}} -->
<div class="nx-block-query">
	<!-- nx:post-template -->
		<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
		<div class="nx-block-group">
			<!-- nx:post-title {"isLink":true,"fontSize":"medium"} /-->
			<!-- nx:post-date {"fontSize":"small","isLink":true} /-->
		</div>
		<!-- /nx:group -->

		<!-- nx:spacer {"height":"var:preset|spacing|20"} -->
		<div style="height:var(--nx--preset--spacing--20)" aria-hidden="true" class="nx-block-spacer"></div>
		<!-- /nx:spacer -->
	<!-- /nx:post-template -->

	<!-- nx:query-no-results -->
		<!-- nx:paragraph {"placeholder":"<?php esc_attr_e( 'Add text or blocks that will display when a query returns no results.', 'twentytwentyfive' ); ?>","fontSize":"medium"} -->
		<p class="has-medium-font-size"><?php echo esc_html_x( 'Sorry, but nothing was found. Please try a search with different keywords.', 'Message explaining that there are no results returned from a search.', 'twentytwentyfive' ); ?></p>
		<!-- /nx:paragraph -->
	<!-- /nx:query-no-results -->
</div>
<!-- /nx:query -->
