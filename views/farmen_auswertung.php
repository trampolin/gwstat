<?php

if (isset($login)) {
	if ($login->isUserLoggedIn() == true) {
		farmMenu();
		?>
		<div class="contentitem round">
			<p>Gesamt Farmertr&auml;ge pro Tag <a href="#" id="togglefarmperday">anzeigen</a></p>
			<div id="farmperday" class="hidden">
				<p>Loading...</p>
			</div>
		</div>

		<div class="contentitem round">
			<p>Gesamt Farmertr&auml;ge pro eigenem Planet <a href="#" id="togglefarmperownplanet">anzeigen</a></p>
			<div id="farmperownplanet" class="hidden">
				<p>Loading...</p>
			</div>
		</div>

		<div class="contentitem round">
			<p>Gesamt Farmertr&auml;ge pro Farm <a href="#" id="togglefarmperplanet">anzeigen</a></p>
			<p><input name="all_filter_galaxy" label="Galaxie" type="number" id="all_filter_galaxy" size="3" maxlength="3"> : 
				<input name="all_filter_system" label="System" type="number" id="all_filter_system" size="3" maxlength="3">
				<img src="images/refresh.png" class="icon" id="all_refresh_allplanets"/>
				<img title="Favoriten anzeigen" src="images/star_y.png" class="icon" id="all_favorit"/>
			</p>
			<div id="farmperplanet" class="hidden">
				<p>Loading...</p>
			</div>
		</div>

		<div class="contentitem round">
			<p>Durchschnittliche Farmertr&auml;ge pro Farm <a href="#" id="toggleavgfarmperplanet">anzeigen</a></p>
			<p><input name="avg_filter_galaxy" label="Galaxie" type="number" id="avg_filter_galaxy" size="3" maxlength="3"> : 
				<input name="avg_filter_system" label="System" type="number" id="avg_filter_system" size="3" maxlength="3">
				<img src="images/refresh.png" class="icon" id="avg_refresh_allplanets"/>
				<img title="Favoriten anzeigen" src="images/star_y.png" class="icon" id="avg_favorit"/>
			</p>
			<div id="avgfarmperplanet" class="hidden">
				<p>Loading...</p>
			</div>
		</div>
		<?php
	}
		
		
		?>

		<?php
}
else
{
	?>
	<p>Not logged in!</p>
	<?php
}
//
?>
			<script type="text/javascript">
			$(function() {
				makeToggleAble('togglefarmperday','farmperday',function() { requestFarmPerDay('farmperday'); });
				makeToggleAble('togglefarmperownplanet','farmperownplanet',function() { requestFarmPerOwnPlanet('farmperownplanet'); });
				makeToggleAble('togglefarmperplanet','farmperplanet',function() { requestFarmPerPlanet('farmperplanet', {galaxy: $('#all_filter_galaxy').val(), system: $('#all_filter_system').val()}); });
				makeToggleAble('toggleavgfarmperplanet','avgfarmperplanet',function() { requestAvgFarmPerPlanet('avgfarmperplanet', {galaxy: $('#avg_filter_galaxy').val(), system: $('#avg_filter_system').val()}); });
				
				$('#all_filter_system').keyup(function(e) {if(e.keyCode == 13) {requestFarmPerPlanet('farmperplanet', {galaxy: $('#all_filter_galaxy').val(), system: $('#all_filter_system').val()});}});
				$('#all_filter_galaxy').keyup(function(e) {if(e.keyCode == 13) {requestFarmPerPlanet('farmperplanet', {galaxy: $('#all_filter_galaxy').val(), system: $('#all_filter_system').val()});}});
				$('#all_refresh_allplanets').click(function () {requestFarmPerPlanet('farmperplanet', {galaxy: $('#all_filter_galaxy').val(), system: $('#all_filter_system').val()});});
				$('#all_favorit').click(function () {requestFarmPerPlanet('farmperplanet', {favoriten: true});});

				$('#avg_filter_system').keyup(function(e) {if(e.keyCode == 13) {requestAvgFarmPerPlanet('avgfarmperplanet', {galaxy: $('#avg_filter_galaxy').val(), system: $('#avg_filter_system').val()});}});
				$('#avg_filter_galaxy').keyup(function(e) {if(e.keyCode == 13) {requestAvgFarmPerPlanet('avgfarmperplanet', {galaxy: $('#avg_filter_galaxy').val(), system: $('#avg_filter_system').val()});}});
				$('#avg_refresh_allplanets').click(function () {requestAvgFarmPerPlanet('avgfarmperplanet', {galaxy: $('#avg_filter_galaxy').val(), system: $('#avg_filter_system').val()});});
				$('#avg_favorit').click(function () {requestAvgFarmPerPlanet('avgfarmperplanet', {favoriten: true});});
				});
			</script>