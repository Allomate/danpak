<?php
require_once '../database/config.php';

$sql = "SELECT `id`, `item_barcode`, `item_name`, `item_color`, `item_size`, `item_quantity`, `item_sent_from_location`, `item_recieved`, (SELECT franchise_name from franchise_info where franchise_id = lir.from_franchise) as from_franchise, (SELECT franchise_name from franchise_info where franchise_id = lir.to_franchise) as to_franchise , date(created_at), DATE_FORMAT(created_at, '%r'), `modified_at`, (SELECT item_quantity from location_based_inventory where item_barcode = lir.item_barcode and franchise_id = (SELECT franchise_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))) as stock_item_quantity FROM `requested_from_location_to_location_inventory` lir WHERE to_franchise = (SELECT franchise_id from  employees_info where employee_username = (SELECT employee from employee_session where session = ?))";

$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $_COOKIE["US-K"], $_COOKIE["US-K"]);
$stmt->execute();
$stmt->bind_result($id, $barcode, $name, $color, $size, $quantity, $sent, $recieved, $from_franchise, $to_franchise, $createdAt, $time, $modifiedAt, $stock_item_quantity);
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
		'from_franchise' => $from_franchise,
		'to_franchise' => $to_franchise,
		'warehouseStock' => (($stock_item_quantity == 'null' || $stock_item_quantity == null) ? '0' : $stock_item_quantity )
		);
}
$stmt->close();
die(json_encode($inventory));
?>