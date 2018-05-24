<?php

require_once '../database/config.php';

$itemBarcode = $_POST["itemBarcode"];
$sql = "SELECT * from warehouse_inventory where item_barcode = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $itemBarcode);
$stmt->execute();
if($stmt->fetch()){
	$stmt->close();
	die("Barcode already exists");
}

$warehouse = $_POST["warehouse"];

$sql = "SELECT warehouse_id from warehouse where warehouse_id = ? and company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
$stmt = $conn->prepare($sql);
$stmt->bind_param('is', $warehouse, $_COOKIE["US-K"]);
$stmt->execute();
if(!$stmt->fetch()){
	$stmt->close();
	die("Violations");
}
$stmt->close();

$itemName = $_POST["itemName"];
$itemBrand = $_POST["itemBrand"];
$itemSell = $_POST["itemSellingPrice"];
$itemPurchase = $_POST["itemPurchasedPrice"];
$itemColor = $_POST["itemColor"];
$itemQuantity = $_POST["itemQuantity"];
$itemSize = $_POST["itemSize"];
$itemExpiry = $_POST["itemExpiry"];
$itemBarcode = $_POST["itemBarcode"];
$itemDescription = $_POST["itemDescription"];
$categoryId = $_POST["prodCategory"];
$itemImage = "";
$target_dir = "../uploads/item_images/";

$totalImages = count($_FILES['itemImage']['name']);
$imagesUploaded = '';
for($i=0; $i<$totalImages; $i++) {
	$tmpFilePath = $_FILES['itemImage']['tmp_name'][$i];
	if ($tmpFilePath != ""){
		$newFilePath = $target_dir . time() . "-" . preg_replace('/\s+/', '_', $_FILES['itemImage']['name'][$i]);
		if(move_uploaded_file($tmpFilePath, $newFilePath)) {
			if($i == 0){
				$imagesUploaded = $newFilePath;
			}else{
				$imagesUploaded .= "," . $newFilePath;
			}
		}
	}
}

$sql = "INSERT INTO `warehouse_inventory`(`item_barcode`, `item_name`, `item_brand`, `item_size`, `item_color`, `item_quantity`, `item_purchased_price`, `item_sale_price`, `item_expiry`, `item_image`, `item_description`, `warehouse_id`, `company_id`, `category_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,(SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)), ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssssiiisssisi', $itemBarcode, $itemName, $itemBrand, $itemSize, $itemColor, $itemQuantity, $itemPurchase, $itemSell, $itemExpiry, $imagesUploaded, $itemDescription, $warehouse, $_COOKIE["US-K"], $categoryId);
if($stmt->execute()){
	$stmt->close();
	die("Success");
}
else
	die(htmlspecialchars($stmt->error));
?>