<?php

require_once '../database/config.php';

$required = $_POST["required"];
$barcode = $_POST["barcode"];
$name = $_POST["name"];
$size = $_POST["size"];
$color = $_POST["color"];
$franchiseId = $_POST["toFranchise"];

$sql = "SELECT id, item_barcode from requested_from_location_to_location_inventory where item_barcode = ? and item_sent_from_location = 0 and from_franchise = (SELECT franchise_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)) and to_franchise = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssi', $barcode, $_COOKIE["US-K"], $franchiseId);
$stmt->execute();
$rowId = 0;
$stmt->bind_result($id, $itemBarcode);
if ($stmt->fetch()) {
	$rowId = $id;
	$stmt->close();
	$sql = "UPDATE `requested_from_location_to_location_inventory` set `item_quantity` = item_quantity + ? where id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('ii', $required, $rowId);
	if ($stmt->execute()) {
		echo "Success";
	}
	else
		die("At line 27: ".htmlspecialchars($stmt->error));
}else{
	$sql = "INSERT INTO `requested_from_location_to_location_inventory`(`item_barcode`, `item_name`, `item_color`, `item_size`, `item_quantity`, `item_recieved`, `from_franchise`, `to_franchise`) VALUES (?,?,?,?,?,0, ( SELECT franchise_id from employees_info where employee_username = ( SELECT employee from employee_session where session = ?)), ?)";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('ssssisi', $barcode, $name, $color, $size, $required, $_COOKIE["US-K"], $franchiseId);
	if ($stmt->execute()) {
		echo "Success";
	}
	else
		die("At line 36: ".htmlspecialchars($stmt->error));
}

exit;
?>