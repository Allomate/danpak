<?php

header('Content-Type: application/json');

class Employee extends Web_Services_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->helper('string');
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

	public function UpdateEmployeePicture(){
		if ($GLOBALS['authentication']) :
			$employeePicture = $this->input->post();
			$config['upload_path'] = './assets/uploads/employee/';
			if (isset($employeePicture['employee_image_b64'])) :
				$imgData = base64_decode($employeePicture['employee_image_b64']);
				$imageName = $config['upload_path'].random_string('alnum', 10).'_'.time().'.jpg';
				$ifp = fopen( $imageName, 'wb' ); 
				fwrite( $ifp, $imgData );
				fclose( $ifp );
				unset($employeePicture['employee_image_b64']);
				$employeePicture['employee_picture'] = $imageName;
				$response = $this->ws->UpdateEmployeePicture($employeePicture);
				if ($response) :
					return $this->ResponseMessage('Success', 'Employee picture has been successfully updated');
				else:
					return $this->ResponseMessage('Failed', $response);
				endif;
			else:
				return $this->ResponseMessage('Failed', 'Missing values');
			endif;
		endif;
	}

	public function GetEmployeeProfile(){
		if ($GLOBALS['authentication']) :
			$employee = $this->input->post();
			unset($employee["api_secret_key"]);
			if ($this->ws->GetProfile($employee)) :
				return $this->ResponseMessage('Success', $this->ws->GetProfile($employee));
			else:
				return $this->ResponseMessage('Failed', $this->ws->GetProfile($employee));
			endif;
		endif;
	}

	public function GetEmployeeOrders(){
		if ($GLOBALS['authentication']) :
			$employee = $this->input->post();
			unset($employee["api_secret_key"]);
			if ($this->ws->GetEmployeeOrders($employee)) :
				return $this->ResponseMessage('Success', $this->ws->GetEmployeeOrders($employee));
			else:
				return $this->ResponseMessage('Failed', $this->ws->GetEmployeeOrders($employee));
			endif;
		endif;
	}

}

?>