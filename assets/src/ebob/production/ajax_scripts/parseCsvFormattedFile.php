<?php

require '../database/config.php';
$uploadedFileName = $_FILES["csvSheet"]["name"];
$fileType = $_FILES["csvSheet"]["type"];
$fileSize = $_FILES["csvSheet"]["size"] / 1024;

if ($fileType != "application/vnd.ms-excel") {
	die("filetype");
}

$sql = "SELECT item_barcode from warehouse_inventory where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $_COOKIE["US-K"]);
$itemBarcodes = array();
$stmt->execute();
$stmt->bind_result($item_barcode);
while ($stmt->fetch()) {
	$itemBarcodes[] = $item_barcode;
}
$stmt->close();

$tmpName = $_FILES["csvSheet"]["tmp_name"];
$csvAsArray = array_map('str_getcsv', file($tmpName));
unset($csvAsArray[0]);
$csvAsArray = array_values($csvAsArray);
$errorsThrown = array();
foreach ($csvAsArray as $value) {
	$barcode = $value[0];
	$name = $value[1];
	$brand = $value[2];
	$purchase = $value[3];
	if (!is_numeric($purchase)) {
		$errorsThrown[] = array(
			'barcode'=> $barcode,
			'error'=> 'Purchase price should be numeric'
			);
		continue;
	}
	$sale = $value[4];
	if (!is_numeric($sale)) {
		$errorsThrown[] = array(
			'barcode'=> $barcode,
			'error'=> 'Sale price should be numeric'
			);
		continue;
	}
	$color = $value[5];
	$size = $value[6];
	$quantity = $value[7];
	if (!is_numeric($quantity)) {
		$errorsThrown[] = array(
			'barcode'=> $barcode,
			'error'=> 'Quantity should be numeric'
			);
		continue;
	}
	$expiry = $value[8];
	$warehouse = $value[9];
	$description = $value[10];

	$sql = "SELECT warehouse_id from warehouse where lower(warehouse_code) = lower(?) and company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('ss', $warehouse, $_COOKIE["US-K"]);
	$stmt->execute();
	if (!$stmt->fetch()) {
		$errorsThrown[] = array(
			'barcode'=> $barcode,
			'error'=> 'Warehouse Code is incorrect'
			);
		continue;
	}
	$stmt->close();

	if (in_array($barcode, $itemBarcodes)) {
		$sql = "UPDATE `warehouse_inventory` set `item_name` = ?, `item_brand` = ?, `item_size` = ?, `item_color` = ?, `item_quantity` = item_quantity + ?, `item_purchased_price` = ?, `item_sale_price` = ?, `item_expiry` = ?, `warehouse_id` = ?, `item_description` = ? where `item_barcode` = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('ssssiiisiss', $name, $brand, $size, $color, $quantity, $purchase, $sale, $expiry, $warehouse, $description, $barcode);
		if (!$stmt->execute()) {
			$errorsThrown[] = array(
				'barcode'=> $barcode,
				'error'=> htmlspecialchars($stmt->error)
				);
		}
		$stmt->close();
	}else{
		$sql = "INSERT INTO `warehouse_inventory`(`item_barcode`, `item_name`, `item_brand`, `item_size`, `item_color`, `item_quantity`, `item_purchased_price`, `item_sale_price`, `item_expiry`, `item_description`, `warehouse_id`, `company_id`) VALUES (?,?,?,?,?,?,?,?,?,?,(SELECT warehouse_id from warehouse where warehouse_name = ?),(SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)))";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('sssssiiissss', $barcode, $name, $brand, $size, $color, $quantity, $purchase, $sale, $expiry, $description, $warehouse, $_COOKIE["US-K"]);
		if (!$stmt->execute()) {
			$errorsThrown[] = array(
				'barcode'=> $barcode,
				'error'=> htmlspecialchars($stmt->error)
				);
		}
		$stmt->close();
	}
}
die(json_encode($errorsThrown));
?>