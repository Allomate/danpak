<?php
require_once '../database/config.php';
$sql = "SELECT (SELECT franchise_name from franchise_info where franchise_id = com.franchise_id) as franchise, count(complain_id) from complains com where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)) group by franchise_id";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $_COOKIE["US-K"]);
$stmt->execute();
$stmt->bind_result($franchise, $totalComplains);
$franchises = array();
$totalComplainses = array();
while($stmt->fetch()){
	$franchises[] = $franchise;
	$totalComplainses[] = $totalComplains;
}
echo json_encode(array("franchise"=>$franchises,"totalComplains"=>$totalComplainses));
exit;
?>