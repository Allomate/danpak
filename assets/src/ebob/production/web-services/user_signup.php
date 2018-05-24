<?php

header('Content-Type: application/json');

require_once '../database/config.php';
require_once '../classes/Status.php';
require_once '../classes/Authenticate-Session.php';
require_once '../classes/Signup.php';
require_once 'validate_api.php';

if(!isset($_POST["login_type"])){
	$status = new ReturnStatus("failed","Signup","Provide login type");
	die($status->GetStatus());
}

if($_POST["login_type"] == "web"){
	if(isset($_POST['username'], $_POST['email'], $_POST['password'], $_POST['gender'], $_POST['phone'], $_POST['address'], $_POST['city'], $_POST['country'], $_POST['firebase_token'], $_POST['age'])){
		$saveUser = new Signup($_POST["username"],strtolower($_POST["email"]),$_POST["password"],strtolower($_POST["gender"]),$_POST["phone"],$_POST["address"],$_POST["city"],$_POST["country"], strtolower($_POST["login_type"]), $_POST['firebase_token'], $_POST['age']);
		die($saveUser->saveUserDetails($conn));

	}else{
		$status = new ReturnStatus("failed","Signup","Provide all values required");
		die($status->GetStatus());
	}
}else{
	if(isset($_POST['username'], $_POST['email'], $_POST['gender'], $_POST['phone'], $_POST['address'], $_POST['city'], $_POST['country'], $_POST['firebase_token'])){
		$saveUser = new Signup($_POST["username"],strtolower($_POST["email"]), "",strtolower($_POST["gender"]),$_POST["phone"],$_POST["address"],$_POST["city"],$_POST["country"], strtolower($_POST["login_type"]), $_POST['firebase_token']);
		echo $saveUser->saveUserDetails($conn);
	}else{
		$status = new ReturnStatus("failed","Signup","Provide all values required");
		die($status->GetStatus());
	}
}

?>