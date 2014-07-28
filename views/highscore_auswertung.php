<?php

if (isset($login)) {
	if ($login->isUserLoggedIn() == true) {
		highscoreMenu();
		?>
		<!--div class="contentitem round">
			<p>Aktive Spieler <a href="#" id="toggleactivehighscore">anzeigen</a></p>
			<div id="activehighscore" class="hidden">
				<p>Loading...</p>
			</div>
		</div-->
		
		<div class="contentitem round">
			<p>Komplette Highscore <a href="#" id="togglecompletehighscore">anzeigen</a></p>
			<p>Name <input name="completehighscore_filter_name" label="Name" type="text" id="completehighscore_filter_name" size="20" maxlength="50"> | Allianz 
				<input name="completehighscore_filter_allianz" label="Allianz" type="text" id="completehighscore_filter_allianz" size="20" maxlength="50">
				<img title="Neu laden" src="images/refresh.png" class="icon" id="completehighscore_refresh"/>
				<img title="Favoriten anzeigen" src="images/star_y.png" class="icon" id="completehighscore_favorit"/>
			<div id="completehighscore" class="hidden">
				<p>Loading...</p>
			</div>
		</div>
		
		<div class="contentitem round">
			<p>Inaktive Spieler <a href="#" id="toggleinactivehighscore">anzeigen</a></p>
			<p>Name <input name="inactivehighscore_filter_name" label="Name" type="text" id="inactivehighscore_filter_name" size="20" maxlength="50"> | Allianz 
				<input name="inactivehighscore_filter_allianz" label="Allianz" type="text" id="inactivehighscore_filter_allianz" size="20" maxlength="50"> | Tage
				<input name="inactivehighscore_filter_days" label="Tage" type="number" id="inactivehighscore_filter_days" size="5" maxlength="10000">
				<img title="Neu laden" src="images/refresh.png" class="icon" id="inactivehighscore_refresh"/>
				<img title="Favoriten anzeigen" src="images/star_y.png" class="icon" id="inactivehighscore_favorit"/>
			<div id="inactivehighscore" class="hidden">
				<p>Loading...</p>
			</div>
		</div>
		<?php
	}
		
}


//select t1.hs_name,t1.hs_timestamp,t1.hs_punkte as PunkteNeu,t2.hs_punkte as PunkteAlt from highscore as t1 join highscore as t2 on t1.hs_name = t2.hs_name and t1.hs_timestamp > t2.hs_timestamp where t1.hs_punkte <> t2.hs_punkte group by 1,2,3,4 order by t1.hs_platz

?>
	<script type="text/javascript">
	$(function() {
		makeToggleAble('togglecompletehighscore','completehighscore',function() { requestCompleteHighscore('completehighscore', {player: ($('#completehighscore_filter_name').val() != '' ? $('#completehighscore_filter_name').val() : undefined), ally: ($('#completehighscore_filter_allianz').val() != '' ? $('#completehighscore_filter_allianz').val() : undefined)}); });
		
		$('#completehighscore_filter_name').keyup(function(e) {if(e.keyCode == 13) {requestCompleteHighscore('completehighscore', {player: ($('#completehighscore_filter_name').val() != '' ? $('#completehighscore_filter_name').val() : undefined), ally: ($('#completehighscore_filter_allianz').val() != '' ? $('#completehighscore_filter_allianz').val() : undefined)});}});
		$('#completehighscore_filter_allianz').keyup(function(e) {if(e.keyCode == 13) {requestCompleteHighscore('completehighscore', {player: ($('#completehighscore_filter_name').val() != '' ? $('#completehighscore_filter_name').val() : undefined), ally: ($('#completehighscore_filter_allianz').val() != '' ? $('#completehighscore_filter_allianz').val() : undefined)});}});
		$('#completehighscore_refresh').click(function () {requestCompleteHighscore('completehighscore', {player: ($('#completehighscore_filter_name').val() != '' ? $('#completehighscore_filter_name').val() : undefined), ally: ($('#completehighscore_filter_allianz').val() != '' ? $('#completehighscore_filter_allianz').val() : undefined)});});
		$('#completehighscore_favorit').click(function () {requestCompleteHighscore('completehighscore', {favoriten: true});});
		
		makeToggleAble('toggleinactivehighscore','inactivehighscore',function() { requestInactiveHighscore('inactivehighscore', {player: ($('#inactivehighscore_filter_name').val() != '' ? $('#inactivehighscore_filter_name').val() : undefined), ally: ($('#inactivehighscore_filter_allianz').val() != '' ? $('#inactivehighscore_filter_allianz').val() : undefined), days: ($('#inactivehighscore_filter_days').val() != '' ? $('#inactivehighscore_filter_days').val() : undefined)}); });
		
		$('#inactivehighscore_filter_name').keyup(function(e) {if(e.keyCode == 13) {requestInactiveHighscore('inactivehighscore', {player: ($('#inactivehighscore_filter_name').val() != '' ? $('#inactivehighscore_filter_name').val() : undefined), ally: ($('#inactivehighscore_filter_allianz').val() != '' ? $('#inactivehighscore_filter_allianz').val() : undefined), days: ($('#inactivehighscore_filter_days').val() != '' ? $('#inactivehighscore_filter_days').val() : undefined)});}});
		$('#inactivehighscore_filter_allianz').keyup(function(e) {if(e.keyCode == 13) {requestInactiveHighscore('inactivehighscore', {player: ($('#inactivehighscore_filter_name').val() != '' ? $('#inactivehighscore_filter_name').val() : undefined), ally: ($('#inactivehighscore_filter_allianz').val() != '' ? $('#inactivehighscore_filter_allianz').val() : undefined), days: ($('#inactivehighscore_filter_days').val() != '' ? $('#inactivehighscore_filter_days').val() : undefined)});}});
		$('#inactivehighscore_filter_days').keyup(function(e) {if(e.keyCode == 13) {requestInactiveHighscore('inactivehighscore', {player: ($('#inactivehighscore_filter_name').val() != '' ? $('#inactivehighscore_filter_name').val() : undefined), ally: ($('#inactivehighscore_filter_allianz').val() != '' ? $('#inactivehighscore_filter_allianz').val() : undefined), days: ($('#inactivehighscore_filter_days').val() != '' ? $('#inactivehighscore_filter_days').val() : undefined)});}});
		$('#inactivehighscore_refresh').click(function () {requestInactiveHighscore('inactivehighscore', {player: ($('#inactivehighscore_filter_name').val() != '' ? $('#inactivehighscore_filter_name').val() : undefined), ally: ($('#inactivehighscore_filter_allianz').val() != '' ? $('#inactivehighscore_filter_allianz').val() : undefined), days: ($('#inactivehighscore_filter_days').val() != '' ? $('#inactivehighscore_filter_days').val() : undefined)});});
		$('#inactivehighscore_favorit').click(function () {requestInactiveHighscore('inactivehighscore', {favoriten: true});});

		
		//makeToggleAble('toggleactivehighscore','activehighscore',function() { requestActiveHighscore('activehighscore'); });
	});
	</script>