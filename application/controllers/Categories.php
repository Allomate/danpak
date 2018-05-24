<?php

class Categories extends WebAuth_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('CategoryModel', 'cm');
	}

	public function ListMainCategories(){
		return $this->load->view('Categories/ListMainCategories', [ 'MainCategories' => $this->cm->GetMainCategories() ]);
	}

	public function ListSubCategories(){
		return $this->load->view('Categories/ListSubCategories', [ 'SubCategories' => $this->cm->GetSubCategories() ]);
	}
	
	public function AddMainCategory(){
		return $this->load->view('Categories/AddMainCategory');
	}
	
	public function AddSubCategory(){
		return $this->load->view('Categories/AddSubCategory', [ 'MainCategories' => $this->cm->GetMainCategories() ]);
	}
	
	public function UpdateMainCategory($catId){
		return $this->load->view('Categories/UpdateMainCategory', [ 'MainCategory' => $this->cm->GetThisMainCategory($catId) ]);
	}
	
	public function UpdateSubCategory($catId){
		return $this->load->view('Categories/UpdateSubCategory', [ 'MainCategories' => $this->cm->GetMainCategories(), 'SubCategory' => $this->cm->GetThisSubCategory($catId) ]);
	}
	
	public function AddMainCategoryOps()
	{
		$this->form_validation->set_rules('main_category_name', 'Category Name', 'required|max_length[100]');
		if ($this->form_validation->run()) {
			$categoryData = $this->input->post();
			if ($this->cm->AddMainCategory($categoryData)) :
				$this->session->set_flashdata("main_category_added", "Category has been added successfully");
			else:
				$this->session->set_flashdata("main_category_add_failed", "Failed to add the category");
			endif;
			return redirect('Categories/ListMainCategories');
		}else{
			return $this->load->view('Categories/AddMainCategory');
		}
	}
	
	public function AddSubCategoryOps()
	{
		$this->form_validation->set_rules('sub_category_name', 'Category Name', 'required|max_length[100]');
		$this->form_validation->set_rules('main_category_id', 'Main Category', 'required');
		if ($this->form_validation->run()) {
			$categoryData = $this->input->post();
			if ($this->cm->AddSubCategory($categoryData)) :
				$this->session->set_flashdata("sub_category_added", "Category has been added successfully");
			else:
				$this->session->set_flashdata("sub_category_add_failed", "Failed to add the category");
			endif;
			return redirect('Categories/ListSubCategories');
		}else{
			return $this->load->view('Categories/AddSubCategory');
		}
	}

	public function DeActivateMainCategory($catId){
		if ($this->cm->DeActivateMainCateogry($catId)) :
			$this->session->set_flashdata('main_category_deactivated', 'Category has been deactivated');
		else:
			$this->session->set_flashdata('main_category_deactivate_failed', 'Unable to deactivate the category');
		endif;
		return redirect('Categories/ListMainCategories');
	}
	
	public function UpdateSubCategoryOps($catId)
	{
		$this->form_validation->set_rules('sub_category_name', 'Category Name', 'required|max_length[100]');
		$this->form_validation->set_rules('main_category_id', 'Main Category', 'required');
		if ($this->form_validation->run()) {
			$categoryData = $this->input->post();
			if ($this->cm->UpdateSubCategory($catId, $categoryData)) :
				$this->session->set_flashdata("sub_category_updated", "Category has been updated successfully");
			else:
				$this->session->set_flashdata("sub_category_update_failed", "Failed to update the category");
			endif;
			return redirect('Categories/ListSubCategories');
		}else{
			return $this->load->view('Categories/UpdateSubCategory');
		}
	}

	public function ActivateMainCategory($catId){
		if ($this->cm->ActivateMainCateogry($catId)) :
			$this->session->set_flashdata('main_category_activated', 'Category has been activated');
		else:
			$this->session->set_flashdata('main_category_activate_failed', 'Unable to activate the category');
		endif;
		return redirect('Categories/ListMainCategories');
	}

	public function UpdateMainCategoryOps($catId)
	{
		$this->form_validation->set_rules('main_category_name', 'Category Name', 'required|max_length[100]');
		if ($this->form_validation->run()) {
			$categoryData = $this->input->post();
			if ($this->cm->UpdateMainCategory($catId, $categoryData)) :
				$this->session->set_flashdata("main_category_updated", "Category has been updated successfully");
			else:
				$this->session->set_flashdata("main_category_update_failed", "Failed to update the category");
			endif;
			return redirect('Categories/ListMainCategories');
		}else{
			return $this->load->view('Categories/UpdateMainCategory');
		}
	}

	public function DeleteMainCategory($catId)
	{
		if ($this->cm->DeleteMainCategory($catId)) :
			$this->session->set_flashdata('main_category_deleted', 'Category has been deleted successfully');
		else:
			$this->session->set_flashdata('main_category_delete_failed', 'Unable to delete the category');
		endif;
		return redirect('Categories/ListMainCategories');
	}

	public function DeleteSubCategory($catId)
	{
		if ($this->cm->DeleteSubCategory($catId)) :
			$this->session->set_flashdata('sub_category_deleted', 'Category has been deleted successfully');
		else:
			$this->session->set_flashdata('sub_category_delete_failed', 'Unable to delete the category');
		endif;
		return redirect('Categories/ListSubCategories');
	}
}