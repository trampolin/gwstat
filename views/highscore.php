<?php
highscoreMenu();
?>
<div class="contentitem round" id="highscore_form">
<form name="farmen" action="" method="post">

	<p>Text von der Highscoreliste <b>!BETA!</b></p>
	<p><textarea name="msg" id="msg_highscore" rows="20" cols="100"></textarea></p>
	<p><input type="submit" name="send" class="button" id="submit_highscore" value="Highscore auswerten"></p>

 </form>
 </div>
 <div class="contentitem round" id="highscoreergebnis">
 <p>Ergebnis:</p>
 </div>
<?php
// /([0-9]+)\s.+[\s]+([a-zA-Z0-9\-_]+)\s*(\[[a-zA-Z0-9\-_\.]+\])?\s+([0-9\.]+)\s+([0-9\.]+)\s+([0-9\.]+)\s+([0-9]+)/
?>