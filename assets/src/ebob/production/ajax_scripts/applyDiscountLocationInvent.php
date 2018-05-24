<?php

require_once '../database/config.php';

$itemId = $_POST["id"];
$discount = $_POST["discount"];

$sql = "UPDATE location_based_inventory set discount_available = ?, discount_active = 1 where item_id = ?";
if ($discount == "0") {
	$sql = "UPDATE location_based_inventory set discount_available = ?, discount_active = 0 where item_id = ?";
}
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $discount, $itemId);
if ($stmt->execute()) {
	echo "Success";
}else{
	echo htmlspecialchars($stmt->error);
}

exit;
?>