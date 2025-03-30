<?php
/**
 * Title: Event schedule
 * Slug: twentytwentyfive/event-schedule
 * Categories: about
 * Description: A section with specified dates and times for an event.
 * Keywords: events, agenda, schedule, lectures
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--60);padding-bottom:var(--nx--preset--spacing--60)">
	<!-- nx:group {"align":"wide","layout":{"type":"default"}} -->
	<div class="nx-block-group alignwide">
		<!-- nx:heading {"fontSize":"xx-large"} -->
		<h2 class="nx-block-heading has-xx-large-font-size"><?php esc_html_e( 'Agenda', 'twentytwentyfive' ); ?></h2>
		<!-- /nx:heading -->
		<!-- nx:paragraph -->
		<p><?php esc_html_e( 'These are some of the upcoming events.', 'twentytwentyfive' ); ?></p>
		<!-- /nx:paragraph -->
		<!-- nx:spacer {"height":"var:preset|spacing|30"} -->
		<div style="height:var(--nx--preset--spacing--30)" aria-hidden="true" class="nx-block-spacer"></div>
		<!-- /nx:spacer -->
		<!-- nx:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}},"border":{"top":{"color":"var:preset|color|accent-6","width":"1px"}}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
		<div class="nx-block-group" style="border-top-color:var(--nx--preset--color--accent-6);border-top-width:1px;padding-top:var(--nx--preset--spacing--40);padding-bottom:var(--nx--preset--spacing--40)">
			<!-- nx:columns -->
			<div class="nx-block-columns">
				<!-- nx:column {"verticalAlignment":"top","width":"40%"} -->
				<div class="nx-block-column is-vertically-aligned-top" style="flex-basis:40%">
					<!-- nx:heading {"level":3} -->
					<h3 class="nx-block-heading"><?php echo esc_html_x( 'Mon, Jan 1', 'Example event date in pattern.', 'twentytwentyfive' ); ?></h3>
					<!-- /nx:heading -->
				</div>
				<!-- /nx:column -->
				<!-- nx:column {"verticalAlignment":"top","width":"60%"} -->
				<div class="nx-block-column is-vertically-aligned-top" style="flex-basis:60%">
					<!-- nx:columns {"isStackedOnMobile":false,"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|40","left":"var:preset|spacing|40"},"margin":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}}} -->
					<div class="nx-block-columns is-not-stacked-on-mobile" style="margin-top:var(--nx--preset--spacing--40);margin-bottom:var(--nx--preset--spacing--40)">
						<!-- nx:column {"width":"33.33%"} -->
						<div class="nx-block-column" style="flex-basis:33.33%">
							<!-- nx:image {"aspectRatio":"1","scale":"cover","sizeSlug":"full","linkDestination":"none","style":{"layout":{"selfStretch":"fixed","flexSize":"270px"}}} -->
							<figure class="nx-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/marshland-birds-square.webp" alt="<?php esc_attr_e( 'Birds on a lake.', 'twentytwentyfive' ); ?>" style="aspect-ratio:1;object-fit:cover"/></figure>
							<!-- /nx:image -->
						</div>
						<!-- /nx:column -->
						<!-- nx:column {"width":"66.66%"} -->
						<div class="nx-block-column" style="flex-basis:66.66%">
							<!-- nx:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
							<div class="nx-block-group">
								<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
								<div class="nx-block-group">
									<!-- nx:heading {"level":4} -->
									<h4 class="nx-block-heading"><a href="#"><?php esc_html_e( 'Fauna from North America and its characteristics', 'twentytwentyfive' ); ?></a></h4>
									<!-- /nx:heading -->
									<!-- nx:paragraph -->
									<p><?php echo esc_html_x( '9 AM — 11 AM', 'Example event time in pattern.', 'twentytwentyfive' ); ?></p>
									<!-- /nx:paragraph -->
								</div>
								<!-- /nx:group -->
								<!-- nx:paragraph {"fontSize":"small"} -->
								<p class="has-small-font-size"><?php echo nx_kses_post( _x( 'Lecture by <a href="#">Prof. Fiona Presley</a>', 'Pattern placeholder text with link.', 'twentytwentyfive' ) ); ?></p>
								<!-- /nx:paragraph -->
							</div>
							<!-- /nx:group -->
						</div>
						<!-- /nx:column -->
					</div>
					<!-- /nx:columns -->
					<!-- nx:columns {"isStackedOnMobile":false,"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|40","left":"var:preset|spacing|40"},"margin":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}}} -->
					<div class="nx-block-columns is-not-stacked-on-mobile" style="margin-top:var(--nx--preset--spacing--40);margin-bottom:var(--nx--preset--spacing--40)">
						<!-- nx:column {"width":"33.33%"} -->
						<div class="nx-block-column" style="flex-basis:33.33%">
							<!-- nx:image {"aspectRatio":"1","scale":"cover","sizeSlug":"full","linkDestination":"none","style":{"layout":{"selfStretch":"fixed","flexSize":"270px"}}} -->
							<figure class="nx-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/coral-square.webp" alt="<?php esc_attr_e( 'View of the deep ocean.', 'twentytwentyfive' ); ?>" style="aspect-ratio:1;object-fit:cover"/></figure>
							<!-- /nx:image -->
						</div>
						<!-- /nx:column -->
						<!-- nx:column {"width":"66.66%"} -->
						<div class="nx-block-column" style="flex-basis:66.66%">
							<!-- nx:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
							<div class="nx-block-group">
								<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
								<div class="nx-block-group">
									<!-- nx:heading {"level":4} -->
									<h4 class="nx-block-heading"><a href="#"><?php esc_html_e( 'Things you didn’t know about the deep ocean', 'twentytwentyfive' ); ?></a></h4>
									<!-- /nx:heading -->
									<!-- nx:paragraph -->
									<p><?php echo esc_html_x( '9 AM — 11 AM', 'Example event time in pattern.', 'twentytwentyfive' ); ?></p>
									<!-- /nx:paragraph -->
								</div>
								<!-- /nx:group -->
								<!-- nx:paragraph {"fontSize":"small"} -->
								<p class="has-small-font-size"><?php echo nx_kses_post( _x( 'Lecture by <a href="#">Prof. Fiona Presley</a>', 'Pattern placeholder text with link.', 'twentytwentyfive' ) ); ?></p>
								<!-- /nx:paragraph -->
							</div>
							<!-- /nx:group -->
						</div>
						<!-- /nx:column -->
					</div>
					<!-- /nx:columns -->
				</div>
				<!-- /nx:column -->
			</div>
			<!-- /nx:columns -->
		</div>
		<!-- /nx:group -->
		<!-- nx:spacer {"height":"var:preset|spacing|30"} -->
		<div style="height:var(--nx--preset--spacing--30)" aria-hidden="true" class="nx-block-spacer"></div>
		<!-- /nx:spacer -->
		<!-- nx:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}},"border":{"top":{"color":"var:preset|color|accent-6","width":"1px"}}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
		<div class="nx-block-group" style="border-top-color:var(--nx--preset--color--accent-6);border-top-width:1px;padding-top:var(--nx--preset--spacing--40);padding-bottom:var(--nx--preset--spacing--40)">
			<!-- nx:columns -->
			<div class="nx-block-columns">
				<!-- nx:column {"verticalAlignment":"top","width":"40%"} -->
				<div class="nx-block-column is-vertically-aligned-top" style="flex-basis:40%">
					<!-- nx:heading {"level":3} -->
					<h3 class="nx-block-heading"><?php echo esc_html_x( 'Mon, Jan 1', 'Example event date in pattern.', 'twentytwentyfive' ); ?></h3>
					<!-- /nx:heading -->
				</div>
				<!-- /nx:column -->
				<!-- nx:column {"verticalAlignment":"top","width":"60%"} -->
				<div class="nx-block-column is-vertically-aligned-top" style="flex-basis:60%">
					<!-- nx:columns {"isStackedOnMobile":false,"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|40","left":"var:preset|spacing|40"},"margin":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}}} -->
					<div class="nx-block-columns is-not-stacked-on-mobile" style="margin-top:var(--nx--preset--spacing--40);margin-bottom:var(--nx--preset--spacing--40)">
						<!-- nx:column {"width":"33.33%"} -->
						<div class="nx-block-column" style="flex-basis:33.33%">
							<!-- nx:image {"aspectRatio":"1","scale":"cover","sizeSlug":"full","linkDestination":"none","style":{"layout":{"selfStretch":"fixed","flexSize":"270px"}}} -->
							<figure class="nx-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/parthenon-square.webp" alt="<?php esc_attr_e( 'The Acropolis of Athens.', 'twentytwentyfive' ); ?>" style="aspect-ratio:1;object-fit:cover"/></figure>
							<!-- /nx:image -->
						</div>
						<!-- /nx:column -->
						<!-- nx:column {"width":"66.66%"} -->
						<div class="nx-block-column" style="flex-basis:66.66%"><!-- nx:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
							<div class="nx-block-group">
								<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
								<div class="nx-block-group">
									<!-- nx:heading {"level":4} -->
									<h4 class="nx-block-heading"><a href="#"><?php esc_html_e( 'Ancient buildings and symbols', 'twentytwentyfive' ); ?></a></h4>
									<!-- /nx:heading -->
									<!-- nx:paragraph -->
									<p><?php echo esc_html_x( '9 AM — 11 AM', 'Example event time in pattern.', 'twentytwentyfive' ); ?></p>
									<!-- /nx:paragraph -->
								</div>
								<!-- /nx:group -->
								<!-- nx:paragraph {"fontSize":"small"} -->
								<p class="has-small-font-size"><?php echo nx_kses_post( _x( 'Lecture by <a href="#">Prof. Fiona Presley</a>', 'Pattern placeholder text with link.', 'twentytwentyfive' ) ); ?></p>
								<!-- /nx:paragraph -->
							</div>
							<!-- /nx:group -->
						</div>
						<!-- /nx:column -->
					</div>
					<!-- /nx:columns -->
					<!-- nx:columns {"isStackedOnMobile":false,"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|40","left":"var:preset|spacing|40"},"margin":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}}} -->
					<div class="nx-block-columns is-not-stacked-on-mobile" style="margin-top:var(--nx--preset--spacing--40);margin-bottom:var(--nx--preset--spacing--40)">
						<!-- nx:column {"width":"33.33%"} -->
						<div class="nx-block-column" style="flex-basis:33.33%">
							<!-- nx:image {"aspectRatio":"1","scale":"cover","sizeSlug":"full","linkDestination":"none","style":{"layout":{"selfStretch":"fixed","flexSize":"270px"}}} -->
							<figure class="nx-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/agenda-img-4.webp" alt="<?php esc_attr_e( 'Black and white photo of an African woman.', 'twentytwentyfive' ); ?>" style="aspect-ratio:1;object-fit:cover"/></figure>
							<!-- /nx:image -->
						</div>
						<!-- /nx:column -->
						<!-- nx:column {"width":"66.66%"} -->
						<div class="nx-block-column" style="flex-basis:66.66%">
							<!-- nx:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
							<div class="nx-block-group">
								<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
								<div class="nx-block-group">
									<!-- nx:heading {"level":4} -->
									<h4 class="nx-block-heading"><a href="#"><?php esc_html_e( 'An introduction to African dialects', 'twentytwentyfive' ); ?></a></h4>
									<!-- /nx:heading -->
									<!-- nx:paragraph -->
									<p><?php echo esc_html_x( '9 AM — 11 AM', 'Example event time in pattern.', 'twentytwentyfive' ); ?></p>
									<!-- /nx:paragraph -->
								</div>
								<!-- /nx:group -->
								<!-- nx:paragraph {"fontSize":"small"} -->
								<p class="has-small-font-size"><?php echo nx_kses_post( _x( 'Lecture by <a href="#">Prof. Fiona Presley</a>', 'Pattern placeholder text with link.', 'twentytwentyfive' ) ); ?></p>
								<!-- /nx:paragraph -->
							</div>
							<!-- /nx:group -->
						</div>
						<!-- /nx:column -->
					</div>
					<!-- /nx:columns -->
				</div>
				<!-- /nx:column -->
			</div>
			<!-- /nx:columns -->
		</div>
		<!-- /nx:group -->
	</div>
	<!-- /nx:group -->
</div>
<!-- /nx:group -->
