<?php
/**
 * Title: Text-only blog, search
 * Slug: twentytwentyfive/template-search-text-blog
 * Template Types: search
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
	<!-- nx:group {"align":"wide","layout":{"type":"default"}} -->
	<div class="nx-block-group alignwide">
		<!-- nx:query-title {"type":"search","align":"wide","fontSize":"x-large"} /-->
		<!-- nx:pattern {"slug":"twentytwentyfive/hidden-search"} /-->
	</div>
	<!-- /nx:group -->
	<!-- nx:spacer {"height":"var:preset|spacing|50"} -->
	<div style="height:var(--nx--preset--spacing--50)" aria-hidden="true" class="nx-block-spacer"></div>
	<!-- /nx:spacer -->
	<!-- nx:pattern {"slug":"twentytwentyfive/template-query-loop-text-blog"} /-->
</main>
<!-- /nx:group -->

<!-- nx:template-part {"slug":"footer"} /-->
