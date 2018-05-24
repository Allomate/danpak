<?php

class AuthenticateSession{

	function __construct($sessionStr){
		$this->sessionStr = $sessionStr;
	}

	public function authenticate($conn){
		$sql = "select * from user_session where session = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('s',$this->sessionStr);
		$stmt->execute();
		if(!$stmt->fetch()){
			$status = new ReturnStatus("failed","authentication","Authentication Failed");
			$stmt->close();
			return $status->GetStatus();
		}else{
			$status = new ReturnStatus("success","authentication","Authentication Success");
			$stmt->close();
			return $status->GetStatus();
		}
	}

}

?>