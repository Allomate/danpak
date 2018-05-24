<?php

require_once '../database/config.php';

$campaignName = $_POST["campaignName"];
$campaignMessage = $_POST["campaignMessage"];
$campaignCity = $_POST["campaignCity"];
$campaignFranchise = $_POST["campaignCity"];
$schedule = $_POST["schedule"];
$campaignStatus = "0";
$campaign_started_at = "";
$campaign_ended_at = "";
if($schedule == "yes"){
	$campaignStatus = "1";
	$campaign_started_at = $_POST["start_date"];
	$campaign_ended_at = $_POST["end_date"];
}

$sql = "INSERT INTO `campaign_management`(`campaign_name`, `campaign_text`, `campaign_city`, `campaign_started_at`, `campaign_ended_at`, `campaign_status`) VALUES (?,?,?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssssi', $campaignName, $campaignMessage, $campaignCity, $campaign_started_at, $campaign_ended_at, $campaignStatus);
if($stmt->execute()){
	$stmt->close();
	setcookie('compaign_added', 'true', time() + (86400 * 30), "/");
	$hostLink = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
	header('Location: '.$hostLink.'/add_campaign.php');
}
else
	die(htmlspecialchars($stmt->error));

exit;
?>