<?php
/**
 * Title: Services, subscriber only section
 * Slug: twentytwentyfive/services-subscriber-only-section
 * Categories: call-to-action, services
 * Description: A subscriber-only section highlighting exclusive services and offerings.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"align":"full","style":{"spacing":{"blockGap":"var:preset|spacing|50","padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--70);padding-bottom:var(--nx--preset--spacing--70)">
	<!-- nx:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|70","left":"var:preset|spacing|70"}}}} -->
	<div class="nx-block-columns alignwide">
		<!-- nx:column {"verticalAlignment":"center"} -->
		<div class="nx-block-column is-vertically-aligned-center">
			<!-- nx:heading {"fontSize":"xx-large"} -->
			<h2 class="nx-block-heading has-xx-large-font-size"><?php esc_html_e( 'Subscribe to get unlimited access', 'twentytwentyfive' ); ?></h2>
			<!-- /nx:heading -->

			<!-- nx:list {"className":"is-style-checkmark-list","style":{"spacing":{"margin":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"},"padding":{"left":"var:preset|spacing|30"}}}} -->
			<ul style="margin-top:var(--nx--preset--spacing--40);margin-bottom:var(--nx--preset--spacing--40);padding-left:var(--nx--preset--spacing--30)" class="nx-block-list is-style-checkmark-list">
				<!-- nx:list-item {"fontSize":"medium"} -->
				<li class="has-medium-font-size"><?php esc_html_e( 'Get access to our paid articles and weekly newsletter.', 'twentytwentyfive' ); ?></li>
				<!-- /nx:list-item -->

				<!-- nx:list-item {"fontSize":"medium"} -->
				<li class="has-medium-font-size"><?php esc_html_e( 'Join our IRL events.', 'twentytwentyfive' ); ?></li>
				<!-- /nx:list-item -->

				<!-- nx:list-item {"fontSize":"medium"} -->
				<li class="has-medium-font-size"><?php esc_html_e( 'Get a free tote bag.', 'twentytwentyfive' ); ?></li>
				<!-- /nx:list-item -->

				<!-- nx:list-item {"fontSize":"medium"} -->
				<li class="has-medium-font-size"><?php esc_html_e( 'An elegant addition of home decor collection.', 'twentytwentyfive' ); ?></li>
				<!-- /nx:list-item -->

				<!-- nx:list-item {"fontSize":"medium"} -->
				<li class="has-medium-font-size"><?php esc_html_e( 'Join our forums.', 'twentytwentyfive' ); ?></li>
				<!-- /nx:list-item -->
			</ul>
			<!-- /nx:list -->

			<!-- nx:buttons {"layout":{"type":"flex","justifyContent":"left","flexWrap":"nowrap"}} -->
			<div class="nx-block-buttons">
				<!-- nx:button {"className":"is-style-fill"} -->
				<div class="nx-block-button is-style-fill"><a class="nx-block-button__link nx-element-button"><?php esc_html_e( 'Subscribe', 'twentytwentyfive' ); ?></a></div>
				<!-- /nx:button -->

				<!-- nx:button {"className":"is-style-outline"} -->
				<div class="nx-block-button is-style-outline"><a class="nx-block-button__link nx-element-button"><?php esc_html_e( 'View plans', 'twentytwentyfive' ); ?></a></div>
				<!-- /nx:button -->
			</div>
			<!-- /nx:buttons -->

			<!-- nx:paragraph {"fontSize":"small"} -->
			<p class="has-small-font-size"><?php esc_html_e( 'Cancel or pause anytime.', 'twentytwentyfive' ); ?></p>
			<!-- /nx:paragraph -->
		</div>
		<!-- /nx:column -->

		<!-- nx:column {"verticalAlignment":"center"} -->
		<div class="nx-block-column is-vertically-aligned-center">
			<!-- nx:image {"sizeSlug":"full","linkDestination":"none"} -->
			<figure class="nx-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/services-subscriber-photo.webp" alt="<?php esc_attr_e( 'Smartphones capturing a scenic wildflower meadow with trees', 'twentytwentyfive' ); ?>"/></figure>
			<!-- /nx:image -->
		</div>
		<!-- /nx:column -->
	</div>
	<!-- /nx:columns -->
</div>
<!-- /nx:group -->
