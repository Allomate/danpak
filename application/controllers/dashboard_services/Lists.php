<?php

header('Content-Type: application/json');

class Lists extends CI_Controller
{
    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header('Access-Control-Allow-Headers: Content-Type');
        parent::__construct();
        $this->load->model('FrontendDashboardModel', 'fe');
    }

    public function GetList()
    {
        $listType = (array) json_decode(file_get_contents('php://input'), true);
        echo json_encode($this->fe->getLists($listType["list_type"]));
    }

    public function GetRetailersList()
    {
        $data = (array) json_decode(file_get_contents('php://input'), true);
        echo json_encode($this->fe->getRetailersList($data["list_type"], $data["id"], $data["filter"]));
    }

}
