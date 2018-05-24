<?php
require_once '../database/config.php';
$companyId = $_POST["companyId"];
$sql = "SELECT (SELECT region_name from company_regions where region_id = (SELECT franchise_region from franchise_info where franchise_id = com.franchise_id)) as region, count(complain_id) as total_complains FROM `complains` com where company_id = ? group by (SELECT region_name from company_regions where region_id = (SELECT franchise_region from franchise_info where franchise_id = com.franchise_id))";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $companyId);
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