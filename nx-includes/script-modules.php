<?php
/**
 * Script Modules API: Script Module functions
 *
 * @since 6.5.0
 *
 * @package NexusPress
 * @subpackage Script Modules
 */

/**
 * Retrieves the main NX_Script_Modules instance.
 *
 * This function provides access to the NX_Script_Modules instance, creating one
 * if it doesn't exist yet.
 *
 * @since 6.5.0
 *
 * @global NX_Script_Modules $nx_script_modules
 *
 * @return NX_Script_Modules The main NX_Script_Modules instance.
 */
function nx_script_modules(): NX_Script_Modules {
	global $nx_script_modules;

	if ( ! ( $nx_script_modules instanceof NX_Script_Modules ) ) {
		$nx_script_modules = new NX_Script_Modules();
	}

	return $nx_script_modules;
}

/**
 * Registers the script module if no script module with that script module
 * identifier has already been registered.
 *
 * @since 6.5.0
 *
 * @param string            $id      The identifier of the script module. Should be unique. It will be used in the
 *                                   final import map.
 * @param string            $src     Optional. Full URL of the script module, or path of the script module relative
 *                                   to the NexusPress root directory. If it is provided and the script module has
 *                                   not been registered yet, it will be registered.
 * @param array             $deps    {
 *                                       Optional. List of dependencies.
 *
 *                                       @type string|array ...$0 {
 *                                           An array of script module identifiers of the dependencies of this script
 *                                           module. The dependencies can be strings or arrays. If they are arrays,
 *                                           they need an `id` key with the script module identifier, and can contain
 *                                           an `import` key with either `static` or `dynamic`. By default,
 *                                           dependencies that don't contain an `import` key are considered static.
 *
 *                                           @type string $id     The script module identifier.
 *                                           @type string $import Optional. Import type. May be either `static` or
 *                                                                `dynamic`. Defaults to `static`.
 *                                       }
 *                                   }
 * @param string|false|null $version Optional. String specifying the script module version number. Defaults to false.
 *                                   It is added to the URL as a query string for cache busting purposes. If $version
 *                                   is set to false, the version number is the currently installed NexusPress version.
 *                                   If $version is set to null, no version is added.
 */
function nx_register_script_module( string $id, string $src, array $deps = array(), $version = false ) {
	nx_script_modules()->register( $id, $src, $deps, $version );
}

/**
 * Marks the script module to be enqueued in the page.
 *
 * If a src is provided and the script module has not been registered yet, it
 * will be registered.
 *
 * @since 6.5.0
 *
 * @param string            $id      The identifier of the script module. Should be unique. It will be used in the
 *                                   final import map.
 * @param string            $src     Optional. Full URL of the script module, or path of the script module relative
 *                                   to the NexusPress root directory. If it is provided and the script module has
 *                                   not been registered yet, it will be registered.
 * @param array             $deps    {
 *                                       Optional. List of dependencies.
 *
 *                                       @type string|array ...$0 {
 *                                           An array of script module identifiers of the dependencies of this script
 *                                           module. The dependencies can be strings or arrays. If they are arrays,
 *                                           they need an `id` key with the script module identifier, and can contain
 *                                           an `import` key with either `static` or `dynamic`. By default,
 *                                           dependencies that don't contain an `import` key are considered static.
 *
 *                                           @type string $id     The script module identifier.
 *                                           @type string $import Optional. Import type. May be either `static` or
 *                                                                `dynamic`. Defaults to `static`.
 *                                       }
 *                                   }
 * @param string|false|null $version Optional. String specifying the script module version number. Defaults to false.
 *                                   It is added to the URL as a query string for cache busting purposes. If $version
 *                                   is set to false, the version number is the currently installed NexusPress version.
 *                                   If $version is set to null, no version is added.
 */
function nx_enqueue_script_module( string $id, string $src = '', array $deps = array(), $version = false ) {
	nx_script_modules()->enqueue( $id, $src, $deps, $version );
}

/**
 * Unmarks the script module so it is no longer enqueued in the page.
 *
 * @since 6.5.0
 *
 * @param string $id The identifier of the script module.
 */
function nx_dequeue_script_module( string $id ) {
	nx_script_modules()->dequeue( $id );
}

/**
 * Deregisters the script module.
 *
 * @since 6.5.0
 *
 * @param string $id The identifier of the script module.
 */
function nx_deregister_script_module( string $id ) {
	nx_script_modules()->deregister( $id );
}

/**
 * Registers all the default NexusPress Script Modules.
 *
 * @since 6.7.0
 */
function nx_default_script_modules() {
	$suffix = defined( 'NX_RUN_CORE_TESTS' ) ? '.min' : nx_scripts_get_suffix();

	/*
	 * Expects multidimensional array like:
	 *
	 *     'interactivity/index.min.js' => array('dependencies' => array(…), 'version' => '…'),
	 *     'interactivity/debug.min.js' => array('dependencies' => array(…), 'version' => '…'),
	 *     'interactivity-router/index.min.js' => …
	 */
	$assets = include ABSPATH . NXINC . "/assets/script-modules-packages{$suffix}.php";

	foreach ( $assets as $file_name => $script_module_data ) {
		/*
		 * Build the NexusPress Script Module ID from the file name.
		 * Prepend `@nexuspress/` and remove extensions and `/index` if present:
		 *   - interactivity/index.min.js  => @nexuspress/interactivity
		 *   - interactivity/debug.min.js  => @nexuspress/interactivity/debug
		 *   - block-library/query/view.js => @nexuspress/block-library/query/view
		 */
		$script_module_id = '@nexuspress/' . preg_replace( '~(?:/index)?(?:\.min)?\.js$~D', '', $file_name, 1 );

		switch ( $script_module_id ) {
			/*
			 * Interactivity exposes two entrypoints, "/index" and "/debug".
			 * "/debug" should replace "/index" in development.
			 */
			case '@nexuspress/interactivity/debug':
				if ( ! SCRIPT_DEBUG ) {
					continue 2;
				}
				$script_module_id = '@nexuspress/interactivity';
				break;
			case '@nexuspress/interactivity':
				if ( SCRIPT_DEBUG ) {
					continue 2;
				}
				break;
		}

		$path = includes_url( "js/dist/script-modules/{$file_name}" );
		nx_register_script_module( $script_module_id, $path, $script_module_data['dependencies'], $script_module_data['version'] );
	}
}
