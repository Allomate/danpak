<?php

class GetWishlist{

	function __construct($conn, $session, $userType){
		$this->conn = $conn;
		$this->session = $session;
		$this->userType = $userType;
	}

	function getWlDetails(){
		$hostLink = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . "/";
		$sql = "SELECT id, (SELECT item_name from location_based_inventory where item_id = wi.product_id), (SELECT item_brand from location_based_inventory where item_id = wi.product_id), (SELECT item_size from location_based_inventory where item_id = wi.product_id), (SELECT item_color from location_based_inventory where item_id = wi.product_id), (SELECT item_image from location_based_inventory where item_id = wi.product_id) from wishlist_items wi where user = (SELECT user_id from users where user_email = (SELECT user from user_session where session = ?))";
		if ($this->userType == "guest") {
			# code...
		}
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param('s', $this->session);
		$stmt->execute();
		$stmt->bind_result($wl_id, $item_name, $item_brand, $item_size, $item_color, $item_image);
		$wlDetails = array();
		while($stmt->fetch()){
			
			if ($item_image != null && $item_image != '') {
				$item_image = str_replace("../",$hostLink,$item_image);
			}else{
				$item_image = $hostLink.'uploads/item_images/no-preview.jpg';
			}

			$wlDetails[] = array(
				'wl_id' => $wl_id,
				'item_name' => $item_name,
				'item_brand' => $item_brand,
				'item_size' => $item_size,
				'item_color' => $item_color,
				'item_image' => $item_image
			);
		}
		return json_encode(array("Wishlist"=>$wlDetails));
	}

}

?>