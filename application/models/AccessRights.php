<?php

class AccessRights extends CI_Model{

	public function VerifyRights($func, $adminSess){
    if (!$this->db->field_exists($func, 'access_rights'))
    {
      return true;
    }
		return $this->db->where(''.$func.' = 1 and admin_id = (SELECT admin_id from admin_session where session = "'.$adminSess.'")')->get("access_rights")->row();
  }
    
  public function getAllRights(){
    
    return $this->db->select('id, (SELECT employee_username from employees_info where employee_id = ar.admin_id) as username')->where('admin_id != 1')->get('access_rights ar')->result();    
  }

  public function getAdminsList(){
    return $this->db->select('employee_id, employee_username')->get('employees_info')->result();
  }

  public function addAccRights($rightsData){
    if($this->db->where('admin_id', $rightsData["admin_id"])->get('access_rights')->row()){
      return "Exist";
    }
    if($this->db->query("INSERT INTO `access_rights`(`admin_id`) VALUES (".$rightsData["admin_id"].")")){
      $latId = $this->db->insert_id();
      return $this->db->query("UPDATE `access_rights` set ".$rightsData["permisData"]." where id = ".$latId);  
    }else{
      return false;
    }
  }

  public function updateAccRights($rightsData, $rightId){
    if($this->db->where('admin_id = '.$rightsData["employee_id"].' and id != '.$rightId)->get('access_rights')->row()){
      return "Exist";
    }
    return $this->db->query("UPDATE `access_rights` set ".$rightsData["permisData"].", admin_id = ".$rightsData["employee_id"]." where id = ".$rightId);  
  }

  public function getRightsDataForAdmin($rightId){
    return $this->db->where('id', $rightId)->get('access_rights')->row();
  }

  public function getRightsDataForLoggedInAdmin($admin){
    return $this->db->where('admin_id = (SELECT admin_id from admin_session where session = "'.$admin.'")')->get('access_rights')->row();
  }

  public function DeleteAccRight($rightId){
		return $this->db->delete('access_rights', array('id' => $rightId)); 
  }

}

?>
