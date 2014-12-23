
var views = {};

views.OutgoingsItem = Backbone.View.extend({
  tagName: 'tr',

  initialize: function(options) {
    _.bindAll(this, 'render');
    this.model.bind('change', this.render);
  },

  render: function() {
    jQuery(this.el).empty();
    jQuery(this.el).append(jQuery('<td>' + this.model.get('id') + '</td>'));
    jQuery(this.el).append(jQuery('<td>' + this.model.get('description') + '</td>'));
    jQuery(this.el).append(jQuery('<td>' + this.model.get('quantity') + '</td>'));
    jQuery(this.el).append(jQuery('<td><a class="btn btn-danger" onclick="deleteOutgoings(' + this.model.get('id') + ')">Borrar gasto</a></td>'));
    return this;
  }
});

views.OutgoingsCollection = Backbone.View.extend({
  collection: null,
  el: 'tbody',
  initialize: function(options) {
    this.collection = options.collection;
    _.bindAll(this, 'render');
    this.collection.bind('reset', this.render);
    this.collection.bind('add', this.render);
    this.collection.bind('remove', this.render);
  },

  render: function() {
    var element = jQuery(this.el);
    element.empty();
    this.collection.forEach(function(item) {
      var itemView = new views.OutgoingsItem({
        model: item
      });
      element.append(itemView.render().el);
    });
    return this;
  }
});
