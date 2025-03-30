<?php
/**
 * Title: Grid with videos
 * Slug: twentytwentyfive/grid-videos
 * Categories: about
 * Description: A grid with videos.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|50","margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50)">
	<!-- nx:group {"align":"wide","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
	<div class="nx-block-group alignwide">
		<!-- nx:heading {"textAlign":"left","align":"wide","className":"is-style-text-subtitle","style":{"layout":{"selfStretch":"fit","flexSize":null}},"fontSize":"x-large"} -->
		<h2 class="nx-block-heading alignwide has-text-align-left is-style-text-subtitle has-x-large-font-size"><?php esc_html_e( 'Explore the episodes', 'twentytwentyfive' ); ?></h2>
		<!-- /nx:heading -->

		<!-- nx:paragraph {"className":"is-style-text-annotation"} -->
		<p class="is-style-text-annotation"><?php esc_html_e( 'Podcast', 'twentytwentyfive' ); ?></p>
		<!-- /nx:paragraph -->
	</div>
	<!-- /nx:group -->

	<!-- nx:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"grid","minimumColumnWidth":"19rem"}} -->
	<div class="nx-block-group alignwide">
		<!-- nx:video -->
		<figure class="nx-block-video"></figure>
		<!-- /nx:video -->

		<!-- nx:video -->
		<figure class="nx-block-video"></figure>
		<!-- /nx:video -->

		<!-- nx:video -->
		<figure class="nx-block-video"></figure>
		<!-- /nx:video -->

		<!-- nx:video -->
		<figure class="nx-block-video"></figure>
		<!-- /nx:video -->

		<!-- nx:video -->
		<figure class="nx-block-video"></figure>
		<!-- /nx:video -->

		<!-- nx:video -->
		<figure class="nx-block-video"></figure>
		<!-- /nx:video -->
	</div>
	<!-- /nx:group -->
</div>
<!-- /nx:group -->
