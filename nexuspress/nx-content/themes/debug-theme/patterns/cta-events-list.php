<?php
/**
 * Title: Events list
 * Slug: twentytwentyfive/cta-events-list
 * Categories: call-to-action
 * Description: A list of events with call to action.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50)">
	<!-- nx:group {"align":"wide","layout":{"type":"default"}} -->
	<div class="nx-block-group alignwide">
		<!-- nx:heading -->
		<h2 class="nx-block-heading"><?php esc_html_e( 'Upcoming events', 'twentytwentyfive' ); ?></h2>
		<!-- /nx:heading -->

		<!-- nx:paragraph -->
		<p><?php esc_html_e( 'These are some of the upcoming events', 'twentytwentyfive' ); ?></p>
		<!-- /nx:paragraph -->

		<!-- nx:group {"style":{"spacing":{"blockGap":"0","margin":{"top":"var:preset|spacing|70"}}},"layout":{"type":"default"}} -->
		<div class="nx-block-group" style="margin-top:var(--nx--preset--spacing--70)">
			<!-- nx:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
			<div class="nx-block-group" style="padding-top:var(--nx--preset--spacing--40);padding-bottom:var(--nx--preset--spacing--40)">
				<!-- nx:group {"layout":{"type":"constrained"}} -->
				<div class="nx-block-group">
					<!-- nx:heading {"level":3} -->
					<h3 class="nx-block-heading"><?php esc_html_e( 'Tell your story', 'twentytwentyfive' ); ?></h3>
					<!-- /nx:heading -->

					<!-- nx:paragraph -->
					<p><?php esc_html_e( 'Atlanta, GA, USA', 'twentytwentyfive' ); ?></p>
					<!-- /nx:paragraph -->
				</div>
				<!-- /nx:group -->

				<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|70"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
				<div class="nx-block-group">
					<!-- nx:paragraph {"style":{"typography":{"textTransform":"uppercase"}}} -->
					<p style="text-transform:uppercase"><?php echo esc_html_x( 'Mon, Jan 1', 'Example event date in pattern.', 'twentytwentyfive' ); ?></p>
					<!-- /nx:paragraph -->

					<!-- nx:buttons -->
					<div class="nx-block-buttons">
						<!-- nx:button {"fontSize":"small"} -->
						<div class="nx-block-button has-custom-font-size has-small-font-size"><a class="nx-block-button__link nx-element-button"><?php esc_html_e( 'Buy Tickets', 'twentytwentyfive' ); ?></a></div>
						<!-- /nx:button -->
					</div>
					<!-- /nx:buttons -->
				</div>
				<!-- /nx:group -->
			</div>
			<!-- /nx:group -->

			<!-- nx:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}},"border":{"top":{"color":"var:preset|color|accent-6","width":"1px"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
			<div class="nx-block-group" style="border-top-color:var(--nx--preset--color--accent-6);border-top-width:1px;padding-top:var(--nx--preset--spacing--40);padding-bottom:var(--nx--preset--spacing--40)"><!-- nx:group {"layout":{"type":"constrained"}} -->
				<div class="nx-block-group">
					<!-- nx:heading {"level":3} -->
					<h3 class="nx-block-heading">
						<?php
						echo nx_kses_post(
							/* translators: This string contains the word "Stories" in four different languages with the first item in the locale's language. */
							_x( '“Stories, <span lang="es">historias</span>, <span lang="uk">iсторії</span>, <span lang="el">iστορίες</span>”', 'Placeholder heading in four languages.', 'twentytwentyfive' )
						);
						?>
					</h3>
					<!-- /nx:heading -->

					<!-- nx:paragraph -->
					<p><?php esc_html_e( 'Mexico City, Mexico', 'twentytwentyfive' ); ?></p>
					<!-- /nx:paragraph -->
				</div>
				<!-- /nx:group -->

				<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|70"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
				<div class="nx-block-group">
					<!-- nx:paragraph {"style":{"typography":{"textTransform":"uppercase"}}} -->
					<p style="text-transform:uppercase"><?php echo esc_html_x( 'Mon, Jan 1', 'Example event date in pattern.', 'twentytwentyfive' ); ?></p>
					<!-- /nx:paragraph -->

					<!-- nx:buttons -->
					<div class="nx-block-buttons">
						<!-- nx:button {"fontSize":"small"} -->
						<div class="nx-block-button has-custom-font-size has-small-font-size"><a class="nx-block-button__link nx-element-button"><?php esc_html_e( 'Buy Tickets', 'twentytwentyfive' ); ?></a></div>
						<!-- /nx:button -->
					</div>
					<!-- /nx:buttons -->
				</div>
				<!-- /nx:group -->
			</div>
			<!-- /nx:group -->

			<!-- nx:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}},"border":{"top":{"color":"var:preset|color|accent-6","width":"1px"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
			<div class="nx-block-group" style="border-top-color:var(--nx--preset--color--accent-6);border-top-width:1px;padding-top:var(--nx--preset--spacing--40);padding-bottom:var(--nx--preset--spacing--40)"><!-- nx:group {"layout":{"type":"constrained"}} -->
				<div class="nx-block-group">
					<!-- nx:heading {"level":3} -->
					<h3 class="nx-block-heading"><?php esc_html_e( 'Tell your story', 'twentytwentyfive' ); ?></h3>
					<!-- /nx:heading -->

					<!-- nx:paragraph -->
					<p><?php esc_html_e( 'Thornville, OH, USA', 'twentytwentyfive' ); ?></p>
					<!-- /nx:paragraph -->
				</div>
				<!-- /nx:group -->

				<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|70"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
				<div class="nx-block-group">
					<!-- nx:paragraph {"style":{"typography":{"textTransform":"uppercase"}}} -->
					<p style="text-transform:uppercase"><?php echo esc_html_x( 'Mon, Jan 1', 'Example event date in pattern.', 'twentytwentyfive' ); ?></p>
					<!-- /nx:paragraph -->

					<!-- nx:buttons -->
					<div class="nx-block-buttons">
						<!-- nx:button {"fontSize":"small"} -->
						<div class="nx-block-button has-custom-font-size has-small-font-size"><a class="nx-block-button__link nx-element-button"><?php esc_html_e( 'Buy Tickets', 'twentytwentyfive' ); ?></a></div>
						<!-- /nx:button -->
					</div>
					<!-- /nx:buttons -->
				</div>
				<!-- /nx:group -->
			</div>
			<!-- /nx:group -->

			<!-- nx:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}},"border":{"top":{"color":"var:preset|color|accent-6","width":"1px"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
			<div class="nx-block-group" style="border-top-color:var(--nx--preset--color--accent-6);border-top-width:1px;padding-top:var(--nx--preset--spacing--40);padding-bottom:var(--nx--preset--spacing--40)"><!-- nx:group {"layout":{"type":"constrained"}} -->
				<div class="nx-block-group">
					<!-- nx:heading {"level":3} -->
					<h3 class="nx-block-heading">
						<?php
						echo nx_kses_post(
							/* translators: This string contains the word "Stories" in four different languages with the first item in the locale's language. */
							_x( '“Stories, <span lang="es">historias</span>, <span lang="uk">iсторії</span>, <span lang="el">iστορίες</span>”', 'Placeholder heading in four languages.', 'twentytwentyfive' )
						);
						?>
					</h3>
					<!-- /nx:heading -->

					<!-- nx:paragraph -->
					<p><?php esc_html_e( 'Thornville, OH, USA', 'twentytwentyfive' ); ?></p>
					<!-- /nx:paragraph -->
				</div>
				<!-- /nx:group -->

				<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|70"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
				<div class="nx-block-group">
					<!-- nx:paragraph {"style":{"typography":{"textTransform":"uppercase"}}} -->
					<p style="text-transform:uppercase"><?php echo esc_html_x( 'Mon, Jan 1', 'Example event date in pattern.', 'twentytwentyfive' ); ?></p>
					<!-- /nx:paragraph -->

					<!-- nx:buttons -->
					<div class="nx-block-buttons">
						<!-- nx:button {"fontSize":"small"} -->
						<div class="nx-block-button has-custom-font-size has-small-font-size"><a class="nx-block-button__link nx-element-button"><?php esc_html_e( 'Buy Tickets', 'twentytwentyfive' ); ?></a></div>
						<!-- /nx:button -->
					</div>
					<!-- /nx:buttons -->
				</div>
				<!-- /nx:group -->
			</div>
			<!-- /nx:group -->
		</div>
		<!-- /nx:group -->
	</div>
	<!-- /nx:group -->
</div>
<!-- /nx:group -->
