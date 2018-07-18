<?php

class KpiModel extends CI_Model
{

    public function get_employees_list()
    {
        $employee_id = $this->db->select('admin_id')->where('session', $this->session->userdata('session'))->get('admin_session')->row()->admin_id;
        if($this->db->select('is_admin')->where('employee_id', $employee_id)->get('employees_info')->row()->is_admin)
        return $this->db->select('employee_id, employee_username, employee_first_name, employee_last_name, (SELECT territory_name from territory_management where id = ei.territory_id) as territory, (SELECT area_name from area_management where id = (SELECT area_id from territory_management where id = ei.territory_id)) as area, (SELECT region_name from regions_info where id = (SELECT region_id from area_management where id = (SELECT area_id from territory_management where id = ei.territory_id))) as region, (SELECT min(active) from kpi_management where YEAR(created_at) = "' . date("Y") . '" and created_for = ei.employee_username) as kpi_status, (SELECT count(*) from kpi_management where created_for = ei.employee_username and YEAR(created_at) = "'.date("Y").'" group by created_for ) as total_kpis')->get("employees_info ei")->result();

        return $this->db->select('employee_id, employee_username, employee_first_name, employee_last_name, (SELECT territory_name from territory_management where id = ei.territory_id) as territory, (SELECT area_name from area_management where id = (SELECT area_id from territory_management where id = ei.territory_id)) as area, (SELECT region_name from regions_info where id = (SELECT region_id from area_management where id = (SELECT area_id from territory_management where id = ei.territory_id))) as region, (SELECT min(active) from kpi_management where YEAR(created_at) = "' . date("Y") . '" and created_for = ei.employee_username) as kpi_status, (SELECT count(*) from kpi_management where created_for = ei.employee_username and YEAR(created_at) = "'.date("Y").'" group by created_for ) as total_kpis')->where('reporting_to', $employee_id)->get("employees_info ei")->result();
    }

    public function get_this_employee_info($employee_username)
    {
        return $this->db->select('employee_designation, CONCAT(employee_first_name," ",employee_last_name) as employee_name, employee_phone, (SELECT territory_name from territory_management where id = ei.territory_id) as territory, (SELECT area_name from area_management where id = (SELECT area_id from territory_management where id = ei.territory_id)) as area, (SELECT region_name from regions_info where id = (SELECT region_id from area_management where id = (SELECT area_id from territory_management where id = ei.territory_id))) as region')->where('employee_username', $employee_username)->get("employees_info ei")->row();
    }

    public function getDetails($employee_username){
        $validateEvaluation = $this->db->select("evaluation_from_employees")->where('created_for', $employee_username)->get("kpi_management")->row();
        if($validateEvaluation){
            if($validateEvaluation->evaluation_from_employees){
                $kpis = $this->db->select('id, criteria, criteria_parameter, kpi_type, pref_id, unit_id, (SELECT item_name from inventory_items where item_id = (SELECT item_id from inventory_preferences where pref_id = kpi.pref_id )) as item_name, COALESCE((SELECT unit_name from inventory_types_units where unit_id = (SELECT unit_id from inventory_preferences where pref_id = kpi.pref_id )), (SELECT unit_name from inventory_types_units where unit_id = kpi.unit_id)) as unit_name, target, eligibility, weightage, evaluation_from_employees, incentive, active')->where('created_for', $employee_username)->get('kpi_management kpi')->result();

                foreach($kpis as $kpi) :
                    if($kpi->criteria == "monthly"):
                        if($kpi->kpi_type == "revenue") :
                            $kpi->progress = $this->db->query(' (SELECT SUM(final_price) as revenue from order_contents where find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where find_in_set(employee_id, (SELECT GROUP_CONCAT(employee_id) from employees_info where find_in_set(employee_username, ((SELECT GROUP_CONCAT(employee_username) from employees_info where reporting_to = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'")))))) and LOWER(MONTHNAME(created_at)) = "'.$kpi->criteria_parameter.'")) )')->row()->revenue;
                        endif;
                        if($kpi->kpi_type == "product") :
                            $kpi->progress = $this->db->query(' (SELECT SUM(item_quantity_booker) as revenue from order_contents where pref_id = '.$kpi->pref_id.' and find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where find_in_set(employee_id, (SELECT GROUP_CONCAT(employee_id) from employees_info where find_in_set(employee_username, ((SELECT GROUP_CONCAT(employee_username) from employees_info where reporting_to = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'")))))) and LOWER(MONTHNAME(created_at)) = "'.$kpi->criteria_parameter.'")) )')->row()->revenue;
                        endif;
                        if($kpi->kpi_type == "quantity") :
                            $kpi->progress = $this->db->query(' (SELECT SUM(item_quantity_booker) as revenue from order_contents where find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where find_in_set(employee_id, (SELECT GROUP_CONCAT(employee_id) from employees_info where find_in_set(employee_username, ((SELECT GROUP_CONCAT(employee_username) from employees_info where reporting_to = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'")))))) and LOWER(MONTHNAME(created_at)) = "'.$kpi->criteria_parameter.'")) and find_in_set(pref_id, (SELECT GROUP_CONCAT(pref_id) from inventory_preferences where unit_id = '.$kpi->unit_id.' )))')->row()->revenue;
                        endif;
                    else:
                        if($kpi->kpi_type == "revenue") :
                            if($kpi->criteria_parameter == "q1") :
                                $kpi->progress = $this->db->query(' (SELECT SUM(final_price) as revenue from order_contents where find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where find_in_set(employee_id, (SELECT GROUP_CONCAT(employee_id) from employees_info where find_in_set(employee_username, ((SELECT GROUP_CONCAT(employee_username) from employees_info where reporting_to = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'")))))) and MONTH(created_at) IN (1,2,3) )) )')->row()->revenue;
                            elseif($kpi->criteria_parameter == "q2") :
                                $kpi->progress = $this->db->query(' (SELECT SUM(final_price) as revenue from order_contents where find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where find_in_set(employee_id, (SELECT GROUP_CONCAT(employee_id) from employees_info where find_in_set(employee_username, ((SELECT GROUP_CONCAT(employee_username) from employees_info where reporting_to = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'")))))) and MONTH(created_at) IN (4,5,6) )) )')->row()->revenue;
                            elseif($kpi->criteria_parameter == "q3") :
                                $kpi->progress = $this->db->query(' (SELECT SUM(final_price) as revenue from order_contents where find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where find_in_set(employee_id, (SELECT GROUP_CONCAT(employee_id) from employees_info where find_in_set(employee_username, ((SELECT GROUP_CONCAT(employee_username) from employees_info where reporting_to = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'")))))) and MONTH(created_at) IN (7,8,9) )) )')->row()->revenue;
                            else :
                                $kpi->progress = $this->db->query(' (SELECT SUM(final_price) as revenue from order_contents where find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where find_in_set(employee_id, (SELECT GROUP_CONCAT(employee_id) from employees_info where find_in_set(employee_username, ((SELECT GROUP_CONCAT(employee_username) from employees_info where reporting_to = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'")))))) and MONTH(created_at) IN (10,11,12) )) )')->row()->revenue;
                            endif;
                        endif;
                        if($kpi->kpi_type == "product") :
                            if($kpi->criteria_parameter == "q1") :
                                $kpi->progress = $this->db->query(' (SELECT SUM(item_quantity_booker) as revenue from order_contents where pref_id = '.$kpi->pref_id.' and find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where find_in_set(employee_id, (SELECT GROUP_CONCAT(employee_id) from employees_info where find_in_set(employee_username, ((SELECT GROUP_CONCAT(employee_username) from employees_info where reporting_to = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'")))))) and MONTH(created_at) IN (1,2,3) )) )')->row()->revenue;
                            elseif($kpi->criteria_parameter == "q2") :
                                $kpi->progress = $this->db->query(' (SELECT SUM(item_quantity_booker) as revenue from order_contents where pref_id = '.$kpi->pref_id.' and find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where find_in_set(employee_id, (SELECT GROUP_CONCAT(employee_id) from employees_info where find_in_set(employee_username, ((SELECT GROUP_CONCAT(employee_username) from employees_info where reporting_to = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'")))))) and MONTH(created_at) IN (4,5,6) )) )')->row()->revenue;
                            elseif($kpi->criteria_parameter == "q3") :
                                $kpi->progress = $this->db->query(' (SELECT SUM(item_quantity_booker) as revenue from order_contents where pref_id = '.$kpi->pref_id.' and find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where find_in_set(employee_id, (SELECT GROUP_CONCAT(employee_id) from employees_info where find_in_set(employee_username, ((SELECT GROUP_CONCAT(employee_username) from employees_info where reporting_to = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'")))))) and MONTH(created_at) IN (7,8,9) )) )')->row()->revenue;
                            else :
                                $kpi->progress = $this->db->query(' (SELECT SUM(item_quantity_booker) as revenue from order_contents where pref_id = '.$kpi->pref_id.' and find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where find_in_set(employee_id, (SELECT GROUP_CONCAT(employee_id) from employees_info where find_in_set(employee_username, ((SELECT GROUP_CONCAT(employee_username) from employees_info where reporting_to = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'")))))) and MONTH(created_at) IN (10,11,12) )) )')->row()->revenue;
                            endif;
                        endif;
                        if($kpi->kpi_type == "quantity") :
                            if($kpi->criteria_parameter == "q1") :
                                $kpi->progress = $this->db->query(' (SELECT SUM(item_quantity_booker) as revenue from order_contents where find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where find_in_set(employee_id, (SELECT GROUP_CONCAT(employee_id) from employees_info where find_in_set(employee_username, ((SELECT GROUP_CONCAT(employee_username) from employees_info where reporting_to = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'")))))) and MONTH(created_at) IN (1,2,3) )) and find_in_set(pref_id, (SELECT GROUP_CONCAT(pref_id) from inventory_preferences where unit_id = '.$kpi->unit_id.' )))')->row()->revenue;
                            elseif($kpi->criteria_parameter == "q2") :
                                $kpi->progress = $this->db->query(' (SELECT SUM(item_quantity_booker) as revenue from order_contents where find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where find_in_set(employee_id, (SELECT GROUP_CONCAT(employee_id) from employees_info where find_in_set(employee_username, ((SELECT GROUP_CONCAT(employee_username) from employees_info where reporting_to = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'")))))) and MONTH(created_at) IN (4,5,6) )) and find_in_set(pref_id, (SELECT GROUP_CONCAT(pref_id) from inventory_preferences where unit_id = '.$kpi->unit_id.' )))')->row()->revenue;
                            elseif($kpi->criteria_parameter == "q3") :
                                $kpi->progress = $this->db->query(' (SELECT SUM(item_quantity_booker) as revenue from order_contents where find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where find_in_set(employee_id, (SELECT GROUP_CONCAT(employee_id) from employees_info where find_in_set(employee_username, ((SELECT GROUP_CONCAT(employee_username) from employees_info where reporting_to = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'")))))) and MONTH(created_at) IN (7,8,9) )) and find_in_set(pref_id, (SELECT GROUP_CONCAT(pref_id) from inventory_preferences where unit_id = '.$kpi->unit_id.' )))')->row()->revenue;
                            else :
                                $kpi->progress = $this->db->query(' (SELECT SUM(item_quantity_booker) as revenue from order_contents where find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where find_in_set(employee_id, (SELECT GROUP_CONCAT(employee_id) from employees_info where find_in_set(employee_username, ((SELECT GROUP_CONCAT(employee_username) from employees_info where reporting_to = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'")))))) and MONTH(created_at) IN (10,11,12) )) and find_in_set(pref_id, (SELECT GROUP_CONCAT(pref_id) from inventory_preferences where unit_id = '.$kpi->unit_id.' )))')->row()->revenue;
                            endif;
                        endif;
                    endif;
                endforeach;
        
                return $kpis;
            }else{
                $kpis = $this->db->select('id, criteria, criteria_parameter, kpi_type, pref_id, unit_id, (SELECT item_name from inventory_items where item_id = (SELECT item_id from inventory_preferences where pref_id = kpi.pref_id )) as item_name, COALESCE((SELECT unit_name from inventory_types_units where unit_id = (SELECT unit_id from inventory_preferences where pref_id = kpi.pref_id )), (SELECT unit_name from inventory_types_units where unit_id = kpi.unit_id)) as unit_name, target, eligibility, weightage, evaluation_from_employees, incentive, active')->where('created_for', $employee_username)->get('kpi_management kpi')->result();

                foreach($kpis as $kpi) :
                    if($kpi->criteria == "monthly"):
                        if($kpi->kpi_type == "revenue") :
                            $kpi->progress = $this->db->query(' (SELECT SUM(final_price) as revenue from order_contents where find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where employee_id = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'" ) and LOWER(MONTHNAME(created_at)) = "'.$kpi->criteria_parameter.'")) )')->row()->revenue;
                        endif;
                        if($kpi->kpi_type == "product") :
                            $kpi->progress = $this->db->query(' (SELECT SUM(item_quantity_booker) as revenue from order_contents where pref_id = '.$kpi->pref_id.' and find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where employee_id = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'" ) and LOWER(MONTHNAME(created_at)) = "'.$kpi->criteria_parameter.'")) )')->row()->revenue;
                        endif;
                        if($kpi->kpi_type == "quantity") :
                            $kpi->progress = $this->db->query(' (SELECT SUM(item_quantity_booker) as revenue from order_contents where find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where employee_id = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'" ) and LOWER(MONTHNAME(created_at)) = "'.$kpi->criteria_parameter.'")) and find_in_set(pref_id, (SELECT GROUP_CONCAT(pref_id) from inventory_preferences where unit_id = '.$kpi->unit_id.' )))')->row()->revenue;
                        endif;
                    else:
                        if($kpi->kpi_type == "revenue") :
                            if($kpi->criteria_parameter == "q1") :
                                $kpi->progress = $this->db->query(' (SELECT SUM(final_price) as revenue from order_contents where find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where employee_id = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'" ) and MONTH(created_at) IN (1,2,3) )) )')->row()->revenue;
                            elseif($kpi->criteria_parameter == "q2") :
                                $kpi->progress = $this->db->query(' (SELECT SUM(final_price) as revenue from order_contents where find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where employee_id = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'" ) and MONTH(created_at) IN (4,5,6) )) )')->row()->revenue;
                            elseif($kpi->criteria_parameter == "q3") :
                                $kpi->progress = $this->db->query(' (SELECT SUM(final_price) as revenue from order_contents where find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where employee_id = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'" ) and MONTH(created_at) IN (7,8,9) )) )')->row()->revenue;
                            else :
                                $kpi->progress = $this->db->query(' (SELECT SUM(final_price) as revenue from order_contents where find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where employee_id = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'" ) and MONTH(created_at) IN (10,11,12) )) )')->row()->revenue;
                            endif;
                        endif;
                        if($kpi->kpi_type == "product") :
                            if($kpi->criteria_parameter == "q1") :
                                $kpi->progress = $this->db->query(' (SELECT SUM(item_quantity_booker) as revenue from order_contents where pref_id = '.$kpi->pref_id.' and find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where employee_id = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'" ) and MONTH(created_at) IN (1,2,3) )) )')->row()->revenue;
                            elseif($kpi->criteria_parameter == "q2") :
                                $kpi->progress = $this->db->query(' (SELECT SUM(item_quantity_booker) as revenue from order_contents where pref_id = '.$kpi->pref_id.' and find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where employee_id = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'" ) and MONTH(created_at) IN (4,5,6) )) )')->row()->revenue;
                            elseif($kpi->criteria_parameter == "q3") :
                                $kpi->progress = $this->db->query(' (SELECT SUM(item_quantity_booker) as revenue from order_contents where pref_id = '.$kpi->pref_id.' and find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where employee_id = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'" ) and MONTH(created_at) IN (7,8,9) )) )')->row()->revenue;
                            else :
                                $kpi->progress = $this->db->query(' (SELECT SUM(item_quantity_booker) as revenue from order_contents where pref_id = '.$kpi->pref_id.' and find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where employee_id = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'" ) and MONTH(created_at) IN (10,11,12) )) )')->row()->revenue;
                            endif;
                        endif;
                        if($kpi->kpi_type == "quantity") :
                            if($kpi->criteria_parameter == "q1") :
                                $kpi->progress = $this->db->query(' (SELECT SUM(item_quantity_booker) as revenue from order_contents where find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where employee_id = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'" ) and MONTH(created_at) IN (1,2,3) )) and find_in_set(pref_id, (SELECT GROUP_CONCAT(pref_id) from inventory_preferences where unit_id = '.$kpi->unit_id.' )))')->row()->revenue;
                            elseif($kpi->criteria_parameter == "q2") :
                                $kpi->progress = $this->db->query(' (SELECT SUM(item_quantity_booker) as revenue from order_contents where find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where employee_id = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'" ) and MONTH(created_at) IN (4,5,6) )) and find_in_set(pref_id, (SELECT GROUP_CONCAT(pref_id) from inventory_preferences where unit_id = '.$kpi->unit_id.' )))')->row()->revenue;
                            elseif($kpi->criteria_parameter == "q3") :
                                $kpi->progress = $this->db->query(' (SELECT SUM(item_quantity_booker) as revenue from order_contents where find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where employee_id = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'" ) and MONTH(created_at) IN (7,8,9) )) and find_in_set(pref_id, (SELECT GROUP_CONCAT(pref_id) from inventory_preferences where unit_id = '.$kpi->unit_id.' )))')->row()->revenue;
                            else :
                                $kpi->progress = $this->db->query(' (SELECT SUM(item_quantity_booker) as revenue from order_contents where find_in_set(order_id, (SELECT GROUP_CONCAT(id) from orders where employee_id = (SELECT employee_id from employees_info where employee_username = "'.$employee_username.'" ) and MONTH(created_at) IN (10,11,12) )) and find_in_set(pref_id, (SELECT GROUP_CONCAT(pref_id) from inventory_preferences where unit_id = '.$kpi->unit_id.' )))')->row()->revenue;
                            endif;
                        endif;
                    endif;
                endforeach;
        
                return $kpis;
            }
        }
        
    }

    public function get_reportees($employee_username){
        
        //Level 1
        $reporting_to = $this->db->select('employee_id, employee_email, employee_picture, CONCAT(employee_first_name, " ", employee_last_name) as employee_name, employee_designation, employee_username')->where('employee_username', $employee_username)->get('employees_info')->row();
        $reportees = array("employee_name" => $reporting_to->employee_name, "employee_email" => $reporting_to->employee_email, "employee_picture" => $reporting_to->employee_picture, "employee_designation" => $reporting_to->employee_designation, "employee_username" => $reporting_to->employee_username, "reportees" => $this->db->select('employee_id, employee_email, employee_picture, CONCAT(employee_first_name, " ", employee_last_name) as employee_name, employee_designation, employee_username')->where('reporting_to', $reporting_to->employee_id)->get('employees_info')->result());

        //Level 2
        foreach($reportees["reportees"] as $reportee):
            $child_reporting_to = $reportee->employee_id;
            $reportee->reportees = $this->db->select('employee_id, employee_email, employee_picture, CONCAT(employee_first_name, " ", employee_last_name) as employee_name, employee_designation, employee_username')->where('reporting_to', $child_reporting_to)->get('employees_info')->result();
        endforeach;
        
        return $reportees;
    }

    public function validate_reporting($employee_username){
        $employee_id = $this->db->select('admin_id')->where('session', $this->session->userdata('session'))->get('admin_session')->row()->admin_id;
        if($this->db->select('is_admin')->where('employee_id', $employee_id)->get('employees_info')->row()->is_admin){
            return true;
        }
        if($this->db->select('reporting_to')->where('employee_username', $employee_username)->get('employees_info')->row()->reporting_to !== $employee_id){
            return false;
        }
        return true;
    }

    public function get_this_employee_kpi($employee_username)
    {
        return $this->db->select('`id`, `kpi_type`, (SELECT item_id from inventory_preferences where pref_id = kpi.pref_id) as item_id, `pref_id`, `unit_id`, `target`, `eligibility`, `weightage`, `incentive`, `criteria`, `criteria_parameter`, `evaluation_from_employees`, `created_by`, `created_for`, `created_at`')->where(['created_for' => $employee_username, 'YEAR(created_at)' => date("Y")])->get("kpi_management kpi")->result();
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
        return $this->db->where(['created_for' => $employee_username, 'YEAR(created_at)' => date('Y')])->update('kpi_management', array('active' => 0));
    }

    public function activate_kpi($employee_username)
    {
        return $this->db->where(['created_for' => $employee_username, 'YEAR(created_at)' => date('Y')])->update('kpi_management', array('active' => 1));
    }

    public function deactivate_singular_kpi($kpiId){
        return $this->db->where('id', $kpiId)->update('kpi_management', array('active' => 0));
    }

    public function activate_singular_kpi($kpiId){
        return $this->db->where('id', $kpiId)->update('kpi_management', array('active' => 1));
    }

    public function delete_kpi($kpiId){
        return $this->db->delete('kpi_management', array('id' => $kpiId));
    }

}
