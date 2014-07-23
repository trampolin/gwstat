<?php//require_once(ROOT_DIR."/classes/entities/band.php");class KampfberichtInterface extends BasicInterface {		public function __construct($db = null) {		parent::__construct($db);	}		public function getCompleteFarmPerDay($data)	{		$q = "SELECT Date(kb_timestamp) as datum, sum(1) as anzahl,sum(kb_eisen) as eisen,sum(kb_silizium) as silizium,sum(kb_wasser) as wasser,sum(kb_wasserstoff) as wasserstoff FROM kampfberichte group by Date(kb_timestamp)";				$result=$this->db->query($q);				$bla = 0;				$html = '<table class="auswertung"><th>Datum</th><th>Anzahl</th><th>Eisen</th><th>Silizium</th><th>Wasser</th><th>Wasserstoff</th></tr>';				if ($this->db->get_last_num_rows() > 0)		{ 			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 			{				$bla++;								$html .= '<tr>';								foreach($row as $key => $value)				{					$html .= '<td>'.$value.'</td>';				}				$html .= '</tr>';									if ($bla%30==29) 				{					$html .= '<tr>'.					'		<th>Datum</th>'.					'		<th>Anzahl</th>'.					'		<th>Eisen</th>'.					'		<th>Silizium</th>'.					'		<th>Wasser.</th>'.					'		<th>Wasserstoff.</th>'.					'	</tr>';				}			}		}		else		{			$html .= '<tr><td colspan="6">Nicht genug Daten gesammelt!</td></tr>';		}		$html .= '</table>';				$resultData = new stdClass;		$resultData->html = $html;				return new DataResponse(ResultTypes::resultOK,"getCompleteFarmPerDay",$resultData);	}				public function getAllKampfberichte($data)	{			$where = " ";		if (isset($data->galaxy) && ($data->galaxy != ""))		{			$where .= " and fb_galaxie = ".$data->galaxy." ";		}		if (isset($data->system) && ($data->system != ""))		{			$where .= " and fb_system = ".$data->system." ";		}			//$q = "SELECT CONCAT(  `kb_galaxie_def` ,  ':',  `kb_system_def` ,  ':',  `kb_planet_def` ) AS Farm, pl_spieler, SUM( 1 ) AS anzahl, SUM( kb_eisen ) AS eisen, SUM( kb_silizium ) AS silizium, SUM( kb_wasser ) AS wasser, SUM( kb_wasserstoff ) AS wasserstoff FROM kampfberichte LEFT OUTER JOIN planeten on kb_galaxie_def = pl_galaxie AND kb_system_def = pl_system and kb_planet_def = pl_planet where 1=1".$where."GROUP BY 1  ORDER BY  `kb_galaxie_def` ,  `kb_system_def` ,  `kb_planet_def`";				$q = 'select * from kampfberichte';				$result=$this->db->query($q);				$bla = 0;				$html = '<table class="auswertung">';//<th>Farm</th><th>Spieler</th><th>Anzahl</th><th>Eisen</th><th>Silizium</th><th>Wasser</th><th>Wasserstoff</th></tr>';				if ($this->db->get_last_num_rows() > 0)		{ 			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 			{				$bla++;								$html .= '<tr>';								foreach($row as $key => $value)				{					/*preg_match("/([0-9]+):([0-9]+):([0-9]+)/",$row['Farm'],$planet);					if ($key=='Farm') {						$html .= '<td><a href="http://uni1.gigrawars.de/galaxie.php?to='.$value.':1">'.$value.'</a>';						$html .= '<div title="Details: '.$row['Farm'].'" class="details icon" onclick="ajaxMessageBox(\'FarmInterface\',\'getFarmData\',{ galaxy:'.$planet[1].',system:'.$planet[2].',planet:'.$planet[3].', highscore: true })"></div></td>';					}					else if ($key=='pl_spieler') {						$html .= '<td><a href="http://uni1.gigrawars.de/playercard.php?p='.$row['Farm'].':1">'.(($value != '' && $value != null) ? $value : '-' ).'</a>';						if ($row['pl_spieler'] != '' && $row['Farm'] != null) 						{							$html .= '<div title="Alle Planeten: '.$row['pl_spieler'].'" class="planet icon" onclick="ajaxMessageBox(\'PlanetInterface\',\'getPlanetByPlayer\',{ player:\''.$row['pl_spieler'].'\', highscore: true})"></div>';						}						$html .= '</td>';					}					else {*/						$html .= '<td>'.$value.'</td>';					/*}*/				}								$html.='</tr>';								if ($bla%30==29) 				{					$html .= '<tr>'.					'		<th>Farm</th>'.					'		<th>Spieler</th>'.					'		<th>Anzahl</th>'.					'		<th>Eisen</th>'.					'		<th>Silizium</th>'.					'		<th>Wasser</th>'.					'		<th>Wasserstoff</th>'.					'	</tr>';				}			}		}		else		{			$html .= '<tr><td colspan="7">Nicht genug Daten gesammelt!</td></tr>';		}		$html .= '</table>';				$resultData = new stdClass;		$resultData->html = $html;				return new DataResponse(ResultTypes::resultOK,"getCompletePerFarm",$resultData);	}	}KampfberichtInterface::registerInterface();?>