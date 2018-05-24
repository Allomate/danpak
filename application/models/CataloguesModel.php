<?php

class CataloguesModel extends CI_Model{

	public function GetAllCatalogues(){
		$allCats = $this->db->get("catalogues")->result();
		$dataCounter = 0;
		$data = array();
		foreach ($allCats as $cat) {
			$inventoryArray = explode(",", $cat->pref_id);
			$data[$dataCounter] = $cat;
			$data[$dataCounter]->inventory = sizeof($inventoryArray);
			$dataCounter++;
		}
		return $data;
	}
	
	public function GetAllInventory(){
		return $this->db->select('pref_id, item_thumbnail, CONCAT((SELECT item_name from inventory_items where item_id = ip.item_id), " (", (SELECT unit_name from inventory_types_units where unit_id = ip.unit_id), ")") as item_name, (SELECT unit_name from inventory_types_units where unit_id = ip.unit_id) as unit_name')->get("inventory_preferences ip")->result();
	}

	public function CreateCompleteCatalogue($catalogueData, $assignmentData){
		$this->db->insert('catalogues', $catalogueData);
		$catalogue_id = $this->db->insert_id();
		$assignment_method = $assignmentData["assignment_method"];
		if ($assignment_method == "employee") :
			$employee_ids = explode(",", $assignmentData["employee_ids"]);
		elseif ($assignment_method == "region") :
			$employee_ids = $this->db->select('GROUP_CONCAT(employee_id) as employee_id')->where('find_in_set(territory_id, (SELECT GROUP_CONCAT(id) from territory_management where find_in_set(area_id, (SELECT GROUP_CONCAT(id) from area_management where region_id = '.$assignmentData["region_id"].'))))')->get('employees_info')->row()->employee_id;
			$employee_ids = explode(",", $employee_ids);
		elseif ($assignment_method == "area") :
			$employee_ids = $this->db->select('GROUP_CONCAT(employee_id) as employee_id')->where('find_in_set(territory_id, (SELECT GROUP_CONCAT(id) from territory_management where find_in_set(area_id, '.$assignmentData['area_id'].')))')->get('employees_info')->row()->employee_id;
			$employee_ids = explode(",", $employee_ids);
		elseif ($assignment_method == "territory") :
			$employee_ids = $this->db->select('GROUP_CONCAT(employee_id) as employee_id')->where('find_in_set(territory_id, '.$assignmentData['territory_id'].')')->get('employees_info')->row()->employee_id;
			$employee_ids = explode(",", $employee_ids);
		endif;
		$catalogue_assignments = array();
		foreach ($employee_ids as $employee_id) {
			$this->db->delete('catalogue_assignment', array('employee_id' => $employee_id));
			$catalogue_assignments[] = array('catalogue_id'=>$catalogue_id, 'employee_id'=>$employee_id, 'active_from'=>$assignmentData["active_from"], 'active_till'=>$assignmentData["active_till"]);
		}
		return $this->db->insert_batch('catalogue_assignment', $catalogue_assignments);
	}

	public function GetSingleCatalogue($catalogue_id){
		$catalogue_data = $this->db->select('id as catalogue_id, catalogue_name, pref_id')->where('id', $catalogue_id)->get("catalogues")->row();
		$catalogue_data->catalogue_assignment_data = $this->db->select('id as catalogue_assignment_id, employee_id, active_from, active_till')->where('catalogue_id', $catalogue_data->catalogue_id)->get('catalogue_assignment')->result();
		$sortedPrefIds = explode(",", $catalogue_data->pref_id);
		$preferencesArray = array();
		foreach ($sortedPrefIds as $pref_id) {
			$preferencesArray[] = $this->db->select('pref_id, CONCAT((SELECT item_name from inventory_items where item_id = ip.item_id), " (", (SELECT unit_name from inventory_types_units where unit_id = ip.unit_id), ")") as item_name, (SELECT unit_name from inventory_types_units where unit_id = ip.unit_id) as unit_name')->where('pref_id', $pref_id)->get("inventory_preferences ip")->row();
		}
		$catalogue_data->preferences = $preferencesArray;
		return $catalogue_data;
	}

	public function GetSingleCatalogueAssignment($catalogueAssignmentId){
		return $this->db->where('id', $catalogueAssignmentId)->get("catalogue_assignment")->row();
	}

	public function UpdateCompleteCatalogue($catalogue_id, $catalogueData, $assignmentData){
		$this->db
		->where('id',$catalogue_id)	
		->update('catalogues', $catalogueData);

		$assignment_method = $assignmentData["assignment_method"];
		if ($assignment_method == "employee") :
			$employee_ids = explode(",", $assignmentData["employee_ids"]);
		elseif ($assignment_method == "region") :
			$employee_ids = $this->db->select('GROUP_CONCAT(employee_id) as employee_id')->where('find_in_set(territory_id, (SELECT GROUP_CONCAT(id) from territory_management where find_in_set(area_id, (SELECT GROUP_CONCAT(id) from area_management where region_id = '.$assignmentData["region_id"].'))))')->get('employees_info')->row()->employee_id;
			$employee_ids = explode(",", $employee_ids);
		elseif ($assignment_method == "area") :
			$employee_ids = $this->db->select('GROUP_CONCAT(employee_id) as employee_id')->where('find_in_set(territory_id, (SELECT GROUP_CONCAT(id) from territory_management where find_in_set(area_id, '.$assignmentData['area_id'].')))')->get('employees_info')->row()->employee_id;
			$employee_ids = explode(",", $employee_ids);
		elseif ($assignment_method == "territory") :
			$employee_ids = $this->db->select('GROUP_CONCAT(employee_id) as employee_id')->where('find_in_set(territory_id, '.$assignmentData['territory_id'].')')->get('employees_info')->row()->employee_id;
			$employee_ids = explode(",", $employee_ids);
		endif;
		$catalogue_assignments = array();
		$this->db->delete('catalogue_assignment', array('catalogue_id' => $catalogue_id));
		foreach ($employee_ids as $employee_id) {
			$catalogue_assignments[] = array('catalogue_id'=>$catalogue_id, 'employee_id'=>$employee_id, 'active_from'=>$assignmentData["active_from"], 'active_till'=>$assignmentData["active_till"]);
		}
		return $this->db->insert_batch('catalogue_assignment', $catalogue_assignments);

	}

	public function UpdateCatalogueAssignment($UpdateCatalogueAssignment, $catalogueAssignmentData){
		return $this->db
		->where('id',$UpdateCatalogueAssignment)	
		->update('catalogue_assignment', $catalogueAssignmentData);
	}

	public function DeleteCatalogue($catalogue_id){
		$this->db->delete('catalogue_assignment', array('catalogue_id' => $catalogue_id)); 
		return $this->db->delete('catalogues', array('id' => $catalogue_id)); 
	}

	public function AssignCatalogue($catalogueAssignmentData){
		return $this->db->insert('catalogue_assignment', $catalogueAssignmentData);
	}

	public function CheckTodayCatalogue($catalogueAssignmentData){
		$datePeriods = $this->db->select("active_from, active_till")->where("employee_id", $catalogueAssignmentData['employee_id'])->get("catalogue_assignment")->result();
		$datesRegistered = array();

		foreach ($datePeriods as $dates) {
			$begin = new DateTime($dates->active_from);
			$end = clone $begin;
			$end->modify($dates->active_till);
			$end->setTime(0,0,1);
			$interval = new DateInterval('P1D');
			$daterange = new DatePeriod($begin, $interval, $end);
			foreach($daterange as $date) {
				$datesRegistered[] = $date->format('Y-m-d');
			}
		}

		return $datesRegistered;
	}

	public function CheckTodayCatalogueUpdate($catalogueAssignmentData, $assignmentId){
		$datePeriods = $this->db->select("id, active_from, active_till")->where("employee_id", $catalogueAssignmentData['employee_id'])->get("catalogue_assignment")->result();
		$datesRegistered = array();

		foreach ($datePeriods as $dates) {
			$begin = new DateTime($dates->active_from);
			$end = clone $begin;
			$end->modify($dates->active_till);
			$end->setTime(0,0,1);
			$interval = new DateInterval('P1D');
			$daterange = new DatePeriod($begin, $interval, $end);
			foreach($daterange as $date) {
				if ($dates->id != $assignmentId) {
					$datesRegistered[] = $date->format('Y-m-d');
				}
			}
		}

		return $datesRegistered;
	}

	public function GetAllAssignments(){
		return $this->db->select('id, (SELECT catalogue_name from catalogues where id = ca.catalogue_id) as catalogue_name, (SELECT employee_username from employees_info where employee_id = ca.employee_id) as employee_username, active_from, active_till')->get("catalogue_assignment ca")->result();
	}

	public function GetCompleteCatalogueAgainstId($catalogue_id){
		$catalogue_data = $this->db->select('id as catalogue_id, catalogue_name, pref_id')->where('id', $catalogue_id)->get("catalogues")->row();
		$catalogue_data->catalogue_assignment_data = $this->db->select('id as catalogue_assignment_id, employee_id, active_from, active_till')->where('catalogue_id', $catalogue_data->catalogue_id)->get('catalogue_assignment')->result();
		$sortedPrefIds = explode(",", $catalogue_data->pref_id);
		$preferencesArray = array();
		foreach ($sortedPrefIds as $pref_id) {
			$preferencesArray[] = $this->db->select('pref_id, (SELECT item_name from inventory_items where item_id = ip.item_id) as item_name, item_id, (SELECT unit_name from inventory_types_units where unit_id = ip.unit_id) as unit_name, REPLACE(item_thumbnail,"./","'.base_url().'") as item_thumbnail, (SELECT sub_category_name from sub_categories where sub_category_id = ip.sub_category_id) as category')->where('pref_id', $pref_id)->get("inventory_preferences ip")->row();
		}
		return $preferencesArray;
	}

	public function DeleteCatalogueAssignment($catalogueAssignmentId){
		return $this->db->delete('catalogue_assignment', array('id' => $catalogueAssignmentId)); 
	}

}

?>