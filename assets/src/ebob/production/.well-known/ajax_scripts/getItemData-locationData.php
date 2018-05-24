<?php
require_once '../database/config.php';

$itemId = $_POST["id"];
$sql = "SELECT `item_barcode`, `item_name`, `item_brand`, `item_size`, `item_color`, `item_quantity`, `item_purchased_price`, `item_sale_price`, `item_expiry`, `category_id`, `created_at`, `modified_at` FROM `location_based_inventory` WHERE item_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $itemId);
$stmt->execute();
$stmt->bind_result($barcode, $name, $brand, $size, $color, $quantity, $purchased, $sale, $expiry, $category, $addedAt, $modified_at);
$stmt->fetch();

$response = array(
	'barcode' => $barcode,
	'name' => $name,
	'brand' => $brand,
	'size' => $size,
	'color' => $color,
	'quantity' => $quantity,
	'purchased' => $purchased,
	'sale' => $sale,
	'expiry' => $expiry,
	'category' => $category,
	'addedAt' => $addedAt,
	'modified_at' => $modified_at
	);
$stmt->close();

echo json_encode($response);

exit;
?>