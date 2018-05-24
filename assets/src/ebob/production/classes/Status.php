<?php

class ReturnStatus{
	//Status = "Success/Failure", Type = "Login/Signout/.."
	function __construct($status, $type, $message) {
		$this->status = $status;
		$this->type = $type;
		$this->message = $message;
	}

	public function GetStatus() {
		$status = array(
			'status' => $this->status,
			'type' => $this->type,
			'message' => $this->message
			);
		$resultJSON = json_encode($status);
		return $resultJSON;
	}

}

?>