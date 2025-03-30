<?php
/**
 * Title: Hero book
 * Slug: twentytwentyfive/hero-book
 * Categories: banner
 * Keywords: podcast, hero, stories
 * Description: A hero section for the book with a description and pre-order link.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group alignfull" style="margin-top:0;margin-bottom:0">
	<!-- nx:columns {"align":"full","style":{"spacing":{"blockGap":{"left":"0"}}}} -->
	<div class="nx-block-columns alignfull">
		<!-- nx:column {"width":"55%"} -->
		<div class="nx-block-column" style="flex-basis:55%">
			<!-- nx:cover {"url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/book-image-landing.webp","dimRatio":0,"customOverlayColor":"#6b6b6b","isUserOverlayColor":true,"isDark":false,"style":{"dimensions":{"aspectRatio":"1"}},"layout":{"type":"default"}} -->
			<div class="nx-block-cover is-light">
				<span aria-hidden="true" class="nx-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#6b6b6b"></span>
				<img class="nx-block-cover__image-background" alt="<?php esc_attr_e( 'Image of the book', 'twentytwentyfive' ); ?>" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/book-image-landing.webp" data-object-fit="cover"/>
				<div class="nx-block-cover__inner-container">
					<!-- nx:spacer {"height":"var:preset|spacing|20"} -->
					<div style="height:var(--nx--preset--spacing--20)" aria-hidden="true" class="nx-block-spacer"></div>
					<!-- /nx:spacer -->
				</div>
			</div>
			<!-- /nx:cover -->
		</div>
		<!-- /nx:column -->

<!-- nx:column {"verticalAlignment":"center","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|60","right":"var:preset|spacing|60"}}}} -->
<div class="nx-block-column is-vertically-aligned-center" style="padding-top:var(--nx--preset--spacing--60);padding-right:var(--nx--preset--spacing--60);padding-bottom:var(--nx--preset--spacing--60);padding-left:var(--nx--preset--spacing--60)">
<!-- nx:heading -->
<h2 class="nx-block-heading has-xx-large-font-size"><?php echo esc_html_x( 'The Stories Book', 'Heading of the hero section.', 'twentytwentyfive' ); ?></h2>
<!-- /nx:heading -->

<!-- nx:paragraph -->
<p><?php echo esc_html_x( 'A fine collection of moments in time featuring photographs from Louis Fleckenstein, Paul Strand and Asahachi Kōno.', 'Content of the hero section.', 'twentytwentyfive' ); ?></p>
<!-- /nx:paragraph -->

<!-- nx:paragraph {"fontSize":"medium"} -->
<p class="has-medium-font-size"><?php echo esc_html_x( 'Available for pre-order now.', 'CTA text of the hero section.', 'twentytwentyfive' ); ?></p>
<!-- /nx:paragraph --></div>
<!-- /nx:column --></div>
<!-- /nx:columns --></div>
<!-- /nx:group -->
