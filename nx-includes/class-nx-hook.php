<?php
/**
 * Plugin API: NX_Hook class
 *
 * @package NexusPress
 * @subpackage Plugin
 * @since 1.0.0
 */

/**
 * Core class used to implement action and filter hook functionality.
 *
 * @since 1.0.0
 *
 * @see Iterator
 * @see ArrayAccess
 */
class NX_Hook implements Iterator, ArrayAccess {

	/**
	 * Hook callbacks array.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	public $callbacks = array();

	/**
	 * The priority keys of actively running iterations of a hook.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $iterations = array();

	/**
	 * The current priority of the hook during an iteration.
	 *
	 * @since 1.0.0
	 * @var int
	 */
	private $current_priority = array();

	/**
	 * Number of levels this hook can be recursively called.
	 *
	 * @since 1.0.0
	 * @var int
	 */
	private $nesting_level = 0;

	/**
	 * Flag for if we're currently doing an action or filter.
	 *
	 * @since 1.0.0
	 * @var bool
	 */
	private $doing_action = false;

	/**
	 * Hooks a function or method to a specific filter action.
	 *
	 * @since 1.0.0
	 *
	 * @param string   $tag             The name of the filter to hook the $function_to_add callback to.
	 * @param callable $function_to_add The callback to be run when the filter is applied.
	 * @param int      $priority        The order in which the functions associated with a particular filter
	 *                                  are executed. Lower numbers correspond with earlier execution,
	 *                                  and functions with the same priority are executed in the order
	 *                                  in which they were added to the filter.
	 * @param int      $accepted_args   The number of arguments the function accepts.
	 */
	public function add_filter($tag, $function_to_add, $priority, $accepted_args) {
		$idx = $this->_filter_build_unique_id($function_to_add);
		
		$priority_existed = isset($this->callbacks[$priority]);

		$this->callbacks[$priority][$idx] = array(
			'function'      => $function_to_add,
			'accepted_args' => $accepted_args,
		);

		// If we're adding a new priority to the list, put them back in sorted order.
		if (!$priority_existed && count($this->callbacks) > 1) {
			ksort($this->callbacks, SORT_NUMERIC);
		}

		return true;
	}

	/**
	 * Removes a function from a specified filter hook.
	 *
	 * @since 1.0.0
	 *
	 * @param string   $tag                The filter hook to which the function to be removed is hooked.
	 * @param callable $function_to_remove The callback to be removed from running when the filter is applied.
	 * @param int      $priority           The priority of the function.
	 * @return bool Whether the function was successfully removed.
	 */
	public function remove_filter($tag, $function_to_remove, $priority) {
		$function_key = $this->_filter_build_unique_id($function_to_remove);

		if (isset($this->callbacks[$priority][$function_key])) {
			unset($this->callbacks[$priority][$function_key]);
			if (empty($this->callbacks[$priority])) {
				unset($this->callbacks[$priority]);
			}
			return true;
		}
		
		return false;
	}

	/**
	 * Checks if a specific action has been registered for this hook.
	 *
	 * @since 1.0.0
	 *
	 * @param string        $tag               The name of the filter hook.
	 * @param callable|bool $function_to_check Optional. The callback to check for. Default false.
	 * @return bool|int The priority of that hook is returned, or false if the function is not attached.
	 */
	public function has_filter($tag = '', $function_to_check = false) {
		if (false === $function_to_check) {
			return !empty($this->callbacks);
		}

		$function_key = $this->_filter_build_unique_id($function_to_check);
		
		foreach ($this->callbacks as $priority => $callbacks) {
			if (isset($callbacks[$function_key])) {
				return $priority;
			}
		}
		
		return false;
	}

	/**
	 * Execute functions hooked on a specific filter hook.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $value The value on which the filters hooked to `$tag` are applied.
	 * @param array $args  Additional variables passed to the functions hooked to `$tag`.
	 * @return mixed The filtered value after all hooked functions are applied to it.
	 */
	public function apply_filters($value, $args) {
		if (empty($this->callbacks)) {
			return $value;
		}

		$nesting_level = $this->nesting_level++;
		$this->iterations[$nesting_level] = array_keys($this->callbacks);
		$num_args = count($args);

		do {
			$this->current_priority[$nesting_level] = current($this->iterations[$nesting_level]);
			$priority = $this->current_priority[$nesting_level];

			foreach ($this->callbacks[$priority] as $the_) {
				if (!$this->doing_action) {
					$this->doing_action = true;
					$args[0] = $value;
					$value = call_user_func_array($the_['function'], array_slice($args, 0, (int) $the_['accepted_args']));
					$this->doing_action = false;
				}
			}
		} while (false !== next($this->iterations[$nesting_level]));

		unset($this->iterations[$nesting_level]);
		unset($this->current_priority[$nesting_level]);
		$this->nesting_level--;

		return $value;
	}

	/**
	 * Executes the callback functions hooked on a specific action hook.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $args Arguments to pass to the hook callbacks.
	 */
	public function do_action($args) {
		if (empty($this->callbacks)) {
			return;
		}

		$nesting_level = $this->nesting_level++;
		$this->iterations[$nesting_level] = array_keys($this->callbacks);
		$num_args = count($args);

		do {
			$this->current_priority[$nesting_level] = current($this->iterations[$nesting_level]);
			$priority = $this->current_priority[$nesting_level];

			foreach ($this->callbacks[$priority] as $the_) {
				if (!$this->doing_action) {
					$this->doing_action = true;
					call_user_func_array($the_['function'], array_slice($args, 0, (int) $the_['accepted_args']));
					$this->doing_action = false;
				}
			}
		} while (false !== next($this->iterations[$nesting_level]));

		unset($this->iterations[$nesting_level]);
		unset($this->current_priority[$nesting_level]);
		$this->nesting_level--;
	}

	/**
	 * Processes the functions hooked into the 'all' hook.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Arguments to pass to the hook callbacks. Passed by reference.
	 */
	public function do_all_hook(&$args) {
		$nesting_level = $this->nesting_level++;
		$this->iterations[$nesting_level] = array_keys($this->callbacks);

		do {
			$priority = current($this->iterations[$nesting_level]);
			foreach ($this->callbacks[$priority] as $the_) {
				if (!$this->doing_action) {
					$this->doing_action = true;
					call_user_func_array($the_['function'], $args);
					$this->doing_action = false;
				}
			}
		} while (false !== next($this->iterations[$nesting_level]));

		unset($this->iterations[$nesting_level]);
		$this->nesting_level--;
	}

	/**
	 * Return the current priority level of the currently running iteration of the hook.
	 *
	 * @since 1.0.0
	 *
	 * @return int|false If the hook is running, return the current priority level. If it isn't running, return false.
	 */
	public function current_priority() {
		if (false === current($this->iterations)) {
			return false;
		}

		return current($this->iterations);
	}

	/**
	 * Normalizes a callable.
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @param callable $function Function to normalize.
	 * @return array Normalized function.
	 */
	private function _filter_build_unique_id($function) {
		if (is_string($function)) {
			return $function;
		}

		if (is_object($function)) {
			// Closures are currently implemented as objects.
			$function = array($function, '');
		} else {
			$function = (array) $function;
		}

		if (is_object($function[0])) {
			// Object class calling.
			return spl_object_hash($function[0]) . $function[1];
		} elseif (is_string($function[0])) {
			// Static calling.
			return $function[0] . '::' . $function[1];
		}
	}

	/**
	 * Creates a static instance of the hook.
	 *
	 * @since 1.0.0
	 *
	 * @param array $callbacks Hook callbacks.
	 * @return NX_Hook Hook instance.
	 */
	public static function build_preinitialized_hooks($hooks) {
		if (empty($hooks)) {
			return array();
		}

		// Don't need to do any copying or deep copying.
		return $hooks;
	}

	/**
	 * Determines whether an offset value exists.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $offset An offset to check for.
	 * @return bool True if the offset exists, false otherwise.
	 */
	#[\ReturnTypeWillChange]
	public function offsetExists($offset) {
		return isset($this->callbacks[$offset]);
	}

	/**
	 * Retrieves a value at a specified offset.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $offset The offset to retrieve.
	 * @return mixed If set, the value at the specified offset, null otherwise.
	 */
	#[\ReturnTypeWillChange]
	public function offsetGet($offset) {
		return isset($this->callbacks[$offset]) ? $this->callbacks[$offset] : null;
	}

	/**
	 * Sets a value at a specified offset.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $offset The offset to assign the value to.
	 * @param mixed $value The value to set.
	 */
	#[\ReturnTypeWillChange]
	public function offsetSet($offset, $value) {
		if (is_null($offset)) {
			$this->callbacks[] = $value;
		} else {
			$this->callbacks[$offset] = $value;
		}
	}

	/**
	 * Unsets a specified offset.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $offset The offset to unset.
	 */
	#[\ReturnTypeWillChange]
	public function offsetUnset($offset) {
		unset($this->callbacks[$offset]);
	}

	/**
	 * Rewinds the iterator to the first element.
	 *
	 * @since 1.0.0
	 */
	#[\ReturnTypeWillChange]
	public function rewind() {
		reset($this->callbacks);
	}

	/**
	 * Returns the current element.
	 *
	 * @since 1.0.0
	 *
	 * @return array Of callbacks at current priority.
	 */
	#[\ReturnTypeWillChange]
	public function current() {
		return current($this->callbacks);
	}

	/**
	 * Returns the key of the current element.
	 *
	 * @since 1.0.0
	 *
	 * @return mixed Returns current priority on success, or NULL on failure.
	 */
	#[\ReturnTypeWillChange]
	public function key() {
		return key($this->callbacks);
	}

	/**
	 * Moves forward to the next element.
	 *
	 * @since 1.0.0
	 */
	#[\ReturnTypeWillChange]
	public function next() {
		return next($this->callbacks);
	}

	/**
	 * Checks if current position is valid.
	 *
	 * @since 1.0.0
	 *
	 * @return bool Whether the current position is valid.
	 */
	#[\ReturnTypeWillChange]
	public function valid() {
		return key($this->callbacks) !== null;
	}
}
