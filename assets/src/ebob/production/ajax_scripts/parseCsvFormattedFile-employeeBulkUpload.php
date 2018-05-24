<?php

$uploadedFileName = $_FILES["csvSheet"]["name"];
$fileType = $_FILES["csvSheet"]["type"];
$fileSize = $_FILES["csvSheet"]["size"] / 1024;

if ($fileType != "application/vnd.ms-excel") {
	die("filetype");
}

$tmpName = $_FILES["csvSheet"]["tmp_name"];
$csvAsArray = array_map('str_getcsv', file($tmpName));
if ($csvAsArray[0][0] == "Employee Name" && $csvAsArray[0][1] == "Employee Username") {
	unset($csvAsArray[0]);
}
$csvAsArray = array_values($csvAsArray);
$errorsThrown = array();
$createdAt = date('Y:m:d H:m:s');
foreach ($csvAsArray as $value) {
	$employee_name = $value[0];
	$employee_username = $value[1];
	$employee_password = sha1($value[2]);
	$employee_address = $value[3];
	$employee_city = $value[4];
	$employee_country = $value[5];
	$reporting_to = $value[6];
	
	require '../database/config.php';
	$sql = "SELECT employee_id, company_id from employees_info where employee_username = ?";
	$stmt = $conn->prepare($sql);
	$employee_details = array();
	$stmt->bind_param('s', $reporting_to);
	$stmt->execute();
	$stmt->bind_result($empId, $companyId);

	while ($stmt->fetch()) {
		$employee_details[] = array(
			'employee_id' => $empId,
			'company_id' => $companyId
		);
	}

	$stmt->close();

	if (sizeof($employee_details) <= 0) {
		$errorsThrown[] = array(
			'employee_username'=> $employee_username,
			'error'=> 'Unknown reporting to: ' . $reporting_to
		);
		continue;
	}
	
	$employee_cnic = $value[7];
	$employee_hire_at = $value[8];
	$employee_phone = $value[9];
	$employee_salary = $value[10];

	if (!is_numeric($employee_salary) == 1) {
		$errorsThrown[] = array(
			'employee_username'=> $employee_username,
			'error'=> 'Salary needs to be numeric ('.$employee_salary.')'
		);
		continue;
	}

	if (!is_numeric($employee_phone) == 1) {
		$errorsThrown[] = array(
			'employee_username'=> $employee_username,
			'error'=> 'Phone needs to be numeric ('.$employee_phone.')'
		);
		continue;
	}

	$sql = "SELECT employee_id from employees_info where employee_username = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('s', $employee_username);
	$stmt->execute();
	$stmt->bind_result($empId);
	if ($stmt->fetch()) {
		$errorsThrown[] = array(
			'employee_username'=> $employee_username,
			'error'=> 'Username already exist'
		);
		continue;
	}
	$stmt->close();

	$sql = "INSERT INTO `employees_info`(`employee_name`, `employee_username`, `employee_password`, `employee_address`, `employee_city`, `employee_country`, `company_id`, `reporting_to`, `employee_cnic`, `employee_hire_at`, `employee_phone`, `employee_salary`, `created_at`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('sssssssssssis', $employee_name, $employee_username, $employee_password, $employee_address, $employee_city, $employee_country, $employee_details[0]['company_id'], $employee_details[0]['employee_id'], $employee_cnic, $employee_hire_at, $employee_phone, $employee_salary	, $createdAt);
	if (!$stmt->execute()) {
		$errorsThrown[] = array(
			'employee_username'=> $employee_username,
			'error'=> htmlspecialchars($stmt->error)
		);
		$stmt->close();
	}else{
		$latestId = $conn->insert_id;
		$stmt->close();
		$sql = "INSERT INTO `access_rights` (`employee_id`) VALUES (?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('i', $latestId);
		$stmt->execute();
	}
}
die(json_encode($errorsThrown));
?>