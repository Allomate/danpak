<?php

class GetMainCategories{

	function __construct($conn){
		$this->conn = $conn;
	}

	function getMainCategories(){
		//For only clothing category for now
		$desiredCategory = 'Clothing';
		$sql = "SELECT category_id, category_name from main_categories where company_category_id = (SELECT category_id from company_categories where category_name = ?)";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param('s', $desiredCategory);
		$stmt->execute();
		$stmt->bind_result($id, $name);
		$mainCats = array();
		while($stmt->fetch()){
			$mainCats[] = array(
				'main_category_id' => $id,
				'main_category_name' => $name
				);
		}
		return json_encode(array("Main Categories"=>$mainCats));
	}

}

?>