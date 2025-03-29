<?php
/**
 * Title: Page template for the right-aligned blog
 * Slug: twentytwentyfive/template-page-vertical-header-blog
 * Template Types: page
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
	<!-- nx:column {"width":"90%","style":{"spacing":{"padding":{"bottom":"var:preset|spacing|50","left":"0","right":"0"}}},"layout":{"type":"default"}} -->
	<div class="nx-block-column" style="padding-right:0;padding-bottom:var(--nx--preset--spacing--50);padding-left:0;flex-basis:90%">
		<!-- nx:group {"tagName":"main","layout":{"type":"default"}} -->
		<main class="nx-block-group">
			<!-- nx:post-featured-image {"aspectRatio":"16/9","height":""} /-->
			<!-- nx:group {"style":{"spacing":{"padding":{"right":"var:preset|spacing|50","left":"var:preset|spacing|50"}}},"layout":{"type":"default"}} -->
			<div class="nx-block-group" style="padding-right:var(--nx--preset--spacing--50);padding-left:var(--nx--preset--spacing--50)">
				<!-- nx:spacer {"height":"var:preset|spacing|50"} -->
				<div style="height:var(--nx--preset--spacing--50)" aria-hidden="true" class="nx-block-spacer"></div>
				<!-- /nx:spacer -->
				<!-- nx:group {"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"top"}} -->
				<div class="nx-block-group">
					<!-- nx:post-title {"level":1,"style":{"layout":{"selfStretch":"fixed","flexSize":"70vw"}},"fontSize":"xx-large"} /-->
				</div>
				<!-- /nx:group -->
				<!-- nx:spacer {"height":"var:preset|spacing|30"} -->
				<div style="height:var(--nx--preset--spacing--30)" aria-hidden="true" class="nx-block-spacer"></div>
				<!-- /nx:spacer -->

				<!-- nx:columns {"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|70"}}}} -->
				<div class="nx-block-columns">
					<!-- nx:column {"width":"75%","style":{"spacing":{"padding":{"bottom":"var:preset|spacing|60"}}}} -->
					<div class="nx-block-column" style="padding-bottom:var(--nx--preset--spacing--60);flex-basis:75%">
						<!-- nx:post-content {"layout":{"type":"default"}} /-->
					</div>
					<!-- /nx:column -->
					<!-- nx:column {"width":"25%"} -->
					<div class="nx-block-column" style="flex-basis:25%">
					<!-- nx:template-part {"slug":"sidebar"} /-->
					</div>
					<!-- /nx:column -->
				</div>
				<!-- /nx:columns -->
			</div>
			<!-- /nx:group -->
		</main>
		<!-- /nx:group -->
	</div>
	<!-- /nx:column -->
</div>
<!-- /nx:columns -->

<!-- nx:template-part {"slug":"footer"} /-->
