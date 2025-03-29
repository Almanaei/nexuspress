<?php
/**
 * Title: Centered link and social links
 * Slug: twentytwentyfive/contact-centered-social-link
 * Keywords: contact, faq, questions
 * Categories: contact
 * Description: Centered contact section with a prominent message and social media links.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>

<!-- nx:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"},"blockGap":"var:preset|spacing|50","margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--80);padding-bottom:var(--nx--preset--spacing--80)">
	<!-- nx:group {"align":"wide","layout":{"type":"default"}} -->
	<div class="nx-block-group alignwide">
		<!-- nx:paragraph {"align":"center","className":"is-style-text-display","style":{"typography":{"fontStyle":"normal","fontWeight":"400"}}} -->
		<p class="has-text-align-center is-style-text-display" style="font-style:normal;font-weight:400"><?php echo nx_kses_post( _x( 'Got questions? <br><a href="#" rel="nofollow">Feel free to reach out.</a>', 'Heading of the Contact social link pattern', 'twentytwentyfive' ) ); ?></p>
		<!-- /nx:paragraph -->

		<!-- nx:spacer {"height":"var:preset|spacing|40"} -->
		<div style="height:var(--nx--preset--spacing--40)" aria-hidden="true" class="nx-block-spacer"></div>
		<!-- /nx:spacer -->

		<!-- nx:social-links {"iconColor":"contrast","className":"has-icon-color is-style-logos-only","layout":{"type":"flex","justifyContent":"center"}} -->
		<ul class="nx-block-social-links has-icon-color is-style-logos-only">
			<!-- nx:social-link {"url":"#","service":"twitter"} /-->
			<!-- nx:social-link {"url":"#","service":"facebook"} /-->
			<!-- nx:social-link {"url":"#","service":"instagram"} /-->
			<!-- nx:social-link {"url":"#","service":"pinterest"} /-->
		</ul>
		<!-- /nx:social-links -->
	</div>
	<!-- /nx:group -->
</div>
<!-- /nx:group -->
