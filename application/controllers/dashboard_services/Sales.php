<?php

header('Content-Type: application/json');

class Sales extends CI_Controller
{

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header('Access-Control-Allow-Headers: Content-Type');
        parent::__construct();
        $this->load->model('FrontendDashboardModel', 'fe');
        $this->load->model('OptimizedDataModel', 'opt');
    }

    public function SalesDataMTD()
    {
        echo json_encode($this->fe->getSalesDataMTD());
    }

    public function SalesDataYTD()
    {
        echo json_encode($this->fe->getSalesDataYTD());
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

    public function RetailersDataYTD()
    {
        echo json_encode($this->fe->getRetailersDataYTD());
    }

    public function RetailersDataCharts()
    {
        echo json_encode($this->fe->getRetailersChartsData());
    }

    public function RetailersOptimizedData()
    {
        echo json_encode($this->opt->getRetailersOptimizedData());
    }

    public function getProductSales()
    {
        $reportType = (array) json_decode(file_get_contents('php://input'), true);
        if($reportType["executionType"] == 'booked'){
            echo json_encode($this->fe->getProductSalesBooked($reportType["reportType"]));
        }else{
            echo json_encode($this->fe->getProductSalesExecuted($reportType["reportType"]));
        }
    }

}
