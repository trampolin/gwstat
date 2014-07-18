<?php

if (isset($login)) {
	if ($login->isUserLoggedIn() == true) {
		planetenMenu();
		?>
		<div class="contentitem round">
			<p>Alle Planeten <a href="#" id="toggleallplanets">anzeigen</a></p>
			<p><input name="filter_galaxy" label="Galaxie" type="number" id="filter_galaxy" size="3" maxlength="3"> : 
				<input name="filter_system" label="System" type="number" id="filter_system" size="3" maxlength="3">
				<img src="images/refresh.png" class="icon" id="refresh_allplanets"/>
			</p>
			<div id="allplanets" class="hidden">
				<p>Loading...</p>
			</div>
		</div>
		<?php
	}
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
	makeToggleAble('toggleallplanets','allplanets',function() { requestAllPlanets('allplanets', {galaxy: $('#filter_galaxy').val(), system: $('#filter_system').val()}); });
	$('#filter_galaxy').focus();
	$('#filter_system').keyup(function(e) {if(e.keyCode == 13) {requestAllPlanets('allplanets', {galaxy: $('#filter_galaxy').val(), system: $('#filter_system').val()});}});
	$('#filter_galaxy').keyup(function(e) {if(e.keyCode == 13) {requestAllPlanets('allplanets', {galaxy: $('#filter_galaxy').val(), system: $('#filter_system').val()});}});
	$('#refresh_allplanets').click(function () {requestAllPlanets('allplanets', {galaxy: $('#filter_galaxy').val(), system: $('#filter_system').val()});});
});
</script>