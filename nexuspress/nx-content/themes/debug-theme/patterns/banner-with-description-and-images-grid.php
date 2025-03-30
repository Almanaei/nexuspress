<?php
/**
 * Title: Banner with description and images grid
 * Slug: twentytwentyfive/banner-description-images-grid
 * Categories: banner, featured
 * Description: A banner with a short paragraph, and two images displayed in a grid layout.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group alignfull" style="margin-top:0;margin-bottom:0">
	<!-- nx:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|50"}},"layout":{"type":"grid","minimumColumnWidth":"26rem"}} -->
	<div class="nx-block-group alignwide" style="padding-top:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50)">
		<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"space-between","justifyContent":"stretch","flexWrap":"nowrap"}} -->
		<div class="nx-block-group">
			<!-- nx:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"left"}} -->
			<div class="nx-block-group">
				<!-- nx:heading {"className":"is-style-text-annotation"} -->
				<h2 class="nx-block-heading is-style-text-annotation"><?php esc_html_e( 'About Us', 'twentytwentyfive' ); ?></h2>
				<!-- /nx:heading -->

				<!-- nx:paragraph {"className":"is-style-text-subtitle"} -->
				<p class="is-style-text-subtitle">
				<?php
				printf(
					/* translators: %s is the brand name, e.g., 'Fleurs'. */
					esc_html__( '%s is a flower delivery and subscription business. Based in the EU, our mission is not only to deliver stunning flower arrangements across but also foster knowledge and enthusiasm on the beautiful gift of nature: flowers.', 'twentytwentyfive' ),
					'<strong>' . esc_html_x( 'Fleurs', 'Example brand name.', 'twentytwentyfive' ) . '</strong>'
				);
				?>
				</p>
				<!-- /nx:paragraph -->

			</div>
			<!-- /nx:group -->

			<!-- nx:image {"aspectRatio":"16/9","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
			<figure class="nx-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/grid-flower-1.webp" alt="<?php esc_attr_e( 'Photography close up of a red flower.', 'twentytwentyfive' ); ?>" style="aspect-ratio:16/9;object-fit:cover"/></figure>
			<!-- /nx:image -->
		</div>
		<!-- /nx:group -->

		<!-- nx:image {"aspectRatio":"3/4","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
		<figure class="nx-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/grid-flower-2.webp" alt="<?php esc_attr_e( 'Black and white photography close up of a flower.', 'twentytwentyfive' ); ?>" style="aspect-ratio:3/4;object-fit:cover"/></figure>
		<!-- /nx:image -->
	</div>
	<!-- /nx:group -->
</div>
<!-- /nx:group -->
