<?php

class LoginModel extends CI_Model{

	public function VerifyLogin($adminData){
		$data = $this->db->where(array('admin_un'=>$adminData["username"],'admin_pw'=>$adminData["password"]))->get("admin_credentials")->row();
		if($data) :
			unset($adminData["username"]);
			unset($adminData["password"]);
			$adminData["admin_id"] = $data->id;
			if($this->db->delete('admin_session', array('admin_id' => $data->id)))
				return $this->db->insert('admin_session', $adminData);
		endif;
	}

	public function signout($session){
		return $this->db->delete('admin_session', array('session' => $session)); 
	}

}

?>