<?php
/**
 * Title: Short heading and paragraph and image on the left
 * Slug: twentytwentyfive/banner-intro-image
 * Categories: banner, featured
 * Description: A Intro pattern with Short heading, paragraph and image on the left.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50)">
	<!-- nx:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|50","left":"var:preset|spacing|50"}}}} -->
	<div class="nx-block-columns alignwide">
		<!-- nx:column {"width":"56%"} -->
		<div class="nx-block-column" style="flex-basis:56%">
			<!-- nx:image {"aspectRatio":"1","scale":"cover","sizeSlug":"full"} -->
			<figure class="nx-block-image size-full">
				<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/botany-flowers.webp" alt="<?php echo esc_attr_x( 'Picture of a flower', 'Alt text for intro picture.', 'twentytwentyfive' ); ?>" style="aspect-ratio:1;object-fit:cover"/>
			</figure>
			<!-- /nx:image -->
		</div>
		<!-- /nx:column -->

		<!-- nx:column {"verticalAlignment":"center","style":{"spacing":{"blockGap":"var:preset|spacing|40"}}} -->
		<div class="nx-block-column is-vertically-aligned-center">
			<!-- nx:heading -->
			<h2 class="nx-block-heading"><?php echo esc_html_x( 'New arrivals', 'Heading for banner pattern.', 'twentytwentyfive' ); ?></h2>
			<!-- /nx:heading -->

			<!-- nx:paragraph -->
			<p><?php echo esc_html_x( 'Like flowers that bloom in unexpected places, every story unfolds with beauty and resilience, revealing hidden wonders.', 'Sample description for banner with flower.', 'twentytwentyfive' ); ?></p>
			<!-- /nx:paragraph -->

			<!-- nx:buttons -->
			<div class="nx-block-buttons">
				<!-- nx:button -->
				<div class="nx-block-button">
					<a class="nx-block-button__link nx-element-button"><?php echo esc_html_x( 'Learn More', 'Button text of intro section.', 'twentytwentyfive' ); ?></a>
				</div>
				<!-- /nx:button -->
			</div>
			<!-- /nx:buttons -->
		</div>
		<!-- /nx:column -->
	</div>
	<!-- /nx:columns -->
</div>
<!-- /nx:group -->
