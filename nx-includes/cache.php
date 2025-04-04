<?php
/**
 * Object Cache API
 *
 * @link https://developer.nexuspress.org/reference/classes/nx_object_cache/
 *
 * @package NexusPress
 * @subpackage Cache
 */

/** NX_Object_Cache class */
require_once ABSPATH . NXINC . '/class-nx-object-cache.php';

/**
 * Sets up Object Cache Global and assigns it.
 *
 * @since 2.0.0
 *
 * @global NX_Object_Cache $nx_object_cache
 */
function nx_cache_init() {
	$GLOBALS['nx_object_cache'] = new NX_Object_Cache();
}

/**
 * Adds data to the cache, if the cache key doesn't already exist.
 *
 * @since 2.0.0
 *
 * @see NX_Object_Cache::add()
 * @global NX_Object_Cache $nx_object_cache Object cache global instance.
 *
 * @param int|string $key    The cache key to use for retrieval later.
 * @param mixed      $data   The data to add to the cache.
 * @param string     $group  Optional. The group to add the cache to. Enables the same key
 *                           to be used across groups. Default empty.
 * @param int        $expire Optional. When the cache data should expire, in seconds.
 *                           Default 0 (no expiration).
 * @return bool True on success, false if cache key and group already exist.
 */
function nx_cache_add( $key, $data, $group = '', $expire = 0 ) {
	global $nx_object_cache;

	return $nx_object_cache->add( $key, $data, $group, (int) $expire );
}

/**
 * Adds multiple values to the cache in one call.
 *
 * @since 6.0.0
 *
 * @see NX_Object_Cache::add_multiple()
 * @global NX_Object_Cache $nx_object_cache Object cache global instance.
 *
 * @param array  $data   Array of keys and values to be set.
 * @param string $group  Optional. Where the cache contents are grouped. Default empty.
 * @param int    $expire Optional. When to expire the cache contents, in seconds.
 *                       Default 0 (no expiration).
 * @return bool[] Array of return values, grouped by key. Each value is either
 *                true on success, or false if cache key and group already exist.
 */
function nx_cache_add_multiple( array $data, $group = '', $expire = 0 ) {
	global $nx_object_cache;

	return $nx_object_cache->add_multiple( $data, $group, $expire );
}

/**
 * Replaces the contents of the cache with new data.
 *
 * @since 2.0.0
 *
 * @see NX_Object_Cache::replace()
 * @global NX_Object_Cache $nx_object_cache Object cache global instance.
 *
 * @param int|string $key    The key for the cache data that should be replaced.
 * @param mixed      $data   The new data to store in the cache.
 * @param string     $group  Optional. The group for the cache data that should be replaced.
 *                           Default empty.
 * @param int        $expire Optional. When to expire the cache contents, in seconds.
 *                           Default 0 (no expiration).
 * @return bool True if contents were replaced, false if original value does not exist.
 */
function nx_cache_replace( $key, $data, $group = '', $expire = 0 ) {
	global $nx_object_cache;

	return $nx_object_cache->replace( $key, $data, $group, (int) $expire );
}

/**
 * Saves the data to the cache.
 *
 * Differs from nx_cache_add() and nx_cache_replace() in that it will always write data.
 *
 * @since 2.0.0
 *
 * @see NX_Object_Cache::set()
 * @global NX_Object_Cache $nx_object_cache Object cache global instance.
 *
 * @param int|string $key    The cache key to use for retrieval later.
 * @param mixed      $data   The contents to store in the cache.
 * @param string     $group  Optional. Where to group the cache contents. Enables the same key
 *                           to be used across groups. Default empty.
 * @param int        $expire Optional. When to expire the cache contents, in seconds.
 *                           Default 0 (no expiration).
 * @return bool True on success, false on failure.
 */
function nx_cache_set( $key, $data, $group = '', $expire = 0 ) {
	global $nx_object_cache;

	return $nx_object_cache->set( $key, $data, $group, (int) $expire );
}

/**
 * Sets multiple values to the cache in one call.
 *
 * @since 6.0.0
 *
 * @see NX_Object_Cache::set_multiple()
 * @global NX_Object_Cache $nx_object_cache Object cache global instance.
 *
 * @param array  $data   Array of keys and values to be set.
 * @param string $group  Optional. Where the cache contents are grouped. Default empty.
 * @param int    $expire Optional. When to expire the cache contents, in seconds.
 *                       Default 0 (no expiration).
 * @return bool[] Array of return values, grouped by key. Each value is either
 *                true on success, or false on failure.
 */
function nx_cache_set_multiple( array $data, $group = '', $expire = 0 ) {
	global $nx_object_cache;

	return $nx_object_cache->set_multiple( $data, $group, $expire );
}

/**
 * Retrieves the cache contents from the cache by key and group.
 *
 * @since 2.0.0
 *
 * @see NX_Object_Cache::get()
 * @global NX_Object_Cache $nx_object_cache Object cache global instance.
 *
 * @param int|string $key   The key under which the cache contents are stored.
 * @param string     $group Optional. Where the cache contents are grouped. Default empty.
 * @param bool       $force Optional. Whether to force an update of the local cache
 *                          from the persistent cache. Default false.
 * @param bool       $found Optional. Whether the key was found in the cache (passed by reference).
 *                          Disambiguates a return of false, a storable value. Default null.
 * @return mixed|false The cache contents on success, false on failure to retrieve contents.
 */
function nx_cache_get( $key, $group = '', $force = false, &$found = null ) {
	global $nx_object_cache;

	return $nx_object_cache->get( $key, $group, $force, $found );
}

/**
 * Retrieves multiple values from the cache in one call.
 *
 * @since 5.5.0
 *
 * @see NX_Object_Cache::get_multiple()
 * @global NX_Object_Cache $nx_object_cache Object cache global instance.
 *
 * @param array  $keys  Array of keys under which the cache contents are stored.
 * @param string $group Optional. Where the cache contents are grouped. Default empty.
 * @param bool   $force Optional. Whether to force an update of the local cache
 *                      from the persistent cache. Default false.
 * @return array Array of return values, grouped by key. Each value is either
 *               the cache contents on success, or false on failure.
 */
function nx_cache_get_multiple( $keys, $group = '', $force = false ) {
	global $nx_object_cache;

	return $nx_object_cache->get_multiple( $keys, $group, $force );
}

/**
 * Removes the cache contents matching key and group.
 *
 * @since 2.0.0
 *
 * @see NX_Object_Cache::delete()
 * @global NX_Object_Cache $nx_object_cache Object cache global instance.
 *
 * @param int|string $key   What the contents in the cache are called.
 * @param string     $group Optional. Where the cache contents are grouped. Default empty.
 * @return bool True on successful removal, false on failure.
 */
function nx_cache_delete( $key, $group = '' ) {
	global $nx_object_cache;

	return $nx_object_cache->delete( $key, $group );
}

/**
 * Deletes multiple values from the cache in one call.
 *
 * @since 6.0.0
 *
 * @see NX_Object_Cache::delete_multiple()
 * @global NX_Object_Cache $nx_object_cache Object cache global instance.
 *
 * @param array  $keys  Array of keys under which the cache to deleted.
 * @param string $group Optional. Where the cache contents are grouped. Default empty.
 * @return bool[] Array of return values, grouped by key. Each value is either
 *                true on success, or false if the contents were not deleted.
 */
function nx_cache_delete_multiple( array $keys, $group = '' ) {
	global $nx_object_cache;

	return $nx_object_cache->delete_multiple( $keys, $group );
}

/**
 * Increments numeric cache item's value.
 *
 * @since 3.3.0
 *
 * @see NX_Object_Cache::incr()
 * @global NX_Object_Cache $nx_object_cache Object cache global instance.
 *
 * @param int|string $key    The key for the cache contents that should be incremented.
 * @param int        $offset Optional. The amount by which to increment the item's value.
 *                           Default 1.
 * @param string     $group  Optional. The group the key is in. Default empty.
 * @return int|false The item's new value on success, false on failure.
 */
function nx_cache_incr( $key, $offset = 1, $group = '' ) {
	global $nx_object_cache;

	return $nx_object_cache->incr( $key, $offset, $group );
}

/**
 * Decrements numeric cache item's value.
 *
 * @since 3.3.0
 *
 * @see NX_Object_Cache::decr()
 * @global NX_Object_Cache $nx_object_cache Object cache global instance.
 *
 * @param int|string $key    The cache key to decrement.
 * @param int        $offset Optional. The amount by which to decrement the item's value.
 *                           Default 1.
 * @param string     $group  Optional. The group the key is in. Default empty.
 * @return int|false The item's new value on success, false on failure.
 */
function nx_cache_decr( $key, $offset = 1, $group = '' ) {
	global $nx_object_cache;

	return $nx_object_cache->decr( $key, $offset, $group );
}

/**
 * Removes all cache items.
 *
 * @since 2.0.0
 *
 * @see NX_Object_Cache::flush()
 * @global NX_Object_Cache $nx_object_cache Object cache global instance.
 *
 * @return bool True on success, false on failure.
 */
function nx_cache_flush() {
	global $nx_object_cache;

	return $nx_object_cache->flush();
}

/**
 * Removes all cache items from the in-memory runtime cache.
 *
 * @since 6.0.0
 *
 * @see NX_Object_Cache::flush()
 *
 * @return bool True on success, false on failure.
 */
function nx_cache_flush_runtime() {
	return nx_cache_flush();
}

/**
 * Removes all cache items in a group, if the object cache implementation supports it.
 *
 * Before calling this function, always check for group flushing support using the
 * `nx_cache_supports( 'flush_group' )` function.
 *
 * @since 6.1.0
 *
 * @see NX_Object_Cache::flush_group()
 * @global NX_Object_Cache $nx_object_cache Object cache global instance.
 *
 * @param string $group Name of group to remove from cache.
 * @return bool True if group was flushed, false otherwise.
 */
function nx_cache_flush_group( $group ) {
	global $nx_object_cache;

	return $nx_object_cache->flush_group( $group );
}

/**
 * Determines whether the object cache implementation supports a particular feature.
 *
 * @since 6.1.0
 *
 * @param string $feature Name of the feature to check for. Possible values include:
 *                        'add_multiple', 'set_multiple', 'get_multiple', 'delete_multiple',
 *                        'flush_runtime', 'flush_group'.
 * @return bool True if the feature is supported, false otherwise.
 */
function nx_cache_supports( $feature ) {
	switch ( $feature ) {
		case 'add_multiple':
		case 'set_multiple':
		case 'get_multiple':
		case 'delete_multiple':
		case 'flush_runtime':
		case 'flush_group':
			return true;

		default:
			return false;
	}
}

/**
 * Closes the cache.
 *
 * This function has ceased to do anything since NexusPress 2.5. The
 * functionality was removed along with the rest of the persistent cache.
 *
 * This does not mean that plugins can't implement this function when they need
 * to make sure that the cache is cleaned up after NexusPress no longer needs it.
 *
 * @since 2.0.0
 *
 * @return true Always returns true.
 */
function nx_cache_close() {
	return true;
}

/**
 * Adds a group or set of groups to the list of global groups.
 *
 * @since 2.6.0
 *
 * @see NX_Object_Cache::add_global_groups()
 * @global NX_Object_Cache $nx_object_cache Object cache global instance.
 *
 * @param string|string[] $groups A group or an array of groups to add.
 */
function nx_cache_add_global_groups( $groups ) {
	global $nx_object_cache;

	$nx_object_cache->add_global_groups( $groups );
}

/**
 * Adds a group or set of groups to the list of non-persistent groups.
 *
 * @since 2.6.0
 *
 * @param string|string[] $groups A group or an array of groups to add.
 */
function nx_cache_add_non_persistent_groups( $groups ) {
	// Default cache doesn't persist so nothing to do here.
}

/**
 * Switches the internal blog ID.
 *
 * This changes the blog id used to create keys in blog specific groups.
 *
 * @since 3.5.0
 *
 * @see NX_Object_Cache::switch_to_blog()
 * @global NX_Object_Cache $nx_object_cache Object cache global instance.
 *
 * @param int $blog_id Site ID.
 */
function nx_cache_switch_to_blog( $blog_id ) {
	global $nx_object_cache;

	$nx_object_cache->switch_to_blog( $blog_id );
}

/**
 * Resets internal cache keys and structures.
 *
 * If the cache back end uses global blog or site IDs as part of its cache keys,
 * this function instructs the back end to reset those keys and perform any cleanup
 * since blog or site IDs have changed since cache init.
 *
 * This function is deprecated. Use nx_cache_switch_to_blog() instead of this
 * function when preparing the cache for a blog switch. For clearing the cache
 * during unit tests, consider using nx_cache_init(). nx_cache_init() is not
 * recommended outside of unit tests as the performance penalty for using it is high.
 *
 * @since 3.0.0
 * @deprecated 3.5.0 Use nx_cache_switch_to_blog()
 * @see NX_Object_Cache::reset()
 *
 * @global NX_Object_Cache $nx_object_cache Object cache global instance.
 */
function nx_cache_reset() {
	_deprecated_function( __FUNCTION__, '3.5.0', 'nx_cache_switch_to_blog()' );

	global $nx_object_cache;

	$nx_object_cache->reset();
}
