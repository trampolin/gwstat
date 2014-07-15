<?php

if (isset($login)) {
	if ($login->isUserLoggedIn() == true) {
		highscoreMenu();
		?>
		<div class="contentitem round">
			<p>Aktive Spieler <a href="#" id="toggleactivehighscore">anzeigen</a></p>
			<div id="activehighscore" class="hidden">
				<p>Loading...</p>
			</div>
		</div>
		
		<div class="contentitem round">
			<p>Komplette Highscore <a href="#" id="togglecompletehighscore">anzeigen</a></p>
			<div id="completehighscore" class="hidden">
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
		makeToggleAble('togglecompletehighscore','completehighscore',function() { requestCompleteHighscore('completehighscore'); });
		makeToggleAble('toggleactivehighscore','activehighscore',function() { requestActiveHighscore('activehighscore'); });
	});
	</script>