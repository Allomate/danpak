<?php

require_once '../database/config.php';

$username = $_POST["username"];

$sql = "SELECT * from employees_info where employee_username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
if($stmt->fetch()){
	echo "Exist";
}else{
	echo "No";
}
// else
	// die(htmlspecialchars($stmt->error));

exit;
?>