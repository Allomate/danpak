<?php

class Orders extends WebAuth_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('EmployeesModel', 'em');
		$this->load->model('OrdersModel', 'om');
		$this->load->model('InventoryModel', 'im');
	}

	public function ListOrders($status){
		if ($status == "EmployeesList")
			return $this->load->view('Order/ListOrders', [ 'Orders' => $this->om->getAllOrders(null) ]);
		return $this->load->view('Order/ListOrders', [ 'Orders' => $this->om->getAllOrders(strtolower($status)) ]);
	}

	public function UpdateOrder($orderId){
		return $this->load->view('Order/UpdateOrder', [ 'Order' => $this->om->getSingleOrder($orderId), 'Inventory' => $this->im->get_inventory_for_this_order($orderId) ]);
	}

	public function OrderInvoice($orderId){
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
		return redirect('Orders/ListOrders/Pending');
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
		return redirect('Orders/ListOrders/Pending');
	}

	public function ProcessOrder($status, $orderId){
		if ($this->om->ProcessOrder($orderId)) :
			$this->session->set_flashData('order_processed', 'Order has been processed successfully');
		else:
			$this->session->set_flashData('order_process_failed', 'Unable to process the order at the moment');
		endif;
		return redirect('Orders/ListOrders/'.$status);
	}

	public function CompleteOrder($status, $orderId){
		if ($this->om->CompleteOrder($orderId)) :
			$this->session->set_flashData('order_completed', 'Order has been completed successfully');
		else:
			$this->session->set_flashData('order_complete_failed', 'Unable to complete the order at the moment');
		endif;
		return redirect('Orders/ListOrders/'.$status);
	}

	public function CancelOrder($status, $orderId){
		if ($this->om->CancelOrder($orderId)) :
			$this->session->set_flashData('order_cancelled', 'Order has been cancelled');
		else:
			$this->session->set_flashData('order_cancel_failed', 'Unable to cancel the order at the moment');
		endif;
		return redirect('Orders/ListOrders/'.$status);
	}

}

?>