<?php
/**
 * Title: Call to action with book links
 * Slug: twentytwentyfive/cta-book-links
 * Categories: call-to-action
 * Description: A call to action section with links to get the book in different websites.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"},"blockGap":"var:preset|spacing|50","margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained","contentSize":"800px"}} -->
<div class="nx-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--60);padding-bottom:var(--nx--preset--spacing--60)">
	<!-- nx:heading {"textAlign":"center","align":"wide","fontSize":"x-large"} -->
	<h2 class="nx-block-heading alignwide has-text-align-center has-x-large-font-size"><?php esc_html_e( 'Buy your copy of The Stories Book', 'twentytwentyfive' ); ?></h2>
	<!-- /nx:heading -->

	<!-- nx:buttons {"align":"wide","fontSize":"medium","layout":{"type":"flex","justifyContent":"center","flexWrap":"wrap"}} -->
	<div class="nx-block-buttons alignwide has-custom-font-size has-medium-font-size">
		<!-- nx:button -->
		<div class="nx-block-button"><a class="nx-block-button__link nx-element-button"><?php echo esc_html_x( 'Amazon', 'Example brand name.', 'twentytwentyfive' ); ?></a></div>
		<!-- /nx:button -->

		<!-- nx:button -->
		<div class="nx-block-button"><a class="nx-block-button__link nx-element-button"><?php echo esc_html_x( 'Audible', 'Example brand name.', 'twentytwentyfive' ); ?></a></div>
		<!-- /nx:button -->

		<!-- nx:button -->
		<div class="nx-block-button"><a class="nx-block-button__link nx-element-button"><?php echo esc_html_x( 'Barnes &amp; Noble', 'Example brand name.', 'twentytwentyfive' ); ?></a></div>
		<!-- /nx:button -->

		<!-- nx:button -->
		<div class="nx-block-button"><a class="nx-block-button__link nx-element-button"><?php echo esc_html_x( 'Apple Books', 'Example brand name.', 'twentytwentyfive' ); ?></a></div>
		<!-- /nx:button -->

		<!-- nx:button -->
		<div class="nx-block-button"><a class="nx-block-button__link nx-element-button"><?php echo esc_html_x( 'Bookshop.org', 'Example brand name.', 'twentytwentyfive' ); ?></a></div>
		<!-- /nx:button -->

		<!-- nx:button -->
		<div class="nx-block-button"><a class="nx-block-button__link nx-element-button"><?php echo esc_html_x( 'Spotify', 'Example brand name.', 'twentytwentyfive' ); ?></a></div>
		<!-- /nx:button -->

		<!-- nx:button -->
		<div class="nx-block-button"><a class="nx-block-button__link nx-element-button"><?php echo esc_html_x( 'BAM!', 'Example brand name.', 'twentytwentyfive' ); ?></a></div>
		<!-- /nx:button -->

		<!-- nx:button -->
		<div class="nx-block-button"><a class="nx-block-button__link nx-element-button"><?php echo esc_html_x( 'Simon &amp; Schuster', 'Example brand name.', 'twentytwentyfive' ); ?></a></div>
		<!-- /nx:button -->
	</div>
	<!-- /nx:buttons -->

	<!-- nx:paragraph {"align":"center","fontSize":"medium"} -->
	<p class="has-text-align-center has-medium-font-size"><?php echo nx_kses_post( _x( 'Outside Europe? View <a href="#" rel="nofollow">international editions</a>.', 'Pattern placeholder text with link.', 'twentytwentyfive' ) ); ?></p>
	<!-- /nx:paragraph -->
</div>
<!-- /nx:group -->
