<?php

header('Content-Type: application/json');

class Catalogue extends Web_Services_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('WebServices', 'ws');
		global $authentication;
		if (!$this->AuthenticateWebServiceCall($this->input->post("api_secret_key"))) :
			return $this->ResponseMessage('Failed', 'Failed Api Authentication');
		else:
			if (!$this->AuthenticateSession($this->input->post("session"))) :
				return $this->ResponseMessage('Failed', 'Failed session Authentication');
			else:
				$authentication = true;
			endif;
		endif;
	}

	public function GetCatalogue(){
		if ($GLOBALS['authentication']) :
			if ($this->input->post()['retailer_id']) :
				$items = $this->ws->GetCatalogue($this->input->post());
				if ($items) :
					return $this->ResponseMessage('Success', $items);
					foreach ($items as $item) {
						if (isset($item->item_thumbnail) && $item->item_thumbnail != '' && $item->item_thumbnail != null && $item->item_thumbnail != "null") :
							$item->item_thumbnail = base_url(str_replace("./", "", $item->item_thumbnail));
						endif;

						if (isset($item->item_image) && $item->item_image != '' && $item->item_image != null && $item->item_image != "null") :
							$item->item_image = str_replace("./", " ".base_url(), $item->item_image);
						endif;
					}
					return $this->ResponseMessage('Success', $items);
				else:
					return $this->ResponseMessage('Failed', 'No catalogue found');
				endif;
			else:
				return $this->ResponseMessage('Failed', 'Missing values');
			endif;
		endif;
	}

}

?>
