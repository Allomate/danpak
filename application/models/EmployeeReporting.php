<?php

class EmployeeReporting extends CI_Model{

	public function GetReporting(){
		return $this->db->select('employee_id, employee_username, (SELECT GROUP_CONCAT(employee_username) from employees_info ei where ei.reporting_to = einf.employee_id) as reportees')->order_by("reporting_to", "asc")->get("employees_info einf")->result();
	}

}

?>