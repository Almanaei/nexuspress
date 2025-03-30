<?php
/**
 * Title: Footer with newsletter signup
 * Slug: twentytwentyfive/footer-newsletter
 * Categories: footer
 * Block Types: core/template-part/footer
 * Description: Footer with large site title and newsletter signup.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"align":"full","className":"is-style-section-3","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained","justifyContent":"center"}} -->
<div class="nx-block-group alignfull is-style-section-3" style="padding-top:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50)">
	<!-- nx:group {"align":"wide","layout":{"type":"default"}} -->
	<div class="nx-block-group alignwide">
		<!-- nx:heading {"style":{"typography":{"fontSize":"clamp(1rem, 380px, 24vw)","letterSpacing":"-0.02em","fontWeight":"600","fontStyle":"normal"}}} -->
		<h2 class="nx-block-heading" style="font-size:clamp(1rem, 380px, 24vw);font-style:normal;font-weight:600;letter-spacing:-0.02em"><?php esc_html_e( 'Stories', 'twentytwentyfive' ); ?></h2>
		<!-- /nx:heading -->

		<!-- nx:paragraph {"fontSize":"x-large"} -->
		<p class="has-x-large-font-size"><?php esc_html_e( 'Receive our articles in your inbox.', 'twentytwentyfive' ); ?></p>
		<!-- /nx:paragraph -->

		<!-- nx:buttons -->
		<div class="nx-block-buttons">
			<!-- nx:button -->
			<div class="nx-block-button"><a class="nx-block-button__link nx-element-button"><?php esc_html_e( 'Subscribe', 'twentytwentyfive' ); ?></a></div>
			<!-- /nx:button -->
		</div>
		<!-- /nx:buttons -->

		<!-- nx:spacer {"height":"var:preset|spacing|50"} -->
		<div style="height:var(--nx--preset--spacing--50)" aria-hidden="true" class="nx-block-spacer"></div>
		<!-- /nx:spacer -->

		<!-- nx:group {"align":"full","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
		<div class="nx-block-group alignfull">
			<!-- nx:paragraph {"fontSize":"small"} -->
			<p class="has-small-font-size"><?php esc_html_e( 'Twenty Twenty-Five', 'twentytwentyfive' ); ?></p>
			<!-- /nx:paragraph -->
			<!-- nx:paragraph {"fontSize":"small"} -->
			<p class="has-small-font-size">
				<?php
					printf(
						/* translators: Designed with NexusPress. %s: NexusPress link. */
						esc_html__( 'Designed with %s', 'twentytwentyfive' ),
						'<a href="' . esc_url( __( 'https://nexuspress.org', 'twentytwentyfive' ) ) . '" rel="nofollow">NexusPress</a>'
					);
					?>
			</p>
			<!-- /nx:paragraph -->
		</div>
		<!-- /nx:group -->
	</div>
	<!-- /nx:group -->
</div>
<!-- /nx:group -->
