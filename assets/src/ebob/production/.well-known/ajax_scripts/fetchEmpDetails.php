<?php
require_once '../database/config.php';
$username = $_POST["username"];
$sql = "SELECT `employee_name`, `employee_address`, `employee_city`, `employee_country`, (SELECT group_concat((SELECT department_name from departments_info where department_id = edm.department_id)) FROM `employee_departments_mapping` edm where employee_id = ei.employee_id) as employee_departments, (SELECT group_concat(department_id) FROM `employee_departments_mapping` edm where employee_id = ei.employee_id) as employee_departments_id,(SELECT franchise_name from franchise_info where franchise_id = ei.franchise_id) as `franchise_id`, (SELECT company_name from company_info where company_id = ei.company_id) as `company_id`, (SELECT role_name from employee_roles where role_id = ei.employee_role_id) as `employee_role_id`, `employee_phone`, `created_at` FROM `employees_info` ei WHERE employee_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $username);
$stmt->execute();
$stmt->bind_result($name, $address, $city, $country, $depts, $deptsId, $franchise, $company, $role, $phone, $created);
$employeeDetails = array();
$department = null;
while($stmt->fetch()){
	$employeeDetails = array(
		'name'=>$name,
		'address'=>$address,
		'city'=>$city,
		'country'=>$country,
		'departments'=>$depts,
		'departments_id'=>$deptsId,
		'franchise'=>$franchise,
		'company'=>$company,
		'role'=>$role,
		'phone'=>$phone,
		'created'=>$created
		);
}

echo json_encode($employeeDetails);
exit;
?>