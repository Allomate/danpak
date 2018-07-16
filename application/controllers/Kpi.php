<?php

class Kpi extends WebAuth_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('KpiModel', 'km');
		$this->load->model('InventoryModel', 'im');
	}

	public function EmpKpi(){
		return $this->load->view('Kpi/employee_kpi', ['Employees' => $this->km->get_employees_list() ]);
	}

	public function EmpKpiSettings($employee_username){
		if(!$this->km->validate_reporting($employee_username))
			return redirect("Kpi/EmpKpi");
		return $this->load->view('Kpi/employee_kpi_setting', ['Employee' => $this->km->get_this_employee_info($employee_username)]);
	}

	public function UpdateKpiSettings($employee_username){
		if(!$this->km->validate_reporting($employee_username))
			return redirect("Kpi/EmpKpi");

		return $this->load->view('Kpi/update_employee_kpi_setting', ['Employee' => $this->km->get_this_employee_info($employee_username), 'kpi' => $this->km->get_this_employee_kpi($employee_username)]);
	}

	public function GetDetailedKpis($employee_username){
		echo json_encode($this->km->getDetails($employee_username));
	}

	public function SaveKpi($employee_username){
		$data = $this->input->post();

		$completeData = array();

		for($i = 0; $i < $data["totalKpis"]; $i++){
			if(!isset($data["for_kpi_type_".$i])){
				continue;
			}
			if($data["for_kpi_type_".$i] == "product"){
				$completeData[] = array('kpi_type' => $data["for_kpi_type_".$i], 'pref_id' => $data["unitDD_".$i], 'unit_id' => null, 'target' => $data["target_".$i], 'eligibility' => $data["eligibility_".$i], 'weightage' => $data["weightage_".$i], 'incentive' => $data["incentive_".$i], 'criteria' => $data["criteria_".$i], 'criteria_parameter' => $data["for_month_or_criteria_".$i], 'created_for' => $employee_username, 'evaluation_from_employees' => $data["evaluation_from_employees"]);
			}else if($data["for_kpi_type_".$i] == "quantity"){
				$completeData[] = array('kpi_type' => $data["for_kpi_type_".$i], 'pref_id' => null, 'unit_id' => $data["unitDD_".$i], 'target' => $data["target_".$i], 'eligibility' => $data["eligibility_".$i], 'weightage' => $data["weightage_".$i], 'incentive' => $data["incentive_".$i], 'criteria' => $data["criteria_".$i], 'criteria_parameter' => $data["for_month_or_criteria_".$i], 'created_for' => $employee_username, 'evaluation_from_employees' => $data["evaluation_from_employees"]);
			}else{
				$completeData[] = array('kpi_type' => $data["for_kpi_type_".$i], 'pref_id' => null, 'unit_id' => null, 'target' => $data["target_".$i], 'eligibility' => $data["eligibility_".$i], 'weightage' => $data["weightage_".$i], 'incentive' => $data["incentive_".$i], 'criteria' => $data["criteria_".$i], 'criteria_parameter' => $data["for_month_or_criteria_".$i], 'created_for' => $employee_username, 'evaluation_from_employees' => $data["evaluation_from_employees"]);
			}
		}

		if(!$this->km->save_kpi($completeData)){
			return $this->load->view('Kpi/employee_kpi_setting', [ 'error' => $data, 'Employee' => $this->km->get_this_employee_info($employee_username) ]);
		}

		$this->session->set_flashdata("kpi_succes", "KPI has been added for ".$employee_username." successfully");
		return redirect('Kpi/EmpKpi');
	}

	public function UpdateKpi($employee_username){
		$data = $this->input->post();

		$completeData = array();

		for($i = 0; $i < $data["totalKpis"]; $i++){
			if(!isset($data["for_kpi_type_".$i])){
				continue;
			}
			if($data["for_kpi_type_".$i] == "product"){
				$completeData[] = array('kpi_type' => $data["for_kpi_type_".$i], 'pref_id' => $data["unitDD_".$i], 'unit_id' => null, 'target' => $data["target_".$i], 'eligibility' => $data["eligibility_".$i], 'weightage' => $data["weightage_".$i], 'incentive' => $data["incentive_".$i], 'criteria' => $data["criteria_".$i], 'criteria_parameter' => $data["for_month_or_criteria_".$i], 'created_for' => $employee_username, 'evaluation_from_employees' => $data["evaluation_from_employees"]);
			}else if($data["for_kpi_type_".$i] == "quantity"){
				$completeData[] = array('kpi_type' => $data["for_kpi_type_".$i], 'pref_id' => null, 'unit_id' => $data["unitDD_".$i], 'target' => $data["target_".$i], 'eligibility' => $data["eligibility_".$i], 'weightage' => $data["weightage_".$i], 'incentive' => $data["incentive_".$i], 'criteria' => $data["criteria_".$i], 'criteria_parameter' => $data["for_month_or_criteria_".$i], 'created_for' => $employee_username, 'evaluation_from_employees' => $data["evaluation_from_employees"]);
			}else{
				$completeData[] = array('kpi_type' => $data["for_kpi_type_".$i], 'pref_id' => null, 'unit_id' => null, 'target' => $data["target_".$i], 'eligibility' => $data["eligibility_".$i], 'weightage' => $data["weightage_".$i], 'incentive' => $data["incentive_".$i], 'criteria' => $data["criteria_".$i], 'criteria_parameter' => $data["for_month_or_criteria_".$i], 'created_for' => $employee_username, 'evaluation_from_employees' => $data["evaluation_from_employees"]);
			}
		}

		if(!$this->km->update_kpi($completeData, $employee_username)){
			return $this->load->view('Kpi/employee_kpi_setting', [ 'error' => $data, 'Employee' => $this->km->get_this_employee_info($employee_username) ]);
		}

		$this->session->set_flashdata("kpi_updated", "KPI has been updated for ".$employee_username." successfully");
		return redirect('Kpi/EmpKpi');
	}

	public function GetProductsForKpi(){
		echo json_encode($this->im->GetInventoryItems());die;
	}

	public function GetUnitsForThisProduct(){
		$item_id = explode("=", file_get_contents('php://input'))[1];
		echo json_encode($this->im->GetUnitsAvailableForThisProduct($item_id));die;
	}

	public function GetUnitsForKpi(){
		echo json_encode($this->im->GetUnitTypes());die;
	}

	public function DeactivateKpi($employee_username){
		if(!$this->km->deactivate_kpi($employee_username)){
			$this->session->set_flashdata("kpi_deactivation_failed", "Unable to deactivate KPI at the moment");
		}

		$this->session->set_flashdata("kpi_deactivated", "KPI has been deactivated for ".$employee_username." successfully");
		return redirect('Kpi/EmpKpi');
	}

	public function ActivateKpi($employee_username){
		if(!$this->km->activate_kpi($employee_username)){
			$this->session->set_flashdata("kpi_activation_failed", "Unable to activate KPI at the moment");
		}

		$this->session->set_flashdata("kpi_activated", "KPI has been activated for ".$employee_username." successfully");
		return redirect('Kpi/EmpKpi');
	}

	public function Hierarchy(){
		return $this->load->view('Kpi/hierarchy', ['Employees' => $this->km->get_employees_list() ]);
	}

	public function CreateHierarchy($employee_username){
		// echo "<pre>"; print_r($this->km->get_reportees($employee_username));die;
		return $this->load->view('Kpi/generate_hierarchy', [ 'Reportees' => $this->km->get_reportees($employee_username) ]);
	}

	public function DeActivateSingularKpi($kpiId){
		$response = $this->km->deactivate_singular_kpi($kpiId);
		echo $response ? "success" : $response;
	}

	public function ActivateSingularKpi($kpiId){
		$response = $this->km->activate_singular_kpi($kpiId);
		echo $response ? "success" : $response;
	}

	public function DeleteThisKpi($kpiId){
		$response = $this->km->delete_kpi($kpiId);
		echo $response ? "success" : $response;
	}

}

?>
