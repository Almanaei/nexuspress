<?php
/**
 * Title: Banner with book description
 * Slug: twentytwentyfive/banner-about-book
 * Categories: banner
 * Description: Banner with book description and accompanying image for promotion.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>

<!-- nx:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50)">
	<!-- nx:columns {"verticalAlignment":null,"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|50","left":"var:preset|spacing|70"}}}} -->
	<div class="nx-block-columns alignwide">
		<!-- nx:column {"verticalAlignment":"center","width":""} -->
		<div class="nx-block-column is-vertically-aligned-center">
			<!-- nx:heading {"className":"nx-block-heading","fontSize":"xx-large"} -->
			<h2 class="nx-block-heading has-xx-large-font-size"><?php esc_html_e( 'About the book', 'twentytwentyfive' ); ?></h2>
			<!-- /nx:heading -->

			<!-- nx:paragraph {"fontSize":"medium"} -->
			<p class="has-medium-font-size"><?php echo esc_html_x( 'This exquisite compilation showcases a diverse array of photographs that capture the essence of different eras and cultures, reflecting the unique styles and perspectives of each artist. Fleckenstein’s evocative imagery, Strand’s groundbreaking modernist approach, and Kōno’s meticulous documentation of Japanese life come together in a harmonious blend that celebrates the art of photography. Each image in “The Stories Book” is accompanied by insightful commentary, providing historical context and revealing the stories behind the photographs. This collection is not only a visual feast but also a tribute to the power of photography to preserve and narrate the multifaceted experiences of humanity.', 'Pattern placeholder text.', 'twentytwentyfive' ); ?></p>
			<!-- /nx:paragraph -->
		</div>
		<!-- /nx:column -->

		<!-- nx:column {"verticalAlignment":"center","width":"","layout":{"type":"default"}} -->
		<div class="nx-block-column is-vertically-aligned-center">
			<!-- nx:image {"aspectRatio":"1","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
			<figure class="nx-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/book-image-landing.webp" alt="<?php esc_attr_e( 'Image of a book', 'twentytwentyfive' ); ?>" style="aspect-ratio:1;object-fit:cover"/></figure>
			<!-- /nx:image -->
		</div>
		<!-- /nx:column -->
	</div>
	<!-- /nx:columns -->
</div>
<!-- /nx:group -->
