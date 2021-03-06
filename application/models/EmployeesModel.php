<?php

class EmployeesModel extends CI_Model
{

    public function get_employees_list_for_dashboard($designation)
    {
        return $this->db->select('employee_id, employee_username, employee_first_name, employee_last_name, (SELECT employee_username from employees_info where employee_id = ei.reporting_to) reporting_to, REPLACE(employee_picture, "./", "http://mgmt.danpakfoods.com/") as picture, employee_designation, (SELECT territory_name from territory_management where id = ei.territory_id) as territory')->where('LOWER(employee_designation) = LOWER("'.$designation.'")')->get("employees_info ei")->result();
    }

    public function getLoggedInProfileInfo(){
        return $this->db->select('`employee_id`, `employee_first_name`, `employee_last_name`, `employee_username`, `employee_email`, `employee_address`, `employee_city`, REPLACE(employee_picture, "./","/") as employee_picture, (SELECT employee_username from employees_info where employee_id = ei.reporting_to) as reporting_to, `employee_cnic`, `employee_designation`, `employee_phone`')->where('employee_id = (SELECT admin_id from admin_session where session = "'.$this->session->userdata("session").'")')->get("employees_info ei")->row();
    }

    public function updatePassword($newPw){
        $empId = $this->db->query('(SELECT admin_id as employee_id from admin_session where session = "'.$this->session->userdata("session").'")')->row()->employee_id;
        return $this->db
            ->where('employee_id', $empId)
            ->update('employees_info', ['employee_password' => $newPw]);
    }

    public function get_employees_list_management()
    {

        if($this->session->userdata("user_type") == "danpak"){
            return $this->db->select('status, employee_id, employee_username, employee_first_name, employee_last_name, (SELECT employee_username from employees_info where employee_id = ei.reporting_to) reporting_to, REPLACE(employee_picture, "./", "http://mgmt.danpakfoods.com/") as picture, employee_designation, (SELECT territory_name from territory_management where id = ei.territory_id) as territory, (SELECT area_name from area_management where id = (SELECT area_id from territory_management where id = ei.territory_id)) as area')->where('LOWER(employee_designation) NOT IN ("asm", "rsm", "order booker", "tso")')->get("employees_info ei")->result();
        }

        $this->db->query("SET SESSION group_concat_max_len = 1000000");
        $managers = $this->db->query('SELECT IFNULL(GROUP_CONCAT(employee_id), 0) as managers FROM `distributor_assignment` where distributor_id = (SELECT distributor_id from admin_session where session = "'.$this->session->userdata("session").'")')->row()->managers;

        $this->db->query("SET SESSION group_concat_max_len = 1000000");
        $reportees = $this->db->query('SELECT IFNULL(GROUP_CONCAT(employee_id), 0) as reportees from employees_info where reporting_to IN (SELECT employee_id FROM `distributor_assignment` where distributor_id = (SELECT distributor_id from admin_session where session = "'.$this->session->userdata("session").'"))')->row()->reportees;

        return $this->db->select('employee_id, employee_username')->where('employee_id IN ('.$reportees.",".$managers.')')->get("employees_info")->result();

        // Atif Retailers Assignment ni kar paa rha due to limited access rights
        // $employee_id = $this->db->select('admin_id')->where('session', $this->session->userdata('session'))->get('admin_session')->row()->admin_id;
        // if($this->db->select('is_admin')->where('employee_id', $employee_id)->get('employees_info')->row()->is_admin !== "0"){
            
        // }else{
            // return $this->db->select('employee_id, employee_username, employee_first_name, employee_last_name, (SELECT employee_username from employees_info where employee_id = ei.reporting_to) reporting_to')->where('reporting_to', $employee_id)->get("employees_info ei")->result();
        // }
    }

    public function get_employees_list_sales_agent()
    {

        if($this->session->userdata("user_type") == "danpak"){
            return $this->db->select('status, employee_id, employee_username, employee_first_name, employee_last_name, (SELECT employee_username from employees_info where employee_id = ei.reporting_to) reporting_to, REPLACE(employee_picture, "./", "http://mgmt.danpakfoods.com/") as picture, employee_designation, (SELECT territory_name from territory_management where id = ei.territory_id) as territory, (SELECT area_name from area_management where id = (SELECT area_id from territory_management where id = ei.territory_id)) as area')->where('LOWER(employee_designation) IN ("asm", "rsm", "order booker", "tso")')->get("employees_info ei")->result();
        }

        $this->db->query("SET SESSION group_concat_max_len = 1000000");
        $managers = $this->db->query('SELECT IFNULL(GROUP_CONCAT(employee_id), 0) as managers FROM `distributor_assignment` where distributor_id = (SELECT distributor_id from admin_session where session = "'.$this->session->userdata("session").'")')->row()->managers;

        $this->db->query("SET SESSION group_concat_max_len = 1000000");
        $reportees = $this->db->query('SELECT IFNULL(GROUP_CONCAT(employee_id), 0) as reportees from employees_info where reporting_to IN (SELECT employee_id FROM `distributor_assignment` where distributor_id = (SELECT distributor_id from admin_session where session = "'.$this->session->userdata("session").'"))')->row()->reportees;

        return $this->db->select('employee_id, employee_username')->where('employee_id IN ('.$reportees.",".$managers.')')->get("employees_info")->result();

        // Atif Retailers Assignment ni kar paa rha due to limited access rights
        // $employee_id = $this->db->select('admin_id')->where('session', $this->session->userdata('session'))->get('admin_session')->row()->admin_id;
        // if($this->db->select('is_admin')->where('employee_id', $employee_id)->get('employees_info')->row()->is_admin !== "0"){
            
        // }else{
            // return $this->db->select('employee_id, employee_username, employee_first_name, employee_last_name, (SELECT employee_username from employees_info where employee_id = ei.reporting_to) reporting_to')->where('reporting_to', $employee_id)->get("employees_info ei")->result();
        // }
    }

    public function get_employees_list()
    {

        if($this->session->userdata("user_type") == "danpak"){
            return $this->db->select('status, employee_id, employee_username, employee_first_name, employee_last_name, (SELECT employee_username from employees_info where employee_id = ei.reporting_to) reporting_to, REPLACE(employee_picture, "./", "http://mgmt.danpakfoods.com/") as picture, employee_designation, (SELECT territory_name from territory_management where id = ei.territory_id) as territory, (SELECT area_name from area_management where id = (SELECT area_id from territory_management where id = ei.territory_id)) as area')->get("employees_info ei")->result();
        }

        $this->db->query("SET SESSION group_concat_max_len = 1000000");
        $managers = $this->db->query('SELECT IFNULL(GROUP_CONCAT(employee_id), 0) as managers FROM `distributor_assignment` where distributor_id = (SELECT distributor_id from admin_session where session = "'.$this->session->userdata("session").'")')->row()->managers;

        $this->db->query("SET SESSION group_concat_max_len = 1000000");
        $reportees = $this->db->query('SELECT IFNULL(GROUP_CONCAT(employee_id), 0) as reportees from employees_info where reporting_to IN (SELECT employee_id FROM `distributor_assignment` where distributor_id = (SELECT distributor_id from admin_session where session = "'.$this->session->userdata("session").'"))')->row()->reportees;

        return $this->db->select('employee_id, employee_username')->where('employee_id IN ('.$reportees.",".$managers.')')->get("employees_info")->result();

        // Atif Retailers Assignment ni kar paa rha due to limited access rights
        // $employee_id = $this->db->select('admin_id')->where('session', $this->session->userdata('session'))->get('admin_session')->row()->admin_id;
        // if($this->db->select('is_admin')->where('employee_id', $employee_id)->get('employees_info')->row()->is_admin !== "0"){
            
        // }else{
            // return $this->db->select('employee_id, employee_username, employee_first_name, employee_last_name, (SELECT employee_username from employees_info where employee_id = ei.reporting_to) reporting_to')->where('reporting_to', $employee_id)->get("employees_info ei")->result();
        // }
    }

    public function add_employee($employee)
    {
        $this->db->insert('employees_info', $employee);
        $employee_id = $this->db->insert_id();
        if ($employee["is_admin"] == "1") {
            $columns = preg_replace('/\bid,\b/', '', $this->db->query('SELECT GROUP_CONCAT(COLUMN_NAME) as columns
			FROM `INFORMATION_SCHEMA`.`COLUMNS`
			WHERE `TABLE_SCHEMA`= "' . $this->db->database . '" AND `TABLE_NAME`="access_rights"')->row()->columns);
            $values = '';
            for ($i = 0; $i < sizeOf(explode(",", $columns)); $i++) {
                if ($i != 0) {
                    if ($i == (sizeof(explode(",", $columns)) - 1)) {
                        $values .= ',1';
                    } else {
                        $values .= ',1';
                    }
                } else {
                    $values = $employee_id;
                }
            }
            return $this->db->query('INSERT into access_rights(' . $columns . ') values(' . $values . ') ');
        }
        return true;
    }

    public function getRsmAsm(){
        return $this->db->select('employee_id, CONCAT(employee_username," (", employee_designation ,")") as employee_username')->where('employee_designation IN ("RSM", "ASM")')->get('employees_info')->result();
    }

    public function getReportingTso($managerId){
        return $this->db->select('employee_id, employee_username, (case when (SELECT count(*) FROM `distributor_assignment` where employee_id = ei.employee_id) > 0 THEN "assigned" else "na" end) as assignment_status')->where('reporting_to = '.$managerId.' and employee_designation = "TSO"')->get('employees_info ei')->result();
    }

    public function getReportingOb($tsoId){
        return $this->db->select('employee_id, employee_username, (case when (SELECT count(*) FROM `distributor_assignment` where employee_id = ei.employee_id) > 0 THEN "assigned" else "na" end) as assignment_status')->where('reporting_to = '.$tsoId.' and employee_designation = "Order Booker"')->get('employees_info ei')->result();
    }

    public function get_single_employee($employee_id)
    {
        return $this->db->select('`employee_id`, `employee_first_name`, `employee_last_name`, `employee_username`, `employee_password`, `employee_email`, `employee_address`, `employee_city`, `employee_country`, `employee_picture`, `reporting_to`, `territory_id`, `employee_cnic`, `employee_hire_at`, `employee_fire_at`, `employee_designation`, `employee_phone`, `employee_salary`, `employee_base_station_lats`, `employee_base_station_longs`, `is_admin`, `created_at`, (SELECT territory_name from territory_management where id = ei.territory_id) as territory, (SELECT area_name from area_management where id = (SELECT area_id from territory_management where id = ei.territory_id)) as area')->where('employee_id', $employee_id)->get("employees_info ei")->row();
        $manager = $this->db->select('admin_id')->where('session', $this->session->userdata('session'))->get('admin_session')->row()->admin_id;
        if($this->db->select('is_admin')->where('employee_id', $manager)->get('employees_info')->row()->is_admin === "1"){
            return $this->db->select('`employee_id`, `employee_first_name`, `employee_last_name`, `employee_username`, `employee_password`, `employee_email`, `employee_address`, `employee_city`, `employee_country`, `employee_picture`, `reporting_to`, `territory_id`, `employee_cnic`, `employee_hire_at`, `employee_fire_at`, `employee_designation`, `employee_phone`, `employee_salary`, `employee_base_station_lats`, `employee_base_station_longs`, `is_admin`, `created_at`, (SELECT territory_name from territory_management where id = ei.territory_id) as territory, (SELECT area_name from area_management where id = (SELECT area_id from territory_management where id = ei.territory_id)) as area')->where('employee_id', $employee_id)->get("employees_info ei")->row();
        }else{
            if($this->db->where(['reporting_to' => $manager, 'employee_id' => $employee_id])->get('employees_info ei')->row()){
                return $this->db->select('`employee_id`, `employee_first_name`, `employee_last_name`, `employee_username`, `employee_password`, `employee_email`, `employee_address`, `employee_city`, `employee_country`, `employee_picture`, `reporting_to`, `territory_id`, `employee_cnic`, `employee_hire_at`, `employee_fire_at`, `employee_designation`, `employee_phone`, `employee_salary`, `employee_base_station_lats`, `employee_base_station_longs`, `is_admin`, `created_at`, (SELECT territory_name from territory_management where id = ei.territory_id) as territory, (SELECT area_name from area_management where id = (SELECT area_id from territory_management where id = ei.territory_id)) as area')->where('employee_id', $employee_id)->get("employees_info ei")->row();
            }
        }
    }

    public function getDailyRouteData()
    {
        $this->db->query("SET SESSION group_concat_max_len = 1000000");
        return $this->db->select('DATE(created_at) as date, GROUP_CONCAT(employee_id) as employees')->group_by('DATE(created_at)')->get('visits_marked vm')->result();
    }

    public function getCompleteRoutingData($routeDate)
    {
        return $this->db->select('(SELECT employee_username from employees_info where employee_id = vm.employee_id) as employee_username, (SELECT retailer_name from retailers_details where id = vm.retailer_id) as retailer_name, DATE(created_at) as route_date, employee_id')->where('DATE(created_at) = "'.$routeDate.'"')->group_by('employee_id')->get('visits_marked vm')->result();
    }

    public function GetLatLongsForDailyRouting($routeData)
    {
        return array('attendance' => $this->db->select('IFNULL(latitude, "") as route_lats, IFNULL(longitude, "") as route_longs')->where('employee_id = ' . $routeData['employee_id'] . ' and checking_status = 1 and DATE(created_at) = "' . $routeData["curr_date"] . '"')->get('ams')->row(), 'shift_end' => $this->db->select('IFNULL(latitude, "") as route_lats, IFNULL(longitude, "") as route_longs')->where('employee_id = ' . $routeData['employee_id'] . ' and checking_status = 0 and DATE(created_at) = "' . $routeData["curr_date"] . '"')->get('ams')->row(), 'data' => $this->db->select('took_order, latitude as route_lats, longitude as route_longs, (SELECT retailer_name from retailers_details where id = vm.retailer_id) as retailer_name')->where('DATE(created_at) = "' . $routeData["curr_date"] . '" and employee_id = ' . $routeData['employee_id'] . ' and latitude IS NOT NULL and latitude != 0 and latitude > 0')->get('visits_marked vm')->result());
    }

    public function GetAttendanceData()
    {
        $totalAttendanceDates = $this->db->select('DATE(created_at) as ams_date')->group_by('DATE(created_at)')->get('ams')->result();
        $attendanceData = array();
        foreach ($totalAttendanceDates as $dates) {

            $attendanceData[] = array('date' => $dates->ams_date, 'data' => $this->db->select('CONCAT(employee_first_name, " ", employee_last_name) as employee_name, (SELECT territory_name from territory_management where id = ei.territory_id) as territory, (SELECT area_name from area_management where id = ((SELECT area_id from territory_management where id = ei.territory_id))) as area, (SELECT region_name from regions_info where id = (SELECT region_id from area_management where id = ((SELECT area_id from territory_management where id = ei.territory_id)))) as region, (SELECT IFNULL((SELECT DATE_FORMAT(DATE_ADD(created_at, INTERVAL 5 HOUR), "%h:%i %p") from ams where DATE(created_at) = "' . $dates->ams_date . '" and employee_id = ei.employee_id and checking_status = 1), "Not checked in")) as check_in_time, (SELECT latitude from ams where DATE(created_at) = "' . $dates->ams_date . '" and employee_id = ei.employee_id and checking_status = 1) as check_in_lat, (SELECT longitude from ams where DATE(created_at) = "' . $dates->ams_date . '" and employee_id = ei.employee_id and checking_status = 1) as check_in_long, (SELECT IFNULL((SELECT DATE_FORMAT(DATE_ADD(created_at, INTERVAL 5 HOUR), "%h:%i %p") from ams where DATE(created_at) = "' . $dates->ams_date . '" and employee_id = ei.employee_id and checking_status = 0), "Not checked out")) as check_out_time, (SELECT IFNULL((SELECT CASE WHEN within_radius = 0 THEN "No" ELSE "Yes" END from ams where DATE(created_at) = "' . $dates->ams_date . '" and employee_id = ei.employee_id and checking_status = 1),"Not marked")) as within_radius, employee_base_station_lats, employee_base_station_longs')->get('employees_info ei')->result());
        }
        return $attendanceData;
    }

    public function AttendanceStats()
    {
        $stats = array("present_today" => $this->db->select('count(employee_id) as present_today')->where('DATE(created_at) = CURDATE() and checking_status = 1')->get('ams')->row()->present_today, "absent_today" => $this->db->select('count(employee_id) as absent_today')->where('employee_id NOT IN (SELECT employee_id from ams where checking_status = 1 and DATE(created_at) = CURDATE())')->get('employees_info ei')->row()->absent_today, "location_compliance" => $this->db->select('count(employee_id) as location_compliance')->where('within_radius = 1 and checking_status = 1 and DATE(created_at) = CURDATE()')->get('ams')->row()->location_compliance, "none_compliance" => $this->db->select('count(employee_id) as none_compliance')->where('within_radius = 0 and checking_status = 1 and DATE(created_at) = CURDATE()')->get('ams')->row()->none_compliance);
        return $stats;
    }

    public function update_employee_picture($picture)
    {
        $empId = $this->db->query('(SELECT admin_id as employee_id from admin_session where session = "'.$this->session->userdata("session").'")')->row()->employee_id;
        $existingImg = $this->db->select('employee_picture')->where('employee_id', $empId)->get('employees_info')->row()->employee_picture;
        if(file_exists($existingImg)){
            unlink($existingImg);
        }
        return $this->db
            ->where('employee_id', $empId)
            ->update('employees_info', ['employee_picture' => $picture]);
    }

    public function update_employee($employee_id, $employee)
    {

        if ($employee["is_admin"] == "1") {
            $this->db->delete('access_rights', array('admin_id' => $employee_id));
            $columns = preg_replace('/\bid,\b/', '', $this->db->query('SELECT GROUP_CONCAT(COLUMN_NAME) as columns
            FROM `INFORMATION_SCHEMA`.`COLUMNS`
            WHERE `TABLE_SCHEMA`= "' . $this->db->database . '" AND `TABLE_NAME`="access_rights"')->row()->columns);
            $values = '';
            for ($i = 0; $i < sizeOf(explode(",", $columns)); $i++) {
                if ($i != 0) {
                    if ($i == (sizeof(explode(",", $columns)) - 1)) {
                        $values .= ',1';
                    } else {
                        $values .= ',1';
                    }
                } else {
                    $values = $employee_id;
                }
            }
            $this->db->query('INSERT into access_rights(' . $columns . ') values(' . $values . ') ');
        } else {
            if($this->db->where('is_admin = 1 and employee_id = '.$employee_id)->get('employees_info')->row()){
                $this->db->delete('access_rights', array('admin_id' => $employee_id));
            }
        }

        if (isset($employee['employee_picture']) || $employee['picture_deleted'] == 'deleted') {
            $employee_picture = $this->db->select('REPLACE(employee_picture,"./","") as employee_picture')->where('employee_id', $employee_id)->get('employees_info')->row()->employee_picture;
            if ($employee_picture) {
                $employee_picture = FCPATH . $employee_picture;
                if (file_exists($employee_picture)) {
                    unlink($employee_picture);
                }
            }
            unset($employee['picture_deleted']);
            if (!isset($employee['employee_picture'])) {
                $employee['employee_picture'] = '';
            }
        } else if (!isset($employee['employee_picture']) && $employee['picture_deleted'] == 'deleted') {
            $employee['employee_picture'] = '';
            unset($employee['picture_deleted']);
        } else {
            unset($employee['picture_deleted']);
        }

        return $this->db
            ->where('employee_id', $employee_id)
            ->update('employees_info', $employee);
    }

    public function delete_employee($employee_id)
    {
        return $this->db->delete('employees_info', array('employee_id' => $employee_id));
    }

    public function GetProfilePicForWeb($session)
    {
        $pic = $this->db->select('(SELECT REPLACE(employee_picture, "./","") from employees_info where employee_id = as.admin_id) as picture')->where('session', $session)->get('admin_session as')->row()->picture;
        return file_exists($pic) ? $pic : "/assets/images/no-image.png";
    }

    public function deact_act_emp($empId, $status){
        return $this->db
            ->where('employee_id', $empId)
            ->update('employees_info', array('status' => $status));
    }

    public function getEmployeeStatsCurrMonth($employeeId){
        $retOrDist = "ret";

        $totalEmpDays = $this->db->query("SELECT DAY(created_at) as week from orders where employee_id = ".$employeeId." group by DAY(created_at)")->result();
        $avg_prod_shops_per_day = array();
        foreach ($totalEmpDays as $value) {
            $avg_prod_shops_per_day[] = $this->db->query("SELECT 
            (SELECT count(*) from visits_marked where took_order = 1 and employee_id = ".$employeeId." and DAY(created_at) = ".$value->week." and find_in_set(retailer_id, (SELECT GROUP_CONCAT(retailer_id) from retailers_assignment where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = 'ret')) ))) as retailers_ordered
        from orders ords where employee_id = ".$employeeId." and MONTH(created_at) = ".date('m')." group by DAY(created_at)")->row() ? $this->db->query("SELECT 
            (SELECT count(*) from visits_marked where took_order = 1 and employee_id = ".$employeeId." and DAY(created_at) = ".$value->week." and find_in_set(retailer_id, (SELECT GROUP_CONCAT(retailer_id) from retailers_assignment where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = 'ret')) ))) as retailers_ordered
        from orders ords where employee_id = ".$employeeId." and MONTH(created_at) = ".date('m')." group by DAY(created_at)")->row()->retailers_ordered : 0;
        }
        $avg_prod_shops_per_day = round(array_sum($avg_prod_shops_per_day)/sizeOf($avg_prod_shops_per_day), 2);

        $totalEmpWeeks = $this->db->query("SELECT week(created_at) as week from orders where employee_id = ".$employeeId." group by week(created_at)")->result();
        $avg_prod_shops_per_week = array();
        foreach ($totalEmpWeeks as $value) {
            $avg_prod_shops_per_week[] = $this->db->query("SELECT 
    (SELECT count(*) from visits_marked where took_order = 1 and employee_id = ".$employeeId." and week(created_at) = ".$value->week." and find_in_set(retailer_id, (SELECT GROUP_CONCAT(retailer_id) from retailers_assignment where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = 'ret')) ))) as retailers_ordered
from orders ords where employee_id = ".$employeeId." and MONTH(created_at) = ".date('m')." group by week(created_at)")->row() ? $this->db->query("SELECT 
    (SELECT count(*) from visits_marked where took_order = 1 and employee_id = ".$employeeId." and week(created_at) = ".$value->week." and find_in_set(retailer_id, (SELECT GROUP_CONCAT(retailer_id) from retailers_assignment where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = 'ret')) ))) as retailers_ordered
from orders ords where employee_id = ".$employeeId." and MONTH(created_at) = ".date('m')." group by week(created_at)")->row()->retailers_ordered : 0;
        }
        $avg_prod_shops_per_week = round(array_sum($avg_prod_shops_per_week)/sizeOf($avg_prod_shops_per_week), 2);

        $totalEmpMonths = $this->db->query("SELECT MONTH(created_at) as mon from orders
where employee_id = ".$employeeId."
group by MONTH(created_at)")->result();
        $result = array();
        foreach ($totalEmpMonths as $value) {
            $result[] = $this->db->query("SELECT 
    (SELECT count(*) from visits_marked where took_order = 1 and employee_id = ".$employeeId." and MONTH(created_at) = ".$value->mon." and find_in_set(retailer_id, (SELECT GROUP_CONCAT(retailer_id) from retailers_assignment where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = 'ret')) ))) as retailers_ordered
from orders ords where employee_id = ".$employeeId." and MONTH(created_at) = ".$value->mon." group by MONTH(created_at)")->row() ? $this->db->query("SELECT 
    (SELECT count(*) from visits_marked where took_order = 1 and employee_id = ".$employeeId." and MONTH(created_at) = ".$value->mon." and find_in_set(retailer_id, (SELECT GROUP_CONCAT(retailer_id) from retailers_assignment where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = 'ret')) ))) as retailers_ordered
from orders ords where employee_id = ".$employeeId." and MONTH(created_at) = ".$value->mon." group by MONTH(created_at)")->row()->retailers_ordered : 0;
        }
        $avg_prod_shops_per_month = round(array_sum($result)/sizeOf($result), 2);

        return array("revenue_generated" => $this->db->query("SELECT ROUND(SUM(final_price)) as total_revenue from order_contents where order_id IN (SELECT id FROM `orders` where status = 'completed' and employee_id = ".$employeeId." and MONTH(created_at) = ".date('m')." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')))")->row()->total_revenue, "avg_monthly_sale" => $this->db->query("SELECT ROUND(SUM(total_sale)/count(*)) as avg_monthly_sale from (SELECT ROUND((SELECT SUM(final_price) from order_contents where find_in_set(order_id, GROUP_CONCAT(orders.id)))) as total_sale FROM `orders` where status = 'completed' and employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) group by MONTH(created_at)) as avg_monthly_sale")->row()->avg_monthly_sale, "avg_per_week_sale" => $this->db->query("SELECT ROUND(SUM(new_total_sale)/count(*)) as avg_per_week_sale from (SELECT week, SUM(total_sale) as new_total_sale from (SELECT WEEK(created_at) week, ROUND((SELECT SUM(final_price) from order_contents where find_in_set(order_id, GROUP_CONCAT(orders.id)))) as total_sale from orders where status = 'completed' and MONTH(created_at) = ".date('m')." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) and employee_id = ".$employeeId." group by DATE(created_at)) as result group by week) as result")->row()->avg_per_week_sale, "avg_daily_sale" => $this->db->query("SELECT ROUND(SUM(total_sale)/count(*)) as avg_daily_sale from (SELECT DATE(created_at), ROUND((SELECT SUM(final_price) from order_contents where find_in_set(order_id, GROUP_CONCAT(orders.id)))) as total_sale from orders where status = 'completed' and MONTH(created_at) = ".date('m')." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) and employee_id = ".$employeeId." group by DATE(created_at)) as avg_daily_sale")->row()->avg_daily_sale, "avg_order_value" => $this->db->query("SELECT ROUND((SUM(total_sale)/count(*))) as avg_order_value from (SELECT id, ROUND((SELECT SUM(final_price) from order_contents where order_id = orders.id)) as total_sale from orders where status = 'completed' and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) and MONTH(created_at) = ".date('m')." and employee_id = ".$employeeId.") as avg_order_value")->row()->avg_order_value, "productive_sales_ratio" => $this->db->query("SELECT ROUND(((count(*)/(SELECT count(*) from visits_marked where employee_id = ".$employeeId."))*100), 2) as productive_sales_ratio from orders where LOWER(status) = 'completed' and MONTH(created_at) = ".date('m')." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) and employee_id = ".$employeeId)->row()->productive_sales_ratio, "return_ratio" => $this->db->query("SELECT ROUND(((count(*)/(SELECT count(*) from visits_marked where employee_id =  ".$employeeId."))*100), 2) as return_ratio from orders where LOWER(status) = 'cancelled' and MONTH(created_at) = ".date('m')." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) and employee_id = ".$employeeId)->row()->return_ratio, "avg_products_per_order" => $this->db->query("SELECT ROUND(SUM((SELECT count(*) from order_contents where order_id = orders.id))/count(*), 2) as avg_products_per_order from orders
        where LOWER(status) = 'completed' and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) and MONTH(created_at) = ".date('m')." and employee_id = ".$employeeId)->row()->avg_products_per_order, "total_retail_outlets" => $this->db->query("SELECT count(*) as total_retail_outlets from retailers_assignment where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."'))")->row()->total_retail_outlets, "avg_prod_shops_per_month" => $avg_prod_shops_per_month, "avg_productive_shops_per_week" => $avg_prod_shops_per_week, "avg_daily_prod_shops" => $avg_prod_shops_per_day, "productive_ratio" => $this->db->query("SELECT ROUND((total_ordered/total_assigned)*100, 2) as productive_ratio from (SELECT count(*) as total_ordered, (SELECT count(*) from retailers_assignment where employee_id = ".$employeeId." and MONTH(created_at) = ".date('m')." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."'))) as total_assigned from orders
where employee_id = ".$employeeId." and MONTH(created_at) = ".date('m')."
and retailer_id IN (SELECT retailer_id from retailers_assignment where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) and MONTH(created_at) = ".date('m').")
and LOWER(status) = 'completed') as res_set")->row()->productive_ratio, "avg_monthly_visits" => $this->db->query("SELECT ROUND(SUM(total_visits)/count(*), 2) as avg_monthly_visits from (SELECT MONTH(created_at) as this_month, count(*) as total_visits from visits_marked where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) group by MONTH(created_at)) as res_set")->row()->avg_monthly_visits, "avg_weekly_visits" => $this->db->query("SELECT ROUND(SUM(total_visits)/count(*), 2) as avg_weekly_visits from (SELECT week(created_at) as this_week, count(*) as total_visits from visits_marked where employee_id = ".$employeeId." and MONTH(created_at) = ".date('m')." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) group by week(created_at)) as res_set")->row()->avg_weekly_visits, "avg_daily_visits" => $this->db->query("SELECT ROUND(SUM(total_visits)/count(*), 2) as avg_daily_visits from (SELECT DATE(created_at) as this_day, count(*) as total_visits from visits_marked where employee_id = ".$employeeId." and MONTH(created_at) = ".date('m')." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) group by DATE(created_at)) as res_set")->row()->avg_daily_visits, "avg_order_monthly" => $this->db->query("SELECT ROUND(SUM(total_orders)/count(*),2) as avg_order_monthly from (SELECT MONTH(created_at) as this_month, count(*) as total_orders from orders where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) group by MONTH(created_at)) as res_set")->row()->avg_order_monthly, "avg_order_weekly" => $this->db->query("SELECT ROUND(SUM(total_orders)/count(*),2) as avg_order_weekly from (SELECT week(created_at) as this_week, count(*) as total_orders from orders where employee_id = ".$employeeId." and MONTH(created_at) = ".date('m')." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) group by week(created_at)) as res_set")->row()->avg_order_weekly, "avg_order_daily" => $this->db->query("SELECT ROUND(SUM(total_orders)/count(*),2) as avg_order_daily from (SELECT date(created_at) as this_day, count(*) as total_orders from orders where employee_id = ".$employeeId." and MONTH(created_at) = ".date('m')." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) group by date(created_at)) as res_set")->row()->avg_order_daily, "avg_discount_per_order" => $this->db->query("SELECT ROUND(SUM(discount_given)/count(*),2) as avg_discount_per_order from (SELECT order_id, SUM(booker_discount) as discount_given from order_contents where order_id IN (SELECT id from orders where employee_id = ".$employeeId." and MONTH(created_at) = ".date('m')." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."'))) group by order_id) as result_set")->row()->avg_discount_per_order, "total_orders_booked" => $this->db->query("SELECT count(*) as total_orders_booked from orders where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) and MONTH(created_at) = ".date('m'))->row()->total_orders_booked, 'expansion_ratio' => $this->db->query("SELECT ROUND((added_new/assigned)*100, 2) as expansion_ratio from (SELECT count(*) added_new, (SELECT count(*) from retailers_assignment where employee_id = ".$employeeId.") as assigned FROM `retailers_details` where added_by = ".$employeeId." and MONTH(created_at) = ".date('m')." and retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) as res_set")->row()->expansion_ratio, "order_compliance" => $this->db->query("SELECT ROUND((order_compliance/total_orders)*100, 2) as compliance from (SELECT (SELECT count(*) from orders where employee_id = ".$employeeId." and MONTH(created_at) = ".date('m')." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) and within_radius = 1) as order_compliance , count(*) as total_orders from orders where employee_id = ".$employeeId." and MONTH(created_at) = ".date('m').") as result")->row()->compliance);
    }

    public function getEmployeeStatsCurrOverall($employeeId){
        
        $retOrDist = "ret";

        $totalEmpDays = $this->db->query("SELECT DAY(created_at) as week from orders where employee_id = ".$employeeId." group by DAY(created_at)")->result();
        $avg_prod_shops_per_day = array();
        foreach ($totalEmpDays as $value) {
            $avg_prod_shops_per_day[] = $this->db->query("SELECT 
            (SELECT count(*) from visits_marked where took_order = 1 and employee_id = ".$employeeId." and DAY(created_at) = ".$value->week." and find_in_set(retailer_id, (SELECT GROUP_CONCAT(retailer_id) from retailers_assignment where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = 'ret')) ))) as retailers_ordered
        from orders ords where employee_id = ".$employeeId." group by DAY(created_at)")->row() ? $this->db->query("SELECT 
            (SELECT count(*) from visits_marked where took_order = 1 and employee_id = ".$employeeId." and DAY(created_at) = ".$value->week." and find_in_set(retailer_id, (SELECT GROUP_CONCAT(retailer_id) from retailers_assignment where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = 'ret')) ))) as retailers_ordered
        from orders ords where employee_id = ".$employeeId." group by DAY(created_at)")->row()->retailers_ordered : 0;
        }
        $avg_prod_shops_per_day = array_sum($avg_prod_shops_per_day)/sizeOf($avg_prod_shops_per_day);

        $totalEmpWeeks = $this->db->query("SELECT week(created_at) as week from orders where employee_id = ".$employeeId." group by week(created_at)")->result();
        $avg_prod_shops_per_week = array();
        foreach ($totalEmpWeeks as $value) {
            $avg_prod_shops_per_week[] = $this->db->query("SELECT 
    (SELECT count(*) from visits_marked where took_order = 1 and employee_id = ".$employeeId." and week(created_at) = ".$value->week." and find_in_set(retailer_id, (SELECT GROUP_CONCAT(retailer_id) from retailers_assignment where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = 'ret')) ))) as retailers_ordered
from orders ords where employee_id = ".$employeeId." group by week(created_at)")->row() ? $this->db->query("SELECT 
    (SELECT count(*) from visits_marked where took_order = 1 and employee_id = ".$employeeId." and week(created_at) = ".$value->week." and find_in_set(retailer_id, (SELECT GROUP_CONCAT(retailer_id) from retailers_assignment where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = 'ret')) ))) as retailers_ordered
from orders ords where employee_id = ".$employeeId." group by week(created_at)")->row()->retailers_ordered : 0;
        }
        $avg_prod_shops_per_week = array_sum($avg_prod_shops_per_week)/sizeOf($avg_prod_shops_per_week);

        $totalEmpMonths = $this->db->query("SELECT MONTH(created_at) as mon from orders
where employee_id = ".$employeeId."
group by MONTH(created_at)")->result();
        $result = array();
        foreach ($totalEmpMonths as $value) {
            $result[] = $this->db->query("SELECT 
    (SELECT count(*) from visits_marked where took_order = 1 and employee_id = ".$employeeId." and MONTH(created_at) = ".$value->mon." and find_in_set(retailer_id, (SELECT GROUP_CONCAT(retailer_id) from retailers_assignment where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = 'ret')) ))) as retailers_ordered
from orders ords where employee_id = ".$employeeId." and MONTH(created_at) = ".$value->mon." group by MONTH(created_at)")->row() ? $this->db->query("SELECT 
    (SELECT count(*) from visits_marked where took_order = 1 and employee_id = ".$employeeId." and MONTH(created_at) = ".$value->mon." and find_in_set(retailer_id, (SELECT GROUP_CONCAT(retailer_id) from retailers_assignment where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = 'ret')) ))) as retailers_ordered
from orders ords where employee_id = ".$employeeId." and MONTH(created_at) = ".$value->mon." group by MONTH(created_at)")->row()->retailers_ordered : 0;
        }
        $avg_prod_shops_per_month = round(array_sum($result)/sizeOf($result), 2);

        return array("revenue_generated" => $this->db->query("SELECT ROUND(SUM(final_price)) as total_revenue from order_contents where order_id IN (SELECT id FROM `orders` where status = 'completed' and employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')))")->row()->total_revenue, "avg_monthly_sale" => $this->db->query("SELECT ROUND(SUM(total_sale)/count(*)) as avg_monthly_sale from (SELECT ROUND((SELECT SUM(final_price) from order_contents where find_in_set(order_id, GROUP_CONCAT(orders.id)))) as total_sale FROM `orders` where status = 'completed' and employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) group by MONTH(created_at)) as avg_monthly_sale")->row()->avg_monthly_sale, "avg_per_week_sale" => $this->db->query("SELECT ROUND(SUM(new_total_sale)/count(*)) as avg_per_week_sale from (SELECT week, SUM(total_sale) as new_total_sale from (SELECT WEEK(created_at) week, ROUND((SELECT SUM(final_price) from order_contents where find_in_set(order_id, GROUP_CONCAT(orders.id)))) as total_sale from orders where status = 'completed' and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) and employee_id = ".$employeeId." group by DATE(created_at)) as result group by week) as result")->row()->avg_per_week_sale, "avg_daily_sale" => $this->db->query("SELECT ROUND(SUM(total_sale)/count(*)) as avg_daily_sale from (SELECT DATE(created_at), ROUND((SELECT SUM(final_price) from order_contents where find_in_set(order_id, GROUP_CONCAT(orders.id)))) as total_sale from orders where status = 'completed' and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) and employee_id = ".$employeeId." group by DATE(created_at)) as avg_daily_sale")->row()->avg_daily_sale, "avg_order_value" => $this->db->query("SELECT ROUND((SUM(total_sale)/count(*))) as avg_order_value from (SELECT id, ROUND((SELECT SUM(final_price) from order_contents where order_id = orders.id)) as total_sale from orders where status = 'completed' and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) and employee_id = ".$employeeId.") as avg_order_value")->row()->avg_order_value, "productive_sales_ratio" => $this->db->query("SELECT ROUND(((count(*)/(SELECT count(*) from visits_marked where employee_id = ".$employeeId."))*100), 2) as productive_sales_ratio from orders where LOWER(status) = 'completed' and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) and employee_id = ".$employeeId)->row()->productive_sales_ratio, "return_ratio" => $this->db->query("SELECT ROUND(((count(*)/(SELECT count(*) from visits_marked where employee_id =  ".$employeeId."))*100), 2) as return_ratio from orders where LOWER(status) = 'cancelled' and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) and employee_id = ".$employeeId)->row()->return_ratio, "avg_products_per_order" => $this->db->query("SELECT ROUND(SUM((SELECT count(*) from order_contents where order_id = orders.id))/count(*), 2) as avg_products_per_order from orders
        where LOWER(status) = 'completed' and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) and employee_id = ".$employeeId)->row()->avg_products_per_order, "total_retail_outlets" => $this->db->query("SELECT count(*) as total_retail_outlets from retailers_assignment where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."'))")->row()->total_retail_outlets, "avg_prod_shops_per_month" => $avg_prod_shops_per_month, "avg_productive_shops_per_week" => round($avg_prod_shops_per_week, 2), "avg_daily_prod_shops" => round($avg_prod_shops_per_day, 2), "productive_ratio" => $this->db->query("SELECT ROUND((total_ordered/total_assigned)*100, 2) as productive_ratio from (SELECT count(*) as total_ordered, (SELECT count(*) from retailers_assignment where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."'))) as total_assigned from orders
where employee_id = ".$employeeId."
and retailer_id IN (SELECT retailer_id from retailers_assignment where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')))
and LOWER(status) = 'completed') as res_set")->row()->productive_ratio, "avg_monthly_visits" => $this->db->query("SELECT ROUND(SUM(total_visits)/count(*), 2) as avg_monthly_visits from (SELECT MONTH(created_at) as this_month, count(*) as total_visits from visits_marked where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) group by MONTH(created_at)) as res_set")->row()->avg_monthly_visits, "avg_weekly_visits" => $this->db->query("SELECT ROUND(SUM(total_visits)/count(*), 2) as avg_weekly_visits from (SELECT week(created_at) as this_week, count(*) as total_visits from visits_marked where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) group by week(created_at)) as res_set")->row()->avg_weekly_visits, "avg_daily_visits" => $this->db->query("SELECT ROUND(SUM(total_visits)/count(*), 2) as avg_daily_visits from (SELECT DATE(created_at) as this_day, count(*) as total_visits from visits_marked where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) group by DATE(created_at)) as res_set")->row()->avg_daily_visits, "avg_order_monthly" => $this->db->query("SELECT ROUND(SUM(total_orders)/count(*),2) as avg_order_monthly from (SELECT MONTH(created_at) as this_month, count(*) as total_orders from orders where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) group by MONTH(created_at)) as res_set")->row()->avg_order_monthly, "avg_order_weekly" => $this->db->query("SELECT ROUND(SUM(total_orders)/count(*),2) as avg_order_weekly from (SELECT week(created_at) as this_week, count(*) as total_orders from orders where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) group by week(created_at)) as res_set")->row()->avg_order_weekly, "avg_order_daily" => $this->db->query("SELECT ROUND(SUM(total_orders)/count(*),2) as avg_order_daily from (SELECT date(created_at) as this_day, count(*) as total_orders from orders where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) group by date(created_at)) as res_set")->row()->avg_order_daily, "avg_discount_per_order" => $this->db->query("SELECT ROUND(SUM(discount_given)/count(*),2) as avg_discount_per_order from (SELECT order_id, SUM(booker_discount) as discount_given from order_contents where order_id IN (SELECT id from orders where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."'))) group by order_id) as result_set")->row()->avg_discount_per_order, "total_orders_booked" => $this->db->query("SELECT count(*) as total_orders_booked from orders where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."'))")->row()->total_orders_booked, 'expansion_ratio' => $this->db->query("SELECT ROUND((added_new/assigned)*100, 2) as expansion_ratio from (SELECT count(*) added_new, (SELECT count(*) from retailers_assignment where employee_id = ".$employeeId.") as assigned FROM `retailers_details` where added_by = ".$employeeId." and retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) as res_set")->row()->expansion_ratio, "order_compliance" => $this->db->query("SELECT ROUND((order_compliance/total_orders)*100, 2) as compliance from (SELECT (SELECT count(*) from orders where employee_id = ".$employeeId." and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) and within_radius = 1) as order_compliance , count(*) as total_orders from orders where employee_id = ".$employeeId.") as result")->row()->compliance);
    }

//     public function getEmployeeStatsCurrOverall($employeeId){
//         return array("revenue_generated" => $this->db->query("SELECT ROUND(SUM(final_price)) as total_revenue from order_contents where order_id IN (SELECT id FROM `orders` where status = 'completed' and employee_id = ".$employeeId.")")->row()->total_revenue, "avg_monthly_sale" => $this->db->query("SELECT ROUND(SUM(total_sale)/count(*)) as avg_monthly_sale from (SELECT ROUND((SELECT SUM(final_price) from order_contents where find_in_set(order_id, GROUP_CONCAT(orders.id)))) as total_sale FROM `orders` where status = 'completed' and employee_id = ".$employeeId." group by MONTH(created_at)) as avg_monthly_sale")->row()->avg_monthly_sale, "avg_per_week_sale" => $this->db->query("SELECT ROUND(SUM(new_total_sale)/count(*)) as avg_per_week_sale from (SELECT week, SUM(total_sale) as new_total_sale from (SELECT WEEK(created_at) week, ROUND((SELECT SUM(final_price) from order_contents where find_in_set(order_id, GROUP_CONCAT(orders.id)))) as total_sale from orders where status = 'completed'  and employee_id = ".$employeeId." group by DATE(created_at)) as result group by week) as result")->row()->avg_per_week_sale, "avg_daily_sale" => $this->db->query("SELECT ROUND(SUM(total_sale)/count(*)) as avg_daily_sale from (SELECT DATE(created_at), ROUND((SELECT SUM(final_price) from order_contents where find_in_set(order_id, GROUP_CONCAT(orders.id)))) as total_sale from orders where status = 'completed'  and employee_id = ".$employeeId." group by DATE(created_at)) as avg_daily_sale")->row()->avg_daily_sale, "avg_order_value" => $this->db->query("SELECT ROUND((SUM(total_sale)/count(*))) as avg_order_value from (SELECT id, ROUND((SELECT SUM(final_price) from order_contents where order_id = orders.id)) as total_sale from orders where status = 'completed'  and employee_id = ".$employeeId.") as avg_order_value")->row()->avg_order_value, "productive_sales_ratio" => $this->db->query("SELECT ROUND(((count(*)/(SELECT count(*) from visits_marked where employee_id = ".$employeeId."))*100), 2) as productive_sales_ratio from orders where LOWER(status) = 'completed'  and employee_id = ".$employeeId)->row()->productive_sales_ratio, "return_ratio" => $this->db->query("SELECT ROUND(((count(*)/(SELECT count(*) from visits_marked where employee_id = ".$employeeId."))*100), 2) as return_ratio from orders where LOWER(status) = 'cancelled'  and employee_id = ".$employeeId)->row()->return_ratio, "avg_products_per_order" => $this->db->query("SELECT ROUND(SUM((SELECT count(*) from order_contents where order_id = orders.id))/count(*), 2) as avg_products_per_order from orders
//         where LOWER(status) = 'completed'  and employee_id = ".$employeeId)->row()->avg_products_per_order, "total_retail_outlets" => $this->db->query("SELECT count(*) as total_retail_outlets from retailers_assignment where employee_id = ".$employeeId)->row()->total_retail_outlets, "avg_prod_shops_per_month" => $this->db->query("SELECT ROUND(SUM(retailers_ordered)/count(*), 2) as avg_prod_shops_per_month from (SELECT MONTH(created_at) as this_month,
// (SELECT count(*) from visits_marked where took_order = 1 and employee_id = ".$employeeId." and MONTH(created_at) = MONTH(ords.created_at) and
// find_in_set(retailer_id, (SELECT GROUP_CONCAT(retailer_id) from retailers_assignment where employee_id = ".$employeeId."))) as retailers_ordered,
// (SELECT count(*) from retailers_assignment where employee_id = ".$employeeId.") as retailers_assigned from orders ords
// where retailer_id IN (SELECT retailer_id from retailers_assignment
// where employee_id = ".$employeeId.") and employee_id = ".$employeeId."
// group by MONTH(created_at)) as result_set
// group by this_month")->row()->avg_prod_shops_per_month, "avg_productive_shops_per_week" => $this->db->query("SELECT ROUND(SUM(retailers_ordered)/count(*), 2) as avg_productive_shops_per_week from (SELECT week(created_at) as this_week,
// (SELECT count(*) from visits_marked where took_order = 1 and employee_id = ".$employeeId." and week(created_at) = week(ords.created_at) and
// find_in_set(retailer_id, (SELECT GROUP_CONCAT(retailer_id) from retailers_assignment where employee_id = ".$employeeId."))) as retailers_ordered,
// (SELECT count(*) from retailers_assignment where employee_id = ".$employeeId.") as retailers_assigned from orders ords
// where retailer_id IN (SELECT retailer_id from retailers_assignment
// where employee_id = ".$employeeId.") and employee_id = ".$employeeId."
// group by week(created_at)) as result_set")->row()->avg_productive_shops_per_week, "avg_daily_prod_shops" => $this->db->query("SELECT ROUND(SUM(retailers_ordered)/count(*), 2) as avg_daily_prod_shops from (SELECT day(created_at) as this_day,
// (SELECT count(*) from visits_marked where took_order = 1 and employee_id = ".$employeeId." and day(created_at) = day(ords.created_at) and
// find_in_set(retailer_id, (SELECT GROUP_CONCAT(retailer_id) from retailers_assignment where employee_id = ".$employeeId."))) as retailers_ordered,
// (SELECT count(*) from retailers_assignment where employee_id = ".$employeeId.") as retailers_assigned from orders ords
// where retailer_id IN (SELECT retailer_id from retailers_assignment
// where employee_id = ".$employeeId.") and employee_id = ".$employeeId."
// group by day(created_at)) as result")->row()->avg_daily_prod_shops, "productive_ratio" => $this->db->query("SELECT ROUND((total_ordered/total_assigned)*100, 2) as productive_ratio from (SELECT count(*) as total_ordered, (SELECT count(*) from retailers_assignment where employee_id = ".$employeeId.") as total_assigned from orders
// where employee_id = ".$employeeId."
// and retailer_id IN (SELECT retailer_id from retailers_assignment where employee_id = ".$employeeId.")
// and LOWER(status) = 'completed') as res_set")->row()->productive_ratio, "avg_monthly_visits" => $this->db->query("SELECT ROUND(SUM(total_visits)/count(*), 2) as avg_monthly_visits from (SELECT MONTH(created_at) as this_month, count(*) as total_visits from visits_marked where employee_id = ".$employeeId." group by MONTH(created_at)) as res_set")->row()->avg_monthly_visits, "avg_weekly_visits" => $this->db->query("SELECT ROUND(SUM(total_visits)/count(*), 2) as avg_weekly_visits from (SELECT week(created_at) as this_week, count(*) as total_visits from visits_marked where employee_id = ".$employeeId."  group by week(created_at)) as res_set")->row()->avg_weekly_visits, "avg_daily_visits" => $this->db->query("SELECT ROUND(SUM(total_visits)/count(*), 2) as avg_daily_visits from (SELECT DATE(created_at) as this_day, count(*) as total_visits from visits_marked where employee_id = ".$employeeId."  group by DATE(created_at)) as res_set")->row()->avg_daily_visits, "avg_order_monthly" => $this->db->query("SELECT ROUND(SUM(total_orders)/count(*),2) as avg_order_monthly from (SELECT MONTH(created_at) as this_month, count(*) as total_orders from orders where employee_id = ".$employeeId." group by MONTH(created_at)) as res_set")->row()->avg_order_monthly, "avg_order_weekly" => $this->db->query("SELECT ROUND(SUM(total_orders)/count(*),2) as avg_order_weekly from (SELECT week(created_at) as this_week, count(*) as total_orders from orders where employee_id = ".$employeeId."  group by week(created_at)) as res_set")->row()->avg_order_weekly, "avg_order_daily" => $this->db->query("SELECT ROUND(SUM(total_orders)/count(*),2) as avg_order_daily from (SELECT date(created_at) as this_day, count(*) as total_orders from orders where employee_id = ".$employeeId."  group by date(created_at)) as res_set")->row()->avg_order_daily, "avg_discount_per_order" => $this->db->query("SELECT ROUND(SUM(discount_given)/count(*),2) as avg_discount_per_order from (SELECT order_id, SUM(booker_discount) as discount_given from order_contents where order_id IN (SELECT id from orders where employee_id = ".$employeeId." ) group by order_id) as result_set")->row()->avg_discount_per_order, "total_orders_booked" => $this->db->query("SELECT count(*) as total_orders_booked from orders where employee_id = ".$employeeId)->row()->total_orders_booked, 'expansion_ratio' => $this->db->query("SELECT ROUND((added_new/assigned)*100, 2) as expansion_ratio from (SELECT count(*) added_new, (SELECT count(*) from retailers_assignment where employee_id = ".$employeeId.") as assigned FROM `retailers_details` where added_by = ".$employeeId.") as res_set")->row()->expansion_ratio, "order_compliance" => $this->db->query("SELECT ROUND((order_compliance/total_orders)*100, 2) as compliance from (SELECT (SELECT count(*) from orders where employee_id = ".$employeeId." and within_radius = 1) as order_compliance , count(*) as total_orders from orders where employee_id = ".$employeeId.") as result")->row()->compliance);
//     }

}
