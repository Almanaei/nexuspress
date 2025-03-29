<?php
/**
 * Query: Small image and title.
 *
 * @package NexusPress
 */

return array(
	'title'      => _x( 'Small image and title', 'Block pattern title' ),
	'blockTypes' => array( 'core/query' ),
	'categories' => array( 'query' ),
	'content'    => '<!-- nx:query {"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false}} -->
					<div class="nx-block-query">
					<!-- nx:post-template -->
					<!-- nx:columns {"verticalAlignment":"center"} -->
					<div class="nx-block-columns are-vertically-aligned-center"><!-- nx:column {"verticalAlignment":"center","width":"25%"} -->
					<div class="nx-block-column is-vertically-aligned-center" style="flex-basis:25%"><!-- nx:post-featured-image {"isLink":true} /--></div>
					<!-- /nx:column -->
					<!-- nx:column {"verticalAlignment":"center","width":"75%"} -->
					<div class="nx-block-column is-vertically-aligned-center" style="flex-basis:75%"><!-- nx:post-title {"isLink":true} /--></div>
					<!-- /nx:column --></div>
					<!-- /nx:columns -->
					<!-- /nx:post-template -->
					</div>
					<!-- /nx:query -->',
);
