<?php
require_once '../database/config.php';
$sql = "SELECT count(*) from complains WHERE company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)) and TIMESTAMPDIFF(HOUR, tad_time_start, CURRENT_TIMESTAMP) > (SELECT tat_time_hrs from tat_time_management where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)))";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $_COOKIE["US-K"], $_COOKIE["US-K"]);
$stmt->execute();
$stmt->bind_result($tatOverComplains);
while($stmt->fetch()){
	echo $tatOverComplains;
}

$stmt->close();
?>