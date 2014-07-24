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

function requestCompleteHighscore(aContainer,aFilter) {
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
	requestInterface("HighscoreInterface","getCompleteHighscore",aFilter,requestCompleteHighscoreCallback,undefined);
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

function requestPlanetDistribution(aContainer,aFilter) {
	var requestPlanetDistributionCallback = function(response) {
		if (checkResult(response)) 
		{
			$("#"+aContainer).html(response.data.html);
			$('#'+aContainer).slideDown();
			$('#toggle'+aContainer).text('verstecken');
			
			if (response.data.planetenverteilung != undefined && response.data.planetenverteilung != null)
			{
				var plotPlanetenVerteilung = $.jqplot('planetenverteilung', [response.data.planetenverteilung], {
					title:'Verteilung der Planeten',
					seriesDefaults: { 
						pointLabels: { show:true } 
					},
					axes:{
						xaxis:{
							renderer:$.jqplot.LinearAxisRenderer,
							min: 0,
							max: 300,
							numberTicks: 21
						},
						yaxis:{
							renderer:$.jqplot.LinearAxisRenderer,
							min: 0,
							max: 2000,
						}
					},
					highlighter: {
						show: true,
						sizeAdjust: 7.5
					},
					cursor:{ 
						show: true,
						zoom:true, 
						showTooltip:false
					} 
				});
			}
		}
		else
		{
			showNotification(response.message,'bad');
		}
	};
	requestInterface("PlanetInterface","getPlanetOverview",aFilter,requestPlanetDistributionCallback,undefined);
}

function requestAllKampfberichte(aContainer,aFilter) {
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
	requestInterface("KampfberichtInterface","getAllKampfberichte",aFilter,requestAllPlanetsCallback,undefined);
}

function requestFarmPerDayKampf(aContainer) {
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
	requestInterface("KampfberichtInterface","getCompleteFarmPerDay",undefined,requestFarmPerDayCallback,undefined);
}

function getMinMax(line)
{
	var minY = 10000000;
	var maxY = 0;
	for (i = 0;i<line.length;i++)
	{
		if (line[i][1] > maxY) { maxY = parseInt(line[i][1],10);}
		if (line[i][1] < minY) { minY = parseInt(line[i][1],10);}
	}
	var diffXY = maxY-minY;
	
	if (diffXY == 0)
	{
		maxY = maxY+20;
		minY = minY-20;
	}
	else
	{
		maxY = maxY+(diffXY/2)+1;
		minY = minY-(diffXY/2)-1;
	}
	
	return { min: minY, max: maxY, diff: diffXY };
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
			
			if (response.data.highscoredata != undefined && response.data.highscoredata != null)
			{
				//$("#messageboxcontainer").append("<p>Verlauf:</p>");
				var punkteline = response.data.highscoredata.punkte;
				var platzline = response.data.highscoredata.platz;
				var planetenline = response.data.highscoredata.planeten;
				
				if (punkteline.length > 0 || platzline.length > 0 || planetenline.length > 0)
				{
					
					var punkteminmax = getMinMax(punkteline);
					var platzminmax = getMinMax(platzline); 
					var planetenminmax = getMinMax(planetenline); 
					
					var plot1 = $.jqplot('highscoreverlauf', [punkteline, platzline], {
							title:'Punkteverlauf',
							seriesDefaults: { 
								pointLabels: { show:true } 
							},
							series:[
								{
									
								},
								{
									yaxis: 'y2axis'
								}
							],
							
							axes:{
								xaxis:{
									renderer:$.jqplot.DateAxisRenderer,
								},
								yaxis:{
									renderer:$.jqplot.LinearAxisRenderer,
									min: punkteminmax.min,
									max: punkteminmax.max,
									numberTicks: 5
								},
								y2axis:{
									renderer:$.jqplot.LinearAxisRenderer,
									min: platzminmax.max,
									max: platzminmax.min,
									numberTicks: 5
								}
								
							},
							highlighter: {
								show: true,
								sizeAdjust: 7.5
							},
							cursor: {
								show: false
							}
					});
					
					$("#messageboxcontainer").append("<p>Punkte gemacht: "+punkteminmax.diff+"</p>");
				}
				
			}
			
			
		}
		else
		{
			showNotification(response.message,'bad');
		}
	};
	requestInterface(aInterface,aFunction,aData,ajaxMessageBoxCallback,undefined)
}