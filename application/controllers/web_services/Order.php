<?php

header('Content-Type: application/json');

class Order extends Web_Services_Controller{

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

	public function BookOrder(){
		if ($GLOBALS['authentication']) :
			$orderDetails = $this->input->post();
			if (isset($orderDetails['retailer_id'], $orderDetails['booker_lats'], $orderDetails['booker_longs'], $orderDetails['pref_id'], $orderDetails['item_quantity_booker'], $orderDetails['booker_discount']) && ($orderDetails['within_radius'] == "0" || $orderDetails['within_radius'] == "1")) :
				unset($orderDetails["api_secret_key"]);
				$response = $this->ws->BookOrder($orderDetails);
				if ($response == "Success") :
					return $this->ResponseMessage('Success', 'Order has been booked');
				else:
					return $this->ResponseMessage('Failed', $response);
				endif;
			else:
				return $this->ResponseMessage('Failed', 'Missing values');
			endif;
		endif;
	}

}

?>