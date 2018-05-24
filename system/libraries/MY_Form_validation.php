<?php

class CI_MY_Form_validation extends CI_Form_validation {

	public function __construct()
	{
		$this->CI =& get_instance();
	}    

	public function update_is_unique($str, $field)
	{
		sscanf($field, '%[^.].%[^.].%[^.]', $table, $field, $id);
		return $this->db->limit(1)->get_where($table, array($field => $str, 'id !=' => $id))->num_rows() === 0;
	}
}

?>