<?php

class InventoryModel extends CI_Model{

	public function get_inventory($itemId){
		return $this->db->select('pref_id, item_barcode, (SELECT unit_name from inventory_types_units where unit_id = ip.unit_id) as unit_name, item_quantity, item_warehouse_price, item_trade_price, item_retail_price, (SELECT sub_category_name from sub_categories where sub_category_id = ip.sub_category_id) as sub_category_name')->where('item_id',$itemId)->get("inventory_preferences ip")->result();
	}

	public function get_inventory_sku_wise(){
		return $this->db->query('SELECT item_id, is_active, item_name, item_sku, item_brand, item_main_description, (SELECT min(REPLACE(item_thumbnail,"./","'.base_url().'")) from inventory_preferences where item_id = it.item_id) as item_thumbnail from inventory_items it where is_active = 1')->result();
	}

	public function get_inventory_sku_wise_deactivated(){
		return $this->db->query('SELECT item_id, is_active, item_name, item_sku, item_brand, item_main_description, (SELECT min(REPLACE(item_thumbnail,"./","'.base_url().'")) from inventory_preferences where item_id = it.item_id) as item_thumbnail from inventory_items it where is_active = 0')->result();
	}

	public function get_inventory_sku_wise_for_gallery(){
		return array("data" => $this->db->query('SELECT item_id, item_name, item_sku, item_main_description, (SELECT min(REPLACE(item_thumbnail,"./","'.base_url().'")) from inventory_preferences where item_id = it.item_id) as item_thumbnail from inventory_items it where is_active = 1 limit 0, 18')->result(), "total_records" => $this->db->query("SELECT IFNULL(count(*), 0) as totalRecords from inventory_items")->row()->totalRecords);
	}

	public function get_inventory_sku_wise_for_gallery_with_brand_filter($brand){
		return array("data" => $this->db->query('SELECT item_id, item_name, item_sku, item_main_description, (SELECT min(REPLACE(item_thumbnail,"./","'.base_url().'")) from inventory_preferences where item_id = it.item_id) as item_thumbnail from inventory_items it where is_active = 1 and LOWER(item_brand) LIKE "%'.$brand.'%" limit 0, 18')->result(), "total_records" => $this->db->query("SELECT IFNULL(count(*), 0) as totalRecords from inventory_items where LOWER(item_brand) LIKE '%".$brand."%'")->row()->totalRecords);
	}

	public function getBrandItemsForProductReports($brand){
		return $this->db->select('pref_id, item_barcode, (SELECT item_name from inventory_items where item_id = ip.item_id) as item_name, (SELECT unit_name from inventory_types_units where unit_id = ip.unit_id) as unit_name, (SELECT item_sku from inventory_items where item_id = ip.item_id) as item_sku, item_trade_price')->where('item_id IN (SELECT item_id from inventory_items where item_brand = "'.$brand.'")')->get("inventory_preferences ip")->result();
	}

	public function getSearchedInventory($searchQuery, $brand){
		if($brand != "0"){
			$results = $this->db->query('SELECT item_id, item_name, item_sku, item_main_description, (SELECT min(REPLACE(item_thumbnail,"./","'.base_url().'")) from inventory_preferences where item_id = it.item_id) as item_thumbnail from inventory_items it where is_active = 1 and LOWER(item_sku) LIKE "%'.$searchQuery.'%" and LOWER(item_brand) = "'.$brand.'"')->result();
			if(!$results){
				$newResults = $this->db->query('SELECT item_id, item_name, item_sku, item_main_description, (SELECT min(REPLACE(item_thumbnail,"./","'.base_url().'")) from inventory_preferences where item_id = it.item_id) as item_thumbnail from inventory_items it where is_active = 1 and LOWER(item_name) LIKE "%'.$searchQuery.'%" and LOWER(item_brand) = "'.$brand.'"')->result();
				if(!$newResults){
					return $this->db->query('SELECT item_id, item_name, item_sku, item_main_description, (SELECT min(REPLACE(item_thumbnail,"./","'.base_url().'")) from inventory_preferences where item_id = it.item_id) as item_thumbnail from inventory_items it where is_active = 1 and LOWER(item_main_description) LIKE "%'.$searchQuery.'%" and LOWER(item_brand) = "'.$brand.'"')->result();
				}
				return $newResults;
			}
			return $results;
		}else{
			$results = $this->db->query('SELECT item_id, item_name, item_sku, item_main_description, (SELECT min(REPLACE(item_thumbnail,"./","'.base_url().'")) from inventory_preferences where item_id = it.item_id) as item_thumbnail from inventory_items it where is_active = 1 and LOWER(item_sku) LIKE "%'.$searchQuery.'%"')->result();
			if(!$results){
				$newResults = $this->db->query('SELECT item_id, item_name, item_sku, item_main_description, (SELECT min(REPLACE(item_thumbnail,"./","'.base_url().'")) from inventory_preferences where item_id = it.item_id) as item_thumbnail from inventory_items it where is_active = 1 and LOWER(item_name) LIKE "%'.$searchQuery.'%"')->result();
				if(!$newResults){
					return $this->db->query('SELECT item_id, item_name, item_sku, item_main_description, (SELECT min(REPLACE(item_thumbnail,"./","'.base_url().'")) from inventory_preferences where item_id = it.item_id) as item_thumbnail from inventory_items it where is_active = 1 and LOWER(item_main_description) LIKE "%'.$searchQuery.'%"')->result();
				}
				return $newResults;
			}
			return $results;
		}
	}

	public function getBrands(){
		return $this->db->query('SELECT item_brand from inventory_items where item_brand != "" and item_brand IS NOT NULL group by item_brand')->result();
	}

	public function get_inventory_sku_wise_paginated($startLimit, $brand){
		if($brand != '0'){
			return $this->db->query('SELECT item_id, item_name, item_sku, item_main_description, (SELECT min(REPLACE(item_thumbnail,"./","'.base_url().'")) from inventory_preferences where item_id = it.item_id) as item_thumbnail from inventory_items it where is_active = 1 and item_brand = "'.$brand.'" limit '.$startLimit.', 18')->result();
		}else{
			return $this->db->query('SELECT item_id, item_name, item_sku, item_main_description, (SELECT min(REPLACE(item_thumbnail,"./","'.base_url().'")) from inventory_preferences where item_id = it.item_id) as item_thumbnail from inventory_items it where is_active = 1 limit '.$startLimit.', 18')->result();
		}
	}

	public function RemoveDistributorStock($prefId){
		$distributorId = $this->db->select('distributor_id')->where('session', $this->session->userdata("session"))->get('admin_session')->row()->distributor_id;
		return $this->db->delete('distributor_stock', array('pref_id' => $prefId, "distributor_id" => $distributorId)); 
	}

	public function UpdateDanpakStock($prefId, $quantity){
		$exist = $this->db->select('item_quantity')->where('pref_id', $prefId)->get('inventory_preferences')->row()->item_quantity;
		$exist = (int) $exist + (int) $quantity;
		return $this->db->where('pref_id',$prefId)->update('inventory_preferences', array('item_quantity' => $exist));
	}

	public function RemoveDanpakStock($prefId, $quantity){
		$exist = $this->db->select('item_quantity')->where('pref_id', $prefId)->get('inventory_preferences')->row()->item_quantity;
		$exist = (int) $exist - (int) $quantity;
		return $this->db->where('pref_id',$prefId)->update('inventory_preferences', array('item_quantity' => $exist));
	}

	public function UpdateDistributorStock($prefId, $quantity){
		$alreadyExist = $this->db->where('pref_id = '.$prefId.' and distributor_id = (SELECT distributor_id from admin_session where session = "'.$this->session->userdata("session").'")')->get('distributor_stock')->row();
		if($alreadyExist){
			return $this->db->where('id',$alreadyExist->id)->update('distributor_stock', array('stock' => $quantity));
		}else{
			return $this->db->query('INSERT INTO `distributor_stock`(`pref_id`, `stock`, `distributor_id`) VALUES ('.$prefId.', '.$quantity.', (SELECT distributor_id from admin_session where session = "'.$this->session->userdata("session").'"))');
		}
	}

	public function UpdateBulkTradePrice($prefId, $price){
		return $this->db->where('pref_id',$prefId)->update('inventory_preferences', array('item_trade_price' => $price));
	}

	public function getInventoryForBulkTradePriceUpdate(){
		return $this->db->select('pref_id, item_barcode, (SELECT item_name from inventory_items where item_id = ip.item_id) as item_name, (SELECT unit_name from inventory_types_units where unit_id = ip.unit_id) as unit_name, (SELECT item_sku from inventory_items where item_id = ip.item_id) as item_sku, item_trade_price')->get("inventory_preferences ip")->result();
	}

	public function updateInventoryCore($skuId, $name, $sku, $desc, $brand){
		if($this->db->where('item_sku = "'.$sku.'" and item_id != '.$skuId)->get('inventory_items')->row())
			return "Exist";
		
		return $this->db->where('item_id', $skuId)->update('inventory_items', array('item_name' => $name, 'item_sku' => $sku, 'item_main_description' => $desc, 'item_brand' => $brand));
	}

	public function getInventoryForDistributorStockManagement(){
		return $this->db->select('pref_id, (SELECT stock from distributor_stock where distributor_id = (SELECT distributor_id from admin_session where session = "'.$this->session->userdata("session").'") and pref_id = ip.pref_id) as stocked, (SELECT item_name from inventory_items where item_id = ip.item_id) as item_name, (SELECT unit_name from inventory_types_units where unit_id = ip.unit_id) as unit_name, (SELECT item_sku from inventory_items where item_id = ip.item_id) as item_sku, (SELECT item_main_description from inventory_items where item_id = ip.item_id) as item_main_description, REPLACE(item_thumbnail,"./","'.base_url().'") as item_thumbnail')->get("inventory_preferences ip")->result();
	}

	public function getInventoryForDanpakStockManagement(){
		return $this->db->select('pref_id, item_quantity, (SELECT item_name from inventory_items where item_id = ip.item_id) as item_name, (SELECT unit_name from inventory_types_units where unit_id = ip.unit_id) as unit_name, (SELECT item_sku from inventory_items where item_id = ip.item_id) as item_sku, (SELECT item_main_description from inventory_items where item_id = ip.item_id) as item_main_description, REPLACE(item_thumbnail,"./","'.base_url().'") as item_thumbnail')->get("inventory_preferences ip")->result();
	}

	public function GetMainSkuDetails($item_id){
		return $this->db->select('item_id, item_sku, item_brand, item_main_description, item_name, (SELECT min(REPLACE(item_thumbnail,"./","'.base_url().'")) from inventory_preferences where item_id = it.item_id) as item_thumbnail, (SELECT sub_category_name from sub_categories where sub_category_id = (SELECT min(sub_category_id) from inventory_preferences where item_id = it.item_id)) as sub_category, (SELECT main_category_name from main_categories where main_category_id = (SELECT main_category_id from sub_categories where sub_category_id = (SELECT min(sub_category_id) from inventory_preferences where item_id = it.item_id))) as main_category, (SELECT min(REPLACE(item_image,"./","'.base_url().'")) as item_image from inventory_preferences where item_id = it.item_id) as item_image')->where('item_id',$item_id)->get("inventory_items it")->row();
	}

	public function get_inventory_for_this_order($orderId){
		return $this->db->select('pref_id, (SELECT item_sku from inventory_items where item_id = ip.item_id) as item_sku, (SELECT item_name from inventory_items where item_id = ip.item_id) as item_name, (SELECT unit_name from inventory_types_units where unit_id = ip.unit_id) as unit_name, item_quantity, item_warehouse_price, item_trade_price, item_retail_price, (SELECT sub_category_name from sub_categories where sub_category_id = ip.sub_category_id) as sub_category_name, (item_trade_price-(((SELECT discount from retailer_types where id = (SELECT retailer_type_id from retailers_details where id = (SELECT retailer_id from orders where id = '.$orderId.')))/100)*(ip.item_trade_price))) as after_discount')->get("inventory_preferences ip")->result();
	}

	public function get_sub_inventory(){
		return $this->db->select('id, CONCAT((SELECT item_name from inventory_items where item_id = (SELECT item_id from inventory_preferences where pref_id = sim.inside_this_item_pref_id)), " (", (SELECT unit_name from inventory_types_units where unit_id = (SELECT unit_id from inventory_preferences where pref_id = sim.inside_this_item_pref_id)), ")") as inside_this_item, quantity, CONCAT((SELECT item_name from inventory_items where item_id = (SELECT item_id from inventory_preferences where pref_id = sim.item_inside_pref_id)), " (", (SELECT unit_plural_name from inventory_types_units where unit_id = (SELECT unit_id from inventory_preferences where pref_id = sim.item_inside_pref_id)), ")") as item_inside')->get("sub_inventory_management sim")->result();
	}

	public function GetInventoryPreferencesForSubInventMgmt(){
		return $this->db->select('item_id, (SELECT item_name from inventory_items where item_id = ip.item_id) as item_name, 
			(SELECT GROUP_CONCAT(CONCAT(unit_name, "(" , unit_id, ")")) from inventory_types_units where find_in_set(unit_id, GROUP_CONCAT(ip.unit_id))) as units_data')->group_by('item_id')->get('inventory_preferences ip')->result();
	}

	public function GetUnitTypes(){
		return $this->db->get('inventory_types_units')->result();
	}

	public function GetUnitsForSku($itemId){
		return $this->db->select('GROUP_CONCAT(unit_id) as unit_id')->where('item_id', $itemId)->get('inventory_preferences')->result();
	}

	public function GetUnitNamesForSku($itemId){
		return $this->db->select('unit_id, unit_name, (SELECT pref_id from inventory_preferences where item_id = '.$itemId.' and unit_id = itu.unit_id) as pref_id')->where("find_in_set(unit_id, (SELECT GROUP_CONCAT(unit_id) from inventory_preferences where item_id = ".$itemId."))")->get('inventory_types_units itu')->result();
	}

	public function GetUnitNamesForSkuWithRetDiscount($item_id, $orderId){
		$data = [];
		$counter = 0;
		$units = $this->db->select('unit_id, unit_name, (SELECT pref_id from inventory_preferences where item_id = '.$item_id.' and unit_id = itu.unit_id) as pref_id, (SELECT item_id from inventory_preferences where item_id = '.$item_id.' and unit_id = itu.unit_id) as item_id, (SELECT item_name from inventory_items where item_id = (SELECT item_id from inventory_preferences where item_id = '.$item_id.' and unit_id = itu.unit_id)) as item_name, (SELECT REPLACE(item_thumbnail,"./","'.base_url().'") from inventory_preferences where item_id = '.$item_id.' and unit_id = itu.unit_id) as item_thumbnail, (SELECT item_trade_price from inventory_preferences where item_id = '.$item_id.' and unit_id = itu.unit_id) as tp, ( SELECT (item_trade_price-(((SELECT discount from retailer_types where id = (SELECT retailer_type_id from retailers_details where id = (SELECT retailer_id from orders where id = '.$orderId.')))/100)*(ip.item_trade_price))) from inventory_preferences ip where item_id = '.$item_id.' and unit_id = itu.unit_id) as after_discount')->where("find_in_set(unit_id, (SELECT GROUP_CONCAT(unit_id) from inventory_preferences where item_id = ".$item_id."))")->get('inventory_types_units itu')->result();
		foreach ($units as $unit) {
			$data[$counter] = $unit;
			$campaign = $this->db->where('scheme_active = 1 and eligibility_criteria_pref_id = (SELECT pref_id from inventory_preferences where item_id = '.$item_id.' and unit_id = '.$unit->unit_id.')')->get('campaign_management')->row();
			if(!$campaign){
				$counter++;
				continue;
			}
			if($campaign->scheme_type == "1"){
                $data[$counter]->campaign = $this->db->select('(REPLACE(scheme_image,"./","' . base_url() . '")) as scheme_image, campaign_id, eligibility_criteria_pref_id as pref_id, cm.minimum_quantity_for_eligibility as item_quantity, (SELECT REPLACE(item_thumbnail,"./","' . base_url() . '") from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id) as item_thumbnail, (SELECT item_name from inventory_items where item_id = (SELECT item_id from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id)) as item_name, CEIL(((((((SELECT item_trade_price from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id) - cm.scheme_amount))-(((SELECT discount from retailer_types where id = (SELECT retailer_type_id from retailers_details where id = 1))/100)*((SELECT item_trade_price from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id) - cm.scheme_amount)))))) as individual_price, CEIL(((((((SELECT item_trade_price from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id) - cm.scheme_amount))-(((SELECT discount from retailer_types where id = (SELECT retailer_type_id from retailers_details where id = 1))/100)*((SELECT item_trade_price from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id) - cm.scheme_amount)))) * cm.minimum_quantity_for_eligibility)) as final_price')->where('campaign_id', $campaign->campaign_id)->get('campaign_management cm')->row();
			}else if($campaign->scheme_type == "2"){
                $data[$counter]->campaign = $this->db->select('(REPLACE(scheme_image,"./","' . base_url() . '")) as scheme_image, campaign_id, eligibility_criteria_pref_id as pref_id, cm.minimum_quantity_for_eligibility as item_quantity, (SELECT REPLACE(item_thumbnail,"./","' . base_url() . '") from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id) as item_thumbnail, (SELECT item_name from inventory_items where item_id = (SELECT item_id from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id)) as item_name, CEIL((((((SELECT item_trade_price from inventory_preferences where pref_id = (SELECT min(item_inside_pref_id) from sub_inventory_management where inside_this_item_pref_id = cm.eligibility_criteria_pref_id)) - cm.discount_on_tp_pkr) - (((SELECT discount from retailer_types where id = (SELECT retailer_type_id from retailers_details where id = 1))/100)*((SELECT item_trade_price from inventory_preferences where pref_id = (SELECT min(item_inside_pref_id) from sub_inventory_management where inside_this_item_pref_id = cm.eligibility_criteria_pref_id)) - cm.discount_on_tp_pkr))) * (SELECT min(quantity) from sub_inventory_management where inside_this_item_pref_id = cm.eligibility_criteria_pref_id)))) as individual_price, CEIL((((((SELECT item_trade_price from inventory_preferences where pref_id = (SELECT min(item_inside_pref_id) from sub_inventory_management where inside_this_item_pref_id = cm.eligibility_criteria_pref_id)) - cm.discount_on_tp_pkr) - (((SELECT discount from retailer_types where id = (SELECT retailer_type_id from retailers_details where id = 1))/100)*((SELECT item_trade_price from inventory_preferences where pref_id = (SELECT min(item_inside_pref_id) from sub_inventory_management where inside_this_item_pref_id = cm.eligibility_criteria_pref_id)) - cm.discount_on_tp_pkr))) * (SELECT min(quantity) from sub_inventory_management where inside_this_item_pref_id = cm.eligibility_criteria_pref_id)) * cm.minimum_quantity_for_eligibility)) as final_price')->where('campaign_id', $campaign->campaign_id)->get('campaign_management cm')->row();
			}else if($campaign->scheme_type == "3"){
                $data[$counter]->campaign = $this->db->select('(REPLACE(scheme_image,"./","' . base_url() . '")) as scheme_image, campaign_id, eligibility_criteria_pref_id as pref_id, cm.minimum_quantity_for_eligibility as item_quantity, (SELECT REPLACE(item_thumbnail,"./","' . base_url() . '") from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id) as item_thumbnail, (SELECT item_name from inventory_items where item_id = (SELECT item_id from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id)) as item_name, CEIL(((((((SELECT item_warehouse_price from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id) - cm.offered_gift_price))-(((SELECT discount from retailer_types where id = (SELECT retailer_type_id from retailers_details where id = 1))/100)*((SELECT item_warehouse_price from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id) - cm.offered_gift_price)))))) as individual_price, CEIL(((((((SELECT item_warehouse_price from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id) - cm.offered_gift_price))-(((SELECT discount from retailer_types where id = (SELECT retailer_type_id from retailers_details where id = 1))/100)*((SELECT item_warehouse_price from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id) - cm.offered_gift_price)))) * cm.minimum_quantity_for_eligibility)) as final_price')->where('campaign_id', $campaign->campaign_id)->get('campaign_management cm')->row();
			}

			$counter++;
		}
		return $data;
	}

	public function GetVariantPrice($itemId, $unitId, $orderId){
		return $this->db->select('(item_trade_price-(((SELECT discount from retailer_types where id = (SELECT retailer_type_id from retailers_details where id = (SELECT retailer_id from orders where id = '.$orderId.')))/100)*(ip.item_trade_price))) as tp')->where('item_id = '.$itemId.' and unit_id = '.$unitId)->get('inventory_preferences ip')->row()->tp;
	}

	public function AddSubInventory($subInventData){
		$itemInsidePref = $this->db->select('pref_id')->where(array('item_id'=>$subInventData["item_name_item_inside"], 'unit_id'=>$subInventData["unit_id_item_inside"]))->get('inventory_preferences')->row()->pref_id;
		$insideThisPref = $this->db->select('pref_id')->where(array('item_id'=>$subInventData["item_name_inside_this_item"], 'unit_id'=>$subInventData["unit_id_inside_this_item"]))->get('inventory_preferences')->row()->pref_id;
		if ($this->db->where('inside_this_item_pref_id = '.$insideThisPref.' and item_inside_pref_id = '.$itemInsidePref)->get('sub_inventory_management')->result()) {
			return "sub_invent_exist";
		}
		$data = array('inside_this_item_pref_id' => $insideThisPref, 'quantity' => $subInventData['quantity'], 'item_inside_pref_id' => $itemInsidePref);
		return $this->db->insert('sub_inventory_management', $data);
	}

	public function UpdateSubInventory($subInventId, $subInventData){
		$itemInsidePref = $this->db->select('pref_id')->where(array('item_id'=>$subInventData["item_name_item_inside"], 'unit_id'=>$subInventData["unit_id_item_inside"]))->get('inventory_preferences')->row()->pref_id;
		$insideThisPref = $this->db->select('pref_id')->where(array('item_id'=>$subInventData["item_name_inside_this_item"], 'unit_id'=>$subInventData["unit_id_inside_this_item"]))->get('inventory_preferences')->row()->pref_id;
		if ($this->db->where('inside_this_item_pref_id = '.$insideThisPref.' and item_inside_pref_id = '.$itemInsidePref.' and id != '.$subInventId)->get('sub_inventory_management')->result()) {
			return "sub_invent_exist";
		}
		$data = array('inside_this_item_pref_id' => $insideThisPref, 'quantity' => $subInventData['quantity'], 'item_inside_pref_id' => $itemInsidePref);
		return $this->db->where('id',$subInventId)->update('sub_inventory_management', $data);
	}

	public function GetSingleSubInventory($subInventId){
		return $this->db->select('quantity, CONCAT((SELECT item_id from inventory_preferences ip where pref_id = sim.inside_this_item_pref_id), "-", (SELECT unit_id from inventory_preferences ip where pref_id = sim.inside_this_item_pref_id)) as inside_this_item, CONCAT((SELECT item_id from inventory_preferences ip where pref_id = sim.item_inside_pref_id), "-", (SELECT unit_id from inventory_preferences ip where pref_id = sim.item_inside_pref_id)) as item_inside')->where('id', $subInventId)->get('sub_inventory_management sim')->row();
	}

	public function GetSingleSubInventoryForConversion($subInventId){
		return $this->db->select('id, (SELECT item_quantity from inventory_preferences where pref_id = sim.inside_this_item_pref_id) as parent_quantity, (SELECT item_quantity from inventory_preferences where pref_id = sim.item_inside_pref_id) as child_quantity, CONCAT((SELECT item_name from inventory_items where item_id = (SELECT item_id from inventory_preferences where pref_id = sim.inside_this_item_pref_id)), " (", (SELECT unit_name from inventory_types_units where unit_id = (SELECT unit_id from inventory_preferences where pref_id = sim.inside_this_item_pref_id)), ")") as parent_item, CONCAT((SELECT item_name from inventory_items where item_id = (SELECT item_id from inventory_preferences where pref_id = sim.item_inside_pref_id)), " (", (SELECT unit_name from inventory_types_units where unit_id = (SELECT unit_id from inventory_preferences where pref_id = sim.item_inside_pref_id)), ")") as child_item, quantity')->where('id', $subInventId)->get('sub_inventory_management sim')->row();
	}

	public function ConvertParentToChild($subInventId, $conversionData){
		$childPrefId = $this->db->select('item_inside_pref_id')->where('id', $subInventId)->get('sub_inventory_management')->row()->item_inside_pref_id;
		$parentPrefId = $this->db->select('inside_this_item_pref_id')->where('id', $subInventId)->get('sub_inventory_management')->row()->inside_this_item_pref_id;
		$getExistingChildQuantity = $this->db->select('item_quantity')->where('pref_id', $childPrefId)->get('inventory_preferences')->row()->item_quantity;
		$newChildQuantity = $conversionData["quantityAddingToChild"]+$getExistingChildQuantity;
		$this->db->where('pref_id',$childPrefId)->update('inventory_preferences', array('item_quantity'=>$newChildQuantity));
		return $this->db->where('pref_id',$parentPrefId)->update('inventory_preferences', array('item_quantity'=>$conversionData["quantityRemainingForParent"]));
	}

	public function GetInventoryItems(){
		return $this->db->select('item_id, item_name, item_sku, (SELECT GROUP_CONCAT(unit_id) from inventory_preferences where item_id = items.item_id) as unit_ids')->get('inventory_items items')->result();
	}

	public function add_unit($unitsData){
		return $this->db->insert('inventory_types_units', $unitsData);
	}

	public function GetUnitsAvailableForThisProduct($item_id){
		return $this->db->select('unit_id, unit_name, (SELECT pref_id from inventory_preferences where item_id = '.$item_id.' and unit_id = itu.unit_id) as pref_id')->where('find_in_set(unit_id, (SELECT GROUP_CONCAT(unit_id) from inventory_preferences where item_id = '.$item_id.' ))')->get('inventory_types_units itu')->result();
	}

	public function update_unit($unit_id, $unitsData){
		return $this->db
		->where('unit_id',$unit_id)	
		->update('inventory_types_units', $unitsData);
	}

	public function get_single_unit_details($unit_id){
		return $this->db->where('unit_id', $unit_id)->get("inventory_types_units")->row();
	}

	public function delete_unit($unit_id){
		return $this->db->delete('inventory_types_units', array('unit_id' => $unit_id)); 
	}

	public function deactivate($item_id){
		return $this->db->where('item_id', $item_id)->update('inventory_items', array('is_active'=>0));
	}

	public function activate($item_id){
		return $this->db->where('item_id', $item_id)->update('inventory_items', array('is_active'=>1));
	}

	public function delete_sub_inventory($subInventId){
		return $this->db->delete('sub_inventory_management', array('id' => $subInventId)); 
	}

	public function AddInventoryItemWithoutPref($invenData){
		$this->db->insert('inventory_items', array('item_sku'=>$invenData['item_sku'], 'item_name'=>$invenData['item_name'], 'item_brand'=>$invenData['item_brand'], 'item_main_description'=>$invenData['item_main_description']));
		return $this->db->insert_id();
	}

	public function CheckRuntimeSkuExistence($sku){
		return $this->db->select('item_sku')->where('item_sku', $sku)->get('inventory_items')->row();
	}

	public function AddParentChildDataWithAddInventory($subInventoryData){
		if (!sizeof($subInventoryData)) :
			return 1;
		else:
			$childData = array();
			return $subInventoryData;
			foreach ($subInventoryData as $data) :
				$parentPrefId = $this->db->select('pref_id')->where('item_id = '.$data['parent_item_main_item_id'].' and unit_id = '.$data['parent_item_unit_id'])->get('inventory_preferences')->row()->pref_id;
				$childPrefId = $this->db->select('pref_id')->where('item_id = '.$data['parent_item_main_item_id'].' and unit_id = '.$data['child_item_unit_id'])->get('inventory_preferences')->row()->pref_id;
				$childData[] = array('inside_this_item_pref_id'=>$parentPrefId, 'quantity'=>$data['child_item_quantity'], 'item_inside_pref_id'=>$childPrefId);
			endforeach;
			return $this->db->insert_batch('sub_inventory_management', $childData);
		endif;
	}

	public function AddInventoryPreferences($preferencesData){
		return $this->db->insert_batch('inventory_preferences', $preferencesData);
	}

	public function add_inventory($itemData){
		if (isset($itemData["item_id"])) :
			if ($this->db->where(array('item_id'=>$itemData['item_id'], 'unit_id'=>$itemData['unit_id']))->get("inventory_preferences ip")->row()) :
				return "exist";
			endif;
			return $this->db->insert('inventory_preferences', $itemData);
		else:
			unset($itemData['pre_defined_item']);
			$inventItems = array('item_name'=>$itemData['item_name'], 'item_sku'=>$itemData['item_sku'], 'item_main_description'=>$itemData['item_main_description']);
			$this->db->insert('inventory_items', $inventItems);
			$item_id = $this->db->insert_id();
			unset($itemData["item_name"], $itemData["item_sku"]);
			$itemData["item_id"] = $item_id;
			return $this->db->insert('inventory_preferences', $itemData);
		endif;
	}

	public function get_single_item_details($pref_id){
		return $this->db->select('pref_id, item_barcode, item_id, (SELECT item_sku from inventory_items where item_id = ip.item_id) as item_sku, (SELECT item_main_description from inventory_items where item_id = ip.item_id) as item_main_description, (SELECT item_name from inventory_items where item_id = ip.item_id) as item_name, unit_id, REPLACE(item_image,"./","'.base_url().'") as item_image, item_quantity, item_warehouse_price, item_trade_price, item_retail_price, REPLACE(item_thumbnail,"./","'.base_url().'") as item_thumbnail, item_description, sub_category_id, (SELECT main_category_id from sub_categories where sub_category_id = ip.sub_category_id) as main_category_id')->where('pref_id', $pref_id)->get("inventory_preferences ip")->row();
	}

	public function update_inventory($pref_id, $itemData){

		$item_id = $this->db->select('item_id')->where('pref_id', $pref_id)->get('inventory_preferences')->row()->item_id;
		if ($this->db->where('item_id = '.$item_id.' and unit_id = '.$itemData['unit_id'].' and pref_id != '.$pref_id)->get("inventory_preferences ip")->row()) :
			return "exist";
		endif;
		unset($itemData['pre_defined_item']);
		$inventItems = array('item_name'=>$itemData['item_name'], 'item_sku'=>$itemData['item_sku'], 'item_main_description'=>$itemData['item_main_description']);
		$skuExist = $this->db->select('item_sku')->where('item_id != '.$item_id.' and item_sku = "'.$inventItems['item_sku'].'"')->get('inventory_items')->result();
		if (!$skuExist) :
			if ($this->db->where('item_id', $item_id)->update('inventory_items', $inventItems)) :
				unset($itemData["item_name"], $itemData["item_sku"], $itemData["item_main_description"]);
				if ($this->db->where('pref_id', $pref_id)->update('inventory_preferences', $itemData)) :
					return $this->db->where('item_id', $item_id)->update('inventory_preferences', array('item_image'=>$itemData['item_image'], 'item_thumbnail'=>$itemData['item_thumbnail']));
				endif;
			else:
				return false;
			endif;
		else:
			return "sku_exist";
		endif;
	}

	public function delete_inventory($pref_id){
		return $this->db->delete('inventory_preferences', array('pref_id' => $pref_id)); 
	}

	public function delete_inventory_sku($itemId){
		if ($this->db->delete('inventory_items', array('item_id' => $itemId))) :
			return $this->db->delete('inventory_preferences', array('item_id' => $itemId));
		endif;
	}

}

?>
