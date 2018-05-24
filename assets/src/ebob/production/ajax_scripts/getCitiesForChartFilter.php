<?php
require_once '../database/config.php';
$sql = "SELECT franchise_city, (SELECT count(complain_id) from complains where franchise_id = fi.franchise_id) total_complains from franchise_info fi where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $_COOKIE["US-K"]);
$stmt->execute();
$stmt->bind_result($city, $totalComplains);
$details = array();
while($stmt->fetch()){
	$details[] = array(
		'city' => $city,
		'complains' => $totalComplains
		);
}
echo json_encode($details);
exit;
?>