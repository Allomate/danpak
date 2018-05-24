<?php
require_once '../database/config.php';
$sql = "SELECT sum(user_rating)/count(user_rating) FROM `complains` where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)) and complain_status = 'resolved'
and user_rating is NOT NULL";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $_COOKIE["US-K"]);
$stmt->execute();
$stmt->bind_result($satisfactionRatio);
$stmt->fetch();
echo $satisfactionRatio;
$stmt->close();
exit;
?>