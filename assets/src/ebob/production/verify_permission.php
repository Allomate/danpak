<?php
require_once 'database/config.php';
$page = explode("/", $_SERVER['REQUEST_URI']);
$page = explode(".", $page[1]);
if ($page[0] == "access_rights") {
    $page[0] = 'permissions';
}
$sql = "SELECT " .$page[0]. " from access_rights where employee_id = (SELECT employee_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $_COOKIE["US-K"]);
$stmt->execute();
$stmt->bind_result($pagePermission);
while ($stmt->fetch()) {
    if (!$pagePermission) {
        header('Location: index.php');
        $stmt->close();
        exit;
    }
}
$stmt->close();
?>