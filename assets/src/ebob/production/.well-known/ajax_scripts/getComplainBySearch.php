<?php
require_once '../database/config.php';
$complain_id = $_POST["id"];
$sql = "SELECT complain_id, (SELECT user_name from users where user_id = com.user_id) as user, user_comments, (SELECT user_dp from users where user_id = com.user_id) as user_dp, tad_time_start from complains com where company_id = (SELECT company_id from employees_info ei where ei.employee_username = (SELECT employee from employee_session where session = ?)) and department_id in (SELECT department_id from employee_departments_mapping where employee_id = (SELECT employee_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)))";
$stmt=$conn->prepare($sql);
$stmt->bind_param('ss', $_COOKIE["US-K"], $_COOKIE["US-K"]);
if (isset($_POST["complainStatus"])) {
	$sql = "SELECT complain_id, (SELECT user_name from users where user_id = com.user_id) as user, user_comments, (SELECT user_dp from users where user_id = com.user_id) as user_dp, tad_time_start from complains com where company_id = (SELECT company_id from employees_info ei where ei.employee_username = (SELECT employee from employee_session where session = ?)) and department_id in (SELECT department_id from employee_departments_mapping where employee_id = (SELECT employee_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))) and complain_status = ?";
	$stmt=$conn->prepare($sql);
	$stmt->bind_param('sss', $_COOKIE["US-K"], $_COOKIE["US-K"], $_POST["complainStatus"]);
}
$stmt->execute();
$complains = array();
$stmt->bind_result($complainId, $user, $user_comments, $user_dp, $time);
if (!isset($_POST["complainStatus"])) {
	while($stmt->fetch()){
		if ($complainId == $complain_id) {
			$complains[] = array(
				'complainId' => $complainId,
				'user' => $user,
				'comments' => $user_comments,
				'user_dp' => $user_dp,
				'time' => $time
			);
		}
	}
}else{
	while($stmt->fetch()){
		$complains[] = array(
			'complainId' => $complainId,
			'user' => $user,
			'comments' => $user_comments,
			'user_dp' => $user_dp,
			'time' => $time
		);
	}
}
echo json_encode($complains);
exit;
?>