<?php

class Dashboard extends WebAuth_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('EmployeeReporting', 'erp');
	}
	
	public function Home(){
		return $this->load->view('index');
	}
	
	public function Reports(){
		$reportings = $this->erp->GetReporting();
		$finalReportings = array();
		foreach($reportings as $reporting) :
			// if($reporting->reportees)
				$finalReportings[] = array('employee_username' => $reporting->employee_username, 'reportees' => $reporting->reportees);
		endforeach;

		$loopedThroughEmployees = array();
		foreach($finalReportings as $fp) :
			if(!in_array($fp["employee_username"], $loopedThroughEmployees)){
				$reportees = explode(",", $fp["reportees"]);
				if(sizeOf($reportees)){
					echo "<ul><li>".$fp["employee_username"]."<ul>";
					$loopedThroughEmployees[] = $fp["employee_username"];
					foreach($reportees as $reportee) :
						$reportees = null;
						foreach($finalReportings as $fpInner) :
							if($fpInner["employee_username"] == $reportee) :
								$loopedThroughEmployees[] = $fpInner["employee_username"];
								$reportees = explode(",", $fpInner["reportees"]);
							endif;
						endforeach;
						if($reportees){
							$reportees = array_filter($reportees);
							echo "<li>".$reportee." <ul>";
							foreach($reportees as $newReportees) :
								echo "<li>".$newReportees."</li>";
								$loopedThroughEmployees[] = $newReportees;
							endforeach;
							echo " </ul></li>";
						}
					endforeach;
					echo "</ul></li></ul>";
				}
			}
		endforeach;
		die;

		// echo "<pre>";print_r($finalReportings);die;
		return $this->load->view('Reporting&Dashboard/Reports', [ 'Reporting' => $finalReportings ]);
	}
	
	public function Dashboardv1(){
		return $this->load->view('Reporting&Dashboard/Dashboardv1');
	}
	
	public function DashboardHrm(){
		return $this->load->view('Reporting&Dashboard/HRMS');
	}

	public function DashboardSales(){
		return $this->load->view('Reporting&Dashboard/SalesAnalytics');
	}

}

?>