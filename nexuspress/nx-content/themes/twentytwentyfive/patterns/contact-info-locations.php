<?php
/**
 * Title: Contact, info and locations
 * Slug: twentytwentyfive/contact-info-locations
 * Keywords: contact, location
 * Categories: contact
 * Viewport width: 1400
 * Description: Contact section with social media links, email, and multiple location details.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50)">
	<!-- nx:group {"align":"wide","layout":{"type":"constrained"}} -->
	<div class="nx-block-group alignwide">
		<!-- nx:heading {"textAlign":"left","align":"full","fontSize":"xx-large"} -->
		<h2 class="nx-block-heading alignfull has-text-align-left has-xx-large-font-size"><?php esc_html_e( 'How to get in touch with us', 'twentytwentyfive' ); ?></h2>
		<!-- /nx:heading -->

		<!-- nx:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"},"blockGap":"var:preset|spacing|50","margin":{"top":"var:preset|spacing|50"}},"border":{"top":{"color":"var:preset|color|accent-4","width":"1px"}}},"layout":{"type":"grid","minimumColumnWidth":"23rem"}} -->
		<div class="nx-block-group alignwide" style="border-top-color:var(--nx--preset--color--accent-4);border-top-width:1px;margin-top:var(--nx--preset--spacing--50);padding-top:var(--nx--preset--spacing--60);padding-bottom:var(--nx--preset--spacing--60)">
			<!-- nx:group {"style":{"layout":{"rowSpan":1,"columnSpan":2}},"layout":{"type":"flex","orientation":"vertical"}} -->
			<div class="nx-block-group">
				<!-- nx:heading {"level":3,"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"fontSize":"medium"} -->
				<h3 class="nx-block-heading has-medium-font-size" style="font-style:normal;font-weight:700"><?php esc_html_e( 'Social media', 'twentytwentyfive' ); ?></h3>
				<!-- /nx:heading -->
				<!-- nx:navigation {"overlayMenu":"never","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"fontSize":"medium","layout":{"type":"flex","orientation":"vertical"},"ariaLabel":"<?php esc_attr_e( 'Social media', 'twentytwentyfive' ); ?>"} -->
					<!-- nx:navigation-link {"label":"<?php echo esc_html_x( 'X', 'Refers to the social media platform formerly known as Twitter.', 'twentytwentyfive' ); ?>","url":"#"} /-->
					<!-- nx:navigation-link {"label":"<?php esc_html_e( 'Instagram', 'twentytwentyfive' ); ?>","url":"#"} /-->
					<!-- nx:navigation-link {"label":"<?php esc_html_e( 'Facebook', 'twentytwentyfive' ); ?>","url":"#"} /-->
					<!-- nx:navigation-link {"label":"<?php esc_html_e( 'TikTok', 'twentytwentyfive' ); ?>","url":"#"} /-->
				<!-- /nx:navigation -->
				<!-- nx:heading {"level":3,"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"fontSize":"medium"} -->
				<h3 class="nx-block-heading has-medium-font-size" style="font-style:normal;font-weight:700"><?php esc_html_e( 'Email', 'twentytwentyfive' ); ?></h3>
				<!-- /nx:heading -->
				<!-- nx:paragraph {"fontSize":"medium"} -->
				<p class="has-medium-font-size"><?php esc_html_e( 'example@example.com', 'twentytwentyfive' ); ?></p>
				<!-- /nx:paragraph -->
			</div>
			<!-- /nx:group -->

			<!-- nx:group {"layout":{"type":"grid","minimumColumnWidth":null,"columnCount":2}} -->
			<div class="nx-block-group">
				<!-- nx:group {"style":{"layout":{"columnSpan":1,"rowSpan":1}},"layout":{"type":"constrained"}} -->
				<div class="nx-block-group">
					<!-- nx:heading {"level":3,"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"fontSize":"medium"} -->
					<h3 class="nx-block-heading has-medium-font-size" style="font-style:normal;font-weight:700"><?php esc_html_e( 'New York', 'twentytwentyfive' ); ?></h3>
					<!-- /nx:heading -->
					<!-- nx:paragraph {"fontSize":"medium"} -->
					<p class="has-medium-font-size"><?php esc_html_e( '123 Example St. Manhattan, NY 10300 United States', 'twentytwentyfive' ); ?></p>
					<!-- /nx:paragraph -->
				</div>
				<!-- /nx:group -->

				<!-- nx:group {"style":{"layout":{"columnSpan":1,"rowSpan":1}},"layout":{"type":"constrained"}} -->
				<div class="nx-block-group">
					<!-- nx:heading {"level":3,"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"fontSize":"medium"} -->
					<h3 class="nx-block-heading has-medium-font-size" style="font-style:normal;font-weight:700"><?php esc_html_e( 'San Diego', 'twentytwentyfive' ); ?></h3>
					<!-- /nx:heading -->

					<!-- nx:paragraph {"fontSize":"medium"} -->
					<p class="has-medium-font-size"><?php esc_html_e( '123 Example St. Manhattan, NY 10300 United States', 'twentytwentyfive' ); ?></p>
					<!-- /nx:paragraph -->
				</div>
				<!-- /nx:group -->

				<!-- nx:group {"style":{"layout":{"columnSpan":1,"rowSpan":1}},"layout":{"type":"constrained"}} -->
				<div class="nx-block-group">
					<!-- nx:heading {"level":3,"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"fontSize":"medium"} -->
					<h3 class="nx-block-heading has-medium-font-size" style="font-style:normal;font-weight:700"><?php esc_html_e( 'Salt Lake City', 'twentytwentyfive' ); ?></h3>
					<!-- /nx:heading -->

					<!-- nx:paragraph {"fontSize":"medium"} -->
					<p class="has-medium-font-size"><?php esc_html_e( '123 Example St. Manhattan, NY 10300 United States', 'twentytwentyfive' ); ?></p>
					<!-- /nx:paragraph -->
				</div>
				<!-- /nx:group -->

				<!-- nx:group {"style":{"layout":{"columnSpan":1,"rowSpan":1}},"layout":{"type":"constrained"}} -->
				<div class="nx-block-group">
					<!-- nx:heading {"level":3,"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"fontSize":"medium"} -->
					<h3 class="nx-block-heading has-medium-font-size" style="font-style:normal;font-weight:700"><?php esc_html_e( 'Portland', 'twentytwentyfive' ); ?></h3>
					<!-- /nx:heading -->

					<!-- nx:paragraph {"fontSize":"medium"} -->
					<p class="has-medium-font-size"><?php esc_html_e( '123 Example St. Manhattan, NY 10300 United States', 'twentytwentyfive' ); ?></p>
					<!-- /nx:paragraph -->
				</div>
				<!-- /nx:group -->
			</div>
			<!-- /nx:group -->
		</div>
		<!-- /nx:group -->
	</div>
	<!-- /nx:group -->
</div>
<!-- /nx:group -->
