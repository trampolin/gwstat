<?php
	define("ROOT_DIR", "..");

	require_once(ROOT_DIR."/bin/database.php");

	$msg = isset($_POST['msg']) ? $_POST['msg'] : null;
	$pw = isset($_POST['password']) ? $_POST['password'] : null;
	$mode = isset($_POST['mode']) ? $_POST['mode'] : 'text';
	
	echo '<p>'.$mode.'-modus</p>';
	

	
	$spieler = '';
	
	// /Sonnensystem\s([0-9]+):([0-9]+)/
	
	if (($pw == 'supergeil') && ($msg != null)) 
	{
		$msg = str_replace('\\"','"',$msg);
		
		$returnValue = preg_match_all("/Sonnensystem\s([0-9]+):([0-9]+)/",$msg,$ausgabe);
		if ($returnValue > 0)
		{
			$seite = 'galaxie';
			$galaxy = $ausgabe[1][0];
			$system = $ausgabe[2][0];
			echo '<p>'.$seite.'-modus</p>';
		}
		else
		{
			$returnValue = preg_match_all('/Spieler (?:"|&quot;)([a-zA-Z0-9\.\-_]+)(?:"|&quot;)/',$msg,$ausgabe);
			if ($returnValue > 0)
			{
				// Spielername für alle Planeten
				$spieler = $ausgabe[1][0];
				$seite = 'playercard';
				echo '<p>'.$seite.'-modus</p>';
			}
			else
			{
				$seite = null;
				echo '<p>Seite nicht erkannt</p>';
			}
		}
		
		if ($seite == 'playercard')
		{
			if ($mode == 'text') 
			{
				$returnValue = preg_match_all("/([0-9]+):([0-9]+):([0-9]+)\s+([a-zA-Z0-9\-_\?\.\+äöü \*\+]+)/",$msg,$ausgabe);
			}
			else
			{
				$returnValue = preg_match_all("/<th><a href=.galaxie.php.to.[0-9]+:[0-9]+.>([0-9]+):([0-9]+):([0-9]+)<\/a><\/th>\s+<th>([a-zA-Z0-9\-_\?\.\+äöü \*\+]+)</",$msg,$ausgabe);
			}
			
			echo '<p>Anzahl der Einträge: '.$returnValue.'</p>';
			$db = new DatabaseConnection();
			
			foreach($ausgabe[0] as $i => $value)
			{
				if ($ausgabe[4][$i] != 'Allianz') {
					$q = "INSERT INTO planeten VALUES".
					"(".
						$ausgabe[1][$i].",".
						$ausgabe[2][$i].",".
						$ausgabe[3][$i].",".
						"'".$ausgabe[4][$i]."',".
						"'".$spieler."',".
						"NULL".
					")";
					
					$db->query($q);
				}
			}
		}
		else if ($seite == 'galaxie')
		{
			if ($mode == 'text')
			{
				$returnValue = preg_match_all("/([0-9]+)\s([a-zA-Z0-9\-_\. äöü\?\*\+]*)\s([a-zA-Z0-9\-_\.äöü\?\*\+]+)\s\[?([a-zA-Z0-9\-_\.äöü\?\*\+]+|\-)\]?\s[0-9]+/",$msg,$ausgabe);
			}
			else
			{
				$returnValue = preg_match_all('/>([0-9]+)<\/th>\s+<th>([a-zA-Z0-9\-_\. äöü\?\*\+]*)<\/th>\s+<th>\s+<a href=.playercard\.php.u=[a-zA-Z0-9\-_]+&p=[0-9]+:[0-9]+:[0-9]+:1">([a-zA-Z0-9\-_\.äöü\?\*\+]+)<\/a>/',$msg,$ausgabe);
			}
			echo '<p>Anzahl der Einträge: '.$returnValue.'</p>';
			$db = new DatabaseConnection();
			
			foreach($ausgabe[0] as $i => $value)
			{
				$q = "INSERT INTO planeten VALUES".
				"(".
					$galaxy.",".
					$system.",".
					$ausgabe[1][$i].",".
					"'".$ausgabe[2][$i]."',".
					"'".$ausgabe[3][$i]."',".
					"NULL".
				")";
				
				$db->query($q);
			}
		}
		else
		{
			echo '<p>Unbekannte Seite</p>';
		}
	}
?>

