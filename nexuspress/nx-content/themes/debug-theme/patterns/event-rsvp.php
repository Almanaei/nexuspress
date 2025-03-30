<?php
/**
 * Title: Event RSVP
 * Slug: twentytwentyfive/event-rsvp
 * Keywords: call-to-action, rsvp, event
 * Categories: call-to-action
 * Block Types: core/post-content
 * Viewport width: 1400
 * Description: RSVP for an upcoming event with a cover image and event details.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"align":"full","style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"}}},"layout":{"type":"default"}} -->
<div class="nx-block-group alignfull" style="margin-top:0;margin-bottom:0">
	<!-- nx:columns {"isStackedOnMobile":false,"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|80","left":"var:preset|spacing|40","right":"var:preset|spacing|40"},"margin":{"top":"0","bottom":"0"}}}} -->
	<div class="nx-block-columns alignfull is-not-stacked-on-mobile" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--40);padding-right:var(--nx--preset--spacing--40);padding-bottom:var(--nx--preset--spacing--80);padding-left:var(--nx--preset--spacing--40)">
		<!-- nx:column {"width":"66.66%"} -->
		<div class="nx-block-column" style="flex-basis:66.66%">
			<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
			<div class="nx-block-group">
				<!-- nx:heading {"fontSize":"xx-large"} -->
				<h2 class="nx-block-heading has-xx-large-font-size">
					<?php
					echo nx_kses_post(
						/* translators: This string contains the word "Stories" in four different languages with the first item in the locale's language. */
						_x( '“Stories, <span lang="es">historias</span>, <span lang="uk">iсторії</span>, <span lang="el">iστορίες</span>”', 'Placeholder heading in four languages.', 'twentytwentyfive' )
					);
					?>
				</h2>
				<!-- /nx:heading -->

				<!-- nx:paragraph {"fontSize":"x-large"} -->
				<p class="has-x-large-font-size"><?php echo esc_html_x( 'Mon, Jan 1', 'Example event date in pattern.', 'twentytwentyfive' ); ?></p>
				<!-- /nx:paragraph -->

				<!-- nx:spacer {"height":"0px","style":{"layout":{"selfStretch":"fixed","flexSize":"140px"}}} -->
				<div style="height:0px" aria-hidden="true" class="nx-block-spacer"></div>
				<!-- /nx:spacer -->
			</div>
			<!-- /nx:group -->
		</div>
		<!-- /nx:column -->

		<!-- nx:column {"width":"12vw"} -->
		<div class="nx-block-column" style="flex-basis:12vw"></div>
		<!-- /nx:column -->

		<!-- nx:column -->
		<div class="nx-block-column">
			<!-- nx:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}} -->
			<div class="nx-block-group">
				<!-- nx:paragraph {"align":"left","style":{"typography":{"writingMode":"vertical-rl","textTransform":"uppercase","lineHeight":"0.6"}}} -->
				<p class="has-text-align-left" style="line-height:0.6;text-transform:uppercase;writing-mode:vertical-rl"><?php esc_html_e( 'Free Workshop', 'twentytwentyfive' ); ?></p>
				<!-- /nx:paragraph -->
			</div>
			<!-- /nx:group -->
		</div>
		<!-- /nx:column -->
	</div>
	<!-- /nx:columns -->

	<!-- nx:columns {"align":"full","className":"is-style-section-2","style":{"spacing":{"blockGap":{"top":"0","left":"0"},"padding":{"top":"0","bottom":"0"}}}} -->
	<div class="nx-block-columns alignfull is-style-section-2" style="padding-top:0;padding-bottom:0">
		<!-- nx:column {"width":"50%"} -->
		<div class="nx-block-column" style="flex-basis:50%">
			<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20","padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}},"dimensions":{"minHeight":"33vh"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch","verticalAlignment":"space-between"}} -->
			<div class="nx-block-group" style="min-height:33vh;padding-top:var(--nx--preset--spacing--50);padding-right:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50);padding-left:var(--nx--preset--spacing--50)">
				<!-- nx:paragraph -->
				<p><?php esc_html_e( 'This immersive event celebrates the universal human experience through the lenses of history and ancestry, featuring a diverse array of photographers whose works capture the essence of different cultures and historical moments.', 'twentytwentyfive' ); ?></p>
				<!-- /nx:paragraph -->

				<!-- nx:spacer {"height":"0px","style":{"layout":{"flexSize":"100px","selfStretch":"fixed"}}} -->
				<div style="height:0px" aria-hidden="true" class="nx-block-spacer"></div>
				<!-- /nx:spacer -->

				<!-- nx:heading {"fontSize":"xx-large"} -->
				<h2 class="nx-block-heading has-xx-large-font-size"><a href="#"><?php echo esc_html_x( 'RSVP', 'Abbreviation for "Please respond".', 'twentytwentyfive' ); ?></a></h2>
				<!-- /nx:heading -->
			</div>
			<!-- /nx:group -->
		</div>
		<!-- /nx:column -->

		<!-- nx:column {"width":"50%"} -->
		<div class="nx-block-column" style="flex-basis:50%">
			<!-- nx:cover {"url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/botany-flowers-closeup.webp","dimRatio":0,"isDark":false} -->
			<div class="nx-block-cover is-light"><span aria-hidden="true" class="nx-block-cover__background has-background-dim-0 has-background-dim"></span><img class="nx-block-cover__image-background" alt="<?php esc_attr_e( 'Close up photo of white flowers on a grey background', 'twentytwentyfive' ); ?>" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/botany-flowers-closeup.webp" data-object-fit="cover"/>
			<div class="nx-block-cover__inner-container">
				<!-- nx:spacer {"height":"var:preset|spacing|20"} -->
				<div style="height:var(--nx--preset--spacing--20)" aria-hidden="true" class="nx-block-spacer"></div>
				<!-- /nx:spacer -->
			</div></div>
			<!-- /nx:cover -->
		</div>
		<!-- /nx:column -->
	</div>
	<!-- /nx:columns -->
</div>
<!-- /nx:group -->
