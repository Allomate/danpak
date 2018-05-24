<?php

require_once '../database/config.php';

$regionName = $_POST["regionName"];

$sql = "INSERT INTO `company_regions`(`region_name`, `region_company`) VALUES (?, (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)))";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $regionName, $_COOKIE["US-K"]);
if($stmt->execute()){
	$stmt->close();
	$hostLink = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
	header('Location: '.$hostLink.'/add_franchise.php');
}
else
	die(htmlspecialchars($stmt->error));

exit;
?>