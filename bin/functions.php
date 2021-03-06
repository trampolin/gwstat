<?php

function regExSpielerName() {
	return "[\S]{1,50}";
}

function regExAllyName() {
	return "[\S ]{1,50}";
}

function kampfMenu() {
?>
	<div class="contentitem round" id="submenu">
		<h3><a href="?action=kampfberichte">Kampfbericht eintragen</a> | <a href="?action=kampfberichte_auswertung">Auswertung</a></h3>
	</div>
<?php
}

function farmMenu() {
?>
	<div class="contentitem round" id="submenu">
		<h3><a href="?action=farmen">Farmen eintragen</a> | <a href="?action=farmen_auswertung">Auswertung</a></h3>
	</div>
<?php
}

function highscoreMenu() {
?>
	<div class="contentitem round" id="submenu">
		<h3><a href="?action=highscore">Highscore eintragen</a> | <a href="?action=highscore_auswertung">Auswertung</a></h3>
	</div>
<?php
}

function planetenMenu() {
?>
	<div class="contentitem round" id="submenu">
		<h3><a href="?action=planeten">Planeten eintragen</a> | <a href="?action=planeten_auswertung">Auswertung</a></h3>
	</div>
<?php
}

function toolsMenu() {
?>
	<div class="contentitem round" id="submenu">
		<h3><a href="?action=tools">Tools</a></h3>
	</div>
<?php
}

function messageBoxContainer() {
?>
	<div class="contentitem round hidden" id="messageboxcontainer"></div>
<?php
}

?>