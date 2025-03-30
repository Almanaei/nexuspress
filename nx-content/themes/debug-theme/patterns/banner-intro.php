<?php
/**
 * Title: Intro with left-aligned description
 * Slug: twentytwentyfive/banner-intro
 * Categories: banner
 * Description: A large left-aligned heading with a brand name emphasized in bold.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--80);padding-bottom:var(--nx--preset--spacing--80)">
	<!-- nx:heading {"align":"wide","fontSize":"x-large"} -->
	<h2 class="nx-block-heading alignwide has-x-large-font-size">
		<?php
			printf(
				/* translators: %s is the brand name, e.g., 'Fleurs'. */
				esc_html_x( 'We\'re %s, our mission is to deliver exquisite flower arrangements that not only adorn living spaces but also inspire a deeper appreciation for natural beauty.', 'Pattern placeholder text.', 'twentytwentyfive' ),
				'<strong>' . esc_html_x( 'Fleurs', 'Example brand name.', 'twentytwentyfive' ) . '</strong>'
			);
			?>
	</h2>
	<!-- /nx:heading -->
</div>
<!-- /nx:group -->
