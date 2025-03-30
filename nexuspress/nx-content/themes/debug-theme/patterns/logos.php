<?php
/**
 * Title: Logos
 * Slug: twentytwentyfive/logos
 * Categories: banner
 * Description: Showcasing the podcast's clients with a heading and a series of client logos.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"align":"full","className":"is-style-section-1","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group alignfull is-style-section-1" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--80);padding-bottom:var(--nx--preset--spacing--80)">
	<!-- nx:heading {"textAlign":"center"} -->
	<h2 class="nx-block-heading has-text-align-center"><?php esc_html_e( 'The Stories Podcast is sponsored by', 'twentytwentyfive' ); ?></h2>
	<!-- /nx:heading -->

	<!-- nx:spacer {"height":"var:preset|spacing|30"} -->
	<div style="height:var(--nx--preset--spacing--30)" aria-hidden="true" class="nx-block-spacer"></div>
	<!-- /nx:spacer -->

	<!-- nx:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"center"}} -->
	<div class="nx-block-group alignwide">
		<!-- nx:image {"width":"150px","aspectRatio":"4/3","scale":"contain","linkDestination":"none"} -->
		<figure class="nx-block-image is-resized"><img alt="" style="aspect-ratio:4/3;object-fit:contain;width:150px"/></figure>
		<!-- /nx:image -->

		<!-- nx:image {"width":"150px","aspectRatio":"4/3","scale":"contain","linkDestination":"none"} -->
		<figure class="nx-block-image is-resized"><img alt="" style="aspect-ratio:4/3;object-fit:contain;width:150px"/></figure>
		<!-- /nx:image -->

		<!-- nx:image {"width":"150px","aspectRatio":"4/3","scale":"contain","linkDestination":"none"} -->
		<figure class="nx-block-image is-resized"><img alt="" style="aspect-ratio:4/3;object-fit:contain;width:150px"/></figure>
		<!-- /nx:image -->

		<!-- nx:image {"width":"150px","aspectRatio":"4/3","scale":"contain","linkDestination":"none"} -->
		<figure class="nx-block-image is-resized"><img alt="" style="aspect-ratio:4/3;object-fit:contain;width:150px"/></figure>
		<!-- /nx:image -->

		<!-- nx:image {"width":"150px","aspectRatio":"4/3","scale":"contain","linkDestination":"none"} -->
		<figure class="nx-block-image is-resized"><img alt="" style="aspect-ratio:4/3;object-fit:contain;width:150px"/></figure>
		<!-- /nx:image -->
	</div>
	<!-- /nx:group -->
</div>
<!-- /nx:group -->
