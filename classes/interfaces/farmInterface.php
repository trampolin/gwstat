<?php//require_once(ROOT_DIR."/classes/entities/band.php");class FarmInterface extends BasicInterface {		public function __construct($db = null) {		parent::__construct($db);	}		public function getFarmData($data)	{		$q = "SELECT fb_timestamp, fb_eisen,  fb_silizium, fb_wasser , fb_wasserstoff  FROM farmberichte where fb_galaxie = ".$data->galaxy." AND fb_system =  ".$data->system."  and fb_planet =  ".$data->planet."  ORDER BY 1 desc";				$result=$this->db->query($q);				$bla = 0;						$html = '';		if (isset($data->highscore) && $data->highscore)		{			$pi = new PlanetInterface();			$player = $pi->getPlayerByPlanet($data);						$hi = new HighscoreInterface();			$hs = $hi->getCompleteHighscore($player->data);			$html .= $hs->data->html;		}				$html .= '<table class="auswertung"><th>Datum</th><th>Eisen</th><th>Silizium</th><th>Wasser</th><th>Wasserstoff</th></tr>';				if ($this->db->get_last_num_rows() > 0)		{ 			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 			{				$bla++;								$html .= '<tr>';								foreach($row as $key => $value)				{					$html .= '<td>'.$value.'</td>';				}				$html .= '</tr>';									if ($bla%30==29) 				{					$html .= '<tr>'.					'		<th>Datum</th>'.					'		<th>Eisen</th>'.					'		<th>Silizium</th>'.					'		<th>Wasser.</th>'.					'		<th>Wasserstoff.</th>'.					'	</tr>';				}			}		}		else		{			$html .= '<tr><td colspan="5">Nicht genug Daten gesammelt!</td></tr>';		}		$html .= '</table>';				$resultData = new stdClass;		$resultData->html = $html;		$resultData->title = $data->galaxy.":".$data->system.":".$data->planet;				return new DataResponse(ResultTypes::resultOK,"getCompleteFarmPerDay",$resultData);	}		public function getCompleteFarmPerDay($data)	{		$q = "SELECT Date(fb_timestamp) as datum, sum(1) as anzahl,sum(fb_eisen) as eisen,sum(fb_silizium) as silizium,sum(fb_wasser) as wasser,sum(fb_wasserstoff) as wasserstoff FROM farmberichte where fb_clearing = 0 group by Date(fb_timestamp)";				$result=$this->db->query($q);				$bla = 0;				$html = '<table class="auswertung"><th>Datum</th><th>Anzahl</th><th>Eisen</th><th>Silizium</th><th>Wasser</th><th>Wasserstoff</th></tr>';				if ($this->db->get_last_num_rows() > 0)		{ 			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 			{				$bla++;								$html .= '<tr>';								foreach($row as $key => $value)				{					$html .= '<td>'.$value.'</td>';				}				$html .= '</tr>';									if ($bla%30==29) 				{					$html .= '<tr>'.					'		<th>Datum</th>'.					'		<th>Anzahl</th>'.					'		<th>Eisen</th>'.					'		<th>Silizium</th>'.					'		<th>Wasser.</th>'.					'		<th>Wasserstoff.</th>'.					'	</tr>';				}			}		}
		else
		{
			$html .= '<tr><td colspan="6">Nicht genug Daten gesammelt!</td></tr>';
		}		$html .= '</table>';				$resultData = new stdClass;		$resultData->html = $html;				return new DataResponse(ResultTypes::resultOK,"getCompleteFarmPerDay",$resultData);	}
	
	public function getCompleteFarmPerOwnPlanet($data)	{		$q = "SELECT CONCAT(  `fb_galaxie_from` ,  ':',  `fb_system_from` ,  ':',  `fb_planet_from` ) AS Planet, SUM( 1 ) AS anzahl, SUM( fb_eisen ) AS eisen, SUM( fb_silizium ) AS silizium, SUM( fb_wasser ) AS wasser, SUM( fb_wasserstoff ) AS wasserstoff FROM farmberichte where fb_clearing = 0 GROUP BY 1  ORDER BY  `fb_galaxie_from` ,  `fb_system_from` ,  `fb_planet_from`";				$result=$this->db->query($q);				$bla = 0;				$html = '<table class="auswertung"><th>Planet</th><th>Anzahl</th><th>Eisen</th><th>Silizium</th><th>Wasser</th><th>Wasserstoff</th></tr>';				if ($this->db->get_last_num_rows() > 0)		{ 			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 			{				$bla++;								$html .= '<tr>';								foreach($row as $key => $value)				{					if ($key=='Planet') {						$html .= '<td><a href="http://uni1.gigrawars.de/playercard.php?p='.$value.':1">'.$value.'</a></td>';					}					else {						$html .= '<td>'.$value.'</td>';					}				}				$html .= '</tr>';									if ($bla%30==29) 				{					$html .= '<tr>'.					'		<th>Planet</th>'.					'		<th>Anzahl</th>'.					'		<th>Eisen</th>'.					'		<th>Silizium</th>'.					'		<th>Wasser.</th>'.					'		<th>Wasserstoff.</th>'.					'	</tr>';				}			}		}		else		{			$html .= '<tr><td colspan="6">Nicht genug Daten gesammelt!</td></tr>';		}		$html .= '</table>';				$resultData = new stdClass;		$resultData->html = $html;				return new DataResponse(ResultTypes::resultOK,"getCompleteFarmPerOwnPlanet",$resultData);	}		public function getCompletePerFarm($data)	{		$q = "SELECT CONCAT(  `fb_galaxie` ,  ':',  `fb_system` ,  ':',  `fb_planet` ) AS Farm, pl_spieler, SUM( 1 ) AS anzahl, SUM( fb_eisen ) AS eisen, SUM( fb_silizium ) AS silizium, SUM( fb_wasser ) AS wasser, SUM( fb_wasserstoff ) AS wasserstoff FROM farmberichte LEFT OUTER JOIN planeten on fb_galaxie = pl_galaxie AND fb_system = pl_system and fb_planet = pl_planet where fb_clearing = 0 GROUP BY 1  ORDER BY  `fb_galaxie` ,  `fb_system` ,  `fb_planet`";				$result=$this->db->query($q);				$bla = 0;				$html = '<table class="auswertung"><th>Farm</th><th>Spieler</th><th>Anzahl</th><th>Eisen</th><th>Silizium</th><th>Wasser</th><th>Wasserstoff</th></tr>';				if ($this->db->get_last_num_rows() > 0)		{ 			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 			{				$bla++;								$html .= '<tr>';								foreach($row as $key => $value)				{					preg_match("/([0-9]+):([0-9]+):([0-9]+)/",$row['Farm'],$planet);					if ($key=='Farm') {						$html .= '<td><a href="http://uni1.gigrawars.de/galaxie.php?to='.$value.':1">'.$value.'</a>';						$html .= '<div title="Details: '.$row['Farm'].'" class="details icon" onclick="ajaxMessageBox(\'FarmInterface\',\'getFarmData\',{ galaxy:'.$planet[1].',system:'.$planet[2].',planet:'.$planet[3].', highscore: true })"></div></td>';					}					else if ($key=='pl_spieler') {						$html .= '<td><a href="http://uni1.gigrawars.de/playercard.php?p='.$row['Farm'].':1">'.(($value != '' && $value != null) ? $value : '-' ).'</a>';						if ($row['pl_spieler'] != '' && $row['Farm'] != null) 						{							$html .= '<div title="Alle Planeten: '.$row['pl_spieler'].'" class="planet icon" onclick="ajaxMessageBox(\'PlanetInterface\',\'getPlanetByPlayer\',{ player:\''.$row['pl_spieler'].'\', highscore: true})"></div>';						}						$html .= '</td>';					}					else {						$html .= '<td>'.$value.'</td>';					}				}								$html.='</tr>';								if ($bla%30==29) 				{					$html .= '<tr>'.					'		<th>Farm</th>'.					'		<th>Spieler</th>'.					'		<th>Anzahl</th>'.					'		<th>Eisen</th>'.					'		<th>Silizium</th>'.					'		<th>Wasser</th>'.					'		<th>Wasserstoff</th>'.					'	</tr>';				}			}		}		else		{			$html .= '<tr><td colspan="7">Nicht genug Daten gesammelt!</td></tr>';		}		$html .= '</table>';				$resultData = new stdClass;		$resultData->html = $html;				return new DataResponse(ResultTypes::resultOK,"getCompletePerFarm",$resultData);	}		public function getAveragePerFarm($data)	{		$q = "SELECT CONCAT(  `fb_galaxie` ,  ':',  `fb_system` ,  ':',  `fb_planet` ) AS Farm, pl_spieler, SUM( 1 ) AS anzahl, ROUND(AVG( fb_eisen )) AS eisen, ROUND(AVG( fb_silizium )) AS silizium, ROUND(AVG( fb_wasser )) AS wasser, ROUND(AVG( fb_wasserstoff )) AS wasserstoff FROM farmberichte LEFT OUTER JOIN planeten on fb_galaxie = pl_galaxie AND fb_system = pl_system and fb_planet = pl_planet where fb_clearing = 0 GROUP BY 1  ORDER BY  4 desc,5 desc,7 desc,6 desc";				$result=$this->db->query($q);				$bla = 0;				$html = '<table class="auswertung"><th>Farm</th><th>Spieler</th><th>Anzahl</th><th>Eisen</th><th>Silizium</th><th>Wasser</th><th>Wasserstoff</th></tr>';				if ($this->db->get_last_num_rows() > 0)		{ 			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 			{				$bla++;								$html .= '<tr>';								foreach($row as $key => $value)				{					preg_match("/([0-9]+):([0-9]+):([0-9]+)/",$row['Farm'],$planet);					if ($key=='Farm') {						$html .= '<td><a href="http://uni1.gigrawars.de/galaxie.php?to='.$value.':1">'.$value.'</a>';						$html .= '<div title="Details: '.$row['Farm'].'" class="details icon" onclick="ajaxMessageBox(\'FarmInterface\',\'getFarmData\',{ galaxy:'.$planet[1].',system:'.$planet[2].',planet:'.$planet[3].', highscore: true })"></div></td>';					}					else if ($key=='pl_spieler') {						$html .= '<td><a href="http://uni1.gigrawars.de/playercard.php?p='.$row['Farm'].':1">'.(($value != '' && $value != null) ? $value : '-' ).'</a>';						if ($row['pl_spieler'] != '' && $row['Farm'] != null) 						{							$html .= '<div title="Alle Planeten: '.$row['pl_spieler'].'" class="planet icon" onclick="ajaxMessageBox(\'PlanetInterface\',\'getPlanetByPlayer\',{ player:\''.$row['pl_spieler'].'\', highscore: true })"></div>';						}						$html .= '</td>';					}					else {						$html .= '<td>'.$value.'</td>';					}				}				$html .= '</tr>';									if ($bla%30==29) 				{					$html .= '<tr>'.					'		<th>Farm</th>'.					'		<th>Spieler</th>'.					'		<th>Anzahl</th>'.					'		<th>Eisen</th>'.					'		<th>Silizium</th>'.					'		<th>Wasser.</th>'.					'		<th>Wasserstoff.</th>'.					'	</tr>';				}			}		}		else		{			$html .= '<tr><td colspan="6">Nicht genug Daten gesammelt!</td></tr>';		}		$html .= '</table>';				$resultData = new stdClass;		$resultData->html = $html;				return new DataResponse(ResultTypes::resultOK,"getAveragePerFarm",$resultData);	}	}FarmInterface::registerInterface();?>