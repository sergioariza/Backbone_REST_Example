var models = {};

models.Outgoings = Backbone.Model.extend();

models.OutgoingsCollection = Backbone.Collection.extend({
  model: models.Outgoings,
  url: 'http://localhost:8080/backbone_rest_example/api/outgoings'
});

var deleteOutgoings = function(id)
{
  var url = 'http://localhost:8080/backbone_rest_example/api/outgoings/' + id;
  $.ajax({
      url: url,
      type:'DELETE',
      success: function (data) {
        if(data.error) {
        	$('.alert-error').text(data.error.text).show();
        }
        else {
         	window.location.replace('http://localhost:8080/backbone_rest_example/index.html');
        }
      }
  });
}