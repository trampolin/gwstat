var debug = true;

function requestInterfaceCustomBlock(aInterface,aFunction,aData,aSuccess,aFail,aBlock,aUnblock) {
	var requestInterfaceFail = function(xhr,status,error) {
		showNotification(xhr.responseText,'bad');
	};
	var params = {					
					intf: aInterface,
					func: aFunction,
					data: (aData == undefined ? null : aData)};
	
	if (aFail==undefined) {
		aFail = requestInterfaceFail;
	};
	
	$.ajax(
		{
			url: "./classes/requesthandler/requesthandler.php",
			data: JSON.stringify(params),
			dataType : "json",
			contentType: 'application/json; charset=UTF-8',
			type: "POST",
			beforeSend: aBlock,
			complete: aUnblock,
			success: aSuccess,
			error: aFail
		}
	)
} 

function requestInterface(aInterface,aFunction,aData,aSuccess,aFail) {
	requestInterfaceCustomBlock(
		aInterface,
		aFunction,
		aData,
		aSuccess,
		aFail,
			function() 
			{ 
				$.blockUI(
				{ 
					css: 
					{ 
						border: 'none', 
						padding: '15px', 
						backgroundColor: '#000', 
						'-webkit-border-radius': '10px', 
						'-moz-border-radius': '10px',
						'border-radius': '10px',
						opacity: .5, 
						color: '#fff' 
					}, 
					overlayCSS: 
					{ 
						backgroundColor: '#888' 
					},
					message: null //$('#loading')
				});
			}
		,
		function() { $.unblockUI(); }
		) 
}

function requestCompleteHighscore(aContainer) {
	var requestCompleteHighscoreCallback = function(response) {
		if (checkResult(response)) 
		{
			$("#"+aContainer).html(response.data.html);
			$('#'+aContainer).slideDown();
			$('#toggle'+aContainer).text('verstecken');
		}
		else
		{
			showNotification(response.message,'bad');
		}
	};
	requestInterface("HighscoreInterface","getCompleteHighscore",undefined,requestCompleteHighscoreCallback,undefined);
}

function requestActiveHighscore(aContainer) {
	var requestActiveHighscoreCallback = function(response) {
		if (checkResult(response)) 
		{
			$("#"+aContainer).html(response.data.html);
			$('#'+aContainer).slideDown();
			$('#toggle'+aContainer).text('verstecken');
		}
		else
		{
			showNotification(response.message,'bad');
		}
	};
	requestInterface("HighscoreInterface","getActiveHighscore",undefined,requestActiveHighscoreCallback,undefined);
}

function requestFarmPerDay(aContainer) {
	var requestFarmPerDayCallback = function(response) {
		if (checkResult(response)) 
		{
			$("#"+aContainer).html(response.data.html);
			$('#'+aContainer).slideDown();
			$('#toggle'+aContainer).text('verstecken');
		}
		else
		{
			showNotification(response.message,'bad');
		}
	};
	requestInterface("FarmInterface","getCompleteFarmPerDay",undefined,requestFarmPerDayCallback,undefined);
}

function requestFarmPerOwnPlanet(aContainer) {
	var requestFarmPerOwnPlanetCallback = function(response) {
		if (checkResult(response)) 
		{
			$("#"+aContainer).html(response.data.html);
			$('#'+aContainer).slideDown();
			$('#toggle'+aContainer).text('verstecken');
		}
		else
		{
			showNotification(response.message,'bad');
		}
	};
	requestInterface("FarmInterface","getCompleteFarmPerOwnPlanet",undefined,requestFarmPerOwnPlanetCallback,undefined);
}

function requestFarmPerPlanet(aContainer,aFilter) {
	var requestFarmPerPlanetCallback = function(response) {
		if (checkResult(response)) 
		{
			$("#"+aContainer).html(response.data.html);
			$('#'+aContainer).slideDown();
			$('#toggle'+aContainer).text('verstecken');
		}
		else
		{
			showNotification(response.message,'bad');
		}
	};
	requestInterface("FarmInterface","getCompletePerFarm",aFilter,requestFarmPerPlanetCallback,undefined);
}

function requestAvgFarmPerPlanet(aContainer,aFilter) {
	var requestAvgFarmPerPlanetCallback = function(response) {
		if (checkResult(response)) 
		{
			$("#"+aContainer).html(response.data.html);
			$('#'+aContainer).slideDown();
			$('#toggle'+aContainer).text('verstecken');
		}
		else
		{
			showNotification(response.message,'bad');
		}
	};
	requestInterface("FarmInterface","getAveragePerFarm",aFilter,requestAvgFarmPerPlanetCallback,undefined);
}

function requestAllPlanets(aContainer,aFilter) {
	var requestAllPlanetsCallback = function(response) {
		if (checkResult(response)) 
		{
			$("#"+aContainer).html(response.data.html);
			$('#'+aContainer).slideDown();
			$('#toggle'+aContainer).text('verstecken');
		}
		else
		{
			showNotification(response.message,'bad');
		}
	};
	requestInterface("PlanetInterface","getAllPlanets",aFilter,requestAllPlanetsCallback,undefined);
}

function ajaxMessageBox(aInterface,aFunction,aData) {
	var ajaxMessageBoxCallback = function(response) {
		if (checkResult(response)) 
		{
			if (response.data.title != undefined && response.data.title != null)
			{
				$("#messageboxcontainer").html("<p>"+response.data.title+"</p>");
			}
			else
			{
				$("#messageboxcontainer").html("<p></p>");
			}
			$("#messageboxcontainer").append(response.data.html);
			$("#messageboxcontainer").bPopup();
		}
		else
		{
			showNotification(response.message,'bad');
		}
	};
	requestInterface(aInterface,aFunction,aData,ajaxMessageBoxCallback,undefined)
}