<?php

class FileComplaint{

	function __construct($session, $deptId, $head_id, $subhead_id, $company_id, $franchise_id, $user_comments, $allowContact){
		$this->session = $session;
		$this->deptId = $deptId;
		$this->head_id = $head_id;
		$this->subhead_id = $subhead_id;
		$this->company_id = $company_id;
		$this->franchise_id = $franchise_id;
		$this->user_comments = $user_comments;
		$this->allowContact = $allowContact;
	}

	function saveComplaint($conn){

		$sql = "INSERT INTO `complains`(`user_id`, `head_id`, `subhead_id`, `company_id`, `franchise_id`, `department_id`, `user_comments`, `complain_status`, `tad_time_start`, `employee_comments`) VALUES ((SELECT user_id FROM users WHERE user_email = (SELECT user FROM user_session WHERE SESSION = ?)),?,?,?,?,?,?,?,?,?)";

		$tadTimeStart = date("Y-m-d H:i:s");
		$employeeComments = "";
		$complainStatus = "pending";
		$stmt = $conn->prepare($sql);
		$latestId = 0;
		$stmt->bind_param('siiiiissss', $this->session, $this->head_id, $this->subhead_id, $this->company_id, $this->franchise_id, $this->deptId, $this->user_comments, $complainStatus, $tadTimeStart, $employeeComments);
		if(!$stmt->execute()){
			$status = new ReturnStatus("failed","FileComplaint",htmlspecialchars($stmt->error));
			$stmt->close();
			return $status->GetStatus();
		}else{
			$latestId = $conn->insert_id;
		}
		$stmt->close();
		
		$status = array(
			'status' => "success",
			'type' => "FileComplaint",
			'message' => "Complain registered successfully",
			'complain_id' => $latestId
			);

		if($this->allowContact == 1){

			$sql = "SELECT * from users_contacted_permission where user_id = (SELECT user_id from users where user_email = (SELECT user from user_session where session = ?)) and company_id = ?";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('si', $this->session, $this->company_id);
			$stmt->execute();
			$alreadyExist = false;
			if($stmt->fetch()){
				$alreadyExist = true;
			}
			$stmt->close();

			if(!$alreadyExist){
				$sql = "INSERT INTO `users_contacted_permission`(`user_id`, `company_id`) VALUES ((SELECT user_id FROM users WHERE user_email = (SELECT user FROM user_session WHERE SESSION = ?)),?)";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('si', $this->session, $this->company_id);
				if($stmt->execute()){
					$status = array(
						'status' => "success",
						'type' => "FileComplaint",
						'message' => "Complain registered successfully",
						'complain_id' => $latestId
						);
				}
				$stmt->close();
			}
		}
		return json_encode($status);
	}

}

?>