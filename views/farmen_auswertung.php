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
			<div id="farmperplanet" class="hidden">
				<p>Loading...</p>
			</div>
		</div>

		<div class="contentitem round">
			<p>Durchschnittliche Farmertr&auml;ge pro Farm <a href="#" id="toggleavgfarmperplanet">anzeigen</a></p>
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
				makeToggleAble('togglefarmperplanet','farmperplanet',function() { requestFarmPerPlanet('farmperplanet'); });
				makeToggleAble('toggleavgfarmperplanet','avgfarmperplanet',function() { requestAvgFarmPerPlanet('avgfarmperplanet'); });
			});
			</script>