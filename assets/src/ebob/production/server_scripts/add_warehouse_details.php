<?php

require_once '../database/config.php';

$name = $_POST["warehouseName"];
$loc = $_POST["warehouseLocation"];
$code = $_POST["warehousecode"];

$sql = "SELECT * from warehouse where warehouse_code = ? and company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $code, $_COOKIE["US-K"]);
$stmt->execute();
if ($stmt->fetch()) {
    setcookie('warehouse_code_exist', $code, time() + (86400 * 1), "/");
	header('Location: ../add_warehouse.php');
	die;
}
$stmt->close();

$sql = "INSERT INTO `warehouse`(`warehouse_name`, `warehouse_location`, `warehouse_code`, `company_id`) VALUES (?, ?, ?, (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)))";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssss', $name, $loc, $code, $_COOKIE["US-K"]);
if($stmt->execute()){
	$stmt->close();
    setcookie('warehouse_added', 'Success', time() + (86400 * 1), "/");
	header('Location: ../add_warehouse.php');
}
else
	die(htmlspecialchars($stmt->error));

exit;
?>