<?php
/**
 * Title: News blog with sidebar
 * Slug: twentytwentyfive/template-home-with-sidebar-news-blog
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

<!-- nx:group {"tagName":"main","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<main class="nx-block-group" style="margin-top:0;margin-bottom:0;padding-top:var(--nx--preset--spacing--50);padding-bottom:var(--nx--preset--spacing--50)">
	<!-- nx:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|50"}}}} -->
	<div class="nx-block-columns alignwide">
		<!-- nx:column {"width":"75%"} -->
		<div class="nx-block-column" style="flex-basis:75%">
			<!-- nx:query {"query":{"perPage":1,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false}} -->
			<div class="nx-block-query">
				<!-- nx:post-template -->
					<!-- nx:post-featured-image {"isLink":true,"aspectRatio":"3/2","align":"wide"} /-->
					<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20","padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
					<div class="nx-block-group" style="padding-top:var(--nx--preset--spacing--40);padding-bottom:var(--nx--preset--spacing--40)">
						<!-- nx:post-title {"level":1,"isLink":true} /-->
						<!-- nx:post-terms {"term":"category","style":{"typography":{"textTransform":"uppercase","letterSpacing":"1.4px"}}} /-->
						<!-- nx:post-date {"isLink":true} /-->
					</div>
					<!-- /nx:group -->
				<!-- /nx:post-template -->
			</div>
			<!-- /nx:query -->
		</div>
		<!-- /nx:column -->
		<!-- nx:column {"width":"25%"} -->
		<div class="nx-block-column" style="flex-basis:25%">
			<!-- nx:heading {"style":{"typography":{"fontStyle":"normal","fontWeight":"600","textTransform":"uppercase","letterSpacing":"1.6px"}},"fontSize":"small"} -->
			<h2 class="nx-block-heading has-small-font-size" style="font-style:normal;font-weight:600;letter-spacing:1.6px;text-transform:uppercase"><?php esc_html_e( 'The Latest', 'twentytwentyfive' ); ?></h2>
			<!-- /nx:heading -->
			<!-- nx:spacer {"height":"var:preset|spacing|20"} -->
			<div style="height:var(--nx--preset--spacing--20)" aria-hidden="true" class="nx-block-spacer"></div>
			<!-- /nx:spacer -->
			<!-- nx:query {"query":{"perPage":6,"pages":0,"offset":"1","postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[]}} -->
			<div class="nx-block-query">
				<!-- nx:post-template -->
					<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
					<div class="nx-block-group">
						<!-- nx:post-title {"level":3,"isLink":true,"fontSize":"large"} /-->
						<!-- nx:post-date {"fontSize":"small","isLink":true} /-->
					</div>
					<!-- /nx:group -->
					<!-- nx:spacer {"height":"var:preset|spacing|20"} -->
					<div style="height:var(--nx--preset--spacing--20)" aria-hidden="true" class="nx-block-spacer"></div>
					<!-- /nx:spacer -->
				<!-- /nx:post-template -->
				<!-- nx:query-no-results -->
					<!-- nx:paragraph {"placeholder":"<?php esc_attr_e( 'Add text or blocks that will display when a query returns no results.', 'twentytwentyfive' ); ?>","fontSize":"medium"} -->
					<p class="has-medium-font-size"><?php echo esc_html_x( 'Sorry, but nothing was found. Please try a search with different keywords.', 'Message explaining that there are no results returned from a search.', 'twentytwentyfive' ); ?></p>
					<!-- /nx:paragraph -->
				<!-- /nx:query-no-results -->
			</div>
			<!-- /nx:query -->
		</div>
		<!-- /nx:column -->
	</div>
	<!-- /nx:columns -->
	<!-- nx:spacer {"height":"var:preset|spacing|50"} -->
	<div style="height:var(--nx--preset--spacing--50)" aria-hidden="true" class="nx-block-spacer"></div>
	<!-- /nx:spacer -->
	<!-- nx:query {"query":{"perPage":4,"pages":0,"offset":"7","postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[]},"align":"wide"} -->
	<div class="nx-block-query alignwide">
		<!-- nx:post-template -->
			<!-- nx:columns {"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|50"},"margin":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"},"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}},"border":{"bottom":{"color":"var:preset|color|accent-6","width":"1px"}}}} -->
			<div class="nx-block-columns" style="border-bottom-color:var(--nx--preset--color--accent-6);border-bottom-width:1px;margin-top:var(--nx--preset--spacing--30);margin-bottom:var(--nx--preset--spacing--30);padding-top:var(--nx--preset--spacing--30);padding-bottom:var(--nx--preset--spacing--30)">
				<!-- nx:column {"verticalAlignment":"center","width":"60%"} -->
				<div class="nx-block-column is-vertically-aligned-center" style="flex-basis:60%">
					<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
					<div class="nx-block-group">
						<!-- nx:post-title {"fontSize":"x-large"} /-->
						<!-- nx:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"fontSize":"small","layout":{"type":"flex","flexWrap":"wrap"}} -->
						<div class="nx-block-group has-small-font-size">
							<!-- nx:post-terms {"term":"category","style":{"typography":{"textTransform":"uppercase","letterSpacing":"1.4px"}}} /-->
							<!-- nx:paragraph -->
							<p><?php echo esc_html_x( '·', 'Separator between date and categories.', 'twentytwentyfive' ); ?></p>
							<!-- /nx:paragraph -->
							<!-- nx:post-date {"isLink":true} /-->
						</div>
						<!-- /nx:group -->
					</div>
					<!-- /nx:group -->
				</div>
				<!-- /nx:column -->
				<!-- nx:column {"width":"20%"} -->
				<div class="nx-block-column" style="flex-basis:20%"></div>
				<!-- /nx:column -->
				<!-- nx:column {"width":"13.33%"} -->
				<div class="nx-block-column" style="flex-basis:13.33%">
					<!-- nx:post-featured-image {"isLink":true,"aspectRatio":"1","style":{"layout":{"selfStretch":"fixed","flexSize":"180px"}}} /-->
				</div>
				<!-- /nx:column -->
			</div>
			<!-- /nx:columns -->
		<!-- /nx:post-template -->
		<!-- nx:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"layout":{"type":"constrained"}} -->
		<div class="nx-block-group" style="padding-top:var(--nx--preset--spacing--30);padding-bottom:var(--nx--preset--spacing--30)">
			<!-- nx:query-pagination {"fontSize":"medium","layout":{"type":"flex","justifyContent":"space-between"}} -->
				<!-- nx:query-pagination-previous /-->
				<!-- nx:query-pagination-numbers /-->
				<!-- nx:query-pagination-next /-->
			<!-- /nx:query-pagination -->
		</div>
		<!-- /nx:group -->
		<!-- nx:query-no-results -->
			<!-- nx:paragraph -->
			<p><?php echo esc_html_x( 'Sorry, but nothing was found. Please try a search with different keywords.', 'Message explaining that there are no results returned from a search.', 'twentytwentyfive' ); ?></p>
			<!-- /nx:paragraph -->
		<!-- /nx:query-no-results -->
	</div>
	<!-- /nx:query -->
</main>
<!-- /nx:group -->

<!-- nx:template-part {"slug":"footer-columns"} /-->
