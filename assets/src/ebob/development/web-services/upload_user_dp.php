<?php

header('Content-Type: bitmap; charset=utf-8');

// require_once '../database/config.php';
// require_once '../classes/Status.php';
// require_once '../classes/Authenticate-Session.php';
// require_once '../classes/Signup.php';
// require_once 'validate_api.php';

if(!isset($_POST["user_dp"], $_POST["image_name"])){
	$status = new ReturnStatus("failed","Profile","Please provide User DP base64 string");
	die($status->GetStatus());
}

$upload_path = '../uploads/dp/'; //this is our upload folder

exit;

?>