<?php

class LoginModel extends CI_Model{

	public function VerifyLogin($empData){
		$data = $this->db->where(array('employee_username'=>$empData["username"],'employee_password'=>$empData["password"]))->get("employees_info")->row();
		if($data) :
			unset($empData["username"]);
			unset($empData["password"]);
			$empData["admin_id"] = $data->employee_id;
			if($this->db->delete('admin_session', array('admin_id' => $data->employee_id)))
				return $this->db->insert('admin_session', $empData);
		endif;
	}

	public function signout($session){
		return $this->db->delete('admin_session', array('session' => $session)); 
	}

}

?>
