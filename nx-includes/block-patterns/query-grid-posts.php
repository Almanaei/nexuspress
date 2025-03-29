<?php
/**
 * Query: Grid.
 *
 * @package NexusPress
 */

return array(
	'title'      => _x( 'Grid', 'Block pattern title' ),
	'blockTypes' => array( 'core/query' ),
	'categories' => array( 'query' ),
	'content'    => '<!-- nx:query {"query":{"perPage":6,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false},"displayLayout":{"type":"flex","columns":3}} -->
					<div class="nx-block-query">
					<!-- nx:post-template -->
					<!-- nx:group {"style":{"spacing":{"padding":{"top":"30px","right":"30px","bottom":"30px","left":"30px"}}},"layout":{"inherit":false}} -->
					<div class="nx-block-group" style="padding-top:30px;padding-right:30px;padding-bottom:30px;padding-left:30px"><!-- nx:post-title {"isLink":true} /-->
					<!-- nx:post-excerpt /-->
					<!-- nx:post-date /--></div>
					<!-- /nx:group -->
					<!-- /nx:post-template -->
					</div>
					<!-- /nx:query -->',
);
