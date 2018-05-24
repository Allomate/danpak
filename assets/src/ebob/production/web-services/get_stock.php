<?php

header('Content-Type: application/json');

require_once '../database/config.php';
require_once '../classes/Status.php';
require_once 'validate_api.php';
require_once '../classes/GetNumberOfItemsInStock.php';

if(!isset($_POST['company_id'], $_POST['franchise_id'], $_POST['item_barcode'])){
	$status = new ReturnStatus("failed","missing-information","Provide all the details required");
	die($status->GetStatus());
}

$getStock = new GetStock($conn);
echo $getStock->getStockItems($_POST['company_id'], $_POST['franchise_id'], $_POST['item_barcode']);

?>