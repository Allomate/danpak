<?php

header('Content-Type: application/json');

require_once '../database/config.php';
require_once '../classes/Status.php';
require_once '../classes/Authenticate-Session.php';
require_once 'validate_api.php';
require_once '../classes/GetCompaniesList.php';

$companiesList = new CompaniesList($conn);
echo $companiesList->getCompanies();

?>