<?php

header('Content-Type: application/json');

class Inventory extends Web_Services_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('WebServices', 'ws');
		global $authentication;

		if (!$this->AuthenticateWebServiceCall($this->input->post("api_secret_key"))) :
			echo $this->ResponseMessage('Failed', 'Failed Api Authentication');
			die;
		endif;
	}

	public function GetCategoriesList(){
		$response = $this->ws->GetCategories();
		if ($response) :
			return $this->ResponseMessage('Success', $response);
		else:
			return $this->ResponseMessage('Failed', $response);
		endif;
	}

}

?>