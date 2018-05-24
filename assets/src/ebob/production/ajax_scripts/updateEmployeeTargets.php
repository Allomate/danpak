<?php

require_once '../database/config.php';

$criteria = $_POST["criteria"];
$definition = $_POST["definition"];
$target_sale = $_POST["target_sale"];
$targets = $_POST["targets"];
$percentages = $_POST["percentages"];
$id = $_POST["id"];

$sql = "UPDATE `employee_targets` set criteria = ?, targets = ?, targets_percentage = ?, quarter = ?, target_sale_amount = ? where id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssssii', $criteria, $targets, $percentages, $definition, $target_sale, $id);
if($stmt->execute()){
	echo "Updated";
}
else
	die(htmlspecialchars($stmt->error));

exit;
?>