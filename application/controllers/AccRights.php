<?php

class AccRights extends WebAuth_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('AccessRights', 'ar');
		$this->load->model('RetailersModel', 'rm');
	}
	
	public function ListRights(){
		return $this->load->view('AccessRights/ListRights', [ 'Rights' => $this->ar->getAllRights() ]);
	}

	public function NewAccRights(){
		return $this->load->view('AccessRights/NewAccRights', [ 'Employees' => $this->ar->getAdminsList(), "Distributors" => $this->rm->GetRetailers() ]);
	}

	public function AddAccRightsOps(){
		$rights = $this->input->post();
		// echo "<pre>"; print_r($this->ar->addAccRights($rights));die;
		if ($this->ar->addAccRights($rights) !== "Exist") :
			$this->session->set_flashdata("rights_added", "Rights have been given successfully");
		else:
			$this->session->set_flashdata("rights_exist", "Rights Already exist");
		endif;
		return redirect('AccRights/ListRights');
	}

	public function UpdateRights($rightId, $userType){
		// echo "<pre>"; print_r($this->ar->getRightsDataForAdmin($rightId, $userType));die;
		return $this->load->view('AccessRights/UpdateRights', [ 'Employees' => $this->ar->getAdminsList(), "Distributors" => $this->rm->GetRetailers(), 'RightsData' => $this->ar->getRightsDataForAdmin($rightId, $userType) ]);
	}

	public function UpdateAccRightsOps($rightId){
		$rights = $this->input->post();
		if ($this->ar->updateAccRights($rights, $rightId) !== "Exist") :
			$this->session->set_flashdata("rights_updated", "Rights have been updated successfully");
		else:
			$this->session->set_flashdata("rights_exist", "Rights Already exist for this admin");
		endif;
		return redirect('AccRights/ListRights');
	}

	public function GetRightsForAdminAjax(){
		$data = $this->input->post();
		$data = $data["id"];
		$userType = $this->session->userdata("user_type");
		echo json_encode($this->ar->getRightsDataForAdmin($data, $userType));
	}

	public function GetRightsForLoggedInAdminAjax(){
		$data = $this->session->userdata('session');
		echo json_encode($this->ar->getRightsDataForLoggedInAdmin($data));
	}

	public function DeleteAccessRight($rightId){
		if ($this->ar->DeleteAccRight($rightId)) :
			$this->session->set_flashdata('rights_deleted', 'Rights have been revoked');
		else:
			$this->session->set_flashdata('rights_delete_failed', 'Unable to revoke xrights at the moment');
		endif;
		return redirect('AccRights/ListRights');
	}

}

?>
