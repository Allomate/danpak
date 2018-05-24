<?php

class AddToCart{

	function __construct($conn, $session, $itemId, $userType, $quantity, $finalPrice){
		$this->conn = $conn;
		$this->session = $session;
		$this->itemId = $itemId;
		$this->userType = $userType;
		$this->quantity = $quantity;
		$this->finalPrice = $finalPrice;
	}

	function addItemToCart(){

		$sql = "SELECT id, quantity, final_price from cart_items where product_id = ? and user = (SELECT user_id from users where user_email = (SELECT user from user_session where session = ?)) and active = 1";
		if ($this->userType == "guest") {

		}

		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param('is', $this->itemId, $this->session);
		$stmt->execute();
		$stmt->bind_result($id, $quantity, $finalPrice);
		while ($stmt->fetch()) {
			$thisId = $id;
			$newQuantity = $this->quantity + $quantity;
			$newPrice = $this->finalPrice + $finalPrice;
			$stmt->close();
			$sql = "UPDATE cart_items set quantity = ?, final_price = ? where id = ?";
			if ($this->userType == "guest") {

			}

			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param('isi', $newQuantity, $newPrice, $thisId);
			if (!$stmt->execute()) {
				$status = new ReturnStatus("failed","update-cart", htmlspecialchars($stmt->error));
				return json_encode($status);
			}
			$status = new ReturnStatus("success","update-cart", "Cart has been updated successfully");
			return json_encode($status);
		}
		$stmt->close();

		$sql = "INSERT INTO `cart_items`(`user`, `product_id`, `quantity`, `final_price`) VALUES ((SELECT user_id from users where user_email = (SELECT user from user_session where session = ?)),?,?,?)";
		if ($this->userType == "guest") {

		}

		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param('siis', $this->session, $this->itemId, $this->quantity, $this->finalPrice);
		if (!$stmt->execute()) {
			$status = new ReturnStatus("failed","add-to-cart", htmlspecialchars($stmt->error));
			return json_encode($status);
		}
		$status = new ReturnStatus("success","cart-creation", "Cart has been created successfully");
		return json_encode($status);
	}

}

?>