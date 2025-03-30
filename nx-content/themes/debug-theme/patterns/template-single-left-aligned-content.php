<?php
/**
 * Title: Post with left-aligned content
 * Slug: twentytwentyfive/post-with-left-aligned-content
 * Template Types: posts, single
 * Viewport width: 1400
 * Inserter: no
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:template-part {"slug":"header-large-title"} /-->

	<!-- nx:group {"tagName":"main","align":"wide","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"}} -->
	<main class="nx-block-group alignwide">
		<!-- nx:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
		<div class="nx-block-group" style="padding-top:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50)">
			<!-- nx:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|50"}}}} -->
			<div class="nx-block-columns alignwide">
				<!-- nx:column {"width":"40%"} -->
				<div class="nx-block-column" style="flex-basis:40%">
					<!-- nx:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
					<div class="nx-block-group alignwide">
						<!-- nx:post-title {"level":1,"align":"wide","fontSize":"x-large"} /-->
						<!-- nx:group {"style":{"spacing":{"blockGap":"4px"}},"fontSize":"small","layout":{"type":"flex","flexWrap":"nowrap"}} -->
						<div class="nx-block-group has-small-font-size">
							<!-- nx:paragraph -->
							<p><?php echo esc_html_x( 'by', 'Prefix before the author name. The post author name is displayed in a separate block.', 'twentytwentyfive' ); ?></p>
							<!-- /nx:paragraph -->
							<!-- nx:post-author-name {"isLink":true,"fontSize":"small"} /-->
						</div>
						<!-- /nx:group -->
					</div>
					<!-- /nx:group -->
				</div>
				<!-- /nx:column -->
				<!-- nx:column {"width":"60%"} -->
				<div class="nx-block-column" style="flex-basis:60%">
					<!-- nx:post-featured-image /-->
				</div>
				<!-- /nx:column -->
			</div>
			<!-- /nx:columns -->

			<!-- nx:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|50"}}}} -->
			<div class="nx-block-columns alignwide">
				<!-- nx:column {"width":"100%"} -->
				<div class="nx-block-column" style="flex-basis:100%">
					<!-- nx:group {"align":"wide","style":{"spacing":{"blockGap":"4px"}},"fontSize":"small","layout":{"type":"flex","flexWrap":"nowrap"}} -->
					<div class="nx-block-group alignwide has-small-font-size">
						<!-- nx:post-date /-->
						<!-- nx:paragraph -->
						<p><?php echo esc_html_x( '·', 'Separator between date and categories.', 'twentytwentyfive' ); ?></p>
						<!-- /nx:paragraph -->
						<!-- nx:post-terms {"term":"category"} /-->
					</div>
					<!-- /nx:group -->
				</div>
				<!-- /nx:column -->
			</div>
			<!-- /nx:columns -->
		</div>
		<!-- /nx:group -->

		<!-- nx:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
		<div class="nx-block-group" style="padding-top:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50)">
			<!-- nx:post-content {"align":"wide","layout":{"type":"constrained","justifyContent":"left","contentSize":"800px"}} /-->
		</div>
		<!-- /nx:group -->

		<!-- nx:group {"align":"wide","style":{"spacing":{"margin":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"default"}} -->
		<div class="nx-block-group alignwide" style="margin-top:var(--nx--preset--spacing--60);margin-bottom:var(--nx--preset--spacing--60)">
			<!-- nx:group {"align":"wide","style":{"border":{"top":{"color":"var:preset|color|accent-6","width":"1px"},"right":[],"bottom":[],"left":[]}},"layout":{"type":"constrained"}} -->
			<div class="nx-block-group alignwide" style="border-top-color:var(--nx--preset--color--accent-6);border-top-width:1px">
				<!-- nx:group {"ariaLabel":"<?php esc_attr_e( 'Post navigation', 'twentytwentyfive' ); ?>","tagName":"nav","align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
				<nav class="nx-block-group alignwide" aria-label="<?php esc_attr_e( 'Post navigation', 'twentytwentyfive' ); ?>" style="padding-top:var(--nx--preset--spacing--40);padding-bottom:var(--nx--preset--spacing--40)">
					<!-- nx:post-navigation-link {"type":"previous","showTitle":true,"arrow":"arrow"} /-->
					<!-- nx:post-navigation-link {"showTitle":true,"arrow":"arrow"} /-->
				</nav>
				<!-- /nx:group -->
			</div>
			<!-- /nx:group -->
		</div>
		<!-- /nx:group -->

		<!-- nx:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
		<div class="nx-block-group" style="padding-top:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50)">
			<!-- nx:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|50"}}}} -->
			<div class="nx-block-columns alignwide">
				<!-- nx:column {"width":"40%"} -->
				<div class="nx-block-column" style="flex-basis:40%">
					<!-- nx:spacer {"height":"var:preset|spacing|20"} -->
					<div style="height:var(--nx--preset--spacing--20)" aria-hidden="true" class="nx-block-spacer"></div>
					<!-- /nx:spacer -->
				</div>
				<!-- /nx:column -->
				<!-- nx:column {"width":"60%","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}}} -->
				<div class="nx-block-column" style="padding-top:0;padding-bottom:0;flex-basis:60%">
					<!-- nx:pattern {"slug":"twentytwentyfive/comments"} /-->
				</div>
				<!-- /nx:column -->
			</div>
			<!-- /nx:columns -->
		</div>
		<!-- /nx:group -->
	</main>
	<!-- /nx:group -->

<!-- nx:template-part {"slug":"footer-columns"} /-->
