<?php

require_once '../database/config.php';

$name = $_POST["warehouseName"];
$loc = $_POST["warehouseLocation"];

$sql = "INSERT INTO `warehouse`(`warehouse_name`, `warehouse_location`, `company_id`) VALUES (?, ?, (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)))";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sss', $name, $loc, $_COOKIE["US-K"]);
if($stmt->execute()){
	$stmt->close();
	header('Location: ../add_warehouse.php');
}
else
	die(htmlspecialchars($stmt->error));

exit;
?>