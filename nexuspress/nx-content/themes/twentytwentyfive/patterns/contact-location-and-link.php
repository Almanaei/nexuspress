<?php
/**
 * Title: Contact location and link
 * Slug: twentytwentyfive/contact-location-and-link
 * Categories: contact, featured
 * Description: Contact section with a location address, a directions link, and an image of the location.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"align":"full","className":"is-style-section-3","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained","justifyContent":"center"}} -->
<div class="nx-block-group alignfull is-style-section-3" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50)">
	<!-- nx:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|50","left":"var:preset|spacing|50"}}}} -->
	<div class="nx-block-columns alignwide">
		<!-- nx:column {"verticalAlignment":"top","width":""} -->
		<div class="nx-block-column is-vertically-aligned-top">
			<!-- nx:group {"style":{"dimensions":{"minHeight":"100%"},"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch","verticalAlignment":"space-between"}} -->
			<div class="nx-block-group" style="min-height:100%"><!-- nx:paragraph {"className":"is-style-text-display","fontSize":"xx-large"} -->
				<p class="is-style-text-display has-xx-large-font-size"><?php esc_html_e( 'Visit us at 123 Example St. Manhattan, NY 10300, United States', 'twentytwentyfive' ); ?></p>
				<!-- /nx:paragraph -->

				<!-- nx:paragraph {"style":{"typography":{"textTransform":"uppercase"}},"fontSize":"medium"} -->
				<p class="has-medium-font-size" style="text-transform:uppercase"><a href="#"><?php esc_html_e( 'Get directions', 'twentytwentyfive' ); ?></a></p>
				<!-- /nx:paragraph -->
			</div>
			<!-- /nx:group -->
		</div>
		<!-- /nx:column -->

		<!-- nx:column {"verticalAlignment":"top","width":""} -->
		<div class="nx-block-column is-vertically-aligned-top">
			<!-- nx:image {"aspectRatio":"1","scale":"cover","linkDestination":"none","className":"nx-block-image size-large"} -->
			<figure class="nx-block-image size-large"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/location.webp" alt="<?php esc_attr_e( 'The business location', 'twentytwentyfive' ); ?>"/></figure>
			<!-- /nx:image -->
		</div>
		<!-- /nx:column -->
	</div>
	<!-- /nx:columns -->
</div>
<!-- /nx:group -->
