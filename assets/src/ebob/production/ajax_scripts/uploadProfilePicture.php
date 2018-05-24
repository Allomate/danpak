<?php
require_once '../database/config.php';
$target_dir = "../uploads/emp_dp/";
$sql = "SELECT employee_picture from employees_info where employee_username = (SELECT employee from employee_session where session = ?)";
$stmt=$conn->prepare($sql);
$stmt->bind_param('s', $_COOKIE["US-K"]);
$stmt->execute();
$stmt->bind_result($dp);
while($stmt->fetch()){
	if(file_exists($dp))
		unlink($dp);
}
$stmt->close();

$target_file_thumb = $target_dir . (time()+1000) . "-" . "{$_FILES['profile_picture'] ['name']}";
if (move_uploaded_file ($_FILES['profile_picture'] ['tmp_name'], $target_file_thumb)) {
	$sql = "UPDATE employees_info set employee_picture = ? where employee_username = (SELECT employee from employee_session where session = ?)";
	$stmt=$conn->prepare($sql);
	$stmt->bind_param('ss', $target_file_thumb, $_COOKIE["US-K"]);
	if ($stmt->execute()) {
		echo json_encode(array('status'=>'success', 'image'=>$target_file_thumb));
	}
	$stmt->close();	
}
die;
?>