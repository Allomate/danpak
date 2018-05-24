<?php
require_once '../database/config.php';
$sql = "SELECT franchise_id, franchise_name from franchise_info where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $_COOKIE["US-K"]);
$stmt->execute();
$stmt->bind_result($franchise_id, $franchise_name);
$franchiseNames = array();
$franchiseIds = array();
while($stmt->fetch()){
	$franchiseNames[] = $franchise_name;
	$franchiseIds[] = $franchise_id;
}
echo json_encode(array("name"=>$franchiseNames,"id"=>$franchiseIds));
exit;
?>