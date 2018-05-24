<?php

header('Content-Type: application/json');

require_once '../database/config.php';
require_once '../classes/Status.php';
require_once '../classes/Authenticate-Session.php';
require_once 'validate_api.php';
require_once '../classes/GetCart.php';

if(isset($_POST['session'])){
	$sessionStr = mysqli_real_escape_string($conn, $_POST['session']);
	$auth = new AuthenticateSession($sessionStr);
	if(json_decode($auth->authenticate($conn), true)["status"] != "success")
		die($auth->authenticate($conn));
}else{
	$status = new ReturnStatus("failed","authentication","Provide session string");
	die($status->GetStatus());
}

if (!isset($_POST['user_type'])) {
	$status = new ReturnStatus("failed","missing-parameters","Please provide user_type");
	die($status->GetStatus());
}

$getCart = new GetCart($conn, $_POST['session'], $_POST['user_type']);
echo $getCart->getCartDetails();

?>