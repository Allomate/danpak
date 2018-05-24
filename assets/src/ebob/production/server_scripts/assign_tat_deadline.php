<?php

require_once '../database/config.php';

$tatDeadline = $_POST["tatDeadline"];

$sql = "INSERT INTO `tat_time_management`(`company_id`, `tat_time_hrs`) VALUES ((SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)),?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $_COOKIE["US-K"], $tatDeadline);
if($stmt->execute()){
	$stmt->close();
	$hostLink = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
	header('Location: '.$hostLink.'/complain_heads.php');
}
else
	die(htmlspecialchars($stmt->error));

exit;
?>