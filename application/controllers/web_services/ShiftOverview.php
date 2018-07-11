<?php

header('Content-Type: application/json');

class ShiftOverview extends Web_Services_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('WebServices', 'ws');
        global $authentication;
        if (!$this->AuthenticateWebServiceCall($this->input->post("api_secret_key"))):
            return $this->ResponseMessage('Failed', 'Failed Api Authentication');
        else:
            if (!$this->AuthenticateSession($this->input->post("session"))):
                return $this->ResponseMessage('Failed', 'Failed session Authentication');
            else:
                $authentication = true;
            endif;
        endif;
    }

    public function GetOverview()
    {
        if ($GLOBALS['authentication']):
            $employeeData = $this->input->post();
            unset($employeeData["api_secret_key"]);
            return $this->ResponseMessage('Success', $this->ws->GetOverviewStat($employeeData));
        endif;
    }

}
