<?php

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('string');
        $this->load->model('LoginModel', 'lm');
        if ($this->uri->segment(2) != 'SignOut') {
            if ($this->session->userdata('session')) {
                return redirect('Dashboard/Home');
            }
        }
    }

    public function index()
    {
        return $this->load->view('login');
    }

    public function AdminLoginOps()
    {
        $this->form_validation->set_rules('username', 'User Name', 'required|max_length[100]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run()) {
            $empData = $this->input->post();
            $empData["password"] = sha1($empData["password"]);
            $empData["session"] = random_string('alnum', 50);
            // echo "<pre>"; print_r($empData);die;
            // echo "<pre>"; print_r($this->lm->VerifyLogin($empData));die;
            if ($this->lm->VerifyLogin($empData)):
                $empLogin = array(
                    'session' => $empData["session"],
                    'user_type' => $empData["login_type"]
				);
				
                $this->session->set_userdata($empLogin);

                return redirect('Dashboard/Home');
            else:
                $this->session->set_flashdata("login_failed", "Invalid credentials. Please try again");
                return redirect("Login/");
            endif;
        } else {
            return $this->load->view('login');
        }
    }

    public function SignOut()
    {
        if ($this->lm->signout($this->session->userdata('session'))) {
            $this->session->unset_userdata('session');
        }

        return redirect('Login');
    }

}
