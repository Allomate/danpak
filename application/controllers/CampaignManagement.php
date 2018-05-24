<?php

class CampaignManagement extends WebAuth_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('CataloguesModel', 'catm');
		$this->load->model('CampaignModel', 'cam');
	}

	public function ListCampaigns(){
		return $this->load->view('Campaign/ListCampaigns', [ 'Campaigns' => $this->cam->getAllCampaigns() ]);
	}

	public function AddCampaign(){
		return $this->load->view('Campaign/AddCampaign', [ 'Inventory' => $this->catm->GetAllInventory() ]);
	}

	public function AddCampaignOps()
	{
		$campaignData = $this->input->post();

		if($campaignData["scheme_type"] == "1") : 
			$campaignData["distributor_discount"] = $campaignData['discount_on_scheme'];
			unset($campaignData['price_discount_of_this_pref_id']);
			unset($campaignData['discount_on_scheme']);
			unset($campaignData['discount_on_tp']);
			$this->form_validation->set_rules('campaign_name', 'Campaign Name', 'required|max_length[100]');
			$this->form_validation->set_rules('eligibility_criteria_pref_id', 'Eligibility Criteria', 'required');
			$this->form_validation->set_rules('minimum_quantity_for_eligibility', 'Minimum quantity for eligibility', 'required');
			$this->form_validation->set_rules('item_given_free_pref_id', '+1 item', 'required');
			$this->form_validation->set_rules('quantity_for_free_item', '+1 item quantity', 'required');
			$this->form_validation->set_rules('scheme_amount', 'Scheme Amount', 'required');
		else:
			$campaignData["discount_on_tp_pkr"] = $campaignData['discount_on_tp'];
			unset($campaignData['item_given_free_pref_id']);
			unset($campaignData['quantity_for_free_item']);
			unset($campaignData['discount_on_tp']);
			unset($campaignData['scheme_amount']);
			unset($campaignData['discount_on_scheme']);
			$this->form_validation->set_rules('campaign_name', 'Campaign Name', 'required|max_length[100]');
			$this->form_validation->set_rules('eligibility_criteria_pref_id', 'Eligibility Criteria', 'required');
			$this->form_validation->set_rules('minimum_quantity_for_eligibility', 'Minimum quantity for eligibility', 'required');
			$this->form_validation->set_rules('price_discount_of_this_pref_id', 'Price discount', 'required');
		endif;

		if ($this->form_validation->run()) :
			if ($this->cam->add_campaign($campaignData)) :
				$this->session->set_flashdata("campaign_created", "Campaign has been created successfully");
			else:
				$this->session->set_flashdata("campaign_creation_failed", "Failed to create the campaign");
			endif;
			return redirect('CampaignManagement/ListCampaigns');
		else:
			return $this->load->view('Campaign/AddCampaign', [ 'Inventory' => $this->catm->GetAllInventory() ]);
		endif;
	}

	public function GetCampaignDetailsForAjax(){
		echo json_encode($this->cam->getCampaignDetails($this->input->post('campaign_id')));
	}

	public function GetItemPriceForSchemeAmountCalculationAjax(){
		echo json_encode($this->cam->getItemPrice($this->input->post('pref_id')));
	}

	public function UpdateCampaign($campaignId){
	}

	public function UpdateCampaignOps($campaignId)
	{
	}

	public function DeleteCampaign($campaignId)
	{
	}

}

?>