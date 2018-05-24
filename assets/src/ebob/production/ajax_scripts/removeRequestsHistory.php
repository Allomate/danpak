<?php

require_once '../database/config.php';
if (!isset($_POST["records"])) {
	die("Records not given to be deleted");
}
if ($_POST["records"] == "1") {
	$sql = "DELETE from location_inventory_requests where item_sent_from_warehouse = 1 and item_recieved = 1 and franchise_id IN (SELECT franchise_id from franchise_info where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)))";
}else if ($_POST["records"] == "all") {
	$sql = "DELETE from location_inventory_requests where franchise_id IN (SELECT franchise_id from franchise_info where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)))";	
}else if ($_POST["records"] == "0") {
	$sql = "DELETE from location_inventory_requests where item_sent_from_warehouse = 1 and item_recieved = 0 and franchise_id IN (SELECT franchise_id from franchise_info where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)))";
}
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $_COOKIE['US-K']);
if($stmt->execute()){
	echo "Deleted";
}
else
	die(htmlspecialchars($stmt->error));

exit;
?>