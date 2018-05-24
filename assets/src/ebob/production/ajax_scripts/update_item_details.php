<?php

require_once '../database/config.php';

$itemBarcode = $_POST["itemBarcode"];
$itemName = $_POST["itemName"];
$itemBrand = $_POST["itemBrand"];
$itemColor = $_POST["itemColor"];
$itemSize = $_POST["itemSize"];
$itemSell = $_POST["itemSale"];
$itemPurchase = $_POST["itemPurchase"];
$itemQuantity = $_POST["itemQuantity"];
$itemExpiry = $_POST["itemExpiry"];
$itemBarcode = $_POST["itemBarcode"];
$itemId = $_POST["itemId"];
$category_id = $_POST["category_id"];
$modified = date('Y:m:d H:m:s');

$imageDeleted = 0;

if ($_POST["image_deleted"] != '') {
	$sql = "SELECT item_image from warehouse_inventory where item_id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('i', $_POST["itemId"]);
	$stmt->execute();
	$stmt->bind_result($existingImgs);
	$alreadyImgs = '';
	while ($stmt->fetch()) {
		$existingImgs = explode(',', $existingImgs);
		$existingImgs = array_map('trim',$existingImgs);
	}
	$stmt->close();

	$imagesToDelete = explode(",", $_POST["image_deleted"]);
	$imagesToDelete = array_map('trim',$imagesToDelete);

	for ($i=0; $i < sizeof($imagesToDelete); $i++) { 
		if (in_array($imagesToDelete[$i], $existingImgs))
		{
			$key = array_search($imagesToDelete[$i],$existingImgs);
			if($key!==false){
				unset($existingImgs[$key]);
				if(file_exists($imagesToDelete[$i]))
					unlink($imagesToDelete[$i]);
			}
		}
	}

	$existingImgs = implode(",",$existingImgs);
	$imageDeleted = 1;
}

$sql = "UPDATE `warehouse_inventory` SET `item_barcode`= ?,`item_name`= ?,`item_brand`= ?,`item_size`= ?,`item_color`= ?,`item_quantity`= ?,`item_purchased_price`= ?,`item_sale_price`= ?,`item_expiry`= ?,`modified_at`= ?, `category_id` = ? WHERE item_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssssiiissii', $itemBarcode, $itemName, $itemBrand, $itemSize, $itemColor, $itemQuantity, $itemPurchase, $itemSell, $itemExpiry, $modified, $category_id, $itemId);
if ($imageDeleted == 1) {
	$sql = "UPDATE `warehouse_inventory` SET `item_barcode`= ?,`item_name`= ?,`item_brand`= ?,`item_size`= ?,`item_color`= ?,`item_quantity`= ?,`item_purchased_price`= ?,`item_sale_price`= ?,`item_expiry`= ?,`modified_at`= ?, `category_id` = ?, item_image = ? WHERE item_id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('sssssiiissisi', $itemBarcode, $itemName, $itemBrand, $itemSize, $itemColor, $itemQuantity, $itemPurchase, $itemSell, $itemExpiry, $modified, $category_id, $existingImgs, $itemId);
}
if($stmt->execute()){
	echo "Success";
}
else
	die(htmlspecialchars($stmt->error));

exit;
?>