<?php
require_once '../database/config.php';
$employee = $_POST["empId"];
$sql = "SELECT sum(discount), sum(reward_points), DATE(created_at) FROM `counter_deals` where employee_id = ? group by MONTHNAME(created_at)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $employee);
$stmt->execute();
$stmt->bind_result($discount, $reward_points, $date);
$detals = array();
while($stmt->fetch()){
	$detals[] = array(
		'discount' => $discount,
		'rewards' => $reward_points,
		'date' => $date,
		);
}
echo json_encode($detals);
exit;
?>