<?php

class AreasModel extends CI_Model{

	public function getAllAreas(){
		return $this->db->select('id, area_name, (SELECT region_name from regions_info where id = am.region_id) region_name, (SELECT employee_username from employees_info where employee_id = am.area_poc_id) area_poc')->get("area_management am")->result();
	}

	public function add_area($areaData){
		return $this->db->insert('area_management', $areaData);
	}

	public function getSingleArea($areaId){
		return $this->db->where('id', $areaId)->get("area_management")->row();
	}

	public function update_area($areaId, $areaData){
		return $this->db
				->where('id',$areaId)	
					->update('area_management', $areaData);
	}

	public function delete_area($areaId){
		return $this->db->delete('area_management', array('id' => $areaId)); 
	}

	public function getMerchantsInArea($areaId){
		return $this->db->select('retailer_lats, retailer_longs')->where('find_in_set(retailer_territory_id, (SELECT GROUP_CONCAT(id) from territory_management where area_id = '.$areaId.'))')->get('retailers_details')->result();
	}

}

?>