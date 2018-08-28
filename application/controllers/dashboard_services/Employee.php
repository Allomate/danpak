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
        $this->load->model('FrontendDashboardModel', 'fe');
        $this->load->model('OptimizedDataModel', 'opt');
        $this->load->model('EmployeesModel', 'em');
    }

    public function EmployeeStats()
    {
        $employee = (array) json_decode(file_get_contents('php://input'), true);
        echo json_encode($this->fe->employeeReports($employee["employee_id"], $employee["employee_date"]));
    }

    public function GetEmployees()
    {
        echo json_encode($this->em->get_employees_list_for_dashboard());
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

}
