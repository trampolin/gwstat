<?php

define("ROOT_DIR", "../..");

require_once("responseTypes.php");
require_once(ROOT_DIR."/bin/database.php");
require_once(ROOT_DIR."/classes/interfaces/basicInterface.php");
require_once(ROOT_DIR."/classes/interfaces/highscoreInterface.php");


function handleRequest() {
	$request_body = file_get_contents('php://input');
	$decoded = json_decode($request_body);

	if (array_key_exists($decoded->intf,BasicInterface::$allowedCalls)) 
	{
		if (array_key_exists($decoded->func,BasicInterface::$allowedCalls[$decoded->intf])) 
		{
			if (BasicInterface::$allowedCalls[$decoded->intf][$decoded->func]) 
			{
				$interface = new $decoded->intf();
				return $interface->{$decoded->func}($decoded->data);
			}
			else 
			{
				return new ErrorDataResponse("Funktion ".$decoded->func." in Interface ".$decoded->intf." ist nicht erlaubt",$decoded->data);
			}
		}
		else 
		{
			return new ErrorDataResponse("Funktion ".$decoded->func." existiert nicht in Interface ".$decoded->intf,$decoded->data);
		}
	}
	else
	{
		return new ErrorDataResponse("Interface ".$decoded->intf." existiert nicht",$decoded->data);
	}
	
	return new ErrorDataResponse("Unbekannter Fehler",$decoded);
}

$response = handleRequest();
echo $response->toJson();

?>