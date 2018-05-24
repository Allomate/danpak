<?php

class GetProductsList{

	function __construct($conn, $prodCatId, $companyId){
		$this->conn = $conn;
		$this->prodCatId = $prodCatId;
		$this->companyId = $companyId;
	}

	function getProdsList(){
		$hostLink = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . "/";
		$sql = "SELECT `item_id`, `item_barcode`, `item_name`, `item_brand`, `item_size`, `item_color`, `item_quantity`, `item_sale_price`, `item_image`, `item_description`, `discount_available`, `discount_active` FROM `location_based_inventory` WHERE category_id = ? and company_id = ? group by item_barcode";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param('ii', $this->prodCatId, $this->companyId);
		$stmt->execute();
		$stmt->bind_result($id, $barcode, $name, $brand, $size, $color, $quantity, $price, $image, $description, $discountOf, $discountActive);
		$productsList = array();
		while($stmt->fetch()){

			$originalPrice = $price;

			if ($discountActive == 1) {
				$discountedAmount = ($discountOf / 100) * $price;
				$price = round($price - $discountedAmount);
			}
			
			if ($image != null && $image != '') {
				$image = str_replace("../",$hostLink.'ebob/development/',$image);;
			}else{
				$image = $hostLink.'ebob/development/uploads/item_images/no-preview.jpg';
			}

			$productsList[] = array(
				'item_id' => $id,
				'item_barcode' => $barcode,
				'item_name' => $name,
				'item_brand' => $brand,
				'item_size' => $size,
				'item_color' => $color,
				'item_quantity' => $quantity,
				'item_price' => $price,
				'item_original_price' => $originalPrice,
				'item_image' => $image,
				'item_description' => $description,
				'item_discount_available' => $discountActive
				);
		}
		return json_encode(array("Products List"=>$productsList));
	}

}

?>