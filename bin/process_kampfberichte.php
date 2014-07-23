<?php
	define("ROOT_DIR", "..");

	require_once(ROOT_DIR."/bin/database.php");

	$msg = isset($_POST['msg']) ? $_POST['msg'] : null;
	$pw = isset($_POST['password']) ? $_POST['password'] : null;
	$mode = isset($_POST['mode']) ? $_POST['mode'] : 'text';
	$kbid = isset($_POST['kbid']) ? $_POST['kbid'] : null;
	
	echo '<p>'.$mode.'-modus</p>';
	
	
	$spieler = '';
	
	// /Sonnensystem\s([0-9]+):([0-9]+)/
	
	if (($pw == 'supergeil') && ($msg != null)) 
	{
		
		if ($mode == 'text')
		{
			$returnValue = preg_match_all("/Datum\s([0-9\.\:\- ]{21,21})\s+Planet\s[0-9]+:[0-9]+:[0-9]+\s+Schiffe des Angreifers \(([0-9]+):([0-9]+):([0-9]+) \/ ([\S]*)(?: \[([\S ]+)\]|)\)\s+[\S\s]*Gesamt in CKK\s+([0-9\.]+)(?:,[0-9]+|)\s+([0-9\.]+)[\S\s]*Schiffe\/T.+rme des Verteidigers \(([0-9]+):([0-9]+):([0-9]+) \/ (?:([\S]+)|)(?: \[([\S ]+)\]|)\)[\S\s]*Gesamt in CKK\s+([0-9\.]+)(?:,[0-9]+|)\s+([0-9\.]+)[\S\s]*(?:Eisen\s([0-9\.]+)\s+Silizium\s([0-9\.]+)\s+Wasser\s([0-9\.]+)\s+Wasserstoff\s([0-9\.]+)\s|Informationen)/",$msg,$ausgabe);
		}
		else
		{
			$msg = str_replace('\\"','"',$msg);
			$msg = str_replace('\\\'','\'',$msg);
			$returnValue = preg_match_all("/>Datum<\/th><th>([0-9\.\:\- ]{21,21})<[\S\s]+Schiffe des Angreifers \(([0-9]+):([0-9]+):([0-9]+) \/ ([\S]*)(?: \[([\S ]+)\]|)\)[\S\s]*>Gesamt in CKK<\/th><th>([0-9\.]+)(?:,[0-9]+|)<\/th><th>([0-9\.]+)[\S\s]*Schiffe\/T.+rme des Verteidigers\s+ \(([0-9]+):([0-9]+):([0-9]+) \/ ([\S]*)(?: \[([\S ]+)\]|)\)[\S\s]*(?:>Gesamt in CKK<\/th><th>([0-9\.]+)(?:,[0-9]+|)<\/th><th>([0-9\.]+)|Keine Schiffe)[\S\s]*(?:>Eisen<\/th><th colspan=.2.>([0-9\.]+)<[\S\s]*>Silizium<\/th><th colspan=.2.>([0-9\.]+)<[\S\s]*>Wasser<\/th><th colspan=.2.>([0-9\.]+)<[\S\s]*>Wasserstoff<\/th><th colspan=.2.>([0-9\.]+)<|Informationen)/",$msg,$ausgabe);
		}
		echo '<p>Anzahl der Einträge: '.$returnValue.'</p>';
		$db = new DatabaseConnection();
		
		foreach($ausgabe[0] as $i => $value)
		{
			$date = substr($ausgabe[1][$i],6,4).'-'.substr($ausgabe[1][$i],3,2).'-'.substr($ausgabe[1][$i],0,2).' '.substr($ausgabe[1][$i],13,8);
		
			$q = "INSERT INTO `kampfberichte`(`kb_galaxie_att`, `kb_system_att`, `kb_planet_att`, `kb_galaxie_def`, `kb_system_def`, `kb_planet_def`, `kb_timestamp`, `kb_spieler_att`, `kb_spieler_def`, `kb_ckk_att`, `kb_ckk_att_lost`, `kb_ckk_def`, `kb_ckk_def_lost`, `kb_eisen`, `kb_silizium`, `kb_wasser`, `kb_wasserstoff`, `kb_id`) VALUES".
			"(".
				$ausgabe[2][$i].",".
				$ausgabe[3][$i].",".
				$ausgabe[4][$i].",".
				$ausgabe[9][$i].",".
				$ausgabe[10][$i].",".
				$ausgabe[11][$i].",".
				'"'.$date.'",'.
				'"'.$ausgabe[5][$i].'",'.
				'"'.$ausgabe[12][$i].'",'.
				
				str_replace(".", "", ($ausgabe[7][$i] == '' ? 0 : $ausgabe[7][$i])).",".
				str_replace(".", "", ($ausgabe[8][$i] == '' ? 0 : $ausgabe[8][$i])).",".
				str_replace(".", "", ($ausgabe[14][$i] == '' ? 0 : $ausgabe[14][$i])).",".
				str_replace(".", "", ($ausgabe[15][$i] == '' ? 0 : $ausgabe[15][$i])).",".

				str_replace(".", "", ($ausgabe[16][$i] == '' ? 0 : $ausgabe[16][$i])).",".
				str_replace(".", "", ($ausgabe[17][$i] == '' ? 0 : $ausgabe[17][$i])).",".
				str_replace(".", "", ($ausgabe[18][$i] == '' ? 0 : $ausgabe[18][$i])).",".
				str_replace(".", "", ($ausgabe[19][$i] == '' ? 0 : $ausgabe[19][$i])).",".
				($kbid == null ? 'null' : '"'.$kbid.'"').
			")";
			
			//echo '<p>'.$q.'</p>';
			
			$db->query($q);
		}
	}
	else
	{
		echo 'Fehler!';
	}
?>

