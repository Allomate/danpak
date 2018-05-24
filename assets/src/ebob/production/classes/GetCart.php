<?php

class GetCart{

	function __construct($conn, $session, $userType){
		$this->conn = $conn;
		$this->session = $session;
		$this->userType = $userType;
	}

	function getCartDetails(){
		$hostLink = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . "/";
		$sql = "SELECT id, (SELECT item_name from location_based_inventory where item_id = ci.product_id), (SELECT item_brand from location_based_inventory where item_id = ci.product_id), (SELECT item_size from location_based_inventory where item_id = ci.product_id), (SELECT item_color from location_based_inventory where item_id = ci.product_id), (SELECT item_image from location_based_inventory where item_id = ci.product_id), quantity, final_price from cart_items ci where user = (SELECT user_id from users where user_email = (SELECT user from user_session where session = ?)) and active = 1";
		if ($this->userType == "guest") {
			# code...
		}
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param('s', $this->session);
		$stmt->execute();
		$stmt->bind_result($cart_id, $item_name, $item_brand, $item_size, $item_color, $item_image, $quantity, $final_price);
		$cartDetails = array();
		while($stmt->fetch()){
			
			if ($item_image != null && $item_image != '') {
				$item_image = str_replace("../",$hostLink,$item_image);
			}else{
				$item_image = $hostLink.'uploads/item_images/no-preview.jpg';
			}

			$cartDetails[] = array(
				'cart_id' => $cart_id,
				'item_name' => $item_name,
				'item_brand' => $item_brand,
				'item_size' => $item_size,
				'item_color' => $item_color,
				'item_image' => $item_image,
				'quantity' => $quantity,
				'final_price' => $final_price
			);
		}
		return json_encode(array("Cart-Details"=>$cartDetails));
	}

}

?>