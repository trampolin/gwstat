<?php

if (isset($login)) {
	if ($login->isUserLoggedIn() == true) {
	toolsMenu();
		?>
		
		<div class="contentitem round">
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
