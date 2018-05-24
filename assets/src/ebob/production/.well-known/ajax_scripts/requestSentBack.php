<?php

require_once '../database/config.php';

$itemBarcode = $_POST["barcode"];
$modified = date('Y:m:d H:m:s');

$sql = "SELECT id, item_sent_from_warehouse from `location_inventory_requests` WHERE item_barcode = ? and item_sent_from_warehouse = 0";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $itemBarcode);
$stmt->execute();
$stmt->bind_result($id, $isSent);
$rowId = 0;
if ($stmt->fetch()) {
	$rowId = $id;
	if ($isSent == 1 || $isSent == "1") {
		echo "Already-Updated";
		die;
	}
}	
$stmt->close();

$sql = "UPDATE `location_inventory_requests` SET `item_sent_from_warehouse`= 1, `modified_at` = ? WHERE item_barcode = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $modified, $itemBarcode);
if(!$stmt->execute())
	die("At line 27: " . htmlspecialchars($stmt->error));
else{
	$stmt->close();
	$sql = "UPDATE warehouse_inventory set item_quantity = item_quantity - (SELECT item_quantity from location_inventory_requests where id = ?) where item_barcode = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('is', $rowId, $itemBarcode);
	if(!$stmt->execute())
		die("At line 34: " . htmlspecialchars($stmt->error));
	else{
		$stmt->close();
		$sql = "SELECT item_barcode from to_be_accepted_inventory_temp where item_barcode = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('s', $itemBarcode);
		$stmt->execute();
		if (!$stmt->fetch()) {
			$stmt->close();
			$sql = "INSERT INTO `to_be_accepted_inventory_temp`(`item_barcode`, `item_name`, `item_brand`, `item_size`, `item_color`, `item_quantity`, `item_purchased_price`, `item_sale_price`, `item_expiry`, `franchise_id`, `company_id`, `category_id`) SELECT `item_barcode`, `item_name`, `item_brand`, `item_size`, `item_color`, (SELECT item_quantity from location_inventory_requests where id = ?), `item_purchased_price`, `item_sale_price`, `item_expiry`, (SELECT franchise_id from location_inventory_requests where id = ?), `company_id`, `category_id` FROM `warehouse_inventory` where item_barcode = ?";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('iis', $rowId, $rowId, $itemBarcode);
			if (!$stmt->execute()) {
				die("At line 47: " . htmlspecialchars($stmt->error));
			}else{
				echo "Success";
			}
		}else{
			$stmt->close();
			$sql = "UPDATE `to_be_accepted_inventory_temp` set `item_quantity` = item_quantity + (SELECT item_quantity from location_inventory_requests where id = ?) where item_barcode = ?";
			echo $sql . "<br>" . $itemBarcode;
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('is', $rowId, $itemBarcode);
			if (!$stmt->execute()) {
				die("At line 57: " . htmlspecialchars($stmt->error));
			}else{
				echo "Success";
			}
		}
	}
}
exit;
?>