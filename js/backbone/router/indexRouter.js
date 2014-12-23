
var Router = Backbone.Router.extend({
  routes: {
    '': 'index'
  },

  index: function() {
    var outgoings = new models.OutgoingsCollection();
    outgoings.fetch();

    var view = new views.OutgoingsCollection({
      collection: outgoings
    });

    view.render();
  }
});

jQuery(document).ready(function() {
  var router = new Router();
  Backbone.history.start();
});
