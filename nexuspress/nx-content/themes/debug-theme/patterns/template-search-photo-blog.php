<?php
/**
 * Title: Photo blog search results
 * Slug: twentytwentyfive/template-search-photo-blog
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
	<!-- nx:query-title {"type":"search","textAlign":"center","align":"wide"} /-->
	<!-- nx:group {"align":"wide","layout":{"type":"default"}} -->
	<div class="nx-block-group alignwide">
		<!-- nx:pattern {"slug":"twentytwentyfive/hidden-search"} /-->
	</div>
	<!-- /nx:group -->
	<!-- nx:pattern {"slug":"twentytwentyfive/template-query-loop-photo-blog"} /-->
</main>
<!-- /nx:group -->

<!-- nx:template-part {"slug":"footer"} /-->
