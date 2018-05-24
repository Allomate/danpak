<?php

header('Content-Type: application/json');

class Bulletin extends Web_Services_Controller{

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

	public function GetBulletin(){
		$bulletinData = $this->input->post();
		unset($bulletinData["api_secret_key"]);
		$response = $this->ws->GetBulletin($bulletinData);
		if ($response != "No bulletins found" && $response != "No Employee found") :
			return $this->ResponseMessage('Success', $response);
		else:
			return $this->ResponseMessage('Failed', $response);
		endif;
	}

}

?>