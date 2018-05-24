<?php

class Regions extends WebAuth_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('EmployeesModel', 'em');
		$this->load->model('RegionsModel', 'rm');
	}

	public function ListRegions(){
		$this->load->view('Region/ListRegions', [ 'Regions' => $this->rm->getAllRegions() ]);
	}

	public function AddRegion(){
		$this->load->view('Region/AddRegion', [ 'employees' => $this->em->get_employees_list() ]);
	}

	public function AddRegionOps()
	{
		$this->form_validation->set_rules('region_name', 'Region Name', 'required|max_length[100]');
		if ($this->form_validation->run()) {
			$regionData = $this->input->post();
			if ($this->rm->add_region($regionData)) :
				$this->session->set_flashdata("region_added", "Region has been added successfully");
			else:
				$this->session->set_flashdata("region_add_failed", "Failed to add the region");
			endif;
			return redirect('Regions/ListRegions');
		}else{
			return $this->load->view('Region/AddRegion', [ 'employees' => $this->em->get_employees_list() ]);
		}
	}

	public function UpdateRegion($regionId){
		$this->load->view('Region/UpdateRegion', [ 'employees' => $this->em->get_employees_list(), 'region' => $this->rm->getSingleRegion($regionId) ]);
	}

	public function UpdateRegionOps($regionId)
	{
		$this->form_validation->set_rules('region_name', 'Region Name', 'required|max_length[100]');
		if ($this->form_validation->run()) {
			$regionData = $this->input->post();
			if ($this->rm->update_region($regionId, $regionData)) :
				$this->session->set_flashdata("region_updated", "Region has been update successfully");
			else:
				$this->session->set_flashdata("region_update_failed", "Failed to update the region");
			endif;
			return redirect('Regions/ListRegions');
		}else{
			return $this->load->view('Region/UpdateRegion', [ 'employees' => $this->em->get_employees_list(), 'region' => $this->rm->getSingleRegion($regionId) ]);
		}
	}

	public function DeleteRegion($regionId)
	{
		if ($this->rm->delete_region($regionId)) :
			$this->session->set_flashdata('region_deleted', 'Region has been deleted successfully');
			return $this->load->view('Region/ListRegions', [ 'Regions' => $this->rm->getAllRegions() ]);
		else:
			$this->session->set_flashdata('region_delete_failed', 'Unable to delete the region');
			return $this->load->view('Region/ListRegions', [ 'Regions' => $this->rm->getAllRegions() ]);

		endif;
	}

	public function ReturnMerchantsInRegion(){
		echo json_encode($this->rm->getMerchantsInRegion($this->input->post('region_id')));
	}

}

?>