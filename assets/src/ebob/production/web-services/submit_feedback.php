<?php

header('Content-Type: application/json');

require_once '../database/config.php';
require_once '../classes/Status.php';
require_once '../classes/Authenticate-Session.php';
require_once 'validate_api.php';
require_once '../classes/SubmitFeedback.php';

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

if(isset($_POST['product_id'], $_POST['feedback'])){
	$submitFeedback = new SubmitFeedback($conn, $sessionStr, $_POST["product_id"], $_POST["feedback"]);
	echo $submitFeedback->submitFeedback();
}else{
	$status = new ReturnStatus("failed","submit-feedback","Provide all values required");
	die($status->GetStatus());
}

?>