<?php
/**
 * Title: Right-aligned blog, 404
 * Slug: twentytwentyfive/template-404-vertical-header-blog
 * Template Types: 404
 * Viewport width: 1400
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:columns {"isStackedOnMobile":false,"style":{"spacing":{"padding":{"right":"0","left":"0","top":"0","bottom":"0"},"blockGap":{"left":"0"}}}} -->
<div class="nx-block-columns is-not-stacked-on-mobile" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0">
	<!-- nx:column {"width":"8rem"} -->
	<div class="nx-block-column" style="flex-basis:8rem">
		<!-- nx:template-part {"slug":"vertical-header"} /-->
	</div>
	<!-- /nx:column -->
	<!-- nx:column {"width":"90%","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}}},"layout":{"type":"default"}} -->
	<div class="nx-block-column" style="padding-top:var(--nx--preset--spacing--50);padding-right:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50);padding-left:var(--nx--preset--spacing--50);flex-basis:90%">
		<!-- nx:group {"tagName":"main","layout":{"type":"default"}} -->
		<main class="nx-block-group">
			<!-- nx:spacer {"height":"var:preset|spacing|50"} -->
			<div style="height:var(--nx--preset--spacing--50)" aria-hidden="true" class="nx-block-spacer"></div>
			<!-- /nx:spacer -->

			<!-- nx:pattern {"slug":"twentytwentyfive/hidden-404"} /-->

			<!-- nx:spacer {"height":"var:preset|spacing|50"} -->
			<div style="height:var(--nx--preset--spacing--50)" aria-hidden="true" class="nx-block-spacer"></div>
			<!-- /nx:spacer -->
		</main>
		<!-- /nx:group -->
	</div>
	<!-- /nx:column -->
</div>
<!-- /nx:columns -->

<!-- nx:template-part {"slug":"footer"} /-->
