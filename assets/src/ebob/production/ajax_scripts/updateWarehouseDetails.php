<?php
require_once '../database/config.php';

$name = $_POST["name"];
$code = $_POST["code"];
$location = $_POST["location"];

$sql = "UPDATE warehouse set warehouse_name = ?, warehouse_location = ? where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)) and warehouse_code = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssss', $name, $location, $_COOKIE["US-K"], $code);
if ($stmt->execute()) {
	echo "Success";
}else{
	echo htmlspecialchars($stmt->error);
}
$stmt->close();
die;
?>