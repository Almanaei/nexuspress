<?php
/**
 * Title: Written by
 * Slug: twentytwentyfive/hidden-written-by
 * Inserter: no
 *
 * @package    NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since      Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"style":{"spacing":{"blockGap":"0.2em","margin":{"bottom":"var:preset|spacing|60"}}},"textColor":"accent-4","fontSize":"small","layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="nx-block-group has-accent-4-color has-text-color has-link-color has-small-font-size" style="margin-bottom:var(--nx--preset--spacing--60)">
	<!-- nx:paragraph -->
	<p><?php esc_html_e( 'Written by ', 'twentytwentyfive' ); ?></p>
	<!-- /nx:paragraph -->
	<!-- nx:post-author-name {"isLink":true} /-->
	<!-- nx:paragraph -->
	<p><?php esc_html_e( 'in', 'twentytwentyfive' ); ?></p>
	<!-- /nx:paragraph -->
	<!-- nx:post-terms {"term":"category","style":{"typography":{"fontWeight":"300"}}} /-->
</div>
<!-- /nx:group -->
