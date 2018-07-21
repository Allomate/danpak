<?php

class Web_Services_Controller extends CI_Controller{

	public function AuthenticateWebServiceCall($key){
		$this->load->database('default');
		$service_module = $this->uri->segment(2) ? $this->uri->segment(2) : "";
		$service_name = $this->uri->segment(3) ? $this->uri->segment(3) : "";
		$existServData = $this->db->select('id, hits')->where('service_name = "'.$service_name.'" and DATE(created_at) = CURDATE()')->get('services_hit_counter')->row();
		if($existServData):
			$this->db->where('id', $existServData->id)->update('services_hit_counter', array('hits' => (((int) $existServData->hits) + 1) ));
		else:
			$this->db->insert('services_hit_counter', ["service_module" => $service_module, "service_name"=>$service_name]);
		endif;
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
