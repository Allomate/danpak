<?php

class OrdersModel extends CI_Model{

	public function getCollectiveOrders($status){
		$orderStats = array();
		$orderDetails = array();
		if(!$status || $status === "pending"){
			$dates = $this->db->select('DATE(created_at) as date')->where('LOWER(status) = "'.$status.'" OR status IS NULL or status = ""')->group_by('DATE(created_at)')->get('orders')->result();
			$emps = $this->db->select('employee_id, (SELECT employee_username from employees_info where employee_id = orders.employee_id) as employee_username')->where('LOWER(status) = "'.$status.'" OR status IS NULL or status = ""')->group_by('employee_id')->get('orders')->result();
			foreach($dates as $today):
				for($i = 0; $i < sizeOf($emps); $i++){
					$ordersCount = $this->db->select('count(*) as totalOrders')->where('DATE(created_at) = "'.$today->date.'" and employee_id = '.$emps[$i]->employee_id.' and (LOWER(status) = "'.$status.'" OR status IS NULL or status = "")')->get('orders')->row()->totalOrders;
					if($ordersCount){
						$orderDetails[] = array('totalOrders' => $ordersCount, 'employee_username' => $emps[$i]->employee_username , 'territory' => $this->db->select('(SELECT territory_name from territory_management where id = orders.booking_territory) as territory')->where('DATE(created_at) = "'.$today->date.'" and employee_id = '.$emps[$i]->employee_id.' and (LOWER(status) = "'.$status.'" OR status IS NULL or status = "")')->get('orders')->row()->territory, 'date' => $today->date, 'employee_id' => $emps[$i]->employee_id);
					}
				}
			endforeach;
			$orderStats = array('Pending'=>$this->db->select('count(*) as pendingOrders')->where('status is null or status = "pending" or status = ""')->get('orders')->row()->pendingOrders,'Total'=>$this->db->select('count(*) as totalOrders')->get('orders')->row()->totalOrders,'Cancelled'=>$this->db->select('count(*) as cancelledOrders')->where('status','cancelled')->get('orders')->row()->cancelledOrders, 'Completed'=>$this->db->select('count(*) as completedOrders')->where('status','completed')->get('orders')->row()->completedOrders, 'Compliance'=>$this->db->select('count(*) as compliance')->where('within_radius', 1)->get('orders')->row()->compliance, 'NonCompliance'=>$this->db->select('count(*) as non_compliance')->where('within_radius', 0)->get('orders')->row()->non_compliance);
		}else if($status == "completed" || $status == "processed" || $status == "cancelled"){
			$dates = $this->db->select('DATE(created_at) as date')->where('LOWER(status) = "'.$status.'"')->group_by('DATE(created_at)')->get('orders')->result();
			$emps = $this->db->select('employee_id, (SELECT employee_username from employees_info where employee_id = orders.employee_id) as employee_username')->where('LOWER(status) = "'.$status.'"')->group_by('employee_id')->get('orders')->result();
			$orderDetails = array();
			foreach($dates as $today):
				for($i = 0; $i < sizeOf($emps); $i++){
					$ordersCount = $this->db->select('count(*) as totalOrders')->where('DATE(created_at) = "'.$today->date.'" and employee_id = '.$emps[$i]->employee_id.' and (LOWER(status) = "'.$status.'")')->get('orders')->row()->totalOrders;
					if($ordersCount){
						$orderDetails[] = array('totalOrders' => $ordersCount, 'employee_username' => $emps[$i]->employee_username , 'territory' => $this->db->select('(SELECT territory_name from territory_management where id = orders.booking_territory) as territory')->where('DATE(created_at) = "'.$today->date.'" and employee_id = '.$emps[$i]->employee_id.' and (LOWER(status) = "'.$status.'")')->get('orders')->row()->territory, 'date' => $today->date, 'employee_id' => $emps[$i]->employee_id);
					}
				}
			endforeach;
			$orderStats = array('Pending'=>$this->db->select('count(*) as pendingOrders')->where('status is null or status = "pending" or status = ""')->get('orders')->row()->pendingOrders,'Total'=>$this->db->select('count(*) as totalOrders')->get('orders')->row()->totalOrders,'Cancelled'=>$this->db->select('count(*) as cancelledOrders')->where('status','cancelled')->get('orders')->row()->cancelledOrders, 'Completed'=>$this->db->select('count(*) as completedOrders')->where('status','completed')->get('orders')->row()->completedOrders, 'Compliance'=>$this->db->select('count(*) as compliance')->where('within_radius', 1)->get('orders')->row()->compliance, 'NonCompliance'=>$this->db->select('count(*) as non_compliance')->where('within_radius', 0)->get('orders')->row()->non_compliance);
		}else{
			$dates = $this->db->select('DATE(created_at) as date')->where('DATE(created_at) = CURDATE()')->group_by('DATE(created_at)')->get('orders')->result();
			$emps = $this->db->select('employee_id, (SELECT employee_username from employees_info where employee_id = orders.employee_id) as employee_username')->where('DATE(created_at) = CURDATE()')->group_by('employee_id')->get('orders')->result();
			$orderDetails = array();
			foreach($dates as $today):
				for($i = 0; $i < sizeOf($emps); $i++){
					$ordersCount = $this->db->select('count(*) as totalOrders')->where('DATE(created_at) = "'.$today->date.'" and employee_id = '.$emps[$i]->employee_id)->get('orders')->row()->totalOrders;
					if($ordersCount){
						$orderDetails[] = array('totalOrders' => $ordersCount, 'employee_username' => $emps[$i]->employee_username , 'territory' => $this->db->select('(SELECT territory_name from territory_management where id = orders.booking_territory) as territory')->where('DATE(created_at) = "'.$today->date.'" and employee_id = '.$emps[$i]->employee_id)->get('orders')->row()->territory, 'date' => $today->date, 'employee_id' => $emps[$i]->employee_id);
					}
				}
			endforeach;
			$orderStats = array('Pending'=>$this->db->select('count(*) as pendingOrders')->where('status is null or status = "pending" or status = ""')->get('orders')->row()->pendingOrders,'Total'=>$this->db->select('count(*) as totalOrders')->get('orders')->row()->totalOrders,'Cancelled'=>$this->db->select('count(*) as cancelledOrders')->where('status','cancelled')->get('orders')->row()->cancelledOrders, 'Completed'=>$this->db->select('count(*) as completedOrders')->where('status','completed')->get('orders')->row()->completedOrders, 'Compliance'=>$this->db->select('count(*) as compliance')->where('within_radius', 1)->get('orders')->row()->compliance, 'NonCompliance'=>$this->db->select('count(*) as non_compliance')->where('within_radius', 0)->get('orders')->row()->non_compliance);
		}
		return array('stats'=>$orderStats, 'orderDetails'=>$orderDetails);
	}

	public function getAllOrders($employee, $date, $status){
		if (!$status || $status === "pending") :
			$orderDetails = $this->db->select('id, (SELECT employee_username from employees_info where employee_id = orders.employee_id) as employee_username, (SELECT territory_name from territory_management where id = (SELECT territory_id from employees_info where employee_id = orders.employee_id)) as territory, (SELECT area_name from area_management where id = (SELECT area_id from territory_management where id = (SELECT territory_id from employees_info where employee_id = orders.employee_id))) as area, (SELECT region_name from regions_info where id = (SELECT region_id from area_management where id = (SELECT area_id from territory_management where id = (SELECT territory_id from employees_info where employee_id = orders.employee_id)))) as region, employee_id, (SELECT retailer_name from retailers_details where id = orders.retailer_id) as distributor_name, (SELECT retailer_lats from retailers_details where id = orders.retailer_id) as retailer_lats, (SELECT retailer_longs from retailers_details where id = orders.retailer_id) as retailer_longs, retailer_id as distributor_id, booker_lats, status, booker_longs, within_radius, DATE(created_at) as created_at')->where('employee_id = '.$employee.' and DATE(created_at) = "'.$date.'" and status is NULL or status = "pending" or status = ""')->get("orders")->result();
			$orderStats = array('Pending'=>$this->db->select('count(*) as pendingOrders')->where('status is null or status = "pending" or status = ""')->get('orders')->row()->pendingOrders,'Total'=>$this->db->select('count(*) as totalOrders')->get('orders')->row()->totalOrders,'Cancelled'=>$this->db->select('count(*) as cancelledOrders')->where('status','cancelled')->get('orders')->row()->cancelledOrders, 'Completed'=>$this->db->select('count(*) as completedOrders')->where('status','completed')->get('orders')->row()->completedOrders, 'Compliance'=>$this->db->select('count(*) as compliance')->where('within_radius', 1)->get('orders')->row()->compliance, 'NonCompliance'=>$this->db->select('count(*) as non_compliance')->where('within_radius', 0)->get('orders')->row()->non_compliance);
			return array('stats'=>$orderStats, 'orderDetails'=>$orderDetails);
		endif;
		$orderDetails = $this->db->select('id, (SELECT employee_username from employees_info where employee_id = orders.employee_id) as employee_username, (SELECT territory_name from territory_management where id = (SELECT territory_id from employees_info where employee_id = orders.employee_id)) as territory, (SELECT area_name from area_management where id = (SELECT area_id from territory_management where id = (SELECT territory_id from employees_info where employee_id = orders.employee_id))) as area, (SELECT region_name from regions_info where id = (SELECT region_id from area_management where id = (SELECT area_id from territory_management where id = (SELECT territory_id from employees_info where employee_id = orders.employee_id)))) as region, employee_id, (SELECT retailer_name from retailers_details where id = orders.retailer_id) as distributor_name, (SELECT retailer_lats from retailers_details where id = orders.retailer_id) as retailer_lats, (SELECT retailer_longs from retailers_details where id = orders.retailer_id) as retailer_longs, retailer_id as distributor_id, within_radius, status,booker_lats, booker_longs, DATE(created_at) as created_at')->where('LOWER(status) = "'.$status.'" and employee_id = '.$employee)->get("orders")->result();
		if($status == "latest") :
			$orderDetails = $this->db->select('id, (SELECT employee_username from employees_info where employee_id = orders.employee_id) as employee_username, (SELECT territory_name from territory_management where id = (SELECT territory_id from employees_info where employee_id = orders.employee_id)) as territory, (SELECT area_name from area_management where id = (SELECT area_id from territory_management where id = (SELECT territory_id from employees_info where employee_id = orders.employee_id))) as area, (SELECT region_name from regions_info where id = (SELECT region_id from area_management where id = (SELECT area_id from territory_management where id = (SELECT territory_id from employees_info where employee_id = orders.employee_id)))) as region, employee_id, (SELECT retailer_name from retailers_details where id = orders.retailer_id) as distributor_name, (SELECT retailer_lats from retailers_details where id = orders.retailer_id) as retailer_lats, (SELECT retailer_longs from retailers_details where id = orders.retailer_id) as retailer_longs, retailer_id as distributor_id, within_radius, status, booker_lats, booker_longs,DATE(created_at) as created_at')->where('DATE(created_at) = CURDATE() and employee_id = '.$employee)->order_by("(SELECT employee_username from employees_info where employee_id = orders.employee_id)")->get("orders")->result();
		endif;
		$orderStats = array('Pending'=>$this->db->select('count(*) as pendingOrders')->where('status is null or status = "pending" or status = ""')->get('orders')->row()->pendingOrders,'Total'=>$this->db->select('count(*) as totalOrders')->get('orders')->row()->totalOrders,'Cancelled'=>$this->db->select('count(*) as cancelledOrders')->where('status','cancelled')->get('orders')->row()->cancelledOrders, 'Completed'=>$this->db->select('count(*) as completedOrders')->where('status','completed')->get('orders')->row()->completedOrders, 'Compliance'=>$this->db->select('count(*) as compliance')->where('within_radius', 1)->get('orders')->row()->compliance, 'NonCompliance'=>$this->db->select('count(*) as non_compliance')->where('within_radius', 0)->get('orders')->row()->non_compliance);
		return array('stats'=>$orderStats, 'orderDetails'=>$orderDetails);
	}

	public function getAllOrdersAgainstRetailer($employee, $date, $retailerId){
		$orderDetails = $this->db->select('id, (SELECT employee_username from employees_info where employee_id = orders.employee_id) as employee_username, (SELECT territory_name from territory_management where id = (SELECT territory_id from employees_info where employee_id = orders.employee_id)) as territory, (SELECT area_name from area_management where id = (SELECT area_id from territory_management where id = (SELECT territory_id from employees_info where employee_id = orders.employee_id))) as area, (SELECT region_name from regions_info where id = (SELECT region_id from area_management where id = (SELECT area_id from territory_management where id = (SELECT territory_id from employees_info where employee_id = orders.employee_id)))) as region, employee_id, (SELECT retailer_name from retailers_details where id = orders.retailer_id) as distributor_name, (SELECT retailer_lats from retailers_details where id = orders.retailer_id) as retailer_lats, (SELECT retailer_longs from retailers_details where id = orders.retailer_id) as retailer_longs, retailer_id as distributor_id, booker_lats, status, booker_longs, within_radius, DATE(created_at) as created_at')->where('employee_id = '.$employee.' and DATE(created_at) = "'.$date.'" and retailer_id = '.$retailerId)->get("orders")->result();
		$orderStats = array('Pending'=>$this->db->select('count(*) as pendingOrders')->where('status is null or status = "pending" or status = ""')->get('orders')->row()->pendingOrders,'Total'=>$this->db->select('count(*) as totalOrders')->get('orders')->row()->totalOrders,'Cancelled'=>$this->db->select('count(*) as cancelledOrders')->where('status','cancelled')->get('orders')->row()->cancelledOrders, 'Completed'=>$this->db->select('count(*) as completedOrders')->where('status','completed')->get('orders')->row()->completedOrders, 'Compliance'=>$this->db->select('count(*) as compliance')->where('within_radius', 1)->get('orders')->row()->compliance, 'NonCompliance'=>$this->db->select('count(*) as non_compliance')->where('within_radius', 0)->get('orders')->row()->non_compliance);
		return array('stats'=>$orderStats, 'orderDetails'=>$orderDetails);
	}

	public function generateBookingSheet($employee, $date, $status){
		$resultingArray = array();
		$totalAmount = 0;
		$allOrders = $this->db->select('id, (SELECT employee_username from employees_info where employee_id = orders.employee_id) as employee_username, (SELECT territory_name from territory_management where id = (SELECT territory_id from employees_info where employee_id = orders.employee_id)) as territory, employee_id, (SELECT retailer_name from retailers_details where id = orders.retailer_id) as retailer_name, (SELECT retailer_phone from retailers_details where id = orders.retailer_id) as retailer_phone, (SELECT retailer_address from retailers_details where id = orders.retailer_id) as retailer_address, retailer_id as retailer_id, status')->where('employee_id = '.$employee.' and DATE(created_at) = "'.$date.'"')->get("orders")->result();
		foreach($allOrders as $order) :
			$resultingArray[] = array('main_order' => $order, 'order_contents' => $this->db->select('(SELECT item_name from inventory_items where item_id = (SELECT item_id from inventory_preferences where pref_id = oc.pref_id)) as product, (SELECT unit_name from inventory_types_units where unit_id = (SELECT unit_id from inventory_preferences where pref_id = oc.pref_id)) as unit_type, ((SELECT item_trade_price from inventory_preferences where pref_id = oc.pref_id) * oc.item_quantity_booker) as trade_price, oc.booker_discount, IFNULL((SELECT campaign_name from campaign_management where campaign_id = oc.campaign_id), "NA") as scheme, oc.final_price as amount, ("'.$order->status.'") as status')->where('order_id', $order->id)->get('order_contents oc')->result());
			$totalAmount += $this->db->select('(SELECT SUM(final_price) from order_contents where order_id = '.$order->id.') as totalAmount')->where('order_id', $order->id)->get('order_contents oc')->row()->totalAmount;
		endforeach;		
		return array('results' => $resultingArray, 'totalAmount' => $totalAmount);
	}

	public function generateDeliveryChallan($employee, $date, $status){
		$resultingArray = array();
		$orders = $this->db->select('GROUP_CONCAT(id) as id, (SELECT employee_username from employees_info where employee_id = orders.employee_id) as employee_username, (SELECT employee_phone from employees_info where employee_id = orders.employee_id) as employee_phone, (SELECT territory_name from territory_management where id = (SELECT territory_id from employees_info where employee_id = orders.employee_id)) as territory')->where('employee_id = '.$employee.' and DATE(created_at) = "'.$date.'"')->get("orders")->row();
		$resultingArray = array( 'employee' => $orders->employee_username, 'phone' => $orders->employee_phone, 'territory' => $orders->territory, 'data' => $this->db->select('pref_id, (SELECT item_name from inventory_items where item_id = (SELECT item_id from inventory_preferences where pref_id = oc.pref_id)) as product, (SELECT unit_name from inventory_types_units where unit_id = (SELECT unit_id from inventory_preferences where pref_id = oc.pref_id)) as unit, SUM(item_quantity_booker) as required_stock, SUM(item_quantity_updated) as updated')->where('order_id IN ('.$orders->id.')')->group_by('pref_id')->get('order_contents oc')->result());
		return $resultingArray;
	}

	public function GetOrderInvoice($orderId){
		$orderDetails = $this->db->select('id as order_number, IFNULL(status, "Pending") as status, (SELECT CONCAT(employee_first_name," ", employee_last_name) from employees_info where employee_id = orders.employee_id) as employee_name, (SELECT GROUP_CONCAT(pref_id) from order_contents where order_id = orders.id and item_status != 0) as pref_id, (SELECT GROUP_CONCAT(id) from order_contents where order_id = orders.id and item_status != 0) as order_content_id, (SELECT retailer_name from retailers_details where id = orders.retailer_id) as distributor_name, (SELECT retailer_phone from retailers_details where id = orders.retailer_id) as retailer_phone, (SELECT GROUP_CONCAT(COALESCE(item_quantity_updated, item_quantity_booker)) from order_contents where order_id = orders.id and item_status != 0) as item_quantity_booker, (SELECT GROUP_CONCAT(booker_discount) from order_contents where order_id = orders.id and item_status != 0) as booker_discount, (SELECT GROUP_CONCAT(final_price) from order_contents where order_id = orders.id and item_status != 0) as subTotal, (SELECT GROUP_CONCAT(IFNULL(campaign_id, "0")) from order_contents where order_id = orders.id and item_status != 0) as campaigns_used, DATE(created_at) as order_date')->where('id', $orderId)->get("orders")->row();
		$items = array();
		$prefIds = explode(",", $orderDetails->pref_id);
		$itemQuantities = explode(",", $orderDetails->item_quantity_booker);
		$booker_discount = explode(",", $orderDetails->booker_discount);
		$final_price = explode(",", $orderDetails->subTotal);
		$campaigns_used = explode(",", $orderDetails->campaigns_used);
		$order_content_id = explode(",", $orderDetails->order_content_id);
		for ($i=0; $i < sizeof($prefIds); $i++) { 
			$items[] = array(
				'item_details' => $this->db->select('pref_id, item_id, (SELECT item_sku from inventory_items where item_id = ip.item_id) as item_sku, (SELECT item_name from inventory_items where item_id = ip.item_id) as item_name, (SELECT unit_name from inventory_types_units where unit_id = ip.unit_id) as unit_name, item_trade_price, unit_id, (SELECT item_image from inventory_items where item_id = ip.item_id) as item_image, item_quantity, item_warehouse_price, item_trade_price, item_retail_price, item_thumbnail, item_description, sub_category_id, (item_trade_price-(((SELECT discount from retailer_types where id = (SELECT retailer_type_id from retailers_details where id = (SELECT retailer_id from orders where id = '.$orderId.')))/100)*(ip.item_trade_price))) as after_discount')->where('pref_id', $prefIds[$i])->get("inventory_preferences ip")->row(),
				'item_quantity_booker' => $itemQuantities[$i],
				'booker_discount' => $booker_discount[$i],
				'final_price' => $final_price[$i],
				'campaign_used' => $campaigns_used[$i],
				'order_content_id' => $order_content_id[$i]
			);
		}
		$orderDetails->items = $items;
		return $orderDetails;
	}

	public function getSingleOrder($orderId){
		$orderDetails = $this->db->select('id, (SELECT employee_username from employees_info where employee_id = orders.employee_id) as employee_username, (SELECT GROUP_CONCAT(pref_id) from order_contents where order_id = orders.id and item_status != 0 and campaign_id is null) as pref_id, (SELECT GROUP_CONCAT(id) from order_contents where order_id = orders.id and item_status != 0 and campaign_id is null and campaign_id is null) as order_content_id, (SELECT GROUP_CONCAT(COALESCE(item_quantity_updated, item_quantity_booker)) from order_contents where order_id = orders.id and item_status != 0 and campaign_id is null) as item_quantity_booker, (SELECT GROUP_CONCAT(booker_discount) from order_contents where order_id = orders.id and item_status != 0 and campaign_id is null) as booker_discount, (SELECT GROUP_CONCAT(final_price) from order_contents where order_id = orders.id and item_status != 0 and campaign_id is null) as subTotal')->where('id', $orderId)->get("orders")->row();
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

	public function GetRetailersForEmployee($employee_id)
    {
		if ($this->db->select('GROUP_CONCAT(retailer_id) as retailer_ids')->where('employee_id', $employee_id)->get('retailers_assignment')->row()):
			$retailerIds = $this->db->select('GROUP_CONCAT(retailer_id) as retailer_ids')->where('employee_id', $employee_id)->get('retailers_assignment')->row()->retailer_ids;
			return $this->db->select('id as retailer_id, retailer_name, retailer_phone, retailer_email, retailer_address, REPLACE(retailer_image,"./","' . base_url() . '") as retailer_image, retailer_lats, retailer_longs, (SELECT territory_name from territory_management where id = rd.retailer_territory_id) as territory_name, retailer_city, retailer_type_id, retailer_territory_id')->where("find_in_set(id, '" . $retailerIds . "')")->get("retailers_details rd")->result();
		endif;
	}
	
	public function GetDistDiscountForItem($pref_id, $distributor_id){
		return array("distributor_discount"=> $this->db->select('discount')->where("id = (SELECT retailer_type_id from retailers_details where id = " . $distributor_id . ")")->get('retailer_types')->row()->discount, "trade_price_after_discount"=>$this->db->select("(item_trade_price-(((SELECT discount from retailer_types where id = (SELECT retailer_type_id from retailers_details where id = " . $distributor_id . "))/100)*(ip.item_trade_price))) as after_discount")->where('pref_id', $pref_id)->get('inventory_preferences ip')->row()->after_discount);
	}

	public function UpdateStockOrderRemoveItems($orderData){
		$itemsDelete = explode(",", $orderData['items_deleted']);
		foreach ($itemsDelete as $item) :
			$this->db->where('id', $item)->update('order_contents', array('item_status'=>0));
		endforeach;
	}

    public function BookOrderManualEntry($orderDetails)
    {
		$pref_id = $orderDetails["pref_id"];
		$employee_id = $orderDetails["employee_id"];
		$item_quantity_booker = $orderDetails["item_quantity_booker"];
		$booker_discount = $orderDetails["booker_discount"];
		$visit_status = $orderDetails["visit_status"];
		$territory_id = $this->db->select('territory_id')->where('employee_id', $employee_id)->get('employees_info')->row()->territory_id;
		$area_id = $this->db->select('area_id')->where('id', $territory_id)->get('territory_management')->row()->area_id;
		$region_id = $this->db->select('region_id')->where('id', $area_id)->get('area_management')->row()->region_id;
		$orderDetails["created_at"] = $orderDetails["order_date"];
		$orderDetails["booking_region"] = $region_id;
		$orderDetails["booking_area"] = $area_id;
		$orderDetails["booking_territory"] = $territory_id;
		unset($orderDetails["pref_id"]);
		unset($orderDetails["item_quantity_booker"]);
		unset($orderDetails["booker_discount"]);
		unset($orderDetails["order_date"]);
		unset($orderDetails["visit_status"]);
		$orderDetails["invoice_number"] = mt_rand(1000000000, mt_getrandmax());
		$this->db->insert('orders', $orderDetails);
		$order_id = $this->db->insert_id();
		$pref_id = explode(",", $pref_id);
		$item_quantity_booker = explode(",", $item_quantity_booker);
		$booker_discount = explode(",", $booker_discount);
		for ($i = 0; $i < sizeof($pref_id); $i++) {
			$individualPriceForThisPrefId = $this->db->select('(item_trade_price-(((SELECT discount from retailer_types where id = (SELECT retailer_type_id from retailers_details where id = ' . $orderDetails['retailer_id'] . '))/100)*(ip.item_trade_price))) as after_discount')->where('pref_id', $pref_id[$i])->get('inventory_preferences ip')->row()->after_discount;
			if ($booker_discount[$i]):
				$individualPriceForThisPrefId = $individualPriceForThisPrefId - (($booker_discount[$i] / 100) * $individualPriceForThisPrefId);
			endif;
			$final_price = $individualPriceForThisPrefId * $item_quantity_booker[$i];
			$orderContents[] = array("pref_id" => $pref_id[$i], "item_quantity_booker" => $item_quantity_booker[$i], "booker_discount" => $booker_discount[$i], "order_id" => $order_id, "final_price" => $final_price);
			$deductFromThisQuantity = $this->db->select('item_quantity')->where('pref_id', $pref_id[$i])->get('inventory_preferences')->row()->item_quantity;
			$finalQuantity = $deductFromThisQuantity - $item_quantity_booker[$i];
			$this->db->where('pref_id', $pref_id[$i])->update('inventory_preferences', array('item_quantity' => $finalQuantity));
		}
		if ($this->db->insert_batch('order_contents', $orderContents)):
			$visitsMarkedData = array("retailer_id" => $orderDetails["retailer_id"], "employee_id" => $employee_id, "took_order" => 0, "created_at" => $orderDetails["created_at"]);
			if($visit_status == "2" || $visit_status == 2){
				$visitsMarkedData = array("retailer_id" => $orderDetails["retailer_id"], "employee_id" => $employee_id, "took_order" => 1, "created_at" => $orderDetails["created_at"]);
			}
			if($this->db->insert('visits_marked', $visitsMarkedData)){
				return "Success";
			}
		endif;
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
