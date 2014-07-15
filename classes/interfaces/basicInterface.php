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