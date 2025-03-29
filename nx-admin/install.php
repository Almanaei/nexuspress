<?php
/**
 * NexusPress Database Installation Script
 *
 * This script creates the NexusPress database structure.
 *
 * @package NexusPress
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Install the NexusPress database structure
 *
 * @return bool True on success, false on failure
 */
function install_nexuspress_db() {
    global $nxdb;
    
    // Get the database charset and collation
    $charset_collate = $nxdb->get_charset_collate();
    
    // Define table names with prefix
    $users_table = $nxdb->prefix . 'users';
    $usermeta_table = $nxdb->prefix . 'usermeta';
    $posts_table = $nxdb->prefix . 'posts';
    $postmeta_table = $nxdb->prefix . 'postmeta';
    $terms_table = $nxdb->prefix . 'terms';
    $termmeta_table = $nxdb->prefix . 'termmeta';
    $term_taxonomy_table = $nxdb->prefix . 'term_taxonomy';
    $term_relationships_table = $nxdb->prefix . 'term_relationships';
    $options_table = $nxdb->prefix . 'options';
    $comments_table = $nxdb->prefix . 'comments';
    $commentmeta_table = $nxdb->prefix . 'commentmeta';
    $links_table = $nxdb->prefix . 'links';
    
    // Create users table
    $sql = "CREATE TABLE IF NOT EXISTS $users_table (
        ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        user_login varchar(60) NOT NULL,
        user_pass varchar(255) NOT NULL,
        user_nicename varchar(50) NOT NULL,
        user_email varchar(100) NOT NULL,
        user_url varchar(100) NOT NULL,
        user_registered datetime NOT NULL,
        user_activation_key varchar(255) NOT NULL,
        user_status int(11) NOT NULL DEFAULT '0',
        display_name varchar(250) NOT NULL,
        PRIMARY KEY  (ID),
        KEY user_login_key (user_login),
        KEY user_nicename (user_nicename),
        KEY user_email (user_email)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'nx-admin/includes/upgrade.php');
    dbDelta($sql);
    
    // Create usermeta table
    $sql = "CREATE TABLE IF NOT EXISTS $usermeta_table (
        umeta_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        user_id bigint(20) unsigned NOT NULL DEFAULT '0',
        meta_key varchar(255) DEFAULT NULL,
        meta_value longtext,
        PRIMARY KEY  (umeta_id),
        KEY user_id (user_id),
        KEY meta_key (meta_key(191))
    ) $charset_collate;";
    
    dbDelta($sql);
    
    // Create posts table
    $sql = "CREATE TABLE IF NOT EXISTS $posts_table (
        ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        post_author bigint(20) unsigned NOT NULL DEFAULT '0',
        post_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        post_date_gmt datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        post_content longtext NOT NULL,
        post_title text NOT NULL,
        post_excerpt text NOT NULL,
        post_status varchar(20) NOT NULL DEFAULT 'publish',
        comment_status varchar(20) NOT NULL DEFAULT 'open',
        ping_status varchar(20) NOT NULL DEFAULT 'open',
        post_name varchar(200) NOT NULL DEFAULT '',
        to_ping text NOT NULL,
        pinged text NOT NULL,
        post_modified datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        post_modified_gmt datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        post_content_filtered longtext NOT NULL,
        post_parent bigint(20) unsigned NOT NULL DEFAULT '0',
        guid varchar(255) NOT NULL DEFAULT '',
        menu_order int(11) NOT NULL DEFAULT '0',
        post_type varchar(20) NOT NULL DEFAULT 'post',
        post_mime_type varchar(100) NOT NULL DEFAULT '',
        comment_count bigint(20) NOT NULL DEFAULT '0',
        filter varchar(255) NOT NULL DEFAULT '',
        PRIMARY KEY  (ID),
        KEY post_name (post_name(191)),
        KEY type_status_date (post_type,post_status,post_date,ID),
        KEY post_parent (post_parent),
        KEY post_author (post_author)
    ) $charset_collate;";
    
    dbDelta($sql);
    
    // Create postmeta table
    $sql = "CREATE TABLE IF NOT EXISTS $postmeta_table (
        meta_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        post_id bigint(20) unsigned NOT NULL DEFAULT '0',
        meta_key varchar(255) DEFAULT NULL,
        meta_value longtext,
        PRIMARY KEY  (meta_id),
        KEY post_id (post_id),
        KEY meta_key (meta_key(191))
    ) $charset_collate;";
    
    dbDelta($sql);
    
    // Create terms table
    $sql = "CREATE TABLE IF NOT EXISTS $terms_table (
        term_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        name varchar(200) NOT NULL DEFAULT '',
        slug varchar(200) NOT NULL DEFAULT '',
        term_group bigint(10) NOT NULL DEFAULT '0',
        PRIMARY KEY  (term_id),
        KEY slug (slug(191)),
        KEY name (name(191))
    ) $charset_collate;";
    
    dbDelta($sql);
    
    // Create termmeta table
    $sql = "CREATE TABLE IF NOT EXISTS $termmeta_table (
        meta_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        term_id bigint(20) unsigned NOT NULL DEFAULT '0',
        meta_key varchar(255) DEFAULT NULL,
        meta_value longtext,
        PRIMARY KEY  (meta_id),
        KEY term_id (term_id),
        KEY meta_key (meta_key(191))
    ) $charset_collate;";
    
    dbDelta($sql);
    
    // Create term_taxonomy table
    $sql = "CREATE TABLE IF NOT EXISTS $term_taxonomy_table (
        term_taxonomy_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        term_id bigint(20) unsigned NOT NULL DEFAULT '0',
        taxonomy varchar(32) NOT NULL DEFAULT '',
        description longtext NOT NULL,
        parent bigint(20) unsigned NOT NULL DEFAULT '0',
        count bigint(20) NOT NULL DEFAULT '0',
        PRIMARY KEY  (term_taxonomy_id),
        UNIQUE KEY term_id_taxonomy (term_id,taxonomy),
        KEY taxonomy (taxonomy)
    ) $charset_collate;";
    
    dbDelta($sql);
    
    // Create term_relationships table
    $sql = "CREATE TABLE IF NOT EXISTS $term_relationships_table (
        object_id bigint(20) unsigned NOT NULL DEFAULT '0',
        term_taxonomy_id bigint(20) unsigned NOT NULL DEFAULT '0',
        term_order int(11) NOT NULL DEFAULT '0',
        PRIMARY KEY  (object_id,term_taxonomy_id),
        KEY term_taxonomy_id (term_taxonomy_id)
    ) $charset_collate;";
    
    dbDelta($sql);
    
    // Create options table
    $sql = "CREATE TABLE IF NOT EXISTS $options_table (
        option_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        option_name varchar(191) NOT NULL DEFAULT '',
        option_value longtext NOT NULL,
        autoload varchar(20) NOT NULL DEFAULT 'yes',
        PRIMARY KEY  (option_id),
        UNIQUE KEY option_name (option_name)
    ) $charset_collate;";
    
    dbDelta($sql);
    
    // Create comments table
    $sql = "CREATE TABLE IF NOT EXISTS $comments_table (
        comment_ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        comment_post_ID bigint(20) unsigned NOT NULL DEFAULT '0',
        comment_author tinytext NOT NULL,
        comment_author_email varchar(100) NOT NULL DEFAULT '',
        comment_author_url varchar(200) NOT NULL DEFAULT '',
        comment_author_IP varchar(100) NOT NULL DEFAULT '',
        comment_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        comment_date_gmt datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        comment_content text NOT NULL,
        comment_karma int(11) NOT NULL DEFAULT '0',
        comment_approved varchar(20) NOT NULL DEFAULT '1',
        comment_agent varchar(255) NOT NULL DEFAULT '',
        comment_type varchar(20) NOT NULL DEFAULT 'comment',
        comment_parent bigint(20) unsigned NOT NULL DEFAULT '0',
        user_id bigint(20) unsigned NOT NULL DEFAULT '0',
        PRIMARY KEY  (comment_ID),
        KEY comment_post_ID (comment_post_ID),
        KEY comment_approved_date_gmt (comment_approved,comment_date_gmt),
        KEY comment_date_gmt (comment_date_gmt),
        KEY comment_parent (comment_parent),
        KEY comment_author_email (comment_author_email(10))
    ) $charset_collate;";
    
    dbDelta($sql);
    
    // Create commentmeta table
    $sql = "CREATE TABLE IF NOT EXISTS $commentmeta_table (
        meta_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        comment_id bigint(20) unsigned NOT NULL DEFAULT '0',
        meta_key varchar(255) DEFAULT NULL,
        meta_value longtext,
        PRIMARY KEY  (meta_id),
        KEY comment_id (comment_id),
        KEY meta_key (meta_key(191))
    ) $charset_collate;";
    
    dbDelta($sql);
    
    // Create links table
    $sql = "CREATE TABLE IF NOT EXISTS $links_table (
        link_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        link_url varchar(255) NOT NULL DEFAULT '',
        link_name varchar(255) NOT NULL DEFAULT '',
        link_image varchar(255) NOT NULL DEFAULT '',
        link_target varchar(25) NOT NULL DEFAULT '',
        link_description varchar(255) NOT NULL DEFAULT '',
        link_visible varchar(20) NOT NULL DEFAULT 'Y',
        link_owner bigint(20) unsigned NOT NULL DEFAULT '1',
        link_rating int(11) NOT NULL DEFAULT '0',
        link_updated datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        link_rel varchar(255) NOT NULL DEFAULT '',
        link_notes mediumtext NOT NULL,
        link_rss varchar(255) NOT NULL DEFAULT '',
        PRIMARY KEY  (link_id),
        KEY link_visible (link_visible)
    ) $charset_collate;";
    
    dbDelta($sql);
    
    return true;
}
