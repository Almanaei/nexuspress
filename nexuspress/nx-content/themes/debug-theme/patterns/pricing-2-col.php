<?php
/**
 * Title: Pricing, 2 columns
 * Slug: twentytwentyfive/pricing-2-col
 * Categories: call-to-action
 * Viewport width: 1400
 * Description: Pricing section with two columns, pricing plan, description, and call-to-action buttons.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--60);padding-bottom:var(--nx--preset--spacing--60)">
	<!-- nx:heading {"textAlign":"center","align":"wide"} -->
	<h2 class="nx-block-heading alignwide has-text-align-center"><?php esc_html_e( 'Pricing', 'twentytwentyfive' ); ?></h2>
	<!-- /nx:heading -->

	<!-- nx:paragraph {"align":"center"} -->
	<p class="has-text-align-center"><?php esc_html_e( 'Cancel or pause anytime.', 'twentytwentyfive' ); ?></p>
	<!-- /nx:paragraph -->

	<!-- nx:spacer {"height":"var:preset|spacing|40"} -->
	<div style="height:var(--nx--preset--spacing--40)" aria-hidden="true" class="nx-block-spacer"></div>
	<!-- /nx:spacer -->

	<!-- nx:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|30","left":"var:preset|spacing|50"}}}} -->
	<div class="nx-block-columns alignwide">
		<!-- nx:column {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","right":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50"}},"border":{"width":"1px","color":"var:preset|color|accent-6","radius":"10px"}}} -->
		<div class="nx-block-column has-border-color" style="border-color:var(--nx--preset--color--accent-6);border-width:1px;border-radius:10px;padding-top:var(--nx--preset--spacing--50);padding-right:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50);padding-left:var(--nx--preset--spacing--50)">
			<!-- nx:heading {"level":3} -->
			<h3 class="nx-block-heading" id="free"><?php esc_html_e( 'Free', 'twentytwentyfive' ); ?></h3>
			<!-- /nx:heading -->

			<!-- nx:paragraph {"fontSize":"large"} -->
			<p class="has-large-font-size"><?php esc_html_e( '0€', 'twentytwentyfive' ); ?></p>
			<!-- /nx:paragraph -->

			<!-- nx:list {"className":"is-style-checkmark-list","style":{"spacing":{"padding":{"left":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}},"fontSize":"small"} -->
			<ul style="padding-bottom:var(--nx--preset--spacing--20);padding-left:var(--nx--preset--spacing--20)" class="nx-block-list is-style-checkmark-list has-small-font-size">
				<!-- nx:list-item -->
				<li><?php esc_html_e( 'Get access to our paid articles and weekly newsletter.', 'twentytwentyfive' ); ?></li>
				<!-- /nx:list-item -->

				<!-- nx:list-item -->
				<li><?php esc_html_e( 'Join our IRL events.', 'twentytwentyfive' ); ?></li>
				<!-- /nx:list-item -->

				<!-- nx:list-item -->
				<li><?php esc_html_e( 'Get a free tote bag.', 'twentytwentyfive' ); ?></li>
				<!-- /nx:list-item -->

				<!-- nx:list-item -->
				<li><?php esc_html_e( 'An elegant addition of home decor collection.', 'twentytwentyfive' ); ?></li>
				<!-- /nx:list-item -->

				<!-- nx:list-item -->
				<li><?php esc_html_e( 'Join our forums.', 'twentytwentyfive' ); ?></li>
				<!-- /nx:list-item -->
			</ul>
			<!-- /nx:list -->

			<!-- nx:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
			<div class="nx-block-buttons">
				<!-- nx:button {"width":100} -->
				<div class="nx-block-button has-custom-width nx-block-button__width-100"><a class="nx-block-button__link nx-element-button"><?php echo esc_html_x( 'Join', 'Button text, refers to joining a community. Verb.', 'twentytwentyfive' ); ?></a></div>
				<!-- /nx:button -->
			</div>
			<!-- /nx:buttons -->
		</div>
		<!-- /nx:column -->

		<!-- nx:column {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","right":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50"}},"border":{"width":"1px","color":"var:preset|color|accent-6","radius":"10px"}},"layout":{"type":"default"}} -->
		<div class="nx-block-column has-border-color" style="border-color:var(--nx--preset--color--accent-6);border-width:1px;border-radius:10px;padding-top:var(--nx--preset--spacing--50);padding-right:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50);padding-left:var(--nx--preset--spacing--50)">
			<!-- nx:heading {"level":3} -->
			<h3 class="nx-block-heading" id="single"><?php echo esc_html_x( 'Single', 'Name of membership package.', 'twentytwentyfive' ); ?></h3>
			<!-- /nx:heading -->

			<!-- nx:paragraph {"fontSize":"large"} -->
			<p class="has-large-font-size"><?php esc_html_e( '20€/month', 'twentytwentyfive' ); ?></p>
			<!-- /nx:paragraph -->

			<!-- nx:list {"className":"is-style-checkmark-list","style":{"spacing":{"padding":{"bottom":"var:preset|spacing|20","left":"var:preset|spacing|20"}}},"fontSize":"small"} -->
			<ul style="padding-bottom:var(--nx--preset--spacing--20);padding-left:var(--nx--preset--spacing--20)" class="nx-block-list is-style-checkmark-list has-small-font-size">
				<!-- nx:list-item -->
				<li><?php esc_html_e( 'Get access to our paid articles and weekly newsletter.', 'twentytwentyfive' ); ?></li>
				<!-- /nx:list-item -->

				<!-- nx:list-item -->
				<li><?php esc_html_e( 'Join our IRL events.', 'twentytwentyfive' ); ?></li>
				<!-- /nx:list-item -->

				<!-- nx:list-item -->
				<li><?php esc_html_e( 'Get a free tote bag.', 'twentytwentyfive' ); ?></li>
				<!-- /nx:list-item -->

				<!-- nx:list-item -->
				<li><?php esc_html_e( 'An elegant addition of home decor collection.', 'twentytwentyfive' ); ?></li>
				<!-- /nx:list-item -->

				<!-- nx:list-item -->
				<li><?php esc_html_e( 'Join our forums.', 'twentytwentyfive' ); ?></li>
				<!-- /nx:list-item -->
			</ul>
			<!-- /nx:list -->

			<!-- nx:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
			<div class="nx-block-buttons">
				<!-- nx:button {"width":100} -->
				<div class="nx-block-button has-custom-width nx-block-button__width-100"><a class="nx-block-button__link nx-element-button"><?php echo esc_html_x( 'Join', 'Button text, refers to joining a community. Verb.', 'twentytwentyfive' ); ?></a></div>
				<!-- /nx:button -->
			</div>
			<!-- /nx:buttons -->
		</div>
		<!-- /nx:column -->
	</div>
	<!-- /nx:columns -->
</div>
<!-- /nx:group -->
