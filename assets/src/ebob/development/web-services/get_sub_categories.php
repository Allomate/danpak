<?php

header('Content-Type: application/json');

require_once '../database/config.php';
require_once '../classes/Status.php';
require_once 'validate_api.php';
require_once '../classes/GetSubCatsList.php';

if (!isset($_POST['main_category_id'])) {
	$status = new ReturnStatus("failed","missing-information","Provide main category id");
	die($status->GetStatus());
}

$getSubCats = new GetSubCategories($conn, $_POST['main_category_id']);
echo $getSubCats->getSubCategories();

?>