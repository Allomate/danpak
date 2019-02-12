<?php

class PrimaryOrders extends WebAuth_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('EmployeesModel', 'em');
		$this->load->model('PrimaryOrdersModel', 'om');
		$this->load->model('CampaignModel', 'cam');
		$this->load->model('InventoryModel', 'im');
	}

	public function ListPrimaryOrders($status){
		$status = str_replace('primary', '', strtolower($status));
		if ($status == "EmployeesList"){
			// echo "<pre>"; print_r($this->om->getAllOrders(null, null, "employee"));die;
			return $this->load->view('PrimaryOrders/ListOrders_individual', [ 'Orders' => $this->om->getAllOrders(null, null, "employee") ]);
		}
		// echo "<pre>"; print_r($this->om->getCollectiveOrders(strtolower($status)));die;
		return $this->load->view('PrimaryOrders/ListOrders', [ 'Orders' => $this->om->getCollectiveOrders(strtolower($status)) ]);
	}

	public function ListOrdersIndividual($employee, $date, $status){
		$status = str_replace('primary', '', strtolower($status));
		return $this->load->view('PrimaryOrders/ListOrders_individual', [ 'Orders' => $this->om->getAllOrders($employee, urldecode($date), strtolower($status)), 'inventory' => $this->im->get_inventory_sku_wise() ]);
	}

	public function ListOrdersIndividualAgainstRetailer($employee, $date, $retailer_id){
		return $this->load->view('PrimaryOrders/ListOrders_individual', [ 'Orders' => $this->om->getAllOrdersAgainstRetailer($employee, urldecode($date), $retailer_id) ]);
	}

	public function UpdateOrder($orderId){
		// echo "<pre>"; print_r($this->om->getSingleOrder($orderId));die;
		return $this->load->view('PrimaryOrders/UpdateOrder', [ 'Order' => $this->om->getSingleOrder($orderId), 'Inventory' => $this->im->get_inventory_for_this_order($orderId) ]);
	}

	public function BookingSheet($employee, $date, $status){
		$status = str_replace('primary', '', strtolower($status));
		// echo "<pre>"; print_r($this->om->generateBookingSheet($employee, $date, strtolower($status)));die;
		return $this->load->view('PrimaryOrders/BookingSheet', [ 'details' => $this->om->generateBookingSheet($employee, $date, strtolower($status)), 'delivChallan' => $this->om->generateDeliveryChallan($employee, $date, strtolower($status)) ]);
	}

	public function DeliveryChallan($employee, $date, $status){
		$status = str_replace('primary', '', strtolower($status));
		return $this->load->view('PrimaryOrders/DeliveryChallan', [ 'details' => $this->om->generateDeliveryChallan($employee, $date, strtolower($status)) ]);
	}

	public function ManualPrimaryOrders(){
		// echo "<pre>"; print_r($this->em->get_employees_list());die;
		return $this->load->view('PrimaryOrders/ManualOrderCreation', [ 'employees' => $this->em->get_employees_list(), 'inventorySku' => $this->im->get_inventory_sku_wise(), 'campaigns' => $this->cam->getAllCampaigns() ]);
	}

	public function GetRetailersForEmployeeAjax(){
		echo json_encode($this->om->GetRetailersForEmployee($this->input->post('employee_id')));
	}

	public function GetUnitsForSku(){
		echo json_encode($this->im->GetUnitNamesForSku($this->input->post('itemId')));
	}

	public function GetUnits($itemId, $orderId){
		echo json_encode($this->im->GetUnitNamesForSkuWithRetDiscount($itemId, $orderId));
	}

	public function UpdateOrderAjax($orderId){
		echo json_encode( [ 'Order' => $this->om->getSingleOrder($orderId) ] );
	}

	public function CommitOrderChanges(){
		echo json_encode($this->om->UpdateStockOrder($this->input->post('removed'), $this->input->post('existing'), $this->input->post('new')));
	}

	public function GetPriceForThisVariant($itemId, $unitId, $orderId){
		echo json_encode($this->im->GetVariantPrice($itemId, $unitId, $orderId));
	}

	public function GetDistDiscountForItem(){
		echo json_encode($this->om->GetDistDiscountForItem($this->input->post('pref_id'), $this->input->post('dist_id')));
	}

	public function GetDistDiscountForCampaign(){
		echo json_encode($this->om->GetDistDiscountForCampaign($this->input->post('campaign_id'), $this->input->post('quantity'), $this->input->post('discount'), $this->input->post('dist_id')));
	}

	public function CreateManualOrders(){
		$data = json_decode($this->input->post("finalResult"));
		$visitStatus = $this->input->post("visit_status");
		$pref_id = "";
		$item_quantity_booker = "";
		$booker_discount = "";
		$employee_id = 0;
		$retailer_id = 0;
		$freight_charges = 0;
		$order_date = "";
		foreach($data as $val) :
			if(isset($val->pref_id)){
				if($pref_id){
					$pref_id .= ",".$val->pref_id;
					$item_quantity_booker .= ",".$val->item_quantity_booker;
					$booker_discount .= ",".$val->booker_discount;
				}else{
					$pref_id = $val->pref_id;
					$item_quantity_booker = ($val->item_quantity_booker ? $val->item_quantity_booker : "0");
					$booker_discount = ($val->booker_discount ? $val->booker_discount : "0");
				}
			}
			$order_date = $val->order_data;
			$employee_id = $val->employee_id;
			$retailer_id = $val->retailer_id;
			$freight_charges = $val->freight_charges;
		endforeach;

		$campaign_id = "";
		$camp_item_quantity_booker = "";
		$camp_booker_discount = "";
		foreach($data as $val) :
			if(isset($val->campaign_id)){
				if($campaign_id){
					$campaign_id .= ",".$val->campaign_id;
					$camp_item_quantity_booker .= ",".$val->item_quantity_booker;
					$camp_booker_discount .= ",".$val->booker_discount;
				}else{
					$campaign_id = $val->campaign_id;
					$camp_item_quantity_booker = ($val->item_quantity_booker ? $val->item_quantity_booker : "0");
					$camp_booker_discount = ($val->booker_discount ? $val->booker_discount : "0");
				}
			}
			$order_date = $val->order_data;
			$employee_id = $val->employee_id;
			$retailer_id = $val->retailer_id;
		endforeach;

		$orderData = array("prefs" => array("pref_id" => $pref_id, "item_quantity_booker" => $item_quantity_booker, "booker_discount" => $booker_discount), "camps" => array("campaign_id" => $campaign_id, "camp_item_quantity_booker" => $camp_item_quantity_booker, "camp_booker_discount" => $camp_booker_discount), "employee_id" => $employee_id, 'order_date' => $order_date, 'retailer_id' => $retailer_id, 'visit_status' => $visitStatus, 'freight_charges' => $freight_charges);

		// echo "<pre>"; print_r($orderData);die;
		// echo "<pre>"; print_r($this->om->BookOrderManualEntry($orderData));die;
		
		if($this->om->BookOrderManualEntry($orderData) == "Success"){
			$this->session->set_flashData('order_created', 'Order has been created successfully');
		}else{
			$this->session->set_flashData('order_creation_failed', 'Failed to create the order');
		}
		return redirect('PrimaryOrders/ManualPrimaryOrders');
	}

	public function OrderInvoice($orderId){
		// echo "<pre>"; print_r($this->om->GetOrderInvoice($orderId));die;
		return $this->load->view('PrimaryOrders/OrderInvoice', [ 'OrderInvoice' => $this->om->GetOrderInvoice($orderId) ]);
	}

	public function UpdateOrderOps($orderId){
		$orderData = $this->input->post();
		$existing_items = explode(',', $orderData['existing_items']);
		$existing_quantities = explode(',', $orderData['existing_quantities']);
		$orderData['pref_id'] = $orderData['existing_items'];
		$orderData['item_quantity_updated'] = $orderData['existing_quantities'];
		unset($orderData['existing_quantities']);
		unset($orderData['existing_items']);
		unset($orderData['DataTables_Table_0_length']);
		unset($orderData['item_id_existing']);
		unset($orderData['item_quantity']);
		unset($orderData['item_quantity_booker_existing']);
		$orderData['order_id'] = $orderId;
		if ($orderData["items_deleted"]) :
			$this->om->UpdateStockOrderRemoveItems($orderData);
		endif;
		$response = $this->om->UpdateStockOrder($orderData);
		if (!sizeof($response)) :
			$this->session->set_flashData('order_updated', 'Order has been updated successfully');
		else:
			$this->session->set_flashData('order_update_failed', 'Unable to update the order at the moment');
		endif;
		return redirect('Orders/UpdateOrder/'.$orderId);
	}

	public function ExpandOrderOps($orderId){
		$expandOrderData = $this->input->post();
		unset($expandOrderData["DataTables_Table_0_length"]);
		unset($expandOrderData["item_quantity"]);
		if ($this->om->ExpandOrder($orderId, $expandOrderData)) :
			$this->session->set_flashData('order_updated', 'Order has been updated successfully');
		else:
			$this->session->set_flashData('order_update_failed', 'Unable to update the order at the moment');
		endif;
		return redirect('Orders/UpdateOrder/'.$orderId);
	}

	public function UpdateOrderStatus($orderId, $status){
		$status = str_replace('primary', '', strtolower($status));
		if(strtolower($status) == "processed"){
			if ($this->om->ProcessOrder($orderId)) :
				echo "success";
			else:
				echo "failed";
			endif;
		}else if(strtolower($status) == "completed"){
			if ($this->om->CompleteOrder($orderId)) :
				echo "success";
			else:
				echo "failed";
			endif;
		}else if(strtolower($status) == "cancelled"){
			if ($this->om->CancelOrder($orderId)) :
				echo "success";
			else:
				echo "failed";
			endif;
		}
	}

	public function ProcessOrder($employee_id, $date, $status, $orderId){
		$status = str_replace('primary', '', strtolower($status));
		if ($this->om->ProcessOrder($orderId)) :
			$this->session->set_flashData('order_processed', 'Order has been processed successfully');
		else:
			$this->session->set_flashData('order_process_failed', 'Unable to process the order at the moment');
		endif;
		return redirect('Orders/ListOrdersIndividual/'.$employee_id.'/'.$date.'/'.$status);
	}

	public function ProcessAll($employee_id, $date, $status){
		$status = str_replace('primary', '', strtolower($status));
		if ($this->om->ProcessAll($employee_id, $date, $status)) :
			$this->session->set_flashData('order_processed', 'All orders have been processed successfully');
		else:
			$this->session->set_flashData('order_process_failed', 'Unable to process the orders at the moment');
		endif;
		return redirect('Orders/ListPrimaryOrders/'.$status);
	}

	public function CompleteAll($employee_id, $date, $status){
		$status = str_replace('primary', '', strtolower($status));
		if ($this->om->CompleteAll($employee_id, $date, $status)) :
			$this->session->set_flashData('order_completed', 'All orders have been completed successfully');
		else:
			$this->session->set_flashData('order_complete_failed', 'Unable to complete the orders at the moment');
		endif;
		return redirect('Orders/ListPrimaryOrders/'.$status);
	}

	public function CompleteOrder($employee_id, $date, $status, $orderId){
		$status = str_replace('primary', '', strtolower($status));
		if ($this->om->CompleteOrder($orderId)) :
			$this->session->set_flashData('order_completed', 'Order has been completed successfully');
		else:
			$this->session->set_flashData('order_complete_failed', 'Unable to complete the order at the moment');
		endif;
		return redirect('Orders/ListOrdersIndividual/'.$employee_id.'/'.$date.'/'.$status);
	}

	public function CancelOrder($employee_id, $date, $status, $orderId){
		$status = str_replace('primary', '', strtolower($status));
		if ($this->om->CancelOrder($orderId)) :
			$this->session->set_flashData('order_cancelled', 'Order has been cancelled');
		else:
			$this->session->set_flashData('order_cancel_failed', 'Unable to cancel the order at the moment');
		endif;
		return redirect('Orders/ListOrdersIndividual/'.$employee_id.'/'.$date.'/'.$status);
	}

}

?>
