<?php
require_once '../database/config.php';
$locationId = $_POST["locationId"];
$sql = "SELECT franchise_id, franchise_name, (SELECT region_name from company_regions where region_id = fi.franchise_region) as region, (SELECT area_name from company_areas where area_id = fi.franchise_area) as area, franchise_region, franchise_area, franchise_address, franchise_city from franchise_info fi where franchise_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $locationId);
$stmt->execute();
$stmt->bind_result($franchise_id, $franchise_name, $region, $area, $regionId, $areaId, $franchise_address, $franchise_city);
$franchiseNames = array();
$franchiseIds = array();
$franchiseCities = array();
$franchiseAddress = array();
$franchiseArea = array();
$franchiseRegion = array();
$franchiseAreaId = array();
$franchiseRegionId = array();
while($stmt->fetch()){
	$franchiseNames[] = $franchise_name;
	$franchiseIds[] = $franchise_id;
	$franchiseCities[] = $franchise_city;
	$franchiseAddress[] = $franchise_address;
	$franchiseArea[] = $area;
	$franchiseRegion[] = $region;
	$franchiseAreaId[] = $areaId;
	$franchiseRegionId[] = $regionId;
}
echo json_encode(array("name"=>$franchiseNames,"id"=>$franchiseIds,"city"=>$franchiseCities,"areas"=>$franchiseArea,"regions"=>$franchiseRegion,"address"=>$franchiseAddress,"areaId"=>$franchiseAreaId,"regionId"=>$franchiseRegionId));
exit;
?>