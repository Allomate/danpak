<?php

class Retailers extends WebAuth_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('TerritoriesModel', 'tm');
		$this->load->model('RetailersModel', 'rem');
		$this->load->model('EmployeesModel', 'em');
	}

	public function ListRetailers(){
		return $this->load->view('Retailer/ListRetailers', [ 'Distributors' => $this->rem->GetRetailers() ]);
	}

	public function ListRetailerTypes(){
		return $this->load->view('Retailer/ListRetailerTypes', [ 'RetailerTypes' => $this->rem->GetRetailerTypes() ]);
	}

	public function AddRetailer(){
		return $this->load->view('Retailer/AddRetailer', [ 'Territories' => $this->tm->getAllTerritories(), 'RetailerTypes' => $this->rem->GetRetailerTypes() ]);
	}

	public function AddRetailerType(){
		return $this->load->view('Retailer/AddRetailerType');
	}

	public function DistributorProfile($id){
		// echo "<pre>"; print_r($this->rem->getDistributorCompleteProfile($id)); die;
		return $this->load->view('Retailer/Profile', [ 'retailer' => $this->rem->GetSingleRetailer($id), "data" => $this->rem->getDistributorCompleteProfile($id) ]);
	}

	public function AddRetailerTypeOps()
	{
		$this->form_validation->set_rules('retailer_type_name', 'Distributor Type', 'required|max_length[100]');
		$this->form_validation->set_rules('discount', 'Distributor Type Discount', 'greater_than[-1]|less_than[101]');
		if ($this->form_validation->run()) :
			$retailersData = $this->input->post();
			if ($this->rem->StoreRetailerTypeInformation($retailersData)) :
				$this->session->set_flashdata("retailer_type_added", "Distributor type has been added successfully");
			else:
				$this->session->set_flashdata("retailer_type_add_failed", "Failed to add the Distributor type");
			endif;
			return redirect('Retailers/ListRetailerTypes');
		else:
			return $this->load->view('Retailer/AddRetailerType');
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
				$this->session->set_flashdata("retailer_added", "Distributor has been added successfully");
			else:
				$this->session->set_flashdata("retailer_add_failed", "Failed to add the distributor");
			endif;
			return redirect('Retailers/ListRetailers');
		else:
			return $this->load->view('Retailer/AddRetailer', [ 'Territories' => $this->tm->getAllTerritories(), 'RetailerTypes' => $this->rem->GetRetailerTypes() ]);
		endif;
	}

	public function UpdateRetailerType($retailerTypeId){
		return $this->load->view('Retailer/UpdateRetailerType', [ 'RetailerType' => $this->rem->GetSingleRetailerType($retailerTypeId) ]);
	}

	public function UpdateRetailer($retailerId){
		return $this->load->view('Retailer/UpdateRetailers', [ 'Territories' => $this->tm->getAllTerritories(), 'Retailer' => $this->rem->GetSingleRetailer($retailerId), 'RetailerTypes' => $this->rem->GetRetailerTypes() ]);
	}

	public function UpdateRetailerTypeOps($retailerTypeId)
	{
		$this->form_validation->set_rules('retailer_type_name', 'Distributor Type Name', 'required|max_length[100]');
		$this->form_validation->set_rules('discount', 'Distributor Type Discount', 'greater_than[-1]|less_than[101]');
		if ($this->form_validation->run()) :
			$retailersData = $this->input->post();
			if ($this->rem->UpdateRetailerTypeInformation($retailerTypeId, $retailersData)) :
				$this->session->set_flashdata("retailer_type_updated", "Distributor Type has been updated successfully");
			else:
				$this->session->set_flashdata("retailer_type_update_failed", "Failed to update the Distributor Type");
			endif;
			return redirect('Retailers/ListRetailerTypes');
		else:
			return $this->load->view('Retailer/UpdateRetailerType', [ 'RetailerType' => $this->rem->GetSingleRetailerType($retailerTypeId) ]);
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
				$this->session->set_flashdata("retailer_updated", "Distributor has been updated successfully");
			else:
				$this->session->set_flashdata("retailer_update_failed", "Failed to update the distributor");
			endif;
			return redirect('Retailers/ListRetailers');
		else:
			return $this->load->view('Retailer/UpdateRetailers', [ 'Territories' => $this->tm->getAllTerritories(), 'Retailer' => $this->rem->GetSingleRetailer($retailerId), 'RetailerTypes' => $this->rem->GetRetailerTypes() ]);
		endif;
	}

	public function DeleteRetailer($retailerId)
	{
		if ($this->rem->delete_retailer($retailerId)) :
			$this->session->set_flashdata('retailer_deleted', 'Distributor has been deleted successfully');
		else:
			$this->session->set_flashdata('retailer_delete_failed', 'Unable to delete the Distributor');
		endif;
		return redirect('Retailers/ListRetailers');
	}

	public function ListRetailersAssignments(){
		$response = $this->rem->ListRetailersAssignments();
		$finalResponse = array();
		$loopedData = array();
		if($response){
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
			return $this->load->view('Retailer/ListRetailerAssignments', [ 'RetailersAssignments' => $finalResponse ]);
		}
		return $this->load->view('Retailer/ListRetailerAssignments', [ 'RetailersAssignments' => [] ]);
	}

	public function ViewCompleteRetailersListForAnEmployeeAjaxRequest(){
		echo json_encode($this->rem->ViewCompleteRetailersList($this->input->post("employee_id"), $this->input->post("assignedDay")));
	}

	public function AddMoreAssignments(){
		return $this->load->view('Retailer/AddMoreAssignments', [ 'Distributors' => $this->rem->get_non_assigned_retailers(), 'Employees' => $this->em->get_employees_list() ] );
	}

	public function RetailerAssignemntOps(){
		$retailersAssignmentsData = $this->input->post();
		unset($retailersAssignmentsData['DataTables_Table_0_length']);
		if (!$retailersAssignmentsData["employee"] || !$retailersAssignmentsData["retailersForAssignments"] || !$retailersAssignmentsData["assigned_for_day"]) {
			$this->session->set_flashdata("missing_information", "Missing Information. Please provide complete details");
			return redirect('Retailers/AddMoreAssignments');
		}
		$status = $this->rem->AssignRetailers($retailersAssignmentsData);
		if ($status == "Exist") :
			$this->session->set_flashdata("retailer_assignment_Exist", "This employee is already assigned distibutor. Please update existing record");
		elseif ($status == "Success") :
			$this->session->set_flashdata("retailer_assignment_added", "Distributors assigned successfully");
		else:
			$this->session->set_flashdata("retailer_assignment_failed", "Failed to add distibutor assignment");
		endif;
		return redirect('Retailers/ListRetailersAssignments');	
	}

	public function UpdateRetailersAssignments($employeeId, $assignedDay){
		// echo sizeOf(explode(",", $this->rem->GetSingleRetailerAssignment($employeeId, $assignedDay)->retailer_names));die;
		// echo "<pre>"; print_r($this->rem->GetSingleRetailerAssignment($employeeId, $assignedDay)); die;
		return $this->load->view('Retailer/UpdateRetailersAssignments', [ 'RetailersAssignment' => $this->rem->GetSingleRetailerAssignment($employeeId, $assignedDay), 'Distributors' => $this->rem->get_non_assigned_retailers(), 'Employees' => $this->em->get_employees_list() ] );
	}

	public function UpdateRetailerAssignemntsOps($employeeId){
		$retailersAssignmentsData = $this->input->post();
		unset($retailersAssignmentsData["DataTables_Table_0_length"]);
		if (!$retailersAssignmentsData["employee"] || !$retailersAssignmentsData["retailersForAssignments"]) {
			$this->session->set_flashdata("missing_information", "Missing Information. Please provide complete details");
			return redirect('Retailers/UpdateRetailersAssignments');
		}
		$status = $this->rem->UpdateRetailersAssignment($employeeId, $retailersAssignmentsData);
		if ($status && $status != "Exist") :
			$this->session->set_flashdata("retailer_assignment_updated", "Distributors assignment updated successfully");
		elseif ($status == "Exist") :
			$this->session->set_flashdata("retailer_assignment_Exist", "This employee is already assigned distributors. Please update existing record");
		else:
			$this->session->set_flashdata("retailer_assignment_update_failed", "Failed to update distributors assignment");
		endif;

		return redirect('Retailers/ListRetailersAssignments');
	}

	public function DeleteRetailersAssignments($employeeId, $assignedDay){
		if ($this->rem->delete_retailer_assignment($employeeId, $assignedDay)) :
			$this->session->set_flashdata('assignment_deleted', 'Assignment has been deleted successfully');
		else:
			$this->session->set_flashdata('assignment_delete_failed', 'Unable to delete the assignment');
		endif;
		return redirect('Retailers/ListRetailersAssignments');
	}

	public function DeleteRetailerType($retailerTypeId){
		if ($this->rem->delete_retailer_type($retailerTypeId)) :
			$this->session->set_flashdata('retailer_type_deleted', 'Distributor type has been deleted successfully');
		else:
			$this->session->set_flashdata('retailer_type_delete_failed', 'Unable to delete the Distributor type');
		endif;
		return redirect('Retailers/ListRetailerTypes');
	}

}

?>
