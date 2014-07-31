<?php

if (isset($login)) {
	if ($login->isUserLoggedIn() == true) {
	toolsMenu();
		?>
		
		<div class="contentitem round">
			<div class="inneritem" id="lastattack">
			<p><input type="number" id="prodprostunde" name="prodprostunde" title="Produktion pro Stunde">Produktion Pro Stunde</p>
			<p><input type="number" id="prodgefunden" name="prodgefunden" title="Rohstoffe auf Planet">Rohstoffe auf Planet</p>
			<p><input type="number" id="produhrzeit" name="produhrzeit" title="Uhrzeit">Uhrzeit</p>
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
