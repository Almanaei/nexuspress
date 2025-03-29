<?php
/**
 * Title: Link in bio with profile, links and wide margins
 * Slug: twentytwentyfive/page-link-in-bio-wide-margins
 * Categories: twentytwentyfive_page, banner, featured
 * Keywords: starter
 * Block Types: core/post-content
 * Viewport width: 1400
 * Description: A link in bio landing page with social links, a profile photo and a brief description.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"align":"full","className":"is-style-section-1","style":{"dimensions":{"minHeight":"100vh"},"spacing":{"padding":{"right":"var:preset|spacing|80","left":"var:preset|spacing|80","top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group alignfull is-style-section-1" style="min-height:100vh;margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--80);padding-right:var(--nx--preset--spacing--80);padding-bottom:var(--nx--preset--spacing--80);padding-left:var(--nx--preset--spacing--80)">
	<!-- nx:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|60"}}}} -->
	<div class="nx-block-columns alignwide are-vertically-aligned-center">
		<!-- nx:column {"verticalAlignment":"center"} -->
		<div class="nx-block-column is-vertically-aligned-center">
			<!-- nx:image {"scale":"cover","sizeSlug":"full","linkDestination":"none","align":"center","style":{"border":{"radius":{"topLeft":"150px","bottomRight":"150px"}}}} -->
			<figure class="nx-block-image aligncenter size-full has-custom-border"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/woman-splashing-water.webp" alt="<?php esc_attr_e( 'Woman on beach, splashing water.', 'twentytwentyfive' ); ?>" style="border-top-left-radius:150px;border-bottom-right-radius:150px;object-fit:cover"/></figure>
			<!-- /nx:image -->
		</div>
		<!-- /nx:column -->

		<!-- nx:column {"verticalAlignment":"center"} -->
		<div class="nx-block-column is-vertically-aligned-center">
			<!-- nx:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
			<div class="nx-block-group">
				<!-- nx:heading {"textAlign":"left"} -->
				<h2 class="nx-block-heading has-text-align-left"><?php esc_html_e( 'Nora Winslow Keene', 'twentytwentyfive' ); ?></h2>
				<!-- /nx:heading -->

				<!-- nx:paragraph -->
				<p><?php echo esc_html_x( 'I’m Nora, a dedicated public interest attorney based in Denver. I’m a graduate of Stanford University.', 'Pattern placeholder text.', 'twentytwentyfive' ); ?></p>
				<!-- /nx:paragraph -->

				<!-- nx:social-links {"iconColor":"currentColor","iconColorValue":"currentColor","className":"is-style-logos-only"} -->
				<ul class="nx-block-social-links has-icon-color is-style-logos-only">
					<!-- nx:social-link {"url":"#","service":"x"} /-->

					<!-- nx:social-link {"url":"#","service":"instagram"} /-->

					<!-- nx:social-link {"url":"#","service":"whatsapp"} /-->
				</ul>
				<!-- /nx:social-links -->
			</div>
			<!-- /nx:group -->
		</div>
		<!-- /nx:column -->
	</div>
	<!-- /nx:columns -->
</div>
<!-- /nx:group -->
