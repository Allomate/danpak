<?php

class BulletinsModel extends CI_Model{

	public function getAllGroups(){
		return $this->db->select('id, group_name, (SELECT GROUP_CONCAT(employee_username SEPARATOR ", ") from employees_info where find_in_set(employee_id, bg.employee_id)) as employees')->get("bulletin_groups bg")->result();
	}

	public function add_group($bulletinGroupData){
		return $this->db->insert('bulletin_groups', $bulletinGroupData);
	}

	public function getSingleGroup($groupId){
		return $this->db->select('id, group_name, employee_id, (SELECT GROUP_CONCAT(CONCAT(employee_username,":",employee_id) SEPARATOR ",") from employees_info where find_in_set(employee_id, bg.employee_id)) as employees')->where('id', $groupId)->get("bulletin_groups bg")->row();
	}

	public function update_group($groupId, $bulletinGroupData){
		return $this->db
				->where('id',$groupId)	
					->update('bulletin_groups', $bulletinGroupData);
	}

	public function delete_group($groupId){
		return $this->db->delete('bulletin_groups', array('id' => $groupId)); 
	}

	public function getAllMessages(){
		return $this->db->select('id, message, (SELECT group_name from bulletin_groups where id = bmess.group_id) group_name, (SELECT employee_username from employees_info where employee_id = bmess.individual_id) employee')->get("bulletin_messages bmess")->result();
	}

	public function add_message($messageData){
		return $this->db->insert('bulletin_messages', $messageData);
	}

	public function getSingleMessage($messageId){
		return $this->db->where('id', $messageId)->get("bulletin_messages")->row();
	}

	public function update_message($messageId, $messageData){
		return $this->db
				->where('id',$messageId)	
					->update('bulletin_messages', $messageData);
	}

	public function delete_message($groupId){
		return $this->db->delete('bulletin_messages', array('id' => $groupId)); 
	}

}

?>