<?php
/**
 * Title: Audio format
 * Slug: twentytwentyfive/format-audio
 * Categories: twentytwentyfive_post-format
 * Description: An audio post format with an image, title, audio player, and description.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"className":"is-style-section-3","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30","left":"var:preset|spacing|30","right":"var:preset|spacing|30"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group is-style-section-3" style="padding-top:var(--nx--preset--spacing--30);padding-right:var(--nx--preset--spacing--30);padding-bottom:var(--nx--preset--spacing--30);padding-left:var(--nx--preset--spacing--30)">
	<!-- nx:columns {"isStackedOnMobile":false,"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|30"}}}} -->
	<div class="nx-block-columns is-not-stacked-on-mobile">
		<!-- nx:column {"width":"100px"} -->
		<div class="nx-block-column" style="flex-basis:100px"><!-- nx:image {"width":"100px","height":"auto","aspectRatio":"1","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
		<figure class="nx-block-image size-full is-resized"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/ruins-image.webp' ); ?>" alt="<?php esc_attr_e( 'Event image', 'twentytwentyfive' ); ?>" style="aspect-ratio:1;object-fit:cover;width:100px;height:auto"/></figure>
		<!-- /nx:image --></div>
		<!-- /nx:column -->

		<!-- nx:column {"width":""} -->
		<div class="nx-block-column"><!-- nx:paragraph -->
		<p><?php esc_html_e( 'Episode 1: Acoma Pueblo with Prof. Fiona Presley', 'twentytwentyfive' ); ?></p>
		<!-- /nx:paragraph -->

		<!-- nx:paragraph {"fontSize":"small"} -->
		<p class="has-small-font-size"><?php esc_html_e( 'Acoma Pueblo, in New Mexico, stands as a testament to the resilience and cultural heritage of the Acoma people', 'twentytwentyfive' ); ?></p>
		<!-- /nx:paragraph -->

		<!-- nx:audio -->
		<figure class="nx-block-audio"><audio controls="" src="#"></audio></figure>
		<!-- /nx:audio --></div>
		<!-- /nx:column --></div>
	<!-- /nx:columns --></div>
<!-- /nx:group -->
