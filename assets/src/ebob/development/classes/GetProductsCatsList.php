<?php

class GetProdCategories{

	function __construct($conn, $subCatId){
		$this->conn = $conn;
		$this->subCatId = $subCatId;
	}

	function getProductsCategories(){
		$sql = "SELECT product_category_id, product_category_name FROM `product_categories` where sub_category_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param('i', $this->subCatId);
		$stmt->execute();
		$stmt->bind_result($id, $name);
		$productCategories = array();
		while($stmt->fetch()){
			$productCategories[] = array(
				'product_category_id' => $id,
				'product_category_name' => $name
				);
		}
		return json_encode(array("Product Categories"=>$productCategories));
	}

}

?>