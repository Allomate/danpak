<?php

require_once '../database/config.php';

$franchiseName = $_POST["franchiseName"];
$franchiseCity = $_POST["franchiseCity"];
$franchiseAddress = $_POST["franchiseAddress"];
$companyId = $_POST["companyId"];
$locationArea = $_POST["franchiseLocation"];
$locationRegion = $_POST["locationRegion"];

$sql = "INSERT INTO `franchise_info`(`franchise_name`, `franchise_city`, `franchise_address`, `company_id`, `franchise_region`, `franchise_area`) VALUES (?,?,?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssiii', $franchiseName, $franchiseCity, $franchiseAddress, $companyId, $locationRegion, $locationArea);
if($stmt->execute()){
	$stmt->close();
	$hostLink = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
	header('Location: '.$hostLink.'/add_franchise.php');
}
else
	die(htmlspecialchars($stmt->error));

exit;
?>