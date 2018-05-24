<?php

header('Content-Type: application/json');

require_once '../database/config.php';
require_once '../classes/Status.php';
require_once '../classes/Authenticate-Session.php';
require_once 'validate_api.php';
require_once '../classes/GetFranchisesList.php';

if(!isset($_POST["company_id"])){
	$status = new ReturnStatus("failed", "Missing Arguments", "Please provide company id");
	die(json_encode($status));
}

$companyId = $_POST["company_id"];
$franchisesList = new FranchisesList($conn);
echo $franchisesList->getFranchises($companyId);

?>