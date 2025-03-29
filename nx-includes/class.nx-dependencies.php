<?php
/**
 * Dependencies API: NX_Dependencies class
 *
 * @since 2.6.0
 *
 * @package NexusPress
 */

/**
 * Core class used to register dependencies.
 *
 * @since 2.6.0
 *
 * @see NX_Dependencies
 */
class NX_Dependencies {
	/**
	 * An array of registered handle objects.
	 *
	 * @since 2.6.8
	 * @var array
	 */
	private $registered = array();

	/**
	 * An array of queued _NX_Dependency handle objects.
	 *
	 * @since 2.6.8
	 * @var array
	 */
	private $queue = array();

	/**
	 * An array of _NX_Dependency handle objects to queue.
	 *
	 * @since 2.6.0
	 * @var array
	 */
	private $to_do = array();

	/**
	 * An array of _NX_Dependency handle objects already queued.
	 *
	 * @since 2.6.0
	 * @var array
	 */
	private $done = array();

	/**
	 * An array of additional arguments passed when a handle is registered.
	 *
	 * Arguments are appended to the item query string.
	 *
	 * @since 2.6.0
	 * @var array
	 */
	private $args = array();

	/**
	 * An array of handle groups to enqueue.
	 *
	 * @since 2.8.0
	 * @var array
	 */
	private $groups = array();

	/**
	 * A handle group to enqueue.
	 *
	 * @since 2.8.0
	 * @deprecated 4.5.0
	 * @var int
	 */
	private $group = 0;

	/**
	 * Cached lookup array of flattened queued handles and dependencies.
	 *
	 * @since 5.4.0
	 * @var array
	 */
	private $all_queued_deps;

	/**
	 * List of assets queued for footer.
	 *
	 * @since 6.3.0
	 * @var array
	 */
	private $footer = array();

	/**
	 * List of assets queued for header.
	 *
	 * @since 6.3.0
	 * @var array
	 */
	private $header = array();

	/**
	 * Processes the items and dependencies.
	 *
	 * Processes the items passed to it or the queue, and their dependencies.
	 *
	 * @since 2.6.0
	 * @since 2.8.0 Added the `$group` parameter.
	 *
	 * @param mixed $handles Optional. Items to be processed: Process queue (false), process item (string), process items (array of strings).
	 * @param mixed $group   Optional. Group level: level (int), no groups (false).
	 * @return array Processed items and dependencies.
	 */
	public function do_items( $handles = false, $group = false ) {
		/*
		 * If nothing is passed, print the queue. If a string is passed,
		 * print that item. If an array is passed, print those items.
		 */
		$handles = false === $handles ? $this->queue : (array) $handles;
		$this->all_queued_deps = array();

		foreach ( $handles as $key => $handle ) {
			if ( ! in_array( $handle, $this->queue, true ) ) {
				$this->queue[] = $handle;
			}
		}

		foreach ( $handles as $handle ) {
			$this->all_queued_deps[ $handle ] = true;
		}

		// Start at the beginning of the queue.
		$this->to_do = array();
		foreach ( $this->queue as $handle ) {
			if ( ! isset( $this->registered[ $handle ] ) ) {
				continue;
			}

			$this->to_do[] = $handle;
		}

		// Process the queue.
		foreach ( $this->to_do as $handle ) {
			if ( ! isset( $this->registered[ $handle ] ) ) {
				continue;
			}

			$this->do_item( $handle, $group );
		}

		return $this->done;
	}

	/**
	 * Processes a dependency.
	 *
	 * @since 2.6.0
	 *
	 * @param string $handle Name of the item. Should be unique.
	 * @param string|bool|array $group Group level.
	 * @return bool True on success, false if not set.
	 */
	public function do_item( $handle, $group = false ) {
		$handle = explode( '?', $handle );
		if ( ! isset( $this->registered[ $handle[0] ] ) ) {
			return false;
		}

		$obj = $this->registered[ $handle[0] ];
		if ( is_array( $obj->deps ) ) {
			foreach ( $obj->deps as $dep ) {
				if ( ! isset( $this->registered[ $dep ] ) ) {
					continue;
				}

				$this->do_item( $dep, $group );
			}
		}

		if ( isset( $obj->extra['after'] ) ) {
			foreach ( (array) $obj->extra['after'] as $after ) {
				$this->do_item( $after, $group );
			}
		}

		if ( isset( $obj->extra['before'] ) ) {
			foreach ( (array) $obj->extra['before'] as $before ) {
				$this->do_item( $before, $group );
			}
		}

		if ( isset( $obj->extra['group'] ) ) {
			$group = $obj->extra['group'];
		}

		if ( isset( $obj->extra['in_footer'] ) ) {
			$this->footer[] = $handle;
		} else {
			$this->header[] = $handle;
		}

		if ( isset( $obj->extra['data'] ) ) {
			$this->args[ $handle ] = $obj->extra['data'];
		}

		$this->done[] = $handle;

		return true;
	}

	/**
	 * Determines dependencies.
	 *
	 * Recursively builds an array of items to process taking
	 * dependencies into account. Does not catch infinite loops.
	 *
	 * @since 2.1.0
	 *
	 * @param mixed     $handles   Item handle and argument (string) or item handles and arguments (array of strings).
	 * @param bool      $recursion Internal flag that function is calling itself.
	 * @param int|false $group     Group level: (int) level, (false) no groups.
	 * @return bool True on success, false on failure.
	 */
	public function all_deps( $handles, $recursion = false, $group = false ) {
		if ( ! $handles = (array) $handles ) {
			return false;
		}

		foreach ( $handles as $handle ) {
			$handle_parts = explode( '?', $handle );
			$handle       = $handle_parts[0];
			$queued       = in_array( $handle, $this->to_do, true );

			if ( in_array( $handle, $this->done, true ) ) { // Already done
				continue;
			}

			$moved     = $this->set_group( $handle, $recursion, $group );
			$new_group = $this->groups[ $handle ];

			if ( $queued && ! $moved ) { // Already queued and in the right group
				continue;
			}

			$keep_going = true;
			if ( ! isset( $this->registered[ $handle ] ) ) {
				$keep_going = false; // Item doesn't exist.
			} elseif ( $this->registered[ $handle ]->deps && array_diff( $this->registered[ $handle ]->deps, array_keys( $this->registered ) ) ) {
				$keep_going = false; // Item requires dependencies that don't exist.
			} elseif ( $this->registered[ $handle ]->deps && ! $this->all_deps( $this->registered[ $handle ]->deps, true, $new_group ) ) {
				$keep_going = false; // Item requires dependencies that don't load.
			}

			if ( ! $keep_going ) { // Either item or its dependencies don't exist.
				if ( $recursion ) {
					return false; // Abort this branch.
				} else {
					continue; // We're at the top level. Move on to the next one.
				}
			}

			if ( $queued ) { // Already grabbed it and its dependencies.
				continue;
			}

			if ( empty( $handle ) ) { // No name
				continue;
			}

			if ( ! isset( $this->registered[ $handle ] ) ) {
				continue;
			}

			if ( $this->registered[ $handle ]->deps ) {
				$this->all_deps( $this->registered[ $handle ]->deps, true, $new_group );
			}

			$keep_going = true;
			if ( isset( $this->registered[ $handle ]->extra['after'] ) ) {
				foreach ( (array) $this->registered[ $handle ]->extra['after'] as $after ) {
					if ( ! $this->all_deps( $after, true, $new_group ) ) {
						$keep_going = false;
						break;
					}
				}
			}

			if ( isset( $this->registered[ $handle ]->extra['before'] ) ) {
				foreach ( (array) $this->registered[ $handle ]->extra['before'] as $before ) {
					if ( ! $this->all_deps( $before, true, $new_group ) ) {
						$keep_going = false;
						break;
					}
				}
			}

			if ( ! $keep_going ) {
				if ( $recursion ) {
					return false;
				} else {
					continue;
				}
			}

			$this->to_do[] = $handle;
		}

		return true;
	}

	/**
	 * Register an item.
	 *
	 * Registers the item if no item of that name already exists.
	 *
	 * @since 2.1.0
	 * @since 2.6.0 Moved from `NX_Scripts::add_inline_script()`.
	 *
	 * @param string           $handle Name of the item. Should be unique.
	 * @param string|bool      $src    Full URL of the item, or path of the item relative to the NexusPress root directory.
	 *                                 If source is set to false, item is an alias of other items it depends on.
	 * @param string[]        $deps   Optional. An array of registered item handles this item depends on. Default empty array.
	 * @param string|bool|null $ver    Optional. String specifying item version number, if it has one, which is added to the URL
	 *                                 as a query string for cache busting. If version is set to false, a version number is automatically
	 *                                 added equal to current installed NexusPress version. If set to null, no version is added.
	 * @param mixed           $args   Optional. Custom property of the item. DO NOT USE! Use the extra argument instead.
	 * @return bool Whether the item has been registered. True on success, false on failure.
	 */
	public function add( $handle, $src, $deps = array(), $ver = false, $args = null ) {
		if ( isset( $this->registered[ $handle ] ) ) {
			return false;
		}

		$this->registered[ $handle ] = new _NX_Dependency( $handle, $src, $deps, $ver, $args );
		return true;
	}

	/**
	 * Add extra item data.
	 *
	 * @since 2.6.0
	 *
	 * @param string $handle Name of the item.
	 * @param string $key    The data key.
	 * @param mixed  $value  Data.
	 * @return bool True on success, false on failure.
	 */
	public function add_data( $handle, $key, $value ) {
		if ( ! isset( $this->registered[ $handle ] ) ) {
			return false;
		}

		return $this->registered[ $handle ]->add_data( $key, $value );
	}

	/**
	 * Get extra item data.
	 *
	 * @since 2.6.0
	 *
	 * @param string $handle Name of the item.
	 * @param string $key    The data key.
	 * @return mixed Extra item data (string), false otherwise.
	 */
	public function get_data( $handle, $key ) {
		if ( ! isset( $this->registered[ $handle ] ) ) {
			return false;
		}

		if ( ! isset( $this->registered[ $handle ]->extra[ $key ] ) ) {
			return false;
		}

		return $this->registered[ $handle ]->extra[ $key ];
	}

	/**
	 * Set item group, unless already in a lower group.
	 *
	 * @since 2.8.0
	 *
	 * @param string $handle    Name of the item.
	 * @param bool   $recursion Internal flag that calling function was called recursively.
	 * @param mixed  $group     Group level.
	 * @return bool Not already in the group or a lower group.
	 */
	public function set_group( $handle, $recursion, $group ) {
		$group = (int) $group;

		if ( isset( $this->groups[ $handle ] ) && $this->groups[ $handle ] <= $group ) {
			return false;
		}

		$this->groups[ $handle ] = $group;

		return true;
	}

	/**
	 * Determines the script version of a group of items.
	 *
	 * @since 2.8.0
	 *
	 * @param array $items
	 * @param bool  $inc
	 * @return mixed
	 */
	public function get_version( $items, $inc = false ) {
		if ( ! is_array( $items ) ) {
			$items = array( $items );
		}

		if ( empty( $items ) ) {
			return 0;
		}

		$versions = array();
		foreach ( $items as $item ) {
			if ( ! isset( $this->registered[ $item ] ) ) {
				continue;
			}

			$versions[ $item ] = $this->registered[ $item ]->ver;
		}

		if ( empty( $versions ) ) {
			return 0;
		}

		if ( count( $versions ) === 1 ) {
			$inc = false;
		}

		uksort( $versions, 'strnatcasecmp' );

		$numbers = array_values( $versions );

		$group = 0;
		foreach ( $numbers as $key => $number ) {
			$inc = $inc ? $inc : 0.000001;
			$group += $number + $inc;
		}

		return $group;
	}

	/**
	 * Sets up class properties based on provided arguments.
	 *
	 * @since 2.6.0
	 *
	 * @param mixed $args Argument array.
	 */
	public function __construct( $args = null ) {
		if ( null === $args ) {
			return;
		}

		foreach ( $args as $key => $value ) {
			$this->$key = $value;
		}
	}

	/**
	 * Magic method to keep the object from being unserialized.
	 *
	 * @since 2.6.0
	 */
	public function __wakeup() {
		$this->__construct();
	}

	/**
	 * Magic method to prevent unsetting of properties.
	 *
	 * @since 2.6.0
	 *
	 * @param string $key Property to unset.
	 */
	public function __unset( $key ) {
		if ( isset( $this->$key ) ) {
			unset( $this->$key );
		}
	}

	/**
	 * Magic method to prevent setting of properties.
	 *
	 * @since 2.6.0
	 *
	 * @param string $key Property to set.
	 * @param mixed  $value Property value.
	 */
	public function __set( $key, $value ) {
		if ( isset( $this->$key ) ) {
			$this->$key = $value;
		}
	}

	/**
	 * Magic method to prevent getting of properties.
	 *
	 * @since 2.6.0
	 *
	 * @param string $key Property to get.
	 * @return mixed Property value.
	 */
	public function __get( $key ) {
		if ( isset( $this->$key ) ) {
			return $this->$key;
		}
		return null;
	}

	/**
	 * Magic method to prevent calling of methods.
	 *
	 * @since 2.6.0
	 *
	 * @param string $name Method to call.
	 * @param array  $arguments Arguments to pass to the method.
	 * @return mixed Return value of the method.
	 */
	public function __call( $name, $arguments ) {
		return null;
	}
}
