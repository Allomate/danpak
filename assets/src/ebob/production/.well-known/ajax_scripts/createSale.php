<?php

require_once '../database/config.php';

$token = mt_rand(1000000000, mt_getrandmax());
$sold_at = date('Y:m:d H:m:s');
$sold_by = $_POST["sold_by"];
$sold_to = $_POST["customerPhone"];
$data = $_POST["cart"];

$sql = "SELECT min(sale_token) as tokens FROM `sales_management` where franchise_id = (SELECT franchise_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)) group by sale_token";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $_COOKIE["US-K"]);
$stmt->execute();
$stmt->bind_result($tokens);
$existingTokens = array();
while ($stmt->fetch()) {
	$existingTokens[] = $tokens;
}
$stmt->close();

$distinct = false;
$j = 0;

while (!$distinct) {
	if (in_array($token, $existingTokens)) {
		$token = mt_rand(1000000000, mt_getrandmax());
	}else{
		$distinct = true;
	}
}

for ($i=0; $i < sizeof(json_decode($data, true)); $i++) { 
	$item_id = json_decode($data, true)[$i]["id"];
	$item_quantity = json_decode($data, true)[$i]["quantitySold"];
	$item_final_price = json_decode($data, true)[$i]["finalPrice"];
	$item_discount = json_decode($data, true)[$i]["discount"];
	$item_price_each = json_decode($data, true)[$i]["itemSell"];

	if ($sold_by == "none" || $sold_by == "") {
		$sql = "INSERT INTO `sales_management`(`item_id`, `item_quantity`, `item_price_each`, `item_final_price`, `item_discount`, `sold_to`, `sold_by`, `sale_token`, `franchise_id`, `sold_at`) VALUES (?,?,?,?,?,?,(SELECT employee_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)),?, (SELECT franchise_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)) ,?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('iiiiisssss', $item_id, $item_quantity, $item_price_each, $item_final_price, $item_discount, $sold_to, $_COOKIE["US-K"], $token, $_COOKIE['US-K'], $sold_at);
		if($stmt->execute()){
			$stmt->close();
			$sql = "UPDATE location_based_inventory set item_quantity = item_quantity - ? where item_id = ?";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('ii', $item_quantity, $item_id);
			if (!$stmt->execute())
				die("Line#49 : " . htmlspecialchars($stmt->error));
		}
		else
			die("Line#52 : " . htmlspecialchars($stmt->error));
	}else{
		$sql = "INSERT INTO `sales_management`(`item_id`, `item_quantity`, `item_price_each`, `item_final_price`, `item_discount`, `sold_to`, `sold_by`, `sale_token`, `franchise_id`, `sold_at`) VALUES (?,?,?,?,?,?,?,?, (SELECT franchise_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)) ,?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('iiiiisisss', $item_id, $item_quantity, $item_price_each, $item_final_price, $item_discount, $sold_to, $sold_by, $token, $_COOKIE['US-K'], $sold_at);
		if($stmt->execute()){
			$stmt->close();
			$sql = "UPDATE location_based_inventory set item_quantity = item_quantity - ? where item_id = ?";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('ii', $item_quantity, $item_id);
			if (!$stmt->execute())
				die("Line#63 : " . htmlspecialchars($stmt->error));
		}
		else
			die("Line#66 : " . htmlspecialchars($stmt->error));
	}
}

echo json_encode(array('status' => 'Success', 'token' => $token));

die;
?>