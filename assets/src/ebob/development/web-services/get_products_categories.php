<?php

header('Content-Type: application/json');

require_once '../database/config.php';
require_once '../classes/Status.php';
require_once 'validate_api.php';
require_once '../classes/GetProductsCatsList.php';

if (!isset($_POST['sub_category_id'])) {
	$status = new ReturnStatus("failed","missing-information","Provide sub category id");
	die($status->GetStatus());
}

$getSubCats = new GetProdCategories($conn, $_POST['sub_category_id']);
echo $getSubCats->getProductsCategories();

?>