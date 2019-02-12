<?php

class CampaignManagement extends WebAuth_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('CataloguesModel', 'catm');
		$this->load->model('CampaignModel', 'cam');
		$this->load->model('RegionsModel', 'rm');
		$this->load->model('AreasModel', 'am');
		$this->load->model('TerritoriesModel', 'tm');
	}

	public function ListCampaigns(){
		return $this->load->view('Campaign/ListCampaigns', [ 'Campaigns' => $this->cam->getAllCampaigns() ]);
	}

	public function AddCampaign(){
		// echo "<pre>"; print_r($this->catm->GetAllInventory());die;
		return $this->load->view('Campaign/AddCampaign', [ 'Inventory' => $this->catm->GetAllInventory(), 'Regions' => $this->rm->getAllRegions(), 'Areas' => $this->am->getAllAreas(), 'Territories' => $this->tm->getAllTerritories() ]);
	}

	public function AddCampaignOps()
	{
		$campaignData = $this->input->post();

		// echo "<pre>"; print_r($campaignData);die;
		
		if($campaignData["scheme_type"] == "1") : 
			unset($campaignData['price_discount_of_this_pref_id']);
			unset($campaignData['discount_on_scheme']);
			unset($campaignData['discount_on_tp']);
			$this->form_validation->set_rules('campaign_name', 'Campaign Name', 'required|max_length[100]');
			$this->form_validation->set_rules('eligibility_criteria_pref_id', 'Eligibility Criteria', 'required');
			$this->form_validation->set_rules('minimum_quantity_for_eligibility', 'Minimum quantity for eligibility', 'required');
			$this->form_validation->set_rules('item_given_free_pref_id', '+1 item', 'required');
			$this->form_validation->set_rules('quantity_for_free_item', '+1 item quantity', 'required');
			$this->form_validation->set_rules('scheme_amount', 'Scheme Amount', 'required');
		elseif($campaignData["scheme_type"] == "2"):
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
		else:
			unset($campaignData['item_given_free_pref_id']);
			unset($campaignData['quantity_for_free_item']);
			unset($campaignData['discount_on_tp']);
			unset($campaignData['scheme_amount']);
			unset($campaignData['discount_on_scheme']);
			unset($campaignData['price_discount_of_this_pref_id']);
			
			$this->form_validation->set_rules('campaign_name', 'Campaign Name', 'required|max_length[100]');
			$this->form_validation->set_rules('eligibility_criteria_pref_id', 'Eligibility Criteria', 'required');
			$this->form_validation->set_rules('minimum_quantity_for_eligibility', 'Minimum quantity for eligibility', 'required');
			$this->form_validation->set_rules('price_discount_of_this_pref_id', 'Price discount', 'required');
		endif;

		$config['upload_path'] = './assets/uploads/campaign/';
		$config['allowed_types'] = 'jpg|bmp|png|jpeg';
		$this->load->helper('file');
		$this->load->library('upload', $config);
		$scheme_image = '';

		if ($this->form_validation->run()) :

			if (isset($_FILES['scheme_image'])) {
				if($_FILES['scheme_image']['name'] !== ''){
					$_FILES['userfile']['name'] = time().'-'.trim($_FILES['scheme_image']['name']);
					$_FILES['userfile']['type'] = $_FILES['scheme_image']['type'];
					$_FILES['userfile']['tmp_name'] = $_FILES['scheme_image']['tmp_name'];
					$_FILES['userfile']['error']    = isset($_FILES['scheme_image']['error']) ? $_FILES['scheme_image']['error'] : '';
					$_FILES['userfile']['size'] = $_FILES['scheme_image']['size'];
					if (!$this->upload->do_upload()) :
						$this->load->view('Campaign/AddCampaign', [ 'Inventory' => $this->catm->GetAllInventory(), 'scheme_image_error'=>$this->upload->display_errors() ]);
					else :
						$file_data = $this->upload->data();
						$scheme_image = $config['upload_path'].$file_data['file_name'];
					endif;
				}
			}

			if (isset($_FILES['scheme_image_disc_tp'])) {
				if($_FILES['scheme_image_disc_tp']['name'] !== ''){
					$_FILES['userfile']['name'] = time().'-'.trim($_FILES['scheme_image_disc_tp']['name']);
					$_FILES['userfile']['type'] = $_FILES['scheme_image_disc_tp']['type'];
					$_FILES['userfile']['tmp_name'] = $_FILES['scheme_image_disc_tp']['tmp_name'];
					$_FILES['userfile']['error']    = isset($_FILES['scheme_image_disc_tp']['error']) ? $_FILES['scheme_image_disc_tp']['error'] : '';
					$_FILES['userfile']['size'] = $_FILES['scheme_image_disc_tp']['size'];
					if (!$this->upload->do_upload()) :
						$this->load->view('Campaign/AddCampaign', [ 'Inventory' => $this->catm->GetAllInventory(), 'scheme_image_disc_tp_error'=>$this->upload->display_errors() ]);
					else :
						$file_data = $this->upload->data();
						$scheme_image = $config['upload_path'].$file_data['file_name'];
					endif;
				}
			}

			if (isset($_FILES['scheme_image_gift'])) {
				if($_FILES['scheme_image_gift']['name'] !== ''){
					$_FILES['userfile']['name'] = time().'-'.trim($_FILES['scheme_image_gift']['name']);
					$_FILES['userfile']['type'] = $_FILES['scheme_image_gift']['type'];
					$_FILES['userfile']['tmp_name'] = $_FILES['scheme_image_gift']['tmp_name'];
					$_FILES['userfile']['error']    = isset($_FILES['scheme_image_gift']['error']) ? $_FILES['scheme_image_gift']['error'] : '';
					$_FILES['userfile']['size'] = $_FILES['scheme_image_gift']['size'];
					if (!$this->upload->do_upload()) :
						$this->load->view('Campaign/AddCampaign', [ 'Inventory' => $this->catm->GetAllInventory(), 'scheme_image_gift_error'=>$this->upload->display_errors() ]);
					else :
						$file_data = $this->upload->data();
						$scheme_image = $config['upload_path'].$file_data['file_name'];
					endif;
				}
			}

			$campaignData["scheme_image"] = $scheme_image;
			// echo "<pre>"; print_r($campaignData);die;
		
			if($campaignData["bulk_assignment"] == "area"){
				unset($campaignData["region_id"]);
				unset($campaignData["territory_id"]);
			}else if($campaignData["bulk_assignment"] == "region"){
				unset($campaignData["territory_id"]);
				unset($campaignData["area_id"]);
			}else if($campaignData["bulk_assignment"] == "territory"){
				unset($campaignData["region_id"]);
				unset($campaignData["area_id"]);
			}
			unset($campaignData["bulk_assignment"]);

			// echo "<pre>"; print_r($campaignData);die;

			if ($this->cam->add_campaign($campaignData)) :
				$this->session->set_flashdata("campaign_created", "Scheme has been created successfully");
			else:
				$this->session->set_flashdata("campaign_creation_failed", "Failed to create the scheme");
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

	public function DeactivateCampaign($campaignId)
	{
		if ($this->cam->deactivate_campaign($campaignId)) :
			$this->session->set_flashdata("campaign_deactivated", "Scheme has been deactivated");
		else:
			$this->session->set_flashdata("campaign_deactivation_failed", "Failed to deactivate scheme");
		endif;
		return redirect('CampaignManagement/ListCampaigns');
	}

}

?>
