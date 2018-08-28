<?php

class AccessRights extends CI_Model{

	public function VerifyRights($func, $adminSess){
    if($this->session->userdata("user_type") == "danpak"){
      if (!$this->db->field_exists($func, 'access_rights'))
      {
        return true;
      }
      return $this->db->where(''.$func.' = 1 and admin_id = (SELECT admin_id from admin_session where session = "'.$adminSess.'")')->get("access_rights")->row();
    }else{
      if (!$this->db->field_exists($func, 'access_rights'))
      {
        return true;
      }
      return $this->db->where(''.$func.' = 1 and distributor_id = (SELECT distributor_id from admin_session where session = "'.$adminSess.'")')->get("access_rights")->row();
    }
  }
    
  public function getAllRights(){
    return $this->db->select('id, (SELECT employee_username from employees_info where employee_id = ar.admin_id) as username, (SELECT retailer_name from retailers_details where id = ar.distributor_id) as distributor_name, (case when admin_id is null then "distributor" else "danpak" end) as user_type')->get('access_rights ar')->result();    
  }

  public function getAdminsList(){
    return $this->db->select('employee_id, employee_username')->get('employees_info')->result();
  }

  public function addAccRights($rightsData){
    if($rightsData["admin_id"] != "null"){
      if($this->db->where('admin_id', $rightsData["admin_id"])->get('access_rights')->row()){
        return "Exist";
      }
      
      if($this->db->query("INSERT INTO `access_rights`(`admin_id`) VALUES (".$rightsData["admin_id"].")")){
        $latId = $this->db->insert_id();
        return $this->db->query("UPDATE `access_rights` set ".$rightsData["permisData"]." where id = ".$latId);  
      }else{
        return false;
      }
    }else{
      if($this->db->where('distributor_id', $rightsData["distributor_id"])->get('access_rights')->row()){
        return "Exist";
      }

      if($this->db->query("INSERT INTO `access_rights`(`distributor_id`) VALUES (".$rightsData["distributor_id"].")")){
        $latId = $this->db->insert_id();
        return $this->db->query("UPDATE `access_rights` set ".$rightsData["permisData"]." where id = ".$latId);  
      }else{
        return false;
      }
    }
  }

  public function updateAccRights($rightsData, $rightId){
    if($rightsData["admin_id"] != "null"){
      if($this->db->where('admin_id = '.$rightsData["admin_id"].' and id != '.$rightId)->get('access_rights')->row()){
        return "Exist";
      }
      return $this->db->query("UPDATE `access_rights` set ".$rightsData["permisData"].", admin_id = ".$rightsData["admin_id"]." where id = ".$rightId);  
    }else{
      if($this->db->where('distributor_id = '.$rightsData["distributor_id"].' and id != '.$rightId)->get('access_rights')->row()){
        return "Exist";
      }
      return $this->db->query("UPDATE `access_rights` set ".$rightsData["permisData"].", distributor_id = ".$rightsData["distributor_id"]." where id = ".$rightId);  
    }
  }

  public function getRightsDataForAdmin($rightId, $userType){
    return $this->db->where('id', $rightId)->get('access_rights')->row();
  }

  public function getRightsDataForLoggedInAdmin($admin){

    if($this->session->userdata("user_type") == "danpak"){
      return $this->db->where('admin_id = (SELECT admin_id from admin_session where session = "'.$admin.'")')->get('access_rights')->row();
    }else{
      return $this->db->where('distributor_id = (SELECT distributor_id from admin_session where session = "'.$admin.'")')->get('access_rights')->row();
    }

  }

  public function DeleteAccRight($rightId){
		return $this->db->delete('access_rights', array('id' => $rightId)); 
  }

}

?>
