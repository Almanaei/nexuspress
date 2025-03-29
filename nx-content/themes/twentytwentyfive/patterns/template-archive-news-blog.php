<?php
/**
 * Title: News blog archive
 * Slug: twentytwentyfive/template-archive-news-blog
 * Template Types: archive
 * Viewport width: 1400
 * Inserter: no
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:template-part {"slug":"header-large-title"} /-->

<!-- nx:group {"tagName":"main","layout":{"type":"constrained"}} -->
<main class="nx-block-group">
	<!-- nx:group {"align":"wide","layout":{"type":"default"}} -->
	<div class="nx-block-group alignwide">
		<!-- nx:spacer {"height":"var:preset|spacing|80"} -->
		<div style="height:var(--nx--preset--spacing--80)" aria-hidden="true" class="nx-block-spacer"></div>
		<!-- /nx:spacer -->
		<!-- nx:query-title {"type":"archive"} /-->
		<!-- nx:term-description /-->
		<!-- nx:spacer {"height":"var:preset|spacing|40"} -->
		<div style="height:var(--nx--preset--spacing--40)" aria-hidden="true" class="nx-block-spacer"></div>
		<!-- /nx:spacer -->
	</div>
	<!-- /nx:group -->
	<!-- nx:group {"align":"wide","layout":{"type":"default"}} -->
	<div class="nx-block-group alignwide">
		<!-- nx:pattern {"slug":"twentytwentyfive/template-query-loop-news-blog"} /-->
	</div>
	<!-- /nx:group -->
</main>
<!-- /nx:group -->

<!-- nx:template-part {"slug":"footer-newsletter"} /-->
