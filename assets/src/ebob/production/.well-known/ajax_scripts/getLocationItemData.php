<?php
require_once '../database/config.php';

$itemId = $_POST["id"];
$sql = "SELECT `item_barcode`, `item_name`, `item_brand`, `item_size`, `item_color`, `item_quantity`, `item_purchased_price`, `item_sale_price`, `item_expiry`, `created_at`, `modified_at`, `item_description`, `item_image`, category_id as product_category, (SELECT product_category_name from product_categories where product_category_id = location_based_inventory.category_id) as product_category_name , (SELECT sub_category_id from product_categories where product_category_id = location_based_inventory.category_id) as sub_category, (SELECT sub_category_name from sub_categories where sub_category_id = (SELECT sub_category_id from product_categories where product_category_id = location_based_inventory.category_id)) as sub_cat_name, (SELECT main_category_id from sub_categories where sub_category_id = (SELECT sub_category_id from product_categories where product_category_id = location_based_inventory.category_id)) as main_category, (SELECT category_name from main_categories where category_id = (SELECT main_category_id from sub_categories where sub_category_id = (SELECT sub_category_id from product_categories where product_category_id = location_based_inventory.category_id))) as main_category_name FROM `location_based_inventory` WHERE item_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $itemId);
$stmt->execute();
$stmt->bind_result($barcode, $name, $brand, $size, $color, $quantity, $purchased, $sale, $expiry, $addedAt, $modified_at, $description, $image, $category, $productCategoryName, $subCategory, $subCategoryName, $mainCategory, $mainCategoryName);
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
	'modified_at' => $modified_at,
	'image' => $image,
	'description' => $description,
	'main_category' => $mainCategory,
	'sub_category' => $subCategory,
	'product_category' => $category,
	'product_category_name' => $productCategoryName,
	'main_category_name' => $mainCategoryName,
	'sub_category_name' => $subCategoryName
	);
$stmt->close();

echo json_encode($response);

exit;
?>