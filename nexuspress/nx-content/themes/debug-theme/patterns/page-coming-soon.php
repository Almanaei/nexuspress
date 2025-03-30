<?php
/**
 * Title: Coming soon
 * Slug: twentytwentyfive/page-coming-soon
 * Categories: twentytwentyfive_page, featured
 * Keywords: starter
 * Block Types: core/post-content
 * Post Types: page, nx_template
 * Viewport width: 1400
 * Description: A full-width cover banner that can be applied to a page or it can work as a single landing page.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:cover {"url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/coming-soon-bg-image.webp","alt":"Photo of a field full of flowers, a blue sky and a tree.","dimRatio":10,"minHeight":100,"minHeightUnit":"vh","align":"full","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-1"}},"heading":{"color":{"text":"var:preset|color|accent-1"}}},"spacing":{"padding":{"right":"var:preset|spacing|50","left":"var:preset|spacing|50","top":"200px","bottom":"200px"},"margin":{"top":"0","bottom":"0"},"blockGap":"var:preset|spacing|40"}},"textColor":"accent-1","layout":{"type":"constrained"}} -->
<div class="nx-block-cover alignfull has-accent-1-color has-text-color has-link-color" style="margin-top:0;margin-bottom:0;padding-top:200px;padding-right:var(--nx--preset--spacing--50);padding-bottom:200px;padding-left:var(--nx--preset--spacing--50);min-height:100vh"><span aria-hidden="true" class="nx-block-cover__background has-background-dim-10 has-background-dim"></span><img class="nx-block-cover__image-background" alt="<?php esc_attr_e( 'Photo of a field full of flowers, a blue sky and a tree.', 'twentytwentyfive' ); ?>" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/coming-soon-bg-image.webp" data-object-fit="cover"/>
	<div class="nx-block-cover__inner-container">
		<!-- nx:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
		<div class="nx-block-group">
			<!-- nx:heading {"textAlign":"center","className":"is-style-text-annotation"} -->
			<h2 class="nx-block-heading has-text-align-center is-style-text-annotation"><?php esc_html_e( 'Event', 'twentytwentyfive' ); ?></h2>
			<!-- /nx:heading -->
		</div>
		<!-- /nx:group -->
		<!-- nx:heading {"textAlign":"center","level":3,"fontSize":"xx-large"} -->
		<h3 class="nx-block-heading has-text-align-center has-xx-large-font-size"><?php esc_html_e( 'Something great is coming soon', 'twentytwentyfive' ); ?></h3>
		<!-- /nx:heading -->

		<!-- nx:paragraph {"align":"center"} -->
		<p class="has-text-align-center"><?php esc_html_e( 'Subscribe to get notified when our website is ready.', 'twentytwentyfive' ); ?></p>
		<!-- /nx:paragraph -->

		<!-- nx:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
		<div class="nx-block-buttons">
			<!-- nx:button {"backgroundColor":"accent-1","textColor":"contrast","className":"is-style-fill","style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"borderColor":"accent-1"} -->
			<div class="nx-block-button is-style-fill"><a class="nx-block-button__link has-contrast-color has-accent-1-background-color has-text-color has-background has-link-color has-border-color has-accent-1-border-color nx-element-button"><?php esc_html_e( 'Subscribe', 'twentytwentyfive' ); ?></a></div>
			<!-- /nx:button -->
		</div>
		<!-- /nx:buttons -->
	</div>
</div>
<!-- /nx:cover -->
