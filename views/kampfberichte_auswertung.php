<?php

if (isset($login)) {
	if ($login->isUserLoggedIn() == true) {
		kampfMenu();
		?>
		<div class="contentitem round">
			<p>Gesamt Farmertr&auml;ge pro Tag <a href="#" id="togglefarmperday">anzeigen</a></p>
			<div id="farmperday" class="hidden">
				<p>Loading...</p>
			</div>
		</div>
		
		
		<div class="contentitem round">
			<p>Alle Kampfberichte <a href="#" id="toggleallkampfberichte">anzeigen</a></p>
			<div id="allkampfberichte" class="hidden">
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
		makeToggleAble('togglefarmperday','farmperday',function() { requestFarmPerDayKampf('farmperday'); });
		
		makeToggleAble('toggleallkampfberichte','allkampfberichte',function() { requestAllKampfberichte('allkampfberichte'); });
	});
	</script>