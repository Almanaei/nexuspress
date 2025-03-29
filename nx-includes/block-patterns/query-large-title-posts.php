<?php
/**
 * Query: Large title.
 *
 * @package NexusPress
 */

return array(
	'title'      => _x( 'Large title', 'Block pattern title' ),
	'blockTypes' => array( 'core/query' ),
	'categories' => array( 'query' ),
	'content'    => '<!-- nx:group {"align":"full","style":{"spacing":{"padding":{"top":"100px","right":"100px","bottom":"100px","left":"100px"}},"color":{"text":"#ffffff","background":"#000000"}}} -->
					<div class="nx-block-group alignfull has-text-color has-background" style="background-color:#000000;color:#ffffff;padding-top:100px;padding-right:100px;padding-bottom:100px;padding-left:100px"><!-- nx:query {"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false}} -->
					<div class="nx-block-query"><!-- nx:post-template -->
					<!-- nx:separator {"customColor":"#ffffff","align":"wide","className":"is-style-wide"} -->
					<hr class="nx-block-separator alignwide has-text-color has-background is-style-wide" style="background-color:#ffffff;color:#ffffff"/>
					<!-- /nx:separator -->

					<!-- nx:columns {"verticalAlignment":"center","align":"wide"} -->
					<div class="nx-block-columns alignwide are-vertically-aligned-center"><!-- nx:column {"verticalAlignment":"center","width":"20%"} -->
					<div class="nx-block-column is-vertically-aligned-center" style="flex-basis:20%"><!-- nx:post-date {"style":{"color":{"text":"#ffffff"}},"fontSize":"extra-small"} /--></div>
					<!-- /nx:column -->

					<!-- nx:column {"verticalAlignment":"center","width":"80%"} -->
					<div class="nx-block-column is-vertically-aligned-center" style="flex-basis:80%"><!-- nx:post-title {"isLink":true,"style":{"typography":{"fontSize":"72px","lineHeight":"1.1"},"color":{"text":"#ffffff","link":"#ffffff"}}} /--></div>
					<!-- /nx:column --></div>
					<!-- /nx:columns -->
					<!-- /nx:post-template --></div>
					<!-- /nx:query --></div>
					<!-- /nx:group -->',
);
