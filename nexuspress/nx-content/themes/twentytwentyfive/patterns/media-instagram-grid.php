<?php
/**
 * Title: Instagram grid
 * Slug: twentytwentyfive/media-instagram-grid
 * Categories: media, gallery, featured
 * Viewport width: 1440
 * Description: A grid section with photos and a link to an Instagram profile.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50)">
	<!-- nx:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"grid","minimumColumnWidth":"18rem"}} -->
	<div class="nx-block-group alignwide">
		<!-- nx:group {"className":"is-style-section-3","style":{"dimensions":{"minHeight":"297px"}},"layout":{"type":"constrained"}} -->
		<div class="nx-block-group is-style-section-3" style="min-height:297px">
			<!-- nx:group {"style":{"dimensions":{"minHeight":"100%"},"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"center","justifyContent":"center"}} -->
			<div class="nx-block-group" style="min-height:100%">
				<!-- nx:heading {"fontSize":"large"} -->
				<h2 class="nx-block-heading has-large-font-size"><?php esc_html_e( 'Instagram', 'twentytwentyfive' ); ?></h2>
				<!-- /nx:heading -->

				<!-- nx:paragraph {"align":"center","fontSize":"medium"} -->
				<p class="has-text-align-center has-medium-font-size"><a href="#"><?php echo esc_html_x( '@example', 'Example username for social media account.', 'twentytwentyfive' ); ?></a></p>
				<!-- /nx:paragraph -->
				</div>
			<!-- /nx:group -->
		</div>
		<!-- /nx:group -->

		<!-- nx:image {"aspectRatio":"1","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
		<figure class="nx-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/flower-meadow-square.webp" alt="<?php esc_attr_e( 'Photo of a field full of flowers, a blue sky and a tree.', 'twentytwentyfive' ); ?>" style="aspect-ratio:1;object-fit:cover"/></figure>
		<!-- /nx:image -->

		<!-- nx:image {"aspectRatio":"1","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
		<figure class="nx-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/vash-gon-square.webp" alt="<?php esc_attr_e( 'Profile portrait of a native person.', 'twentytwentyfive' ); ?>" style="aspect-ratio:1;object-fit:cover"/></figure>
		<!-- /nx:image -->

		<!-- nx:image {"aspectRatio":"1","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
		<figure class="nx-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/coral-square.webp" alt="<?php esc_attr_e( 'View of the deep ocean.', 'twentytwentyfive' ); ?>" style="aspect-ratio:1;object-fit:cover"/></figure>
		<!-- /nx:image -->

		<!-- nx:image {"aspectRatio":"1","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
		<figure class="nx-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/agenda-img-4.webp" alt="<?php esc_attr_e( 'Portrait of an African Woman dressed in traditional costume, wearing decorative jewelry.', 'twentytwentyfive' ); ?>" style="aspect-ratio:1;object-fit:cover"/></figure>
		<!-- /nx:image -->

		<!-- nx:image {"aspectRatio":"1","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
		<figure class="nx-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/parthenon-square.webp" alt="<?php esc_attr_e( 'The Acropolis of Athens.', 'twentytwentyfive' ); ?>" style="aspect-ratio:1;object-fit:cover"/></figure>
		<!-- /nx:image -->

		<!-- nx:image {"aspectRatio":"1","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
		<figure class="nx-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/dallas-creek-square.webp" alt="<?php esc_attr_e( 'Close up of two flowers on a dark background.', 'twentytwentyfive' ); ?>" style="aspect-ratio:1;object-fit:cover"/></figure>
		<!-- /nx:image -->

		<!-- nx:image {"aspectRatio":"1","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
		<figure class="nx-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/marshland-birds-square.webp" alt="<?php esc_attr_e( 'Birds on a lake.', 'twentytwentyfive' ); ?>" style="aspect-ratio:1;object-fit:cover"/></figure>
		<!-- /nx:image -->
	</div>
	<!-- /nx:group -->
</div>
<!-- /nx:group -->
