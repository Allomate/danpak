<?php

header('Content-Type: application/json');

class User extends Web_Services_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->helper('string');
		$this->load->model('WebServices', 'ws');
		global $authentication;
		if (!$this->AuthenticateWebServiceCall($this->input->post("api_secret_key"))) :
			return $this->ResponseMessage('Failed', 'Failed Api Authentication');
		else:
			$authentication = true;
		endif;
	}

	public function Login(){
		if ($GLOBALS['authentication']) :
			$loginInfo = $this->input->post();
			$failedLoginInfo = $this->input->post();
			unset($failedLoginInfo["api_secret_key"]);
			if (!$loginInfo['username'] || !$loginInfo['password']) :
				return $this->ResponseMessage('Failed', 'Missing Username/Password');
			else:
				$loginInfo['password'] = sha1($loginInfo['password']);
				$loginInfo['session'] = random_string('alnum', 50);
				if ($this->ws->AuthenticateLogin($loginInfo)) :
					unset($loginInfo['password']);
					unset($loginInfo['api_secret_key']);
					$failedLoginInfo["status"] = "authenticated";
					$this->ws->StoreLoginAttempt($failedLoginInfo);
					if ($this->ws->GenerateSession($loginInfo)) :
						return $this->ResponseMessage('Success', array('session'=>$loginInfo['session']));
					else:
						return $this->ResponseMessage('Failed', 'Unable to generate session at the time. Please try again');
					endif;
				else:
					$this->ws->StoreLoginAttempt($failedLoginInfo);
					return $this->ResponseMessage('Failed', 'Invalid Username/Password');
				endif;
			endif;
		endif;
	}

	public function Signout(){
		if ($GLOBALS['authentication']) :
			$signoutInfo = $this->input->post();
			if (!$signoutInfo['session']) :
				return $this->ResponseMessage('Failed', 'Missing session');
			else:
				if ($this->AuthenticateSession($this->input->post("session"))) :
					if ($this->ws->RemoveSessionSignout($signoutInfo)) :
						return $this->ResponseMessage('Success', 'Sign out has been successfully');
					else:
						return $this->ResponseMessage('Failed', 'Unable to sign out at the time. Please try again');
					endif;
				else:
					return $this->ResponseMessage('Failed', 'Failed session Authentication');
				endif;
			endif;
		endif;
	}

}

?>
