<?php
/**
 * Title: Right-aligned posts
 * Slug: twentytwentyfive/template-query-loop-vertical-header-blog
 * Inserter: no
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:query {"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true,"taxQuery":null,"parents":[]}} -->
<div class="nx-block-query">
	<!-- nx:post-template -->
		<!-- nx:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
		<div class="nx-block-group">
			<!-- nx:post-title {"isLink":true,"fontSize":"xx-large"} /-->
			<!-- nx:post-date {"fontSize":"small","isLink":true} /-->
		</div>
		<!-- /nx:group -->
		<!-- nx:spacer {"height":"var:preset|spacing|40"} -->
		<div style="height:var(--nx--preset--spacing--40)" aria-hidden="true" class="nx-block-spacer"></div>
		<!-- /nx:spacer -->
		<!-- nx:columns {"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|50"}}}} -->
		<div class="nx-block-columns"><!-- nx:column {"width":"70%"} -->
		<div class="nx-block-column" style="flex-basis:70%"><!-- nx:post-excerpt {"moreText":"","showMoreOnNewLine":false} /--></div>
		<!-- /nx:column -->

		<!-- nx:column -->
		<div class="nx-block-column"></div>
		<!-- /nx:column --></div>
		<!-- /nx:columns -->
		<!-- nx:post-featured-image {"isLink":true,"aspectRatio":"16/9"} /-->
		<!-- nx:spacer {"height":"var:preset|spacing|80"} -->
		<div style="height:var(--nx--preset--spacing--80)" aria-hidden="true" class="nx-block-spacer"></div>
		<!-- /nx:spacer -->
	<!-- /nx:post-template -->
	<!-- nx:query-pagination {"layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
		<!-- nx:query-pagination-previous /-->
		<!-- nx:query-pagination-numbers /-->
		<!-- nx:query-pagination-next /-->
	<!-- /nx:query-pagination -->

	<!-- nx:query-no-results -->
		<!-- nx:paragraph -->
		<p><?php echo esc_html_x( 'Sorry, but nothing was found. Please try a search with different keywords.', 'Message explaining that there are no results returned from a search.', 'twentytwentyfive' ); ?></p>
		<!-- /nx:paragraph -->
	<!-- /nx:query-no-results -->
</div>
<!-- /nx:query -->
