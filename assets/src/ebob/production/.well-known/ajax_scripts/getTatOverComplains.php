<?php
require_once '../database/config.php';
$companyId = $_POST["company_id"];
$sql = "SELECT count(*) from complains WHERE company_id = ? and TIMESTAMPDIFF(HOUR, tad_time_start, CURRENT_TIMESTAMP) > (SELECT tat_time_hrs from tat_time_management where company_id = ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $companyId, $companyId);
$stmt->execute();
$stmt->bind_result($tatOverComplains);
while($stmt->fetch()){
	echo $tatOverComplains;
}

$stmt->close();
?>