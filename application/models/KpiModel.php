<?php

class KpiModel extends CI_Model
{

    public function get_employees_list()
    {
        return $this->db->select('employee_id, employee_username, employee_first_name, employee_last_name, (SELECT territory_name from territory_management where id = ei.territory_id) as territory, (SELECT area_name from area_management where id = (SELECT area_id from territory_management where id = ei.territory_id)) as area, (SELECT region_name from regions_info where id = (SELECT region_id from area_management where id = (SELECT area_id from territory_management where id = ei.territory_id))) as region, (SELECT min(active) from kpi_management where YEAR(created_at) = "'.date("Y").'" and created_for = ei.employee_username) as kpi_status')->get("employees_info ei")->result();
    }

    public function get_this_employee_info($employee_username)
    {
        return $this->db->select('employee_designation, CONCAT(employee_first_name," ",employee_last_name) as employee_name, employee_phone, (SELECT territory_name from territory_management where id = ei.territory_id) as territory, (SELECT area_name from area_management where id = (SELECT area_id from territory_management where id = ei.territory_id)) as area, (SELECT region_name from regions_info where id = (SELECT region_id from area_management where id = (SELECT area_id from territory_management where id = ei.territory_id))) as region')->where('employee_username', $employee_username)->get("employees_info ei")->row();
    }

    public function get_this_employee_kpi($employee_username)
    {
        return $this->db->select('`id`, `kpi_type`, (SELECT item_id from inventory_preferences where pref_id = kpi.pref_id) as item_id, `pref_id`, `unit_id`, `target`, `eligibility`, `weightage`, `incentive`, `criteria`, `criteria_parameter`, `created_by`, `created_for`, `created_at`')->where(['created_for' => $employee_username, 'YEAR(created_at)' => date("Y")])->get("kpi_management kpi")->result();
    }

    public function save_kpi($data)
    {
        return $this->db->insert_batch('kpi_management', $data);
    }

    public function update_kpi($data, $employee_username)
    {
        if ($this->db->delete('kpi_management', array('created_for' => $employee_username, 'YEAR(created_at)' => date("Y")))) {
            return $this->db->insert_batch('kpi_management', $data);
        }
        return false;
    }

    public function deactivate_kpi($employee_username)
    {
        return $this->db->where(['created_for' => $employee_username, 'YEAR(created_at)' => date('Y')])->update('kpi_management', array('active'=>0));
    }


    public function activate_kpi($employee_username)
    {
        return $this->db->where(['created_for' => $employee_username, 'YEAR(created_at)' => date('Y')])->update('kpi_management', array('active'=>1));
    }

}
