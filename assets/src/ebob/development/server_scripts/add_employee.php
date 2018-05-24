<?php

require_once '../database/config.php';

$empUn = $_POST["empUn"];
$empName = $_POST["empName"];

$sql = "SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $_COOKIE["US-K"]);
$stmt->execute();
$stmt->bind_result($company_id);
while ($stmt->fetch()) {
	$companyId = $company_id;
}
$stmt->close();
$empRole = $_POST["empRole"];
$reportingTo = $_POST["reporting_to"];
$franchiseId = "";
if($empRole != "2")
	$franchiseId = $_POST["franchiseId"];
$empCity = $_POST["empCity"];
$empAddress = $_POST["empAddress"];
$empPhone = $_POST["empPhone"];
$empPw = sha1($_POST["empPw"]);
$empSalary = $_POST["empSalary"];
$empHireAt = date("Y-m-d", strtotime($_POST["hireDate"]));
$empCnic = $_POST["empCnic"];
$departmentsList = array();

$empImage = "";
if(isset($_FILES["empImage"])){
	$target_dir = "../uploads/emp_dp/";
	$empImage = $target_dir . (time()+1000 . "-" . "{$_FILES['empImage'] ['name']}");
	move_uploaded_file ($_FILES['empImage'] ['tmp_name'], $empImage);
}

$sql = "INSERT INTO `employees_info`(`employee_name`, `employee_username`, `employee_password`, `employee_address`, `employee_city`, `employee_picture`, `franchise_id`, `company_id`, `reporting_to`, `employee_cnic`, `employee_hire_at`, `employee_role_id`, `employee_phone`, `employee_salary`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssssssiisssiss', $empName, $empUn, $empPw, $empAddress, $empCity, $empImage, $franchiseId, $companyId, $reportingTo, $empCnic, $empHireAt, $empRole, $empPhone, $empSalary);
$latestId = 0;
if($stmt->execute()){
	$latestId = $conn->insert_id;
	$stmt->close();
}
else
	die(htmlspecialchars($stmt->error));

if(!empty($_POST['department_list'])) {
	foreach($_POST['department_list'] as $check) {
		$sql = "INSERT INTO `employee_departments_mapping` (`employee_id`, `department_id`) VALUES (?,?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('ii', $latestId, $check);
		$stmt->execute();
		$stmt->close();
	}
}

$sql = "INSERT INTO `access_rights` (`employee_id`) VALUES (?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $latestId);
$stmt->execute();

$hostLink = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
header('Location: '.$hostLink.'/add_employee.php');

exit;
?>