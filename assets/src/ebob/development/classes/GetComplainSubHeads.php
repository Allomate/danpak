<?php

class ComplainSubHeads{

	function __construct($conn){
		$this->conn = $conn;
	}

	function getComplainSubHeads($headId, $level){
		if($level == "1"){
			$sql = "SELECT id, complain_subhead from complain_subhead where complain_head_id = ? and parent_subhead_id = 0 and level = 1";
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param('i', $headId);
			$stmt->execute();
			$stmt->bind_result($head_id, $head_name);
			$complainSubheads = array();
			while($stmt->fetch()){
				$complainSubheads[] = array(
					'id' => $head_id,
					'complain_subhead' => $head_name
					);
			}
		}else if($level == "2"){
			$sql = "SELECT id, complain_subhead from complain_subhead where parent_subhead_id = ? and level = 2";
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param('i', $headId);
			$stmt->execute();
			$stmt->bind_result($head_id, $head_name);
			$complainSubheads = array();
			while($stmt->fetch()){
				$complainSubheads[] = array(
					'id' => $head_id,
					'complain_subhead' => $head_name
					);
			}
		}else if($level == "3"){
			$sql = "SELECT id, complain_subhead from complain_subhead where parent_subhead_id = ? and level = 3";
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param('i', $headId);
			$stmt->execute();
			$stmt->bind_result($head_id, $head_name);
			$complainSubheads = array();
			while($stmt->fetch()){
				$complainSubheads[] = array(
					'id' => $head_id,
					'complain_subhead' => $head_name
					);
			}
		}

		return json_encode(array("ComplainSubHeads"=>$complainSubheads));

	}

}

?>