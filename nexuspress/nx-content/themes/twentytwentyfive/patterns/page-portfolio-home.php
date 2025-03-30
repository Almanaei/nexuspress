<?php
/**
 * Title: Portfolio homepage
 * Slug: twentytwentyfive/page-portfolio-home
 * Categories: twentytwentyfive_page, posts
 * Keywords: starter
 * Block Types: core/post-content
 * Post Types: page, nx_template
 * Viewport width: 1400
 * Description: A portfolio homepage pattern.
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:group {"align":"full","layout":{"type":"default"}} -->
<div class="nx-block-group alignfull">
	<!-- nx:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
	<div class="nx-block-group alignfull" style="padding-top:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50)">
		<!-- nx:columns {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|50"}}}} -->
		<div class="nx-block-columns alignwide" style="padding-top:var(--nx--preset--spacing--80);padding-bottom:var(--nx--preset--spacing--50)">
			<!-- nx:column {"width":"50%"} -->
			<div class="nx-block-column" style="flex-basis:50%">
				<!-- nx:heading {"align":"wide","fontSize":"x-large"} -->
				<h2 class="nx-block-heading alignwide has-x-large-font-size"><?php esc_html_e( 'My name is Anna Möller and these are some of my photo projects.', 'twentytwentyfive' ); ?></h2>
				<!-- /nx:heading -->
			</div>
			<!-- /nx:column -->

			<!-- nx:column {"width":"50%"} -->
			<div class="nx-block-column" style="flex-basis:50%">
				<!-- nx:spacer {"height":"var:preset|spacing|20"} -->
				<div style="height:var(--nx--preset--spacing--20)" aria-hidden="true" class="nx-block-spacer"></div>
				<!-- /nx:spacer -->
				</div>
			<!-- /nx:column -->
		</div>
		<!-- /nx:columns -->
	</div>
	<!-- /nx:group -->
</div>
<!-- /nx:group -->

<!-- nx:group {"align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group alignfull" style="margin-top:0;margin-bottom:0">
	<!-- nx:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|20"}}}} -->
	<div class="nx-block-columns alignwide">
		<!-- nx:column {"width":"66.66%"} -->
		<div class="nx-block-column" style="flex-basis:66.66%">
			<!-- nx:query {"query":{"perPage":1,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[]},"layout":{"type":"default"}} -->
			<div class="nx-block-query">
				<!-- nx:post-template -->
					<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"default"}} -->
					<div class="nx-block-group">
						<!-- nx:post-featured-image {"isLink":true,"aspectRatio":"3/2"} /-->
						<!-- nx:post-title {"isLink":true} /-->
						<!-- nx:post-terms {"term":"category","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-4"}}},"typography":{"fontStyle":"normal","fontWeight":"300"}}} /-->
					</div>
					<!-- /nx:group -->
				<!-- /nx:post-template -->
				<!-- nx:query-no-results -->
				<!-- nx:paragraph -->
				<p><?php echo esc_html_x( 'Sorry, but nothing was found. Please try a search with different keywords.', 'Message explaining that there are no results returned from a search.', 'twentytwentyfive' ); ?></p>
				<!-- /nx:paragraph -->
				<!-- /nx:query-no-results -->
			</div>
			<!-- /nx:query -->
		</div>
		<!-- /nx:column -->
		<!-- nx:column {"width":"33.33%"} -->
		<div class="nx-block-column" style="flex-basis:33.33%">
			<!-- nx:query {"query":{"perPage":1,"pages":0,"offset":"1","postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[]},"layout":{"type":"default"}} -->
			<div class="nx-block-query">
				<!-- nx:post-template -->
					<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"default"}} -->
					<div class="nx-block-group">
						<!-- nx:post-featured-image {"isLink":true,"aspectRatio":"3/2"} /-->
						<!-- nx:post-title {"isLink":true} /-->
						<!-- nx:post-terms {"term":"category","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-4"}}},"typography":{"fontStyle":"normal","fontWeight":"300"}}} /-->
					</div>
					<!-- /nx:group -->
				<!-- /nx:post-template -->
				<!-- nx:query-no-results -->
				<!-- nx:paragraph -->
				<p><?php echo esc_html_x( 'Sorry, but nothing was found. Please try a search with different keywords.', 'Message explaining that there are no results returned from a search.', 'twentytwentyfive' ); ?></p>
				<!-- /nx:paragraph -->
				<!-- /nx:query-no-results -->
			</div>
			<!-- /nx:query -->
		</div>
		<!-- /nx:column -->
	</div>
	<!-- /nx:columns -->

	<!-- nx:spacer {"height":"var:preset|spacing|30"} -->
	<div style="height:var(--nx--preset--spacing--30)" aria-hidden="true" class="nx-block-spacer"></div>
	<!-- /nx:spacer -->
</div>
<!-- /nx:group -->

<!-- nx:group {"align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group alignfull" style="margin-top:0;margin-bottom:0">
	<!-- nx:spacer {"height":"var:preset|spacing|30"} -->
	<div style="height:var(--nx--preset--spacing--30)" aria-hidden="true" class="nx-block-spacer"></div>
	<!-- /nx:spacer -->
	<!-- nx:query {"query":{"perPage":3,"pages":0,"offset":"2","postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[]},"align":"wide","layout":{"type":"default"}} -->
	<div class="nx-block-query alignwide">
		<!-- nx:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"grid","columnCount":3}} -->
			<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"default"}} -->
			<div class="nx-block-group">
				<!-- nx:post-featured-image {"isLink":true,"aspectRatio":"3/2"} /-->
				<!-- nx:post-title {"isLink":true} /-->
				<!-- nx:post-terms {"term":"category","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-4"}}},"typography":{"fontStyle":"normal","fontWeight":"300"}}} /-->
			</div>
			<!-- /nx:group -->
		<!-- /nx:post-template -->
		<!-- nx:query-no-results -->
		<!-- nx:paragraph -->
		<p><?php echo esc_html_x( 'Sorry, but nothing was found. Please try a search with different keywords.', 'Message explaining that there are no results returned from a search.', 'twentytwentyfive' ); ?></p>
		<!-- /nx:paragraph -->
		<!-- /nx:query-no-results -->
	</div>
	<!-- /nx:query -->
	<!-- nx:spacer {"height":"var:preset|spacing|30"} -->
	<div style="height:var(--nx--preset--spacing--30)" aria-hidden="true" class="nx-block-spacer"></div>
	<!-- /nx:spacer -->
</div>
<!-- /nx:group -->

<!-- nx:group {"align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group alignfull" style="margin-top:0;margin-bottom:0">
	<!-- nx:spacer {"height":"var:preset|spacing|30"} -->
	<div style="height:var(--nx--preset--spacing--30)" aria-hidden="true" class="nx-block-spacer"></div>
	<!-- /nx:spacer -->
	<!-- nx:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|20"}}}} -->
	<div class="nx-block-columns alignwide">
		<!-- nx:column {"width":"33.33%"} -->
		<div class="nx-block-column" style="flex-basis:33.33%">
			<!-- nx:query {"query":{"perPage":1,"pages":0,"offset":"5","postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[]},"layout":{"type":"default"}} -->
			<div class="nx-block-query">
				<!-- nx:post-template -->
					<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"default"}} -->
					<div class="nx-block-group">
						<!-- nx:post-featured-image {"isLink":true,"aspectRatio":"3/2"} /-->
						<!-- nx:post-title {"isLink":true} /-->
						<!-- nx:post-terms {"term":"category","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-4"}}},"typography":{"fontStyle":"normal","fontWeight":"300"}}} /-->
					</div>
					<!-- /nx:group -->
				<!-- /nx:post-template -->
				<!-- nx:query-no-results -->
				<!-- nx:paragraph -->
				<p><?php echo esc_html_x( 'Sorry, but nothing was found. Please try a search with different keywords.', 'Message explaining that there are no results returned from a search.', 'twentytwentyfive' ); ?></p>
				<!-- /nx:paragraph -->
				<!-- /nx:query-no-results -->
			</div>
			<!-- /nx:query -->
		</div>
		<!-- /nx:column -->
		<!-- nx:column {"width":"66.66%"} -->
		<div class="nx-block-column" style="flex-basis:66.66%">
			<!-- nx:query {"query":{"perPage":1,"pages":0,"offset":"6","postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[]},"layout":{"type":"default"}} -->
			<div class="nx-block-query">
				<!-- nx:post-template -->
					<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"default"}} -->
					<div class="nx-block-group">
						<!-- nx:post-featured-image {"isLink":true,"aspectRatio":"3/2"} /-->
						<!-- nx:post-title {"isLink":true} /-->
						<!-- nx:post-terms {"term":"category","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-4"}}},"typography":{"fontStyle":"normal","fontWeight":"300"}}} /-->
					</div>
					<!-- /nx:group -->
				<!-- /nx:post-template -->
				<!-- nx:query-no-results -->
				<!-- nx:paragraph -->
				<p><?php echo esc_html_x( 'Sorry, but nothing was found. Please try a search with different keywords.', 'Message explaining that there are no results returned from a search.', 'twentytwentyfive' ); ?></p>
				<!-- /nx:paragraph -->
				<!-- /nx:query-no-results -->
			</div>
			<!-- /nx:query -->
		</div>
		<!-- /nx:column -->
	</div>
	<!-- /nx:columns -->

	<!-- nx:spacer {"height":"var:preset|spacing|70"} -->
	<div style="height:var(--nx--preset--spacing--70)" aria-hidden="true" class="nx-block-spacer"></div>
	<!-- /nx:spacer -->

	<!-- nx:query {"query":{"perPage":3,"pages":0,"offset":"7","postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[]},"align":"wide","layout":{"type":"default"}} -->
	<div class="nx-block-query alignwide">
		<!-- nx:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"grid","columnCount":3}} -->
			<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"default"}} -->
			<div class="nx-block-group">
				<!-- nx:post-featured-image {"isLink":true,"aspectRatio":"3/2"} /-->
				<!-- nx:post-title {"isLink":true} /-->
				<!-- nx:post-terms {"term":"category","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-4"}}},"typography":{"fontStyle":"normal","fontWeight":"300"}}} /-->
			</div>
			<!-- /nx:group -->
		<!-- /nx:post-template -->
		<!-- nx:query-no-results -->
		<!-- nx:paragraph -->
		<p><?php echo esc_html_x( 'Sorry, but nothing was found. Please try a search with different keywords.', 'Message explaining that there are no results returned from a search.', 'twentytwentyfive' ); ?></p>
		<!-- /nx:paragraph -->
		<!-- /nx:query-no-results -->
	</div>
	<!-- /nx:query -->

	<!-- nx:separator {"align":"full"} -->
	<hr class="nx-block-separator alignfull has-alpha-channel-opacity"/>
	<!-- /nx:separator -->

	<!-- nx:spacer {"height":"var:preset|spacing|30"} -->
	<div style="height:var(--nx--preset--spacing--30)" aria-hidden="true" class="nx-block-spacer"></div>
	<!-- /nx:spacer -->
</div>
<!-- /nx:group -->

<!-- nx:group {"align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="nx-block-group alignfull" style="margin-top:0;margin-bottom:0">
	<!-- nx:group {"align":"wide","layout":{"type":"constrained"}} -->
	<div class="nx-block-group alignwide">
		<!-- nx:group {"align":"wide","layout":{"type":"default"}} -->
		<div class="nx-block-group alignwide">
			<!-- nx:paragraph {"fontSize":"small"} -->
			<p class="has-small-font-size"><?php esc_html_e( 'Twenty Twenty-Five', 'twentytwentyfive' ); ?></p>
			<!-- /nx:paragraph -->
			<!-- nx:paragraph {"fontSize":"small"} -->
			<p class="has-small-font-size"><?php esc_html_e( 'email@example.com', 'twentytwentyfive' ); ?><br><?php echo esc_html_x( '+1 555 349 1806', 'Phone number.', 'twentytwentyfive' ); ?></p>
			<!-- /nx:paragraph -->
		</div>
		<!-- /nx:group -->
	</div>
	<!-- /nx:group -->
</div>
<!-- /nx:group -->
