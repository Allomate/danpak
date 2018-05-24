<?php

class AddToWl{

	function __construct($conn, $session, $itemId, $userType){
		$this->conn = $conn;
		$this->session = $session;
		$this->itemId = $itemId;
		$this->userType = $userType;
	}

	function addItemToWishlist(){

		$sql = "SELECT id from wishlist_items where product_id = ? and user = (SELECT user_id from users where user_email = (SELECT user from user_session where session = ?))";
		if ($this->userType == "guest") {

		}

		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param('is', $this->itemId, $this->session);
		$stmt->execute();
		while ($stmt->fetch()) {
			$status = new ReturnStatus("success","add-to-wl", "Item already exist in wishlist");
			return json_encode($status);
		}
		$stmt->close();

		$sql = "INSERT INTO `wishlist_items` (`user`, `product_id`) VALUES ((SELECT user_id from users where user_email = (SELECT user from user_session where session = ?)),?)";
		if ($this->userType == "guest") {

		}

		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param('si', $this->session, $this->itemId);
		if (!$stmt->execute()) {
			$status = new ReturnStatus("failed","add-to-wl", htmlspecialchars($stmt->error));
			return json_encode($status);
		}
		$status = new ReturnStatus("success","wishlist-items", "Item has been added to wishlist");
		return json_encode($status);
	}

}

?>