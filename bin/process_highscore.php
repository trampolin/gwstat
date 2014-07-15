<?php
	define("ROOT_DIR", "..");

	require_once(ROOT_DIR."/bin/database.php");

	$msg = isset($_POST['msg']) ? $_POST['msg'] : null;
	$pw = isset($_POST['password']) ? $_POST['password'] : null;
	$mode = isset($_POST['mode']) ? $_POST['mode'] : 'text';
	
	//
	
	if (($pw == 'supergeil') && ($msg != null)) {
	
		if ($mode == 'text') {
			$returnValue = preg_match_all("/([0-9]+)\s.+[\s]+()([a-zA-Z0-9\-_]+)\s*(\[[a-zA-Z0-9\-_\.]+\])?\s+([0-9\.]+)\s+([0-9\.]+)\s+([0-9\.]+)\s+([0-9]+)/",$msg,$ausgabe);
		}
		else
		{
			$msg = str_replace('\\"','"',$msg);
			$returnValue = preg_match_all('/<tr class="(?:\s*|\s+ally\s+|own\s+)">\s+<th>([0-9]+)\s+(?:<span class="[a-z]+"><small>&[a-z]+;[0-9]+<\/small><\/span>|&bull;)\s+<\/th>\s+<th>\s+<a href="playercard\.php\?u=([a-zA-Z0-9\-_\.]+)">([a-zA-Z0-9_\-\.]+)<\/a>\s+(?:&nbsp;\[<a href="allianzen\.php\?ally=[a-zA-Z0-9\-_\.]+">([a-zA-Z0-9\-_\.]+)<\/a>\])?<\/th>\s+<th>([0-9\.]+)<\/th>\s+<th>([0-9\.]+)<\/th>\s+<th>([0-9\.]+)<\/th>\s+<th>([0-9\.]+)<\/th>/',$msg,$ausgabe);
		}
		
		///// 
		
		echo '<p>Anzahl der Einträge: '.$returnValue.'</p>';
		$db = new DatabaseConnection();
		
		foreach($ausgabe[0] as $i => $value)
		{
			//$date = substr($ausgabe[1][$i],6,4).'-'.substr($ausgabe[1][$i],3,2).'-'.substr($ausgabe[1][$i],0,2).' '.$ausgabe[2][$i];
		
			$q = "INSERT INTO highscore(hs_platz,hs_playercard,hs_name,hs_allianz,hs_planetenpunkte,hs_forschungspunkte,hs_punkte,hs_planeten) VALUES".
			"(".
				$ausgabe[1][$i].",".
				"'".$ausgabe[2][$i]."',".
				"'".$ausgabe[3][$i]."',".
				"'".$ausgabe[4][$i]."',".
				str_replace(".", "", $ausgabe[5][$i]).",".
				str_replace(".", "", $ausgabe[6][$i]).",".
				str_replace(".", "", $ausgabe[7][$i]).",".
				$ausgabe[8][$i].
			")";
			
			//echo '<p>'.$q.'</p>';
			
			$db->query($q);
		}
	}
	else
	{
		echo 'Fehler!';
	}
	//
	
	
	// REGEX für die Planeten auf der Playercard:
	// /<th><a href=.galaxie.php.to.[0-9]+:[0-9]+.>([0-9]+):([0-9]+):([0-9]+)<\/a><\/th>\s+<th>([a-zA-Z\-\._]+)</
	
	
///([0-9]+\.[0-9]+\.20[0-9]+).-.([0-9]+:[0-9]+:[0-9]+).(([0-9]+):([0-9]+):([0-9]+)).Eine.Ihrer.Flotten.ist.von.(([0-9]+):([0-9]+):([0-9]+)).zurückgekehrt.mit.folgenden.Rohstoffen:.([0-9\.]+).Eisen,.([0-9\.]+).Silizium,.([0-9\.]+).Wasser.und.([0-9\.]+).Wasserstoff/six
?>

