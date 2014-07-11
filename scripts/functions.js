$(function() {
  $(".button").click(function() {
		var message = $("#msg").val();
		
		$.ajax({
			type: "POST",
			url: "bin/ausgabe.php",
			data: { msg: message, password: 'supergeil'},
			success: function(data) {
				showNotification(data,'good');
				$("#farmergebnis").html('<p>Ergebnis</p>'+data);
				$('#msg').val("");
			}
		});
		return false;
  });
});

function showNotification(aMessage,aTheme) {
	$.jGrowl(aMessage, {theme: aTheme});
}

function showDebugNotification(aMessage) {
	$.jGrowl(aMessage, {theme: 'debug'});
}

function checkResult(response) {
	if (response != undefined)
	{
		if (debug && response.debugInfo != null)
		{
			showDebugNotification(response.debugInfo);
		}
		return (response.result != undefined) && (response.result == "ok")
	}
	else
	{
		return false;
	}

}

function submitForm(formclass, outputclass, adress) {
    $.ajax({type:'POST', url: adress, data:$('.'+formclass).serialize(), success: function(response) {
        $('.'+formclass).find('.'+outputclass).html(response);
    }});
    return false;
}