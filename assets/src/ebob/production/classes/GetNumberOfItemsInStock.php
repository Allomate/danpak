<?php

class GetStock{

	function __construct($conn){
		$this->conn = $conn;
	}

	function getStockItems($companyId, $franchiseId, $barcode){
		$sql = "SELECT item_quantity from location_based_inventory where item_barcode = ? and company_id = ? and franchise_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param('sii', $barcode, $companyId, $franchiseId);
		$stmt->execute();
		$stmt->bind_result($item_quantity);
		$stockItems = 0;
		while($stmt->fetch()){
			$stockItems = $item_quantity;
		}
		return json_encode(array("Stock"=>$stockItems));
	}

}

?>