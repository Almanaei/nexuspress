<?php
/**
 * Query: Standard.
 *
 * @package NexusPress
 */

return array(
	'title'      => _x( 'Standard', 'Block pattern title' ),
	'blockTypes' => array( 'core/query' ),
	'categories' => array( 'query' ),
	'content'    => '<!-- nx:query {"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false}} -->
					<div class="nx-block-query">
					<!-- nx:post-template -->
					<!-- nx:post-title {"isLink":true} /-->
					<!-- nx:post-featured-image  {"isLink":true,"align":"wide"} /-->
					<!-- nx:post-excerpt /-->
					<!-- nx:separator -->
					<hr class="nx-block-separator"/>
					<!-- /nx:separator -->
					<!-- nx:post-date /-->
					<!-- /nx:post-template -->
					</div>
					<!-- /nx:query -->',
);
