<?php

class CategoryModel extends CI_Model{

	public function GetMainCategories(){
		return $this->db->get("main_categories")->result();
	}

	public function GetSubCategories(){
		return $this->db->select('sub_category_id, sub_category_name, (SELECT main_category_name from main_categories where main_category_id = sc.main_category_id) as main_category_name')->get("sub_categories sc")->result();
	}

	public function GetThisMainCategory($catId){
		return $this->db->where('main_category_id', $catId)->get("main_categories")->row();
	}

	public function GetThisSubCategory($catId){
		return $this->db->where('sub_category_id', $catId)->get("sub_categories")->row();
	}

	public function GetSubCatForMain($catId){
		return $this->db->select('sub_category_id, sub_category_name')->where('main_category_id', $catId)->get("sub_categories sc")->result();
	}

	public function AddMainCategory($catData){
		return $this->db->insert('main_categories', $catData);
	}

	public function AddSubCategory($catData){
		return $this->db->insert('sub_categories', $catData);
	}

	public function DeActivateMainCateogry($catId){
		return $this->db
		->where('main_category_id',$catId)	
		->update('main_categories', array('is_active'=>0));
	}

	public function ActivateMainCateogry($catId){
		return $this->db
		->where('main_category_id',$catId)	
		->update('main_categories', array('is_active'=>1));
	}

	public function UpdateMainCategory($catId, $catData){
		return $this->db
		->where('main_category_id',$catId)	
		->update('main_categories', $catData);
	}

	public function UpdateSubCategory($catId, $catData){
		return $this->db
		->where('sub_category_id',$catId)	
		->update('sub_categories', $catData);
	}

	public function DeleteMainCategory($catId){
		return $this->db->delete('main_categories', array('main_category_id' => $catId)); 
	}

	public function DeleteSubCategory($catId){
		return $this->db->delete('sub_categories', array('sub_category_id' => $catId)); 
	}

}

?>