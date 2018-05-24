<?php
require_once '../database/config.php';
$crankOp = $_POST["crankOp"];
$email = $_POST["userEmail"];

if ($crankOp == "add") {
	$sql = "INSERT INTO `crank_customers`(`user_id`, `employee_id`, `company_id`) VALUES ((SELECT user_id from users where user_email = ?), (SELECT employee_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)),(SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)))";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('sss', $email, $_COOKIE["US-K"], $_COOKIE["US-K"]);
	if(!$stmt->execute())
		die(htmlspecialchars($stmt->error));
	$stmt->close();
	echo "Added";
}else{
	$sql = "DELETE from `crank_customers` where user_id = (SELECT user_id from users where user_email = ?)";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('s', $email);
	if(!$stmt->execute())
		die(htmlspecialchars($stmt->error));
	$stmt->close();
	echo "Removed";
}
exit;
?>