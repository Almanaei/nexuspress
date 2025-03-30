<?php
/**
 * Title: Centered footer
 * Slug: twentytwentyfive/footer-centered
 * Categories: footer
 * Block Types: core/template-part/footer
 * Description: Footer with centered site title and tagline.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group alignfull" style="padding-top:var(--nx--preset--spacing--70);padding-bottom:var(--nx--preset--spacing--70)">
	<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
	<div class="nx-block-group">
		<!-- nx:site-title {"level":0,"textAlign":"center"} /-->
		<!-- nx:site-tagline {"textAlign":"center"} /-->
	</div>
	<!-- /nx:group -->

	<!-- nx:spacer {"height":"var:preset|spacing|20"} -->
	<div style="height:var(--nx--preset--spacing--20)" aria-hidden="true" class="nx-block-spacer"></div>
	<!-- /nx:spacer -->

	<!-- nx:paragraph {"align":"center","fontSize":"small"} -->
	<p class="has-text-align-center has-small-font-size">
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
