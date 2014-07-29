<?php

class BasicInterface {
	protected $db;
	
	public function __construct($db = null) {
		if ($db == null) {
			$this->db = new DatabaseConnection();
		}
		else
		{
			$this->db = $db;
		}
	}

	public static $allowedCalls = array();

	public static function registerInterface()
	{
		BasicInterface::$allowedCalls[get_called_class()] = array();
		$class_methods = get_class_methods(get_called_class());
		foreach ($class_methods as $method_name) {
			if (($method_name != "registerInterface") && ($method_name != "__construct")) 
			{
				BasicInterface::$allowedCalls[get_called_class()][$method_name] = true;
			}
		}
	}
	
	protected function getHtmlAjaxMessageBox($interface,$function,$params)
	{
		$html='ajaxMessageBox(\''.$interface.'\',\''.$function.'\'';
		if ($params != null)
		{
			$html .= ','.$params;
		}
		$html .= ')';
		return $html;
	}
	
	protected function getHtmlDiv($title,$class,$id,$onclick,$content)
	{
		$html = '<div';
		if ($title != null)
		{
			$html .= ' title="'.$title.'"';
		}
		if ($class != null)
		{
			$html .= ' class="'.$class.'"';
		}
		if ($id != null)
		{
			$html .= ' id="'.$id.'"';
		}
		if ($onclick != null)
		{
			$html .= ' onclick="'.$onclick.'"';
		}
		$html .= '>';
		if ($content != null)
		{
			$html .= $content;
		}
		$html .= '</div>';
		return $html;
	}
	
	protected function getHtmlAllPlanetByPlayerIcon($player)
	{
		return $this->getHtmlDiv("Alle Planeten: ".$player,"planet icon",null,$this->getHtmlAjaxMessageBox('PlanetInterface','getPlanetByPlayer','{player: \''.$player.'\', highscore: true, popup: true, dotable: true}'),null);
	}
	
	protected function getHtmlHighscoreHistoryIcon($player)
	{
		return $this->getHtmlDiv("Highscoreverlauf: ".$player,"highscorev icon",null,$this->getHtmlAjaxMessageBox('HighscoreInterface','getHighscoreHistory','{player: \''.$player.'\', highscore: true, popup: true, dotable: true}'),null);
	}
	
	protected function getHtmlFavoritIcon($player,$favorit)
	{
		return $this->getHtmlDiv(($favorit != null && $favorit != 0 ? 'Von Favoriten entfernen' : 'Zu Favoriten hinzufügen').': '.$player,$player.'_favorit '.($favorit != null && $favorit != 0 ? 'removefavorit' : 'addfavorit').' icon',null,'requestToggleHighscore(\''.$player.'_favorit\',{player:\''.$player.'\'})',null);
	}
	
	protected function getHtmlTableHeader($fields)
	{
		$html = '<thead>';
		foreach ($fields as $field)
		{
			$html .= '<th>'.$field.'</th>';
		}
		$html .= '</thead>';
		return $html;
	}
	
	
	
	protected function getTableClasses($data)
	{
		$classes = array();
		$classes[] = 'auswertung';
		//$classes[] = $data->func;
		if (isset($data->popup))
		{
			$classes[] = 'popup';
		}
		if (isset($data->dotable) && ($data->dotable))
		{
			$classes[] = 'dotable';
		}
		return $classes;
	}
	
	protected function getHtmlTableOpen($classes)
	{
		$html = '<table class="';
		foreach ($classes as $class)
		{
			$html .= $class.' ';
		}
		$html .= '">';
		
		return $html;
	}
	
	public function testInterface($data)
	{
		return new DataResponse(ResultTypes::resultOK,"Test Interface: ".get_class($this),$data);
	}
	
	public function getInterfaceInfo()
	{
		return new DataResponse(ResultTypes::resultOK,"Interface Info: ".get_class($this),BasicInterface::$allowedCalls[get_class($this)]);
	}
}

BasicInterface::registerInterface();

?>