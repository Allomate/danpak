<?php

require_once '../classes/Authenticate-API-Secret.php';

if(!isset($_POST["api_secret"])){
	$status = new ReturnStatus("failed","api-auth","Provide api secret key");
	die($status->GetStatus());
}else{
	$auth_api = new AuthenticateAPI($_POST["api_secret"]);
	if(json_decode($auth_api->authenticateApi($conn), true)["status"] != "success"){
		$status = new ReturnStatus("failed","api-auth","Authentication Failed");
		die($status->GetStatus());
	}
}

?>