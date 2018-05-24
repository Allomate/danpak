<?php

require_once '../database/config.php';
require_once '../classes/Secure.php';

$username = $_POST["username"];
$password = sha1($_POST["password"]);

$sql = "SELECT * from employees_info where employee_username = ? and employee_password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $username, $password);
$stmt->execute();
if(!$stmt->fetch()){
	die("Sorry! No user found");
}
$stmt->close();

$deleteSess = "DELETE FROM employee_session WHERE employee = ?";
$stmt = $conn->prepare($deleteSess);
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->close();

$obj = new SecureToken();
$sessKey = $obj->getToken(50);
$expiry = date('Y:m:d');

$sql = "INSERT into employee_session (employee, session, expiry) values(?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sss', $username, $sessKey, $expiry);
$stmt->execute();

setcookie('US-K', $sessKey, time() + (86400 * 1), "/");
setcookie('US-LT', 'w', time() + (86400 * 1), "/");
$hostLink = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
header('Location: '.$hostLink.'/index.php');

exit;
?>