<?php
require_once '../database/config.php';
$companyId = $_POST["company_id"];
$sql = "SELECT sum(TIMESTAMPDIFF(HOUR, tad_time_start, tad_time_close))/count(*) hours from complains where company_id = ? and complain_status = 'resolved'";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $companyId);
$stmt->execute();
$stmt->bind_result($avgTat);
while($stmt->fetch()){
	echo $avgTat;
}

$stmt->close();
?>