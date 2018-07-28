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

	public function getRetailerCompleteProfile($id){

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

	public function delete_retailer_assignment($employeeId, $assignedDay){
		$retailers = $this->db->select('id')->where('retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = "ret")')->get('retailers_details')->result();
		$rets = null;
		foreach($retailers as $retailer) :
			if(!$rets){
				$rets = $retailer->id;
			}else{
				$rets = $rets . ", " . $retailer->id;
			}
		endforeach;
		return $this->db->where('employee_id = '.$employeeId.' and assigned_for_day = "'.$assignedDay.'" and retailer_id IN ('.$rets.')')->delete('retailers_assignment'); 
	}

	public function ViewCompleteRetailersList($employeeId, $assiged_for_day){
		$retailers = $this->db->select('id')->where('retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = "ret")')->get('retailers_details')->result();
		$rets = null;
		foreach($retailers as $retailer) :
			if(!$rets){
				$rets = $retailer->id;
				// return $rets;
			}else{
				$rets = $rets . ", " . $retailer->id;
			}
		endforeach;

		return $this->db->select('(SELECT retailer_name from retailers_details where id = rd.retailer_id) as retailer_name, (SELECT retailer_address from retailers_details where id = rd.retailer_id) as retailer_address, (SELECT territory_name from territory_management where id = (SELECT retailer_territory_id from retailers_details where id = rd.retailer_id)) as territory_name')->where('employee_id = '.$employeeId.' and assigned_for_day = "'.$assiged_for_day.'" and retailer_id IN ('.$rets.')')->get('retailers_assignment rd')->result();
	}

	public function ListRetailersAssignments(){
		$retailers = $this->db->select('id')->where('retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = "ret")')->get('retailers_details')->result();
		$rets = null;
		foreach($retailers as $retailer) :
			if(!$rets){
				$rets = $retailer->id;
				// return $rets;
			}else{
				$rets = $rets . ", " . $retailer->id;
			}
		endforeach;
		$data = $this->db->select('employee_id, assigned_for_day,
		(SELECT CONCAT(employee_first_name, " ", employee_last_name) from employees_info where employee_id = rd.employee_id) as employee,
		(SELECT count(*) FROM `retailers_assignment` where employee_id = rd.employee_id and assigned_for_day = rd.assigned_for_day and retailer_id IN ('.$rets.')) as total_distributors_assigned,
		(SELECT territory_name from territory_management where id = (SELECT territory_id from employees_info where employee_id = rd.employee_id)) as territory_name')->where('retailer_id IN ('.$rets.')')->get('retailers_assignment rd')->result();
		return $data;
	}

	public function GetSingleRetailerAssignment($employee_id, $assiged_for_day){
		$retailers = $this->db->select('id')->where('retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = "ret")')->get('retailers_details')->result();
		$rets = null;
		foreach($retailers as $distributor) :
			if(!$rets){
				$rets = $distributor->id;
			}else{
				$rets = $rets . ", " . $distributor->id;
			}
		endforeach;
		return $this->db->select('GROUP_CONCAT(id) as retailer_assignment_id, employee_id, GROUP_CONCAT(retailer_id order by retailer_id) as retailer_id,
			(SELECT CONCAT(employee_first_name, " ", employee_last_name) from employees_info where employee_id = rd.employee_id and assigned_for_day = rd.assigned_for_day) as employee,
			( SELECT GROUP_CONCAT(retailer_name order by id SEPARATOR "<>") from retailers_details where find_in_set(id, (SELECT GROUP_CONCAT(retailer_id) from retailers_assignment where employee_id = rd.employee_id and assigned_for_day = rd.assigned_for_day and retailer_id IN ('.$rets.')))) as retailer_names,
			( SELECT GROUP_CONCAT(retailer_address order by id SEPARATOR "<br>") from retailers_details where find_in_set(id, (SELECT GROUP_CONCAT(retailer_id) from retailers_assignment where employee_id = rd.employee_id))) as retailer_addresses, assigned_for_day')->group_by('employee_id')->where('employee_id='.$employee_id.' and assigned_for_day = "'.$assiged_for_day.'" and retailer_id IN ('.$rets.')')->get('retailers_assignment rd')->row();
	}

	public function AssignRetailers($assignmentsData){
		$retailers = $this->db->select('id')->where('retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = "ret")')->get('retailers_details')->result();
		$rets = null;
		foreach($retailers as $retailer) :
			if(!$rets){
				$rets = $retailer->id;
			}else{
				$rets = $rets . ", " . $retailer->id;
			}
		endforeach;
		if ($this->db->where('employee_id = '.$assignmentsData["employee"].' and assigned_for_day = "'.$assignmentsData["assigned_for_day"].'" and retailer_id IN ('.$rets.')')->get('retailers_assignment')->result()) {
			return "Exist";
		}
		$retailers = explode(",", $assignmentsData["retailersForAssignments"]);
		$assignmentsBatch = array();
		for ($i=0; $i < sizeof($retailers); $i++) :
			$assignmentsBatch[] = array("employee_id"=>$assignmentsData["employee"], "assigned_for_day"=>$assignmentsData["assigned_for_day"], "retailer_id"=>$retailers[$i]);
		endfor;
		
		if ($this->db->insert_batch('retailers_assignment', $assignmentsBatch)) :
			return "Success";
		else:
			return "Failed";
		endif;
	}

	public function UpdateRetailersAssignment($existingEmployeeId, $assignmentsData){
		$retailers = $this->db->select('id')->where('retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = "ret")')->get('retailers_details')->result();
		$rets = null;
		foreach($retailers as $retailer) :
			if(!$rets){
				$rets = $retailer->id;
			}else{
				$rets = $rets . ", " . $retailer->id;
			}
		endforeach;
		if ($this->db->where('employee_id = '. $assignmentsData["employee"] . ' and assigned_for_day = "'.$assignmentsData['assigned_for_day'].'" and retailer_id IN ('.$rets.') and id NOT IN ('.$assignmentsData['existingAssignmentIds'].')')->get('retailers_assignment')->result()) {
			return "Exist";
		}
		$toDelete = $this->db->select('id')->where('employee_id = '.$existingEmployeeId.' and assigned_for_day = "'.$assignmentsData["assigned_for_day"].'" and retailer_id IN ('.$rets.')')->get('retailers_assignment')->result();
		$deleteIds = null;
		foreach($toDelete as $delete) :
			if(!$deleteIds){
				$deleteIds = $delete->id;
			}else{
				$deleteIds = $deleteIds . ", " . $delete->id;
			}
		endforeach;
		if ($this->db->where('id IN ('.$deleteIds.')')->delete('retailers_assignment')) :
			$retailers = explode(",", $assignmentsData["retailersForAssignments"]);
			$assignmentsBatch = array();
			for ($i=0; $i < sizeof($retailers); $i++) :
				$assignmentsBatch[] = array("employee_id"=>$assignmentsData["employee"], "assigned_for_day"=>$assignmentsData["assigned_for_day"], "retailer_id"=>$retailers[$i]);
			endfor;
			return $this->db->insert_batch('retailers_assignment', $assignmentsBatch);
		else :
			return false;
		endif;
	}

}

?>
