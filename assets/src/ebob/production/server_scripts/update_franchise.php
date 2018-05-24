<?php

require_once '../database/config.php';

$franchiseName = $_POST["locationName"];
$franchiseCity = $_POST["locationCity"];
$locationArea = $_POST["locationArea"];
$locationRegion = $_POST["locationRegion"];
$franchiseAddress = $_POST["locationAddress"];
$companyId = $_POST["locationId"];

$sql = "UPDATE `franchise_info`set `franchise_name` = ?, `franchise_city` = ?, `franchise_region` = ?, `franchise_area` = ?, `franchise_address` = ? where franchise_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssiisi', $franchiseName, $franchiseCity, $locationRegion, $locationArea, $franchiseAddress, $companyId);
if($stmt->execute()){
	$stmt->close();
	$hostLink = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
	header('Location: '.$hostLink.'/update_company.php');
}
else
	die(htmlspecialchars($stmt->error));

exit;
?>