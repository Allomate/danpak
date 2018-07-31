<?php

class Catalogue extends WebAuth_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('CataloguesModel', 'cm');
		$this->load->model('EmployeesModel', 'em');
		$this->load->model('RegionsModel', 'rm');
		$this->load->model('AreasModel', 'am');
		$this->load->model('TerritoriesModel', 'tm');
	}

	public function ViewCatalogues(){
		return $this->load->view('Catalogue/ViewCatalogues', [ 'Catalogues' => $this->cm->GetAllCatalogues() ]);
	}

	public function CreateCatalogue(){
		return $this->load->view('Catalogue/CreateCatalogue', [ 'inventoryList' => $this->cm->GetAllInventory(), 'Employees' => $this->em->get_employees_list(), 'Regions' => $this->rm->getAllRegions(), 'Areas' => $this->am->getAllAreas(), 'Territories' => $this->tm->getAllTerritories() ]);
	}

	public function UpdateCatalogue($catalogue_id){
		return $this->load->view('Catalogue/UpdateCatalogue', [ 'inventoryList' => $this->cm->GetAllInventory(), 'CatalogueDetails' => $this->cm->GetSingleCatalogue($catalogue_id), 'Employees' => $this->em->get_employees_list(), 'Regions' => $this->rm->getAllRegions(), 'Areas' => $this->am->getAllAreas(), 'Territories' => $this->tm->getAllTerritories() ]);
	}

	public function CreateCatalogueOps(){
		$catalogueData = json_decode($this->input->post("catalogue_data"));
		$newCatalogueData["catalogue_name"] = $catalogueData->catalogue_name;
		$newCatalogueData["pref_id"] = $catalogueData->pref_ids;
		$catalogueAssignments = json_decode($this->input->post("assignment_data"));
		$newAssignmentData["active_till"] = $catalogueAssignments->active_till;
		$newAssignmentData["active_from"] = $catalogueAssignments->active_from;
		$newAssignmentData["assignment_method"] = $catalogueAssignments->assignment_method;
		if (isset($catalogueAssignments->employee_ids)) :
			$newAssignmentData["employee_ids"] = $catalogueAssignments->employee_ids;
		elseif (isset($catalogueAssignments->territory_id)) :
			$newAssignmentData["territory_id"] = $catalogueAssignments->territory_id;
		elseif (isset($catalogueAssignments->region_id)) :
			$newAssignmentData["region_id"] = $catalogueAssignments->region_id;
		elseif (isset($catalogueAssignments->area_id)) :
			$newAssignmentData["area_id"] = $catalogueAssignments->area_id;
		endif;
		if ($this->cm->CreateCompleteCatalogue($newCatalogueData, $newAssignmentData)):
			$this->session->set_flashData('catalogue_added', 'Catalogue has been added successfully');
		else:
			$this->session->set_flashData('catalogue_add_failed', 'Unable to add the Catalogue');
		endif;
		return redirect('Catalogue/ViewCatalogues');
	}

	public function UpdateCatalogueOps($catalogueId){
		$catalogueData = json_decode($this->input->post("catalogue_data"));
		$newCatalogueData["catalogue_name"] = $catalogueData->catalogue_name;
		$newCatalogueData["pref_id"] = $catalogueData->pref_ids;
		$catalogueAssignments = json_decode($this->input->post("assignment_data"));
		$newAssignmentData["active_till"] = $catalogueAssignments->active_till;
		$newAssignmentData["active_from"] = $catalogueAssignments->active_from;
		$newAssignmentData["assignment_method"] = $catalogueAssignments->assignment_method;
		if (isset($catalogueAssignments->employee_ids)) :
			$newAssignmentData["employee_ids"] = $catalogueAssignments->employee_ids;
		elseif (isset($catalogueAssignments->territory_id)) :
			$newAssignmentData["territory_id"] = $catalogueAssignments->territory_id;
		elseif (isset($catalogueAssignments->region_id)) :
			$newAssignmentData["region_id"] = $catalogueAssignments->region_id;
		elseif (isset($catalogueAssignments->area_id)) :
			$newAssignmentData["area_id"] = $catalogueAssignments->area_id;
		endif;
		// echo "<pre>";print_r($newAssignmentData);die;
		if ($this->cm->UpdateCompleteCatalogue($catalogueId, $newCatalogueData, $newAssignmentData)):
			$this->session->set_flashData('catalogue_updated', 'Catalogue has been added successfully');
		else:
			$this->session->set_flashData('catalogue_update_failed', 'Unable to add the Catalogue');
		endif;
		return redirect('Catalogue/ViewCatalogues');
	}

	public function DeleteCatalogue($catalogueId)
	{
		if ($this->cm->DeleteCatalogue($catalogueId)) :
			$this->session->set_flashdata('catalogue_deleted', 'Catalogue has been deleted successfully');
		else:
			$this->session->set_flashdata('catalogue_delete_failed', 'Unable to delete the catalogue');
		endif;
		return redirect('Catalogue/ViewCatalogues');
	}

	public function ViewCatalogueAssignments(){
		return $this->load->view('Catalogue/ViewCatalogueAssignments', [ 'Assignments' => $this->cm->GetAllAssignments() ]);
	}

	public function AssignCatalogue(){
		return $this->load->view('Catalogue/AssignCatalogue', [ 'Catalogues' => $this->cm->GetAllCatalogues(), 'Employees' => $this->em->get_employees_list() ]);
	}

	public function AssignCatalogueOps(){
		$this->form_validation->set_rules('active_from', 'Active From', 'required');
		$this->form_validation->set_rules('active_till', 'Active Till', 'required');
		$this->form_validation->set_rules('catalogue_id', 'Catalogue', 'required');
		$this->form_validation->set_rules('employee_id', 'Employee', 'required');
		if ($this->form_validation->run()) :
			$catalogueAssignmentData = $this->input->post();
			if ($catalogueAssignmentData['active_from'] > $catalogueAssignmentData['active_till']) {
				$this->session->set_flashData('invalid_dates', 'Please select dates properly');
				return $this->load->view('Catalogue/AssignCatalogue', [ 'Catalogues' => $this->cm->GetAllCatalogues(), 'Employees' => $this->em->get_employees_list() ]);
				die;
			}

			$begin = new DateTime($catalogueAssignmentData["active_from"]);
			$end = clone $begin;
			$end->modify($catalogueAssignmentData["active_till"]);
			$end->setTime(0,0,1);
			$interval = new DateInterval('P1D');
			$daterange = new DatePeriod($begin, $interval, $end);
			$newDates = array();

			foreach($daterange as $date) {
				$newDates[] = $date->format('Y-m-d');
			}

			$checkDates = array_intersect($newDates, $this->cm->CheckTodayCatalogue($catalogueAssignmentData));
			if (count($checkDates)) :
				$this->session->set_flashData('already_exist', 'This employee has an existing catalogue within this time. You can delete/update catalogues anytime');
			else:
				if ($this->cm->AssignCatalogue($catalogueAssignmentData)):
					$this->session->set_flashData('catalogue_assigned', 'Catalogue has been assigned successfully');
				else:
					$this->session->set_flashData('catalogue_assignment_failed', 'Unable to assign the Catalogue');
				endif;
			endif;
			return redirect('Catalogue/ViewCatalogueAssignments');
		else:
			return $this->load->view('Catalogue/AssignCatalogue', [ 'Catalogues' => $this->cm->GetAllCatalogues(), 'Employees' => $this->em->get_employees_list() ]);
		endif;
	}

	public function UpdateCatalogueAssignment($catalogueAssignmentId){
		return $this->load->view('Catalogue/UpdateCatalogueAssignment', [ 'Catalogues' => $this->cm->GetAllCatalogues(), 'Employees' => $this->em->get_employees_list(), 'ThisCatalogue' => $this->cm->GetSingleCatalogueAssignment($catalogueAssignmentId) ]);
	}

	public function UpdateCatalogueAssignmentOps($catalogueAssignmentId){
		$this->form_validation->set_rules('active_from', 'Active From', 'required');
		$this->form_validation->set_rules('active_till', 'Active Till', 'required');
		if ($this->form_validation->run()) :
			$catalogueAssignmentData = $this->input->post();
			if ($catalogueAssignmentData['active_from'] > $catalogueAssignmentData['active_till']) {
				$this->session->set_flashData('invalid_dates', 'Please select dates properly');
				return $this->load->view('Catalogue/UpdateCatalogueAssignment', [ 'Catalogues' => $this->cm->GetAllCatalogues(), 'Employees' => $this->em->get_employees_list(), 'ThisCatalogue' => $this->cm->GetSingleCatalogueAssignment($catalogueAssignmentId) ]);
				die;
			}

			$begin = new DateTime($catalogueAssignmentData["active_from"]);
			$end = clone $begin;
			$end->modify($catalogueAssignmentData["active_till"]);
			$end->setTime(0,0,1);
			$interval = new DateInterval('P1D');
			$daterange = new DatePeriod($begin, $interval, $end);
			$newDates = array();

			foreach($daterange as $date) {
				$newDates[] = $date->format('Y-m-d');
			}

			$checkDates = array_intersect($newDates, $this->cm->CheckTodayCatalogueUpdate($catalogueAssignmentData, $catalogueAssignmentId));
			if (count($checkDates)) :
				$this->session->set_flashData('already_exist', 'This employee has an existing catalogue for the day. You can delete/update catalogues anytime');
			else:
				if ($this->cm->UpdateCatalogueAssignment($catalogueAssignmentId, $catalogueAssignmentData)):
					$this->session->set_flashData('catalogue_assignment_updated', 'Catalogue assignment has been updated successfully');
				else:
					$this->session->set_flashData('catalogue_assignment_update_failed', 'Unable to update the assignment of catalogue');
				endif;
			endif;
			return redirect('Catalogue/ViewCatalogueAssignments');
		else:
			return $this->load->view('Catalogue/UpdateCatalogueAssignment', [ 'Catalogues' => $this->cm->GetAllCatalogues(), 'Employees' => $this->em->get_employees_list(), 'ThisCatalogue' => $this->cm->GetSingleCatalogueAssignment($catalogueAssignmentId) ]);
		endif;
	}

	public function ViewCompleteCatalogueListAjax(){
		echo json_encode($this->cm->GetCompleteCatalogueAgainstId($this->input->post("catalogue_id")));
	}

	public function DeleteCatalogueAssignment($catalogueAssignmentId)
	{
		if ($this->cm->DeleteCatalogueAssignment($catalogueAssignmentId)) :
			$this->session->set_flashdata('catalogue_assignment_deleted', 'Catalogue assignment has been deleted successfully');
		else:
			$this->session->set_flashdata('catalogue_assignment_delete_failed', 'Unable to delete the catalogue assignment');
		endif;
		return redirect('Catalogue/ViewCatalogueAssignments');
	}

	public function GetCatalogueContentsAjaxCall(){
		echo "<pre>";print_r($this->input->post());
	}

}

?>
