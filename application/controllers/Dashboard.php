<?php

class Dashboard extends WebAuth_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('EmployeeReporting', 'erp');
        $this->load->model('DashboardModel', 'dm');
    }

    public function Home()
    {   
        return $this->load->view('index', ["db_backup" => $this->dm->db_backup()]);
    }

    public function Reports()
    {
        // echo "<pre>";print_r($finalReportings);die;
        return $this->load->view('Reporting&Dashboard/Reports', ['data' => null]);
    }

    public function Dashboardv1()
    {
        // echo "<pre>"; print_r($this->dm->Dashboardv1Stats()); die;
        return $this->load->view('Reporting&Dashboard/Dashboardv1', [ 'stats' => $this->dm->Dashboardv1Stats() ]);
    }

    public function DashboardHrm()
    {
        return $this->load->view('Reporting&Dashboard/HRMS');
    }

    public function DashboardSales()
    {
        return $this->load->view('Reporting&Dashboard/SalesAnalytics');
    }

}
