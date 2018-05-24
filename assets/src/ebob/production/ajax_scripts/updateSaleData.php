<?php

require_once '../database/config.php';

$saleId = $_POST["saleId"];
$finalPrice = $_POST["finalPrice"];
$quantity = $_POST["quantity"];
$existingQuan = $_POST["existingQuan"];

$sql = "UPDATE `sales_management` set `item_quantity` = ?, `item_final_price` = ? where sale_id = ? and franchise_id = (SELECT franchise_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
$stmt = $conn->prepare($sql);
$newQuantit = ($existingQuan - $quantity);
$stmt->bind_param('iiis', $newQuantit, $finalPrice, $saleId, $_COOKIE["US-K"]);
if($stmt->execute()){
	$stmt->close();
	$sql = "UPDATE location_based_inventory set item_quantity = item_quantity + ? where item_id = (SELECT item_id from sales_management where sale_id = ? and franchise_id = (SELECT franchise_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)))";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('iis', $quantity, $saleId, $_COOKIE["US-K"]);
	if ($stmt->execute()) {
		die("Updated");
	}else{
		die(htmlspecialchars($stmt->error));			
	}
}
else
	die(htmlspecialchars($stmt->error));

exit;
?>