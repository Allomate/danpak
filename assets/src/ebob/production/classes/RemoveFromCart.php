<?php

class RemoveCart{

	function __construct($conn, $cartId){
		$this->conn = $conn;
		$this->cartId = $cartId;
	}

	function removeItemsFromCart(){
		$sql = "DELETE from cart_items where id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param('i', $this->cartId);
		$status = new ReturnStatus("success","cart-remove","Item has been removed successfully");
		if (!$stmt->execute()) {
			$status = new ReturnStatus("failed","cart-remove",htmlspecialchars($stmt->error));
		}
		return json_encode($status);
	}

}

?>