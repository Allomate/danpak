<?php

class LoginModel extends CI_Model{

	public function VerifyLogin($empData){
		if($empData["login_type"] == "danpak"){
			unset($empData["login_type"]);
			$data = $this->db->where(array('employee_username'=>$empData["username"],'employee_password'=>$empData["password"]))->get("employees_info")->row();
			if($data) :
				unset($empData["username"]);
				unset($empData["password"]);
				$empData["admin_id"] = $data->employee_id;
				$this->db->delete('admin_session', array('admin_id' => $data->employee_id));
				return $this->db->insert('admin_session', $empData);
			endif;
		}else{
			unset($empData["login_type"]);
			$data = $this->db->where(array('distributor_username'=>$empData["username"],'distributor_password'=>$empData["password"]))->get("retailers_details")->row();
			if($data) :
				unset($empData["username"]);
				unset($empData["password"]);
				$empData["distributor_id"] = $data->id;
				$this->db->delete('admin_session', array('distributor_id' => $data->id));
				return $this->db->insert('admin_session', $empData);
			endif;
		}
	}

	public function signout($session){
		return $this->db->delete('admin_session', array('session' => $session)); 
	}

}

?>
