<?php

class CompaniesList{

	function __construct($conn){
		$this->conn = $conn;
	}

	function getCompanies(){
		$sql = "SELECT company_id, company_name from company_info order by company_id desc";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$stmt->bind_result($company_id, $company_name);
		$companiesList = array();
		while($stmt->fetch()){
			$companiesList[] = array(
				'company_id' => $company_id,
				'company_name' => $company_name
				);
		}

		return json_encode(array("Companies"=>$companiesList));

	}

}

?>