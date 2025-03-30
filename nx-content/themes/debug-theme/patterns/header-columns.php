<?php
/**
 * Title: Header with columns
 * Slug: twentytwentyfive/header-columns
 * Categories: header
 * Block Types: core/template-part/header
 * Description: Header with site title and navigation in columns.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"layout":{"type":"constrained"}} -->
<div class="nx-block-group">
	<!-- nx:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|60"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"top"}} -->
	<div class="nx-block-group alignwide" style="padding-top:var(--nx--preset--spacing--40);padding-bottom:var(--nx--preset--spacing--60)">
		<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20","padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"layout":{"type":"constrained"}} -->
		<div class="nx-block-group" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0">
			<!-- nx:site-title {"level":0} /-->
			<!-- nx:site-tagline /-->
		</div>
		<!-- /nx:group -->
		<!-- nx:group {"layout":{"type":"constrained","justifyContent":"left"}} -->
		<div class="nx-block-group">
			<!-- nx:navigation {"overlayBackgroundColor":"base","overlayTextColor":"contrast","layout":{"type":"flex","orientation":"vertical"}} /-->
		</div>
		<!-- /nx:group -->
		<!-- nx:site-logo /-->
	</div>
	<!-- /nx:group -->
</div>
<!-- /nx:group -->
