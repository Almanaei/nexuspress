<?php
/**
 * Title: Events, 3 columns with event images and titles
 * Slug: twentytwentyfive/event-3-col
 * Categories: banner
 * Description: A header with title and text and three columns that show 3 events with their images and titles.
 * Keywords: events, columns, images
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"},"blockGap":"0","margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50)">
	<!-- nx:group {"align":"wide","layout":{"type":"constrained","justifyContent":"left"}} -->
	<div class="nx-block-group alignwide">
		<!-- nx:heading {"fontSize":"x-large"} -->
		<h2 class="nx-block-heading has-x-large-font-size"><?php esc_html_e( 'Events', 'twentytwentyfive' ); ?></h2>
		<!-- /nx:heading -->

		<!-- nx:paragraph -->
		<p><?php esc_html_e( 'These are some of the upcoming events.', 'twentytwentyfive' ); ?></p>
		<!-- /nx:paragraph -->
	</div>
	<!-- /nx:group -->

	<!-- nx:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"0","left":"var:preset|spacing|50"},"padding":{"top":"0","bottom":"0"}}}} -->
	<div class="nx-block-columns alignwide" style="padding-top:0;padding-bottom:0">
		<!-- nx:column {"style":{"spacing":{"padding":{"top":"var:preset|spacing|70"},"blockGap":"0"}}} -->
		<div class="nx-block-column" style="padding-top:var(--nx--preset--spacing--70)">
			<!-- nx:image {"sizeSlug":"full","linkDestination":"none"} -->
			<figure class="nx-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/ruins-image.webp' ); ?>" alt="<?php esc_attr_e( 'Event image', 'twentytwentyfive' ); ?>"/></figure>
			<!-- /nx:image -->

			<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20","padding":{"top":"var:preset|spacing|30"}}},"layout":{"type":"flex","orientation":"vertical"}} -->
			<div class="nx-block-group" style="padding-top:var(--nx--preset--spacing--30)">
				<!-- nx:heading {"level":3,"style":{"spacing":{"padding":{"top":"var:preset|spacing|20"}}}} -->
				<h3 class="nx-block-heading" style="padding-top:var(--nx--preset--spacing--20)"><?php esc_html_e( 'Tell your story', 'twentytwentyfive' ); ?></h3>
				<!-- /nx:heading -->

				<!-- nx:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-4"}}}},"textColor":"accent-4","fontSize":"medium"} -->
				<p class="has-accent-4-color has-text-color has-link-color has-medium-font-size"><?php echo esc_html_x( 'Mon, Jan 1', 'Example event date in pattern.', 'twentytwentyfive' ); ?></p>
				<!-- /nx:paragraph -->
			</div>
			<!-- /nx:group -->

			<!-- nx:paragraph {"style":{"spacing":{"padding":{"top":"var:preset|spacing|40"}}}} -->
			<p style="padding-top:var(--nx--preset--spacing--40)"><a href="#"><?php esc_html_e( 'Event details', 'twentytwentyfive' ); ?></a></p>
			<!-- /nx:paragraph -->
		</div>
		<!-- /nx:column -->

		<!-- nx:column {"style":{"spacing":{"padding":{"top":"var:preset|spacing|70"},"blockGap":"0"}}} -->
		<div class="nx-block-column" style="padding-top:var(--nx--preset--spacing--70)">
			<!-- nx:image {"sizeSlug":"full","linkDestination":"none"} -->
			<figure class="nx-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/ruins-image.webp' ); ?>" alt="<?php esc_attr_e( 'Event image', 'twentytwentyfive' ); ?>"/></figure>
			<!-- /nx:image -->

			<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20","padding":{"top":"var:preset|spacing|30"}}},"layout":{"type":"flex","orientation":"vertical"}} -->
			<div class="nx-block-group" style="padding-top:var(--nx--preset--spacing--30)">
				<!-- nx:heading {"level":3,"style":{"spacing":{"padding":{"top":"var:preset|spacing|20"}}}} -->
				<h3 class="nx-block-heading" style="padding-top:var(--nx--preset--spacing--20)"><?php esc_html_e( 'Tell your story', 'twentytwentyfive' ); ?></h3>
				<!-- /nx:heading -->

				<!-- nx:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-4"}}}},"textColor":"accent-4","fontSize":"medium"} -->
				<p class="has-accent-4-color has-text-color has-link-color has-medium-font-size"><?php echo esc_html_x( 'Mon, Jan 1', 'Example event date in pattern.', 'twentytwentyfive' ); ?></p>
				<!-- /nx:paragraph -->
			</div>
			<!-- /nx:group -->

			<!-- nx:paragraph {"style":{"spacing":{"padding":{"top":"var:preset|spacing|40"}}}} -->
			<p style="padding-top:var(--nx--preset--spacing--40)"><a href="#"><?php esc_html_e( 'Event details', 'twentytwentyfive' ); ?></a></p>
			<!-- /nx:paragraph -->
		</div>
		<!-- /nx:column -->

		<!-- nx:column {"style":{"spacing":{"padding":{"top":"var:preset|spacing|70"},"blockGap":"0"}}} -->
		<div class="nx-block-column" style="padding-top:var(--nx--preset--spacing--70)">
			<!-- nx:image {"sizeSlug":"full","linkDestination":"none"} -->
			<figure class="nx-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/ruins-image.webp' ); ?>" alt="<?php esc_attr_e( 'Event image', 'twentytwentyfive' ); ?>"/></figure>
			<!-- /nx:image -->

			<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20","padding":{"top":"var:preset|spacing|30"}}},"layout":{"type":"flex","orientation":"vertical"}} -->
			<div class="nx-block-group" style="padding-top:var(--nx--preset--spacing--30)">
				<!-- nx:heading {"level":3,"style":{"spacing":{"padding":{"top":"var:preset|spacing|20"}}}} -->
				<h3 class="nx-block-heading" style="padding-top:var(--nx--preset--spacing--20)"><?php esc_html_e( 'Tell your story', 'twentytwentyfive' ); ?></h3>
				<!-- /nx:heading -->

				<!-- nx:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-4"}}}},"textColor":"accent-4","fontSize":"medium"} -->
				<p class="has-accent-4-color has-text-color has-link-color has-medium-font-size"><?php echo esc_html_x( 'Mon, Jan 1', 'Example event date in pattern.', 'twentytwentyfive' ); ?></p>
				<!-- /nx:paragraph -->
			</div>
			<!-- /nx:group -->

			<!-- nx:paragraph {"style":{"spacing":{"padding":{"top":"var:preset|spacing|40"}}}} -->
			<p style="padding-top:var(--nx--preset--spacing--40)"><a href="#"><?php esc_html_e( 'Event details', 'twentytwentyfive' ); ?></a></p>
			<!-- /nx:paragraph -->
		</div>
		<!-- /nx:column -->
	</div>
	<!-- /nx:columns -->
</div>
<!-- /nx:group -->
