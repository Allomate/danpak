<?php

header('Content-Type: application/json');

class Catalogue extends Web_Services_Controller
{

    public function __construct()
    {
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

    public function GetCatalogue()
    {
		if ($GLOBALS['authentication']):
			$items = array();
            if (isset($this->input->post()['retailer_id'])):
                $items = $this->ws->GetCatalogue($this->input->post());
			else:
				$items = $this->ws->GetCatalogueWithoutRetailer($this->input->post());
            endif;

			if ($items):
				return $this->ResponseMessage('Success', $items);
			else:
				return $this->ResponseMessage('Failed', 'No catalogue found');
			endif;
        endif;
    }

}
