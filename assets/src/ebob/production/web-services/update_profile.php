<?php

header('Content-Type: application/json');

require_once '../database/config.php';
require_once '../classes/Status.php';
require_once '../classes/Authenticate-Session.php';
require_once 'validate_api.php';
require_once '../classes/UpdateProfile.php';

$sessionStr = "";
if(isset($_POST['session'])){
	$sessionStr = mysqli_real_escape_string($conn, $_POST['session']);
	$auth = new AuthenticateSession($sessionStr);
	if(json_decode($auth->authenticate($conn), true)["status"] != "success")
		die($auth->authenticate($conn));
}else{
	$status = new ReturnStatus("failed","authentication","Provide session string");
	die($status->GetStatus());
}

if(isset($_POST['email'], $_POST['password'], $_POST['gender'], $_POST['phone'], $_POST['address'], $_POST['user_dp'], $_POST['city'], $_POST['country'])){
	$userProfile = new UpdateProfile($conn, $sessionStr,strtolower($_POST["email"]),$_POST["password"],strtolower($_POST["gender"]),$_POST["phone"],$_POST["address"], $_POST['user_dp'], $_POST["city"],$_POST["country"]);
	echo $userProfile->updateProfile();
}else{
	$status = new ReturnStatus("failed","update-profile","Provide all values required");
	die($status->GetStatus());
}

?>