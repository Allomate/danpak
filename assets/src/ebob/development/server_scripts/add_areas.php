<?php

require_once '../database/config.php';

$areaName = $_POST["areaName"];

$sql = "INSERT INTO `company_areas`(`area_name`, `area_company`) VALUES (?, (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)))";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $areaName, $_COOKIE["US-K"]);
if($stmt->execute()){
	$stmt->close();
	$hostLink = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
	header('Location: '.$hostLink.'/add_franchise.php');
}
else
	die(htmlspecialchars($stmt->error));

exit;
?>