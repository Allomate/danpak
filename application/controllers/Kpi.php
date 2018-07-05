<?php

class Kpi extends WebAuth_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('AccessRights', 'ar');
	}

	public function EmpKpi(){
		return $this->load->view('Kpi/employee_kpi', [ 'Rights' => $this->ar->getAllRights() ]);
	}

	public function EmpKpiSettings(){
		return $this->load->view('Kpi/employee_kpi_setting', [ 'Rights' => $this->ar->getAllRights() ]);
	}

}

?>
