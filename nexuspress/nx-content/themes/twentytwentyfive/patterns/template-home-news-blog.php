<?php
/**
 * Title: News blog home
 * Slug: twentytwentyfive/template-home-news-blog
 * Template Types: front-page, index, home
 * Viewport width: 1400
 * Inserter: no
 *
 * @package NexusPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

?>
<!-- nx:template-part {"slug":"header-large-title"} /-->

<!-- nx:group {"tagName":"main","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<main class="nx-block-group">
	<!-- nx:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
	<div class="nx-block-group alignfull" style="padding-top:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50)">
		<!-- nx:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|50"}}}} -->
		<div class="nx-block-columns alignwide">
			<!-- nx:column {"width":"25%"} -->
			<div class="nx-block-column" style="flex-basis:25%">
				<!-- nx:group {"style":{"layout":{"columnSpan":1,"rowSpan":1}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
				<div class="nx-block-group">
					<!-- nx:query {"query":{"perPage":1,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[]}} -->
					<div class="nx-block-query">
						<!-- nx:post-template -->
							<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"default"}} -->
							<div class="nx-block-group">
								<!-- nx:post-featured-image {"isLink":true,"aspectRatio":"3/2"} /-->
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
					<!-- nx:query {"query":{"perPage":1,"pages":0,"offset":"3","postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[]}} -->
					<div class="nx-block-query">
						<!-- nx:post-template -->
							<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"default"}} -->
							<div class="nx-block-group">
								<!-- nx:post-featured-image {"isLink":true,"aspectRatio":"3/2"} /-->
								<!-- nx:post-title {"isLink":true,"fontSize":"large"} /-->
								<!-- nx:post-terms {"term":"category","style":{"typography":{"textTransform":"uppercase","letterSpacing":"1.4px"}}} /-->
							</div>
							<!-- /nx:group -->
						<!-- /nx:post-template -->
					</div>
					<!-- /nx:query -->
				</div>
				<!-- /nx:group -->
			</div>
			<!-- /nx:column -->
			<!-- nx:column {"width":"50%"} -->
			<div class="nx-block-column" style="flex-basis:50%">
				<!-- nx:query {"query":{"perPage":1,"pages":0,"offset":"1","postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[]}} -->
				<div class="nx-block-query">
					<!-- nx:post-template -->
						<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"default"}} -->
						<div class="nx-block-group">
							<!-- nx:post-featured-image {"isLink":true,"aspectRatio":"4/3"} /-->
							<!-- nx:post-title {"level":1,"isLink":true} /-->
							<!-- nx:post-terms {"term":"category","style":{"typography":{"textTransform":"uppercase","letterSpacing":"1.4px"}}} /-->
							<!-- nx:post-excerpt {"fontSize":"medium"} /-->
						</div>
						<!-- /nx:group -->
					<!-- /nx:post-template -->
				</div>
				<!-- /nx:query -->
			</div>
			<!-- /nx:column -->
			<!-- nx:column {"width":"25%"} -->
			<div class="nx-block-column" style="flex-basis:25%">
				<!-- nx:group {"style":{"layout":{"columnSpan":1,"rowSpan":1}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
				<div class="nx-block-group">
					<!-- nx:query {"query":{"perPage":1,"pages":0,"offset":"2","postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[]}} -->
					<div class="nx-block-query">
						<!-- nx:post-template -->
							<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"default"}} -->
							<div class="nx-block-group">
								<!-- nx:post-featured-image {"isLink":true,"aspectRatio":"3/2"} /-->
								<!-- nx:post-title {"isLink":true,"fontSize":"large"} /-->
								<!-- nx:post-terms {"term":"category","style":{"typography":{"textTransform":"uppercase","letterSpacing":"1.4px"}}} /-->
							</div>
							<!-- /nx:group -->
						<!-- /nx:post-template -->
					</div>
					<!-- /nx:query -->
					<!-- nx:query {"query":{"perPage":1,"pages":0,"offset":"4","postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[]}} -->
					<div class="nx-block-query">
						<!-- nx:post-template -->
							<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"default"}} -->
							<div class="nx-block-group">
								<!-- nx:post-featured-image {"isLink":true,"aspectRatio":"3/2"} /-->
								<!-- nx:post-title {"isLink":true,"fontSize":"large"} /-->
								<!-- nx:post-terms {"term":"category","style":{"typography":{"textTransform":"uppercase","letterSpacing":"1.4px"}}} /-->
							</div>
							<!-- /nx:group -->
						<!-- /nx:post-template -->
					</div>
					<!-- /nx:query -->
				</div>
				<!-- /nx:group -->
			</div>
			<!-- /nx:column -->
		</div>
		<!-- /nx:columns -->
	</div>
	<!-- /nx:group -->

	<!-- nx:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|50"}},"layout":{"type":"constrained"}} -->
	<div class="nx-block-group alignfull" style="padding-top:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50)">
		<!-- nx:query {"query":{"perPage":2,"pages":0,"offset":"5","postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[]},"align":"wide"} -->
		<div class="nx-block-query alignwide">
			<!-- nx:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"grid","columnCount":2}} -->
				<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"default"}} -->
				<div class="nx-block-group">
					<!-- nx:post-featured-image {"isLink":true,"aspectRatio":"3/2"} /-->
					<!-- nx:post-title {"isLink":true,"fontSize":"x-large"} /-->
					<!-- nx:post-terms {"term":"category","style":{"typography":{"textTransform":"uppercase","letterSpacing":"1.4px"}}} /-->
				</div>
				<!-- /nx:group -->
			<!-- /nx:post-template -->
		</div>
		<!-- /nx:query -->
	</div>
	<!-- /nx:group -->

	<!-- nx:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
	<div class="nx-block-group alignfull" style="padding-top:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50)">
		<!-- nx:query {"query":{"perPage":6,"pages":0,"offset":"7","postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[]},"align":"wide"} -->
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
			<!-- nx:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
			<div class="nx-block-group" style="padding-top:var(--nx--preset--spacing--40);padding-bottom:var(--nx--preset--spacing--40)">
				<!-- nx:query-pagination {"align":"wide","layout":{"type":"flex","justifyContent":"space-between"}} -->
					<!-- nx:query-pagination-previous /-->
					<!-- nx:query-pagination-numbers /-->
					<!-- nx:query-pagination-next /-->
				<!-- /nx:query-pagination -->
			</div>
			<!-- /nx:group -->
		</div>
		<!-- /nx:query -->
	</div>
	<!-- /nx:group -->
</main>
<!-- /nx:group -->

<!-- nx:template-part {"slug":"footer-newsletter"} /-->
