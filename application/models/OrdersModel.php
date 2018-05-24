<?php

class OrdersModel extends CI_Model{

	public function getAllOrders($status){
		if (!$status) :
			$orderDetails = $this->db->select('id, (SELECT employee_username from employees_info where employee_id = orders.employee_id) as employee_username, (SELECT territory_name from territory_management where id = (SELECT territory_id from employees_info where employee_id = orders.employee_id)) as territory, (SELECT area_name from area_management where id = (SELECT area_id from territory_management where id = (SELECT territory_id from employees_info where employee_id = orders.employee_id))) as area, (SELECT region_name from regions_info where id = (SELECT region_id from area_management where id = (SELECT area_id from territory_management where id = (SELECT territory_id from employees_info where employee_id = orders.employee_id)))) as region, employee_id, (SELECT GROUP_CONCAT(item_name) from inventory_items where find_in_set(item_id, (SELECT GROUP_CONCAT(item_id) from inventory_preferences where find_in_set(pref_id, (SELECT GROUP_CONCAT(pref_id) as pref_id FROM `order_contents` where order_id = orders.id and item_status != 0))))) item_name, (SELECT retailer_name from retailers_details where id = orders.retailer_id) as distributor_name, (SELECT retailer_lats from retailers_details where id = orders.retailer_id) as retailer_lats, (SELECT retailer_longs from retailers_details where id = orders.retailer_id) as retailer_longs, retailer_id as distributor_id, booker_lats, booker_longs, within_radius, status, DATE(created_at) as created_at')->get("orders")->result();
			$orderStats = array('Pending'=>$this->db->select('count(*) as pendingOrders')->where('status is null or status = "pending" or status = ""')->get('orders')->row()->pendingOrders,'Total'=>$this->db->select('count(*) as totalOrders')->get('orders')->row()->totalOrders,'Cancelled'=>$this->db->select('count(*) as cancelledOrders')->where('status','cancelled')->get('orders')->row()->cancelledOrders, 'Completed'=>$this->db->select('count(*) as completedOrders')->where('status','completed')->get('orders')->row()->completedOrders, 'Compliance'=>$this->db->select('count(*) as compliance')->where('within_radius', 1)->get('orders')->row()->compliance, 'NonCompliance'=>$this->db->select('count(*) as non_compliance')->where('within_radius', 0)->get('orders')->row()->non_compliance);
			return array('stats'=>$orderStats, 'orderDetails'=>$orderDetails);
		endif;
		$orderDetails = $this->db->select('id, (SELECT employee_username from employees_info where employee_id = orders.employee_id) as employee_username, (SELECT territory_name from territory_management where id = (SELECT territory_id from employees_info where employee_id = orders.employee_id)) as territory, (SELECT area_name from area_management where id = (SELECT area_id from territory_management where id = (SELECT territory_id from employees_info where employee_id = orders.employee_id))) as area, (SELECT region_name from regions_info where id = (SELECT region_id from area_management where id = (SELECT area_id from territory_management where id = (SELECT territory_id from employees_info where employee_id = orders.employee_id)))) as region, employee_id, (SELECT GROUP_CONCAT(item_name) from inventory_items where find_in_set(item_id, (SELECT GROUP_CONCAT(item_id) from inventory_preferences where find_in_set(pref_id, (SELECT GROUP_CONCAT(pref_id) as pref_id FROM `order_contents` where order_id = orders.id and item_status != 0))))) item_name, (SELECT retailer_name from retailers_details where id = orders.retailer_id) as distributor_name, (SELECT retailer_lats from retailers_details where id = orders.retailer_id) as retailer_lats, (SELECT retailer_longs from retailers_details where id = orders.retailer_id) as retailer_longs, retailer_id as distributor_id, within_radius, status,booker_lats, booker_longs, DATE(created_at) as created_at')->where('LOWER(status)',$status)->get("orders")->result();
		if ($status == "pending") :
			$orderDetails = $this->db->select('id, (SELECT employee_username from employees_info where employee_id = orders.employee_id) as employee_username, (SELECT territory_name from territory_management where id = (SELECT territory_id from employees_info where employee_id = orders.employee_id)) as territory, (SELECT area_name from area_management where id = (SELECT area_id from territory_management where id = (SELECT territory_id from employees_info where employee_id = orders.employee_id))) as area, (SELECT region_name from regions_info where id = (SELECT region_id from area_management where id = (SELECT area_id from territory_management where id = (SELECT territory_id from employees_info where employee_id = orders.employee_id)))) as region, employee_id, (SELECT GROUP_CONCAT(item_name) from inventory_items where find_in_set(item_id, (SELECT GROUP_CONCAT(item_id) from inventory_preferences where find_in_set(pref_id, (SELECT GROUP_CONCAT(pref_id) as pref_id FROM `order_contents` where order_id = orders.id and item_status != 0))))) item_name, (SELECT retailer_name from retailers_details where id = orders.retailer_id) as distributor_name, (SELECT retailer_lats from retailers_details where id = orders.retailer_id) as retailer_lats, (SELECT retailer_longs from retailers_details where id = orders.retailer_id) as retailer_longs, retailer_id as distributor_id, within_radius, booker_lats, booker_longs,status, DATE(created_at) as created_at')->where('LOWER(status) = LOWER("Awaiting") OR status is NULL')->get("orders")->result();
		elseif($status == "latest") :
			$orderDetails = $this->db->select('id, (SELECT employee_username from employees_info where employee_id = orders.employee_id) as employee_username, (SELECT territory_name from territory_management where id = (SELECT territory_id from employees_info where employee_id = orders.employee_id)) as territory, (SELECT area_name from area_management where id = (SELECT area_id from territory_management where id = (SELECT territory_id from employees_info where employee_id = orders.employee_id))) as area, (SELECT region_name from regions_info where id = (SELECT region_id from area_management where id = (SELECT area_id from territory_management where id = (SELECT territory_id from employees_info where employee_id = orders.employee_id)))) as region, employee_id, (SELECT GROUP_CONCAT(item_name) from inventory_items where find_in_set(item_id, (SELECT GROUP_CONCAT(item_id) from inventory_preferences where find_in_set(pref_id, (SELECT GROUP_CONCAT(pref_id) as pref_id FROM `order_contents` where order_id = orders.id and item_status != 0))))) item_name, (SELECT retailer_name from retailers_details where id = orders.retailer_id) as distributor_name, (SELECT retailer_lats from retailers_details where id = orders.retailer_id) as retailer_lats, (SELECT retailer_longs from retailers_details where id = orders.retailer_id) as retailer_longs, retailer_id as distributor_id, within_radius, booker_lats, booker_longs,status, DATE(created_at) as created_at')->where('DATE(created_at) = CURDATE()')->order_by("(SELECT employee_username from employees_info where employee_id = orders.employee_id)")->get("orders")->result();
		endif;
		$orderStats = array('Pending'=>$this->db->select('count(*) as pendingOrders')->where('status is null or status = "pending" or status = ""')->get('orders')->row()->pendingOrders,'Total'=>$this->db->select('count(*) as totalOrders')->get('orders')->row()->totalOrders,'Cancelled'=>$this->db->select('count(*) as cancelledOrders')->where('status','cancelled')->get('orders')->row()->cancelledOrders, 'Completed'=>$this->db->select('count(*) as completedOrders')->where('status','completed')->get('orders')->row()->completedOrders, 'Compliance'=>$this->db->select('count(*) as compliance')->where('within_radius', 1)->get('orders')->row()->compliance, 'NonCompliance'=>$this->db->select('count(*) as non_compliance')->where('within_radius', 0)->get('orders')->row()->non_compliance);
		return array('stats'=>$orderStats, 'orderDetails'=>$orderDetails);
	}

	public function GetOrderInvoice($orderId){
		$orderDetails = $this->db->select('id as order_number, IFNULL(status, "Pending") as status, (SELECT CONCAT(employee_first_name," ", employee_last_name) from employees_info where employee_id = orders.employee_id) as employee_name, (SELECT GROUP_CONCAT(pref_id) from order_contents where order_id = orders.id and item_status != 0) as pref_id, (SELECT GROUP_CONCAT(id) from order_contents where order_id = orders.id and item_status != 0) as order_content_id, (SELECT retailer_name from retailers_details where id = orders.retailer_id) as distributor_name, (SELECT retailer_phone from retailers_details where id = orders.retailer_id) as retailer_phone, (SELECT GROUP_CONCAT(COALESCE(item_quantity_updated, item_quantity_booker)) from order_contents where order_id = orders.id and item_status != 0) as item_quantity_booker, (SELECT GROUP_CONCAT(booker_discount) from order_contents where order_id = orders.id and item_status != 0) as booker_discount, (SELECT GROUP_CONCAT(final_price) from order_contents where order_id = orders.id and item_status != 0) as subTotal, DATE(created_at) as order_date')->where('id', $orderId)->get("orders")->row();
		$items = array();
		$prefIds = explode(",", $orderDetails->pref_id);
		$itemQuantities = explode(",", $orderDetails->item_quantity_booker);
		$booker_discount = explode(",", $orderDetails->booker_discount);
		$final_price = explode(",", $orderDetails->subTotal);
		$order_content_id = explode(",", $orderDetails->order_content_id);
		for ($i=0; $i < sizeof($prefIds); $i++) { 
			$items[] = array(
				'item_details' => $this->db->select('pref_id, item_id, (SELECT item_sku from inventory_items where item_id = ip.item_id) as item_sku, (SELECT item_name from inventory_items where item_id = ip.item_id) as item_name, (SELECT unit_name from inventory_types_units where unit_id = ip.unit_id) as unit_name, item_trade_price, unit_id, (SELECT item_image from inventory_items where item_id = ip.item_id) as item_image, item_quantity, item_warehouse_price, item_trade_price, item_retail_price, item_thumbnail, item_description, sub_category_id, (item_trade_price-(((SELECT discount from retailer_types where id = (SELECT retailer_type_id from retailers_details where id = (SELECT retailer_id from orders where id = '.$orderId.')))/100)*(ip.item_trade_price))) as after_discount')->where('pref_id', $prefIds[$i])->get("inventory_preferences ip")->row(),
				'item_quantity_booker' => $itemQuantities[$i],
				'booker_discount' => $booker_discount[$i],
				'final_price' => $final_price[$i],
				'order_content_id' => $order_content_id[$i]
			);
		}
		$orderDetails->items = $items;
		return $orderDetails;
	}

	public function getSingleOrder($orderId){
		$orderDetails = $this->db->select('id, (SELECT employee_username from employees_info where employee_id = orders.employee_id) as employee_username, (SELECT GROUP_CONCAT(pref_id) from order_contents where order_id = orders.id and item_status != 0) as pref_id, (SELECT GROUP_CONCAT(id) from order_contents where order_id = orders.id and item_status != 0) as order_content_id, (SELECT GROUP_CONCAT(COALESCE(item_quantity_updated, item_quantity_booker)) from order_contents where order_id = orders.id and item_status != 0) as item_quantity_booker, (SELECT GROUP_CONCAT(booker_discount) from order_contents where order_id = orders.id and item_status != 0) as booker_discount, (SELECT GROUP_CONCAT(final_price) from order_contents where order_id = orders.id and item_status != 0) as subTotal')->where('id', $orderId)->get("orders")->row();
		$items = array();
		$prefIds = explode(",", $orderDetails->pref_id);
		$itemQuantities = explode(",", $orderDetails->item_quantity_booker);
		$booker_discount = explode(",", $orderDetails->booker_discount);
		$final_price = explode(",", $orderDetails->subTotal);
		$order_content_id = explode(",", $orderDetails->order_content_id);
		for ($i=0; $i < sizeof($prefIds); $i++) { 
			$items[] = array(
				'item_details' => $this->db->select('pref_id, item_id, (SELECT item_sku from inventory_items where item_id = ip.item_id) as item_sku, (SELECT item_name from inventory_items where item_id = ip.item_id) as item_name, (SELECT unit_name from inventory_types_units where unit_id = ip.unit_id) as unit_name, item_trade_price, unit_id, (SELECT item_image from inventory_items where item_id = ip.item_id) as item_image, item_quantity, item_warehouse_price, item_trade_price, item_retail_price, item_thumbnail, item_description, sub_category_id, (item_trade_price-(((SELECT discount from retailer_types where id = (SELECT retailer_type_id from retailers_details where id = (SELECT retailer_id from orders where id = '.$orderId.')))/100)*(ip.item_trade_price))) as after_discount')->where('pref_id', $prefIds[$i])->get("inventory_preferences ip")->row(),
				'item_quantity_booker' => $itemQuantities[$i],
				'booker_discount' => $booker_discount[$i],
				'final_price' => $final_price[$i],
				'order_content_id' => $order_content_id[$i]
			);
		}
		$orderDetails->items = $items;
		return $orderDetails;
	}

	public function UpdateStockOrderRemoveItems($orderData){
		$itemsDelete = explode(",", $orderData['items_deleted']);
		foreach ($itemsDelete as $item) :
			$this->db->where('id', $item)->update('order_contents', array('item_status'=>0));
		endforeach;
	}

	public function UpdateStockOrder($orderData){

		$itemsUpdate = explode(",", $orderData['pref_id']);
		$itemsQuantities = explode(",", $orderData['item_quantity_updated']);
		$failedUpdates = array();
		for ($i = 0; $i < sizeof($itemsUpdate); $i++) :
			//To detect which item quantities are updated
			$stockedQuantity = $this->db->select('COALESCE(item_quantity_updated, item_quantity_booker) as item_stocked_quantity')->where('pref_id = ' . $itemsUpdate[$i] . ' and order_id = ' . $orderData['order_id'] . ' and item_status != 0')->get('order_contents')->row()->item_stocked_quantity;
			$failedUpdates = array();
			if ($stockedQuantity !== $itemsQuantities[$i]) :
				$individualPriceForThisPrefId = $this->db->select('(item_trade_price-(((SELECT discount from retailer_types where id = (SELECT retailer_type_id from retailers_details where id = (SELECT retailer_id from orders where id = '.$orderData['order_id'].')))/100)*(ip.item_trade_price))) as after_discount')->where('pref_id', $itemsUpdate[$i])->get('inventory_preferences ip')->row()->after_discount;
				$booker_discount = $this->db->select('booker_discount')->where('pref_id = ' . $itemsUpdate[$i] . ' and order_id = ' . $orderData['order_id'] . ' and item_status != 0')->get('order_contents')->row()->booker_discount;
				if ($booker_discount) {
					$discountedAmount = ($booker_discount / 100) * $individualPriceForThisPrefId;
					$individualPriceForThisPrefId = $individualPriceForThisPrefId - $discountedAmount;
				}
				$final_price = $individualPriceForThisPrefId*$itemsQuantities[$i];
				if ($itemsQuantities[$i] > $stockedQuantity) :
					$deductFromThisQuantity = $this->db->select('item_quantity')->where('pref_id', $itemsUpdate[$i])->get('inventory_preferences')->row()->item_quantity;
					$finalQuantity = $deductFromThisQuantity-($itemsQuantities[$i]-$stockedQuantity);
				else:
					$addBackIntoThisQuantity = $this->db->select('item_quantity')->where('pref_id', $itemsUpdate[$i])->get('inventory_preferences')->row()->item_quantity;
					$finalQuantity = $addBackIntoThisQuantity+($stockedQuantity-$itemsQuantities[$i]);
				endif;

				$this->db->where('pref_id',$itemsUpdate[$i])->update('inventory_preferences', array('item_quantity'=>$finalQuantity));

				if (!$this->db->where('pref_id = ' . $itemsUpdate[$i] . ' and order_id = ' . $orderData['order_id'] . ' and item_status != 0')->update('order_contents', array('item_quantity_updated'=>$itemsQuantities[$i], 'final_price'=>$final_price))) :
					$failedUpdates[] = array(
						'item'=>$itemsUpdate[$i],
						'reason'=> $this->db->where(array('item_id'=>$itemsUpdate[$i], 'order_id'=>$orderData['order_id']))->update('order_contents', array('item_quantity_updated'=>$itemsQuantities[$i]))
					);
				endif;
			endif;
		endfor;
		return $failedUpdates;
	}

	public function ExpandOrder($orderId, $expandOrderData){
		$itemQuantities = explode(",", $expandOrderData['item_quantities_expansion']);
		$prefIds = explode(",", $expandOrderData['item_ids_expansion']);
		$bookerDiscounts = explode(",", $expandOrderData['booker_discounts_expansion']);
		for ($i=0; $i < sizeof($prefIds); $i++) :
			$individualPriceForThisPrefId = $this->db->select('(item_trade_price-(((SELECT discount from retailer_types where id = (SELECT retailer_type_id from retailers_details where id = (SELECT retailer_id from orders where id = '.$orderId.')))/100)*(ip.item_trade_price))) as after_discount')->where('pref_id', $prefIds[$i])->get('inventory_preferences ip')->row()->after_discount;
			if ($bookerDiscounts[$i]) {
				$discountedAmount = ($bookerDiscounts[$i] / 100) * $individualPriceForThisPrefId;
				$individualPriceForThisPrefId = $individualPriceForThisPrefId - $discountedAmount;
			}
			$final_price = $individualPriceForThisPrefId*$itemQuantities[$i];
			
			$deductFromThisQuantity = $this->db->select('item_quantity')->where('pref_id', $prefIds[$i])->get('inventory_preferences')->row()->item_quantity;
			$finalQuantity = $deductFromThisQuantity-$itemQuantities[$i];
			$this->db->where('pref_id',$prefIds[$i])->update('inventory_preferences', array('item_quantity'=>$finalQuantity));
			$orderContents[] = array("pref_id"=>$prefIds[$i], "item_quantity_updated"=>$itemQuantities[$i], "booker_discount"=>$bookerDiscounts[$i], "final_price"=>$final_price, "item_status"=>2, "order_id"=>$orderId);
		endfor;
		return $this->db->insert_batch('order_contents', $orderContents);
	}

	public function ProcessOrder($orderId){
		return $this->db
		->where('id',$orderId)	
		->update('orders', array('status'=>'Processed'));
	}

	public function CompleteOrder($orderId){
		return $this->db
		->where('id',$orderId)	
		->update('orders', array('status'=>'Completed'));
	}

	public function CancelOrder($orderId){
		return $this->db
		->where('id',$orderId)	
		->update('orders', array('status'=>'Cancelled'));
	}

}

?>