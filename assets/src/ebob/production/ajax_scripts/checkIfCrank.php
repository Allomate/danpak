<?php
require_once '../database/config.php';

$email = $_POST["userEmail"];

$sql = "SELECT count(complain_id) as totalRecords FROM `complains` where user_id = (SELECT user_id from users where user_email = ?) and company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)) and MONTH(tad_time_start) = MONTH(CURDATE())";
$stmt=$conn->prepare($sql);
$stmt->bind_param('ss', $email, $_COOKIE["US-K"]);
$stmt->execute();
$stmt->bind_result($totalRecords);
if($stmt->fetch()){
	if($totalRecords <= 2)
		die("Less Complains");
}
$stmt->close();

$sql = "SELECT * from crank_customers where user_id = (SELECT user_id from users where user_email = ?) and company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
$stmt=$conn->prepare($sql);
$stmt->bind_param('ss', $email, $_COOKIE["US-K"]);
$stmt->execute();
if($stmt->fetch()){
	echo "Crank";
}else{
	echo "Not Cranked";
}
$stmt->close();
exit;
?>