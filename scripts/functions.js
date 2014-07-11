$(function() {
  $("#submit_farms").click(function() {
		var message = $("#msg_farms").val();
		
		$.ajax({
			type: "POST",
			url: "bin/ausgabe.php",
			data: { msg: message, password: 'supergeil'},
			success: function(data) {
				showNotification(data,'good');
				$("#farmergebnis").html('<p>Ergebnis</p>'+data);
				$('#msg_farms').val("");
			}
		});
		return false;
  });
});

$(function() {
  $("#submit_highscore").click(function() {
		var message = $("#msg_highscore").val();
		
		$.ajax({
			type: "POST",
			url: "bin/process_highscore.php",
			data: { msg: message, password: 'supergeil'},
			success: function(data) {
				showNotification(data,'good');
				$("#highscoreergebnis").html('<p>Ergebnis</p>'+data);
				$('#msg_highscore').val("");
			}
		});
		return false;
  });
});

function makeToggleAble(linkid,divid) {
	$('#'+linkid).click(function() {
		$('#'+divid).slideToggle();
		$(this).text($(this).text() == 'anzeigen' ? 'verstecken' : 'anzeigen');
	});
}

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