<?php

class SubmitReview{

	function __construct($conn, $rating, $complainId){
		$this->conn = $conn;
		$this->rating = $rating;
		$this->complainId = $complainId;
	}

	function saveReview(){
		$sql = "UPDATE complains set user_rating = ? where complain_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param('ii',$this->rating, $this->complainId);
		if($stmt->execute()){
			$status = new ReturnStatus("success","review","Review submitted successfully");
			return $status->GetStatus();
		}
		
	}

}

?>