<?php

header('Content-Type: application/json');

require_once '../database/config.php';
require_once '../classes/Status.php';
require_once 'validate_api.php';
require_once '../classes/RemoveFromWl.php';

if(!isset($_POST['wl_id'])){
	$status = new ReturnStatus("failed","missing-information","Please provide wl_id");
	die($status->GetStatus());
}

$removeFromWl = new RemoveFromWl($conn, $_POST["wl_id"]);
echo $removeFromWl->removeItemsFromWl();

?>