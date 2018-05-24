<?php

class Login extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->helper('string');
		$this->load->model('LoginModel', 'lm');
		if($this->uri->segment(2) != 'SignOut'){
			if($this->session->userdata('session')){
				return redirect('Dashboard/Home');
			}
		}
	}

	public function index(){
		return $this->load->view('login');
	}

	public function AdminLoginOps()
	{
		$this->form_validation->set_rules('username', 'User Name', 'required|max_length[100]');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if ($this->form_validation->run()) {
			$adminData = $this->input->post();
			$adminData["password"] = sha1($adminData["password"]);
			$adminData["session"] = random_string('alnum', 50);
			if ($this->lm->VerifyLogin($adminData)) :
				$adminLogin = array(
					'session' => $adminData["session"]
				);

				$this->session->set_userdata($adminLogin);

				return redirect('Dashboard/Home');
			else:
				$this->session->set_flashdata("login_failed", "Invalid credentials. Please try again");
				return redirect('Dashboard');
			endif;
		}else{
			return $this->load->view('login');
		}
	}

	public function SignOut(){
		if($this->lm->signout($this->session->userdata('session')))
			$this->session->unset_userdata('session');
		return redirect('Login');
	}

}

?>