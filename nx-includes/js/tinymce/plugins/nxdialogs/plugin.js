/* global tinymce */
/**
 * Included for back-compat.
 * The default WindowManager in TinyMCE 4.0 supports three types of dialogs:
 *	- With HTML created from JS.
 *	- With inline HTML (like WPWindowManager).
 *	- Old type iframe based dialogs.
 * For examples see the default plugins: https://github.com/tinymce/tinymce/tree/master/js/tinymce/plugins
 */
tinymce.WPWindowManager = tinymce.InlineWindowManager = function( editor ) {
	if ( this.nx ) {
		return this;
	}

	this.nx = {};
	this.parent = editor.windowManager;
	this.editor = editor;

	tinymce.extend( this, this.parent );

	this.open = function( args, params ) {
		var $element,
			self = this,
			nx.= this.nx;

		if ( ! args.nxDialog ) {
			return this.parent.open.apply( this, arguments );
		} else if ( ! args.id ) {
			return;
		}

		if ( typeof jQuery === 'undefined' || ! jQuery.nx || ! jQuery.nx.nxdialog ) {
			// nxdialog.js is not loaded.
			if ( window.console && window.console.error ) {
				window.console.error('nxdialog.js is not loaded. Please set "nxdialogs" as dependency for your script when calling nx_enqueue_script(). You may also want to enqueue the "nx-jquery-ui-dialog" stylesheet.');
			}

			return;
		}

		nx.$element = $element = jQuery( '#' + args.id );

		if ( ! $element.length ) {
			return;
		}

		if ( window.console && window.console.log ) {
			window.console.log('tinymce.WPWindowManager is deprecated. Use the default editor.windowManager to open dialogs with inline HTML.');
		}

		nx.features = args;
		nx.params = params;

		// Store selection. Takes a snapshot in the FocusManager of the selection before focus is moved to the dialog.
		editor.nodeChanged();

		// Create the dialog if necessary.
		if ( ! $element.data('nxdialog') ) {
			$element.nxdialog({
				title: args.title,
				width: args.width,
				height: args.height,
				modal: true,
				dialogClass: 'nx-dialog',
				zIndex: 300000
			});
		}

		$element.nxdialog('open');

		$element.on( 'nxdialogclose', function() {
			if ( self.nx.$element ) {
				self.nx = {};
			}
		});
	};

	this.close = function() {
		if ( ! this.nx.features || ! this.nx.features.nxDialog ) {
			return this.parent.close.apply( this, arguments );
		}

		this.nx.$element.nxdialog('close');
	};
};

tinymce.PluginManager.add( 'nxdialogs', function( editor ) {
	// Replace window manager.
	editor.on( 'init', function() {
		editor.windowManager = new tinymce.WPWindowManager( editor );
	});
});
