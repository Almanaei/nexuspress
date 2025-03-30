<?php
/**
 * Title: Heading and search form
 * Slug: twentytwentyfive/cta-heading-search
 * Categories: call-to-action
 * Description: Large heading with a search form for quick navigation.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|50","padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group alignwide" style="padding-top:var(--nx--preset--spacing--80);padding-bottom:var(--nx--preset--spacing--80)"><!-- nx:group {"align":"wide","layout":{"type":"default"}} -->
	<div class="nx-block-group alignwide">
		<!-- nx:heading {"fontSize":"xx-large"} -->
		<h2 class="nx-block-heading has-xx-large-font-size"><?php esc_html_e( 'What are you looking for?', 'twentytwentyfive' ); ?></h2>
		<!-- /nx:heading -->

		<!-- nx:search {"label":"<?php echo esc_html_x( 'Search', 'Search form label.', 'twentytwentyfive' ); ?>","showLabel":false,"placeholder":"<?php echo esc_attr_x( 'Type here...', 'Search input field placeholder text.', 'twentytwentyfive' ); ?>","buttonText":"<?php echo esc_attr_x( 'Search', 'Button text. Verb.', 'twentytwentyfive' ); ?>"} /-->
	</div>
	<!-- /nx:group -->
</div>
<!-- /nx:group -->
