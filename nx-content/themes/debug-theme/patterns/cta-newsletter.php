<?php
/**
 * Title: Newsletter sign-up
 * Slug: twentytwentyfive/cta-newsletter
 * Keywords: call-to-action, newsletter
 * Categories: call-to-action
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"tagName":"aside","align":"full","className":"is-style-section-3","style":{"spacing":{"padding":{"right":"var:preset|spacing|50","left":"var:preset|spacing|50","top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"},"margin":{"top":"0","bottom":"0"}},"dimensions":{"minHeight":""}},"layout":{"type":"constrained","contentSize":"800px"}} -->
<aside class="nx-block-group alignfull is-style-section-3" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--50);padding-right:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50);padding-left:var(--nx--preset--spacing--50)">
	<!-- nx:group {"style":{"dimensions":{"minHeight":"360px"},"spacing":{"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"center","justifyContent":"center"}} -->
	<div class="nx-block-group" style="min-height:360px;margin-top:0;margin-bottom:0">
		<!-- nx:heading {"textAlign":"center","fontSize":"xx-large"} -->
		<h2 class="nx-block-heading has-text-align-center has-xx-large-font-size"><?php esc_html_e( 'Sign up to get daily stories', 'twentytwentyfive' ); ?></h2>
		<!-- /nx:heading -->

		<!-- nx:paragraph {"align":"center","className":"is-style-text-subtitle"} -->
		<p class="has-text-align-center is-style-text-subtitle"><?php esc_html_e( 'Get access to a curated collection of moments in time featuring photographs from historical relevance.', 'twentytwentyfive' ); ?></p>
		<!-- /nx:paragraph -->

		<!-- nx:spacer {"height":"var:preset|spacing|30"} -->
		<div style="height:var(--nx--preset--spacing--30)" aria-hidden="true" class="nx-block-spacer"></div>
		<!-- /nx:spacer -->

		<!-- nx:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
		<div class="nx-block-buttons"><!-- nx:button {"textAlign":"center"} -->
			<div class="nx-block-button"><a class="nx-block-button__link has-text-align-center nx-element-button"><?php esc_html_e( 'Subscribe', 'twentytwentyfive' ); ?></a></div>
		<!-- /nx:button --></div>
		<!-- /nx:buttons -->
	</div>
	<!-- /nx:group -->
</aside>
<!-- /nx:group -->
