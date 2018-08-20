<?php

header('Content-Type: application/json');

class Campaign extends Web_Services_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('WebServices', 'ws');
		global $authentication;
		
		if (!$this->AuthenticateWebServiceCall($this->input->post("api_secret_key"))):
            return $this->ResponseMessage('Failed', 'Failed Api Authentication');
        else:
            if (!$this->AuthenticateSession($this->input->post("session"))):
                return $this->ResponseMessage('Failed', 'Failed session Authentication');
            else:
                $authentication = true;
            endif;
        endif;
	}

	public function AddToCart(){
		if ($GLOBALS['authentication']) :
			if ($this->input->post()['retailer_id'] && $this->input->post()['campaign_id'] && $this->input->post()['item_quantity']) :
                $campaign = $this->ws->AddCampaignToCart($this->input->post());
                if(!is_object($campaign)){
                    return $this->ResponseMessage('Failed', $campaign);
                }
                return $this->ResponseMessage('Success', $campaign);
			else:
				return $this->ResponseMessage('Failed', 'Missing values');
            endif;
		endif;
	}

	public function GetCampaigns(){
		if ($GLOBALS['authentication']) :
			$campaigns = $this->ws->GetCampaigns($this->input->post("session"));
			return $this->ResponseMessage('Success', $campaigns);
		endif;
	}

}

?>
