<?php
require_once 'database/config.php';
$sql = "DELETE from employee_session where session = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $_COOKIE["US-K"]);
if($stmt->execute()){
	setcookie('US-K', null, -1, '/');
	setcookie('US-LT', null, -1, '/');
	$hostLink = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]"; 
	header('Location: '.$hostLink.'/index.php');
	exit;
}
?>