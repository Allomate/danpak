<?php
require_once '../database/config.php';
$sql = "SELECT sum(TIMESTAMPDIFF(HOUR, tad_time_start, tad_time_close))/count(*) hours from complains where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)) and complain_status = 'resolved'";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $_COOKIE["US-K"]);
$stmt->execute();
$stmt->bind_result($avgTat);
while($stmt->fetch()){
	echo $avgTat;
}

$stmt->close();
?>