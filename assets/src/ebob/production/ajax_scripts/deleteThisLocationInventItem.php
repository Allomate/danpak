<?php

require_once '../database/config.php';

$itemId = $_POST["id"];

$sql = "DELETE from location_based_inventory where item_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $itemId);
if($stmt->execute()){
	echo "Deleted";
}
else
	die(htmlspecialchars($stmt->error));

exit;
?>