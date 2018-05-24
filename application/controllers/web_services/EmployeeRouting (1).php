<?php

header('Content-Type: application/json');

class EmployeeRouting extends Web_Services_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('WebServices', 'ws');
		global $authentication;

		if (!$this->AuthenticateWebServiceCall($this->input->post("api_secret_key"))) :
			echo $this->ResponseMessage('Failed', 'Failed Api Authentication');
			die;
		else:
			if (!$this->AuthenticateSession($this->input->post("session"))) :
				echo $this->ResponseMessage('Failed', 'Failed session Authentication');
				die;
			endif;
		endif;
	}

	public function StoreRoute(){
        if ($this->input->post()['route_lats'] && $this->input->post()['route_longs']) :
            $routeData = $this->input->post();
            unset($routeData["api_secret_key"]);
            $response = $this->ws->StoreRouteData($routeData);
            if ($response) :
                return $this->ResponseMessage('Success', 'Routing data saved successfully');
            else:
                return $this->ResponseMessage('Failed', $response);
            endif;
        else:
            return $this->ResponseMessage('Failed', 'Missing values');
        endif;
	}

}

?>