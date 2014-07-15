<?php
	
abstract class ResultTypes
{
    const resultOK = "ok";
    const resultNotOK = "nok";
}
	
class BasicResponse {
	public $result;
	public $message;
	public $debugInfo;
	
	public function toJson()
	{
		return json_encode($this);
	}
	
	public function __construct($result,$message,$debugInfo = null) {
		$this->result = $result;
		$this->message = $message;
		$this->debugInfo = $debugInfo;
	}
}

class DataResponse extends BasicResponse {
	public $data;
	
	public function __construct($result,$message,$data,$debugInfo = null) {
		parent::__construct($result,$message,$debugInfo);
		$this->data = $data;
	}
}

class ErrorResponse extends BasicResponse {
	public function __construct($message,$debugInfo = null) {
		parent::__construct(ResultTypes::resultNotOK,$message,$debugInfo);
	}
}

class ErrorDataResponse extends ErrorResponse {
	public $data;
	
	public function __construct($message,$data,$debugInfo = null) {
		parent::__construct($message,$debugInfo);
		$this->data = $data;
	}
}

?>
