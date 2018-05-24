<?php

header('Content-Type: application/json');

require_once '../database/config.php';
require_once '../classes/Status.php';
require_once 'validate_api.php';
require_once '../classes/GetProductsList.php';

if (!isset($_POST['product_category_id'], $_POST['company_id'])) {
	$status = new ReturnStatus("failed","missing-information","Provide product all the details required");
	die($status->GetStatus());
}

$getProducts = new GetProductsList($conn, $_POST['product_category_id'], $_POST['company_id']);
echo $getProducts->getProdsList();

?>