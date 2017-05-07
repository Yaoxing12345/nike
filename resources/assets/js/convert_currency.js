$('#to_country').change(function () {
    alert("hiii");

  $.ajax({
    'url' : '/conversion-factor',
    'type' : 'GET',
    beforeSend: function() {
                alert(1);
            },
    error: function() {
                alert('Error');
            },
    'success' : function(data) {
      if (data == "success") {
        alert('request sent!');
      }
    }
  });
});