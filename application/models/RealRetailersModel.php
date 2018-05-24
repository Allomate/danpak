<?php

class RealRetailersModel extends CI_Model{
	
	public function GetRetailers(){
		return $this->db->select('id, retailer_name, retailer_address, (SELECT territory_name from territory_management where id = rd.retailer_territory_id) as territory_name, (SELECT retailer_type_name from retailer_types where id = rd.retailer_type_id) as retailer_type')->where('find_in_set(rd.retailer_type_id, (SELECT GROUP_CONCAT(id) from retailer_types where retailer_or_distributor = "ret"))')->get("retailers_details rd")->result();
	}
	
	public function GetRetailerTypes(){
		return $this->db->where('retailer_or_distributor', 'ret')->get("retailer_types")->result();
	}

	public function GetAreas(){
		return $this->db->select('id as area_id, area_name')->get("area_management")->result();
	}

	public function StoreRetailerInformation($retailerInfo){
		return $this->db->insert('retailers_details', $retailerInfo);
	}

	public function StoreRetailerTypeInformation($retailerInfo){
		return $this->db->insert('retailer_types', $retailerInfo);
	}

	public function GetSingleRetailer($retailerId){
		return $this->db->where('id', $retailerId)->get('retailers_details')->row();
	}

	public function GetSingleRetailerType($retailerTypeId){
		return $this->db->where('id', $retailerTypeId)->get('retailer_types')->row();
	}

	public function UpdateRetailerInformation($retailer_id, $retailerInfo){
		return $this->db
		->where('id',$retailer_id)	
		->update('retailers_details', $retailerInfo);
	}

	public function get_non_assigned_retailers(){
		return $this->db->select('`id`, `retailer_name`, `retailer_phone`, `retailer_email`, `retailer_address`, `retailer_lats`, `retailer_longs`, `retailer_city`, `retailer_type_id`, (SELECT retailer_type_name from retailer_types where id = rd.retailer_type_id) as retailer_type, `retailer_territory_id`, (SELECT territory_name from territory_management where id = rd.retailer_territory_id) as retailer_territory, `retailer_image`, `added_by`, `updated_by`, `created_at`, (SELECT IFNULL((SELECT count(retailer_id) from retailers_assignment where retailer_id = rd.id), 0)) as assigned')->where('find_in_set(rd.retailer_type_id, (SELECT GROUP_CONCAT(id) from retailer_types where retailer_or_distributor = "ret"))')->get('retailers_details rd')->result();
	}

	public function UpdateRetailerTypeInformation($retailerTypeId, $retailerInfo){
		return $this->db
		->where('id',$retailerTypeId)	
		->update('retailer_types', $retailerInfo);
	}

	public function delete_retailer($retailerId){
		return $this->db->delete('retailers_details', array('id' => $retailerId)); 
	}

	public function delete_retailer_type($retailerTypeId){
		return $this->db->delete('retailer_types', array('id' => $retailerTypeId)); 
	}

	public function delete_retailer_assignment($employeeId){
		return $this->db->delete('retailers_assignment', array('employee_id' => $employeeId)); 
	}

	public function ViewCompleteRetailersList($employeeId){
		return $this->db->select('(SELECT retailer_name from retailers_details where id = rd.retailer_id) as retailer_name, (SELECT retailer_address from retailers_details where id = rd.retailer_id) as retailer_address, (SELECT territory_name from territory_management where id = (SELECT retailer_territory_id from retailers_details where id = rd.retailer_id)) as territory_name')->where('employee_id', $employeeId)->get('retailers_assignment rd')->result();
	}

	public function ListRetailersAssignments(){
		return $this->db->select('employee_id,
			(SELECT CONCAT(employee_first_name, " ", employee_last_name) from employees_info where employee_id = rd.employee_id) as employee, (SELECT count(*) FROM `retailers_assignment` where employee_id = rd.employee_id) as total_distributors_assigned, (SELECT territory_name from territory_management where id = (SELECT territory_id from employees_info where employee_id = rd.employee_id)) as territory_name')->group_by('employee_id')->get('retailers_assignment rd')->result();
	}

	public function GetSingleRetailerAssignment($employee_id){
		return $this->db->select('GROUP_CONCAT(id) as retailer_assignment_id, employee_id, GROUP_CONCAT(retailer_id order by retailer_id) as retailer_id,
			(SELECT CONCAT(employee_first_name, " ", employee_last_name) from employees_info where employee_id = rd.employee_id) as employee,
			( SELECT GROUP_CONCAT(retailer_name order by id SEPARATOR "<br>") from retailers_details where find_in_set(id, (SELECT GROUP_CONCAT(retailer_id) from retailers_assignment where employee_id = rd.employee_id))) as retailer_names,
			( SELECT GROUP_CONCAT(retailer_address order by id SEPARATOR "<br>") from retailers_details where find_in_set(id, (SELECT GROUP_CONCAT(retailer_id) from retailers_assignment where employee_id = rd.employee_id))) as retailer_addresses')->group_by('employee_id')->where('employee_id', $employee_id)->get('retailers_assignment rd')->row();
	}

	public function AssignRetailers($assignmentsData){
		if ($this->db->where('employee_id', $assignmentsData["employee"])->get('retailers_assignment')->result()) {
			return "Exist";
		}
		$retailers = explode(",", $assignmentsData["retailersForAssignments"]);
		$assignmentsBatch = array();
		for ($i=0; $i < sizeof($retailers); $i++) :
			$assignmentsBatch[] = array("employee_id"=>$assignmentsData["employee"], "retailer_id"=>$retailers[$i]);
		endfor;
		
		if ($this->db->insert_batch('retailers_assignment', $assignmentsBatch)) :
			return "Success";
		else:
			return "Failed";
		endif;
	}

	public function UpdateRetailersAssignment($existingEmployeeId, $assignmentsData){
		if ($this->db->where('employee_id = '. $assignmentsData["employee"] . ' and id NOT IN ('.$assignmentsData['existingAssignmentIds'].')')->get('retailers_assignment')->result()) {
			return "Exist";
		}
		if ($this->db->delete('retailers_assignment', array('employee_id' => $existingEmployeeId))) :
			$retailers = explode(",", $assignmentsData["retailersForAssignments"]);
			$assignmentsBatch = array();
			for ($i=0; $i < sizeof($retailers); $i++) :
				$assignmentsBatch[] = array("employee_id"=>$assignmentsData["employee"], "retailer_id"=>$retailers[$i]);
			endfor;
			return $this->db->insert_batch('retailers_assignment', $assignmentsBatch);
		else :
			return false;
		endif;
	}

}

?>