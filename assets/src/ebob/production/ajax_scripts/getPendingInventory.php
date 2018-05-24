<?php
require_once '../database/config.php';

$sql = "SELECT item_id, item_barcode, item_name, item_size, item_color, item_quantity, created_at from to_be_accepted_inventory_temp where franchise_id = (SELECT franchise_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)) order by item_name";	
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $_COOKIE["US-K"]);
$stmt->execute();
$stmt->bind_result($id, $barcode, $name, $size, $color, $quantity, $createdOn);
$inventory = array();
while ($stmt->fetch()) {
	$inventory[] = array(
		'id' => $id,
		'barcode' => $barcode,
		'name' => $name,
		'size' => $size,
		'color' => $color,
		'quantity' => $quantity,
		'createdOn' => $createdOn
		);
}
$stmt->close();
die(json_encode($inventory));
?>