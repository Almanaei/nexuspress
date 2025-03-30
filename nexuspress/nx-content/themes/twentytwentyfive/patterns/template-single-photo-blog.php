<?php
/**
 * Title: Photo blog single post
 * Slug: twentytwentyfive/template-single-photo-blog
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

<!-- nx:group {"tagName":"main","style":{"spacing":{"margin":{"top":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<main class="nx-block-group" style="margin-top:var(--nx--preset--spacing--60)">
	<!-- nx:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
	<div class="nx-block-group alignwide" style="padding-top:var(--nx--preset--spacing--60);padding-bottom:var(--nx--preset--spacing--60)">
		<!-- nx:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|60"}}}} -->
		<div class="nx-block-columns alignwide">
			<!-- nx:column {"width":"60%"} -->
			<div class="nx-block-column" style="flex-basis:60%">
				<!-- nx:post-title {"level":1} /-->
				</div>
			<!-- /nx:column -->
			<!-- nx:column {"width":"40%"} -->
			<div class="nx-block-column" style="flex-basis:40%">
				<!-- nx:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"top"}} -->
				<div class="nx-block-group">
					<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","orientation":"vertical"}} -->
					<div class="nx-block-group">
						<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"fontSize":"small","layout":{"type":"constrained"}} -->
						<div class="nx-block-group has-small-font-size">
							<!-- nx:paragraph --><p><?php echo esc_html_x( 'Published on', 'Prefix before the post date block.', 'twentytwentyfive' ); ?></p><!-- /nx:paragraph -->
							<!-- nx:post-date {"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"textColor":"contrast"} /-->
						</div>
						<!-- /nx:group -->
						<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"fontSize":"small","layout":{"type":"constrained"}} -->
						<div class="nx-block-group has-small-font-size">
							<!-- nx:paragraph --><p><?php echo esc_html_x( 'Posted by', 'Prefix before the author name. The post author name is displayed in a separate block on the next line.', 'twentytwentyfive' ); ?></p><!-- /nx:paragraph -->
							<!-- nx:post-author-name {"isLink":true} /-->
						</div>
						<!-- /nx:group -->
					</div>
					<!-- /nx:group -->
					<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","orientation":"vertical"}} -->
					<div class="nx-block-group">
						<!-- nx:group {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"constrained"}} -->
						<div class="nx-block-group">
							<!-- nx:paragraph {"fontSize":"small"} -->
							<p class="has-small-font-size"><?php echo esc_html_x( 'Categories:', 'Prefix before one or more categories. The categories are displayed in a separate block on the next line.', 'twentytwentyfive' ); ?></p>
							<!-- /nx:paragraph -->
							<!-- nx:post-terms {"term":"category","style":{"typography":{"fontStyle":"normal","fontWeight":"300"}}} /-->
						</div>
						<!-- /nx:group -->
						<!-- nx:group {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"constrained"}} -->
						<div class="nx-block-group">
							<!-- nx:paragraph {"fontSize":"small"} -->
							<p class="has-small-font-size"><?php echo esc_html_x( 'Tagged:', 'Prefix before one or more tags. The tags are displayed in a separate block on the next line.', 'twentytwentyfive' ); ?></p>
							<!-- /nx:paragraph -->
							<!-- nx:post-terms {"term":"post_tag","style":{"typography":{"fontStyle":"normal","fontWeight":"300"}}} /-->
						</div>
					<!-- /nx:group -->
					</div>
				<!-- /nx:group -->
				</div>
				<!-- /nx:group -->
			</div>
			<!-- /nx:column -->
		</div>
		<!-- /nx:columns -->
		<!-- nx:group {"align":"wide","style":{"spacing":{"margin":{"top":"var:preset|spacing|50","bottom":"0"}}},"layout":{"type":"default"}} -->
		<div class="nx-block-group alignwide" style="margin-top:var(--nx--preset--spacing--50);margin-bottom:0">
			<!-- nx:group {"ariaLabel":"<?php esc_attr_e( 'Post navigation', 'twentytwentyfive' ); ?>","tagName":"nav","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
			<nav aria-label="<?php esc_attr_e( 'Post navigation', 'twentytwentyfive' ); ?>" class="nx-block-group" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--40);padding-bottom:var(--nx--preset--spacing--40)">
				<!-- nx:post-navigation-link {"type":"previous","label":"<?php esc_html_e( 'Previous Photo', 'twentytwentyfive' ); ?>","fontSize":"small"} /-->
				<!-- nx:post-navigation-link {"label":"<?php esc_html_e( 'Next Photo', 'twentytwentyfive' ); ?>","fontSize":"small"} /-->
			</nav>
			<!-- /nx:group -->
		</div>
		<!-- /nx:group -->
		<!-- nx:post-featured-image {"aspectRatio":"auto","align":"wide"} /-->
		</div>
	<!-- /nx:group -->

	<!-- nx:post-content {"align":"wide","layout":{"type":"constrained","justifyContent":"left"}} /-->

	<!-- nx:group {"align":"wide","layout":{"type":"constrained","justifyContent":"left"}} -->
	<div class="nx-block-group alignwide">
		<!-- nx:pattern {"slug":"twentytwentyfive/comments"} /-->
	</div>
	<!-- /nx:group -->
</main>
<!-- /nx:group -->
<!-- nx:template-part {"slug":"footer"} /-->
