<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employees extends WebAuth_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('EmployeesModel', 'em');
		$this->load->model('TerritoriesModel', 'tm');
	}

	public function AddEmployee()
	{
		$employeesList = $this->em->get_employees_list();
		$this->load->view('Employee/add_employee', ['employees'=>$employeesList, 'territories'=>$this->tm->getAllTerritories()]);
	}

	public function DailyRouting()
	{
		// echo "<pre>"; print_r($this->em->getDailyRouteData());die;
		$employeesList = $this->em->getDailyRouteData();
		$loopCounter = 0;
		foreach($employeesList as $employees){
			$employeesNewList = explode(",", $employees->employees);
			$employeesList[$loopCounter]->total_employees = sizeOf(array_unique($employeesNewList));
			$loopCounter++;
		}
		return $this->load->view('Employee/EmployeesListRouting', ['routing'=> $employeesList]);
	}

	public function CompleteEmployeeRoutingList($routingDate)
	{
		// echo "<pre>"; print_r($this->em->getCompleteRoutingData($routingDate));die;
		return $this->load->view('Employee/DailyRouting', ['routing'=>$this->em->getCompleteRoutingData($routingDate)]);
	}

	public function GetDailyRouteLatLongsAjax(){
		echo json_encode($this->em->GetLatLongsForDailyRouting($this->input->post()));
	}

	public function Attendance(){
		return $this->load->view('Employee/Attendance', [ 'AttendanceData' => $this->em->GetAttendanceData(), 'AttendanceStats' => $this->em->AttendanceStats() ]);
	}

	public function ListEmployees()
	{
		if(!isset($_COOKIE['sage']))
			return redirect('/');
		$employeesList = $this->em->get_employees_list_management();
		if($_COOKIE['sage'] == 1){
			$employeesList = $this->em->get_employees_list_sales_agent();
		}
		$this->load->view('Employee/list_employees', ['employees'=>$employeesList]);
	}

	public function Deactivate($empId){
		if ($this->em->deact_act_emp($empId, '0')) :
			$this->session->set_flashdata("employee_deactivated", "Employee has been deactivated");
		else:
			$this->session->set_flashdata("employee_deactivate_failed", "Failed to deactive the employee");
		endif;
		return redirect('Employees/ListEmployees');
	}

	public function Activate($empId){
		if ($this->em->deact_act_emp($empId, '1')) :
			$this->session->set_flashdata("employee_activated", "Employee has been activated");
		else:
			$this->session->set_flashdata("employee_activate_failed", "Failed to active the employee");
		endif;
		return redirect('Employees/ListEmployees');
	}

	public function UpdateEmployeeProfilePicture(){
		$employee_picture = '';
		if (isset($_FILES['employee_picture'])) :
			$_FILES['employee_picture'] = array_filter($_FILES['employee_picture']);
		endif;
		if (!empty($_FILES['employee_picture']['name'])) :
			$employee['picture_deleted'] = 'deleted';
			$config['upload_path'] = './assets/uploads/employee/';
			$config['allowed_types'] = 'jpg|bmp|png|jpeg';
			$config['max_size'] = 'jpg|bmp|png|jpeg';
			$this->load->helper('file');
			$this->load->library('upload', $config);
			$item_thumbnail = '';
			$_FILES['userfile']['name'] = time().'-'.trim($_FILES['employee_picture']['name']);
			$_FILES['userfile']['type'] = $_FILES['employee_picture']['type'];
			$_FILES['userfile']['tmp_name'] = $_FILES['employee_picture']['tmp_name'];
			$_FILES['userfile']['error']    = isset($_FILES['employee_picture']['error']) ? $_FILES['employee_picture']['error'] : '';
			$_FILES['userfile']['size'] = $_FILES['employee_picture']['size'];
			if (!$this->upload->do_upload()) :
				$this->load->view('Employee/add_employee', ['employees'=>$employeesList, 'territories'=>$this->tm->getAllTerritories(), 'employee_picture_error'=>$this->upload->display_errors()]);
			else :
				$file_data = $this->upload->data();
				$employee_picture = $config['upload_path'].$file_data['file_name'];
			endif;
		endif;

		$status = $this->em->update_employee_picture($employee_picture);
		if (!$status) :
			echo json_encode(['status' => 'failed', 'error' => $status]);
			die;
		endif;
		echo json_encode(['status' => 'success', 'image' => str_replace("./", "/", $employee_picture)]);
	}

	public function PersonalInfo(){
		$this->load->view('personal-profile', ["info" => $this->em->getLoggedInProfileInfo() ]);
	}

	public function ChangePwAjax(){
		echo json_encode($this->em->updatePassword(sha1($this->input->post("pw"))));
	}

	public function EmployeeProfile($employeeId)
	{
		// echo "<pre>"; print_r($this->em->getEmployeeStatsCurrOverall($employeeId));die;
		if(isset($_COOKIE["stat_type"]) && $_COOKIE["stat_type"] == "overall"){
			$this->load->view('Employee/profile', ["data" => $this->em->getEmployeeStatsCurrOverall($employeeId), "employee" => $this->em->get_single_employee($employeeId) ]);
		}else{
			$this->load->view('Employee/profile', ["data" => $this->em->getEmployeeStatsCurrMonth($employeeId), "employee" => $this->em->get_single_employee($employeeId) ]);
		}
	}

	public function GetEmployeeProfilePicture(){
		$data = $this->session->userdata('session');
		echo $this->em->GetProfilePicForWeb($data);
	}

	public function DeleteEmployee($employee_id)
	{
		if ($this->em->delete_employee($employee_id)) :
			$this->session->set_flashdata("employee_deleted", "Employee has been deleted");
		else:
			$this->session->set_flashdata("employee_delete_failed", "Failed to delete the employee");
		endif;
		return redirect('Employees/ListEmployees');
	}

	public function UpdateEmployee($employee_id)
	{
		$employeeDetails = $this->em->get_single_employee($employee_id);
		if(!$employeeDetails){
			return redirect('Employees/ListEmployees');
		}
		$employeesList = $this->em->get_employees_list();
		$this->load->view('Employee/update_employee', ['employee'=>$employeeDetails, 'employees_list'=>$employeesList, 'territories'=>$this->tm->getAllTerritories()]);
	}

	public function update_employee_operation($employee_id)
	{
		$this->form_validation->set_rules('employee_first_name', 'First Name', 'required|max_length[50]');
		$this->form_validation->set_rules('employee_last_name', 'Last Name', 'max_length[50]');
		$this->form_validation->set_rules('employee_cnic', 'Cnic', 'max_length[13]|exact_length[13]|trim');
		$this->form_validation->set_rules('employee_phone', 'Phone', 'max_length[20]');
		$this->form_validation->set_rules('employee_address', 'Address', 'required|max_length[100]');
		$this->form_validation->set_rules('employee_city', 'City', 'required|alpha|max_length[60]');
		$this->form_validation->set_rules('employee_email', 'Email', 'valid_email|max_length[100]');
		$this->form_validation->set_rules('employee_base_station_lats', 'Latitude', 'required|greater_than[-179]|less_than[181]|max_length[100]');
		$this->form_validation->set_rules('employee_base_station_longs', 'Longitude', 'required|greater_than[-179]|less_than[181]|max_length[100]');
		$employee_picture = '';
		if ($this->form_validation->run()) {
			$employee = $this->input->post();
			if (isset($_FILES['employee_picture'])) :
				$_FILES['employee_picture'] = array_filter($_FILES['employee_picture']);
			endif;
			if (!empty($_FILES['employee_picture']['name'])) :
				$employee['picture_deleted'] = 'deleted';
				$config['upload_path'] = './assets/uploads/employee/';
				$config['allowed_types'] = 'jpg|bmp|png|jpeg';
				$config['max_size'] = 'jpg|bmp|png|jpeg';
				$this->load->helper('file');
				$this->load->library('upload', $config);
				$item_thumbnail = '';
				$_FILES['userfile']['name'] = time().'-'.trim($_FILES['employee_picture']['name']);
				$_FILES['userfile']['type'] = $_FILES['employee_picture']['type'];
				$_FILES['userfile']['tmp_name'] = $_FILES['employee_picture']['tmp_name'];
				$_FILES['userfile']['error']    = isset($_FILES['employee_picture']['error']) ? $_FILES['employee_picture']['error'] : '';
				$_FILES['userfile']['size'] = $_FILES['employee_picture']['size'];
				if (!$this->upload->do_upload()) :
					$this->load->view('Employee/add_employee', ['employees'=>$employeesList, 'territories'=>$this->tm->getAllTerritories(), 'employee_picture_error'=>$this->upload->display_errors()]);
				else :
					$file_data = $this->upload->data();
					$employee['employee_picture'] = $config['upload_path'].$file_data['file_name'];
				endif;
			endif;
			if ($employee['employee_password'] != '') :
				$employee['employee_password'] = sha1($employee['employee_password']);
			else:
				unset($employee['employee_password']);
			endif;

			if ($this->em->update_employee($employee_id, $employee)) :
				$this->session->set_flashdata("update_success", "Employee has been updated successfully");
			else:
				$this->session->set_flashdata("update_failed", "Failed to update the employee");
			endif;
			return redirect('Employees/ListEmployees');
		}else{
			$employeeDetails = $this->em->get_single_employee($employee_id);
			$employeesList = $this->em->get_employees_list();
			$this->load->view('Employee/update_employee', ['employee'=>$employeeDetails, 'employees_list'=>$employeesList, 'territories'=>$this->tm->getAllTerritories()]);
		}
	}

	public function add_employee_operation()
	{
		$this->form_validation->set_rules(
			'employee_username', 'Username',
			'required|max_length[50]|trim|is_unique[employees_info.employee_username]',
			array(
				'required'      => 'You have not provided %s.',
				'is_unique'     => 'This %s already exists.'
			)
		);
		$this->form_validation->set_rules('employee_password', 'Password', 'required|max_length[50]');
		$this->form_validation->set_rules('employee_first_name', 'First Name', 'required|max_length[50]');
		$this->form_validation->set_rules('employee_last_name', 'Last Name', 'max_length[50]');
		$this->form_validation->set_rules('employee_cnic', 'Cnic', 'max_length[13]|exact_length[13]|trim');
		$this->form_validation->set_rules('employee_phone', 'Phone', 'max_length[20]');
		$this->form_validation->set_rules('employee_address', 'Address', 'required|max_length[100]');
		$this->form_validation->set_rules('employee_city', 'City', 'required|alpha|max_length[60]');
		$this->form_validation->set_rules('employee_email', 'Email', 'valid_email|max_length[100]');
		$this->form_validation->set_rules('employee_base_station_lats', 'Latitude', 'required|greater_than[-179]|less_than[181]|max_length[100]');
		$this->form_validation->set_rules('employee_base_station_longs', 'Longitude', 'required|greater_than[-179]|less_than[181]|max_length[100]');
		$employee_picture = '';
		if ($this->form_validation->run()) {
			if (isset($_FILES['employee_picture'])) :
				$_FILES['employee_picture'] = array_filter($_FILES['employee_picture']);
			endif;
			if (!empty($_FILES['employee_picture']['name'])) :
				$config['upload_path'] = './assets/uploads/employee/';
				$config['allowed_types'] = 'jpg|bmp|png|jpeg';
				$config['max_size'] = 'jpg|bmp|png|jpeg';
				$this->load->helper('file');
				$this->load->library('upload', $config);
				$item_thumbnail = '';
				$_FILES['userfile']['name'] = time().'-'.trim($_FILES['employee_picture']['name']);
				$_FILES['userfile']['type'] = $_FILES['employee_picture']['type'];
				$_FILES['userfile']['tmp_name'] = $_FILES['employee_picture']['tmp_name'];
				$_FILES['userfile']['error']    = isset($_FILES['employee_picture']['error']) ? $_FILES['employee_picture']['error'] : '';
				$_FILES['userfile']['size'] = $_FILES['employee_picture']['size'];
				if (!$this->upload->do_upload()) :
					$this->load->view('Employee/add_employee', ['employees'=>$employeesList, 'territories'=>$this->tm->getAllTerritories(), 'employee_picture_error'=>$this->upload->display_errors()]);
				else :
					$file_data = $this->upload->data();
					$employee_picture = $config['upload_path'].$file_data['file_name'];
				endif;
			endif;
			$employee = $this->input->post();
			$employee['employee_password'] = sha1($employee['employee_password']);
			$employee['employee_picture'] = $employee_picture;
			if ($this->em->add_employee($employee)) :
				$this->session->set_flashData('employee_added', 'Employee has been added successfully');
			else:
				$this->session->set_flashData('employee_add_failed', 'Unable to add employee at the moment');
			endif;

			return redirect('Employees/ListEmployees');
		}else{
			$employeesList = $this->em->get_employees_list();
			return $this->load->view('Employee/add_employee', ['employees'=>$employeesList, 'territories'=>$this->tm->getAllTerritories()]);
		}
	}
}
