<?php
require_once '../database/config.php';

$employee = $_POST["employee"];
$criteria = $_POST["criteria"];
$definition = $_POST["definition"];
$currYear = date('Y');

$sql = "SELECT id, targets, targets_percentage, target_sale_amount, created_at from employee_targets where employee_id = ? and criteria = ? and quarter = ? and EXTRACT(YEAR from created_at) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('isss', $employee, $criteria, $definition, $currYear);
$stmt->execute();
$stmt->bind_result($id, $targets, $percentage, $targetSale, $createdAt);
$details = array();
while($stmt->fetch()){
	$details = array(
		'id' => $id,
		'targets' => $targets,
		'sale' => $targetSale,
		'percentage' => $percentage,
		'createdAt' => $createdAt
		);
}
echo json_encode($details);
exit;
?>