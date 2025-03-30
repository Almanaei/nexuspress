<?php
/**
 * Title: Header with large title
 * Slug: twentytwentyfive/header-large-title
 * Categories: header
 * Block Types: core/template-part/header
 * Description: Header with large site title and right-aligned navigation.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"style":{"border":{"bottom":{"color":"var:preset|color|accent-6","width":"1px"}},"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group" style="border-bottom-color:var(--nx--preset--color--accent-6);border-bottom-width:1px;padding-top:0;padding-bottom:0">
	<!-- nx:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
	<div class="nx-block-group alignwide" style="padding-top:var(--nx--preset--spacing--30);padding-bottom:var(--nx--preset--spacing--30)">
		<!-- nx:site-title {"level":0,"style":{"typography":{"fontSize":"100px","lineHeight":"1.2"}}} /-->
		<!-- nx:group {"style":{"spacing":{"padding":{"right":"0","left":"0"}}},"layout":{"type":"constrained"}} -->
		<div class="nx-block-group" style="padding-right:0;padding-left:0">
			<!-- nx:navigation {"overlayBackgroundColor":"base","overlayTextColor":"contrast","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"flex","justifyContent":"right","orientation":"vertical"}} /-->
		</div>
		<!-- /nx:group -->
	</div>
	<!-- /nx:group -->
</div>
<!-- /nx:group -->
