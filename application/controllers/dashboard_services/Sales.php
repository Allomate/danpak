<?php

header('Content-Type: application/json');

class Sales extends CI_Controller
{

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        parent::__construct();
        $this->load->model('FrontendDashboardModel', 'fe');
        $this->load->model('OptimizedDataModel', 'opt');
    }

    public function SalesData()
    {
        echo json_encode($this->fe->getSalesData());
    }

    public function SecondarySalesData()
    {
        echo json_encode($this->fe->getSecondarySalesData());
    }

    public function ChartsData()
    {
        echo json_encode($this->fe->getChartsData());
    }

    public function RetailersData()
    {
        echo json_encode($this->fe->getRetailersData());
    }

    public function RetailersDataCharts()
    {
        echo json_encode($this->fe->getRetailersChartsData());
    }

    public function RetailersOptimizedData()
    {
        echo json_encode($this->opt->getRetailersOptimizedData());
    }

}
