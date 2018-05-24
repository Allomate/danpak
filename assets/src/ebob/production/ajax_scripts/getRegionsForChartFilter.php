<?php
require_once '../database/config.php';
$sql = "SELECT (SELECT region_name from company_regions where region_id = (SELECT franchise_region from franchise_info where franchise_id = com.franchise_id)) as region, count(complain_id) as total_complains FROM `complains` com where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)) group by (SELECT region_name from company_regions where region_id = (SELECT franchise_region from franchise_info where franchise_id = com.franchise_id))";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $_COOKIE["US-K"]);
$stmt->execute();
$stmt->bind_result($regions, $totalComplains);
$details = array();
while($stmt->fetch()){
	$details[] = array(
		'region' => $regions,
		'totalComplains' => $totalComplains
		);
}
echo json_encode($details);
exit;
?>