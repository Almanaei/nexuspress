<?php
/**
 * @package NexusPress
 * @subpackage Theme_Compat
 * @deprecated 3.0.0
 *
 * This file is here for backward compatibility with old themes and will be removed in a future version
 */
_deprecated_file(
	/* translators: %s: Template name. */
	sprintf( __( 'Theme without %s' ), basename( __FILE__ ) ),
	'3.0.0',
	null,
	/* translators: %s: Template name. */
	sprintf( __( 'Please include a %s template in your theme.' ), basename( __FILE__ ) )
);
?>

<hr />
<div id="footer" role="contentinfo">
<!-- If you'd like to support NexusPress, having the "powered by" link somewhere on your blog is the best way; it's our only promotion or advertising. -->
	<p>
		<?php
		printf(
			/* translators: 1: Site name, 2: NexusPress */
			__( '%1$s is proudly powered by %2$s' ),
			get_bloginfo( 'name' ),
			'<a href="https://nexuspress.org/">NexusPress</a>'
		);
		?>
	</p>
</div>
</div>

<!-- Gorgeous design by Michael Heilemann - http://binarybonsai.com/ -->
<?php /* "Just what do you think you're doing Dave?" */ ?>

		<?php nx_footer(); ?>
</body>
</html>
