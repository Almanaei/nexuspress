<?php
/**
 * Title: 404
 * Slug: twentytwentyfive/hidden-404
 * Inserter: no
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"style":{"spacing":{"padding":{"right":"0","left":"0"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group" style="padding-right:0;padding-left:0">
	<!-- nx:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|50","left":"var:preset|spacing|50"}}}} -->
	<div class="nx-block-columns alignwide">
		<!-- nx:column -->
		<div class="nx-block-column">
			<!-- nx:image {"scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
			<figure class="nx-block-image size-full">
				<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/404-image.webp" alt="<?php echo esc_attr_x( 'Small totara tree on ridge above Long Point', 'image description', 'twentytwentyfive' ); ?>" style="object-fit:cover"/>
			</figure>
			<!-- /nx:image -->
		</div>
		<!-- /nx:column -->
		<!-- nx:column {"verticalAlignment":"bottom"} -->
		<div class="nx-block-column is-vertically-aligned-bottom">
			<!-- nx:group {"layout":{"type":"default"}} -->
			<div class="nx-block-group">
				<!-- nx:heading {"level":1} -->
				<h1 class="nx-block-heading">
					<?php echo esc_html_x( 'Page not found', '404 error message', 'twentytwentyfive' ); ?>
				</h1>
				<!-- /nx:heading -->
				<!-- nx:paragraph -->
				<p><?php echo esc_html_x( 'The page you are looking for doesn\'t exist, or it has been moved. Please try searching using the form below.', '404 error message', 'twentytwentyfive' ); ?></p>
				<!-- /nx:paragraph -->
				<!-- nx:pattern {"slug":"twentytwentyfive/hidden-search"} /-->
			</div>
			<!-- /nx:group -->
		</div>
		<!-- /nx:column -->
	</div>
	<!-- /nx:columns -->
</div>
<!-- /nx:group -->
