<?php

require_once '../database/config.php';

$barcode = explode(",", $_POST["barcode"]);
$quantity = explode(",", $_POST["quantity"]);
$franchiseId = $_POST["franchise"];

for ($i=0; $i < sizeof($barcode); $i++) { 
	$sql = "SELECT * from warehouse_inventory where item_barcode = ? and company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('ss', $barcode[$i], $_COOKIE["US-K"]);
	$stmt->execute();
	if (!$stmt->fetch()) {
		$stmt->close();
		die("One more violation and your liscene will be cancelled");
	}
	$stmt->close();
}

$errorsThrown = array();
$inventoryRecord = array();
for ($i=0; $i < sizeof($barcode); $i++) { 

	$sql = "SELECT item_barcode from to_be_accepted_inventory_temp where item_barcode = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('s', $barcode[$i]);
	$stmt->execute();
	if($stmt->fetch()){
		$stmt->close();
		$sql = "UPDATE to_be_accepted_inventory_temp set item_quantity = item_quantity + ? where item_barcode = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('is', $quantity[$i], $barcode[$i]);
		if ($stmt->execute()) {
			$stmt->close();
			$sql = "UPDATE warehouse_inventory set item_quantity = item_quantity - ? where item_barcode = ?";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('is', $quantity[$i], $barcode[$i]);
			$stmt->execute();
			$inventoryRecord[] = array(
				'barcode' => $barcode[$i],
				'quantity' => $quantity[$i]
				);
		}
		$stmt->close();
	}else{
		$stmt->close();
		$sql = "INSERT INTO `to_be_accepted_inventory_temp`(`item_barcode`, `item_name`, `item_brand`, `item_size`, `item_color`, `item_quantity`, `item_purchased_price`, `item_sale_price`, `item_expiry`, `discount_available`, `discount_active`, `franchise_id`, `company_id`, `category_id`) VALUES (?,(SELECT GROUP_CONCAT(item_name) from warehouse_inventory where item_barcode = ?),(SELECT GROUP_CONCAT(item_brand) from warehouse_inventory where item_barcode = ?),(SELECT GROUP_CONCAT(item_size) from warehouse_inventory where item_barcode = ?),(SELECT GROUP_CONCAT(item_color) from warehouse_inventory where item_barcode = ?),?,(SELECT GROUP_CONCAT(item_purchased_price) from warehouse_inventory where item_barcode = ?),(SELECT GROUP_CONCAT(item_sale_price) from warehouse_inventory where item_barcode = ?),(SELECT GROUP_CONCAT(item_expiry) from warehouse_inventory where item_barcode = ?),0,0,?,(SELECT GROUP_CONCAT(company_id) from employees_info where employee_username = (SELECT employee from employee_session where session = ?)),(SELECT GROUP_CONCAT(category_id) from warehouse_inventory where item_barcode = ?))";

		$stmt = $conn->prepare($sql);
		$stmt->bind_param('sssssisssiss', $barcode[$i], $barcode[$i], $barcode[$i], $barcode[$i], $barcode[$i], $quantity[$i], $barcode[$i], $barcode[$i], $barcode[$i], $franchiseId, $_COOKIE["US-K"], $barcode[$i]);
		if (!$stmt->execute()) {
			$errorsThrown[] = array(
				'barcode' => $barcode[$i],
				'error' => $stmt->error
				);
		}else{
			$stmt->close();
			$sql = "UPDATE warehouse_inventory set item_quantity = item_quantity - ? where item_barcode = ?";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('is', $quantity[$i], $barcode[$i]);
			$stmt->execute();
			$inventoryRecord[] = array(
				'barcode' => $barcode[$i],
				'quantity' => $quantity[$i]
				);
		}
		$stmt->close();
	}
}

if (sizeof($errorsThrown) <= 0) {
	$inventRecString = '';
	for($i = 0; $i < count($inventoryRecord); $i++) {
		$inventRecString .= implode(":", $inventoryRecord[$i]) . ', ';
	}
	$inventRecString = substr($inventRecString, 0, -2);
	$sql = "INSERT INTO `inventory_record`(`inventory`, `franchise_id`) VALUES (?,?)";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('si', $inventRecString, $franchiseId);
	if (!$stmt->execute()) {
		echo htmlspecialchars($stmt->error);
	}
}

echo json_encode($errorsThrown);

exit;
?>