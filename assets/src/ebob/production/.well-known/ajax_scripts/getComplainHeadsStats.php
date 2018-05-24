<?php
require_once '../database/config.php';
$companyId = $_POST["companyId"];
$sql = "SELECT (SELECT complain_head from complain_heads where id = com.head_id) as heads, count(head_id) as total from complains com where company_id = ? group by head_id";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $companyId);
$stmt->execute();
$stmt->bind_result($heads, $total);
$headsTotals = array();
while($stmt->fetch()){
	$headsTotals[] = array(
		'head' => $heads,
		'total' => $total
		);
}
echo json_encode($headsTotals);
exit;
?>