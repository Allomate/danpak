<?php

class BrandsList{

	function __construct($conn){
		$this->conn = $conn;
	}

	function getBrands(){
		//For only clothing category for now
		$desiredCategory = 'Clothing';
		$sql = "SELECT company_id, company_name, company_country from company_info where company_category_id = (SELECT category_id from company_categories where category_name = ?)";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param('s', $desiredCategory);
		$stmt->execute();
		$stmt->bind_result($id, $name, $country);
		$brandsList = array();
		while($stmt->fetch()){
			$brandsList[] = array(
				'company_id' => $id,
				'company_name' => $name,
				'company_country' => $country
				);
		}
		return json_encode(array("Brands"=>$brandsList));
	}

}

?>