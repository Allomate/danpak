<?php
require_once '../database/config.php';
$companyId = $_POST["companyId"];
$sql = "SELECT (SELECT franchise_name from franchise_info where franchise_id = com.franchise_id) as franchise, count(complain_id) from complains com where company_id = ? group by franchise_id";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $companyId);
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