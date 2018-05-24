<?php
require_once '../database/config.php';
$code = $_POST["code"];
$sql = "SELECT warehouse_name, warehouse_location from warehouse where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)) and warehouse_code = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $_COOKIE["US-K"], $code);
$stmt->execute();
$stmt->bind_result($name, $loc);
$headsTotals = array();
while($stmt->fetch()){
	$headsTotals[] = array(
		'name' => $name,
		'location' => $loc
		);
}
echo json_encode($headsTotals);
exit;
?>