<?php
/**
 * Multisite administration panel.
 *
 * @package NexusPress
 * @subpackage Multisite
 * @since 3.0.0
 */

require_once __DIR__ . '/admin.php';

nx_redirect( network_admin_url() );
exit;
