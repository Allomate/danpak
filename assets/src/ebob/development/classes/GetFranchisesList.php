<?php

class FranchisesList{

	function __construct($conn){
		$this->conn = $conn;
	}

	function getFranchises($companyId){
		$sql = "SELECT franchise_id, franchise_name, franchise_city from franchise_info where company_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param('i', $companyId);
		$stmt->execute();
		$stmt->bind_result($franchise_id, $franchise_name, $franchise_city);
		$franchisesList = array();
		while($stmt->fetch()){
			$franchisesList[] = array(
				'franchise_id' => $franchise_id,
				'franchise_name' => $franchise_name,
				'franchise_city' => $franchise_city
				);
		}
		return json_encode(array("Franchises"=>$franchisesList));
	}

}

?>