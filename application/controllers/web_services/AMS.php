<?php

header('Content-Type: application/json');

class AMS extends Web_Services_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('WebServices', 'ws');
		global $authentication;
		if (!$this->AuthenticateWebServiceCall($this->input->post("api_secret_key"))) :
			return $this->ResponseMessage('Failed', 'Failed Api Authentication');
		else:
			if (!$this->AuthenticateSession($this->input->post("session"))) :
				return $this->ResponseMessage('Failed', 'Failed session Authentication');
			else:
				$authentication = true;
			endif;
		endif;
	}

	public function CheckInAttendance(){
		if ($GLOBALS['authentication']) :
			$attendanceData = $this->input->post();
			unset($attendanceData["api_secret_key"]);
			if ($attendanceData['latitude'] && $attendanceData['longitude'] && ($attendanceData['within_radius'] != '')) :
				if ($this->ws->CheckInAttendance($attendanceData) == "Success") :
					return $this->ResponseMessage('Success', 'You\'ve checked in successfully');
				elseif ($this->ws->CheckInAttendance($attendanceData) == "Exist") :
					return $this->ResponseMessage('Failed', 'You\'ve already checked in');
				elseif ($this->ws->CheckInAttendance($attendanceData) == "Complete") :
					return $this->ResponseMessage('Failed', 'You\'ve marked today\'s attendance');
				else:
					return $this->ResponseMessage('Failed', $this->ws->CheckInAttendance($attendanceData));
				endif;
			else:
				return $this->ResponseMessage('Failed', 'Missing values');
			endif;
		endif;
	}

	public function CheckOutAttendance(){
		if ($GLOBALS['authentication']) :
			$attendanceData = $this->input->post();
			unset($attendanceData["api_secret_key"]);
			if ($attendanceData['latitude'] && $attendanceData['longitude'] && ($attendanceData['within_radius'] != '')) :
				if ($this->ws->CheckOutAttendance($attendanceData) == "Success") :
					return $this->ResponseMessage('Success', 'You\'ve checked out successfully');
				elseif ($this->ws->CheckOutAttendance($attendanceData) == "Unable") :
					return $this->ResponseMessage('Failed', 'You need to check in first');
				elseif ($this->ws->CheckOutAttendance($attendanceData) == "Exist") :
					return $this->ResponseMessage('Failed', 'You\'ve already checked out');
				else:
					return $this->ResponseMessage('Failed', $this->ws->CheckOutAttendance($attendanceData));
				endif;
			else:
				return $this->ResponseMessage('Failed', 'Missing values');
			endif;
		endif;
	}

	public function CheckAttendanceStatus(){
		if ($GLOBALS['authentication']) :
			$attendanceData = $this->input->post();
			unset($attendanceData["api_secret_key"]);
			$response = $this->ws->CheckStatus($attendanceData);
			if ($response == "1") :
				return $this->ResponseMessage('Success', 'Completed');
			elseif ($response == "2") :
				return $this->ResponseMessage('Success', 'Checked In');
			elseif ($response == "3") :
				return $this->ResponseMessage('Success', 'Allow');
			endif;
		endif;
	}

}

?>