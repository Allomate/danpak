<?php

require_once '../database/config.php';

$targets = $_POST["targets"];
$percentage = $_POST["percentage"];
$employee_id = $_POST["employee_id"];
$targetSale = $_POST["target_sale"];
$criteria = $_POST["criteria"];
$criteriaDefinition = $_POST["criteria_definition"];
$created_at = date('Y:m:d H:m:s');
$currentYear = date("Y");

$sql = "SELECT id from employee_targets where employee_id = ? and criteria = ? and quarter = ? and EXTRACT(YEAR from created_at) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('isss', $employee_id, $criteria, $criteriaDefinition, $currentYear);
$stmt->execute();
$stmt->bind_result($id);
if ($stmt->fetch()) {
	$rowId = $id;
	$stmt->close();
	$sql = "DELETE from employee_targets where id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('i', $rowId);
	$stmt->execute();
}
$stmt->close();

$sql = "INSERT INTO `employee_targets`(`employee_id`, `criteria`, `quarter`, `targets`, `targets_percentage`, `target_sale_amount`, `created_at`) VALUES (?,?,?,?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('issssis', $employee_id, $criteria, $criteriaDefinition, $targets, $percentage, $targetSale, $created_at);
if($stmt->execute()){
	die("Success");
}
else
	die(htmlspecialchars($stmt->error));
?>