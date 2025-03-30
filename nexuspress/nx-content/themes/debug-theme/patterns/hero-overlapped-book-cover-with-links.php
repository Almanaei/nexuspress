<?php
/**
 * Title: Hero, overlapped book cover with links
 * Slug: twentytwentyfive/hero-overlapped-book-cover-with-links
 * Categories: banner
 * Description: A hero with an overlapped book cover and links.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"align":"full","className":"is-style-section-1","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80","left":"var:preset|spacing|50","right":"var:preset|spacing|50"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group alignfull is-style-section-1" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--80);padding-right:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--80);padding-left:var(--nx--preset--spacing--50)">
	<!-- nx:group {"align":"wide","layout":{"type":"default"}} -->
	<div class="nx-block-group alignwide">
		<!-- nx:columns {"verticalAlignment":null,"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|80","left":"var:preset|spacing|80"}}}} -->
		<div class="nx-block-columns alignwide">
			<!-- nx:column {"verticalAlignment":"center","width":"55%"} -->
			<div class="nx-block-column is-vertically-aligned-center" style="flex-basis:55%">
				<!-- nx:group {"style":{"dimensions":{"minHeight":"100%"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"left","flexWrap":"nowrap","verticalAlignment":"top"}} -->
				<div class="nx-block-group" style="min-height:100%">
					<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
					<div class="nx-block-group">
						<!-- nx:heading {"fontSize":"xx-large"} -->
						<h2 class="nx-block-heading has-xx-large-font-size">
							<?php echo esc_html_x( 'The Stories Book', 'Hero - Overlapped book cover pattern headline text', 'twentytwentyfive' ); ?>
						</h2>
						<!-- /nx:heading -->

						<!-- nx:paragraph {"className":"is-style-text-subtitle"} -->
						<p class="is-style-text-subtitle">
							<?php echo esc_html_x( 'A fine collection of moments in time featuring photographs from Louis Fleckenstein, Paul Strand and Asahachi Kōno.', 'Hero - Overlapped book cover pattern subline text', 'twentytwentyfive' ); ?>
						</p>
						<!-- /nx:paragraph -->
					</div>
					<!-- /nx:group -->

					<!-- nx:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
					<div class="nx-block-group">
						<!-- nx:spacer {"style":{"layout":{"selfStretch":"fit","flexSize":null},"spacing":{"margin":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}}} -->
						<div style="margin-top:var(--nx--preset--spacing--20);margin-bottom:var(--nx--preset--spacing--20)" aria-hidden="true" class="nx-block-spacer"></div>
						<!-- /nx:spacer -->

						<!-- nx:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|20","left":"var:preset|spacing|20"}}}} -->
						<div class="nx-block-columns">
							<!-- nx:column {"verticalAlignment":"stretch"} -->
							<div class="nx-block-column is-vertically-aligned-stretch">
								<!-- nx:buttons {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"horizontal","flexWrap":"wrap","justifyContent":"space-between"}} -->
								<div class="nx-block-buttons">
									<!-- nx:button {"width":100,"className":"is-style-fill"} -->
									<div class="nx-block-button has-custom-width nx-block-button__width-100 is-style-fill">
										<a class="nx-block-button__link nx-element-button" href="#">
											<?php echo esc_html_x( 'Amazon', 'Example brand name.', 'twentytwentyfive' ); ?>
										</a>
									</div>
									<!-- /nx:button -->
									<!-- nx:button {"width":100,"className":"is-style-fill"} -->
									<div class="nx-block-button has-custom-width nx-block-button__width-100 is-style-fill">
										<a class="nx-block-button__link nx-element-button" href="#">
											<?php echo esc_html_x( 'Apple Books', 'Example brand name.', 'twentytwentyfive' ); ?>
										</a>
									</div>
									<!-- /nx:button -->
								</div>
								<!-- /nx:buttons -->
							</div>
							<!-- /nx:column -->
							<!-- nx:column {"verticalAlignment":"stretch"} -->
							<div class="nx-block-column is-vertically-aligned-stretch">
								<!-- nx:buttons {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"horizontal","flexWrap":"wrap","justifyContent":"space-between"}} -->
								<div class="nx-block-buttons">
									<!-- nx:button {"width":100,"className":"is-style-fill"} -->
									<div class="nx-block-button has-custom-width nx-block-button__width-100 is-style-fill">
										<a class="nx-block-button__link nx-element-button" href="#">
											<?php echo esc_html_x( 'Audible', 'Example brand name.', 'twentytwentyfive' ); ?>
										</a>
									</div>
									<!-- /nx:button -->
									<!-- nx:button {"width":100,"className":"is-style-fill"} -->
									<div class="nx-block-button has-custom-width nx-block-button__width-100 is-style-fill">
										<a class="nx-block-button__link nx-element-button" href="#">
											<?php echo esc_html_x( 'Barnes &amp; Noble', 'Example brand name.', 'twentytwentyfive' ); ?>
										</a>
									</div>
									<!-- /nx:button -->
								</div>
								<!-- /nx:buttons -->
							</div>
							<!-- /nx:column -->
						</div>
						<!-- /nx:columns -->

						<!-- nx:spacer {"style":{"layout":{"selfStretch":"fit","flexSize":null},"spacing":{"margin":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}}} -->
						<div style="margin-top:var(--nx--preset--spacing--20);margin-bottom:var(--nx--preset--spacing--20)" aria-hidden="true" class="nx-block-spacer"></div>
						<!-- /nx:spacer -->

						<!-- nx:paragraph {"fontSize":"medium"} -->
						<p class="has-medium-font-size"><?php echo nx_kses_post( _x( 'Outside Europe? View <a href="#" rel="nofollow">international editions</a>.', 'Pattern placeholder text with link.', 'twentytwentyfive' ) ); ?></p>
						<!-- /nx:paragraph -->
					</div>
					<!-- /nx:group -->
				</div>
				<!-- /nx:group -->
			</div>
			<!-- /nx:column -->

			<!-- nx:column {"verticalAlignment":"top","width":"45%"} -->
			<div class="nx-block-column is-vertically-aligned-top" style="flex-basis:45%">
				<!-- nx:image {"aspectRatio":"3/4","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
				<figure class="nx-block-image size-full">
					<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/book-image.webp" alt="<?php echo esc_attr__( 'Book Image', 'twentytwentyfive' ); ?>" style="aspect-ratio:3/4;object-fit:cover"/>
				</figure>
				<!-- /nx:image -->
			</div>
			<!-- /nx:column -->
		</div>
		<!-- /nx:columns -->
	</div>
	<!-- /nx:group -->
</div>
<!-- /nx:group -->
