<?php

class Checkout{

	function __construct($conn, $session, $userType, $paymentMethod){
		$this->conn = $conn;
		$this->session = $session;
		$this->userType = $userType;
		$this->paymentMethod = $paymentMethod;
	}

	function checkoutWithCart(){

		$sql = "SELECT id, product_id, quantity, final_price, (SELECT item_name from location_based_inventory where item_id = ci.product_id), (SELECT item_quantity from location_based_inventory where item_id = ci.product_id) from cart_items ci where user = (SELECT user_id from users where user_email = (SELECT user from user_session where session = ?)) and active = 1";

		if ($this->userType == "guest") {
			# code...
		}

		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param('s', $this->session);
		$stmt->execute();
		$stmt->bind_result($cartId, $pid, $cartQuantity, $final_price, $productName, $stockQuantity);
		$overQuantified = array();
		$cartIds = array();
		$cartPrice = 0;
		$products = array();
		$reservedQuantities = array();
		while ($stmt->fetch()) {
			if ($cartQuantity > $stockQuantity) {
				$overQuantified[] = array(
					'product_id' => $pid,
					'product_name' => $productName,
					'booked_quantity' => $cartQuantity,
					'stock_quantity' => $stockQuantity
				);
			}
			$cartPrice += $final_price;
			$cartIds[] = $cartId;
			$products[] = $pid;
			$reservedQuantities[] = $cartQuantity;
		}
		$stmt->close();

		if (sizeof($products) <= 0) {
			$status = new ReturnStatus("failed","cart_missing", "You do not have any items added to your cart");
			return json_encode($status);
		}

		if (sizeof($overQuantified) > 0) {
			return json_encode(array("Over-Quantified"=>$overQuantified));
		}else{
			$orderCart = implode(",", $cartIds);
			$sql = "INSERT INTO `orders`(`user_id`, `cart_id`, `payment_method`, `total_price`) VALUES ((SELECT user_id from users where user_email = (SELECT user from user_session where session = ?)),?,?,?)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param('ssss', $this->session, $orderCart, $this->paymentMethod, $cartPrice);
			if ($stmt->execute()) {
				$stmt->close();

				for ($i=0; $i < sizeof($products); $i++) { 
					$sql = "UPDATE location_based_inventory set item_quantity = item_quantity - ? where item_id = ?";
					$stmt = $this->conn->prepare($sql);
					$stmt->bind_param('ii', $reservedQuantities[$i], $products[$i]);
					if (!$stmt->execute()) {
						$status = new ReturnStatus("failed","stock_update", htmlspecialchars($stmt->error));
						return json_encode($status);
					}
					$stmt->close();
				}

				$sql = "UPDATE cart_items set active = 0 where id IN (".$orderCart.")";
				$stmt = $this->conn->prepare($sql);
				if ($stmt->execute()) {
					$status = new ReturnStatus("success","checkout", "Checkout has been successfully made. Your order is now in process");
					return json_encode($status);
				}else{
					$status = new ReturnStatus("failed","cart_update", htmlspecialchars($stmt->error));
					return json_encode($status);
				}
			}else{
				$status = new ReturnStatus("failed","orders", htmlspecialchars($stmt->error));
				return json_encode($status);
			}

		}
	}

}

?>