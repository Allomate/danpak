<?php

require_once '../database/config.php';

$empLocation = $_POST["empLocation"];
$departments = $_POST["empDepartments"];
$empUsername = $_POST["empUsername"];

$sql = "UPDATE `employees_info` set franchise_id = ? where employee_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $empLocation, $empUsername);
if($stmt->execute()){
	$stmt->close();
}
else
	die(htmlspecialchars($stmt->error));

$sql = "DELETE from `employee_departments_mapping` where employee_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $empUsername);
if($stmt->execute()){
	$stmt->close();
}

$departmentsNew = explode(",", $departments);
for ($i=0; $i < sizeof($departmentsNew); $i++) { 
	$sql = "INSERT into `employee_departments_mapping`(`employee_id`, `department_id`) values(?,?)";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('ii', $empUsername, $departmentsNew[$i]);
	if($stmt->execute()){
		$stmt->close();
	}
}
echo "Updated";
exit;
?>