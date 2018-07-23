<?php

class EmployeesModel extends CI_Model
{

    public function get_employees_list()
    {
        return $this->db->select('employee_id, employee_username, employee_first_name, employee_last_name, (SELECT employee_username from employees_info where employee_id = ei.reporting_to) reporting_to')->get("employees_info ei")->result();
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

    public function get_single_employee($employee_id)
    {
        return $this->db->where('employee_id', $employee_id)->get("employees_info")->row();
    }

    public function getDailyRouteData()
    {
        return $this->db->select('(SELECT employee_username from employees_info where employee_id = vm.employee_id) as employee_username, (SELECT retailer_name from retailers_details where id = vm.retailer_id) as retailer_name, DATE(created_at) as route_date, employee_id')->group_by('DATE(created_at)')->get('visits_marked vm')->result();
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

    public function update_employee($employee_id, $employee)
    {

        if ($employee["is_admin"] == "1") {
            if (!$this->db->where('admin_id', $employee_id)->get('access_rights')->result()) {
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
            }
        } else {
            $this->db->delete('access_rights', array('admin_id' => $employee_id));
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
        return $this->db->select('(SELECT REPLACE(employee_picture, "./","") from employees_info where employee_id = as.admin_id) as picture')->where('session', $session)->get('admin_session as')->row()->picture;
    }

}
