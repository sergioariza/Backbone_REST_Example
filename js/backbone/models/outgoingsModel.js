var models = {};

models.Outgoings = Backbone.Model.extend();

models.OutgoingsCollection = Backbone.Collection.extend({
  model: models.Outgoings,
  url: 'http://localhost:8080/backbone_rest_example/api/outgoings'
});

