<?php
require_once '../database/config.php';
$companyId = $_POST["companyId"];
$sql = "SELECT complain_status, count(complain_status) status from complains where company_id = ? group by complain_status";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $companyId);
$stmt->execute();
$stmt->bind_result($status, $numberOfComplains);
$details = array();
$pendingAcquired = false;
$resolvedAcquired = false;
if($stmt->fetch()){
	while($stmt->fetch()){
		if($status == "pending"){
			$details[] = array(
				'status' => $status,
				'complains' => $numberOfComplains
				);
			$pendingAcquired = true;
		}else if($status == "resolved"){
			$details[] = array(
				'status' => $status,
				'complains' => $numberOfComplains
				);
			$resolvedAcquired = true;
		}
	}

	if(!$pendingAcquired){
		$details[] = array(
			'status' => 'pending',
			'complains' => 0
			);
	}else if(!$resolvedAcquired){
		$details[] = array(
			'status' => 'resolved',
			'complains' => 0
			);
	}
}else{
	$details[] = array(
		'status' => 'pending',
		'complains' => '0'
		);
	$details[] = array(
		'status' => 'resolved',
		'complains' => '0'
		);
}
echo json_encode($details);
exit;
?>