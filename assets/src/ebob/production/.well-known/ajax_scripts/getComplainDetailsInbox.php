<?php
require_once '../database/config.php';

$complainId = $_POST["complain_id"];

$sql = "SELECT user_comments, tad_time_start, complain_status, (SELECT franchise_name from franchise_info fi where fi.franchise_id = com.franchise_id) as franchise_name, (SELECT department_name from departments_info dept where dept.department_id = com.department_id) as department_name, tad_time_close, employee_comments, TIMESTAMPDIFF(HOUR, tad_time_start, tad_time_close) as tad_time_diff, (SELECT employee_name from employees_info where employee_id = com.employee_id) as employee_name from complains com where complain_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $complainId);
$stmt->execute();
$stmt->bind_result($user_comments, $tad_time_start, $complain_status, $franchise_name, $department_name, $tad_time_close, $employee_comments, $tad_time_diff, $employee_name);
$complainInfo = array();
while($stmt->fetch()){
	$complainInfo = array(
		'user_comments' => $user_comments,
		'tad_time_start' => $tad_time_start,
		'complain_status' => $complain_status,
		'franchise_name' => $franchise_name,
		'department_name' => $department_name,
		'tad_time_close' => $tad_time_close,
		'employee_name' => $employee_name,
		'employee_comments' => $employee_comments,
		'tad_time_diff' => $tad_time_diff
		);
}

echo json_encode($complainInfo);
exit;
?>