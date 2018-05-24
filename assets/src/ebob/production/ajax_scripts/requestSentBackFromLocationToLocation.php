<?php

require_once '../database/config.php';

$itemBarcode = $_POST["barcode"];
$requestedFromFranchise = $_POST["requested_from_franchise"];
$modified = date('Y:m:d H:m:s');

$sql = "SELECT id, item_sent_from_location from `requested_from_location_to_location_inventory` WHERE item_barcode = ? and item_sent_from_location = 0";
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

$sql = "UPDATE `requested_from_location_to_location_inventory` SET `item_sent_from_location`= 1, `modified_at` = ? WHERE item_barcode = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $modified, $itemBarcode);
if(!$stmt->execute())
	die("At line 28: " . htmlspecialchars($stmt->error));
else{
	$stmt->close();
	$sql = "UPDATE location_based_inventory set item_quantity = item_quantity - (SELECT item_quantity from requested_from_location_to_location_inventory where id = ?) where item_barcode = ? and franchise_id = (SELECT franchise_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('iss', $rowId, $itemBarcode, $_COOKIE["US-K"]);
	if(!$stmt->execute())
		die("At line 34: " . htmlspecialchars($stmt->error));
	else{
		$stmt->close();
		$sql = "SELECT item_barcode from to_be_accepted_inventory_temp where item_barcode = ? and franchise_id = (SELECT franchise_id from franchise_info where franchise_name = ?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('ss', $itemBarcode, $requestedFromFranchise);
		$stmt->execute();
		if (!$stmt->fetch()) {
			$stmt->close();
			$sql = "INSERT INTO `to_be_accepted_inventory_temp`(`item_barcode`, `item_name`, `item_brand`, `item_size`, `item_color`, `item_quantity`, `item_purchased_price`, `item_sale_price`, `item_expiry`, `franchise_id`, `company_id`, `category_id`) SELECT `item_barcode`, `item_name`, `item_brand`, `item_size`, `item_color`, (SELECT item_quantity from requested_from_location_to_location_inventory where id = ?), `item_purchased_price`, `item_sale_price`, `item_expiry`, (SELECT from_franchise from requested_from_location_to_location_inventory where id = ?), `company_id`, `category_id` FROM `location_based_inventory` where item_barcode = ? and franchise_id = (SELECT franchise_id from franchise_info where franchise_name = ?)";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('iiss', $rowId, $rowId, $itemBarcode, $requestedFromFranchise);
			if (!$stmt->execute()) {
				die("At line 48: " . htmlspecialchars($stmt->error));
			}else{
				echo "Success";
			}
		}else{
			$stmt->close();
			$sql = "UPDATE `to_be_accepted_inventory_temp` set `item_quantity` = item_quantity + (SELECT item_quantity from requested_from_location_to_location_inventory where id = ?) where item_barcode = ?";
			echo $sql . "<br>" . $itemBarcode;
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('is', $rowId, $itemBarcode);
			if (!$stmt->execute()) {
				die("At line 59: " . htmlspecialchars($stmt->error));
			}else{
				echo "Success";
			}
		}
	}
}
exit;
?>