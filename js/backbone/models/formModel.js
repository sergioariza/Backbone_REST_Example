$("#outgoingsForm").submit(function( event ) {
  event.preventDefault();
  var url = 'http://localhost:8080/backbone_rest_example/api/outgoings';
  var $form = $(this);
  var formValues = {
    "id": $form.find( "input[name='id']" ).val(),
    "description": $form.find("input[name='description']").val(),
    "quantity": $form.find("input[name='quantity']").val()
  };

  $.ajax({
      url:url,
      type:'POST',
      data: JSON.stringify(formValues),
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      processData: true,
      success: function (data) {
        console.log(["Login request details: ", data]);
        if(data.error) {  // If there is an error, show the error messages
           $('.alert-error').text(data.error.text).show();
        }
        else { // If not, send them back to the home page
          window.location.replace('http://localhost:8080/backbone_rest_example/index.html');
        }
      }
  });
});