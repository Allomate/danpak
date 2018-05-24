<?php

header('Content-Type: application/json');

require_once '../database/config.php';
require_once '../classes/Status.php';
require_once '../classes/Authenticate-Session.php';
require_once '../classes/FileComplaint.php';
require_once 'validate_api.php';

if(isset($_POST['session'])){
	$sessionStr = mysqli_real_escape_string($conn, $_POST['session']);
	$auth = new AuthenticateSession($sessionStr);
	if(json_decode($auth->authenticate($conn), true)["status"] != "success")
		die($auth->authenticate($conn));
}else{
	$status = new ReturnStatus("failed","authentication","Provide session string");
	die($status->GetStatus());
}

if(isset($_POST['head_id'], $_POST['department_id'], $_POST['subhead_id'], $_POST['company_id'], $_POST['franchise_id'], $_POST['user_comments'], $_POST['allow_contact'])){
	$fileComplaint = new FileComplaint($_POST['session'], $_POST['department_id'], $_POST['head_id'], $_POST['subhead_id'], $_POST['company_id'], $_POST['franchise_id'], $_POST['user_comments'], $_POST['allow_contact']);
	echo $fileComplaint->saveComplaint($conn);
}else{
	$status = new ReturnStatus("failed","Missing Arguments","Provide all values required");
	die($status->GetStatus());
}

?>