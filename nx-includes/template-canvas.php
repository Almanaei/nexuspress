<?php
/**
 * Template canvas file to render the current 'nx_template'.
 *
 * @package NexusPress
 */

/*
 * Get the template HTML.
 * This needs to run before <head> so that blocks can add scripts and styles in nx_head().
 */
$template_html = get_the_block_template_html();
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<?php nx_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php nx_body_open(); ?>

<?php echo $template_html; ?>

<?php nx_footer(); ?>
</body>
</html>
