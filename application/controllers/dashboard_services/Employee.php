<?php

header('Content-Type: application/json');

class Employee extends CI_Controller
{

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header('Access-Control-Allow-Headers: Content-Type');
        parent::__construct();
		$this->load->helper('string');
        $this->load->model('FrontendDashboardModel', 'fe');
        $this->load->model('OptimizedDataModel', 'opt');
        $this->load->model('EmployeesModel', 'em');
        $this->load->model('WebServices', 'ws');
    }

	public function DashLogin(){
        $employee = (array) json_decode(file_get_contents('php://input'), true);
        if (!$employee['username'] || !$employee['password']) :
            echo json_encode(array('status' => 'Failed', 'message' => 'Missing Username/Password'));
        else:
            $loginInfo['username'] = $employee['username'];
            $loginInfo['password'] = sha1($employee['password']);
            $loginInfo['session'] = random_string('alnum', 50);
            if ($this->ws->AuthenticateLogin($loginInfo)) :
                unset($loginInfo['password']);
                if ($this->ws->GenerateSession($loginInfo)) :
                    echo json_encode(array('status' => 'success', 'message' => $loginInfo["session"]));
                else:
                    echo json_encode(array('status' => 'Failed', 'message' => 'Unable to generate session at the time. Please try again'));
                endif;
            else:
                echo json_encode(array('status' => 'Failed', 'message' => 'Invalid Username/Password'));
            endif;
        endif;
	}

    public function EmployeeStats()
    {
        $employee = (array) json_decode(file_get_contents('php://input'), true);
        echo json_encode($this->fe->employeeReports($employee["employee_id"], $employee["employee_date"]));
    }

    public function GetEmployees($designation)
    {
        echo json_encode($this->em->get_employees_list_for_dashboard(urldecode($designation)));
    }

    public function GetEmployeesDaysList()
    {
        $employee = (array) json_decode(file_get_contents('php://input'), true);
        echo json_encode($this->fe->getEmployeeDays($employee["employee_id"]));
    }

    public function RetailersOptimizedData()
    {
        echo json_encode($this->opt->getRetailersOptimizedData());
    }

    public function EmployeeOverallStats()
    {
        $employee = (array) json_decode(file_get_contents('php://input'), true);
        echo json_encode($this->fe->getEmployeeStatsOverall($employee["employee_id"]));
    }

    public function EmployeeCurrMonthStats()
    {
        $employee = (array) json_decode(file_get_contents('php://input'), true);
        echo json_encode($this->fe->getEmployeeStatsCurrMonth($employee["employee_id"]));
    }

    public function getEmployeeDetails()
    {
        $employee = (array) json_decode(file_get_contents('php://input'), true);
        echo json_encode($this->fe->getEmployeeDetails($employee["employee_id"]));
    }

}
