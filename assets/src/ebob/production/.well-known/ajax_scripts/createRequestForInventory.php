<?php

require_once '../database/config.php';

$required = $_POST["required"];
$barcode = $_POST["barcode"];
$name = $_POST["name"];
$size = $_POST["size"];
$color = $_POST["color"];

$sql = "SELECT id, item_barcode from location_inventory_requests where item_barcode = ? and item_sent_from_warehouse = 0";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $barcode);
$stmt->execute();
$rowId = 0;
$stmt->bind_result($id, $itemBarcode);
if ($stmt->fetch()) {
	$rowId = $id;
	$stmt->close();
	$sql = "UPDATE `location_inventory_requests` set `item_quantity` = item_quantity + ? where id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('ii', $required, $rowId);
	if ($stmt->execute()) {
		echo "Success";
	}
	else
		die("At line 27: ".htmlspecialchars($stmt->error));
}else{
	$sql = "INSERT INTO `location_inventory_requests`(`item_barcode`, `item_name`, `item_color`, `item_size`, `item_quantity`, `item_recieved`, `franchise_id`) VALUES (?,?,?,?,?,0, ( SELECT franchise_id from employees_info where employee_username = ( SELECT employee from employee_session where session = ?)))";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('ssssis', $barcode, $name, $color, $size, $required, $_COOKIE["US-K"]);
	if ($stmt->execute()) {
		echo "Success";
	}
	else
		die("At line 36: ".htmlspecialchars($stmt->error));
}

exit;
?>