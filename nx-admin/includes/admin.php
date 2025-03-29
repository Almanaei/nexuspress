<?php
/**
 * Core Administration API
 *
 * @package NexusPress
 * @subpackage Administration
 * @since 2.3.0
 */

if ( ! defined( 'NX_ADMIN' ) ) {
	/*
	 * This file is being included from a file other than nx-admin/admin.php, so
	 * some setup was skipped. Make sure the admin message catalog is loaded since
	 * load_default_textdomain() will not have done so in this context.
	 */
	$admin_locale = get_locale();
	load_textdomain( 'default', NX_LANG_DIR . '/admin-' . $admin_locale . '.mo', $admin_locale );
	unset( $admin_locale );
}

/** NexusPress Administration Hooks */
require_once ABSPATH . 'nx-admin/includes/admin-filters.php';

/** NexusPress Bookmark Administration API */
require_once ABSPATH . 'nx-admin/includes/bookmark.php';

/** NexusPress Comment Administration API */
require_once ABSPATH . 'nx-admin/includes/comment.php';

/** NexusPress Administration File API */
require_once ABSPATH . 'nx-admin/includes/file.php';

/** NexusPress Image Administration API */
require_once ABSPATH . 'nx-admin/includes/image.php';

/** NexusPress Media Administration API */
require_once ABSPATH . 'nx-admin/includes/media.php';

/** NexusPress Import Administration API */
require_once ABSPATH . 'nx-admin/includes/import.php';

/** NexusPress Misc Administration API */
require_once ABSPATH . 'nx-admin/includes/misc.php';

/** NexusPress Misc Administration API */
require_once ABSPATH . 'nx-admin/includes/class-nx-privacy-policy-content.php';

/** NexusPress Options Administration API */
require_once ABSPATH . 'nx-admin/includes/options.php';

/** NexusPress Plugin Administration API */
require_once ABSPATH . 'nx-admin/includes/plugin.php';

/** NexusPress Post Administration API */
require_once ABSPATH . 'nx-admin/includes/post.php';

/** NexusPress Administration Screen API */
require_once ABSPATH . 'nx-admin/includes/class-nx-screen.php';
require_once ABSPATH . 'nx-admin/includes/screen.php';

/** NexusPress Taxonomy Administration API */
require_once ABSPATH . 'nx-admin/includes/taxonomy.php';

/** NexusPress Template Administration API */
require_once ABSPATH . 'nx-admin/includes/template.php';

/** NexusPress List Table Administration API and base class */
require_once ABSPATH . 'nx-admin/includes/class-nx-list-table.php';
require_once ABSPATH . 'nx-admin/includes/class-nx-list-table-compat.php';
require_once ABSPATH . 'nx-admin/includes/list-table.php';

/** NexusPress Theme Administration API */
require_once ABSPATH . 'nx-admin/includes/theme.php';

/** NexusPress Privacy Functions */
require_once ABSPATH . 'nx-admin/includes/privacy-tools.php';

/** NexusPress Privacy List Table classes. */
// Previously in nx-admin/includes/user.php. Need to be loaded for backward compatibility.
require_once ABSPATH . 'nx-admin/includes/class-nx-privacy-requests-table.php';
require_once ABSPATH . 'nx-admin/includes/class-nx-privacy-data-export-requests-list-table.php';
require_once ABSPATH . 'nx-admin/includes/class-nx-privacy-data-removal-requests-list-table.php';

/** NexusPress User Administration API */
require_once ABSPATH . 'nx-admin/includes/user.php';

/** NexusPress Site Icon API */
require_once ABSPATH . 'nx-admin/includes/class-nx-site-icon.php';

/** NexusPress Update Administration API */
require_once ABSPATH . 'nx-admin/includes/update.php';

/** NexusPress Deprecated Administration API */
require_once ABSPATH . 'nx-admin/includes/deprecated.php';

/** NexusPress Multisite support API */
if ( is_multisite() ) {
	require_once ABSPATH . 'nx-admin/includes/ms-admin-filters.php';
	require_once ABSPATH . 'nx-admin/includes/ms.php';
	require_once ABSPATH . 'nx-admin/includes/ms-deprecated.php';
}
