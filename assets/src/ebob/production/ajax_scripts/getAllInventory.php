<?php
require_once '../database/config.php';

if (!isset($_POST["location"])) {
	die("Get out");
}

$inventoryLocation = $_POST["location"];

$sql = "SELECT item_id, item_barcode, item_name, item_size, item_color, item_quantity, created_at from warehouse_inventory where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)) order by item_name";

if ($inventoryLocation == "true") {
	$sql = "SELECT item_id, item_barcode, item_name, item_size, item_color, item_quantity, discount_available, discount_active, created_at from location_based_inventory where franchise_id = (SELECT franchise_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)) order by item_name";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('s', $_COOKIE["US-K"]);
	$stmt->execute();
	$stmt->bind_result($id, $barcode, $name, $size, $color, $quantity, $discount_available, $discount_active, $createdOn);
	$inventory = array();
	while ($stmt->fetch()) {
		$inventory[] = array(
			'id' => $id,
			'barcode' => $barcode,
			'name' => $name,
			'size' => $size,
			'color' => $color,
			'quantity' => $quantity,
			'createdOn' => $createdOn,
			'discount_available' => $discount_available,
			'discount_active' => $discount_active
		);
	}
	$stmt->close();
	die(json_encode($inventory));
}

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