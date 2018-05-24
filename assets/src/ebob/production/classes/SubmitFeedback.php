<?php

class SubmitFeedback{

	function __construct($conn, $session, $product, $feedback){
		$this->conn = $conn;
		$this->session = $session;
		$this->product = $product;
		$this->feedback = $feedback;
	}

	function submitFeedback(){
		$created_at = date('Y:m:d H:m:s');

		$sql = "SELECT * from customer_product_feedback where item_id = ? and user_id = (SELECT user_id from users where user_email = (SELECT user from user_session where session = ?))";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param('is', $this->product, $this->session);
		$stmt->execute();
		while ($stmt->fetch()) {
			$status = new ReturnStatus("failed","feedback-submission","Already submitted feedback for this product");
			return json_encode($status);
		}
		$stmt->close();

		$sql = "INSERT INTO `customer_product_feedback`(`item_id`, `user_id`, `feedback`, `created_at`) VALUES (?,(SELECT user_id from users where user_email = (SELECT user from user_session where session = ?)),?,?)";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param('isis', $this->product, $this->session, $this->feedback, $created_at);
		if ($stmt->execute()) {
			$status = new ReturnStatus("success","feedback-submission","Successfully submitted feedback");
		}else{
			$status = new ReturnStatus("failed","feedback-submission", htmlspecialchars($stmt->error));
		}
		return json_encode($status);
	}

}

?>