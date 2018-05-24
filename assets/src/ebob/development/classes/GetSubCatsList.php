<?php

class GetSubCategories{

	function __construct($conn, $mainCatId){
		$this->conn = $conn;
		$this->mainCatId = $mainCatId;
	}

	function getSubCategories(){
		$sql = "SELECT sub_category_id, sub_category_name FROM `sub_categories` where main_category_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param('i', $this->mainCatId);
		$stmt->execute();
		$stmt->bind_result($id, $name);
		$subCategories = array();
		while($stmt->fetch()){
			$subCategories[] = array(
				'sub_category_id' => $id,
				'sub_category_name' => $name
				);
		}
		return json_encode(array("Sub Categories"=>$subCategories));
	}

}

?>