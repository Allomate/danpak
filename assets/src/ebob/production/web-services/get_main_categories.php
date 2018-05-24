<?php

header('Content-Type: application/json');

require_once '../database/config.php';
require_once '../classes/Status.php';
require_once 'validate_api.php';
require_once '../classes/GetMainCatsList.php';

$getMainCats = new GetMainCategories($conn);
echo $getMainCats->getMainCategories();

?>