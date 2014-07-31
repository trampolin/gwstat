$(function() {
  $("#submit_farms").click(function() {
		var message = $("#msg_farms").val();
		
		$.ajax({
			type: "POST",
			url: "bin/process_farmen.php",
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
			data: { msg: message, password: 'supergeil', mode:'text'},
			success: function(data) {
				showNotification(data,'good');
				$("#highscoreergebnis").html('<p>Ergebnis</p>'+data);
				$('#msg_highscore').val("");
			}
		});
		return false;
  });
});

$(function() {
  $("#submit_planeten").click(function() {
		var message = $("#msg_planeten").val();
		
		$.ajax({
			type: "POST",
			url: "bin/process_planeten.php",
			data: { msg: message, password: 'supergeil', mode:'text'},
			success: function(data) {
				showNotification(data,'good');
				$("#planetenergebnis").html('<p>Ergebnis</p>'+data);
				$('#msg_planeten').val("");
			}
		});
		return false;
  });
});

$(function() {
  $("#submit_kampfberichte").click(function() {
		var message = $("#msg_kampfberichte").val();
		
		$.ajax({
			type: "POST",
			url: "bin/process_kampfberichte.php",
			data: { msg: message, password: 'supergeil', mode:'text'},
			success: function(data) {
				showNotification(data,'good');
				$("#kampfberichteergebnis").html('<p>Ergebnis</p>'+data);
				$('#msg_kampfberichte').val("");
			}
		});
		return false;
  });
});

function makeToggleAble(linkid,divid,firstUse) {
	$('#'+linkid).click(function() {
		if ($('#'+divid).html().indexOf('<p>Loading...</p>') != -1) { 
			firstUse();
		}
		else
		{
			$('#'+divid).slideToggle();
			$(this).text($(this).text() == 'anzeigen' ? 'verstecken' : 'anzeigen');
		}
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

jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "planet-pre": function ( a ) {
				var tmp = document.createElement("DIV");
				tmp.innerHTML = a;

        var m = tmp.textContent.split(":"), x = "";
 
        for(var i = 0; i < m.length; i++) {
            var item = m[i];
            if(item.length == 1) {
                x += "00" + item;
            } else if(item.length == 2) {
                x += "0" + item;
            } else {
                x += item;
            }
        }
 
        return x;
    },
 
    "planet-asc": function ( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },
 
    "planet-desc": function ( a, b ) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
} );

jQuery.fn.dataTableExt.aTypes.unshift(
    function ( sData )
    {
        if (/Details: \d{1,3}:\d{1,3}:\d{1,3}/.test(sData)) {
            return 'planet';
        }
        return null;
    }
);


function submitForm(formclass, outputclass, adress) {
    $.ajax({type:'POST', url: adress, data:$('.'+formclass).serialize(), success: function(response) {
        $('.'+formclass).find('.'+outputclass).html(response);
    }});
    return false;
}

function sendProbes(toc)
{
  /*
  a=$('#fromG').val();
  b=$('#fromS').val();
  c=$('#fromP').val();   
  
  var arr = new Array();
  
   //koords
  arr["fromc"] = $('#fromG').val()+":"+$('#fromS').val()+":"+$('#fromP').val()+":"+$('#fromT').val();
  arr["toc"]  = toc;
  arr["type"] = "sendprobes";
  
  var ajax = new Ajax();
  
  ajax.action = "http://uni1.gigrawars.de/ajax.php";
  ajax.method = "post";
  
  ajax.createFormArray(arr);
  
  ajax.onready = function () {
        var fleetCode = Number(this.response);
        if(fleetCode == -100)
        {
            //success   
						showNotification("Probe sent",'good');
            
        }else{
            showNotification("Error: "+fleetCode,'bad');
        }
    };
    
    //clearInterval(timerTO);
    ajax.run();
		*/
}