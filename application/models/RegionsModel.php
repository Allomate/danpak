<?php

class RegionsModel extends CI_Model{

	public function getAllRegions(){
		return $this->db->select('id, region_name, (SELECT employee_username from employees_info where employee_id = ri.region_poc_id) region_poc')->get("regions_info ri")->result();
	}

	public function add_region($regionData){
		return $this->db->insert('regions_info', $regionData);
	}

	public function getSingleRegion($regionId){
		return $this->db->where('id', $regionId)->get("regions_info")->row();
	}

	public function update_region($regionId, $regionData){
		return $this->db
				->where('id',$regionId)	
					->update('regions_info', $regionData);
	}

	public function delete_region($regionId){
		return $this->db->delete('regions_info', array('id' => $regionId)); 
	}

	public function getMerchantsInRegion($regionId){
		return $this->db->select('retailer_lats, retailer_longs')->where('find_in_set(retailer_territory_id, (SELECT GROUP_CONCAT(id) from territory_management where find_in_set(area_id, (SELECT GROUP_CONCAT(id) from area_management where region_id = '.$regionId.' ))))')->get('retailers_details')->result();
	}

}

?>