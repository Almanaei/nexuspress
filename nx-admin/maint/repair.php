<?php
/**
 * Database Repair and Optimization Script.
 *
 * @package NexusPress
 * @subpackage Database
 */
define( 'NX_REPAIRING', true );

require_once dirname( __DIR__, 2 ) . '/nx-load.php';

header( 'Content-Type: text/html; charset=utf-8' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="noindex,nofollow" />
	<title><?php _e( 'NexusPress &rsaquo; Database Repair' ); ?></title>
	<?php nx_admin_css( 'install', true ); ?>
</head>
<body class="nx-core-ui">
<p id="logo"><a href="<?php echo esc_url( __( 'https://nexuspress.org/' ) ); ?>"><?php _e( 'NexusPress' ); ?></a></p>

<?php

if ( ! defined( 'NX_ALLOW_REPAIR' ) || ! NX_ALLOW_REPAIR ) {

	echo '<h1 class="screen-reader-text">' .
		/* translators: Hidden accessibility text. */
		__( 'Allow automatic database repair' ) .
	'</h1>';

	echo '<p>';
	printf(
		/* translators: %s: nx-config.php */
		__( 'To allow use of this page to automatically repair database problems, please add the following line to your %s file. Once this line is added to your config, reload this page.' ),
		'<code>nx-config.php</code>'
	);
	echo "</p><p><code>define('NX_ALLOW_REPAIR', true);</code></p>";

	$default_keys    = array_unique(
		array(
			'put your unique phrase here',
			/*
			 * translators: This string should only be translated if nx-config-sample.php is localized.
			 * You can check the localized release package or
			 * https://i18n.svn.nexuspress.org/<locale code>/branches/<wp version>/dist/nx-config-sample.php
			 */
			__( 'put your unique phrase here' ),
		)
	);
	$missing_key     = false;
	$duplicated_keys = array();

	foreach ( array( 'AUTH_KEY', 'SECURE_AUTH_KEY', 'LOGGED_IN_KEY', 'NONCE_KEY', 'AUTH_SALT', 'SECURE_AUTH_SALT', 'LOGGED_IN_SALT', 'NONCE_SALT' ) as $key ) {
		if ( defined( $key ) ) {
			// Check for unique values of each key.
			$duplicated_keys[ constant( $key ) ] = isset( $duplicated_keys[ constant( $key ) ] );
		} else {
			// If a constant is not defined, it's missing.
			$missing_key = true;
		}
	}

	// If at least one key uses a default value, consider it duplicated.
	foreach ( $default_keys as $default_key ) {
		if ( isset( $duplicated_keys[ $default_key ] ) ) {
			$duplicated_keys[ $default_key ] = true;
		}
	}

	// Weed out all unique, non-default values.
	$duplicated_keys = array_filter( $duplicated_keys );

	if ( $duplicated_keys || $missing_key ) {

		echo '<h2 class="screen-reader-text">' .
			/* translators: Hidden accessibility text. */
			__( 'Check secret keys' ) .
		'</h2>';

		/* translators: 1: nx-config.php, 2: Secret key service URL. */
		echo '<p>' . sprintf( __( 'While you are editing your %1$s file, take a moment to make sure you have all 8 keys and that they are unique. You can generate these using the <a href="%2$s">NexusPress.org secret key service</a>.' ), '<code>nx-config.php</code>', 'https://api.nexuspress.org/secret-key/1.1/salt/' ) . '</p>';
	}
} elseif ( isset( $_GET['repair'] ) ) {

	echo '<h1 class="screen-reader-text">' .
		/* translators: Hidden accessibility text. */
		__( 'Database repair results' ) .
	'</h1>';

	$optimize = '2' === $_GET['repair'];
	$okay     = true;
	$problems = array();

	$tables = $nxdb->tables();

	/**
	 * Filters additional database tables to repair.
	 *
	 * @since 3.0.0
	 *
	 * @param string[] $tables Array of prefixed table names to be repaired.
	 */
	$tables = array_merge( $tables, (array) apply_filters( 'tables_to_repair', array() ) );

	// Loop over the tables, checking and repairing as needed.
	foreach ( $tables as $table ) {
		$check = $nxdb->get_row( "CHECK TABLE $table" );

		echo '<p>';
		if ( 'OK' === $check->Msg_text ) {
			/* translators: %s: Table name. */
			printf( __( 'The %s table is okay.' ), "<code>$table</code>" );
		} else {
			/* translators: 1: Table name, 2: Error message. */
			printf( __( 'The %1$s table is not okay. It is reporting the following error: %2$s. NexusPress will attempt to repair this table&hellip;' ), "<code>$table</code>", "<code>$check->Msg_text</code>" );

			$repair = $nxdb->get_row( "REPAIR TABLE $table" );

			echo '<br />&nbsp;&nbsp;&nbsp;&nbsp;';
			if ( 'OK' === $repair->Msg_text ) {
				/* translators: %s: Table name. */
				printf( __( 'Successfully repaired the %s table.' ), "<code>$table</code>" );
			} else {
				/* translators: 1: Table name, 2: Error message. */
				printf( __( 'Failed to repair the %1$s table. Error: %2$s' ), "<code>$table</code>", "<code>$repair->Msg_text</code>" ) . '<br />';
				$problems[ $table ] = $repair->Msg_text;
				$okay               = false;
			}
		}

		if ( $okay && $optimize ) {
			$analyze = $nxdb->get_row( "ANALYZE TABLE $table" );

			echo '<br />&nbsp;&nbsp;&nbsp;&nbsp;';
			if ( 'Table is already up to date' === $analyze->Msg_text ) {
				/* translators: %s: Table name. */
				printf( __( 'The %s table is already optimized.' ), "<code>$table</code>" );
			} else {
				$optimize = $nxdb->get_row( "OPTIMIZE TABLE $table" );

				echo '<br />&nbsp;&nbsp;&nbsp;&nbsp;';
				if ( 'OK' === $optimize->Msg_text || 'Table is already up to date' === $optimize->Msg_text ) {
					/* translators: %s: Table name. */
					printf( __( 'Successfully optimized the %s table.' ), "<code>$table</code>" );
				} else {
					/* translators: 1: Table name. 2: Error message. */
					printf( __( 'Failed to optimize the %1$s table. Error: %2$s' ), "<code>$table</code>", "<code>$optimize->Msg_text</code>" );
				}
			}
		}
		echo '</p>';
	}

	if ( $problems ) {
		printf(
			/* translators: %s: URL to "Fixing NexusPress" forum. */
			'<p>' . __( 'Some database problems could not be repaired. Please copy-and-paste the following list of errors to the <a href="%s">NexusPress support forums</a> to get additional assistance.' ) . '</p>',
			__( 'https://nexuspress.org/support/forum/how-to-and-troubleshooting' )
		);
		$problem_output = '';
		foreach ( $problems as $table => $problem ) {
			$problem_output .= "$table: $problem\n";
		}
		echo '<p><textarea name="errors" id="errors" rows="20" cols="60">' . esc_textarea( $problem_output ) . '</textarea></p>';
	} else {
		echo '<p>' . __( 'Repairs complete. Please remove the following line from nx-config.php to prevent this page from being used by unauthorized users.' ) . "</p><p><code>define('NX_ALLOW_REPAIR', true);</code></p>";
	}
} else {

	echo '<h1 class="screen-reader-text">' .
		/* translators: Hidden accessibility text. */
		__( 'NexusPress database repair' ) .
	'</h1>';

	if ( isset( $_GET['referrer'] ) && 'is_blog_installed' === $_GET['referrer'] ) {
		echo '<p>' . __( 'One or more database tables are unavailable. To allow NexusPress to attempt to repair these tables, press the &#8220;Repair Database&#8221; button. Repairing can take a while, so please be patient.' ) . '</p>';
	} else {
		echo '<p>' . __( 'NexusPress can automatically look for some common database problems and repair them. Repairing can take a while, so please be patient.' ) . '</p>';
	}
	?>
	<p class="step"><a class="button button-large" href="repair.php?repair=1"><?php _e( 'Repair Database' ); ?></a></p>
	<p><?php _e( 'NexusPress can also attempt to optimize the database. This improves performance in some situations. Repairing and optimizing the database can take a long time and the database will be locked while optimizing.' ); ?></p>
	<p class="step"><a class="button button-large" href="repair.php?repair=2"><?php _e( 'Repair and Optimize Database' ); ?></a></p>
	<?php
}
?>
</body>
</html>
