<?php
	require_once("database.php");

	$msg = isset($_POST['msg']) ? $_POST['msg'] : null;
	$pw = isset($_POST['password']) ? $_POST['password'] : null;
	
	if (($pw == 'supergeil') && ($msg != null)) {
		
		preg_match_all("/([0-9\.]+).(Eisen|Silizium|Wasserstoff|Wasser)/x", $msg, $ausgabe);
		
		$res = array('Eisen','Silizium','Wasser','Wasserstoff');
		$farm = array(0,0,0,0)
			;
		
		$i = 0;
		foreach ($ausgabe[1] as $unterkey => $untervalue) {
			//echo '<p>'.$untervalue.'</p>';
			$value = str_replace(".", "", $untervalue);
			$value = str_replace(" ", "", $value);
			$farm[$i%4] += $value;
			$i++;
		}
		
		foreach ($farm as $key => $betrag) {
			$val = number_format($betrag,0,',','.');
			echo '<p>'.$res[$key].': '.$val;
		}
		
		$returnValue = preg_match_all("/([0-9]+\.[0-9]+\.20[0-9]+).-.([0-9]+:[0-9]+:[0-9]+).([0-9]+):([0-9]+):([0-9]+)\sEine Ihrer Flotten ist von ([0-9]+):([0-9]+):([0-9]+) zur.ckgekehrt mit folgenden Rohstoffen:[\s]+([0-9\.]+) Eisen, ([0-9\.]+) Silizium, ([0-9\.]+) Wasser und ([0-9\.]+) Wasserstoff/",$msg,$ausgabe);
		
		echo '<p>Anzahl der Berichte:'.$returnValue.'</p>';
		$db = new DatabaseConnection();
		
		foreach($ausgabe[0] as $i => $value)
		{
			$date = substr($ausgabe[1][$i],6,4).'-'.substr($ausgabe[1][$i],3,2).'-'.substr($ausgabe[1][$i],0,2).' '.$ausgabe[2][$i];
		
			//echo '<p>'.$date.'</p>';
			$q = "INSERT INTO farmberichte VALUES".
			"(".
				$ausgabe[6][$i].",".
				$ausgabe[7][$i].",".
				$ausgabe[8][$i].",".
				"'".$date."',".//$ausgabe[0][$i].",".
				str_replace(".", "", $ausgabe[9][$i]).",".
				str_replace(".", "", $ausgabe[10][$i]).",".
				str_replace(".", "", $ausgabe[11][$i]).",".
				str_replace(".", "", $ausgabe[12][$i]).",".
				$ausgabe[3][$i].",".
				$ausgabe[4][$i].",".
				$ausgabe[5][$i].",".
				'NULL'.
			")";
			
			$db->query($q);
		}
	}
	else
	{
		echo 'Fehler!';
	}
	//
	
	
	
///([0-9]+\.[0-9]+\.20[0-9]+).-.([0-9]+:[0-9]+:[0-9]+).(([0-9]+):([0-9]+):([0-9]+)).Eine.Ihrer.Flotten.ist.von.(([0-9]+):([0-9]+):([0-9]+)).zurückgekehrt.mit.folgenden.Rohstoffen:.([0-9\.]+).Eisen,.([0-9\.]+).Silizium,.([0-9\.]+).Wasser.und.([0-9\.]+).Wasserstoff/six
?>

