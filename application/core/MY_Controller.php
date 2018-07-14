<?php

class Web_Services_Controller extends CI_Controller{

	public function AuthenticateWebServiceCall($key){
		$this->load->model("WebServices", 'ws');
		return $this->ws->GetAuth($key);
	}

	public function AuthenticateSession($session){
		$this->load->model("WebServices", 'ws');
		return $this->ws->GetAuthSession($session);
	}

	public function ResponseMessage($status, $response){
		echo json_encode(array(
			'status' => $status,
			'response' => $response
		));
	}

}

class WebAuth_Controller extends CI_Controller{

	public function __construct(){
		parent::__construct();

		if (!$this->session->userdata('session')) :
			return redirect("Login/");
		endif;

		$this->load->model('AccessRights', 'ar');
		$func = $this->uri->segment(2);
		if($func == "ListOrders"){
			$func = $this->uri->segment(3);
		}

		$adminSession = $this->session->userdata('session');
		if($func != "Home"){
			if(!$this->ar->VerifyRights($func, $adminSession)){
				return $this->load->view('not_found');
			}
		}
	}
	
}

?>
