<?php
require '../database/config.php';

$created_at = date('Y:m:d H:i:s');

$sql = "INSERT INTO `loyalty_program`(`program_name`, `points_name_singular`, `points_name_plural`, `amount_customer_spent`, `points_amount_spent`, `points_monetary_value`, `eligibility_criteria`, `condition_weeks`, `company_id`, `created_at`) VALUES (?,?,?,?,?,?,?,?,(SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)),?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssiiisiss', $_POST['program_name'], $_POST["point_name_singular"], $_POST["point_name_plural"], $_POST["amount_customer_spent"], $_POST["point_every_amount_spent"], $_POST["monetory_value"], $_POST["eligibility_criteria"],$_POST["condition_to_redeem_reward_points"], $_COOKIE["US-K"], $created_at);
if ($stmt->execute()) {
	$stmt->close();

	$tierLevel = "1";

	if ($_POST["tier_2_name"] != '') {
		$tierLevel = "2";
	}

	if ($_POST["tier_3_name"] != '') {
		$tierLevel = "3";
	}
	
	$sql = "INSERT INTO `loyalty_tiers`(`tier_1_name`, `tier_1_period`, `tier_2_name`, `tier_2_period`, `tier_3_name`, `tier_3_period`, `tier_level`, `company_id`, `created_at`) VALUES (?,?,?,?,?,?,?,(SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)),?)";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('sisisiiss', $_POST["tier_1_name"], $_POST["tier_1_period"], $_POST["tier_2_name"], $_POST["tier_2_period"], $_POST["tier_3_name"], $_POST["tier_3_period"], $tierLevel, $_COOKIE["US-K"], $created_at);
	if (!$stmt->execute()) {
		echo htmlspecialchars("Line#26: " . $stmt->error);
		$stmt->close();
		die;
	}
	echo "Success";
	$stmt->close();
	die;
}else{
	echo htmlspecialchars($stmt->error);
	$stmt->close();
}
die;
?>