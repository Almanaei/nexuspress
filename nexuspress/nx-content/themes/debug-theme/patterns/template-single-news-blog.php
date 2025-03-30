<?php
/**
 * Title: News blog single post with sidebar
 * Slug: twentytwentyfive/template-single-news-blog
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

<!-- nx:group {"tagName":"main","layout":{"type":"constrained"}} -->
<main class="nx-block-group">

	<!-- nx:group {"align":"wide","layout":{"type":"constrained"}} -->
	<div class="nx-block-group alignwide">
		<!-- nx:group {"align":"wide","layout":{"type":"default"}} -->
		<div class="nx-block-group alignwide">
			<!-- nx:spacer {"height":"var:preset|spacing|80"} -->
			<div style="height:var(--nx--preset--spacing--80)" aria-hidden="true" class="nx-block-spacer"></div>
			<!-- /nx:spacer -->
			<!-- nx:post-title {"level":1,"align":"wide","fontSize":"xx-large"} /-->
			<!-- nx:spacer {"height":"var:preset|spacing|40"} -->
			<div style="height:var(--nx--preset--spacing--40)" aria-hidden="true" class="nx-block-spacer"></div>
			<!-- /nx:spacer -->
			<!-- nx:group {"layout":{"type":"default"}} -->
			<div class="nx-block-group">
				<!-- nx:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
				<div class="nx-block-group" style="padding-top:var(--nx--preset--spacing--20);padding-bottom:var(--nx--preset--spacing--20)">
					<!-- nx:group {"style":{"spacing":{"blockGap":"4px"}},"fontSize":"small","layout":{"type":"flex","flexWrap":"nowrap"}} -->
					<div class="nx-block-group has-small-font-size">
						<!-- nx:post-date /-->
						<!-- nx:paragraph -->
						<p><?php echo esc_html_x( '·', 'Separator between date and categories.', 'twentytwentyfive' ); ?></p>
						<!-- /nx:paragraph -->
						<!-- nx:post-terms {"term":"category","style":{"typography":{"textTransform":"uppercase","letterSpacing":"1.4px"}}} /-->
					</div>
					<!-- /nx:group -->
					<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
					<div class="nx-block-group">
						<!-- nx:avatar {"size":30,"isLink":true,"style":{"border":{"radius":"100px"}}} /-->
						<!-- nx:post-author-name {"isLink":true,"fontSize":"small"} /-->
					</div>
					<!-- /nx:group -->
				</div>
				<!-- /nx:group -->
			</div>
			<!-- /nx:group -->
		</div>
		<!-- /nx:group -->
	</div>
	<!-- /nx:group -->

	<!-- nx:group {"align":"wide","layout":{"type":"constrained"}} -->
	<div class="nx-block-group alignwide"><!-- nx:post-featured-image {"align":"wide"} /--></div>
	<!-- /nx:group -->

	<!-- nx:group {"align":"wide","layout":{"type":"constrained"}} -->
	<div class="nx-block-group alignwide">
		<!-- nx:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|40"},"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}}} -->
		<div class="nx-block-columns alignwide" style="padding-top:var(--nx--preset--spacing--60);padding-bottom:var(--nx--preset--spacing--60)">
			<!-- nx:column {"width":"5%"} -->
			<div class="nx-block-column" style="flex-basis:5%"></div>
			<!-- /nx:column -->
			<!-- nx:column {"width":"65%","style":{"spacing":{"padding":{"bottom":"var:preset|spacing|60"}}}} -->
			<div class="nx-block-column" style="padding-bottom:var(--nx--preset--spacing--60);flex-basis:65%">
				<!-- nx:post-content {"layout":{"type":"default"}} /-->
				<!-- nx:spacer {"height":"var:preset|spacing|40"} -->
				<div style="height:var(--nx--preset--spacing--40)" aria-hidden="true" class="nx-block-spacer"></div>
				<!-- /nx:spacer -->
				<!-- nx:post-terms {"term":"post_tag","separator":"  ","className":"is-style-post-terms-1","style":{"typography":{"fontStyle":"normal","fontWeight":"400"}}} /-->
			</div>
			<!-- /nx:column -->
			<!-- nx:column {"width":"5%"} -->
			<div class="nx-block-column" style="flex-basis:5%"></div>
			<!-- /nx:column -->
			<!-- nx:column {"width":"25%"} -->
			<div class="nx-block-column" style="flex-basis:25%"><!-- nx:template-part {"slug":"sidebar"} /--></div>
			<!-- /nx:column -->
			<!-- nx:column {"width":"5%"} -->
			<div class="nx-block-column" style="flex-basis:5%"></div>
			<!-- /nx:column -->
		</div>
		<!-- /nx:columns -->
	</div>
	<!-- /nx:group -->

	<!-- nx:group {"align":"wide","style":{"spacing":{"margin":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
	<div class="nx-block-group alignwide" style="margin-top:var(--nx--preset--spacing--60);margin-bottom:var(--nx--preset--spacing--60)">
		<!-- nx:group {"ariaLabel":"<?php esc_attr_e( 'Post navigation', 'twentytwentyfive' ); ?>","tagName":"nav","align":"wide","style":{"border":{"top":{"color":"var:preset|color|accent-6","width":"1px"}},"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
		<nav class="nx-block-group alignwide" aria-label="<?php esc_attr_e( 'Post navigation', 'twentytwentyfive' ); ?>" style="border-top-color:var(--nx--preset--color--accent-6);border-top-width:1px;padding-top:var(--nx--preset--spacing--40);padding-bottom:var(--nx--preset--spacing--40)">
			<!-- nx:post-navigation-link {"type":"previous","showTitle":true,"arrow":"arrow"} /-->
			<!-- nx:post-navigation-link {"showTitle":true,"arrow":"arrow"} /-->
		</nav>
		<!-- /nx:group -->
	</div>
	<!-- /nx:group -->

	<!-- nx:group {"align":"wide","layout":{"type":"constrained","justifyContent":"center"}} -->
	<div class="nx-block-group alignwide">
		<!-- nx:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|40"},"margin":{"top":"0","bottom":"0"}}}} -->
		<div class="nx-block-columns alignwide" style="margin-top:0;margin-bottom:0">
			<!-- nx:column {"width":"5%"} -->
			<div class="nx-block-column" style="flex-basis:5%"></div>
			<!-- /nx:column -->

			<!-- nx:column {"width":"65%","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}}} -->
			<div class="nx-block-column" style="padding-top:0;padding-bottom:0;flex-basis:65%">
				<!-- nx:group {"style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"layout":{"type":"default"}} -->
				<div class="nx-block-group" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0">
					<!-- nx:pattern {"slug":"twentytwentyfive/comments"} /-->
				</div>
				<!-- /nx:group -->
			</div>
			<!-- /nx:column -->

			<!-- nx:column {"width":"5%"} -->
			<div class="nx-block-column" style="flex-basis:5%"></div>
			<!-- /nx:column -->

			<!-- nx:column {"width":"25%"} -->
			<div class="nx-block-column" style="flex-basis:25%"></div>
			<!-- /nx:column -->

			<!-- nx:column {"width":"5%"} -->
			<div class="nx-block-column" style="flex-basis:5%"></div>
			<!-- /nx:column -->

		</div>
		<!-- /nx:columns -->
	</div>
	<!-- /nx:group -->
</main>
<!-- /nx:group -->

<!-- nx:template-part {"slug":"footer-newsletter"} /-->
