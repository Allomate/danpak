<?php
require_once '../database/config.php';

$sql = "SELECT `id`, `item_barcode`, `item_name`, `item_color`, `item_size`, `item_quantity`, `item_sent_from_warehouse`, `item_recieved`, (SELECT franchise_name from franchise_info where franchise_id = lir.franchise_id) as franchise, date(created_at), DATE_FORMAT(created_at, '%r'), `modified_at`, (SELECT item_quantity from warehouse_inventory where item_barcode = lir.item_barcode) as stock_item_quantity FROM `location_inventory_requests` lir WHERE franchise_id IN (SELECT franchise_id from franchise_info where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)))";

$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $_COOKIE["US-K"]);
$stmt->execute();
$stmt->bind_result($id, $barcode, $name, $color, $size, $quantity, $sent, $recieved, $franchise, $createdAt, $time, $modifiedAt, $stock_item_quantity);
$inventory = array();
while ($stmt->fetch()) {
	$inventory[] = array(
		'id' => $id,
		'barcode' => $barcode,
		'name' => $name,
		'size' => $size,
		'color' => $color,
		'quantity' => $quantity,
		'createdOn' => $createdAt,
		'sent' => $sent,
		'recieved' => $recieved,
		'modified' => $modifiedAt,
		'time' => $time,
		'franchise' => $franchise,
		'warehouseStock' => $stock_item_quantity
		);
}
$stmt->close();
die(json_encode($inventory));
?>