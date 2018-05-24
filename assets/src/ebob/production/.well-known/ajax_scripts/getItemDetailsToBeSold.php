<?php
require_once '../database/config.php';

$itemBarcode = $_POST["barcode"];
$sql = "SELECT `item_id`, `item_name`, `item_brand`, `item_size`, `item_color`, `item_quantity`, `item_sale_price`, `item_expiry`, `item_image`, `item_description`, `discount_available`, `discount_active`, (SELECT product_category_name from product_categories where product_category_id = location_based_inventory.category_id) as product_category FROM `location_based_inventory` WHERE item_barcode = ? and franchise_id = (SELECT franchise_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $itemBarcode, $_COOKIE["US-K"]);
$stmt->execute();
$stmt->bind_result($id, $name, $brand, $size, $color, $quantity, $sale, $expiry, $image, $description, $discount_available, $discount_active, $product_category);
$item = array();
while($stmt->fetch()){

	$hostLink = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . "/";
	
	if ($discount_active > 0 && $discount_active != '' && $discount_active != null && $discount_active != '0') {
		$discountedAmount = ($discount_available / 100) * $sale;
		$sale = round($sale - $discountedAmount);	
	}

	if ($image != null && $image != '') {
		$image = str_replace("../",$hostLink,$image);;
	}else{
		$image = $hostLink.'uploads/item_images/no-preview.jpg';
	}

	$item = array(
		'id' => $id,
		'name' => $name,
		'brand' => $brand,
		'size' => $size,
		'color' => $color,
		'quantity' => $quantity,
		'sale' => $sale,
		'expiry' => $expiry,
		'image' => $image,
		'description' => $description,
		'discount_available' => $discount_available,
		'discount_active' => $discount_active,
		'product_category' => $product_category
		);
}
echo json_encode($item);
exit;
?>