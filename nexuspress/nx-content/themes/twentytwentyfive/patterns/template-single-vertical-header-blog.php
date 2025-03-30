<?php
/**
 * Title: Right-aligned single post
 * Slug: twentytwentyfive/template-single-vertical-header-blog
 * Template Types: posts, single
 * Viewport width: 1400
 * Inserter: no
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
	<!-- nx:column {"width":"90%","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50","right":"0"}}},"layout":{"type":"default"}} -->
	<div class="nx-block-column" style="padding-top:var(--nx--preset--spacing--50);padding-right:0;padding-bottom:var(--nx--preset--spacing--50);padding-left:var(--nx--preset--spacing--50);flex-basis:90%">
		<!-- nx:group {"tagName":"main","layout":{"type":"default"}} -->
		<main class="nx-block-group">
			<!-- nx:group {"style":{"spacing":{"padding":{"right":"var:preset|spacing|50","left":"0"}}},"layout":{"type":"default"}} -->
			<div class="nx-block-group" style="padding-right:var(--nx--preset--spacing--50);padding-left:0">
				<!-- nx:spacer {"height":"var:preset|spacing|50"} -->
				<div style="height:var(--nx--preset--spacing--50)" aria-hidden="true" class="nx-block-spacer"></div>
				<!-- /nx:spacer -->
				<!-- nx:group {"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"top"}} -->
				<div class="nx-block-group">
					<!-- nx:post-title {"level":1,"style":{"layout":{"selfStretch":"fixed","flexSize":"70vw"}},"fontSize":"xx-large"} /-->
					<!-- nx:post-date {"textAlign":"right","style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"textColor":"contrast","fontSize":"small"} /-->
					</div>
				<!-- /nx:group -->

				<!-- nx:spacer {"height":"var:preset|spacing|50"} -->
				<div style="height:var(--nx--preset--spacing--50)" aria-hidden="true" class="nx-block-spacer"></div>
				<!-- /nx:spacer -->
			</div>
			<!-- /nx:group -->
			<!-- nx:post-featured-image {"aspectRatio":"16/9"} /-->
			<!-- nx:group {"style":{"spacing":{"padding":{"right":"var:preset|spacing|50"}}},"layout":{"type":"default"}} -->
			<div class="nx-block-group" style="padding-right:var(--nx--preset--spacing--50)">
				<!-- nx:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
				<div class="nx-block-group" style="padding-top:var(--nx--preset--spacing--20);padding-bottom:var(--nx--preset--spacing--20)">
					<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
					<div class="nx-block-group">
						<!-- nx:avatar {"size":30,"isLink":true,"style":{"border":{"radius":"100px"}}} /-->
						<!-- nx:post-author-name {"isLink":true,"fontSize":"small"} /-->
					</div>
					<!-- /nx:group -->
					<!-- nx:post-terms {"term":"post_tag","separator":"  ","className":"is-style-post-terms-1","style":{"typography":{"fontStyle":"normal","fontWeight":"400"}}} /-->
				</div>
				<!-- /nx:group -->

				<!-- nx:spacer {"height":"var:preset|spacing|50"} -->
				<div style="height:var(--nx--preset--spacing--50)" aria-hidden="true" class="nx-block-spacer"></div>
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

				<!-- nx:spacer {"height":"var:preset|spacing|50"} -->
				<div style="height:var(--nx--preset--spacing--50)" aria-hidden="true" class="nx-block-spacer"></div>
				<!-- /nx:spacer -->
			</div>
			<!-- /nx:group -->
			<!-- nx:group {"ariaLabel":"<?php esc_attr_e( 'Post navigation', 'twentytwentyfive' ); ?>","tagName":"nav","align":"full","style":{"border":{"top":{"color":"var:preset|color|accent-6","width":"1px"}},"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"left"}} -->
			<nav class="nx-block-group alignfull" aria-label="<?php esc_attr_e( 'Post navigation', 'twentytwentyfive' ); ?>" style="border-top-color:var(--nx--preset--color--accent-6);border-top-width:1px;padding-top:var(--nx--preset--spacing--40);padding-bottom:var(--nx--preset--spacing--40)">
				<!-- nx:post-navigation-link {"type":"previous","showTitle":true,"arrow":"arrow"} /-->
				<!-- nx:post-navigation-link {"showTitle":true,"arrow":"arrow"} /-->
			</nav>
			<!-- /nx:group -->
		</main>
		<!-- /nx:group -->
		<!-- nx:group {"tagName":"aside","align":"wide","layout":{"type":"constrained","justifyContent":"left"},"style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}}} -->
		<aside class="nx-block-group alignwide" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0">
			<!-- nx:pattern {"slug":"twentytwentyfive/comments"} /-->
		</aside>
		<!-- /nx:group -->
	</div>
	<!-- /nx:column -->
</div>
<!-- /nx:columns -->

<!-- nx:template-part {"slug":"footer"} /-->
