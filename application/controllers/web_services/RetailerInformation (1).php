<?php

header('Content-Type: application/json');

class RetailerInformation extends Web_Services_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->helper('string');
		$this->load->model('WebServices', 'ws');
	}
	
	public function GetAllRetailers(){
		if ($this->AuthenticateWebServiceCall($this->input->post("api_secret_key"))) :
			if (!$this->AuthenticateSession($this->input->post("session"))) :
				return $this->ResponseMessage('Failed', 'Failed session Authentication');
			else:
				$userSession = $this->input->post();
				$response = $this->ws->GetRetailers($userSession);
				if ($response) :
					return $this->ResponseMessage('Success', $response);
				else:
					return $this->ResponseMessage('Failed', 'No retailers to show');
				endif;	
			endif;
		else:
			return $this->ResponseMessage('Failed', 'Failed Api Authentication');
		endif;
	}
	
	public function GetAllRetailerTypes(){
		if ($this->AuthenticateWebServiceCall($this->input->post("api_secret_key"))) :
			if ($this->ws->GetRetailerTypes()) :
				return $this->ResponseMessage('Success', $this->ws->GetRetailerTypes());
			else:
				return $this->ResponseMessage('Failed', 'No retailer types to show');
			endif;	
		else:
			return $this->ResponseMessage('Failed', 'Failed Api Authentication');
		endif;
	}
	
	public function GetAllAreas(){
		if ($this->AuthenticateWebServiceCall($this->input->post("api_secret_key"))) :
			if ($this->ws->GetAreas()) :
				return $this->ResponseMessage('Success', $this->ws->GetAreas());
			else:
				return $this->ResponseMessage('Failed', 'No Areas to show');
			endif;	
		else:
			return $this->ResponseMessage('Failed', 'Failed Api Authentication');
		endif;
	}
	
	public function GetAllTerritories(){
		if ($this->AuthenticateWebServiceCall($this->input->post("api_secret_key"))) :
			if ($this->ws->GetAreas()) :
				return $this->ResponseMessage('Success', $this->ws->GetTerritories());
			else:
				return $this->ResponseMessage('Failed', 'No Territories to show');
			endif;	
		else:
			return $this->ResponseMessage('Failed', 'Failed Api Authentication');
		endif;
	}
	
	public function AddRetailer(){

		if ($this->AuthenticateWebServiceCall($this->input->post("api_secret_key"))) :
			$retailerInfo = $this->input->post();
			unset($retailerInfo['api_secret_key']);
			if (isset($retailerInfo['retailer_name'], $retailerInfo['retailer_address'], 
				$retailerInfo['retailer_lats'], $retailerInfo['retailer_longs'], 
				$retailerInfo['retailer_territory_id'], $retailerInfo['retailer_city'], $retailerInfo['retailer_phone'], $retailerInfo['retailer_email'], $retailerInfo['retailer_type_id'], $retailerInfo['session'])) :
				$config['upload_path'] = './assets/uploads/retailers/';
			if (isset($retailerInfo['retailer_image_b64'])) :
				$imgData = base64_decode($_POST['retailer_image_b64']);
				$imageName = $config['upload_path'].random_string('alnum', 10).'_'.time().'.jpg';
				$ifp = fopen( $imageName, 'wb' ); 
				fwrite( $ifp, $imgData );
				fclose( $ifp );
				unset($retailerInfo['retailer_image_b64']);
				$retailerInfo['retailer_image'] = $imageName;
			endif;
			$this->form_validation->set_rules('retailer_name', 'Retailer Name', 'max_length[100]');
			$this->form_validation->set_rules('retailer_address', 'Retailer Address', 'max_length[500]');
			$this->form_validation->set_rules('retailer_city', 'Retailer City', 'max_length[100]');
			$this->form_validation->set_rules('retailer_phone', 'Retailer Phone', 'numeric|max_length[100]');
			$this->form_validation->set_rules('retailer_email', 'Retailer Email', 'valid_email|max_length[100]');
			if ($this->form_validation->run()) :
				if ($this->ws->StoreRetailerInformation($retailerInfo)) :
					return $this->ResponseMessage('Success', 'Retailer has been added successfully');
				else:
					return $this->ResponseMessage('Failed', $this->ws->StoreRetailerInformation($retailerInfo));
				endif;
			else:
				$this->form_validation->set_error_delimiters('', '');
				return $this->ResponseMessage('Failed', validation_errors());
			endif;
		else:
			return $this->ResponseMessage('Failed', 'Missing Values');
		endif;
	else:
		return $this->ResponseMessage('Failed', 'Failed Api Authentication');
	endif;

}

public function UpdateRetailer(){
	if ($this->AuthenticateWebServiceCall($this->input->post("api_secret_key"))) :
		$retailerInfo = $this->input->post();
		unset($retailerInfo['api_secret_key']);
		if (isset($retailerInfo['retailer_name'], $retailerInfo['retailer_address'], 
			$retailerInfo['retailer_lats'], $retailerInfo['retailer_longs'], 
			$retailerInfo['retailer_territory_id'], $retailerInfo['retailer_city'], $retailerInfo['retailer_phone'], $retailerInfo['retailer_email'], $retailerInfo['retailer_type_id'], $retailerInfo['session'], $retailerInfo['retailer_id'])) :
			$config['upload_path'] = './assets/uploads/retailers/';
		if (isset($retailerInfo['retailer_image_b64'])) :
			$imgData = base64_decode($_POST['retailer_image_b64']);
			$imageName = $config['upload_path'].random_string('alnum', 10).'_'.time().'.jpg';
			$ifp = fopen( $imageName, 'wb' ); 
			fwrite( $ifp, $imgData );
			fclose( $ifp );
			unset($retailerInfo['retailer_image_b64']);
			$retailerInfo['retailer_image'] = $imageName;
		endif;
		$this->form_validation->set_rules('retailer_name', 'Retailer Name', 'max_length[100]');
		$this->form_validation->set_rules('retailer_address', 'Retailer Address', 'max_length[500]');
		$this->form_validation->set_rules('retailer_city', 'Retailer City', 'max_length[100]');
		$this->form_validation->set_rules('retailer_phone', 'Retailer Phone', 'numeric|max_length[100]');
		$this->form_validation->set_rules('retailer_email', 'Retailer Email', 'valid_email|max_length[100]');

		if ($this->form_validation->run()) :
			$retailerId = $retailerInfo["retailer_id"];
			unset($retailerInfo['retailer_id']);
			if ($this->ws->UpdateRetailerInformation($retailerId, $retailerInfo)) :
				return $this->ResponseMessage('Success', 'Retailer has been updated successfully');
			else:
				return $this->ResponseMessage('Failed', $this->ws->StoreRetailerInformation($retailerInfo));
			endif;
		else:
			$this->form_validation->set_error_delimiters('', '');
			return $this->ResponseMessage('Failed', validation_errors());
		endif;
	else:
		return $this->ResponseMessage('Failed', 'Missing Values');
	endif;
else:
	return $this->ResponseMessage('Failed', 'Failed Api Authentication');
endif;

}

}

?>