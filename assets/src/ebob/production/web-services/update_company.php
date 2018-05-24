<?php

require_once '../database/config.php';

$companyName = $_POST["companyName"];
$companyId = $_POST["companyId"];

$sql = "UPDATE `company_info` set `company_name` = ? where `company_id` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $companyName, $companyId);
if($stmt->execute()){
	$stmt->close();
	$hostLink = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
	header('Location: '.$hostLink.'/update_company.php');
}
else
	die(htmlspecialchars($stmt->error));

exit;
?>