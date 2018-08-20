<?php

class RealRetailers extends WebAuth_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('TerritoriesModel', 'tm');
		$this->load->model('RealRetailersModel', 'rem');
		$this->load->model('EmployeesModel', 'em');
		$this->load->model('RegionsModel', 'rm');
		$this->load->model('AreasModel', 'am');
		$this->load->model('TerritoriesModel', 'tm');
	}

	public function ListRetailers(){
		return $this->load->view('RealRetailers/ListRetailers', [ 'Distributors' => $this->rem->GetRetailers() ]);
	}

	public function ListRetailerTypes(){
		return $this->load->view('RealRetailers/ListRetailerTypes', [ 'RetailerTypes' => $this->rem->GetRetailerTypes() ]);
	}

	public function AddRetailer(){
		return $this->load->view('RealRetailers/AddRetailer', [ 'Territories' => $this->tm->getAllTerritories(), 'RetailerTypes' => $this->rem->GetRetailerTypes() ]);
	}

	public function AddRetailerType(){
		return $this->load->view('RealRetailers/AddRetailerType');
	}

	public function RetailerProfile($id){
		return $this->load->view('Retailer/Profile', [ 'retailer' => $this->rem->GetSingleRetailer($id), "data" => $this->rem->getRetailerCompleteProfile($id) ]);
	}

	public function AddRetailerTypeOps()
	{
		$this->form_validation->set_rules('retailer_type_name', 'Retailer Type', 'required|max_length[100]');
		$this->form_validation->set_rules('discount', 'Retailer Type Discount', 'greater_than[-1]|less_than[101]');
		if ($this->form_validation->run()) :
			$retailersData = $this->input->post();
			if ($this->rem->StoreRetailerTypeInformation($retailersData)) :
				$this->session->set_flashdata("retailer_type_added", "Retailer type has been added successfully");
			else:
				$this->session->set_flashdata("retailer_type_add_failed", "Failed to add the Retailer type");
			endif;
			return redirect('RealRetailers/ListRetailerTypes');
		else:
			return $this->load->view('RealRetailers/AddRetailerType');
		endif;
	}

	public function AddRetailerOps()
	{
		$this->form_validation->set_rules('retailer_name', 'Retailer Name', 'required|max_length[100]');
		$this->form_validation->set_rules('retailer_territory_id', 'Territory', 'required');
		$this->form_validation->set_rules('retailer_type_id', 'Retailer Type', 'required');
		$this->form_validation->set_rules('retailer_lats', 'Latitude', 'greater_than[-179]|less_than[181]|max_length[100]');
		$this->form_validation->set_rules('retailer_longs', 'Longitude', 'greater_than[-179]|less_than[181]|max_length[100]');
		$this->form_validation->set_rules('retailer_address', 'Address', 'required|max_length[500]');
		$this->form_validation->set_rules('retailer_city', 'City', 'required|max_length[100]');
		$this->form_validation->set_rules('retailer_email', 'Email', 'valid_email|max_length[100]');
		$this->form_validation->set_rules('retailer_phone', 'Phone', 'numeric|max_length[100]');
		if ($this->form_validation->run()) :
			$retailersData = $this->input->post();
			if ($this->rem->StoreRetailerInformation($retailersData)) :
				$this->session->set_flashdata("retailer_added", "Retailer has been added successfully");
			else:
				$this->session->set_flashdata("retailer_add_failed", "Failed to add the retailer");
			endif;
			return redirect('RealRetailers/ListRetailers');
		else:
			return $this->load->view('RealRetailers/AddRetailer', [ 'Territories' => $this->tm->getAllTerritories(), 'RetailerTypes' => $this->rem->GetRetailerTypes() ]);
		endif;
	}

	public function UpdateRetailerType($retailerTypeId){
		return $this->load->view('RealRetailers/UpdateRetailerType', [ 'RetailerType' => $this->rem->GetSingleRetailerType($retailerTypeId) ]);
	}

	public function UpdateRetailer($retailerId){
		return $this->load->view('RealRetailers/UpdateRetailers', [ 'Territories' => $this->tm->getAllTerritories(), 'Retailer' => $this->rem->GetSingleRetailer($retailerId), 'RetailerTypes' => $this->rem->GetRetailerTypes() ]);
	}

	public function UpdateRetailerTypeOps($retailerTypeId)
	{
		$this->form_validation->set_rules('retailer_type_name', 'Retailer Type Name', 'required|max_length[100]');
		$this->form_validation->set_rules('discount', 'Retailer Type Discount', 'greater_than[-1]|less_than[101]');
		if ($this->form_validation->run()) :
			$retailersData = $this->input->post();
			if ($this->rem->UpdateRetailerTypeInformation($retailerTypeId, $retailersData)) :
				$this->session->set_flashdata("retailer_type_updated", "Retailer Type has been updated successfully");
			else:
				$this->session->set_flashdata("retailer_type_update_failed", "Failed to update the Retailer Type");
			endif;
			return redirect('RealRetailers/ListRetailerTypes');
		else:
			return $this->load->view('RealRetailers/UpdateRetailerType', [ 'RetailerType' => $this->rem->GetSingleRetailerType($retailerTypeId) ]);
		endif;
	}

	public function UpdateRetailerOps($retailerId)
	{
		$this->form_validation->set_rules('retailer_name', 'Retailer Name', 'required|max_length[100]');
		$this->form_validation->set_rules('retailer_type_id', 'Retailer Type', 'required');
		$this->form_validation->set_rules('retailer_territory_id', 'Territory', 'required');
		$this->form_validation->set_rules('retailer_lats', 'Latitude', 'greater_than[-179]|less_than[181]|max_length[100]');
		$this->form_validation->set_rules('retailer_longs', 'Longitude', 'greater_than[-179]|less_than[181]|max_length[100]');
		$this->form_validation->set_rules('retailer_address', 'Address', 'required|max_length[500]');
		$this->form_validation->set_rules('retailer_city', 'City', 'required|max_length[100]');
		$this->form_validation->set_rules('retailer_email', 'Email', 'valid_email|max_length[100]');
		$this->form_validation->set_rules('retailer_phone', 'Phone', 'numeric|max_length[100]');
		if ($this->form_validation->run()) :
			$retailersData = $this->input->post();
			if ($this->rem->UpdateRetailerInformation($retailerId, $retailersData)) :
				$this->session->set_flashdata("retailer_updated", "Retailer has been updated successfully");
			else:
				$this->session->set_flashdata("retailer_update_failed", "Failed to update the retailer");
			endif;
			return redirect('RealRetailers/ListRetailers');
		else:
			return $this->load->view('RealRetailers/UpdateRetailers', [ 'Territories' => $this->tm->getAllTerritories(), 'Retailer' => $this->rem->GetSingleRetailer($retailerId), 'RetailerTypes' => $this->rem->GetRetailerTypes() ]);
		endif;
	}

	public function DeleteRetailer($retailerId)
	{
		if ($this->rem->delete_retailer($retailerId)) :
			$this->session->set_flashdata('retailer_deleted', 'Retailer has been deleted successfully');
		else:
			$this->session->set_flashdata('retailer_delete_failed', 'Unable to delete the Retailer');
		endif;
		return redirect('RealRetailers/ListRetailers');
	}

	public function ListRetailersAssignments(){
		$response = $this->rem->ListRetailersAssignments();
		$finalResponse = array();
		$loopedData = array();
		foreach($response as $data) :
			$exist = false;
			foreach($loopedData as $looper) :
				if(in_array($data->employee_id, $looper)){
					if(in_array($data->assigned_for_day, $looper)){
						$exist = true;
						break;
					}
				}
			endforeach;
			if(!$exist){
				$finalResponse[] = $data;
			}
			$loopedData[] = array(
				'employee_id' => $data->employee_id,
				'assigned_for_day' => $data->assigned_for_day,
			);
		endforeach;
		return $this->load->view('RealRetailers/ListRetailerAssignments', [ 'RetailersAssignments' => $finalResponse ]);
	}

	public function ViewCompleteRetailersListForAnEmployeeAjaxRequest(){
		echo json_encode($this->rem->ViewCompleteRetailersList($this->input->post("employee_id"), $this->input->post("assignedDay")));
	}

	public function AddMoreAssignments(){
		return $this->load->view('RealRetailers/AddMoreAssignments', [ 'Distributors' => $this->rem->get_non_assigned_retailers(), 'Employees' => $this->em->get_employees_list(), 'Regions' => $this->rm->getAllRegions(), 'Areas' => $this->am->getAllAreas(), 'Territories' => $this->tm->getAllTerritories() ] );
	}

	public function RetailerAssignemntOps(){
		$retailersAssignmentsData = $this->input->post();
		unset($retailersAssignmentsData['DataTables_Table_0_length']);
		if (!$retailersAssignmentsData["employee"] || !$retailersAssignmentsData["assigned_for_day"]) {
			$this->session->set_flashdata("missing_information", "Missing Information. Please provide complete details");
			return redirect('RealRetailers/AddMoreAssignments');
		}
		$status = $this->rem->AssignRetailers($retailersAssignmentsData);
		if ($status == "Exist") :
			$this->session->set_flashdata("retailer_assignment_Exist", "This employee is already assigned retailers. Please update existing record");
		elseif ($status == "all_retailers_assigned") :
			$this->session->set_flashdata("retailer_assignment_reserved", "There are no retailers to assiged");
		elseif ($status == "Success") :
			$this->session->set_flashdata("retailer_assignment_added", "Retailers assigned successfully");
		else:
			$this->session->set_flashdata("retailer_assignment_failed", "Failed to add retailers assignment");
		endif;
		return redirect('RealRetailers/ListRetailersAssignments');	
	}

	public function UpdateRetailersAssignments($employeeId, $assignedDay){
		// echo "<pre>"; print_r($this->em->get_employees_list());die;
		// echo "<pre>"; print_r($this->rem->GetSingleRetailerAssignment($employeeId, $assignedDay));die;
		return $this->load->view('RealRetailers/UpdateRetailersAssignments', [ 'RetailersAssignment' => $this->rem->GetSingleRetailerAssignment($employeeId, $assignedDay), 'Distributors' => $this->rem->get_non_assigned_retailers(), 'Employees' => $this->em->get_employees_list(), 'Regions' => $this->rm->getAllRegions(), 'Areas' => $this->am->getAllAreas(), 'Territories' => $this->tm->getAllTerritories() ] );
	}

	public function UpdateRetailerAssignemntsOps($employeeId){
		$retailersAssignmentsData = $this->input->post();
		unset($retailersAssignmentsData["DataTables_Table_0_length"]);
		if (!$retailersAssignmentsData["employee"] || !$retailersAssignmentsData["assigned_for_day"]) {
			$this->session->set_flashdata("missing_information", "Missing Information. Please provide complete details");
			return redirect('RealRetailers/UpdateRetailersAssignments');
		}
		$status = $this->rem->UpdateRetailersAssignment($employeeId, $retailersAssignmentsData);
		if ($status && $status != "Exist") :
			$this->session->set_flashdata("retailer_assignment_updated", "Retailers assignment updated successfully");
		elseif ($status == "Exist") :
			$this->session->set_flashdata("retailer_assignment_Exist", "This employee is already assigned retailers. Please update existing record");
		else:
			$this->session->set_flashdata("retailer_assignment_update_failed", "Failed to update retailers assignment");
		endif;

		return redirect('RealRetailers/ListRetailersAssignments');
	}

	public function DeleteRetailersAssignments($employeeId, $assignedDay){
		if ($this->rem->delete_retailer_assignment($employeeId, $assignedDay)) :
			$this->session->set_flashdata('assignment_deleted', 'Assignment has been deleted successfully');
		else:
			$this->session->set_flashdata('assignment_delete_failed', 'Unable to delete the assignment');
		endif;
		return redirect('RealRetailers/ListRetailersAssignments');
	}

	public function DeleteRetailerType($retailerTypeId){
		if ($this->rem->delete_retailer_type($retailerTypeId)) :
			$this->session->set_flashdata('retailer_type_deleted', 'Retailer type has been deleted successfully');
		else:
			$this->session->set_flashdata('retailer_type_delete_failed', 'Unable to delete the Retailer type');
		endif;
		return redirect('RealRetailers/ListRetailerTypes');
	}

}

?>
