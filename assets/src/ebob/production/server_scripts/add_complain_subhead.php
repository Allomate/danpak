<?php
require_once '../database/config.php';

$complainHead = $_POST["complainHead"];
$level = $_POST["level"];

if($level == "1"){
	$complainSubHead = $_POST["complainSubHeadLevel1"];
	$parentSubHeadId = 0;
	$sql = "INSERT INTO `complain_subhead`(`complain_subhead`, `complain_head_id`, `parent_subhead_id`, `level`) VALUES (?,?,?,?)";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('siii', $complainSubHead, $complainHead, $parentSubHeadId, $level);
	$stmt->execute();
} else if($level == "2"){
	$complainSubHeadLevel1 = $_POST["complainSubHeadLevel1"];
	$complainSubHead = $_POST["complainSubHeadLevel2"];
	$sql = "INSERT INTO `complain_subhead`(`complain_subhead`, `complain_head_id`, `parent_subhead_id`, `level`) VALUES (?,?,?,?)";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('siii', $complainSubHead, $complainHead, $complainSubHeadLevel1, $level);
	$stmt->execute();
}else{
	$complainSubHead = $_POST["complainSubHeadLevel3"];
	$complainSubHeadLevel2 = $_POST["complainSubHeadLevel2"];
	$sql = "INSERT INTO `complain_subhead`(`complain_subhead`, `complain_head_id`, `parent_subhead_id`, `level`) VALUES (?,?,?,?)";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('siii', $complainSubHead, $complainHead, $complainSubHeadLevel2, $level);
	$stmt->execute();
}

$hostLink = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
header('Location: '.$hostLink.'/complain_heads.php');
exit;
?>