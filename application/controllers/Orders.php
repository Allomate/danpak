<?php

class Orders extends WebAuth_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('EmployeesModel', 'em');
		$this->load->model('OrdersModel', 'om');
		$this->load->model('InventoryModel', 'im');
	}

	public function ListOrders($status){
		if ($status == "EmployeesList"){
			// echo "<pre>"; print_r($this->om->getAllOrders(null, null, "employee"));die;
			return $this->load->view('Order/ListOrders_individual', [ 'Orders' => $this->om->getAllOrders(null, null, "employee") ]);
		}
		// echo "<pre>"; print_r($this->om->getCollectiveOrders(strtolower($status)));die;
		return $this->load->view('Order/ListOrders', [ 'Orders' => $this->om->getCollectiveOrders(strtolower($status)) ]);
	}

	public function ListOrdersIndividual($employee, $date, $status){
		// echo "<pre>"; print_r($this->om->getAllOrders($employee, urldecode($date), strtolower($status)));die;
		return $this->load->view('Order/ListOrders_individual', [ 'Orders' => $this->om->getAllOrders($employee, urldecode($date), strtolower($status)) ]);
	}

	public function ListOrdersIndividualAgainstRetailer($employee, $date, $retailer_id){
		return $this->load->view('Order/ListOrders_individual', [ 'Orders' => $this->om->getAllOrdersAgainstRetailer($employee, urldecode($date), $retailer_id) ]);
	}

	public function UpdateOrder($orderId){
		// echo "<pre>"; print_r($this->om->getSingleOrder($orderId));die;
		return $this->load->view('Order/UpdateOrder', [ 'Order' => $this->om->getSingleOrder($orderId), 'Inventory' => $this->im->get_inventory_for_this_order($orderId) ]);
	}

	public function BookingSheet($employee, $date, $status){
		// echo "<pre>"; print_r($this->om->generateBookingSheet($employee, $date, strtolower($status)));die;
		return $this->load->view('Order/BookingSheet', [ 'details' => $this->om->generateBookingSheet($employee, $date, strtolower($status)), 'delivChallan' => $this->om->generateDeliveryChallan($employee, $date, strtolower($status)) ]);
	}

	public function DeliveryChallan($employee, $date, $status){
		return $this->load->view('Order/DeliveryChallan', [ 'details' => $this->om->generateDeliveryChallan($employee, $date, strtolower($status)) ]);
	}

	public function ManualOrders(){
		// echo "<pre>"; print_r($this->em->get_employees_list());die;
		return $this->load->view('Order/ManualOrderCreation', [ 'employees' => $this->em->get_employees_list(), 'inventorySku' => $this->im->get_inventory_sku_wise() ]);
	}

	public function GetRetailersForEmployeeAjax(){
		echo json_encode($this->om->GetRetailersForEmployee($this->input->post('employee_id')));
	}

	public function GetUnitsForSku(){
		echo json_encode($this->im->GetUnitNamesForSku($this->input->post('itemId')));
	}

	public function GetDistDiscountForItem(){
		echo json_encode($this->om->GetDistDiscountForItem($this->input->post('pref_id'), $this->input->post('dist_id')));
	}

	public function CreateManualOrders(){
		$data = json_decode($this->input->post("finalResult"));
		$visitStatus = $this->input->post("visit_status");
		$pref_id = "";
		$item_quantity_booker = "";
		$booker_discount = "";
		$employee_id = 0;
		$retailer_id = 0;
		$order_date = "";
		foreach($data as $val) :
			if($pref_id){
				$pref_id .= ",".$val->pref_id;
				$item_quantity_booker .= ",".$val->item_quantity_booker;
				$booker_discount .= ",".$val->booker_discount;
			}else{
				$pref_id = $val->pref_id;
				$item_quantity_booker = ($val->item_quantity_booker ? $val->item_quantity_booker : "0");
				$booker_discount = ($val->booker_discount ? $val->booker_discount : "0");
			}
			$order_date = $val->order_data;
			$employee_id = $val->employee_id;
			$retailer_id = $val->retailer_id;
		endforeach;
		$orderData = array("pref_id" => $pref_id, "item_quantity_booker" => $item_quantity_booker, "booker_discount" => $booker_discount, "employee_id" => $employee_id, 'order_date' => $order_date, 'retailer_id' => $retailer_id, 'visit_status' => $visitStatus);
		if($this->om->BookOrderManualEntry($orderData) == "Success"){
			$this->session->set_flashData('order_created', 'Order has been created successfully');
		}else{
			$this->session->set_flashData('order_creation_failed', 'Failed to create the order');
		}
		return redirect('Orders/ManualOrders');
	}

	public function OrderInvoice($orderId){
		// echo "<pre>"; print_r($this->om->GetOrderInvoice($orderId));die;
		return $this->load->view('Order/OrderInvoice', [ 'OrderInvoice' => $this->om->GetOrderInvoice($orderId) ]);
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

	public function ProcessOrder($employee_id, $date, $status, $orderId){
		if ($this->om->ProcessOrder($orderId)) :
			$this->session->set_flashData('order_processed', 'Order has been processed successfully');
		else:
			$this->session->set_flashData('order_process_failed', 'Unable to process the order at the moment');
		endif;
		return redirect('Orders/ListOrdersIndividual/'.$employee_id.'/'.$date.'/'.$status);
	}

	public function ProcessAll($employee_id, $date, $status){
		if ($this->om->ProcessAll($employee_id, $date, $status)) :
			$this->session->set_flashData('order_processed', 'All orders have been processed successfully');
		else:
			$this->session->set_flashData('order_process_failed', 'Unable to process the orders at the moment');
		endif;
		return redirect('Orders/ListOrders/'.$status);
	}

	public function CompleteAll($employee_id, $date, $status){
		if ($this->om->CompleteAll($employee_id, $date, $status)) :
			$this->session->set_flashData('order_completed', 'All orders have been completed successfully');
		else:
			$this->session->set_flashData('order_complete_failed', 'Unable to complete the orders at the moment');
		endif;
		return redirect('Orders/ListOrders/'.$status);
	}

	public function CompleteOrder($employee_id, $date, $status, $orderId){
		if ($this->om->CompleteOrder($orderId)) :
			$this->session->set_flashData('order_completed', 'Order has been completed successfully');
		else:
			$this->session->set_flashData('order_complete_failed', 'Unable to complete the order at the moment');
		endif;
		return redirect('Orders/ListOrdersIndividual/'.$employee_id.'/'.$date.'/'.$status);
	}

	public function CancelOrder($employee_id, $date, $status, $orderId){
		if ($this->om->CancelOrder($orderId)) :
			$this->session->set_flashData('order_cancelled', 'Order has been cancelled');
		else:
			$this->session->set_flashData('order_cancel_failed', 'Unable to cancel the order at the moment');
		endif;
		return redirect('Orders/ListOrdersIndividual/'.$employee_id.'/'.$date.'/'.$status);
	}

}

?>
