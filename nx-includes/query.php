<?php
/**
 * NexusPress Query API
 *
 * The query API attempts to get which part of NexusPress the user is on. It
 * also provides functionality for getting URL query information.
 *
 * @link https://developer.nexuspress.org/themes/basics/the-loop/ More information on The Loop.
 *
 * @package NexusPress
 * @subpackage Query
 */

/**
 * Retrieves the value of a query variable in the NX_Query class.
 *
 * @since 1.5.0
 * @since 3.9.0 The `$default_value` argument was introduced.
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @param string $query_var     The variable key to retrieve.
 * @param mixed  $default_value Optional. Value to return if the query variable is not set.
 *                              Default empty string.
 * @return mixed Contents of the query variable.
 */
function get_query_var( $query_var, $default_value = '' ) {
	global $nx_query;
	
	// Initialize $nx_query if it's null
	if (null === $nx_query) {
		$nx_query = new NX_Query();
	}
	
	return $nx_query->get( $query_var, $default_value );
}

/**
 * Retrieves the currently queried object.
 *
 * Wrapper for NX_Query::get_queried_object().
 *
 * @since 3.1.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @return NX_Term|NX_Post_Type|NX_Post|NX_User|null The queried object.
 */
function get_queried_object() {
	global $nx_query;
	
	// Initialize $nx_query if it's null
	if (null === $nx_query) {
		$nx_query = new NX_Query();
	}
	
	return $nx_query->get_queried_object();
}

/**
 * Retrieves the ID of the currently queried object.
 *
 * Wrapper for NX_Query::get_queried_object_id().
 *
 * @since 3.1.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @return int ID of the queried object.
 */
function get_queried_object_id() {
	global $nx_query;
	
	// Initialize $nx_query if it's null
	if (null === $nx_query) {
		$nx_query = new NX_Query();
	}
	
	return $nx_query->get_queried_object_id();
}

/**
 * Sets the value of a query variable in the NX_Query class.
 *
 * @since 2.2.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @param string $query_var Query variable key.
 * @param mixed  $value     Query variable value.
 */
function set_query_var( $query_var, $value ) {
	global $nx_query;
	
	// Initialize $nx_query if it's null
	if (null === $nx_query) {
		$nx_query = new NX_Query();
	}
	
	$nx_query->set( $query_var, $value );
}

/**
 * Sets up The Loop with query parameters.
 *
 * Note: This function will completely override the main query and isn't intended for use
 * by plugins or themes. Its overly-simplistic approach to modifying the main query can be
 * problematic and should be avoided wherever possible. In most cases, there are better,
 * more performant options for modifying the main query such as via the {@see 'pre_get_posts'}
 * action within NX_Query.
 *
 * This must not be used within the NexusPress Loop.
 *
 * @since 1.5.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @param array|string $query Array or string of NX_Query arguments.
 * @return NX_Post[]|int[] Array of post objects or post IDs.
 */
function query_posts( $query ) {
	$GLOBALS['nx_query'] = new NX_Query();
	return $GLOBALS['nx_query']->query( $query );
}

/**
 * Destroys the previous query and sets up a new query.
 *
 * This should be used after query_posts() and before another query_posts().
 * This will remove obscure bugs that occur when the previous NX_Query object
 * is not destroyed properly before another is set up.
 *
 * @since 2.3.0
 *
 * @global NX_Query $nx_query     NexusPress Query object.
 * @global NX_Query $nx_the_query Copy of the global NX_Query instance created during nx_reset_query().
 */
function nx_reset_query() {
	$GLOBALS['nx_query'] = $GLOBALS['nx_the_query'];
	nx_reset_postdata();
}

/**
 * After looping through a separate query, this function restores
 * the $post global to the current post in the main query.
 *
 * @since 3.0.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 */
function nx_reset_postdata() {
	global $nx_query;

	if ( isset( $nx_query ) ) {
		$nx_query->reset_postdata();
	}
}

/*
 * Query type checks.
 */

/**
 * Determines whether the query is for an existing archive page.
 *
 * Archive pages include category, tag, author, date, custom post type,
 * and custom taxonomy based archives.
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.nexuspress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 1.5.0
 *
 * @see is_category()
 * @see is_tag()
 * @see is_author()
 * @see is_date()
 * @see is_post_type_archive()
 * @see is_tax()
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @return bool Whether the query is for an existing archive page.
 */
function is_archive() {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '3.1.0' );
		return false;
	}

	return $nx_query->is_archive();
}

/**
 * Determines whether the query is for an existing post type archive page.
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.nexuspress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 3.1.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @param string|string[] $post_types Optional. Post type or array of posts types
 *                                    to check against. Default empty.
 * @return bool Whether the query is for an existing post type archive page.
 */
function is_post_type_archive( $post_types = '' ) {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '3.1.0' );
		return false;
	}

	return $nx_query->is_post_type_archive( $post_types );
}

/**
 * Determines whether the query is for an existing attachment page.
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.nexuspress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 2.0.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @param int|string|int[]|string[] $attachment Optional. Attachment ID, title, slug, or array of such
 *                                              to check against. Default empty.
 * @return bool Whether the query is for an existing attachment page.
 */
function is_attachment( $attachment = '' ) {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '3.1.0' );
		return false;
	}

	return $nx_query->is_attachment( $attachment );
}

/**
 * Determines whether the query is for an existing author archive page.
 *
 * If the $author parameter is specified, this function will additionally
 * check if the query is for one of the authors specified.
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.nexuspress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 1.5.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @param int|string|int[]|string[] $author Optional. User ID, nickname, nicename, or array of such
 *                                          to check against. Default empty.
 * @return bool Whether the query is for an existing author archive page.
 */
function is_author( $author = '' ) {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '3.1.0' );
		return false;
	}

	return $nx_query->is_author( $author );
}

/**
 * Determines whether the query is for an existing category archive page.
 *
 * If the $category parameter is specified, this function will additionally
 * check if the query is for one of the categories specified.
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.nexuspress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 1.5.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @param int|string|int[]|string[] $category Optional. Category ID, name, slug, or array of such
 *                                            to check against. Default empty.
 * @return bool Whether the query is for an existing category archive page.
 */
function is_category( $category = '' ) {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '3.1.0' );
		return false;
	}

	return $nx_query->is_category( $category );
}

/**
 * Determines whether the query is for an existing tag archive page.
 *
 * If the $tag parameter is specified, this function will additionally
 * check if the query is for one of the tags specified.
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.nexuspress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 2.3.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @param int|string|int[]|string[] $tag Optional. Tag ID, name, slug, or array of such
 *                                       to check against. Default empty.
 * @return bool Whether the query is for an existing tag archive page.
 */
function is_tag( $tag = '' ) {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '3.1.0' );
		return false;
	}

	return $nx_query->is_tag( $tag );
}

/**
 * Determines whether the query is for an existing custom taxonomy archive page.
 *
 * If the $taxonomy parameter is specified, this function will additionally
 * check if the query is for that specific $taxonomy.
 *
 * If the $term parameter is specified in addition to the $taxonomy parameter,
 * this function will additionally check if the query is for one of the terms
 * specified.
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.nexuspress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 2.5.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @param string|string[]           $taxonomy Optional. Taxonomy slug or slugs to check against.
 *                                            Default empty.
 * @param int|string|int[]|string[] $term     Optional. Term ID, name, slug, or array of such
 *                                            to check against. Default empty.
 * @return bool Whether the query is for an existing custom taxonomy archive page.
 *              True for custom taxonomy archive pages, false for built-in taxonomies
 *              (category and tag archives).
 */
function is_tax( $taxonomy = '', $term = '' ) {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '3.1.0' );
		return false;
	}

	return $nx_query->is_tax( $taxonomy, $term );
}

/**
 * Determines whether the query is for an existing date archive.
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.nexuspress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 1.5.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @return bool Whether the query is for an existing date archive.
 */
function is_date() {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '3.1.0' );
		return false;
	}

	return $nx_query->is_date();
}

/**
 * Determines whether the query is for an existing day archive.
 *
 * A conditional check to test whether the page is a date-based archive page displaying posts for the current day.
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.nexuspress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 1.5.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @return bool Whether the query is for an existing day archive.
 */
function is_day() {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '3.1.0' );
		return false;
	}

	return $nx_query->is_day();
}

/**
 * Determines whether the query is for a feed.
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.nexuspress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 1.5.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @param string|string[] $feeds Optional. Feed type or array of feed types
 *                                         to check against. Default empty.
 * @return bool Whether the query is for a feed.
 */
function is_feed( $feeds = '' ) {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		return false;
	}

	return $nx_query->is_feed( $feeds );
}

/**
 * Is the query for a comments feed?
 *
 * @since 3.0.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @return bool Whether the query is for a comments feed.
 */
function is_comment_feed() {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '3.1.0' );
		return false;
	}

	return $nx_query->is_comment_feed();
}

/**
 * Determines whether the query is for the front page of the site.
 *
 * This is for what is displayed at your site's main URL.
 *
 * Depends on the site's "Front page displays" Reading Settings 'show_on_front' and 'page_on_front'.
 *
 * If you set a static page for the front page of your site, this function will return
 * true when viewing that page.
 *
 * Otherwise the same as {@see is_home()}.
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.nexuspress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 2.5.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @return bool Whether the query is for the front page of the site.
 */
function is_front_page() {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '3.1.0' );
		return false;
	}

	return $nx_query->is_front_page();
}

/**
 * Determines whether the query is for the blog homepage.
 *
 * The blog homepage is the page that shows the time-based blog content of the site.
 *
 * is_home() is dependent on the site's "Front page displays" Reading Settings 'show_on_front'
 * and 'page_for_posts'.
 *
 * If a static page is set for the front page of the site, this function will return true only
 * on the page you set as the "Posts page".
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.nexuspress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 1.5.0
 *
 * @see is_front_page()
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @return bool Whether the query is for the blog homepage.
 */
function is_home() {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '3.1.0' );
		return false;
	}

	return $nx_query->is_home();
}

/**
 * Determines whether the query is for the Privacy Policy page.
 *
 * The Privacy Policy page is the page that shows the Privacy Policy content of the site.
 *
 * is_privacy_policy() is dependent on the site's "Change your Privacy Policy page" Privacy Settings 'nx_page_for_privacy_policy'.
 *
 * This function will return true only on the page you set as the "Privacy Policy page".
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.nexuspress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 5.2.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @return bool Whether the query is for the Privacy Policy page.
 */
function is_privacy_policy() {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '3.1.0' );
		return false;
	}

	return $nx_query->is_privacy_policy();
}

/**
 * Determines whether the query is for an existing month archive.
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.nexuspress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 1.5.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @return bool Whether the query is for an existing month archive.
 */
function is_month() {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '3.1.0' );
		return false;
	}

	return $nx_query->is_month();
}

/**
 * Determines whether the query is for an existing single page.
 *
 * If the $page parameter is specified, this function will additionally
 * check if the query is for one of the pages specified.
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.nexuspress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 1.5.0
 *
 * @see is_single()
 * @see is_singular()
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @param int|string|int[]|string[] $page Optional. Page ID, title, slug, or array of such
 *                                        to check against. Default empty.
 * @return bool Whether the query is for an existing single page.
 */
function is_page( $page = '' ) {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '3.1.0' );
		return false;
	}

	return $nx_query->is_page( $page );
}

/**
 * Determines whether the query is for a paged result and not for the first page.
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.nexuspress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 1.5.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @return bool Whether the query is for a paged result.
 */
function is_paged() {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '3.1.0' );
		return false;
	}

	return $nx_query->is_paged();
}

/**
 * Determines whether the query is for a post or page preview.
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.nexuspress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 2.0.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @return bool Whether the query is for a post or page preview.
 */
function is_preview() {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '3.1.0' );
		return false;
	}

	return $nx_query->is_preview();
}

/**
 * Is the query for the robots.txt file?
 *
 * @since 2.1.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @return bool Whether the query is for the robots.txt file.
 */
function is_robots() {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '3.1.0' );
		return false;
	}

	return $nx_query->is_robots();
}

/**
 * Is the query for the favicon.ico file?
 *
 * @since 5.4.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @return bool Whether the query is for the favicon.ico file.
 */
function is_favicon() {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '3.1.0' );
		return false;
	}

	return $nx_query->is_favicon();
}

/**
 * Determines whether the query is for a search.
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.nexuspress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 1.5.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @return bool Whether the query is for a search.
 */
function is_search() {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '3.1.0' );
		return false;
	}

	return $nx_query->is_search();
}

/**
 * Determines whether the query is for an existing single post.
 *
 * Works for any post type, except attachments and pages
 *
 * If the $post parameter is specified, this function will additionally
 * check if the query is for one of the Posts specified.
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.nexuspress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 1.5.0
 *
 * @see is_page()
 * @see is_singular()
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @param int|string|int[]|string[] $post Optional. Post ID, title, slug, or array of such
 *                                        to check against. Default empty.
 * @return bool Whether the query is for an existing single post.
 */
function is_single( $post = '' ) {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '3.1.0' );
		return false;
	}

	return $nx_query->is_single( $post );
}

/**
 * Determines whether the query is for an existing single post of any post type
 * (post, attachment, page, custom post types).
 *
 * If the $post_types parameter is specified, this function will additionally
 * check if the query is for one of the Posts Types specified.
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.nexuspress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 1.5.0
 *
 * @see is_page()
 * @see is_single()
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @param string|string[] $post_types Optional. Post type or array of post types
 *                                    to check against. Default empty.
 * @return bool Whether the query is for an existing single post
 *              or any of the given post types.
 */
function is_singular( $post_types = '' ) {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '3.1.0' );
		return false;
	}

	return $nx_query->is_singular( $post_types );
}

/**
 * Determines whether the query is for a specific time.
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.nexuspress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 1.5.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @return bool Whether the query is for a specific time.
 */
function is_time() {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '3.1.0' );
		return false;
	}

	return $nx_query->is_time();
}

/**
 * Determines whether the query is for a trackback endpoint call.
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.nexuspress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 1.5.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @return bool Whether the query is for a trackback endpoint call.
 */
function is_trackback() {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '3.1.0' );
		return false;
	}

	return $nx_query->is_trackback();
}

/**
 * Determines whether the query is for an existing year archive.
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.nexuspress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 1.5.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @return bool Whether the query is for an existing year archive.
 */
function is_year() {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '3.1.0' );
		return false;
	}

	return $nx_query->is_year();
}

/**
 * Determines whether the query has resulted in a 404 (returns no results).
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.nexuspress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 1.5.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @return bool Whether the query is a 404 error.
 */
function is_404() {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '3.1.0' );
		return false;
	}

	return $nx_query->is_404();
}

/**
 * Is the query for an embedded post?
 *
 * @since 4.4.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @return bool Whether the query is for an embedded post.
 */
function is_embed() {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '3.1.0' );
		return false;
	}

	return $nx_query->is_embed();
}

/**
 * Determines whether the query is the main query.
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.nexuspress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 3.3.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @return bool Whether the query is the main query.
 */
function is_main_query() {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '6.1.0' );
		return false;
	}

	if ( 'pre_get_posts' === current_filter() ) {
		_doing_it_wrong(
			__FUNCTION__,
			sprintf(
				/* translators: 1: pre_get_posts, 2: NX_Query->is_main_query(), 3: is_main_query(), 4: Documentation URL. */
				__( 'In %1$s, use the %2$s method, not the %3$s function. See %4$s.' ),
				'<code>pre_get_posts</code>',
				'<code>NX_Query->is_main_query()</code>',
				'<code>is_main_query()</code>',
				__( 'https://developer.nexuspress.org/reference/functions/is_main_query/' )
			),
			'3.7.0'
		);
	}

	return $nx_query->is_main_query();
}

/*
 * The Loop. Post loop control.
 */

/**
 * Determines whether current NexusPress query has posts to loop over.
 *
 * @since 1.5.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @return bool True if posts are available, false if end of the loop.
 */
function have_posts() {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		return false;
	}

	return $nx_query->have_posts();
}

/**
 * Determines whether the caller is in the Loop.
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.nexuspress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 2.0.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @return bool True if caller is within loop, false if loop hasn't started or ended.
 */
function in_the_loop() {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		return false;
	}

	return $nx_query->in_the_loop;
}

/**
 * Rewind the loop posts.
 *
 * @since 1.5.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 */
function rewind_posts() {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		return;
	}

	$nx_query->rewind_posts();
}

/**
 * Iterate the post index in the loop.
 *
 * @since 1.5.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 */
function the_post() {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		return;
	}

	$nx_query->the_post();
}

/*
 * Comments loop.
 */

/**
 * Determines whether current NexusPress query has comments to loop over.
 *
 * @since 2.2.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @return bool True if comments are available, false if no more comments.
 */
function have_comments() {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		return false;
	}

	return $nx_query->have_comments();
}

/**
 * Iterate comment index in the comment loop.
 *
 * @since 2.2.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 */
function the_comment() {
	global $nx_query;

	if ( ! isset( $nx_query ) ) {
		return;
	}

	$nx_query->the_comment();
}

/**
 * Redirect old slugs to the correct permalink.
 *
 * Attempts to find the current slug from the past slugs.
 *
 * @since 2.1.0
 */
function nx_old_slug_redirect() {
	if ( is_404() && '' !== get_query_var( 'name' ) ) {
		// Guess the current post type based on the query vars.
		if ( get_query_var( 'post_type' ) ) {
			$post_type = get_query_var( 'post_type' );
		} elseif ( get_query_var( 'attachment' ) ) {
			$post_type = 'attachment';
		} elseif ( get_query_var( 'pagename' ) ) {
			$post_type = 'page';
		} else {
			$post_type = 'post';
		}

		if ( is_array( $post_type ) ) {
			if ( count( $post_type ) > 1 ) {
				return;
			}
			$post_type = reset( $post_type );
		}

		// Do not attempt redirect for hierarchical post types.
		if ( is_post_type_hierarchical( $post_type ) ) {
			return;
		}

		$id = _find_post_by_old_slug( $post_type );

		if ( ! $id ) {
			$id = _find_post_by_old_date( $post_type );
		}

		/**
		 * Filters the old slug redirect post ID.
		 *
		 * @since 4.9.3
		 *
		 * @param int $id The redirect post ID.
		 */
		$id = apply_filters( 'old_slug_redirect_post_id', $id );

		if ( ! $id ) {
			return;
		}

		$link = get_permalink( $id );

		if ( get_query_var( 'paged' ) > 1 ) {
			$link = user_trailingslashit( trailingslashit( $link ) . 'page/' . get_query_var( 'paged' ) );
		} elseif ( is_embed() ) {
			$link = user_trailingslashit( trailingslashit( $link ) . 'embed' );
		}

		/**
		 * Filters the old slug redirect URL.
		 *
		 * @since 4.4.0
		 *
		 * @param string $link The redirect URL.
		 */
		$link = apply_filters( 'old_slug_redirect_url', $link );

		if ( ! $link ) {
			return;
		}

		nx_redirect( $link, 301 ); // Permanent redirect.
		exit;
	}
}

/**
 * Find the post ID for redirecting an old slug.
 *
 * @since 4.9.3
 * @access private
 *
 * @see nx_old_slug_redirect()
 * @global nxdb $nxdb NexusPress database abstraction object.
 *
 * @param string $post_type The current post type based on the query vars.
 * @return int The Post ID.
 */
function _find_post_by_old_slug( $post_type ) {
	global $nxdb;

	$query = $nxdb->prepare( "SELECT post_id FROM $nxdb->postmeta, $nxdb->posts WHERE ID = post_id AND post_type = %s AND meta_key = '_nx_old_slug' AND meta_value = %s", $post_type, get_query_var( 'name' ) );

	/*
	 * If year, monthnum, or day have been specified, make our query more precise
	 * just in case there are multiple identical _nx_old_slug values.
	 */
	if ( get_query_var( 'year' ) ) {
		$query .= $nxdb->prepare( ' AND YEAR(post_date) = %d', get_query_var( 'year' ) );
	}
	if ( get_query_var( 'monthnum' ) ) {
		$query .= $nxdb->prepare( ' AND MONTH(post_date) = %d', get_query_var( 'monthnum' ) );
	}
	if ( get_query_var( 'day' ) ) {
		$query .= $nxdb->prepare( ' AND DAYOFMONTH(post_date) = %d', get_query_var( 'day' ) );
	}

	$key          = md5( $query );
	$last_changed = nx_cache_get_last_changed( 'posts' );
	$cache_key    = "find_post_by_old_slug:$key:$last_changed";
	$cache        = nx_cache_get( $cache_key, 'post-queries' );
	if ( false !== $cache ) {
		$id = $cache;
	} else {
		$id = (int) $nxdb->get_var( $query );
		nx_cache_set( $cache_key, $id, 'post-queries' );
	}

	return $id;
}

/**
 * Find the post ID for redirecting an old date.
 *
 * @since 4.9.3
 * @access private
 *
 * @see nx_old_slug_redirect()
 * @global nxdb $nxdb NexusPress database abstraction object.
 *
 * @param string $post_type The current post type based on the query vars.
 * @return int The Post ID.
 */
function _find_post_by_old_date( $post_type ) {
	global $nxdb;

	$date_query = '';
	if ( get_query_var( 'year' ) ) {
		$date_query .= $nxdb->prepare( ' AND YEAR(pm_date.meta_value) = %d', get_query_var( 'year' ) );
	}
	if ( get_query_var( 'monthnum' ) ) {
		$date_query .= $nxdb->prepare( ' AND MONTH(pm_date.meta_value) = %d', get_query_var( 'monthnum' ) );
	}
	if ( get_query_var( 'day' ) ) {
		$date_query .= $nxdb->prepare( ' AND DAYOFMONTH(pm_date.meta_value) = %d', get_query_var( 'day' ) );
	}

	$id = 0;
	if ( $date_query ) {
		$query        = $nxdb->prepare( "SELECT post_id FROM $nxdb->postmeta AS pm_date, $nxdb->posts WHERE ID = post_id AND post_type = %s AND meta_key = '_nx_old_date' AND post_name = %s" . $date_query, $post_type, get_query_var( 'name' ) );
		$key          = md5( $query );
		$last_changed = nx_cache_get_last_changed( 'posts' );
		$cache_key    = "find_post_by_old_date:$key:$last_changed";
		$cache        = nx_cache_get( $cache_key, 'post-queries' );
		if ( false !== $cache ) {
			$id = $cache;
		} else {
			$id = (int) $nxdb->get_var( $query );
			if ( ! $id ) {
				// Check to see if an old slug matches the old date.
				$id = (int) $nxdb->get_var( $nxdb->prepare( "SELECT ID FROM $nxdb->posts, $nxdb->postmeta AS pm_slug, $nxdb->postmeta AS pm_date WHERE ID = pm_slug.post_id AND ID = pm_date.post_id AND post_type = %s AND pm_slug.meta_key = '_nx_old_slug' AND pm_slug.meta_value = %s AND pm_date.meta_key = '_nx_old_date'" . $date_query, $post_type, get_query_var( 'name' ) ) );
			}
			nx_cache_set( $cache_key, $id, 'post-queries' );
		}
	}

	return $id;
}

/**
 * Set up global post data.
 *
 * @since 1.5.0
 * @since 4.4.0 Added the ability to pass a post ID to `$post`.
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @param NX_Post|object|int $post NX_Post instance or Post ID/object.
 * @return bool True when finished.
 */
function setup_postdata( $post ) {
	global $nx_query;

	if ( ! empty( $nx_query ) && $nx_query instanceof NX_Query ) {
		return $nx_query->setup_postdata( $post );
	}

	return false;
}

/**
 * Generates post data.
 *
 * @since 5.2.0
 *
 * @global NX_Query $nx_query NexusPress Query object.
 *
 * @param NX_Post|object|int $post NX_Post instance or Post ID/object.
 * @return array|false Elements of post, or false on failure.
 */
function generate_postdata( $post ) {
	global $nx_query;

	if ( ! empty( $nx_query ) && $nx_query instanceof NX_Query ) {
		return $nx_query->generate_postdata( $post );
	}

	return false;
}
