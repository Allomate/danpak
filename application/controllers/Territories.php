<?php

class Territories extends WebAuth_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('EmployeesModel', 'em');
		$this->load->model('RegionsModel', 'rm');
		$this->load->model('AreasModel', 'am');
		$this->load->model('TerritoriesModel', 'tm');
	}

	public function ListTerritories(){
		return $this->load->view('Territory/ListTerritory', [ 'Territories' => $this->tm->getAllTerritories() ]);
	}

	public function AddTerritory(){
		$this->load->view('Territory/AddTerritory', [ 'employees' => $this->em->get_employees_list(), 'areas' => $this->am->getAllAreas() ]);
	}

	public function AddTerritoryOps()
	{
		$this->form_validation->set_rules('territory_name', 'Territory Name', 'required|max_length[100]');
		if ($this->form_validation->run()) {
			$territoryData = $this->input->post();
			if ($this->tm->add_territory($territoryData)) :
				$this->session->set_flashdata("territory_added", "Territory has been added successfully");
			else:
				$this->session->set_flashdata("territory_add_failed", "Failed to add the territory at the moment");
			endif;
			return redirect('Territories/ListTerritories');
		}else{
			return $this->load->view('Territory/AddTerritory', [ 'employees' => $this->em->get_employees_list(), 'areas' => $this->am->getAllAreas() ]);
		}
	}

	public function UpdateTerritory($territoryId){
		return $this->load->view('Territory/UpdateTerritory', [ 'employees' => $this->em->get_employees_list(), 'areas' => $this->am->getAllAreas(), 'territory' => $this->tm->getSingleTerritory($territoryId) ]);
	}

	public function UpdateTerritoryOps($territoryId)
	{
		$this->form_validation->set_rules('territory_name', 'Territory Name', 'required|max_length[100]');
		if ($this->form_validation->run()) {
			$territoryData = $this->input->post();
			if ($this->tm->update_territory($territoryId, $territoryData)) :
				$this->session->set_flashdata("territory_updated", "Territory has been update successfully");
			else:
				$this->session->set_flashdata("territory_update_failed", "Failed to update the territory");
			endif;
			return redirect('Territories/ListTerritories');
		}else{
			return $this->load->view('Territory/UpdateTerritory', [ 'employees' => $this->em->get_employees_list(), 'areas' => $this->am->getAllAreas(), 'territory' => $this->tm->getSingleTerritory($territoryId) ]);
		}
	}

	public function DeleteTerritory($territoryId)
	{
		if ($this->tm->delete_territory($territoryId)) :
			$this->session->set_flashdata('territory_deleted', 'Territory has been deleted successfully');
		else:
			$this->session->set_flashdata('territory_delete_failed', 'Unable to delete the territory');
		endif;
		return $this->load->view('Territory/ListTerritory', [ 'Territories' => $this->tm->getAllTerritories() ]);
	}

	public function ReturnMerchantsInTerritory(){
		echo json_encode($this->tm->getMerchantsInTerritory($this->input->post('territory_id')));
	}

}

?>