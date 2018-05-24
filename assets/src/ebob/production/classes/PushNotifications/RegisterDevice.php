<?php 
require_once 'DBOperation.php';

class RegisterDevice{

	function __construct($token, $email){
		$this->token = $token;
		$this->email = $email;
	}

	function tokenizeDevice(){
		$db = new DbOperation(); 
		$result = $db->registerDevice($this->email, $this->token);
		$status = null;
		if($result == 0){
			$status = new ReturnStatus("success","registration","Device registered successfully");
		}elseif($result == 2){
			$status = new ReturnStatus("failed","registration","Device already registered");
		}else{
			$status = new ReturnStatus("failed","registration","Device not registered");
		}
		return $status->GetStatus();
	}
}

?>