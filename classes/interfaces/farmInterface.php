<?php//require_once(ROOT_DIR."/classes/entities/band.php");class FarmInterface extends BasicInterface {		public function __construct($db = null) {		parent::__construct($db);	}		public function getFarmData($data)	{		$q = "SELECT fb_timestamp, fb_eisen,  fb_silizium, fb_wasser , fb_wasserstoff  FROM farmberichte where fb_galaxie = ".$data->galaxy." AND fb_system =  ".$data->system."  and fb_planet =  ".$data->planet."  ORDER BY 1 desc";				$result=$this->db->query($q);						$html = '';		if (isset($data->highscore) && $data->highscore)		{			$pi = new PlanetInterface();			$player = $pi->getPlayerByPlanet($data);						$hi = new HighscoreInterface();			$hs = $hi->getCompleteHighscore($player->data);			$html .= $hs->data->html;		}		$resultData = new stdClass;		$farmdata = new StdClass;		$farmdata->eisen = array();		$farmdata->silizium = array();		$farmdata->wasser = array();		$farmdata->wasserstoff = array();				if ($this->db->get_last_num_rows() > 0)		{ 			$html .= '<div id="farmverlauf"></div>';					while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 			{				$eisen = array();				$eisen[] = $row['fb_timestamp'];				$eisen[] = $row['fb_eisen'];				$farmdata->eisen[] = $eisen;								$silizium = array();				$silizium[] = $row['fb_timestamp'];				$silizium[] = $row['fb_silizium'];				$farmdata->silizium[] = $silizium;								$wasser = array();				$wasser[] = $row['fb_timestamp'];				$wasser[] = $row['fb_wasser'];				$farmdata->wasser[] = $wasser;								$wasserstoff = array();				$wasserstoff[] = $row['fb_timestamp'];				$wasserstoff[] = $row['fb_wasserstoff'];				$farmdata->wasserstoff[] = $wasserstoff;			}						$resultData->farmdata = $farmdata;		}		else		{			'<p>Keine Farmdaten</p>';		}		$html .= '</table>';				$resultData->html = $html;		$resultData->title = $data->galaxy.":".$data->system.":".$data->planet;				return new DataResponse(ResultTypes::resultOK,"getFarmData",$resultData);	}		public function getCompleteFarmPerDay($data)	{		$q = "SELECT Date(fb_timestamp) as datum, sum(1) as anzahl,sum(fb_eisen) as eisen,sum(fb_silizium) as silizium,sum(fb_wasser) as wasser,sum(fb_wasserstoff) as wasserstoff FROM farmberichte where fb_clearing = 0 group by Date(fb_timestamp)";				$result=$this->db->query($q);				$bla = 0;				$html = '<table class="auswertung"><th>Datum</th><th>Anzahl</th><th>Eisen</th><th>Silizium</th><th>Wasser</th><th>Wasserstoff</th></tr>';				if ($this->db->get_last_num_rows() > 0)		{ 			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 			{				$bla++;								$html .= '<tr>';								foreach($row as $key => $value)				{					$html .= '<td>'.$value.'</td>';				}				$html .= '</tr>';									if ($bla%30==29) 				{					$html .= '<tr>'.					'		<th>Datum</th>'.					'		<th>Anzahl</th>'.					'		<th>Eisen</th>'.					'		<th>Silizium</th>'.					'		<th>Wasser.</th>'.					'		<th>Wasserstoff.</th>'.					'	</tr>';				}			}		}
		else
		{
			$html .= '<tr><td colspan="6">Nicht genug Daten gesammelt!</td></tr>';
		}		$html .= '</table>';				$resultData = new stdClass;		$resultData->html = $html;				return new DataResponse(ResultTypes::resultOK,"getCompleteFarmPerDay",$resultData);	}
	
	public function getCompleteFarmPerOwnPlanet($data)	{		$q = "SELECT CONCAT(  `fb_galaxie_from` ,  ':',  `fb_system_from` ,  ':',  `fb_planet_from` ) AS Planet, SUM( 1 ) AS anzahl, SUM( fb_eisen ) AS eisen, SUM( fb_silizium ) AS silizium, SUM( fb_wasser ) AS wasser, SUM( fb_wasserstoff ) AS wasserstoff FROM farmberichte where fb_clearing = 0 GROUP BY 1  ORDER BY  `fb_galaxie_from` ,  `fb_system_from` ,  `fb_planet_from`";				$result=$this->db->query($q);				$bla = 0;				$html = '<table class="auswertung"><th>Planet</th><th>Anzahl</th><th>Eisen</th><th>Silizium</th><th>Wasser</th><th>Wasserstoff</th></tr>';				if ($this->db->get_last_num_rows() > 0)		{ 			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 			{				$bla++;								$html .= '<tr>';								foreach($row as $key => $value)				{					if ($key=='Planet') {						$html .= '<td><a href="http://uni1.gigrawars.de/playercard.php?p='.$value.':1">'.$value.'</a></td>';					}					else {						$html .= '<td>'.$value.'</td>';					}				}				$html .= '</tr>';									if ($bla%30==29) 				{					$html .= '<tr>'.					'		<th>Planet</th>'.					'		<th>Anzahl</th>'.					'		<th>Eisen</th>'.					'		<th>Silizium</th>'.					'		<th>Wasser.</th>'.					'		<th>Wasserstoff.</th>'.					'	</tr>';				}			}		}		else		{			$html .= '<tr><td colspan="6">Nicht genug Daten gesammelt!</td></tr>';		}		$html .= '</table>';				$resultData = new stdClass;		$resultData->html = $html;				return new DataResponse(ResultTypes::resultOK,"getCompleteFarmPerOwnPlanet",$resultData);	}		public function getCompletePerFarm($data)	{			$where = " ";		if (isset($data->favoriten)) 		{			$where = " and sp_favorit=1 ";		}		else		{			if (isset($data->galaxy) && ($data->galaxy != ""))			{				$where .= " and fb_galaxie = ".$data->galaxy." ";			}			if (isset($data->system) && ($data->system != ""))			{				$where .= " and fb_system = ".$data->system." ";			}		}			$q = "SELECT CONCAT(  `fb_galaxie` ,  ':',  `fb_system` ,  ':',  `fb_planet` ) AS Farm, pl_spieler, sp_allianz, sp_favorit, SUM( 1 ) AS anzahl, SUM( fb_eisen ) AS eisen, SUM( fb_silizium ) AS silizium, SUM( fb_wasser ) AS wasser, SUM( fb_wasserstoff ) AS wasserstoff FROM farmberichte LEFT OUTER JOIN planeten on fb_galaxie = pl_galaxie AND fb_system = pl_system and fb_planet = pl_planet LEFT JOIN spieler on pl_spieler = sp_name where fb_clearing = 0".$where."GROUP BY 1  ORDER BY  `fb_galaxie` ,  `fb_system` ,  `fb_planet`";				$result=$this->db->query($q);				$bla = 0;				$html = '<table class="auswertung"><th>Farm</th><th>Spieler</th><th>Allianz</th><th>Anzahl</th><th>Eisen</th><th>Silizium</th><th>Wasser</th><th>Wasserstoff</th></tr>';				if ($this->db->get_last_num_rows() > 0)		{ 			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 			{				$bla++;								$html .= '<tr>';								foreach($row as $key => $value)				{					preg_match("/([0-9]+):([0-9]+):([0-9]+)/",$row['Farm'],$planet);					if ($key=='Farm') {						$html .= '<td><a href="http://uni1.gigrawars.de/galaxie.php?to='.$value.':1">'.$value.'</a>';						$html .= '<div title="Details: '.$row['Farm'].'" class="details icon" onclick="ajaxMessageBox(\'FarmInterface\',\'getFarmData\',{ galaxy:'.$planet[1].',system:'.$planet[2].',planet:'.$planet[3].', highscore: true })"></div></td>';					}					else if ($key=='pl_spieler') {						$html .= '<td><a href="http://uni1.gigrawars.de/playercard.php?p='.$row['Farm'].':1">'.(($value != '' && $value != null) ? $value : '-' ).'</a>';						if ($row['pl_spieler'] != '' && $row['Farm'] != null) 						{							$html .= '<div title="Alle Planeten: '.$row['pl_spieler'].'" class="planet icon" onclick="ajaxMessageBox(\'PlanetInterface\',\'getPlanetByPlayer\',{ player:\''.$row['pl_spieler'].'\', highscore: true})"></div>';							$html .= '<div title="Highscoreverlauf: '.$row['pl_spieler'].'" class="highscorev icon" onclick="ajaxMessageBox(\'HighscoreInterface\',\'getHighscoreHistory\',{ player:\''.$row['pl_spieler'].'\', highscore: true })"></div>';							$html .= '<div title="'.($row['sp_favorit'] != null && $row['sp_favorit'] != 0 ? 'Von Favoriten entfernen' : 'Zu Favoriten hinzufügen').': '.$row['pl_spieler'].'" class="'.$row['pl_spieler'].'_favorit '.($row['sp_favorit'] != null && $row['sp_favorit'] != 0 ? 'removefavorit' : 'addfavorit').' icon" onclick="requestToggleHighscore(\''.$row['pl_spieler'].'_favorit\',{player:\''.$row['pl_spieler'].'\'})"></div>';													}						$html .= '</td>';					}					else if ($key=='sp_allianz')					{						if ($value != '')						{							$html .= '<td>'.$value.'<div title="Allianz: '.$row['sp_allianz'].'" class="ally icon" onclick="ajaxMessageBox(\'HighscoreInterface\',\'getAllyDetails\',{ ally:\''.$row['sp_allianz'].'\', highscore: true })"></div></td>';						}						else						{							$html .= '<td>'.$value.'</td>';						}					}					else if ($key!='sp_favorit')					{						$html .= '<td>'.$value.'</td>';					}				}								$html.='</tr>';								if ($bla%30==29) 				{					$html .= '<tr>'.					'		<th>Farm</th>'.					'		<th>Spieler</th><th>Allianz</th>'.					'		<th>Anzahl</th>'.					'		<th>Eisen</th>'.					'		<th>Silizium</th>'.					'		<th>Wasser</th>'.					'		<th>Wasserstoff</th>'.					'	</tr>';				}			}		}		else		{			$html .= '<tr><td colspan="8">Nicht genug Daten gesammelt!</td></tr>';		}		$html .= '</table>';				$resultData = new stdClass;		$resultData->html = $html;				return new DataResponse(ResultTypes::resultOK,"getCompletePerFarm",$resultData);	}		public function getAveragePerFarm($data)	{			$where = " ";		if (isset($data->favoriten)) 		{			$where = " and sp_favorit=1 ";		}		else		{			if (isset($data->galaxy) && ($data->galaxy != ""))			{				$where .= " and fb_galaxie = ".$data->galaxy." ";			}			if (isset($data->system) && ($data->system != ""))			{				$where .= " and fb_system = ".$data->system." ";			}		}			$q = "SELECT CONCAT(fb_galaxie,':',fb_system,':',fb_planet) AS Farm, pl_spieler, sp_allianz, sp_favorit, anzahl, eisen, silizium, wasser, wasserstoff FROM avgfarmview LEFT OUTER JOIN spieler on pl_spieler = sp_name where 1=1".$where."ORDER BY 4 desc,5 desc,7 desc,6 desc";				$result=$this->db->query($q);				$bla = 0;				$html = '<table class="auswertung"><th>Farm</th><th>Spieler</th><th>Allianz</th><th>Anzahl</th><th>Eisen</th><th>Silizium</th><th>Wasser</th><th>Wasserstoff</th></tr>';				if ($this->db->get_last_num_rows() > 0)		{ 			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 			{				$bla++;								$html .= '<tr>';								foreach($row as $key => $value)				{					preg_match("/([0-9]+):([0-9]+):([0-9]+)/",$row['Farm'],$planet);					if ($key=='Farm') {						$html .= '<td><a href="http://uni1.gigrawars.de/galaxie.php?to='.$value.':1">'.$value.'</a>';						$html .= '<div title="Details: '.$row['Farm'].'" class="details icon" onclick="ajaxMessageBox(\'FarmInterface\',\'getFarmData\',{ galaxy:'.$planet[1].',system:'.$planet[2].',planet:'.$planet[3].', highscore: true })"></div></td>';					}					else if ($key=='pl_spieler') {						$html .= '<td><a href="http://uni1.gigrawars.de/playercard.php?p='.$row['Farm'].':1">'.(($value != '' && $value != null) ? $value : '-' ).'</a>';						if ($row['pl_spieler'] != '' && $row['Farm'] != null) 						{							$html .= '<div title="Alle Planeten: '.$row['pl_spieler'].'" class="planet icon" onclick="ajaxMessageBox(\'PlanetInterface\',\'getPlanetByPlayer\',{ player:\''.$row['pl_spieler'].'\', highscore: true })"></div>';							$html .= '<div title="Highscoreverlauf: '.$row['pl_spieler'].'" class="highscorev icon" onclick="ajaxMessageBox(\'HighscoreInterface\',\'getHighscoreHistory\',{ player:\''.$row['pl_spieler'].'\', highscore: true })"></div>';							$html .= '<div title="'.($row['sp_favorit'] != null && $row['sp_favorit'] != 0 ? 'Von Favoriten entfernen' : 'Zu Favoriten hinzufügen').': '.$row['pl_spieler'].'" class="'.$row['pl_spieler'].'_favorit '.($row['sp_favorit'] != null && $row['sp_favorit'] != 0 ? 'removefavorit' : 'addfavorit').' icon" onclick="requestToggleHighscore(\''.$row['pl_spieler'].'_favorit\',{player:\''.$row['pl_spieler'].'\'})"></div>';						}						$html .= '</td>';					}					else if ($key=='sp_allianz')					{						if ($value != '')						{							$html .= '<td>'.$value.'<div title="Allianz: '.$row['sp_allianz'].'" class="ally icon" onclick="ajaxMessageBox(\'HighscoreInterface\',\'getAllyDetails\',{ ally:\''.$row['sp_allianz'].'\', highscore: true })"></div></td>';						}						else						{							$html .= '<td>'.$value.'</td>';						}					}					else if ($key!='sp_favorit')					{						$html .= '<td>'.$value.'</td>';					}				}				$html .= '</tr>';									if ($bla%30==29) 				{					$html .= '<tr>'.					'		<th>Farm</th>'.					'		<th>Spieler</th><th>Allianz</th>'.					'		<th>Anzahl</th>'.					'		<th>Eisen</th>'.					'		<th>Silizium</th>'.					'		<th>Wasser.</th>'.					'		<th>Wasserstoff.</th>'.					'	</tr>';				}			}		}		else		{			$html .= '<tr><td colspan="8">Nicht genug Daten gesammelt!</td></tr>';		}		$html .= '</table>';				$resultData = new stdClass;		$resultData->html = $html;				return new DataResponse(ResultTypes::resultOK,"getAveragePerFarm",$resultData);	}	}FarmInterface::registerInterface();?>