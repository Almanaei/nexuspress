<?php
/**
 * Title: Text-only blog, archive
 * Slug: twentytwentyfive/template-archive-text-blog
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
	<!-- nx:query-title {"type":"archive","align":"wide","fontSize":"x-large"} /-->
	<!-- nx:term-description {"align":"wide"} /-->
	<!-- nx:spacer {"height":"var:preset|spacing|50"} -->
	<div style="height:var(--nx--preset--spacing--50)" aria-hidden="true" class="nx-block-spacer"></div>
	<!-- /nx:spacer -->
	<!-- nx:pattern {"slug":"twentytwentyfive/template-query-loop-text-blog"} /-->
</main>
<!-- /nx:group -->

<!-- nx:template-part {"slug":"footer"} /-->
