<?php

class AuthenticateAPI{

	function __construct($apiSecret){
		$this->apiSecret = $apiSecret;
	}

	public function authenticateApi($conn){
		$sql = "select * from service_secret_key where api_secret = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('s',$this->apiSecret);
		$stmt->execute();
		if(!$stmt->fetch()){
			$status = new ReturnStatus("failed","api-auth","Authentication Failed");
			$stmt->close();
			return $status->GetStatus();
		}else{
			$status = new ReturnStatus("success","api-auth","Authentication Success");
			$stmt->close();
			return $status->GetStatus();
		}
	}

}

?>