<?php

class Areas extends WebAuth_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('EmployeesModel', 'em');
		$this->load->model('RegionsModel', 'rm');
		$this->load->model('AreasModel', 'am');
	}

	public function ListAreas(){
		$this->load->view('Area/ListAreas', [ 'Areas' => $this->am->getAllAreas() ]);
	}

	public function AddArea(){
		$this->load->view('Area/AddArea', [ 'employees' => $this->em->get_employees_list(), 'regions' => $this->rm->getAllRegions() ]);
	}

	public function AddAreaOps()
	{
		$this->form_validation->set_rules('area_name', 'Area Name', 'required|max_length[100]');
		if ($this->form_validation->run()) {
			$areaData = $this->input->post();
			if ($this->am->add_area($areaData)) :
				$this->session->set_flashdata("area_added", "Area has been added successfully");
			else:
				$this->session->set_flashdata("area_add_failed", "Failed to add the area");
			endif;
			return redirect('Areas/ListAreas');
		}else{
			$this->load->view('Area/AddArea', [ 'employees' => $this->em->get_employees_list(), 'regions' => $this->rm->getAllRegions() ]);
		}
	}

	public function UpdateArea($areaId){
		return $this->load->view('Area/UpdateArea', [ 'employees' => $this->em->get_employees_list(), 'area' => $this->am->getSingleArea($areaId), 'regions' => $this->rm->getAllRegions() ]);
	}

	public function UpdateAreaOps($areaId)
	{
		$this->form_validation->set_rules('area_name', 'Area Name', 'required|max_length[100]');
		if ($this->form_validation->run()) {
			$areaData = $this->input->post();
			if ($this->am->update_area($areaId, $areaData)) :
				$this->session->set_flashdata("area_updated", "Area has been update successfully");
			else:
				$this->session->set_flashdata("area_update_failed", "Failed to update the area");
			endif;
			return redirect('Areas/ListAreas');
		}else{
			return $this->load->view('Area/UpdateArea', [ 'employees' => $this->em->get_employees_list(), 'area' => $this->am->getSingleArea($areaId), 'regions' => $this->rm->getAllRegions() ]);
		}
	}

	public function DeleteArea($areaId)
	{
		if ($this->am->delete_area($areaId)) :
			$this->session->set_flashdata('area_deleted', 'Area has been deleted successfully');
			return $this->load->view('Area/ListAreas', [ 'Areas' => $this->am->getAllAreas() ]);
		else:
			$this->session->set_flashdata('area_delete_failed', 'Unable to delete the area');
			return $this->load->view('Area/ListAreas', [ 'Areas' => $this->am->getAllAreas() ]);

		endif;
	}

	public function ReturnMerchantsInArea(){
		echo json_encode($this->am->getMerchantsInArea($this->input->post('area_id')));
	}

}

?>