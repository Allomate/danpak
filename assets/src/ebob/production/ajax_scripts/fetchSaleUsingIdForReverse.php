<?php

require_once '../database/config.php';

$saleId = $_POST["saleId"];

$sql = "SELECT `sale_id`, (SELECT item_barcode from location_based_inventory where item_id = sm.item_id) as barcode, (SELECT item_name from location_based_inventory where item_id = sm.item_id) as item_name, `item_quantity`, `item_price_each`, `item_final_price`, `item_discount`, `sold_to`, `sold_by`, `sale_token`, `sold_at` FROM `sales_management` sm WHERE sale_id = ? and franchise_id = (SELECT franchise_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
$stmt = $conn->prepare($sql);
$stmt->bind_param('is', $saleId, $_COOKIE["US-K"]);
$stmt->execute();
$stmt->bind_result($sale_id, $barcode, $item_name, $item_quantity, $item_price_each, $item_final_price, $item_discount, $sold_to, $sold_by, $sale_token, $sold_at);
while ($stmt->fetch()) {
	$soldInventory = array(
		'sale_id'=>$sale_id,
		'barcode'=>$barcode,
		'item_name'=>$item_name,
		'item_quantity'=>$item_quantity,
		'item_price_each'=>$item_price_each,
		'item_final_price'=>$item_final_price,
		'item_discount'=>$item_discount,
		'sold_to'=>$sold_to,
		'sold_by'=>$sold_by,
		'sale_token'=>$sale_token,
		'sold_at'=>$sold_at
	);
}
$stmt->close();
die(json_encode($soldInventory));
?>