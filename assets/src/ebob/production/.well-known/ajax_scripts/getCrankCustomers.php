<?php
require_once '../database/config.php';

$sql = "SELECT count(*) as totalCranks from crank_customers where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $_COOKIE["US-K"]);
$stmt->execute();
$stmt->bind_result($totalCranks);
$stmt->fetch();
echo $totalCranks;
$stmt->close();
exit;
?>