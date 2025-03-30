<?php
/**
 * Title: Link in bio heading, paragraph, links and full-height image
 * Slug: twentytwentyfive/page-link-in-bio-heading-paragraph-links-image
 * Categories: twentytwentyfive_page, banner, featured
 * Keywords: starter
 * Block Types: core/post-content
 * Viewport width: 1400
 * Description: A link in bio landing page with a heading, paragraph, links and a full height image.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"align":"full","className":"is-style-section-4","style":{"dimensions":{"minHeight":"100vh"},"spacing":{"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group alignfull is-style-section-4" style="min-height:100vh;margin-top:0;margin-bottom:0">
	<!-- nx:columns {"align":"full"} -->
	<div class="nx-block-columns alignfull">
		<!-- nx:column {"verticalAlignment":"center"} -->
		<div class="nx-block-column is-vertically-aligned-center">
			<!-- nx:group {"style":{"spacing":{"padding":{"right":"var:preset|spacing|50","left":"var:preset|spacing|50","top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"default"}} -->
			<div class="nx-block-group" style="padding-top:var(--nx--preset--spacing--50);padding-right:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50);padding-left:var(--nx--preset--spacing--50)">
				<!-- nx:heading -->
				<h2 class="nx-block-heading"><?php esc_html_e( 'Lewis Hine', 'twentytwentyfive' ); ?></h2>
				<!-- /nx:heading -->

				<!-- nx:paragraph -->
				<p><?php esc_html_e( 'Lewis W. Hine studied sociology before moving to New York in 1901 to work at the Ethical Culture School, where he took up photography to enhance his teaching practices', 'twentytwentyfive' ); ?></p>
				<!-- /nx:paragraph -->

				<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
				<div class="nx-block-group">
					<!-- nx:paragraph -->
					<p><a href="#"><?php esc_html_e( 'Instagram', 'twentytwentyfive' ); ?></a></p>
					<!-- /nx:paragraph -->

					<!-- nx:paragraph -->
					<p><a href="#"><?php echo esc_html_x( 'X', 'Refers to the social media platform formerly known as Twitter.', 'twentytwentyfive' ); ?></a></p>
					<!-- /nx:paragraph -->

					<!-- nx:paragraph -->
					<p><a href="#"><?php esc_html_e( 'TikTok', 'twentytwentyfive' ); ?></a></p>
					<!-- /nx:paragraph -->
				</div>
				<!-- /nx:group -->
			</div>
			<!-- /nx:group -->
		</div>
		<!-- /nx:column -->

		<!-- nx:column -->
		<div class="nx-block-column">
			<!-- nx:cover {"url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/link-in-bio-background.webp","alt":"Photo of a woman worker.","dimRatio":0,"customOverlayColor":"#6b6b6b","isUserOverlayColor":true,"minHeight":100,"minHeightUnit":"vh","layout":{"type":"default"}} -->
			<div class="nx-block-cover" style="min-height:100vh"><span aria-hidden="true" class="nx-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#6b6b6b"></span>
				<img class="nx-block-cover__image-background" alt="<?php esc_attr_e( 'Photo of a woman worker.', 'twentytwentyfive' ); ?>" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/link-in-bio-background.webp" data-object-fit="cover"/><div class="nx-block-cover__inner-container">
				<!-- nx:spacer {"height":"var:preset|spacing|20"} -->
				<div style="height:var(--nx--preset--spacing--20)" aria-hidden="true" class="nx-block-spacer"></div>
				<!-- /nx:spacer -->
			</div></div>
			<!-- /nx:cover -->
		</div>
		<!-- /nx:column -->
	</div>
	<!-- /nx:columns -->
</div>
<!-- /nx:group -->
