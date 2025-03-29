<?php
/**
 * Title: News blog query loop
 * Slug: twentytwentyfive/template-query-loop-news-blog
 * Inserter: no
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:query {"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true,"taxQuery":null,"parents":[]}} -->
<div class="nx-block-query"><!-- nx:post-template -->
<!-- nx:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|50","left":"var:preset|spacing|50"},"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}},"border":{"top":{"color":"var:preset|color|accent-6","width":"1px"}}}} -->
<div class="nx-block-columns" style="border-top-color:var(--nx--preset--color--accent-6);border-top-width:1px;padding-top:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50)"><!-- nx:column {"width":"20%"} -->
<div class="nx-block-column" style="flex-basis:20%"><!-- nx:post-date {"isLink":true} /--></div>
<!-- /nx:column -->

<!-- nx:column -->
<div class="nx-block-column"><!-- nx:post-title /-->

<!-- nx:post-terms {"term":"category","style":{"typography":{"textTransform":"uppercase","letterSpacing":"1.4px"}}} /-->

<!-- nx:post-excerpt {"showMoreOnNewLine":false,"fontSize":"medium"} /-->

<!-- nx:group {"style":{"spacing":{"blockGap":"0.12em"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="nx-block-group">
	<!-- nx:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-4"}}}},"textColor":"accent-4","fontSize":"small"} -->
	<p class="has-accent-4-color has-text-color has-link-color has-small-font-size"><?php echo esc_html_x( 'Written by', 'Prefix before the author name. The post author name is displayed in a separate block.', 'twentytwentyfive' ); ?></p>
	<!-- /nx:paragraph -->
	<!-- nx:post-author-name {"isLink":true,"fontSize":"small"} /-->
</div>
<!-- /nx:group --></div>
<!-- /nx:column -->

<!-- nx:column {"width":"20%"} -->
<div class="nx-block-column" style="flex-basis:20%"><!-- nx:post-featured-image {"aspectRatio":"1"} /--></div>
<!-- /nx:column --></div>
<!-- /nx:columns -->
<!-- /nx:post-template -->

<!-- nx:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}},"layout":{"type":"default"}} -->
<div class="nx-block-group" style="padding-top:var(--nx--preset--spacing--40);padding-bottom:var(--nx--preset--spacing--40)"><!-- nx:query-pagination {"paginationArrow":"arrow","layout":{"type":"flex","justifyContent":"space-between"}} -->
<!-- nx:query-pagination-previous {"label":"<?php esc_html_e( 'Newer Posts', 'twentytwentyfive' ); ?>"} /-->

<!-- nx:query-pagination-numbers /-->

<!-- nx:query-pagination-next {"label":"<?php esc_html_e( 'Older Posts', 'twentytwentyfive' ); ?>"} /-->
<!-- /nx:query-pagination --></div>
<!-- /nx:group -->

<!-- nx:query-no-results -->
<!-- nx:paragraph -->
<p><?php echo esc_html_x( 'Sorry, but nothing was found. Please try a search with different keywords.', 'Message explaining that there are no results returned from a search.', 'twentytwentyfive' ); ?></p>
<!-- /nx:paragraph -->
<!-- /nx:query-no-results -->

<!-- nx:spacer {"height":"var:preset|spacing|70"} -->
<div style="height:var(--nx--preset--spacing--70)" aria-hidden="true" class="nx-block-spacer"></div>
<!-- /nx:spacer --></div>
<!-- /nx:query -->
