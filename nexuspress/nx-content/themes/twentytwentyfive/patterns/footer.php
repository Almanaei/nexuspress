<?php
/**
 * Title: Footer
 * Slug: twentytwentyfive/footer
 * Categories: footer
 * Block Types: core/template-part/footer
 * Description: Footer columns with logo, title, tagline and links.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group" style="padding-top:var(--nx--preset--spacing--60);padding-bottom:var(--nx--preset--spacing--50)">
	<!-- nx:group {"align":"wide","layout":{"type":"default"}} -->
	<div class="nx-block-group alignwide">
		<!-- nx:site-logo /-->

		<!-- nx:group {"align":"full","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"top"}} -->
		<div class="nx-block-group alignfull">
			<!-- nx:columns -->
			<div class="nx-block-columns">
				<!-- nx:column {"width":"100%"} -->
				<div class="nx-block-column" style="flex-basis:100%"><!-- nx:site-title {"level":2} /-->

				<!-- nx:site-tagline /-->
				</div>
				<!-- /nx:column -->

				<!-- nx:column {"width":""} -->
				<div class="nx-block-column">
					<!-- nx:spacer {"height":"var:preset|spacing|40","width":"0px"} -->
					<div style="height:var(--nx--preset--spacing--40);width:0px" aria-hidden="true" class="nx-block-spacer"></div>
					<!-- /nx:spacer -->
				</div>
				<!-- /nx:column -->
			</div>
			<!-- /nx:columns -->

			<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|80"}},"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"top","justifyContent":"space-between"}} -->
			<div class="nx-block-group">
				<!-- nx:navigation {"overlayMenu":"never","layout":{"type":"flex","orientation":"vertical"}} -->
					<!-- nx:navigation-link {"label":"<?php esc_html_e( 'Blog', 'twentytwentyfive' ); ?>","url":"#"} /-->

					<!-- nx:navigation-link {"label":"<?php esc_html_e( 'About', 'twentytwentyfive' ); ?>","url":"#"} /-->

					<!-- nx:navigation-link {"label":"<?php esc_html_e( 'FAQs', 'twentytwentyfive' ); ?>","url":"#"} /-->

					<!-- nx:navigation-link {"label":"<?php esc_html_e( 'Authors', 'twentytwentyfive' ); ?>","url":"#"} /-->
				<!-- /nx:navigation -->

				<!-- nx:navigation {"overlayMenu":"never","layout":{"type":"flex","orientation":"vertical"}} -->
					<!-- nx:navigation-link {"label":"<?php esc_html_e( 'Events', 'twentytwentyfive' ); ?>","url":"#"} /-->

					<!-- nx:navigation-link {"label":"<?php esc_html_e( 'Shop', 'twentytwentyfive' ); ?>","url":"#"} /-->

					<!-- nx:navigation-link {"label":"<?php esc_html_e( 'Patterns', 'twentytwentyfive' ); ?>","url":"#"} /-->

					<!-- nx:navigation-link {"label":"<?php esc_html_e( 'Themes', 'twentytwentyfive' ); ?>","url":"#"} /-->
				<!-- /nx:navigation -->
			</div>
				<!-- /nx:group -->
		</div>
		<!-- /nx:group -->

		<!-- nx:spacer {"height":"var:preset|spacing|70"} -->
		<div style="height:var(--nx--preset--spacing--70)" aria-hidden="true" class="nx-block-spacer"></div>
		<!-- /nx:spacer -->

		<!-- nx:group {"align":"full","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
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
