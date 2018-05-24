<?php

require_once '../database/config.php';

$departmentName = $_POST["departmentName"];

$sql = "INSERT INTO `departments_info`(`department_name`) VALUES (?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $departmentName);
if($stmt->execute()){
	$stmt->close();
	setcookie('department_added', 'true', time() + (86400 * 30), "/");
	$hostLink = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
	header('Location: '.$hostLink.'/add_department.php');
}
else
	die(htmlspecialchars($stmt->error));

exit;
?>