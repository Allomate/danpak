<?php

class ComplainsInfo{

	function __construct($conn, $session){
		$this->conn = $conn;
		$this->session = $session;
	}

	function getComplainsInfo(){
		$sql = "SELECT complain_id, (SELECT company_name from company_info where company_id = complains.company_id) as company, (SELECT franchise_name from franchise_info where franchise_id = complains.franchise_id) as franchise, (SELECT complain_head from complain_heads where id = complains.head_id) as complain_head, (SELECT complain_subhead from complain_subhead where id = complains.subhead_id) as subhead, user_comments, complain_status, tad_time_start, tad_time_close, (SELECT employee_name from employees_info where employee_id = complains.employee_id) as employee_name, employee_comments, TIMESTAMPDIFF(HOUR, tad_time_start, tad_time_close) as resolved_in_hrs from complains where user_id = (SELECT user_id from users where user_email = (SELECT user from user_session where session = ?))";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param('s', $this->session);
		$stmt->execute();
		$stmt->bind_result($complain_id, $company, $franchise, $complain_head, $subhead, $user_comments, $complain_status, $tad_time_start, $tad_time_close, $employee_name, $employee_comments, $resolved_in_hrs);
		$complainsInfo = array();
		while($stmt->fetch()){
			$complainsInfo[] = array(
				'complain_id' => $complain_id,
				'company' => $company,
				'franchise' => $franchise,
				'complain_head' => $complain_head,
				'subhead' => $subhead,
				'user_comments' => $user_comments,
				'complain_status' => $complain_status,
				'tad_time_start' => $tad_time_start,
				'tad_time_close' => $tad_time_close,
				'employee_name' => $employee_name,
				'employee_comments' => $employee_comments,
				'resolved_in_hrs' => $resolved_in_hrs
				);
		}
		return json_encode(array("Complains"=>$complainsInfo));
	}

}

?>