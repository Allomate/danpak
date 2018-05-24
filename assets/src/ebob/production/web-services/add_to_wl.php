<?php

header('Content-Type: application/json');

require_once '../database/config.php';
require_once '../classes/Status.php';
require_once '../classes/Authenticate-Session.php';
// require_once 'validate_api.php';
require_once '../classes/AddToWl.php';

if(isset($_POST['session'])){
	$sessionStr = mysqli_real_escape_string($conn, $_POST['session']);
	$auth = new AuthenticateSession($sessionStr);
	if(json_decode($auth->authenticate($conn), true)["status"] != "success")
		die($auth->authenticate($conn));
}else{
	$status = new ReturnStatus("failed","authentication","Provide session string");
	die($status->GetStatus());
}

if (!isset($_POST['item_id'], $_POST['user_type'])) {
	$status = new ReturnStatus("failed","missing-information","Provide product all the required details");
	die($status->GetStatus());
}

$addToWl = new AddToWl($conn, $_POST['session'], $_POST['item_id'], $_POST['user_type']);
echo $addToWl->addItemToWishlist();

?>