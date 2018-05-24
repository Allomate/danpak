<?php

class TerritoriesModel extends CI_Model{

	public function getAllTerritories(){
		return $this->db->select('id, territory_name, (SELECT area_name from area_management where id = tm.area_id) area_name, (SELECT employee_username from employees_info where employee_id = tm.territory_poc_id) territory_poc')->get("territory_management tm")->result();
	}

	public function add_territory($territoryData){
		return $this->db->insert('territory_management', $territoryData);
	}

	public function getSingleTerritory($territoryId){
		return $this->db->where('id', $territoryId)->get("territory_management")->row();
	}

	public function update_territory($territoryId, $territoryData){
		return $this->db
				->where('id',$territoryId)	
					->update('territory_management', $territoryData);
	}

	public function delete_territory($territoryId){
		return $this->db->delete('territory_management', array('id' => $territoryId)); 
	}

	public function getMerchantsInTerritory($territoryId){
		return $this->db->select('retailer_lats, retailer_longs')->where('retailer_territory_id', $territoryId)->get('retailers_details')->result();
	}

}

?>