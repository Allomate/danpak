<?php

require_once '../database/config.php';

$empName = $_POST["empName"];
$empAddress = $_POST["empAddress"];
$empCity = $_POST["empCity"];
$empCountry = $_POST["empCountry"];
$empPhone = $_POST["empPhone"];
$empUsername = $_POST["empUsername"];

$sql = "UPDATE `employees_info` set employee_name = ?, employee_address = ?, employee_city = ?, employee_country = ?, employee_phone = ? where employee_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssssi', $empName, $empAddress, $empCity, $empCountry, $empPhone, $empUsername);
if($stmt->execute()){
	echo "Updated";
}
else
	die(htmlspecialchars($stmt->error));

exit;
?>