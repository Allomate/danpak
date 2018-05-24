<?php

header('Content-Type: application/json');

require_once '../database/config.php';
require_once '../classes/Status.php';
require_once '../classes/Authenticate-Session.php';
require_once 'validate_api.php';
require_once '../classes/GetComplainHeads.php';

$complainHeads = new ComplainHeads($conn);
echo $complainHeads->getComplainHeads();

?>