<?php//require_once(ROOT_DIR."/classes/entities/band.php");/////////// INSERT INTO spieler (sp_name,sp_allianz)SELECT hs_name, hs_allianz FROM (SELECT hs_platz, hs_name, hs_allianz, hs_planetenpunkte,hs_forschungspunkte,hs_punkte,hs_planeten,hs_playercard FROM highscore ORDER BY hs_timestamp DESC) AS t1 GROUP BY hs_name ORDER BY hs_platz ASC/////////class HighscoreInterface extends BasicInterface {		public function __construct($db = null) {		parent::__construct($db);	}		public function toggleFavorit($data)	{		if (isset($data->player))		{			$q = "update spieler set sp_favorit=1-sp_favorit where sp_name='".$data->player."'";			$this->db->query($q);						$q = "select sp_favorit from spieler where sp_name='".$data->player."'";			$result=$this->db->query($q);			if ($this->db->get_last_num_rows() > 0)			{				$resultData = new stdClass;				while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 				{					$favorit = $row['sp_favorit'];				}				$resultData->player = $data->player;				$resultData->favorit = $favorit;								return new DataResponse(ResultTypes::resultOK,"toggleFavorit",$resultData);			}			else			{				return new ErrorResponse('Spieler nicht gefunden!',$data);			}								}		else		{			return new ErrorResponse('Spieler muss angegeben werden!',$data);		}	}		public function getAllyDetails($data)	{		if (isset($data->ally))		{			$title = $data->ally;			$html = '';			$hs = $this->getCompleteHighscore($data);			$html .= $hs->data->html;						$resultData = new stdClass;			$resultData->html = $html;			$resultData->title = $title;						return new DataResponse(ResultTypes::resultOK,"getAllyDetails",$resultData);		}		else		{			return new ErrorResponse('Allianz muss angegeben werden!',$data);		}	}		public function getHighscoreHistory($data)	{		if (isset($data->player))		{					$html = '';			$hs = $this->getCompleteHighscore($data);			$html .= $hs->data->html;						$resultData = new stdClass;					$highscoredata = new stdClass;			$highscoredata->punkte = array();			$highscoredata->platz = array();			$highscoredata->planeten = array();			$q = "SELECT hs_timestamp, hs_punkte, hs_platz, hs_planeten from highscore where hs_name='".$data->player."' order by hs_timestamp asc";			$result=$this->db->query($q);			if ($this->db->get_last_num_rows() > 0)			{ 				while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 				{					$punkterow = array();					$punkterow[] = $row['hs_timestamp'];					$punkterow[] = $row['hs_punkte'];					$highscoredata->punkte[] = $punkterow;										$platzrow = array();					$platzrow[] = $row['hs_timestamp'];					$platzrow[] = $row['hs_platz'];					$highscoredata->platz[] = $platzrow;										$planetenrow = array();					$planetenrow[] = $row['hs_timestamp'];					$planetenrow[] = $row['hs_planeten'];					$highscoredata->planeten[] = $planetenrow;				}				$html .= '<div id="highscoreverlauf"></div>';				$resultData->highscoredata = $highscoredata;			}						$resultData->html = $html;			$resultData->title = 'Highscoreverlauf '.$data->player;						return new DataResponse(ResultTypes::resultOK,"getHighscoreHistory",$resultData);		}		else		{			return new ErrorResponse('Spieler muss angegeben werden!',$data);		}					}		public function getCompleteHighscore($data)	{		//$q = "SELECT * from highscore order by hs_platz asc, hs_timestamp asc";				$where = " ";				if (isset($data->favoriten)) 		{			$where = " where sp_favorit=1 ";		}		else		{			if (isset($data->player))			{				$where .= "where hs_name='".$data->player."' ";			}			if (isset($data->ally))			{				if ($where == " ")				{					$where = " where ";				}				else				{					$where .= " and ";				}				$where .= " hs_allianz='".$data->ally."' ";			}		}				$q = "SELECT * FROM (SELECT hs_platz, hs_name, hs_allianz, hs_planetenpunkte,hs_forschungspunkte,hs_punkte,hs_planeten,hs_playercard,sp_favorit FROM highscore left join spieler on hs_name=sp_name".$where."ORDER BY hs_timestamp DESC) AS t1 GROUP BY hs_name ORDER BY hs_platz ASC";				$result=$this->db->query($q);				$bla = 0;				$html = '<table class="auswertung"><tr><th>Platz</th><th>Name</th><th>Allianz</th><th>Planetenpkt.</th><th>Forschungspkt.</th><th>Punkte</th><th>Planeten</th></tr>';				if ($this->db->get_last_num_rows() > 0)		{ 			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 			{				$bla++;				
				$html .= '<tr>';
								foreach($row as $key => $value)				{					if ($key != 'hs_playercard' && $key != 'sp_favorit') {						if ($key == 'hs_name')						{							if ($row['hs_playercard'] == '')							{								$html .= '<td>'.$value;							}							else							{								$html .= '<td><a href="http://uni1.gigrawars.de/playercard.php?u='.$row['hs_playercard'].'">'.$value.'</a>';							}							$html .= '<div title="Alle Planeten: '.$row['hs_name'].'" class="planet icon" onclick="ajaxMessageBox(\'PlanetInterface\',\'getPlanetByPlayer\',{ player:\''.$row['hs_name'].'\', highscore: true })"></div>';							$html .= '<div title="Highscoreverlauf: '.$row['hs_name'].'" class="highscorev icon" onclick="ajaxMessageBox(\'HighscoreInterface\',\'getHighscoreHistory\',{ player:\''.$row['hs_name'].'\', highscore: true })"></div>';														$html .= '<div title="'.($row['sp_favorit'] != null && $row['sp_favorit'] != 0 ? 'Von Favoriten entfernen' : 'Zu Favoriten hinzufügen').': '.$row['hs_name'].'" class="'.$row['hs_name'].'_favorit '.($row['sp_favorit'] != null && $row['sp_favorit'] != 0 ? 'removefavorit' : 'addfavorit').' icon" onclick="requestToggleHighscore(\''.$row['hs_name'].'_favorit\',{player:\''.$row['hs_name'].'\'})"></div>';														$html .= '</td>';						}						else if ($key == 'hs_allianz')						{							if ($value != '')							{								$html .= '<td>'.$value.'<div title="Allianz: '.$row['hs_allianz'].'" class="ally icon" onclick="ajaxMessageBox(\'HighscoreInterface\',\'getAllyDetails\',{ ally:\''.$row['hs_allianz'].'\', highscore: true })"></div></td>';							}							else							{								$html .= '<td>'.$value.'</td>';							}						}						else						{							$html .= '<td>'.$value.'</td>';						}					}				}				$html .= '</tr>';									if ($bla%30==29) 				{					$html .= '<tr>'.					'		<th>Platz</th>'.					'		<th>Name</th>'.					'		<th>Allianz</th>'.					'		<th>Planetenpkt.</th>'.					'		<th>Forschungspkt.</th>'.					'		<th>Punkte</th>'.					'		<th>Planeten</th>'.					'	</tr>';				}			}		}
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