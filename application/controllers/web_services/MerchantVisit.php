<?php

header('Content-Type: application/json');

class MerchantVisit extends Web_Services_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('WebServices', 'ws');
		global $authentication;
		if (!$this->AuthenticateWebServiceCall($this->input->post("api_secret_key"))) :
			return $this->ResponseMessage('Failed', 'Failed Api Authentication');
		endif;
	}

	public function MarkVisit(){
		if (!$this->AuthenticateSession($this->input->post("session"))) :
			return $this->ResponseMessage('Failed', 'Failed session Authentication');
		endif;
		$markVisit = $this->input->post();
		if ($markVisit['retailer_id']) :
			unset($markVisit["api_secret_key"]);
			$visitStatus = $this->ws->MarkVisit($markVisit);
			if ($visitStatus == "Success") :
				return $this->ResponseMessage('Success', 'Visit marked successfully');
			else:
				return $this->ResponseMessage('Failed', $visitStatus);
			endif;
		else:
			return $this->ResponseMessage('Failed', 'Missing values');
		endif;
	}

	public function DoneVisits(){
		if (!$this->AuthenticateSession($this->input->post("session"))) :
			return $this->ResponseMessage('Failed', 'Failed session Authentication');
		endif;
		$doneVisits = $this->input->post();
		unset($doneVisits["api_secret_key"]);
		$doneVisits = $this->ws->DoneVisits($doneVisits);
		if ($doneVisits == "No visits done"):
			return $this->ResponseMessage('Failed', $doneVisits);
		elseif ($doneVisits == "No retailers in plan today"):
			return $this->ResponseMessage('Failed', $doneVisits);
		elseif ($doneVisits == "No retailers assigned"):
			return $this->ResponseMessage('Failed', $doneVisits);
		else:
			return $this->ResponseMessage('Success', $doneVisits);
		endif;
	}

	public function GetMerchantMarkStatusForToday(){
		$getMarkStatus = $this->input->post();
		if ($getMarkStatus['retailer_id']) :
			unset($getMarkStatus["api_secret_key"]);
			$visitStatus = $this->ws->GetMarkStatus($getMarkStatus);
			if ($visitStatus == "Marked" || $visitStatus == "Unmarked") :
				return $this->ResponseMessage('Success', $visitStatus);
			else:
				return $this->ResponseMessage('Failed', $visitStatus);
			endif;
		else:
			return $this->ResponseMessage('Failed', 'Missing values');
		endif;
	}

	public function PlanVisits(){
		if (!$this->AuthenticateSession($this->input->post("session"))) :
			return $this->ResponseMessage('Failed', 'Failed session Authentication');
		endif;
		$visitPlanning = $this->input->post();
		if ($visitPlanning['retailersList']) :
			unset($visitPlanning["api_secret_key"]);
			$visitStatus = $this->ws->VisitPlan($visitPlanning);
			if ($visitStatus) :
				if ($visitStatus == "plan_exist") :
					return $this->ResponseMessage('Failed', 'Plan already made for today');
				else:
					return $this->ResponseMessage('Success', 'Plan created successfully');
				endif;
			else:
				return $this->ResponseMessage('Failed', $visitStatus);
			endif;
		else:
			return $this->ResponseMessage('Failed', 'Missing values');
		endif;
	}

	public function UpdatePlanVisits(){
		if (!$this->AuthenticateSession($this->input->post("session"))) :
			return $this->ResponseMessage('Failed', 'Failed session Authentication');
		endif;
		$visitPlanning = $this->input->post();
		if ($visitPlanning['retailersList']) :
			unset($visitPlanning["api_secret_key"]);
			$visitStatus = $this->ws->UpdateVisitPlan($visitPlanning);
			if ($visitStatus) :
				return $this->ResponseMessage('Success', 'Plan Updated successfully');
			else:
				return $this->ResponseMessage('Failed', $visitStatus);
			endif;
		else:
			return $this->ResponseMessage('Failed', 'Missing values');
		endif;
	}

	public function GetPlanVisit(){
		if (!$this->AuthenticateSession($this->input->post("session"))) :
			return $this->ResponseMessage('Failed', 'Failed session Authentication');
		endif;
		$visitPlan = $this->input->post();
		unset($visitPlan["api_secret_key"]);
		$visitStatus = $this->ws->GetVisitPlan($visitPlan);
		if ($visitStatus) :
			if ($visitStatus == "no_plan") :
				return $this->ResponseMessage('Failed', 'No plan exist for today');
			else:
				return $this->ResponseMessage('Success', $visitStatus);
			endif;
		else:
			return $this->ResponseMessage('Failed', $visitStatus);
		endif;
	}

}

?>