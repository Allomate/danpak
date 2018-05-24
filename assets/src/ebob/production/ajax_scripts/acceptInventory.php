<?php

require_once '../database/config.php';

$errorsThrown = array();
$barcode = explode(",", $_POST["barcode"]);
for ($i=0; $i < sizeof($barcode); $i++) { 
	$sql = "SELECT item_id from location_based_inventory where item_barcode = ? and franchise_id = (SELECT franchise_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('ss', $barcode[$i], $_COOKIE["US-K"]);
	$stmt->execute();
	$stmt->bind_result($item_id);
	if ($stmt->fetch()) {
		$itemId = $item_id;
		$stmt->close();
		$sql = "UPDATE location_based_inventory set item_quantity = item_quantity + (SELECT item_quantity from to_be_accepted_inventory_temp where item_barcode = ? and franchise_id = (SELECT franchise_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))) where item_id = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('ssi', $barcode[$i], $_COOKIE["US-K"], $itemId);
		if (!$stmt->execute()) {
			$errorsThrown[] = array(
				'barcode' => $barcode[$i],
				'error' => $stmt->error,
				'reason' => 'Unable to update location based inventory table for new entry to merge in existing item_quantity line # 23'
				);
		}else{
			$stmt->close();
			$sql = "DELETE from `to_be_accepted_inventory_temp` where item_barcode = ?";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('s', $barcode[$i]);
			if (!$stmt->execute()) {
				$errorsThrown[] = array(
					'barcode' => $barcode[$i],
					'error' => $stmt->error,
					'reason' => 'Unable to remove entry from to be accepted inventory temp table line # 34'
					);
			}else{
				$stmt->close();
				$sql = "UPDATE `location_inventory_requests` set item_recieved = 1 where item_barcode = ?;";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('s', $barcode[$i]);
				$stmt->execute();
				$stmt->close();
				$sql = "UPDATE `requested_from_location_to_location_inventory` set item_recieved = 1 where item_barcode = ?";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('s', $barcode[$i]);
				$stmt->execute();
			}
		}
		$stmt->close();
	}else{
		$sql = "INSERT INTO `location_based_inventory`(`item_barcode`, `item_name`, `item_brand`, `item_size`, `item_color`, `item_quantity`, `item_purchased_price`, `item_sale_price`, `item_expiry`, `item_image`, `discount_available`, `discount_active`, `franchise_id`, `company_id`, `category_id`) SELECT `item_barcode`, `item_name`, `item_brand`, `item_size`, `item_color`, `item_quantity`, `item_purchased_price`, `item_sale_price`, `item_expiry`, (SELECT item_image from warehouse_inventory where item_barcode = ?), `discount_available`, `discount_active`, `franchise_id`, `company_id`, `category_id` FROM `to_be_accepted_inventory_temp` where item_barcode = ? and franchise_id = (SELECT franchise_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('sss', $barcode[$i], $barcode[$i], $_COOKIE["US-K"]);
		if (!$stmt->execute()) {
			$errorsThrown[] = array(
				'barcode' => $barcode[$i],
				'error' => $stmt->error,
				'reason' => 'Unable to insert data in location_based_inventory line # 53'
				);
		}else{
			$stmt->close();
			$sql = "DELETE from `to_be_accepted_inventory_temp` where item_barcode = ? and franchise_id = (SELECT franchise_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('ss', $barcode[$i], $_COOKIE["US-K"]);
			if (!$stmt->execute()) {
				$errorsThrown[] = array(
					'barcode' => $barcode[$i],
					'error' => $stmt->error,
					'reason' => 'Unable to remove entry from to be accepted inventory temp table line # 64'
					);
			}else{
				$stmt->close();
				$sql = "UPDATE `location_inventory_requests` set item_recieved = 1 where item_barcode = ? and franchise_id = (SELECT franchise_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?));";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('ss', $barcode[$i], $_COOKIE["US-K"]);
				$stmt->execute();
				$stmt->close();
				$sql = "UPDATE `requested_from_location_to_location_inventory` set item_recieved = 1 where item_barcode = ? and to_franchise = (SELECT franchise_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('ss', $barcode[$i], $_COOKIE["US-K"]);
				$stmt->execute();
			}
		}
		$stmt->close();
	}
}

die(json_encode($errorsThrown));

?>