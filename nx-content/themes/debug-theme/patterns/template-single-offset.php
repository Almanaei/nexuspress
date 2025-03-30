<?php
/**
 * Title: Offset post without featured image
 * Slug: twentytwentyfive/template-single-offset
 * Template Types: posts, single
 * Viewport width: 1400
 * Inserter: no
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:template-part {"slug":"header"} /-->

<!-- nx:group {"tagName":"main","align":"wide","layout":{"type":"default"}} -->
<main class="nx-block-group alignwide">
	<!-- nx:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|40"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
	<div class="nx-block-group" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--80);padding-bottom:var(--nx--preset--spacing--40)">
		<!-- nx:group {"align":"wide","style":{"spacing":{"padding":{"bottom":"var:preset|spacing|50"}},"border":{"bottom":{"color":"var:preset|color|accent-6","width":"1px"},"top":[],"right":[],"left":[]}},"layout":{"type":"default"}} -->
		<div class="nx-block-group alignwide" style="border-bottom-color:var(--nx--preset--color--accent-6);border-bottom-width:1px;padding-bottom:var(--nx--preset--spacing--50)">
			<!-- nx:post-title {"level":1,"align":"wide","fontSize":"xx-large"} /-->
			<!-- nx:post-terms {"term":"category","style":{"typography":{"textTransform":"uppercase","letterSpacing":"1.4px"}}} /-->
		</div>
		<!-- /nx:group -->
	</div>
	<!-- /nx:group -->

	<!-- nx:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|50"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
	<div class="nx-block-group" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--30);padding-bottom:var(--nx--preset--spacing--50)">
		<!-- nx:group {"align":"wide","layout":{"type":"default"}} -->
		<div class="nx-block-group alignwide">
			<!-- nx:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|50","left":"var:preset|spacing|50"}}}} -->
			<div class="nx-block-columns">
				<!-- nx:column {"width":"30%"} -->
				<div class="nx-block-column" style="flex-basis:30%">
					<!-- nx:group {"style":{"spacing":{"blockGap":"4px"}},"fontSize":"small","layout":{"type":"flex","flexWrap":"nowrap"}} -->
					<div class="nx-block-group has-small-font-size">
						<!-- nx:paragraph --><p><?php echo esc_html_x( 'Published on', 'Prefix before the post date block.', 'twentytwentyfive' ); ?></p><!-- /nx:paragraph -->
						<!-- nx:post-date {"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"textColor":"contrast"} /-->
					</div>
					<!-- /nx:group -->
				</div>
				<!-- /nx:column -->

				<!-- nx:column {"width":"70%"} -->
				<div class="nx-block-column" style="flex-basis:70%">
					<!-- nx:post-content {"layout":{"type":"default"}} /-->
				</div>
				<!-- /nx:column -->
			</div>
			<!-- /nx:columns -->
		</div>
		<!-- /nx:group -->
	</div>
	<!-- /nx:group -->

	<!-- nx:group {"align":"wide","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
	<div class="nx-block-group alignwide" style="margin-top:0;margin-bottom:0">
		<!-- nx:group {"ariaLabel":"<?php esc_attr_e( 'Post navigation', 'twentytwentyfive' ); ?>","tagName":"nav","align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}},"border":{"top":{"color":"var:preset|color|accent-6","width":"1px"},"right":{},"bottom":{},"left":{}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
		<nav class="nx-block-group alignwide" aria-label="<?php esc_attr_e( 'Post navigation', 'twentytwentyfive' ); ?>" style="border-top-color:var(--nx--preset--color--accent-6);border-top-width:1px;padding-top:var(--nx--preset--spacing--40);padding-bottom:var(--nx--preset--spacing--40)">
			<!-- nx:post-navigation-link {"type":"previous","showTitle":true,"arrow":"arrow"} /-->
			<!-- nx:post-navigation-link {"showTitle":true,"arrow":"arrow"} /-->
		</nav>
		<!-- /nx:group -->
	</div>
	<!-- /nx:group -->

	<!-- nx:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
	<div class="nx-block-group" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50)">
		<!-- nx:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|50"}}}} -->
		<div class="nx-block-columns alignwide">
			<!-- nx:column {"width":"30%"} -->
			<div class="nx-block-column" style="flex-basis:30%">
				<!-- nx:spacer {"height":"var:preset|spacing|20"} -->
				<div style="height:var(--nx--preset--spacing--20)" aria-hidden="true" class="nx-block-spacer"></div>
				<!-- /nx:spacer -->
			</div>
			<!-- /nx:column -->
			<!-- nx:column {"width":"70%","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}}} -->
			<div class="nx-block-column" style="padding-top:0;padding-bottom:0;flex-basis:70%">
				<!-- nx:pattern {"slug":"twentytwentyfive/comments"} /-->
			</div>
			<!-- /nx:column -->
		</div>
		<!-- /nx:columns -->
	</div>
	<!-- /nx:group -->
</main>
<!-- /nx:group -->

<!-- nx:template-part {"slug":"footer"} /-->
