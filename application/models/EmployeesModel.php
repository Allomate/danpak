<?php

class EmployeesModel extends CI_Model{

	public function get_employees_list(){
		return $this->db->select('employee_id, employee_username, employee_first_name, employee_last_name, (SELECT employee_username from employees_info where employee_id = ei.reporting_to) reporting_to')->get("employees_info ei")->result();
	}

	public function add_employee($employee){
		return $this->db->insert('employees_info', $employee);
	}

	public function get_single_employee($employee_id){
		return $this->db->where('employee_id', $employee_id)->get("employees_info")->row();
	}

	public function getDailyRouteData(){
		return $this->db->select('(SELECT employee_username from employees_info where employee_id = ed.employee_id) as employee_username, DATE(routing_day) as route_date, employee_id')->group_by('DATE(routing_day)')->get('employee_daily_routing ed')->result();
	}

	public function GetLatLongsForDailyRouting($routeData){
		return $this->db->select('route_lats, route_longs')->where('DATE(routing_day) = "'.$routeData["curr_date"].'" and employee_id = '.$routeData['employee_id'])->get('employee_daily_routing')->result();
	}

	public function GetAttendanceData(){
		$totalAttendanceDates = $this->db->select('DATE(created_at) as ams_date')->group_by('DATE(created_at)')->get('ams')->result();
		$attendanceData = array();
		foreach ($totalAttendanceDates as $dates) {

			$attendanceData[] = array('date'=>$dates->ams_date, 'data'=>$this->db->select('CONCAT(employee_first_name, " ", employee_last_name) as employee_name, (SELECT territory_name from territory_management where id = ei.territory_id) as territory, (SELECT area_name from area_management where id = ((SELECT area_id from territory_management where id = ei.territory_id))) as area, (SELECT region_name from regions_info where id = (SELECT region_id from area_management where id = ((SELECT area_id from territory_management where id = ei.territory_id)))) as region, (SELECT IFNULL((SELECT DATE_FORMAT(DATE_ADD(created_at, INTERVAL 9 HOUR), "%h:%i %p") from ams where DATE(created_at) = "'.$dates->ams_date.'" and employee_id = ei.employee_id and checking_status = 1), "Not checked in")) as check_in_time, (SELECT latitude from ams where DATE(created_at) = "'.$dates->ams_date.'" and employee_id = ei.employee_id and checking_status = 1) as check_in_lat, (SELECT longitude from ams where DATE(created_at) = "'.$dates->ams_date.'" and employee_id = ei.employee_id and checking_status = 1) as check_in_long, (SELECT IFNULL((SELECT DATE_FORMAT(DATE_ADD(created_at, INTERVAL 9 HOUR), "%h:%i %p") from ams where DATE(created_at) = "'.$dates->ams_date.'" and employee_id = ei.employee_id and checking_status = 0), "Not checked out")) as check_out_time, (SELECT IFNULL((SELECT CASE WHEN within_radius = 0 THEN "No" ELSE "Yes" END from ams where DATE(created_at) = "'.$dates->ams_date.'" and employee_id = ei.employee_id and checking_status = 1),"Not marked")) as within_radius, employee_base_station_lats, employee_base_station_longs')->get('employees_info ei')->result());
		}
		return $attendanceData;
	}

	public function AttendanceStats(){
		$stats = array("present_today"=>$this->db->select('count(employee_id) as present_today')->where('DATE(created_at) = CURDATE() and checking_status = 1')->get('ams')->row()->present_today, "absent_today"=>$this->db->select('count(employee_id) as absent_today')->where('employee_id NOT IN (SELECT employee_id from ams where checking_status = 1 and DATE(created_at) = CURDATE())')->get('employees_info ei')->row()->absent_today, "location_compliance"=>$this->db->select('count(employee_id) as location_compliance')->where('within_radius = 1 and checking_status = 1 and DATE(created_at) = CURDATE()')->get('ams')->row()->location_compliance, "none_compliance"=>$this->db->select('count(employee_id) as none_compliance')->where('within_radius = 0 and checking_status = 1 and DATE(created_at) = CURDATE()')->get('ams')->row()->none_compliance);
		return $stats;
	}

	public function update_employee($employee_id, $employee){
		if (isset($employee['employee_picture']) || $employee['picture_deleted'] == 'deleted') {
			$employee_picture = $this->db->select('REPLACE(employee_picture,"./","") as employee_picture')->where('employee_id', $employee_id)->get('employees_info')->row()->employee_picture;
			if ($employee_picture) {
				$employee_picture = FCPATH.$employee_picture;
				if (file_exists($employee_picture)) {
					unlink($employee_picture);
				}
			}
			unset($employee['picture_deleted']);
			if (!isset($employee['employee_picture'])) {
				$employee['employee_picture'] = '';
			}
		}else if(!isset($employee['employee_picture']) && $employee['picture_deleted'] == 'deleted'){
			$employee['employee_picture'] = '';
			unset($employee['picture_deleted']);
		}else{
			unset($employee['picture_deleted']);
		}
		return $this->db
		->where('employee_id',$employee_id)	
		->update('employees_info', $employee);
	}

	public function delete_employee($employee_id){
		return $this->db->delete('employees_info', array('employee_id' => $employee_id)); 
	}

}

?>