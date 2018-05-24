<?php

class RemoveFromWl{

	function __construct($conn, $wlId){
		$this->conn = $conn;
		$this->wlId = $wlId;
	}

	function removeItemsFromWl(){
		$sql = "DELETE from wishlist_items where id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param('i', $this->wlId);
		$status = new ReturnStatus("success","wl-remove","Item has been removed successfully");
		if (!$stmt->execute()) {
			$status = new ReturnStatus("failed","wl-remove",htmlspecialchars($stmt->error));
		}
		return json_encode($status);
	}

}

?>