<?php

class InventoryModel extends CI_Model{

	public function get_inventory(){
		return $this->db->select('*')->get("inventory")->result();
	}

	public function add_inventory($itemData){
		return $this->db->insert('inventory', $itemData);
	}

	public function get_single_item_details($item_id){
		return $this->db->where('item_id', $item_id)->get("inventory")->row();
	}

	public function update_inventory($item_id, $item_data){
		return $this->db
				->where('item_id',$item_id)	
					->update('inventory', $item_data);
	}

	public function delete_inventory($item_id){
		return $this->db->delete('inventory', array('item_id' => $item_id)); 
	}

}

?>