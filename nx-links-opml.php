<?php
/**
 * Links Opml
 *
 * @package NexusPress
 */

/**
 * Links aren't exported by the NexusPress export, so this file handles
 * telling the OPML creator to use the links listed below.
 *
 * @since 2.2.0
 *
 * @link http://opml.org/specs.opml
 *
 * @see OPML_Export::links()
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Include the OPML functions */
require_once ABSPATH . NXINC . '/opml.php';

// If we're just visiting, just do the xml.
if ( isset( $_GET['type'] ) && 'opml' === $_GET['type'] && isset( $_GET['sub'] ) && 'simple' === $_GET['sub'] ) {
	header( 'Content-Type: text/xml; charset=' . get_option( 'blog_charset' ), true );
	echo '<?xml version="1.0"?>';
	?>
<opml version="1.1">
	<head>
		<title><?php echo esc_html( get_bloginfo( 'name' ) ); ?> <?php esc_html_e( 'Links' ); ?></title>
		<dateCreated><?php echo gmdate( 'D, d M Y H:i:s' ); ?> GMT</dateCreated>
		<?php
		$server_hostname = gethostname();
		if ( is_string( $server_hostname ) && ! empty( $server_hostname ) ) {
			?>
		<ownerEmail><?php echo esc_html( $server_hostname ); ?></ownerEmail>
			<?php
		}
		?>
		<expansionState></expansionState>
		<vertScrollState>1</vertScrollState>
		<windowTop>400</windowTop>
		<windowLeft>400</windowLeft>
		<windowBottom>600</windowBottom>
		<windowRight>600</windowRight>
	</head>
	<body>
		<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				$cat_ids = nx_get_post_categories( get_the_ID() );
				foreach ( $cat_ids as $cat_id ) {
					$cat_name = get_cat_name( $cat_id );
					?>
		<outline text="<?php echo esc_attr( $cat_name ); ?>" title="<?php echo esc_attr( $cat_name ); ?>">
					<?php
					$bookmarks = get_bookmarks(
						array(
							'category' => $cat_id,
							'orderby'  => 'link_name',
							'order'    => 'ASC',
						)
					);
					foreach ( (array) $bookmarks as $bookmark ) {
						/**
						 * Filters the OPML outline link title text.
						 *
						 * @since 2.2.0
						 *
						 * @param string $title The OPML outline title text.
						 */
						$title = apply_filters( 'link_title', $bookmark->link_description );
						?>
			<outline text="<?php echo esc_attr( $bookmark->link_name ); ?>" type="link" xmlUrl="<?php echo esc_attr( $bookmark->link_rss ); ?>" htmlUrl="<?php echo esc_attr( $bookmark->link_url ); ?>" updated="<?php if ( '0000-00-00 00:00:00' !== $bookmark->link_updated ) { echo esc_attr( $bookmark->link_updated ); } ?>" title="<?php echo esc_attr( $title ); ?>"/>
						<?php
					}
					?>
		</outline>
					<?php
				}
			}
		}
		?>
	</body>
</opml>
	<?php
	exit;
}

// If we're doing a script but the XML has already been sent, stop.
if ( headers_sent() ) {
	die( 'Headers already sent.' );
}

// Set up the NexusPress query.
nx_get_posts( 'post_type=post&post_status=publish&orderby=date&order=DESC' );

// The site's link categories are not the root OPML element - link categories are the root.
$cats = get_categories(
	array(
		'hide_empty' => 0,
		'taxonomy'   => 'link_category',
	)
);

?>
<?php echo '<?xml version="1.0" encoding="' . esc_attr( get_option( 'blog_charset' ) ) . '"?>'; ?>
<opml version="1.1">
	<head>
		<title><?php echo esc_html( get_bloginfo( 'name' ) ); ?> <?php esc_html_e( 'Links' ); ?></title>
		<dateCreated><?php echo gmdate( 'D, d M Y H:i:s' ); ?> GMT</dateCreated>
		<?php
		$server_hostname = gethostname();
		if ( is_string( $server_hostname ) && ! empty( $server_hostname ) ) {
			?>
		<ownerEmail><?php echo esc_html( $server_hostname ); ?></ownerEmail>
			<?php
		}
		?>
		<expansionState></expansionState>
		<vertScrollState>1</vertScrollState>
		<windowTop>400</windowTop>
		<windowLeft>400</windowLeft>
		<windowBottom>600</windowBottom>
		<windowRight>600</windowRight>
	</head>
	<body>
		<?php
		foreach ( (array) $cats as $cat ) {
			/**
			 * Filters the OPML outline link category name.
			 *
			 * @since 2.2.0
			 *
			 * @param string $catname The OPML outline category name.
			 */
			$catname = apply_filters( 'link_category', $cat->name );
			?>
		<outline text="<?php echo esc_attr( $catname ); ?>" description="<?php echo esc_attr( $cat->description ); ?>">
			<?php
			$bookmarks = get_bookmarks(
				array(
					'category' => $cat->term_id,
					'orderby'  => 'link_name',
					'order'    => 'ASC',
				)
			);
			foreach ( (array) $bookmarks as $bookmark ) {
				/**
				 * Filters the OPML outline link title text.
				 *
				 * @since 2.2.0
				 *
				 * @param string $title The OPML outline title text.
				 */
				$title = apply_filters( 'link_title', $bookmark->link_description );
				?>
			<outline text="<?php echo esc_attr( $bookmark->link_name ); ?>" type="link" xmlUrl="<?php echo esc_attr( $bookmark->link_rss ); ?>" htmlUrl="<?php echo esc_attr( $bookmark->link_url ); ?>" updated="<?php if ( '0000-00-00 00:00:00' !== $bookmark->link_updated ) { echo esc_attr( $bookmark->link_updated ); } ?>" title="<?php echo esc_attr( $title ); ?>"/>
				<?php
			}
			?>
		</outline>
			<?php
		}
		?>
	</body>
</opml>
