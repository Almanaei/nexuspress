<?php
/**
 * Title: Footer with columns
 * Slug: twentytwentyfive/footer-columns
 * Categories: footer
 * Block Types: core/template-part/footer
 * Description: Footer columns with title, tagline and links.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group" style="padding-top:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50)">
	<!-- nx:group {"align":"wide","layout":{"type":"default"}} -->
	<div class="nx-block-group alignwide">
		<!-- nx:group {"align":"full","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"top"}} -->
		<div class="nx-block-group alignfull">
			<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20","padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"layout":{"type":"constrained"}} -->
			<div class="nx-block-group" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0">
				<!-- nx:site-title {"level":2,"fontSize":"xx-large"} /-->
				<!-- nx:site-tagline /-->
			</div>
			<!-- /nx:group -->

			<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|80"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
			<div class="nx-block-group">
				<!-- nx:group {"style":{"spacing":{"padding":{"right":"0","left":"0"}}},"layout":{"type":"constrained"}} -->
				<div class="nx-block-group" style="padding-right:0;padding-left:0">
					<!-- nx:heading {"level":3,"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"fontSize":"medium"} -->
					<h3 class="nx-block-heading has-medium-font-size" style="font-style:normal;font-weight:700"><?php esc_html_e( 'Stories', 'twentytwentyfive' ); ?></h3>
					<!-- /nx:heading -->
					<!-- nx:navigation {"overlayMenu":"never","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"fontSize":"medium","layout":{"type":"flex","orientation":"vertical"},"ariaLabel":"<?php esc_attr_e( 'Stories', 'twentytwentyfive' ); ?>"} -->
						<!-- nx:navigation-link {"label":"<?php esc_html_e( 'Blog', 'twentytwentyfive' ); ?>","url":"#"} /-->
						<!-- nx:navigation-link {"label":"<?php esc_html_e( 'About', 'twentytwentyfive' ); ?>","url":"#"} /-->
						<!-- nx:navigation-link {"label":"<?php esc_html_e( 'FAQs', 'twentytwentyfive' ); ?>","url":"#"} /-->
						<!-- nx:navigation-link {"label":"<?php esc_html_e( 'Authors', 'twentytwentyfive' ); ?>","url":"#"} /-->
					<!-- /nx:navigation -->
				</div>
				<!-- /nx:group -->
				<!-- nx:group {"style":{"spacing":{"padding":{"right":"0","left":"0"}}},"layout":{"type":"constrained"}} -->
				<div class="nx-block-group" style="padding-right:0;padding-left:0">
					<!-- nx:heading {"level":3,"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"fontSize":"medium"} -->
					<h3 class="nx-block-heading has-medium-font-size" style="font-style:normal;font-weight:700"><?php echo esc_html_x( 'Fleurs', 'Example brand name.', 'twentytwentyfive' ); ?></h3>
					<!-- /nx:heading -->
					<!-- nx:navigation {"overlayMenu":"never","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"fontSize":"medium","layout":{"type":"flex","orientation":"vertical"},"ariaLabel":"<?php esc_attr_e( 'Featured', 'twentytwentyfive' ); ?>"} -->
						<!-- nx:navigation-link {"label":"<?php esc_html_e( 'Events', 'twentytwentyfive' ); ?>","url":"#"} /-->
						<!-- nx:navigation-link {"label":"<?php esc_html_e( 'Shop', 'twentytwentyfive' ); ?>","url":"#"} /-->
						<!-- nx:navigation-link {"label":"<?php esc_html_e( 'Patterns', 'twentytwentyfive' ); ?>","url":"#"} /-->
						<!-- nx:navigation-link {"label":"<?php esc_html_e( 'Themes', 'twentytwentyfive' ); ?>","url":"#"} /-->
					<!-- /nx:navigation -->
				</div>
				<!-- /nx:group -->
			</div>
			<!-- /nx:group -->
		</div>
		<!-- /nx:group -->
		<!-- nx:spacer {"height":"var:preset|spacing|60"} -->
		<div style="height:var(--nx--preset--spacing--60)" aria-hidden="true" class="nx-block-spacer"></div>
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
