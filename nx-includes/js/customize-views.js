/**
 * @output nx-includes/js/customize-views.js
 */

(function( $, nx, _ ) {

	if ( ! nx || ! nx.customize ) { return; }
	var api = nx.customize;

	/**
	 * nx.customize.HeaderTool.CurrentView
	 *
	 * Displays the currently selected header image, or a placeholder in lack
	 * thereof.
	 *
	 * Instantiate with model nx.customize.HeaderTool.currentHeader.
	 *
	 * @memberOf nx.customize.HeaderTool
	 * @alias nx.customize.HeaderTool.CurrentView
	 *
	 * @constructor
	 * @augments nx.Backbone.View
	 */
	api.HeaderTool.CurrentView = nx.Backbone.View.extend(/** @lends nx.customize.HeaderTool.CurrentView.prototype */{
		template: nx.template('header-current'),

		initialize: function() {
			this.listenTo(this.model, 'change', this.render);
			this.render();
		},

		render: function() {
			this.$el.html(this.template(this.model.toJSON()));
			this.setButtons();
			return this;
		},

		setButtons: function() {
			var elements = $('#customize-control-header_image .actions .remove');
			if (this.model.get('choice')) {
				elements.show();
			} else {
				elements.hide();
			}
		}
	});


	/**
	 * nx.customize.HeaderTool.ChoiceView
	 *
	 * Represents a choosable header image, be it user-uploaded,
	 * theme-suggested or a special Randomize choice.
	 *
	 * Takes a nx.customize.HeaderTool.ImageModel.
	 *
	 * Manually changes model nx.customize.HeaderTool.currentHeader via the
	 * `select` method.
	 *
	 * @memberOf nx.customize.HeaderTool
	 * @alias nx.customize.HeaderTool.ChoiceView
	 *
	 * @constructor
	 * @augments nx.Backbone.View
	 */
	api.HeaderTool.ChoiceView = nx.Backbone.View.extend(/** @lends nx.customize.HeaderTool.ChoiceView.prototype */{
		template: nx.template('header-choice'),

		className: 'header-view',

		events: {
			'click .choice,.random': 'select',
			'click .close': 'removeImage'
		},

		initialize: function() {
			var properties = [
				this.model.get('header').url,
				this.model.get('choice')
			];

			this.listenTo(this.model, 'change:selected', this.toggleSelected);

			if (_.contains(properties, api.get().header_image)) {
				api.HeaderTool.currentHeader.set(this.extendedModel());
			}
		},

		render: function() {
			this.$el.html(this.template(this.extendedModel()));

			this.toggleSelected();
			return this;
		},

		toggleSelected: function() {
			this.$el.toggleClass('selected', this.model.get('selected'));
		},

		extendedModel: function() {
			var c = this.model.get('collection');
			return _.extend(this.model.toJSON(), {
				type: c.type
			});
		},

		select: function() {
			this.preventJump();
			this.model.save();
			api.HeaderTool.currentHeader.set(this.extendedModel());
		},

		preventJump: function() {
			var container = $('.nx-full-overlay-sidebar-content'),
				scroll = container.scrollTop();

			_.defer(function() {
				container.scrollTop(scroll);
			});
		},

		removeImage: function(e) {
			e.stopPropagation();
			this.model.destroy();
			this.remove();
		}
	});


	/**
	 * nx.customize.HeaderTool.ChoiceListView
	 *
	 * A container for ChoiceViews. These choices should be of one same type:
	 * user-uploaded headers or theme-defined ones.
	 *
	 * Takes a nx.customize.HeaderTool.ChoiceList.
	 *
	 * @memberOf nx.customize.HeaderTool
	 * @alias nx.customize.HeaderTool.ChoiceListView
	 *
	 * @constructor
	 * @augments nx.Backbone.View
	 */
	api.HeaderTool.ChoiceListView = nx.Backbone.View.extend(/** @lends nx.customize.HeaderTool.ChoiceListView.prototype */{
		initialize: function() {
			this.listenTo(this.collection, 'add', this.addOne);
			this.listenTo(this.collection, 'remove', this.render);
			this.listenTo(this.collection, 'sort', this.render);
			this.listenTo(this.collection, 'change', this.toggleList);
			this.render();
		},

		render: function() {
			this.$el.empty();
			this.collection.each(this.addOne, this);
			this.toggleList();
		},

		addOne: function(choice) {
			var view;
			choice.set({ collection: this.collection });
			view = new api.HeaderTool.ChoiceView({ model: choice });
			this.$el.append(view.render().el);
		},

		toggleList: function() {
			var title = this.$el.parents().prev('.customize-control-title'),
				randomButton = this.$el.find('.random').parent();
			if (this.collection.shouldHideTitle()) {
				title.add(randomButton).hide();
			} else {
				title.add(randomButton).show();
			}
		}
	});


	/**
	 * nx.customize.HeaderTool.CombinedList
	 *
	 * Aggregates nx.customize.HeaderTool.ChoiceList collections (or any
	 * Backbone object, really) and acts as a bus to feed them events.
	 *
	 * @memberOf nx.customize.HeaderTool
	 * @alias nx.customize.HeaderTool.CombinedList
	 *
	 * @constructor
	 * @augments nx.Backbone.View
	 */
	api.HeaderTool.CombinedList = nx.Backbone.View.extend(/** @lends nx.customize.HeaderTool.CombinedList.prototype */{
		initialize: function(collections) {
			this.collections = collections;
			this.on('all', this.propagate, this);
		},
		propagate: function(event, arg) {
			_.each(this.collections, function(collection) {
				collection.trigger(event, arg);
			});
		}
	});

})( jQuery, window.nx, _ );
