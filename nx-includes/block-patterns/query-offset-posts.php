<?php
/**
 * Query: Offset.
 *
 * @package NexusPress
 */

return array(
	'title'      => _x( 'Offset', 'Block pattern title' ),
	'blockTypes' => array( 'core/query' ),
	'categories' => array( 'query' ),
	'content'    => '<!-- nx:group {"style":{"spacing":{"padding":{"top":"30px","right":"30px","bottom":"30px","left":"30px"}}},"layout":{"inherit":false}} -->
					<div class="nx-block-group" style="padding-top:30px;padding-right:30px;padding-bottom:30px;padding-left:30px"><!-- nx:columns -->
					<div class="nx-block-columns"><!-- nx:column {"width":"50%"} -->
					<div class="nx-block-column" style="flex-basis:50%"><!-- nx:query {"query":{"perPage":2,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false},"displayLayout":{"type":"list"}} -->
					<div class="nx-block-query"><!-- nx:post-template -->
					<!-- nx:post-featured-image /-->
					<!-- nx:post-title /-->
					<!-- nx:post-date /-->
					<!-- nx:spacer {"height":200} -->
					<div style="height:200px" aria-hidden="true" class="nx-block-spacer"></div>
					<!-- /nx:spacer -->
					<!-- /nx:post-template --></div>
					<!-- /nx:query --></div>
					<!-- /nx:column -->
					<!-- nx:column {"width":"50%"} -->
					<div class="nx-block-column" style="flex-basis:50%"><!-- nx:query {"query":{"perPage":2,"pages":0,"offset":2,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false},"displayLayout":{"type":"list"}} -->
					<div class="nx-block-query"><!-- nx:post-template -->
					<!-- nx:spacer {"height":200} -->
					<div style="height:200px" aria-hidden="true" class="nx-block-spacer"></div>
					<!-- /nx:spacer -->
					<!-- nx:post-featured-image /-->
					<!-- nx:post-title /-->
					<!-- nx:post-date /-->
					<!-- /nx:post-template --></div>
					<!-- /nx:query --></div>
					<!-- /nx:column --></div>
					<!-- /nx:columns --></div>
					<!-- /nx:group -->',
);
