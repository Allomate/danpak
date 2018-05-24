<?php
require_once '../database/config.php';

$complainHead = $_POST["complainHead"];
$level = $_POST["level"];

if($level == "2"){
	
	$sql = "SELECT id, complain_subhead from complain_subhead where complain_head_id = ? and parent_subhead_id = 0";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('i', $complainHead);
	$stmt->execute();
	$stmt->bind_result($id, $complain_subhead);
	$complainSubHead = array();
	while($stmt->fetch()){
		$complainSubHead[] = array(
			'id' => $id,
			'subhead' => $complain_subhead
			);
	}
}else if($level == "3"){

	$complainHeadLevel1 = $_POST["complainHeadLevel1"];
	$sql = "SELECT id, complain_subhead from complain_subhead where complain_head_id = ? and parent_subhead_id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('ii', $complainHead, $complainHeadLevel1);
	$stmt->execute();
	$stmt->bind_result($id, $complain_subhead);
	$complainSubHead = array();
	while($stmt->fetch()){
		$complainSubHead[] = array(
			'id' => $id,
			'subhead' => $complain_subhead
			);
	}
}

echo json_encode($complainSubHead);
exit;
?>