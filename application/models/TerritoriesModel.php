<?php

class TerritoriesModel extends CI_Model
{

    public function getAllTerritories()
    {
        return $this->db->select('id, territory_name, (SELECT area_name from area_management where id = tm.area_id) area_name, (SELECT employee_username from employees_info where employee_id = tm.territory_poc_id) territory_poc')->get("territory_management tm")->result();
    }

    public function getAllTerritoriesForListings()
    {
        // $manager = $this->db->select('admin_id')->where('session', $this->session->userdata('session'))->get('admin_session')->row()->admin_id;
        // if($this->db->select('is_admin')->where('employee_id', $manager)->get('employees_info')->row()->is_admin === "1"){
        return $this->db->select('id, territory_name, (SELECT area_name from area_management where id = tm.area_id) area_name, (SELECT employee_username from employees_info where employee_id = tm.territory_poc_id) territory_poc')->get("territory_management tm")->result();
        // }else{
        // return $this->db->select('id, territory_name, (SELECT area_name from area_management where id = tm.area_id) area_name, (SELECT employee_username from employees_info where employee_id = tm.territory_poc_id) territory_poc')->where('territory_poc_id', $manager)->get("territory_management tm")->result();
        // }
    }

    public function add_territory($territoryData, $zones)
    {
        unset($territoryData["zones"]);
        $this->db->insert('territory_management', $territoryData);
        $terrId = $this->db->insert_id();
        $this->db
            ->where('employee_id', $territoryData["territory_poc_id"])
            ->update('employees_info', ["territory_id" => $terrId]);
        $zonesData = array();
        foreach ($zones as $z) {
            $zonesData[] = array('territory_id' => $terrId, 'zone_name' => $z);
        }
		return $this->db->insert_batch('zones_management', $zonesData);
    }

    public function getSingleTerritory($territoryId)
    {
        return $this->db->select('id, territory_name, territory_poc_id, area_id, (SELECT GROUP_CONCAT(zone_name SEPARATOR "<>") FROM `zones_management` where territory_id = '.$territoryId.') as zones')->where('id', $territoryId)->get("territory_management")->row();
    }

    public function update_territory($territoryId, $territoryData, $zones)
    {
        unset($territoryData["zones"]);
        $this->db
            ->where('id', $territoryId)
            ->update('territory_management', $territoryData);
        $this->db
            ->where('employee_id', $territoryData["territory_poc_id"])
            ->update('employees_info', ["territory_id" => $territoryId]);
        $this->db->delete('zones_management', array('territory_id' => $territoryId));
        $zonesData = array();
        foreach (explode("<>", $zones) as $z) {
            $zonesData[] = array('territory_id' => $territoryId, 'zone_name' => $z);
        }
		return $this->db->insert_batch('zones_management', $zonesData);
    }

    public function delete_territory($territoryId)
    {
        return $this->db->delete('territory_management', array('id' => $territoryId));
    }

    public function getMerchantsInTerritory($territoryId)
    {
        return $this->db->select('retailer_lats, retailer_longs, retailer_name')->where('retailer_territory_id', $territoryId)->get('retailers_details')->result();
    }

}
