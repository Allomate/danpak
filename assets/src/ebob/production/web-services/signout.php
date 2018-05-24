<?php

require_once '../database/config.php';

$deleteSess = "DELETE FROM employee_session WHERE session = ?";
$stmt = $conn->prepare($deleteSess);
$stmt->bind_param('s', $_COOKIE["US-K"]);
$stmt->execute();
$stmt->close();

setcookie('US-K', null, -1, '/');
setcookie('US-LT', null, -1, '/');
$hostLink = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
header('Location: '.$hostLink.'/index.php');

exit;
?>