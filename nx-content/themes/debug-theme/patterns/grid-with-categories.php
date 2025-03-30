<?php
/**
 * Title: Grid with categories
 * Slug: twentytwentyfive/grid-with-categories
 * Categories: banner
 * Viewport width: 1400
 * Description: A grid section with different categories.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50)">
	<!-- nx:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"grid","minimumColumnWidth":"16rem"}} -->
	<div class="nx-block-group alignwide">
		<!-- nx:group {"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"center"}} -->
		<div class="nx-block-group">
			<!-- nx:heading {"fontSize":"x-large"} -->
			<h2 class="nx-block-heading has-x-large-font-size"><?php esc_html_e( 'Top Categories', 'twentytwentyfive' ); ?></h2>
			<!-- /nx:heading -->
		</div>
		<!-- /nx:group -->
		<!-- nx:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
		<div class="nx-block-group">
			<!-- nx:cover {"url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/category-anthuriums.webp","alt":"Close up of a red anthurium.","dimRatio":0,"customOverlayColor":"#833d3a","isUserOverlayColor":true,"layout":{"type":"constrained"}} -->
			<div class="nx-block-cover"><span aria-hidden="true" class="nx-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#833d3a"></span><img class="nx-block-cover__image-background" alt="<?php esc_attr_e( 'Close up of a red anthurium.', 'twentytwentyfive' ); ?>" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/category-anthuriums.webp" data-object-fit="cover"/><div class="nx-block-cover__inner-container">
				<!-- nx:spacer {"height":"var:preset|spacing|20"} -->
				<div style="height:var(--nx--preset--spacing--20)" aria-hidden="true" class="nx-block-spacer"></div>
				<!-- /nx:spacer -->
			</div></div>
			<!-- /nx:cover -->
			<!-- nx:paragraph {"align":"center"} -->
			<p class="has-text-align-center"><?php esc_html_e( 'Anthuriums', 'twentytwentyfive' ); ?></p>
			<!-- /nx:paragraph -->
		</div>
		<!-- /nx:group -->
		<!-- nx:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
		<div class="nx-block-group">
			<!-- nx:cover {"url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/category-cactus.webp","dimRatio":0,"customOverlayColor":"#828282","isUserOverlayColor":true,"isDark":false,"layout":{"type":"constrained"}} -->
			<div class="nx-block-cover is-light"><span aria-hidden="true" class="nx-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#828282"></span><img class="nx-block-cover__image-background" alt="" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/category-cactus.webp" data-object-fit="cover"/><div class="nx-block-cover__inner-container">
				<!-- nx:spacer {"height":"var:preset|spacing|20"} -->
				<div style="height:var(--nx--preset--spacing--20)" aria-hidden="true" class="nx-block-spacer"></div>
				<!-- /nx:spacer -->
			</div></div>
			<!-- /nx:cover -->
			<!-- nx:paragraph {"align":"center"} -->
			<p class="has-text-align-center"><?php esc_html_e( 'Cactus', 'twentytwentyfive' ); ?></p>
			<!-- /nx:paragraph -->
		</div>
		<!-- /nx:group -->
		<!-- nx:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
		<div class="nx-block-group">
			<!-- nx:cover {"url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/category-sunflowers.webp","dimRatio":0,"customOverlayColor":"#d6bc98","isUserOverlayColor":true,"isDark":false,"layout":{"type":"constrained"}} -->
			<div class="nx-block-cover is-light"><span aria-hidden="true" class="nx-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#d6bc98"></span><img class="nx-block-cover__image-background" alt="" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/category-sunflowers.webp" data-object-fit="cover"/><div class="nx-block-cover__inner-container">
				<!-- nx:spacer {"height":"var:preset|spacing|20"} -->
				<div style="height:var(--nx--preset--spacing--20)" aria-hidden="true" class="nx-block-spacer"></div>
				<!-- /nx:spacer -->
			</div></div>
			<!-- /nx:cover -->
			<!-- nx:paragraph {"align":"center"} -->
			<p class="has-text-align-center"><?php esc_html_e( 'Sunflowers', 'twentytwentyfive' ); ?></p>
			<!-- /nx:paragraph -->
		</div>
		<!-- /nx:group -->
	</div>
	<!-- /nx:group -->
</div>
<!-- /nx:group -->
