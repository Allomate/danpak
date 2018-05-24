<?php

class Organization extends WebAuth_Controller{

	public function __construct(){
		parent::__construct();
	}

	public function Profile(){
		$this->load->view('Organization/Profile');
	}

}

?>