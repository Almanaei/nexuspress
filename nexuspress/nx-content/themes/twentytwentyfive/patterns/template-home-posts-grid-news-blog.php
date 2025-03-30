<?php
/**
 * Title: News blog with featured posts grid
 * Slug: twentytwentyfive/template-home-posts-grid-news-blog
 * Template Types: front-page, index, home
 * Inserter: no
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:template-part {"slug":"header-large-title"} /-->

<!-- nx:group {"tagName":"main","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"default"}} -->
<main class="nx-block-group" style="margin-top:0;margin-bottom:0;">

	<!-- nx:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
	<div class="nx-block-group" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50)">
		<!-- nx:query {"query":{"perPage":1,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"align":"wide"} -->
		<div class="nx-block-query alignwide">
			<!-- nx:post-template -->
				<!-- nx:post-featured-image {"isLink":true,"aspectRatio":"16/9","align":"wide"} /-->
				<!-- nx:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|40"}}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
				<div class="nx-block-group" style="padding-top:var(--nx--preset--spacing--40)">
					<!-- nx:post-title {"textAlign":"center","level":1,"isLink":true,"fontSize":"xx-large"} /-->
					<!-- nx:post-terms {"term":"category","textAlign":"center","style":{"typography":{"textTransform":"uppercase","letterSpacing":"1.4px"}}} /-->
					<!-- nx:post-date {"textAlign":"center","isLink":true} /-->
				</div>
				<!-- /nx:group -->
			<!-- /nx:post-template -->
			<!-- nx:query-no-results -->
				<!-- nx:paragraph {"align":"center","placeholder":"<?php esc_attr_e( 'Add text or blocks that will display when a query returns no results.', 'twentytwentyfive' ); ?>"} -->
				<p class="has-text-align-center"><?php echo esc_html_x( 'Sorry, but nothing was found. Please try a search with different keywords.', 'Message explaining that there are no results returned from a search.', 'twentytwentyfive' ); ?></p>
				<!-- /nx:paragraph -->
			<!-- /nx:query-no-results -->
		</div>
		<!-- /nx:query -->
	</div>
	<!-- /nx:group -->

	<!-- nx:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
	<div class="nx-block-group" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50)">
		<!-- nx:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"grid","columnCount":null,"minimumColumnWidth":"40rem"}} -->
		<div class="nx-block-group alignwide">
			<!-- nx:query {"query":{"perPage":1,"pages":0,"offset":"1","postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[]}} -->
			<div class="nx-block-query">
				<!-- nx:post-template -->
					<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"default"}} -->
					<div class="nx-block-group">
						<!-- nx:post-featured-image {"isLink":true,"aspectRatio":"3/2"} /-->
						<!-- nx:post-title {"isLink":true,"fontSize":"x-large"} /-->
						<!-- nx:post-terms {"term":"category","style":{"typography":{"textTransform":"uppercase","letterSpacing":"1.4px"}}} /-->
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
			<!-- nx:query {"query":{"perPage":1,"pages":0,"offset":"2","postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[]}} -->
			<div class="nx-block-query">
				<!-- nx:post-template -->
					<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"default"}} -->
					<div class="nx-block-group">
						<!-- nx:post-featured-image {"isLink":true,"aspectRatio":"3/2"} /-->
						<!-- nx:post-title {"isLink":true,"fontSize":"x-large"} /-->
						<!-- nx:post-terms {"term":"category","style":{"typography":{"textTransform":"uppercase","letterSpacing":"1.4px"}}} /-->
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
		<!-- /nx:group -->
	</div>
	<!-- /nx:group -->

	<!-- nx:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
	<div class="nx-block-group" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50)">
		<!-- nx:query {"query":{"perPage":3,"pages":0,"offset":"3","postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[]},"align":"wide"} -->
		<div class="nx-block-query alignwide">
			<!-- nx:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"grid","columnCount":3}} -->
				<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"default"}} -->
				<div class="nx-block-group">
					<!-- nx:post-featured-image {"isLink":true,"aspectRatio":"4/3"} /-->
					<!-- nx:post-title {"isLink":true,"fontSize":"large"} /-->
					<!-- nx:post-terms {"term":"category","style":{"typography":{"textTransform":"uppercase","letterSpacing":"1.4px"}}} /-->
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
	<!-- /nx:group -->

	<!-- nx:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
	<div class="nx-block-group alignwide" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--60);padding-bottom:var(--nx--preset--spacing--60)">
		<!-- nx:heading {"align":"wide"} -->
		<h2 class="nx-block-heading alignwide"><?php esc_html_e( 'Architecture', 'twentytwentyfive' ); ?></h2>
		<!-- /nx:heading -->
		<!-- nx:query {"query":{"perPage":6,"pages":0,"offset":"6","postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[]},"align":"wide","layout":{"type":"default"}} -->
		<div class="nx-block-query alignwide">
			<!-- nx:post-template {"align":"full","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"}} -->
				<!-- nx:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}},"border":{"bottom":{"color":"var:preset|color|accent-6","width":"1px"},"top":[],"right":[],"left":[]}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center","justifyContent":"space-between"}} -->
				<div class="nx-block-group alignfull" style="border-bottom-color:var(--nx--preset--color--accent-6);border-bottom-width:1px;padding-top:var(--nx--preset--spacing--30);padding-bottom:var(--nx--preset--spacing--30)">
					<!-- nx:post-title {"level":3,"isLink":true,"fontSize":"large"} /-->
					<!-- nx:post-date {"textAlign":"right","isLink":true} /-->
				</div>
				<!-- /nx:group -->
			<!-- /nx:post-template -->
			</div>
		<!-- /nx:query -->
	</div>
	<!-- /nx:group -->

</main>
<!-- /nx:group -->

<!-- nx:pattern {"slug":"twentytwentyfive/cta-newsletter"} /-->

<!-- nx:template-part {"slug":"footer-columns"} /-->
