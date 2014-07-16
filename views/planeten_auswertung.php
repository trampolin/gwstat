<?php

if (isset($login)) {
	if ($login->isUserLoggedIn() == true) {
		planetenMenu();
		?>
		<div class="contentitem round">
			<p>Alle Planeten <a href="#" id="toggleallplanets">anzeigen</a></p>
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
	makeToggleAble('toggleallplanets','allplanets',function() { requestAllPlanets('allplanets'); });
});
</script>