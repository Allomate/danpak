<?php

require_once '../database/config.php';

$complainHeadName = $_POST["complainHeadName"];
$department = $_POST["departments"];

$sql = "INSERT INTO `complain_heads`(`complain_head`, `department_id`) VALUES (?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $complainHeadName, $department);
if($stmt->execute()){
	$stmt->close();
	$hostLink = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
	header('Location: '.$hostLink.'/complain_heads.php');
}
else
	die(htmlspecialchars($stmt->error));

exit;
?>