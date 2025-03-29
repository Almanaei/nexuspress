<?php
/**
 * Title: Overlapping images and paragraph on right
 * Slug: twentytwentyfive/overlapped-images
 * Categories: about, featured
 * Description: A section with overlapping images, and a description.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"align":"full","className":"is-style-section-1","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group alignfull is-style-section-1" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--80);padding-bottom:var(--nx--preset--spacing--80)">
	<!-- nx:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|80","left":"var:preset|spacing|80"}}}} -->
	<div class="nx-block-columns alignwide">
		<!-- nx:column {"width":"45%","style":{"spacing":{"padding":{"right":"var:preset|spacing|50"}}}} -->
		<div class="nx-block-column" style="padding-right:var(--nx--preset--spacing--50);flex-basis:45%">
			<!-- nx:image {"sizeSlug":"full"} -->
			<figure class="nx-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/red-hibiscus-closeup.webp" alt="<?php esc_attr_e( 'Photography close up of a red flower.', 'twentytwentyfive' ); ?>"/></figure>
			<!-- /nx:image -->
			<!-- nx:group {"style":{"spacing":{"margin":{"top":"-12vw"}}},"layout":{"type":"constrained"}} -->
			<div class="nx-block-group" style="margin-top:-12vw">
				<!-- nx:image {"width":"202px","sizeSlug":"full","align":"right","className":"is-resized","style":{"spacing":{"margin":{"right":"-5vw","left":"-5vw"}}}} -->
				<figure class="nx-block-image alignright size-full is-resized" style="margin-right:-5vw;margin-left:-5vw"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/grid-flower-2.webp" alt="<?php esc_attr_e( 'Black and white photography close up of a flower.', 'twentytwentyfive' ); ?>" style="width:202px"/></figure>
				<!-- /nx:image -->
			</div>
			<!-- /nx:group -->
		</div>
		<!-- /nx:column -->
		<!-- nx:column {"verticalAlignment":"center","width":"50%","style":{"spacing":{"padding":{"left":"0","right":"0"}}}} -->
		<div class="nx-block-column is-vertically-aligned-center" style="padding-right:0;padding-left:0;flex-basis:50%">
			<!-- nx:group {"layout":{"type":"flex","orientation":"vertical"}} -->
			<div class="nx-block-group">
				<!-- nx:heading {"className":"is-style-text-annotation"} -->
				<h2 class="nx-block-heading is-style-text-annotation"><?php esc_html_e( 'About Us', 'twentytwentyfive' ); ?></h2>
				<!-- /nx:heading -->
			</div>
			<!-- /nx:group -->

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
		<!-- /nx:column -->
	</div>
	<!-- /nx:columns -->
</div>
<!-- /nx:group -->
