<?php

require_once '../database/config.php';

$customerPhone = $_POST["customerPhone"];
$customerEmail = $_POST["customerEmail"];
$customerName = $_POST["customerName"];
$customerGender = $_POST["customerGender"];
$createdAt = date('Y:m:d H:m:s');

$sql = "SELECT name from non_registerered_customer_data where phone = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $customerPhone);
$stmt->execute();
$stmt->bind_result($name);
if ($stmt->fetch()) {
	$details = array('status' => 'Exist', 'name' => $name);
	die(json_encode($details));
}
$stmt->close();

$sql = "INSERT INTO `non_registerered_customer_data`(`name`, `email`, `gender`, `phone`, `created_at`) VALUES (?,?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssss', $customerName, $customerEmail, $customerGender, $customerPhone, $createdAt);
if($stmt->execute()){
	$details = array('status' => 'Success');
	die(json_encode($details));
}
else
	die(htmlspecialchars($stmt->error));
?>