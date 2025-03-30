<?php
/**
 * Basic Theme functions file
 */

// Add theme support
function basic_theme_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let NexusPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');

    // This theme uses nx_nav_menu() in one location
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'basic-theme'),
    ));

    // Switch default core markup for search form, comment form, and comments to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
}
add_action('after_setup_theme', 'basic_theme_setup');

// Register widget area
function basic_theme_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'basic-theme'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here.', 'basic-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'basic_theme_widgets_init');

// Enqueue scripts and styles
function basic_theme_scripts() {
    nx_enqueue_style('basic-theme-style', get_stylesheet_uri());
}
add_action('nx_enqueue_scripts', 'basic_theme_scripts');

// Debug function to show theme loading
function basic_theme_debug() {
    echo "<!-- Basic Theme loaded successfully -->";
}
add_action('nx_footer', 'basic_theme_debug'); 