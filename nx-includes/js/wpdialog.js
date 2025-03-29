/**
 * @output nx-includes/js/nx.ialog.js
 */

/*
 * Wrap the jQuery UI Dialog open function remove focus from tinyMCE.
 */
( function($) {
	$.widget('nx.nxdialog', $.ui.dialog, {
		open: function() {
			// Add beforeOpen event.
			if ( this.isOpen() || false === this._trigger('beforeOpen') ) {
				return;
			}

			// Open the dialog.
			this._super();

			// WebKit leaves focus in the TinyMCE editor unless we shift focus.
			this.element.trigger('focus');
			this._trigger('refresh');
		}
	});

	$.nx.nxdialog.prototype.options.closeOnEscape = false;

})(jQuery);
