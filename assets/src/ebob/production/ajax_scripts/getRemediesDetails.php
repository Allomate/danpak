<?php
require_once '../database/config.php';
$empId = $_POST["employee"];
$sql = "SELECT count(*) from counter_deals where employee_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $empId);
$stmt->execute();
$stmt->bind_result($total);
$stmt->fetch();
$totalDeals = $total;
$stmt->close();

$sql = "SELECT count(discount) from counter_deals where employee_id = ? and discount != 0";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $empId);
$stmt->execute();
$stmt->bind_result($discounts);
$stmt->fetch();
$totalDiscounts = $discounts;
$stmt->close();

$sql = "SELECT count(reward_points) from counter_deals where employee_id = ? and reward_points != 0";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $empId);
$stmt->execute();
$stmt->bind_result($reward_points);
$stmt->fetch();
$rewards = $reward_points;
$stmt->close();

$details = array(
	'total' => $totalDeals,
	'discounts' => $totalDiscounts,
	'rewards' => $rewards
	);

echo json_encode($details);
exit();
?>