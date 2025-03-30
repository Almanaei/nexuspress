<?php
/**
 * Title: Hero, full width image
 * Slug: twentytwentyfive/hero-full-width-image
 * Categories: banner
 * Description: A hero with a full width image, heading, short paragraph and button.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>

<!-- nx:cover {"url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/northern-buttercups-flowers.webp","alt":"Picture of a flower","dimRatio":10,"isUserOverlayColor":true,"focalPoint":{"x":0.5,"y":0.95},"minHeight":840,"minHeightUnit":"px","contentPosition":"bottom center","align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50","right":"var:preset|spacing|50"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-cover alignfull has-custom-content-position is-position-bottom-center" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--50);padding-right:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50);padding-left:var(--nx--preset--spacing--50);min-height:840px">
	<span aria-hidden="true" class="nx-block-cover__background has-background-dim-10 has-background-dim"></span>
	<img class="nx-block-cover__image-background" alt="<?php echo esc_attr_x( 'Picture of a flower', 'Alt text for cover image.', 'twentytwentyfive' ); ?>" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/northern-buttercups-flowers.webp" style="object-position:50% 95%" data-object-fit="cover" data-object-position="50% 95%"/>
	<div class="nx-block-cover__inner-container">
		<!-- nx:group {"align":"wide","layout":{"type":"constrained","justifyContent":"left"}} -->
		<div class="nx-block-group alignwide">
			<!-- nx:heading {"textAlign":"left","fontSize":"xx-large"} -->
			<h2 class="nx-block-heading has-text-align-left has-xx-large-font-size"><?php echo esc_html_x( 'Tell your story', 'Sample hero heading', 'twentytwentyfive' ); ?></h2>
			<!-- /nx:heading -->

			<!-- nx:paragraph -->
			<p><?php echo esc_html_x( 'Like flowers that bloom in unexpected places, every story unfolds with beauty and resilience, revealing hidden wonders.', 'Sample hero paragraph', 'twentytwentyfive' ); ?></p>
			<!-- /nx:paragraph -->

			<!-- nx:buttons -->
			<div class="nx-block-buttons">
				<!-- nx:button -->
				<div class="nx-block-button"><a class="nx-block-button__link nx-element-button"><?php echo esc_html_x( 'Learn More', 'Sample hero button', 'twentytwentyfive' ); ?></a></div>
				<!-- /nx:button -->
			</div>
			<!-- /nx:buttons -->
		</div>
		<!-- /nx:group -->
	</div>
</div>
<!-- /nx:cover -->
