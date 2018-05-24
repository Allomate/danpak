<?php

class InventoryModel extends CI_Model{

	public function get_inventory($itemId){
		return $this->db->select('pref_id, item_barcode, (SELECT unit_name from inventory_types_units where unit_id = ip.unit_id) as unit_name, item_quantity, item_warehouse_price, item_trade_price, item_retail_price, (SELECT sub_category_name from sub_categories where sub_category_id = ip.sub_category_id) as sub_category_name')->where('item_id',$itemId)->get("inventory_preferences ip")->result();
	}

	public function get_inventory_sku_wise(){
		return $this->db->select('item_id, item_name, item_sku, item_main_description, (SELECT min(REPLACE(item_thumbnail,"./","'.base_url().'")) from inventory_preferences where item_id = it.item_id) as item_thumbnail')->get("inventory_items it")->result();
	}

	public function GetMainSkuDetails($item_id){
		return $this->db->select('item_id, item_sku, item_main_description, item_name, (SELECT min(REPLACE(item_thumbnail,"./","'.base_url().'")) from inventory_preferences where item_id = it.item_id) as item_thumbnail, (SELECT sub_category_name from sub_categories where sub_category_id = (SELECT min(sub_category_id) from inventory_preferences where item_id = it.item_id)) as sub_category, (SELECT main_category_name from main_categories where main_category_id = (SELECT main_category_id from sub_categories where sub_category_id = (SELECT min(sub_category_id) from inventory_preferences where item_id = it.item_id))) as main_category, (SELECT min(REPLACE(item_image,"./","'.base_url().'")) as item_image from inventory_preferences where item_id = it.item_id) as item_image')->where('item_id',$item_id)->get("inventory_items it")->row();
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

	public function delete_sub_inventory($subInventId){
		return $this->db->delete('sub_inventory_management', array('id' => $subInventId)); 
	}

	public function AddInventoryItemWithoutPref($invenData){
		$this->db->insert('inventory_items', array('item_sku'=>$invenData['item_sku'], 'item_name'=>$invenData['item_name'], 'item_main_description'=>$invenData['item_main_description']));
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