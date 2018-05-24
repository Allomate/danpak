<?php

require_once '../database/config.php';

$customerNumber = $_POST["customerNumber"];

$sql = "SELECT user_name from users where user_phone = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $customerNumber);
$stmt->execute();
$stmt->bind_result($name);
if($stmt->fetch()){
	die($name);
}
else{
	$stmt->close();
	$sql = "SELECT name from non_registerered_customer_data where phone = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('s', $customerNumber);
	$stmt->execute();
	$stmt->bind_result($name);
	if($stmt->fetch()){
		die($name);
	}else{
		die("Failed");
	}
}
?>