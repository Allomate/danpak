<?php

class Inventory extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('InventoryModel', 'im');
	}
	
	public function ListInventory(){
		return $this->load->view('Inventory/ListInventory', [ 'Inventory' => $this->im->($item_id) ]);
	}
	
	public function UpdateInventory($item_id){
		return $this->load->view('Inventory/UpdateInventory', [ 'item' => $this->im->get_single_item_details($item_id) ]);
	}

	public function UpdateInventoryOps($item_id){

		$itemData = $this->input->post();
		$existingImgs = '';
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

		unset($itemData['thumb_deleted']);

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

		unset($itemData['images_deleted']);
		unset($itemData['existing_images']);

		$this->form_validation->set_rules('item_sku', 'Item Sku', 'max_length[20]|trim');
		$this->form_validation->set_rules('item_barcode', 'Item Barcode', 'max_length[20]|trim');
		$this->form_validation->set_rules('item_name', 'Item Name', 'required|max_length[100]');
		$this->form_validation->set_rules('item_brand', 'Item Brand', 'required|max_length[100]');
		$this->form_validation->set_rules('item_size', 'Item Size', 'required|max_length[50]');
		$this->form_validation->set_rules('item_expiry', 'Item Expiry', 'required');
		$this->form_validation->set_rules('item_purchased_price', 'Item Purchase Price', 'required|max_length[11]|trim');
		$this->form_validation->set_rules('item_sale_price', 'Item Sale Price', 'max_length[11]|trim');
		$this->form_validation->set_rules('item_description', 'Item Description', 'max_length[500]');
		if ($this->form_validation->run()) :
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
							if ($existingImgs == '') :
								$existingImgs = $config['upload_path'].$file_data['file_name'];
							else:
								$existingImgs .= ','.$config['upload_path'].$file_data['file_name'];
							endif;
						endif;
					endfor;
					$itemData['item_image'] = $existingImgs;
					if (sizeof($imagesUploadError)) {
						$this->load->view('Inventory/UpdateInventory', [ 'image_upload_error' => implode(",", $imagesUploadError) ] );
					}
				endif;
			}

			if(isset($_FILES['item_thumbnail']) && $_FILES['item_thumbnail']['name'] != '')
			{
				$_FILES['userfile']['name'] = time().'-'.trim($_FILES['item_thumbnail']['name']);
				$_FILES['userfile']['type'] = $_FILES['item_thumbnail']['type'];
				$_FILES['userfile']['tmp_name'] = $_FILES['item_thumbnail']['tmp_name'];
				$_FILES['userfile']['error']    = $_FILES['item_thumbnail']['error'];
				$_FILES['userfile']['size'] = $_FILES['item_thumbnail']['size'];
				if (!$this->upload->do_upload()) :
					$item_thumbnail_error = array('item_thumbnail_error'=>$this->upload->display_errors());
					$this->load->view('Inventory/UpdateInventory', $item_thumbnail_error);
				else :
					$file_data = $this->upload->data();
					$item_thumbnail = $config['upload_path'].$file_data['file_name'];
					$itemData['item_thumbnail'] = $item_thumbnail;
				endif;
			}

			if ($this->im->update_inventory($item_id, $itemData)) :
				$this->session->set_flashdata("inventory_update_successfull", "Inventory has been updated successfully");
				return redirect('Inventory/ListInventory');
			else:
				$this->session->set_flashdata("inventory_update_failed", "Unable to update the inventory");
				return redirect('Inventory/ListInventory');
			endif;
		else:
			return $this->load->view('Inventory/UpdateInventory', [ 'item' => $this->im->get_single_item_details($item_id) ]);
		endif;

	}
	
	public function DeleteInventory($item_id){
		$itemDetails = $this->im->get_single_item_details($item_id);

		if ($itemDetails->item_thumbnail != '') :
			if (file_exists($itemDetails->item_thumbnail)) :
				unlink($itemDetails->item_thumbnail);
			endif;
		endif;

		if ($itemDetails->item_image != '') :
			if(strpos( $itemDetails->item_image , ',' ) !== false) :
				$images = explode(",", $itemDetails->item_image);
				foreach ( $images as $image ) :
					if (file_exists($image)) :
						unlink($image);
					endif;
				endforeach;
			else:
				if (file_exists($itemDetails->item_image)) :
					unlink($itemDetails->item_image);
				endif;
			endif;
		endif;

		if ($this->im->delete_inventory($item_id)) :
			$this->session->set_flashdata('success_deleted', 'Item has been deleted successfully');
			return redirect('Inventory/ListInventory');
		else:
			$this->session->set_flashdata('delete_failed', 'Unable to delete the item');
			return redirect('Inventory/ListInventory');
		endif;
	}
	
	public function AddInventory(){
		return $this->load->view('Inventory/AddInventory');
	}

	public function AddInventoryOps(){
		$config['upload_path'] = './assets/uploads/inventory/';
		$config['allowed_types'] = 'jpg|bmp|png|jpeg';
		$config['max_size'] = 'jpg|bmp|png|jpeg';
		$this->load->helper('file');
		$this->load->library('upload', $config);
		$item_thumbnail = '';
		$item_images = '';

		$this->form_validation->set_rules('item_sku', 'Item Sku', 'max_length[20]|trim');
		$this->form_validation->set_rules('item_barcode', 'Item Barcode', 'max_length[20]|trim');
		$this->form_validation->set_rules('item_name', 'Item Name', 'required|max_length[100]');
		$this->form_validation->set_rules('item_brand', 'Item Brand', 'required|max_length[100]');
		$this->form_validation->set_rules('item_size', 'Item Size', 'required|max_length[50]');
		$this->form_validation->set_rules('item_expiry', 'Item Expiry', 'required');
		$this->form_validation->set_rules('item_purchased_price', 'Item Purchase Price', 'required|max_length[11]|trim');
		$this->form_validation->set_rules('item_sale_price', 'Item Sale Price', 'max_length[11]|trim');
		$this->form_validation->set_rules('item_description', 'Item Description', 'max_length[500]');
		if ($this->form_validation->run()) :

			if(isset($_FILES['item_thumbnail']) && $_FILES['item_thumbnail']['name'] != '')
			{
				$_FILES['userfile']['name'] = time().'-'.trim($_FILES['item_thumbnail']['name']);
				$_FILES['userfile']['type'] = $_FILES['item_thumbnail']['type'];
				$_FILES['userfile']['tmp_name'] = $_FILES['item_thumbnail']['tmp_name'];
				$_FILES['userfile']['error']    = $_FILES['item_thumbnail']['error'];
				$_FILES['userfile']['size'] = $_FILES['item_thumbnail']['size'];
				if (!$this->upload->do_upload()) :
					$item_thumbnail_error = array('item_thumbnail_error'=>$this->upload->display_errors());
					$this->load->view('Inventory/AddInventory', $item_thumbnail_error);
				else :
					$file_data = $this->upload->data();
					$item_thumbnail = $config['upload_path'].$file_data['file_name'];
				endif;
			}

			if(isset($_FILES['item_images']) && $_FILES['item_images']['name'] != '')
			{
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
					$this->load->view('Inventory/AddInventory', [ 'image_upload_error' => implode(",", $imagesUploadError) ] );
				}
			}

			$itemData = $this->input->post();
			if ($item_thumbnail != '') : 
				$itemData['item_thumbnail'] = $item_thumbnail;
			endif;
			if ($item_images != '') : 
				$itemData['item_image'] = $item_images;
			endif;
			if ($this->im->add_inventory($itemData)) :
				$this->session->set_flashdata("inventory_add_successfull", "Inventory has been added successfully");
				return redirect('Inventory/ListInventory');
			else:
				$this->session->set_flashdata("inventory_add_failed", "Unable to add the inventory");
				return redirect('Inventory/ListInventory');
			endif;
		else:
			$this->load->view('Inventory/AddInventory');
		endif;
	}

}

?>