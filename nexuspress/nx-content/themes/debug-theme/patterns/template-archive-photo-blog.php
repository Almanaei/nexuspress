<?php
/**
 * Title: Photo blog archive
 * Slug: twentytwentyfive/template-archive-photo-blog
 * Template Types: archive
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
	<!-- nx:query-title {"type":"archive","textAlign":"center"} /-->
	<!-- nx:term-description {"textAlign":"center"} /-->
	<!-- nx:pattern {"slug":"twentytwentyfive/template-query-loop-photo-blog"} /-->
</main>
<!-- /nx:group -->

<!-- nx:template-part {"slug":"footer"} /-->
