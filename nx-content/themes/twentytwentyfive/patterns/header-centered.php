<?php
/**
 * Title: Centered header
 * Slug: twentytwentyfive/header-centered
 * Categories: header
 * Block Types: core/template-part/header
 * Description: Header with centered site title and navigation.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"layout":{"type":"constrained"}} -->
<div class="nx-block-group">
	<!-- nx:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|30"}}},"layout":{"type":"constrained"}} -->
	<div class="nx-block-group alignwide" style="padding-top:var(--nx--preset--spacing--60);padding-bottom:var(--nx--preset--spacing--30)">
		<!-- nx:site-title {"level":0,"textAlign":"center","align":"wide","fontSize":"x-large"} /-->
		<!-- nx:group {"align":"wide","layout":{"type":"constrained"}} -->
		<div class="nx-block-group alignwide">
			<!-- nx:navigation {"overlayBackgroundColor":"base","overlayTextColor":"contrast","layout":{"type":"flex","justifyContent":"center"}} /-->
		</div>
		<!-- /nx:group -->
	</div>
	<!-- /nx:group -->
</div>
<!-- /nx:group -->
