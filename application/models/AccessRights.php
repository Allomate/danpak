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
    return $this->db->select('`id`, `admin_id`, `Dashboardv1`, `DashboardHrm`, `DashboardSales`, `Reports`, `Profile`, `ListRegions`, `ListAreas`, `ListTerritories`, `ViewCatalogueAssignments`, `DailyRouting`, `ListCampaigns`, `AddEmployee`, `ListEmployees`, `Attendance`, `EmployeesList`, `AddInventory`, `ListInventory`, `ProductGallery`, `ListMainCategories`, `ListSubCategories`, `ListSubInventory`, `ListUnits`, `ViewCatalogues`, `ListRetailers`, `ListRetailerTypes`, `ListRetailersAssignments`, `ListOrders`, `ListGroups`, `ListMessages`, `UpdateInventorySku`, `ListRights`, (SELECT admin_un from admin_credentials where id = ar.admin_id) as username')->where('admin_id != 1')->get('access_rights ar')->result();    
  }

  public function getAdminsList(){
    return $this->db->select('id, admin_un')->where('id != 1')->get('admin_credentials')->result();
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
    if($this->db->where('admin_id = '.$rightsData["admin_id"].' and id != '.$rightId)->get('access_rights')->row()){
      return "Exist";
    }
    return $this->db->query("UPDATE `access_rights` set ".$rightsData["permisData"]." where id = ".$rightId);  
  }

  public function getRightsDataForAdmin($rightsData){
    return $this->db->where('id', $rightsData)->get('access_rights')->row();
  }

  public function getRightsDataForLoggedInAdmin($admin){
    return $this->db->where('admin_id = (SELECT admin_id from admin_session where session = "'.$admin.'")')->get('access_rights')->row();
  }

  public function DeleteAccRight($rightId){
		return $this->db->delete('access_rights', array('id' => $rightId)); 
  }

}

?>
