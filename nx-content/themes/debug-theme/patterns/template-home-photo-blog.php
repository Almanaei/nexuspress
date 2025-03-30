<?php
/**
 * Title: Photo blog home
 * Slug: twentytwentyfive/template-home-photo-blog
 * Template Types: front-page, index, home
 * Viewport width: 1400
 * Inserter: no
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:template-part {"slug":"header"} /-->

<!-- nx:group {"tagName":"main","style":{"spacing":{"margin":{"top":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<main class="nx-block-group" style="margin-top:var(--nx--preset--spacing--60)">
	<!-- nx:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
	<div class="nx-block-group">
		<!-- nx:heading {"textAlign":"center","level":1,"className":"is-style-text-annotation"} -->
		<h1 class="nx-block-heading has-text-align-center is-style-text-annotation"><?php esc_html_e( 'Stories', 'twentytwentyfive' ); ?></h1>
		<!-- /nx:heading -->
	</div>
	<!-- /nx:group -->
	<!-- nx:heading {"textAlign":"center","align":"wide","fontSize":"xx-large"} -->
	<h2 class="nx-block-heading alignwide has-text-align-center has-xx-large-font-size"><?php esc_html_e( 'Tell your story', 'twentytwentyfive' ); ?></h2>
	<!-- /nx:heading -->
	<!-- nx:pattern {"slug":"twentytwentyfive/template-query-loop-photo-blog"} /-->
</main>
<!-- /nx:group -->

<!-- nx:template-part {"slug":"footer"} /-->
