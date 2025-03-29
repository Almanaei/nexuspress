<?php
/**
 * Query: Image at left.
 *
 * @package NexusPress
 */

return array(
	'title'      => _x( 'Image at left', 'Block pattern title' ),
	'blockTypes' => array( 'core/query' ),
	'categories' => array( 'query' ),
	'content'    => '<!-- nx:query {"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false}} -->
					<div class="nx-block-query">
					<!-- nx:post-template -->
					<!-- nx:columns {"align":"wide"} -->
					<div class="nx-block-columns alignwide"><!-- nx:column {"width":"66.66%"} -->
					<div class="nx-block-column" style="flex-basis:66.66%"><!-- nx:post-featured-image {"isLink":true} /--></div>
					<!-- /nx:column -->
					<!-- nx:column {"width":"33.33%"} -->
					<div class="nx-block-column" style="flex-basis:33.33%"><!-- nx:post-title {"isLink":true} /-->
					<!-- nx:post-excerpt /--></div>
					<!-- /nx:column --></div>
					<!-- /nx:columns -->
					<!-- /nx:post-template -->
					</div>
					<!-- /nx:query -->',
);
