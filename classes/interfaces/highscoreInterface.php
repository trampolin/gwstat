<?php//require_once(ROOT_DIR."/classes/entities/band.php");class HighscoreInterface extends BasicInterface {		public function __construct($db = null) {		parent::__construct($db);	}		public function getCompleteHighscore($data)	{		$q = "SELECT * from highscore order by hs_platz asc, hs_timestamp asc";				$result=$this->db->query($q);				$bla = 0;				$html = '<table class="auswertung"><tr><th>Timestamp</th><th>Name</th><th>Allianz</th><th>Platz</th><th>Planetenpkt.</th><th>Forschungspkt.</th><th>Punkte</th><th>Planeten</th></tr>';				if ($this->db->get_last_num_rows() > 0)		{ 			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 			{				$bla++;
				
				$html .= '<tr>';
								foreach($row as $key => $value)				{					if ($key != 'hs_playercard') {						if ($key == 'hs_name')						{							if ($row['hs_playercard'] == '')							{								$html .= '<td>'.$value.'</td>';							}							else							{								$html .= '<td><a href="http://uni1.gigrawars.de/playercard.php?u='.$row['hs_playercard'].'">'.$value.'</a></td>';							}						}						else						{							$html .= '<td>'.$value.'</td>';						}					}											}				$html .= '</tr>';									if ($bla%30==29) 				{					$html .= '<tr>'.					'		<th>Timestamp</th>'.					'		<th>Name</th>'.					'		<th>Allianz</th>'.					'		<th>Platz</th>'.					'		<th>Planetenpkt.</th>'.					'		<th>Forschungspkt.</th>'.					'		<th>Punkte</th>'.					'		<th>Planeten</th>'.					'	</tr>';				}			}		}
		else
		{
			$html .= '<tr><td colspan="8">Nicht genug Daten gesammelt!</td></tr>';
		}		$html .= '</table>';				$resultData = new stdClass;		$resultData->html = $html;				return new DataResponse(ResultTypes::resultOK,"getCompleteHighscore",$resultData);	}
	
	public function getActiveHighscore($data) 
	{
// aktive Spieler
		$q = "select t1.hs_platz,t1.hs_name,t1.hs_timestamp,t1.hs_punkte as PunkteNeu,t2.hs_punkte as PunkteAlt from highscore as t1 join highscore as t2 on t1.hs_name = t2.hs_name and t1.hs_timestamp > t2.hs_timestamp where t1.hs_punkte <> t2.hs_punkte group by 2,1,3,4,5 order by t1.hs_platz";

    $result =$this->db->query($q);
        
    $bla = 0;
		
		$html = '<table class="auswertung"><tr><th>Platz</th><th>Name</th><th>Aktiv</th><th>Punkte Neu</th><th>Punkte Alt</th></tr>';
        
		if ($this->db->get_last_num_rows() > 0)
		{ 
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
			{
				$bla++;
				
				$html .= '<tr>';
				
				foreach($row as $key => $value)
				{
					$html .= '<td>'.$value.'</td>';
				}
				$html .= '</tr>';
				
				if ($bla%30==29) {
					$html .= '<tr><th>Platz</th><th>Name</th><th>Aktiv</th><th>Punkte Neu</th><th>Punkte Alt</th></tr>';
				}
			}
		}
		else
		{
			$html .= '<tr><td colspan="5">Nicht genug Daten gesammelt!</td></tr>';
		}
		
		$html .= '</table>';				$resultData = new stdClass;		$resultData->html = $html;
		
		return new DataResponse(ResultTypes::resultOK,"getActiveHighscore",$resultData);
	}	}HighscoreInterface::registerInterface();?>