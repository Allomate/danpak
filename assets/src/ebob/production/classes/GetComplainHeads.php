<?php

class ComplainHeads{

	function __construct($conn){
		$this->conn = $conn;
	}

	function getComplainHeads(){
		$sql = "SELECT id, complain_head, department_id from complain_heads";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$stmt->bind_result($head_id, $head_name, $department_id);
		$franchisesList = array();
		while($stmt->fetch()){
			$franchisesList[] = array(
				'complain_head_id' => $head_id,
				'complain_head_name' => $head_name,
				'department_id' => $department_id
				);
		}
		return json_encode(array("ComplainHeads"=>$franchisesList));
	}

}

?>