<?php
/**
 * Title: Hero podcast
 * Slug: twentytwentyfive/hero-podcast
 * Categories: banner
 * Keywords: podcast, hero, stories
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"align":"full","className":"is-style-section-2","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group alignfull is-style-section-2" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--60);padding-bottom:var(--nx--preset--spacing--60)">
	<!-- nx:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|60"}}}} -->
	<div class="nx-block-columns alignwide">
		<!-- nx:column {"width":"40%"} -->
		<div class="nx-block-column" style="flex-basis:40%">
			<!-- nx:image {"sizeSlug":"large","linkDestination":"none"} -->
			<figure class="nx-block-image size-large">
				<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/hero-podcast.webp" alt="<?php echo esc_attr_x( 'Picture of a person', 'Alt text for hero image.', 'twentytwentyfive' ); ?>"/>
			</figure>
			<!-- /nx:image -->
		</div>
		<!-- /nx:column -->


		<!-- nx:column {"verticalAlignment":"center","width":"60%","style":{"spacing":{"blockGap":"var:preset|spacing|40"}}} -->
		<div class="nx-block-column is-vertically-aligned-center" style="flex-basis:60%">
			<!-- nx:heading {"fontSize":"xx-large"} -->
			<h2 class="nx-block-heading has-xx-large-font-size"><?php esc_html_e( 'The Stories Podcast', 'twentytwentyfive' ); ?></h2>
			<!-- /nx:heading -->

			<!-- nx:paragraph -->
			<p><?php echo esc_html_x( 'Storytelling, expert analysis, and vivid descriptions. The Stories Podcast brings history to life, making it accessible and engaging for a global audience.', 'Podcast description', 'twentytwentyfive' ); ?></p>
			<!-- /nx:paragraph -->

			<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"wrap"}} -->
			<div class="nx-block-group">

				<!-- nx:heading {"level":3,"style":{"typography":{"textTransform":"uppercase","letterSpacing":"1px","fontStyle":"normal","fontWeight":"600"}},"fontSize":"small"} -->
				<h3 class="nx-block-heading has-small-font-size" style="font-style:normal;font-weight:600;letter-spacing:1px;text-transform:uppercase"><?php esc_html_e( 'Subscribe on your favorite platform', 'twentytwentyfive' ); ?></h3>
				<!-- /nx:heading -->

				<!-- nx:group {"layout":{"type":"flex","flexWrap":"wrap"}} -->
				<div class="nx-block-group">
					<!-- nx:paragraph {"className":"is-style-text-annotation"} -->
					<p class="is-style-text-annotation"><a href="#"><?php echo esc_html_x( 'YouTube', 'Button text', 'twentytwentyfive' ); ?></a></p>
					<!-- /nx:paragraph -->

					<!-- nx:paragraph {"className":"is-style-text-annotation"} -->
					<p class="is-style-text-annotation"><a href="#"><?php echo esc_html_x( 'Apple Podcasts', 'Button text', 'twentytwentyfive' ); ?></a></p>
					<!-- /nx:paragraph -->

					<!-- nx:paragraph {"className":"is-style-text-annotation"} -->
					<p class="is-style-text-annotation"><a href="#"><?php echo esc_html_x( 'Spotify', 'Button text', 'twentytwentyfive' ); ?></a></p>
					<!-- /nx:paragraph -->

					<!-- nx:paragraph {"className":"is-style-text-annotation"} -->
					<p class="is-style-text-annotation"><a href="#"><?php echo esc_html_x( 'Pocket Casts', 'Button text', 'twentytwentyfive' ); ?></a></p>
					<!-- /nx:paragraph -->

					<!-- nx:paragraph {"className":"is-style-text-annotation"} -->
					<p class="is-style-text-annotation"><a href="#"><?php echo esc_html_x( 'RSS', 'Button text', 'twentytwentyfive' ); ?></a></p>
					<!-- /nx:paragraph -->
				</div>
				<!-- /nx:group -->

			</div>
			<!-- /nx:group -->

		</div>
		<!-- /nx:column -->
	</div>
	<!-- /nx:columns -->
</div>
<!-- /nx:group -->
