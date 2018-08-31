<?php

class Inventory extends WebAuth_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('InventoryModel', 'im');
		$this->load->model('CategoryModel', 'cm');
	}

	public function ListUnits(){
		return $this->load->view('Inventory/ListUnits', [ 'UnitTypes' => $this->im->GetUnitTypes() ]);
	}
	
	public function AddUnit(){
		return $this->load->view('Inventory/AddUnit');
	}
	
	public function UpdateUnit($unit_id){
		return $this->load->view('Inventory/UpdateUnit', [ 'UnitType' => $this->im->get_single_unit_details($unit_id) ]);
	}

	public function DistributorStockManagement(){
		// echo "<pre>"; print_r($this->im->getInventoryForDistributorStockManagement());die;
		return $this->load->view('Inventory/DistributorStockManagement', [ 'Inventory' => $this->im->getInventoryForDistributorStockManagement() ]);
	}

	public function AddDistributorStock(){
		echo json_encode($this->im->UpdateDistributorStock($this->input->post("pref_id"), $this->input->post("quantity")));
	}

	public function DeleteDistributorStock(){
		echo json_encode($this->im->RemoveDistributorStock($this->input->post("pref_id")));
	}

	public function AddUnitOps()
	{
		$this->form_validation->set_rules('unit_name', 'Packaging Name', 'required|max_length[100]');
		$this->form_validation->set_rules('unit_plural_name', 'Packaging Plural Name', 'max_length[100]');
		$this->form_validation->set_rules('unit_short_name', 'Packaging Short Name', 'max_length[100]');
		if ($this->form_validation->run()) {
			$unitsData = $this->input->post();
			if ($this->im->add_unit($unitsData)) :
				$this->session->set_flashdata("unit_added", "Packaging has been added successfully");
			else:
				$this->session->set_flashdata("unit_add_failed", "Failed to add the packaging");
			endif;
			return redirect('Inventory/ListUnits');
		}else{
			return $this->load->view('Inventory/AddUnit');
		}
	}

	public function UpdateUnitOps($unit_id)
	{
		$this->form_validation->set_rules('unit_name', 'Packaging Name', 'required|max_length[100]');
		$this->form_validation->set_rules('unit_plural_name', 'Packaging Plural Name', 'max_length[100]');
		$this->form_validation->set_rules('unit_short_name', 'Packaging Short Name', 'max_length[100]');
		if ($this->form_validation->run()) {
			$unitsData = $this->input->post();
			if ($this->im->update_unit($unit_id, $unitsData)) :
				$this->session->set_flashdata("unit_updated", "Packaging has been updated successfully");
			else:
				$this->session->set_flashdata("unit_update_failed", "Failed to update the packaging");
			endif;
			return redirect('Inventory/ListUnits');
		}else{
			return $this->load->view('Inventory/UpdateUnit', [ 'UnitType' => $this->im->get_single_unit_details($unit_id) ]);
		}
	}

	public function DeleteUnit($unit_id)
	{
		if ($this->im->delete_unit($unit_id)) :
			$this->session->set_flashdata('unit_deleted', 'Packaging has been deleted successfully');
		else:
			$this->session->set_flashdata('unit_delete_failed', 'Unable to delete the packaging');
		endif;
		return redirect('Inventory/ListUnits');
	}

	public function DeleteSubInventory($subInventId)
	{
		if ($this->im->delete_sub_inventory($subInventId)) :
			$this->session->set_flashdata('sub_inventory_deleted', 'Sub-inventory has been deleted successfully');
		else:
			$this->session->set_flashdata('sub_inventory_delete_failed', 'Unable to delete the sub-inventory');
		endif;
		return redirect('Inventory/ListSubInventory');
	}

	public function DeleteInventory($prefId)
	{
		if ($this->im->delete_inventory($prefId)) :
			$this->session->set_flashdata('inventory_deleted', 'Inventory has been deleted successfully');
		else:
			$this->session->set_flashdata('inventory_delete_failed', 'Unable to delete the Inventory');
		endif;
		return redirect('Inventory/ListInventory');
	}

	public function DeleteInventorySku($itemId)
	{
		if ($this->im->delete_inventory_sku($itemId)) :
			$this->session->set_flashdata('inventory_deleted', 'Inventory has been deleted successfully');
		else:
			$this->session->set_flashdata('inventory_delete_failed', 'Unable to delete the Inventory');
		endif;
		return redirect('Inventory/ListInventory');
	}

	public function ConvertTo($subInventId){
		return $this->load->view('Inventory/ConvertSubInventory', [ 'SubInventoryData' => $this->im->GetSingleSubInventoryForConversion($subInventId) ]);
	}

	public function ConvertSubInventoryOps($subInventId){
		$conversionData = $this->input->post();
		unset($conversionData["each_parent_contains_quantity"]);
		if ($this->im->ConvertParentToChild($subInventId, $conversionData)) :
			$this->session->set_flashdata('sub_inventory_converted', 'Sub-inventory has been converted successfully');
			return redirect('Inventory/ListInventory');
		else:
			$this->session->set_flashdata('sub_inventory_convert_failed', 'Unable to convert the sub-inventory');
			return redirect('Inventory/ListSubInventory');
		endif;
	}

	public function ListSubInventory(){
		return $this->load->view('Inventory/ListSubInventory', [ 'SubInventory' => $this->im->get_sub_inventory() ]);
	}

	public function AddSubInventory(){
		return $this->load->view('Inventory/AddSubInventory');
	}

	public function AddSubInventoryOps(){
		$subInventData = $this->input->post();
		$this->form_validation->set_rules('item_name_item_inside', 'Item Name', 'required');
		$this->form_validation->set_rules('unit_id_item_inside', 'Item Name', 'required');
		$this->form_validation->set_rules('quantity', 'Item Quantity', 'required|greater_than[0]');
		$this->form_validation->set_rules('item_name_inside_this_item', 'Item Name', 'required');
		$this->form_validation->set_rules('unit_id_inside_this_item', 'Item Name', 'required');
		if ($this->form_validation->run()) :
			unset($subInventData["subInventData"]);
			unset($subInventData["currentController"]);
			$response = $this->im->AddSubInventory($subInventData);
			if ($response) :
				if ($response == "sub_invent_exist" && $response != 1) {
					return $this->load->view('Inventory/AddSubInventory', ['sub_invent_exist'=>'These preferences already exist. You can update the preferences any time by clicking update']);
				}else{
					$this->session->set_flashdata("sub_invent_added", "Sub Inventory has been added successfully");
				}
			else:
				$this->session->set_flashdata("sub_invent_add_failed", "Unable to add the sub-inventory");
			endif;
			return redirect('Inventory/ListSubInventory');
		else:
			return $this->load->view('Inventory/AddSubInventory');
		endif;
	}

	public function UpdateSubInventory(){
		return $this->load->view('Inventory/UpdateSubInventory');
	}

	public function UpdateSubInventoryOps($subInventId){
		$subInventData = $this->input->post();
		$this->form_validation->set_rules('item_name_item_inside', 'Item Name', 'required');
		$this->form_validation->set_rules('unit_id_item_inside', 'Item Name', 'required');
		$this->form_validation->set_rules('quantity', 'Item Quantity', 'required|greater_than[0]');
		$this->form_validation->set_rules('item_name_inside_this_item', 'Item Name', 'required');
		$this->form_validation->set_rules('unit_id_inside_this_item', 'Item Name', 'required');
		if ($this->form_validation->run()) :
			unset($subInventData["subInventData"]);
			unset($subInventData["thisSubInventData"]);
			unset($subInventData["currentController"]);
			$response = $this->im->UpdateSubInventory($subInventId, $subInventData);
			if ($response) :
				if ($response == "sub_invent_exist" && $response != 1) {
					return $this->load->view('Inventory/UpdateSubInventory', ['sub_invent_exist'=>'These preferences already exist. You can update the preferences any time by clicking update']);
				}else{
					$this->session->set_flashdata("sub_inventory_updated", "Sub Inventory has been updated successfully");
				}
			else:
				$this->session->set_flashdata("sub_inventory_update_failed", "Unable to update the sub-inventory");
			endif;
			return redirect('Inventory/ListSubInventory');
		else:
			return $this->load->view('Inventory/UpdateSubInventory');
		endif;
	}

	public function SubInventDataForAjax(){
		echo json_encode($this->im->GetInventoryPreferencesForSubInventMgmt());
	}

	public function FetchSubCategoriesForMainCategoryAjax(){
		echo json_encode($this->cm->GetSubCatForMain($this->input->post('main_category')));
	}

	public function GetSingleSubInventory($subInventId){
		echo json_encode($this->im->GetSingleSubInventory($subInventId));
	}

	public function GetDefinedUnitsForThisSKuAjax(){
		echo json_encode($this->im->GetUnitsForSku($this->input->post("itemId")));
	}

	public function GetRuntimeSku(){
		$status = $this->im->CheckRuntimeSkuExistence($this->input->post("sku"));
		echo json_encode($status);
	}

	public function ListInventory(){
		return $this->load->view('Inventory/ListInventory', [ 'inventoryListSku' => $this->im->get_inventory_sku_wise() ]);
	}

	public function ProductGallery(){
		return $this->load->view('Inventory/InventoryGallery', [ 'inventoryListSku' => $this->im->get_inventory_sku_wise() ]);
	}

	public function AddInventory(){
		return $this->load->view('Inventory/AddInventory', [ 'UnitTypes' => $this->im->GetUnitTypes(), 'PreDefinedItems' => $this->im->GetInventoryItems(), 'MainCategories' => $this->cm->GetMainCategories() ]);
	}

	public function UpdateInventory($pref_id){
		return $this->load->view('Inventory/UpdateInventory', [ 'UnitTypes' => $this->im->GetUnitTypes(), 'item' => $this->im->get_single_item_details($pref_id), 'MainCategories' => $this->cm->GetMainCategories() ]);
	}

	public function UpdateInventorySku($item_id){
		return $this->load->view('Inventory/UpdateInventorySku', [ 'UnitTypes' => $this->im->GetUnitTypes(), 'SkuInventory' => $this->im->get_inventory($item_id), 'GetMainDetails' => $this->im->GetMainSkuDetails($item_id), 'MainCategories' => $this->cm->GetMainCategories() ]);
	}

	public function AddInventoryOps(){

		$config['upload_path'] = './assets/uploads/inventory/';
		$config['allowed_types'] = 'jpg|bmp|png|jpeg';
		$config['max_size'] = 'jpg|bmp|png|jpeg';
		$this->load->helper('file');
		$this->load->library('upload', $config);
		$item_thumbnail = '';
		$item_images = '';
		$mainItemId = 0;

		$itemData = $this->input->post();

		if ($this->input->post('pre_defined_item')) {
			$mainItemId = $itemData["pre_defined_item"];
			unset($itemData["pre_defined_item"]);
			unset($itemData["item_sku"]);
			unset($itemData["item_name"]);
		}else{
			$this->form_validation->set_rules(
				'item_sku', 'Item Sku',
				'required|max_length[20]|trim|is_unique[inventory_items.item_sku]',
				array(
					'required'      => 'You have not provided %s.',
					'is_unique'     => 'This %s already exists.'
				)
			);
			$this->form_validation->set_rules('item_name', 'Item Name', 'required|max_length[200]');

			if (!$this->form_validation->run()) :
				return $this->load->view('Inventory/AddInventory', [ 'UnitTypes' => $this->im->GetUnitTypes(), 'PreDefinedItems' => $this->im->GetInventoryItems(), 'MainCategories' => $this->cm->GetMainCategories() ]);
			else:
				$mainItemId = $this->im->AddInventoryItemWithoutPref($itemData);
			endif;
		}

		unset($itemData['subCatDataForAjax']);

		$item_thumbnail = '';
		if (isset($_FILES['item_thumbnail'])) :
			$_FILES['item_thumbnail'] = array_filter($_FILES['item_thumbnail']);
		endif;
		if (!empty($_FILES['item_thumbnail']['name'])) :
			$config['upload_path'] = './assets/uploads/inventory/';
			$config['allowed_types'] = 'jpg|bmp|png|jpeg';
			$config['max_size'] = 'jpg|bmp|png|jpeg';
			$this->load->helper('file');
			$this->load->library('upload', $config);
			$item_thumbnail = '';
			$_FILES['userfile']['name'] = time().'-'.trim($_FILES['item_thumbnail']['name']);
			$_FILES['userfile']['type'] = $_FILES['item_thumbnail']['type'];
			$_FILES['userfile']['tmp_name'] = $_FILES['item_thumbnail']['tmp_name'];
			$_FILES['userfile']['error']    = isset($_FILES['item_thumbnail']['error']) ? $_FILES['item_thumbnail']['error'] : '';
			$_FILES['userfile']['size'] = $_FILES['item_thumbnail']['size'];
			if (!$this->upload->do_upload()) :
				$this->load->view('Employee/add_employee', ['employees'=>$employeesList, 'territories'=>$this->tm->getAllTerritories(), 'item_thumbnail_error'=>$this->upload->display_errors()]);
			else :
				$file_data = $this->upload->data();
				$item_thumbnail = $config['upload_path'].$file_data['file_name'];
			endif;
		endif;
		$itemData['item_thumbnail'] = $item_thumbnail;

		$item_images = '';
		if (isset($_FILES['item_images'])) {
			$_FILES['item_images']['name'] = array_filter($_FILES['item_images']['name']);
		}

		if(isset($_FILES['item_images']) && $_FILES['item_images']['name'] != '')
		{
			if(count(array_filter($_FILES['item_images']['name']))) :
				$imagesUploadError = array();
				for ($i = 0; $i < count($_FILES['item_images']['name']); $i++) :
					$_FILES['userfile']['name'] = time().'-'.trim($_FILES['item_images']['name'][$i]);
					$_FILES['userfile']['type'] = $_FILES['item_images']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $_FILES['item_images']['tmp_name'][$i];
					$_FILES['userfile']['error']    = $_FILES['item_images']['error'][$i];
					$_FILES['userfile']['size'] = $_FILES['item_images']['size'][$i];
					if (!$this->upload->do_upload()) :
						$imagesUploadError[] = array('item_images'=>$this->upload->display_errors());
						continue;
					else :
						$file_data = $this->upload->data();
						if ($item_images == '') :
							$item_images = $config['upload_path'].$file_data['file_name'];
						else:
							$item_images .= ','.$config['upload_path'].$file_data['file_name'];
						endif;
					endif;
				endfor;
				if (sizeof($imagesUploadError)) {
					return $this->load->view('Inventory/UpdateInventory', [ 'UnitTypes' => $this->im->GetUnitTypes(), 'item' => $this->im->get_single_item_details($pref_id), 'MainCategories' => $this->cm->GetMainCategories(), 'image_upload_error' => implode(",", $imagesUploadError) ] );
				}
			endif;
		}
		$itemData['item_image'] = $item_images;

		$inventoryPreferences = array();
		$parentChildData = array();
		for ($i=0; $i < $itemData['totalInventoryAdded']; $i++) : 
			if (!isset($itemData['unit_id_'.$i])) {
				continue;
			}
			$inventoryPreferences[] = array("item_id"=>$mainItemId, "unit_id"=>$itemData['unit_id_'.$i], "item_barcode"=>$itemData['item_barcode_'.$i], "item_quantity"=>$itemData['item_quantity_'.$i], "item_warehouse_price"=>$itemData['item_warehouse_price_'.$i], "item_trade_price"=>$itemData['item_trade_price_'.$i], "item_retail_price"=>$itemData['item_retail_price_'.$i], "sub_category_id"=>$itemData['sub_category_id_0'], "item_description"=>$itemData['item_description_'.$i], "item_thumbnail"=>$itemData['item_thumbnail'], "item_image"=>$itemData['item_image']);
			if (isset($itemData["child_item_".$i]) && $itemData['child_item_'.$i] != 0 && $itemData['child_item_'.$i] != "0") {
				$parentChildData[] = array('parent_item_unit_id'=>$itemData['unit_id_'.$i], 'parent_item_main_item_id'=>$mainItemId, 'child_item_unit_id'=>$itemData['child_item_'.$i], 'child_item_quantity'=>$itemData['child_item_quantity_'.$i]);
			}
		endfor;

		$status = $this->im->AddInventoryPreferences($inventoryPreferences);
		if ($status) :
			$status = $this->im->AddParentChildDataWithAddInventory($parentChildData);
			if ($status) :
				$this->session->set_flashdata("inventory_added", "Inventory has been added successfully");
			else:
				$this->session->set_flashdata("inventory_add_failed", "Unable to add the sub inventory");
			endif;
		else:
			$this->session->set_flashdata("inventory_add_failed", "Unable to add the preferences");
		endif;
		return redirect('Inventory/ListInventory');
	}

	public function UpdateInventoryOps($pref_id){

		$itemData = $this->input->post();

		$existingImgs = '';
		$existingThumb = $this->input->post('existing_thumbnail');
		$config['upload_path'] = './assets/uploads/inventory/';
		$config['allowed_types'] = 'jpg|bmp|png|jpeg';
		$config['max_size'] = 'jpg|bmp|png|jpeg';
		$this->load->helper('file');
		$this->load->library('upload', $config);

		if ($this->input->post('thumb_deleted')) :
			if(file_exists(str_replace($this->config->config['base_url'], './', $this->input->post("thumb_deleted")))) :
				unlink(str_replace($this->config->config['base_url'], './', $this->input->post("thumb_deleted")));
			endif;
			$itemData['item_thumbnail'] = '';
		endif;

		if ($this->input->post('images_deleted')) :
			$newImages = '';
			$existingImgs = explode(',', $this->input->post('existing_images'));
			$imagesToDelete = explode(",", str_replace($this->config->config['base_url'], './', $this->input->post("images_deleted")));
			$imagesToDelete = array_map('trim', $imagesToDelete);
			for ($i=0; $i < sizeof($imagesToDelete); $i++) :
				if (in_array($imagesToDelete[$i], $existingImgs)) :
					$key = array_search($imagesToDelete[$i],$existingImgs);
					if($key!==false) :
						unset($existingImgs[$key]);
						if(file_exists($imagesToDelete[$i])) :
							unlink($imagesToDelete[$i]);
						endif;
					endif;
				endif;
			endfor;
			$existingImgs = implode(",",$existingImgs);
			$itemData['item_image'] = $existingImgs;
		endif;

		$this->form_validation->set_rules('item_sku', 'Item Sku', 'required|max_length[20]|trim');
		$this->form_validation->set_rules('item_name', 'Item Name', 'required|max_length[200]');
		$this->form_validation->set_rules('unit_id', 'Unit', 'required');
		$this->form_validation->set_rules('item_quantity', 'Item Quantity', 'required|max_length[50]|greater_than[0]');
		$this->form_validation->set_rules('item_warehouse_price', 'Item Cost Price', 'required|max_length[11]|greater_than[0]|numeric');
		$this->form_validation->set_rules('item_retail_price', 'Item Retail Price', 'required|max_length[11]|greater_than[0]|numeric');
		$this->form_validation->set_rules('item_trade_price', 'Item Trade Price', 'required|max_length[11]|greater_than[0]|numeric');
		$this->form_validation->set_rules('item_description', 'Item Description', 'max_length[1000]');
		$this->form_validation->set_rules('sub_category_id', 'Sub Category', 'required');

		if ($this->form_validation->run()) :

			if (isset($_FILES['item_images'])) {
				$_FILES['item_images']['name'] = array_filter($_FILES['item_images']['name']);
			}

			if(isset($_FILES['item_images']) && $_FILES['item_images']['name'] != '')
			{
				if(count(array_filter($_FILES['item_images']['name']))) :

					$imagesUploadError = array();
					if ($existingImgs == '') {
						$existingImgs = $this->input->post('existing_images');
					}
					for ($i = 0; $i < count($_FILES['item_images']['name']); $i++) :
						$_FILES['userfile']['name'] = time().'-'.trim($_FILES['item_images']['name'][$i]);
						$_FILES['userfile']['type'] = $_FILES['item_images']['type'][$i];
						$_FILES['userfile']['tmp_name'] = $_FILES['item_images']['tmp_name'][$i];
						$_FILES['userfile']['error']    = $_FILES['item_images']['error'][$i];
						$_FILES['userfile']['size'] = $_FILES['item_images']['size'][$i];
						if (!$this->upload->do_upload()) :
							$imagesUploadError[] = array('item_images'=>$this->upload->display_errors());
							continue;
						else :
							$file_data = $this->upload->data();
							if ($existingImgs == '') :
								$existingImgs = $config['upload_path'].$file_data['file_name'];
							else:
								$existingImgs .= ','.$config['upload_path'].$file_data['file_name'];
							endif;
						endif;
					endfor;

					$itemData['item_image'] = $existingImgs;
					if (sizeof($imagesUploadError)) :
						return $this->load->view('Inventory/UpdateInventory', [ 'UnitTypes' => $this->im->GetUnitTypes(), 'item' => $this->im->get_single_item_details($pref_id), 'MainCategories' => $this->cm->GetMainCategories(), 'image_upload_error' => implode(",", $imagesUploadError) ] );
					endif;
				else:
					if ($existingImgs == '') {
						if (!isset($itemData['images_deleted']) || $itemData['images_deleted'] == '') {
							$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
							$hostUrl = $protocol.'://'.$_SERVER['HTTP_HOST'];
							$existingImgs = explode(',', $this->input->post('existing_images'));
							if (is_array($existingImgs)) {
								$itemData['item_image'] = implode(",", str_replace($hostUrl, './', $existingImgs));
							}else{
								$itemData['item_image'] = $existingImgs;
							}	
						}
					}
				endif;
			}else{
				if ($existingImgs == '') {
					if (!isset($itemData['images_deleted']) || $itemData['images_deleted'] == '') {
						$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
						$hostUrl = $protocol.'://'.$_SERVER['HTTP_HOST'];
						$existingImgs = explode(',', $this->input->post('existing_images'));
						if (is_array($existingImgs)) {
							$itemData['item_image'] = implode(",", str_replace($hostUrl, './', $existingImgs));
						}else{
							$itemData['item_image'] = $existingImgs;
						}	
					}
				}
			}

			if(isset($_FILES['item_thumbnail']) && $_FILES['item_thumbnail']['name'] != '')
			{
				$_FILES['userfile']['name'] = time().'-'.trim($_FILES['item_thumbnail']['name']);
				$_FILES['userfile']['type'] = $_FILES['item_thumbnail']['type'];
				$_FILES['userfile']['tmp_name'] = $_FILES['item_thumbnail']['tmp_name'];
				$_FILES['userfile']['error']    = $_FILES['item_thumbnail']['error'];
				$_FILES['userfile']['size'] = $_FILES['item_thumbnail']['size'];
				if (!$this->upload->do_upload()) :
					$item_thumbnail_error = array('UnitTypes' => $this->im->GetUnitTypes(), 'item' => $this->im->get_single_item_details($pref_id), 'SubCategories' => $this->cm->GetSubCategories(), 'item_thumbnail_error'=>$this->upload->display_errors());
					return $this->load->view('Inventory/UpdateInventory', [ 'UnitTypes' => $this->im->GetUnitTypes(), 'item' => $this->im->get_single_item_details($pref_id), 'MainCategories' => $this->cm->GetMainCategories(), 'image_upload_error' => implode(",", $item_thumbnail_error) ] );
				else :
					$file_data = $this->upload->data();
					$item_thumbnail = $config['upload_path'].$file_data['file_name'];
					$itemData['item_thumbnail'] = $item_thumbnail;
				endif;
			}else{
				if (!isset($itemData['thumb_deleted']) || $itemData['thumb_deleted'] == '') {
					$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
					$hostUrl = $protocol.'://'.$_SERVER['HTTP_HOST'];
					$itemData['item_thumbnail'] = $this->input->post('existing_thumbnail');
				}
			}

			unset($itemData['images_deleted']);
			unset($itemData['thumb_deleted']);
			unset($itemData['existing_images']);
			unset($itemData['existing_thumbnail']);
			unset($itemData['subCatDataForAjax']);
			unset($itemData['subCatSelected']);
			unset($itemData['totalInventoryAdded']);

			$response = $this->im->update_inventory($pref_id, $itemData);
			if ($response) :
				if ($response == "exist" && $response != 1 && $response != 'sku_exist') :
					return $this->load->view('Inventory/UpdateInventory', [ 'UnitTypes' => $this->im->GetUnitTypes(), 'item' => $this->im->get_single_item_details($pref_id), 'MainCategories' => $this->cm->GetMainCategories(), 'PropExist'=> 'This item already has this Packaging added in the inventory' ] );
				elseif ($response == "sku_exist" && $response != 1 && $response != 'exist') :
					return $this->load->view('Inventory/UpdateInventory', [ 'UnitTypes' => $this->im->GetUnitTypes(), 'item' => $this->im->get_single_item_details($pref_id), 'MainCategories' => $this->cm->GetMainCategories(), 'skuExist'=> 'Item sku already exist' ] );
				else:
					if ($response) :
						$this->session->set_flashdata("inventory_updated", "Inventory has been updated successfully");
						return redirect('Inventory/ListInventory');
					else:
						$this->session->set_flashdata("inventory_update_failed", "Unable to update the inventory");
						return redirect('Inventory/ListInventory');
					endif;
				endif;
			else:
				return $response;
			endif;
		else:
			return $this->load->view('Inventory/UpdateInventory', [ 'UnitTypes' => $this->im->GetUnitTypes(), 'item' => $this->im->get_single_item_details($pref_id), 'MainCategories' => $this->cm->GetMainCategories() ] );
		endif;

	}

}

?>
