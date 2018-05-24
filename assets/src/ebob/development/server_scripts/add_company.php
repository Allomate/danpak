<?php

require_once '../database/config.php';

$companyName = $_POST["companyName"];
$companyCountry = "Pakistan";

$sql = "INSERT INTO `company_info`(`company_name`, `company_country`) VALUES (?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $companyName, $companyCountry);
if($stmt->execute()){
	$stmt->close();
	setcookie('company_added', 'true', time() + (86400 * 30), "/");
	$hostLink = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
	header('Location: '.$hostLink.'/add_company.php');
}
else
	die(htmlspecialchars($stmt->error));

exit;
?>