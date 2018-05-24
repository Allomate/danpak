<?php

header('Content-Type: application/json');

require_once '../database/config.php';
require_once '../classes/Status.php';
require_once '../classes/Authenticate-Session.php';
require_once 'validate_api.php';
require_once '../classes/GetComplainSubHeads.php';

if(!isset($_POST["complain_head_id"], $_POST["level"])){
	$status = new ReturnStatus("failed","ComplainHeads","Provide all values required");
	die($status->GetStatus());
}

$subHeads = new ComplainSubHeads($conn);
echo $subHeads->getComplainSubHeads($_POST["complain_head_id"], $_POST["level"]);

?>