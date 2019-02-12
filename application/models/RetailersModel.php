<?php

class RetailersModel extends CI_Model{
	
	public function GetRetailers($id){
		return $this->db->select('id, retailer_name, distributor_username, retailer_email, retailer_address, (SELECT territory_name from territory_management where id = rd.retailer_territory_id) as territory_name, (SELECT retailer_type_name from retailer_types where id = rd.retailer_type_id) as retailer_type')->where('retailer_territory_id = '.$id.' and find_in_set(rd.retailer_type_id, (SELECT GROUP_CONCAT(id) from retailer_types where retailer_or_distributor = "dist"))')->order_by("retailer_name", "")->get("retailers_details rd")->result();
	}
	
	public function GetRetailersWithoutTerritory(){
		return $this->db->select('id, retailer_name, distributor_username, retailer_email, retailer_address, (SELECT territory_name from territory_management where id = rd.retailer_territory_id) as territory_name, (SELECT retailer_type_name from retailer_types where id = rd.retailer_type_id) as retailer_type')->where('find_in_set(rd.retailer_type_id, (SELECT GROUP_CONCAT(id) from retailer_types where retailer_or_distributor = "dist"))')->order_by("retailer_name", "")->get("retailers_details rd")->result();
	}

	public function GetTerritoriesWithTotalDistributors(){
        return $this->db->select('id, territory_name, (SELECT CONCAT(employee_first_name," ",employee_last_name) from employees_info where employee_id = tm.territory_poc_id) territory_poc, (SELECT count(*) from retailers_details rd where retailer_territory_id = tm.id and find_in_set(rd.retailer_type_id, (SELECT GROUP_CONCAT(id) from retailer_types where retailer_or_distributor = "dist"))) totalRetailers')->where('territory_poc_id IN (SELECT employee_id from employees_info where employee_designation IN ("ASM","RSM"))')->get("territory_management tm")->result();
	}
	
	public function GetRetailerTypes(){
		return $this->db->where('retailer_or_distributor', 'dist')->get("retailer_types")->result();
	}

	public function GetAreas(){
		return $this->db->select('id as area_id, area_name')->get("area_management")->result();
	}

	public function StoreRetailerInformation($retailerInfo){
		$bulkAssignments = array();
		$assignedEmps = $retailerInfo["assignedEmployees"];
		unset($retailerInfo["assignedEmployees"]);
		unset($retailerInfo["asmOrRsm"]);
		unset($retailerInfo["tso"]);
		unset($retailerInfo["orderBooker"]);
		if($this->db->insert('retailers_details', $retailerInfo)){
			if(sizeOf(json_decode($assignedEmps)) > 0){
				foreach(json_decode($assignedEmps) as $employee){
					$bulkAssignments[] = array('employee_id' => $employee, "distributor_id" => $this->db->insert_id());
				}
				return $this->db->insert_batch('distributor_assignment', $bulkAssignments);
			}
			return true;
		}
		return false;
	}

	public function StoreRetailerTypeInformation($retailerInfo){
		return $this->db->insert('retailer_types', $retailerInfo);
	}

	public function GetSingleRetailer($retailerId){
		return $this->db->where('id', $retailerId)->get('retailers_details')->row();
	}

	public function validateUsername($username){
		return $this->db->select('id')->where('LOWER(distributor_username)', strtolower($username))->get('retailers_details')->row();
	}

	public function GetEmployeesAssigned($retailerId){
		return $this->db->select('employee_id, (SELECT employee_username from employees_info where employee_id = da.employee_id) as username, (SELECT employee_designation from employees_info where employee_id = da.employee_id) as designation')->where('distributor_id', $retailerId)->get('distributor_assignment da')->result();
	}

	public function GetSingleRetailerType($retailerTypeId){
		return $this->db->where('id', $retailerTypeId)->get('retailer_types')->row();
	}

	public function UpdateRetailerInformation($retailer_id, $retailerInfo){
		$oldPassword = $this->db->select('distributor_password')->where('id', $retailer_id)->get('retailers_details')->row()->distributor_password;
		if($oldPassword == $retailerInfo["distributor_password"]){
			unset($retailerInfo["distributor_password"]);
			unset($retailerInfo["new_password"]);
		}else{
			$retailerInfo["distributor_password"] = $retailerInfo["new_password"];
			unset($retailerInfo["new_password"]);
		}

		$this->db->delete('distributor_assignment', array('distributor_id' => $retailer_id));
		$bulkAssignments = array();
		$assignedEmps = $retailerInfo["assignedEmployees"];
		unset($retailerInfo["assignedEmployees"]);
		unset($retailerInfo["asmOrRsm"]);
		unset($retailerInfo["tso"]);
		unset($retailerInfo["orderBooker"]);
		
		if(sizeOf(json_decode($assignedEmps)) > 0){
			foreach(json_decode($assignedEmps) as $employee){
				$bulkAssignments[] = array('employee_id' => $employee, "distributor_id" => $retailer_id);
			}
			$bulkAssignsStatus = $this->db->insert_batch('distributor_assignment', $bulkAssignments);
			if(!$bulkAssignsStatus){
				return $bulkAssignsStatus;
			}
		}

		return $this->db
		->where('id',$retailer_id)	
		->update('retailers_details', $retailerInfo);
	}

	public function getDistributorCompleteProfile($id){

		$dates = $this->db->select('DATE(created_at) as date')->where('retailer_id', $id)->group_by('DATE(created_at)')->get('orders')->result();
		$emps = $this->db->select('employee_id, retailer_id, (SELECT employee_username from employees_info where employee_id = orders.employee_id) as employee_username')->where('retailer_id', $id)->group_by('employee_id')->get('orders')->result();
		$orderDetails = array();
		foreach($dates as $today):
			for($i = 0; $i < sizeOf($emps); $i++){
				$ordersCount = $this->db->select('count(*) as totalOrders')->where('DATE(created_at) = "'.$today->date.'" and retailer_id = '.$id.' and employee_id = '.$emps[$i]->employee_id)->get('orders')->row()->totalOrders;
				if($ordersCount){
					$orderDetails[] = array('totalOrders' => $ordersCount, 'employee_username' => $emps[$i]->employee_username , 'date' => $today->date, 'employee_id' => $emps[$i]->employee_id, 'retailer_id' => $emps[$i]->retailer_id);
				}
			}
		endforeach;

		return array('retailer_additional_info' => $this->db->select('(SELECT territory_name from territory_management where id = rd.retailer_territory_id) as territory, (SELECT area_name from area_management where id = (SELECT area_id from territory_management where id = rd.retailer_territory_id)) as area, (SELECT region_name from regions_info where id = (SELECT region_id from area_management where id = (SELECT area_id from territory_management where id = rd.retailer_territory_id))) as region')->where('id', $id)->get('retailers_details rd')->row(), 'order_stats' => $this->db->query('SELECT (SELECT count(*) from orders where retailer_id = '.$id.' and MONTH(created_at) = "'.date('m').'" ) as total_orders_this_month, (SELECT count(*) from visits_marked where retailer_id = '.$id.' ) as total_visits, (SELECT count(*) from orders where retailer_id = '.$id.' ) as total_orders, (SELECT SUM(final_price) from order_contents where find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where retailer_id = '.$id.' ))) as total_sale')->row(), 'visits' => $this->db->select('DATE_FORMAT(TIME(created_at), "%r") as time, DATE(created_at) as date, (SELECT CONCAT(employee_first_name, " ", employee_last_name) from employees_info where employee_id = vm.employee_id) as employee, picture')->where('retailer_id', $id)->get('visits_marked vm')->result(), 'top_products' => $this->db->query('SELECT CONCAT((SELECT item_name from inventory_items where item_id = (SELECT item_id from inventory_preferences where pref_id = oc.pref_id)), " (", (SELECT unit_name from inventory_types_units where unit_id = (SELECT unit_id from inventory_preferences where pref_id = oc.pref_id)), ")") as product, item_quantity_booker, ROUND(((item_quantity_booker/(SELECT SUM(item_quantity_booker) as total_quantities
        from ((SELECT item_quantity_booker FROM `order_contents` oc where find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where retailer_id = '.$id.' )) order by item_quantity_booker desc LIMIT 0,5)) as sumed))*100), 2) as percent_value FROM `order_contents` oc where find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where retailer_id = '.$id.' )) order by item_quantity_booker desc LIMIT 0,5')->result(), 'orders' => $orderDetails);
	}

	public function getRetailersAgainstEmployeeTerritory($employeeId){
		return $this->db->select('`id`, `retailer_name`, `retailer_phone`, `retailer_email`, `retailer_address`, `retailer_lats`, `retailer_longs`, `retailer_city`, `retailer_type_id`, (SELECT retailer_type_name from retailer_types where id = rd.retailer_type_id) as retailer_type, `retailer_territory_id`, (SELECT territory_name from territory_management where id = rd.retailer_territory_id) as retailer_territory, `retailer_image`, `added_by`, `updated_by`, `created_at`, (SELECT IFNULL((SELECT count(retailer_id) from retailers_assignment where retailer_id = rd.id), 0)) as assigned')->where('retailer_territory_id = (SELECT territory_id from employees_info where employee_id = '.$employeeId.') and find_in_set(rd.retailer_type_id, (SELECT GROUP_CONCAT(id) from retailer_types where retailer_or_distributor = "dist"))')->get('retailers_details rd')->result();
	}

	public function get_non_assigned_retailers(){
		return $this->db->select('`id`, `retailer_name`, `retailer_phone`, `retailer_email`, `retailer_address`, `retailer_lats`, `retailer_longs`, `retailer_city`, `retailer_type_id`, (SELECT retailer_type_name from retailer_types where id = rd.retailer_type_id) as retailer_type, `retailer_territory_id`, (SELECT territory_name from territory_management where id = rd.retailer_territory_id) as retailer_territory, `retailer_image`, `added_by`, `updated_by`, `created_at`, (SELECT IFNULL((SELECT count(retailer_id) from retailers_assignment where retailer_id = rd.id), 0)) as assigned')->where('find_in_set(rd.retailer_type_id, (SELECT GROUP_CONCAT(id) from retailer_types where retailer_or_distributor = "dist"))')->get('retailers_details rd')->result();
	}

	public function UpdateRetailerTypeInformation($retailerTypeId, $retailerInfo){
		return $this->db
		->where('id',$retailerTypeId)	
		->update('retailer_types', $retailerInfo);
	}

	public function delete_retailer($retailerId){
		$this->db->delete('distributor_assignment', array('distributor_id' => $retailerId));
		$this->db->delete('distributor_stock', array('distributor_id' => $retailerId));
		$this->db->delete('access_rights', array('distributor_id' => $retailerId));
		return $this->db->delete('retailers_details', array('id' => $retailerId)); 
	}

	public function delete_retailer_type($retailerTypeId){
		return $this->db->delete('retailer_types', array('id' => $retailerTypeId)); 
	}

	public function delete_retailer_assignment($employeeId, $assignedDay){
		$distributors = $this->db->select('id')->where('retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = "dist")')->get('retailers_details')->result();
		$dists = null;
		foreach($distributors as $distributor) :
			if(!$dists){
				$dists = $distributor->id;
			}else{
				$dists = $dists . ", " . $distributor->id;
			}
		endforeach;
		return $this->db->where('employee_id = '.$employeeId.' and assigned_for_day = "'.$assignedDay.'" and retailer_id IN ('.$dists.')')->delete('retailers_assignment'); 
	}

	public function ViewCompleteRetailersList($employeeId, $assiged_for_day){
		return $this->db->select('(SELECT retailer_name from retailers_details where id = rd.retailer_id) as retailer_name, (SELECT retailer_address from retailers_details where id = rd.retailer_id) as retailer_address, (SELECT territory_name from territory_management where id = (SELECT retailer_territory_id from retailers_details where id = rd.retailer_id)) as territory_name')->where('employee_id = '.$employeeId.' and assigned_for_day = "'.$assiged_for_day.'" and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor  = "dist"))')->get('retailers_assignment rd')->result();
	}

	public function ListRetailersAssignments(){

		$data = $this->db->select('employee_id, assigned_for_day,
		(SELECT CONCAT(employee_first_name, " ", employee_last_name) from employees_info where employee_id = rd.employee_id) as employee,
		(SELECT count(*) FROM `retailers_assignment` where employee_id = rd.employee_id and assigned_for_day = rd.assigned_for_day and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = "dist")) ) as total_distributors_assigned,
		(SELECT territory_name from territory_management where id = (SELECT territory_id from employees_info where employee_id = rd.employee_id)) as territory_name')->where('retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = "dist"))')->get('retailers_assignment rd')->result();
		return $data;
	}

	public function GetSingleRetailerAssignment($employee_id, $assigned_for_day){
		$retailerAssignments = array('details' => $this->db->select('id, retailer_name')->where('id IN (SELECT retailer_id from retailers_assignment where employee_id = '.$employee_id.' and assigned_for_day = "'.$assigned_for_day.'" and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor  = "dist")) )')->get('retailers_details')->result(), 'verbose' => $this->db->select('GROUP_CONCAT(id) as retailer_assignment_id, employee_id, (SELECT CONCAT(employee_first_name, " ", employee_last_name) from employees_info where employee_id = rd.employee_id and assigned_for_day = rd.assigned_for_day) as employee, assigned_for_day')->group_by('employee_id')->where('employee_id='.$employee_id.' and assigned_for_day = "'.$assigned_for_day.'" and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor  = "dist"))')->get('retailers_assignment rd')->row());
		return $retailerAssignments;
	}

	public function AssignRetailers($assignmentsData){
		$retailersForAssignments = "";
		if(isset($assignmentsData["bunchAssignment"])){
			$this->db->query("SET SESSION group_concat_max_len = 1000000");
			if($assignmentsData["bunchAssignment"] == "region"){
				$areaIds = $this->db->select('GROUP_CONCAT(id) as areas')->where('region_id', $assignmentsData["region_id"])->get('area_management')->row()->areas;
				$territory_ids = $this->db->select('GROUP_CONCAT(id) as territories')->where('find_in_set(area_id, ("'.$areaIds.'") )')->get('territory_management')->row()->territories;
			}else if($assignmentsData["bunchAssignment"] == "area"){
				$territory_ids = $this->db->select('GROUP_CONCAT(id) as territories')->where('area_id', $assignmentsData["area_id"])->get('territory_management')->row()->territories;
			}else if($assignmentsData["bunchAssignment"] == "territory"){
				$territory_ids = $assignmentsData["territory_id"];
			}

			$retailersForAssignments = $this->db->select('id')->where('retailer_territory_id IN ('.$territory_ids.') and retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = "dist") and id NOT IN (SELECT retailer_id from retailers_assignment where retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = "dist")) and employee_id != '.$assignmentsData["employee"].' )')->get('retailers_details')->result();
			// $retailersForAssignments = $this->db->select('id')->where('retailer_territory_id IN ('.$territory_ids.') and retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = "dist") and id NOT IN (SELECT retailer_id from retailers_assignment where retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = "dist") ))')->get('retailers_details')->result();
		}

		if ($this->db->where('employee_id = '.$assignmentsData["employee"].' and assigned_for_day = "'.$assignmentsData["assigned_for_day"].'" and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor  = "dist")) ')->get('retailers_assignment')->result()) {
			return "Exist";
		}

		$retailers = explode(",", $assignmentsData["retailersForAssignments"]);
		if(isset($assignmentsData["bunchAssignment"])){
			if(!sizeOf($retailersForAssignments)){
				return "all_retailers_assigned";
			}
			$retailers = $retailersForAssignments;
		}

		$assignmentsBatch = array();
		for ($i=0; $i < sizeof($retailers); $i++) :
			if(isset($assignmentsData["bunchAssignment"])){
				$assignmentsBatch[] = array("employee_id"=>$assignmentsData["employee"], "assigned_for_day"=>$assignmentsData["assigned_for_day"], "retailer_id"=>$retailers[$i]->id);
			}else{
				$assignmentsBatch[] = array("employee_id"=>$assignmentsData["employee"], "assigned_for_day"=>$assignmentsData["assigned_for_day"], "retailer_id"=>$retailers[$i]);
			}
		endfor;

		if(sizeOf($assignmentsBatch)){
			if ($this->db->insert_batch('retailers_assignment', $assignmentsBatch)) :
				return "Success";
			endif;
		}else{
			return "Failed";
		}
	}

	public function UpdateRetailersAssignment($existingEmployeeId, $assignmentsData){
		$retailersForAssignments = "";
		if(isset($assignmentsData["bunchAssignment"])){
			if($assignmentsData["bunchAssignment"] == "region"){
				$areaIds = $this->db->select('GROUP_CONCAT(id) as areas')->where('region_id', $assignmentsData["region_id"])->get('area_management')->row()->areas;
				$territory_ids = $this->db->select('GROUP_CONCAT(id) as territories')->where('find_in_set(area_id, ("'.$areaIds.'") )')->get('territory_management')->row()->territories;
			}else if($assignmentsData["bunchAssignment"] == "area"){
				$territory_ids = $this->db->select('GROUP_CONCAT(id) as territories')->where('area_id', $assignmentsData["area_id"])->get('territory_management')->row()->territories;
			}else if($assignmentsData["bunchAssignment"] == "territory"){
				$territory_ids = $assignmentsData["territory_id"];
			}

			$retailersForAssignments = $this->db->select('id')->where('retailer_territory_id IN ('.$territory_ids.') and retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = "dist") and id NOT IN (SELECT retailer_id from retailers_assignment where retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = "dist")) and employee_id != '.$assignmentsData["employee"].' )')->get('retailers_details')->result();

		}
		
		$retailers = explode(",", $assignmentsData["retailersForAssignments"]);

		if(isset($assignmentsData["bunchAssignment"])){
			if(!sizeOf($retailersForAssignments)){
				return "all_retailers_assigned";
			}
			$retailers = $retailersForAssignments;
		}

		$mainRetailers = $this->db->query('(SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor  = "dist"))')->result();

		if ($this->db->where('employee_id = '. $assignmentsData["employee"] . ' and assigned_for_day = "'.$assignmentsData["assigned_for_day"].'" and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor  = "dist")) and id NOT IN (SELECT id from retailers_assignment rd where employee_id = '.$assignmentsData["employee"] .' and assigned_for_day = "'.$assignmentsData["assigned_for_day"].'" and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor  = "dist")))')->get('retailers_assignment')->result()) {
			return "Exist";
		}

		if($assignmentsData["existing_day"] == $assignmentsData["assigned_for_day"]){
			if ($this->db->where('employee_id = '.$existingEmployeeId.' and assigned_for_day = "'.$assignmentsData["assigned_for_day"].'" and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor  = "dist"))')->delete('retailers_assignment')) :
				$assignmentsBatch = array();
				for ($i=0; $i < sizeof($retailers); $i++) :
					if(isset($assignmentsData["bunchAssignment"])){
						$assignmentsBatch[] = array("employee_id"=>$assignmentsData["employee"], "assigned_for_day"=>$assignmentsData["assigned_for_day"], "retailer_id"=>$retailers[$i]->id);
					}else{
						$assignmentsBatch[] = array("employee_id"=>$assignmentsData["employee"], "assigned_for_day"=>$assignmentsData["assigned_for_day"], "retailer_id"=>$retailers[$i]);
					}
				endfor;
				return $this->db->insert_batch('retailers_assignment', $assignmentsBatch);
			else :
				return false;
			endif;
		}else{
			if ($this->db->where('employee_id = '.$existingEmployeeId.' and assigned_for_day = "'.$assignmentsData["existing_day"].'" and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor  = "dist"))')->delete('retailers_assignment')) :
				$assignmentsBatch = array();
				for ($i=0; $i < sizeof($retailers); $i++) :
					if(isset($assignmentsData["bunchAssignment"])){
						$assignmentsBatch[] = array("employee_id"=>$assignmentsData["employee"], "assigned_for_day"=>$assignmentsData["assigned_for_day"], "retailer_id"=>$retailers[$i]->id);
					}else{
						$assignmentsBatch[] = array("employee_id"=>$assignmentsData["employee"], "assigned_for_day"=>$assignmentsData["assigned_for_day"], "retailer_id"=>$retailers[$i]);
					}
				endfor;
				return $this->db->insert_batch('retailers_assignment', $assignmentsBatch);
			else :
				return false;
			endif;
		}
	}

}

?>
