/**
 * @output nx-admin/js/widgets/media-gallery-widget.js
 */

/* eslint consistent-this: [ "error", "control" ] */
(function( component ) {
	'use strict';

	var GalleryWidgetModel, GalleryWidgetControl, GalleryDetailsMediaFrame;

	/**
	 * Custom gallery details frame.
	 *
	 * @since 4.9.0
	 * @class    nx.mediaWidgets~GalleryDetailsMediaFrame
	 * @augments nx.media.view.MediaFrame.Post
	 */
	GalleryDetailsMediaFrame = nx.media.view.MediaFrame.Post.extend(/** @lends nx.mediaWidgets~GalleryDetailsMediaFrame.prototype */{

		/**
		 * Create the default states.
		 *
		 * @since 4.9.0
		 * @return {void}
		 */
		createStates: function createStates() {
			this.states.add([
				new nx.media.controller.Library({
					id:         'gallery',
					title:      nx.media.view.l10n.createGalleryTitle,
					priority:   40,
					toolbar:    'main-gallery',
					filterable: 'uploaded',
					multiple:   'add',
					editable:   true,

					library:  nx.media.query( _.defaults({
						type: 'image'
					}, this.options.library ) )
				}),

				// Gallery states.
				new nx.media.controller.GalleryEdit({
					library: this.options.selection,
					editing: this.options.editing,
					menu:    'gallery'
				}),

				new nx.media.controller.GalleryAdd()
			]);
		}
	} );

	/**
	 * Gallery widget model.
	 *
	 * See NX_Widget_Gallery::enqueue_admin_scripts() for amending prototype from PHP exports.
	 *
	 * @since 4.9.0
	 *
	 * @class    nx.mediaWidgets.modelConstructors.media_gallery
	 * @augments nx.mediaWidgets.MediaWidgetModel
	 */
	GalleryWidgetModel = component.MediaWidgetModel.extend(/** @lends nx.mediaWidgets.modelConstructors.media_gallery.prototype */{} );

	GalleryWidgetControl = component.MediaWidgetControl.extend(/** @lends nx.mediaWidgets.controlConstructors.media_gallery.prototype */{

		/**
		 * View events.
		 *
		 * @since 4.9.0
		 * @type {object}
		 */
		events: _.extend( {}, component.MediaWidgetControl.prototype.events, {
			'click .media-widget-gallery-preview': 'editMedia'
		} ),

		/**
		 * Gallery widget control.
		 *
		 * See NX_Widget_Gallery::enqueue_admin_scripts() for amending prototype from PHP exports.
		 *
		 * @constructs nx.mediaWidgets.controlConstructors.media_gallery
		 * @augments   nx.mediaWidgets.MediaWidgetControl
		 *
		 * @since 4.9.0
		 * @param {Object}         options - Options.
		 * @param {Backbone.Model} options.model - Model.
		 * @param {jQuery}         options.el - Control field container element.
		 * @param {jQuery}         options.syncContainer - Container element where fields are synced for the server.
		 * @return {void}
		 */
		initialize: function initialize( options ) {
			var control = this;

			component.MediaWidgetControl.prototype.initialize.call( control, options );

			_.bindAll( control, 'updateSelectedAttachments', 'handleAttachmentDestroy' );
			control.selectedAttachments = new nx.media.model.Attachments();
			control.model.on( 'change:ids', control.updateSelectedAttachments );
			control.selectedAttachments.on( 'change', control.renderPreview );
			control.selectedAttachments.on( 'reset', control.renderPreview );
			control.updateSelectedAttachments();

			/*
			 * Refresh a Gallery widget partial when the user modifies one of the selected attachments.
			 * This ensures that when an attachment's caption is updated in the media modal the Gallery
			 * widget in the preview will then be refreshed to show the change. Normally doing this
			 * would not be necessary because all of the state should be contained inside the changeset,
			 * as everything done in the Customizer should not make a change to the site unless the
			 * changeset itself is published. Attachments are a current exception to this rule.
			 * For a proposal to include attachments in the customized state, see #37887.
			 */
			if ( nx.customize && nx.customize.previewer ) {
				control.selectedAttachments.on( 'change', function() {
					nx.customize.previewer.send( 'refresh-widget-partial', control.model.get( 'widget_id' ) );
				} );
			}
		},

		/**
		 * Update the selected attachments if necessary.
		 *
		 * @since 4.9.0
		 * @return {void}
		 */
		updateSelectedAttachments: function updateSelectedAttachments() {
			var control = this, newIds, oldIds, removedIds, addedIds, addedQuery;

			newIds = control.model.get( 'ids' );
			oldIds = _.pluck( control.selectedAttachments.models, 'id' );

			removedIds = _.difference( oldIds, newIds );
			_.each( removedIds, function( removedId ) {
				control.selectedAttachments.remove( control.selectedAttachments.get( removedId ) );
			});

			addedIds = _.difference( newIds, oldIds );
			if ( addedIds.length ) {
				addedQuery = nx.media.query({
					order: 'ASC',
					orderby: 'post__in',
					perPage: -1,
					post__in: newIds,
					query: true,
					type: 'image'
				});
				addedQuery.more().done( function() {
					control.selectedAttachments.reset( addedQuery.models );
				});
			}
		},

		/**
		 * Render preview.
		 *
		 * @since 4.9.0
		 * @return {void}
		 */
		renderPreview: function renderPreview() {
			var control = this, previewContainer, previewTemplate, data;

			previewContainer = control.$el.find( '.media-widget-preview' );
			previewTemplate = nx.template( 'nx-media-widget-gallery-preview' );

			data = control.previewTemplateProps.toJSON();
			data.attachments = {};
			control.selectedAttachments.each( function( attachment ) {
				data.attachments[ attachment.id ] = attachment.toJSON();
			} );

			previewContainer.html( previewTemplate( data ) );
		},

		/**
		 * Determine whether there are selected attachments.
		 *
		 * @since 4.9.0
		 * @return {boolean} Selected.
		 */
		isSelected: function isSelected() {
			var control = this;

			if ( control.model.get( 'error' ) ) {
				return false;
			}

			return control.model.get( 'ids' ).length > 0;
		},

		/**
		 * Open the media select frame to edit images.
		 *
		 * @since 4.9.0
		 * @return {void}
		 */
		editMedia: function editMedia() {
			var control = this, selection, mediaFrame, mediaFrameProps;

			selection = new nx.media.model.Selection( control.selectedAttachments.models, {
				multiple: true
			});

			mediaFrameProps = control.mapModelToMediaFrameProps( control.model.toJSON() );
			selection.gallery = new Backbone.Model( mediaFrameProps );
			if ( mediaFrameProps.size ) {
				control.displaySettings.set( 'size', mediaFrameProps.size );
			}
			mediaFrame = new GalleryDetailsMediaFrame({
				frame: 'manage',
				text: control.l10n.add_to_widget,
				selection: selection,
				mimeType: control.mime_type,
				selectedDisplaySettings: control.displaySettings,
				showDisplaySettings: control.showDisplaySettings,
				metadata: mediaFrameProps,
				editing:   true,
				multiple:  true,
				state: 'gallery-edit'
			});
			nx.media.frame = mediaFrame; // See nx.media().

			// Handle selection of a media item.
			mediaFrame.on( 'update', function onUpdate( newSelection ) {
				var state = mediaFrame.state(), resultSelection;

				resultSelection = newSelection || state.get( 'selection' );
				if ( ! resultSelection ) {
					return;
				}

				// Copy orderby_random from gallery state.
				if ( resultSelection.gallery ) {
					control.model.set( control.mapMediaToModelProps( resultSelection.gallery.toJSON() ) );
				}

				// Directly update selectedAttachments to prevent needing to do additional request.
				control.selectedAttachments.reset( resultSelection.models );

				// Update models in the widget instance.
				control.model.set( {
					ids: _.pluck( resultSelection.models, 'id' )
				} );
			} );

			mediaFrame.$el.addClass( 'media-widget' );
			mediaFrame.open();

			if ( selection ) {
				selection.on( 'destroy', control.handleAttachmentDestroy );
			}
		},

		/**
		 * Open the media select frame to chose an item.
		 *
		 * @since 4.9.0
		 * @return {void}
		 */
		selectMedia: function selectMedia() {
			var control = this, selection, mediaFrame, mediaFrameProps;
			selection = new nx.media.model.Selection( control.selectedAttachments.models, {
				multiple: true
			});

			mediaFrameProps = control.mapModelToMediaFrameProps( control.model.toJSON() );
			if ( mediaFrameProps.size ) {
				control.displaySettings.set( 'size', mediaFrameProps.size );
			}
			mediaFrame = new GalleryDetailsMediaFrame({
				frame: 'select',
				text: control.l10n.add_to_widget,
				selection: selection,
				mimeType: control.mime_type,
				selectedDisplaySettings: control.displaySettings,
				showDisplaySettings: control.showDisplaySettings,
				metadata: mediaFrameProps,
				state: 'gallery'
			});
			nx.media.frame = mediaFrame; // See nx.media().

			// Handle selection of a media item.
			mediaFrame.on( 'update', function onUpdate( newSelection ) {
				var state = mediaFrame.state(), resultSelection;

				resultSelection = newSelection || state.get( 'selection' );
				if ( ! resultSelection ) {
					return;
				}

				// Copy orderby_random from gallery state.
				if ( resultSelection.gallery ) {
					control.model.set( control.mapMediaToModelProps( resultSelection.gallery.toJSON() ) );
				}

				// Directly update selectedAttachments to prevent needing to do additional request.
				control.selectedAttachments.reset( resultSelection.models );

				// Update widget instance.
				control.model.set( {
					ids: _.pluck( resultSelection.models, 'id' )
				} );
			} );

			mediaFrame.$el.addClass( 'media-widget' );
			mediaFrame.open();

			if ( selection ) {
				selection.on( 'destroy', control.handleAttachmentDestroy );
			}

			/*
			 * Make sure focus is set inside of modal so that hitting Esc will close
			 * the modal and not inadvertently cause the widget to collapse in the customizer.
			 */
			mediaFrame.$el.find( ':focusable:first' ).focus();
		},

		/**
		 * Clear the selected attachment when it is deleted in the media select frame.
		 *
		 * @since 4.9.0
		 * @param {nx.media.models.Attachment} attachment - Attachment.
		 * @return {void}
		 */
		handleAttachmentDestroy: function handleAttachmentDestroy( attachment ) {
			var control = this;
			control.model.set( {
				ids: _.difference(
					control.model.get( 'ids' ),
					[ attachment.id ]
				)
			} );
		}
	} );

	// Exports.
	component.controlConstructors.media_gallery = GalleryWidgetControl;
	component.modelConstructors.media_gallery = GalleryWidgetModel;

})( nx.mediaWidgets );
