<?php

require_once '../database/config.php';
require_once '../classes/PushNotifications/SendSinglePush.php';

$resolutionComments = $_POST["resolutionComments"];
$complainId = $_POST["complainId"];
$reward = $_POST["reward"];
$discount = $_POST["discount"];
$product = $_POST["product"];
$isDeal = $_POST["deal"];
$complainStatus = "";
$email = "";
$userId = "";
$companyId = "";

$sql = "SELECT complain_status, (SELECT user_email from users where user_id = (SELECT user_id from complains where complain_id = ?)), (SELECT user_id from complains where complain_id = ?), 
(SELECT company_id from complains where complain_id = ?) from complains where complain_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('iiii', $complainId, $complainId, $complainId, $complainId);
$stmt->execute();
$stmt->bind_result($complain_status, $email, $user_id, $company_id);
while($stmt->fetch()){
	$complainStatus = $complain_status;
	$email = $email;
	$userId = $user_id;
	$companyId = $company_id;
}
$stmt->close();
    
if($complainStatus == "resolved"){
	die("Already resolved");
}

$sql = "UPDATE complains set employee_comments = ?, tad_time_close = ?, complain_status = 'resolved', employee_id = (SELECT employee_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)) where complain_id = ?";
$stmt = $conn->prepare($sql);
$tadTimeClose = date("Y-m-d H:i:s");
$stmt->bind_param('sssi', $resolutionComments, $tadTimeClose, $_COOKIE["US-K"], $complainId);
if($stmt->execute()){
	$stmt->close();
}
else{
	die(htmlspecialchars($stmt->error));
	$stmt->close();
}

if($isDeal){

	if($reward == "")
		$reward = 0;
	
	if($discount == "")
		$discount = 0;
		
	$sql = "INSERT INTO `counter_deals`(`company_id`, `employee_id`, `user_id`, `complain_id`, `discount`, `reward_points`, `product_id`) VALUES ((SELECT company_id from complains where complain_id = ?),(SELECT employee_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)),(SELECT user_id from complains where complain_id = ?),?,?,?,?)";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('isiiiis', $complainId, $_COOKIE["US-K"], $complainId, $complainId, $discount, $reward, $product);
	if(!$stmt->execute())
		die(htmlspecialchars($stmt->error));
	$stmt->close();
	
    $sn = new SendNotification("Resolved", $resolutionComments, null, $email, $complainId, $reward, $discount, "123");
    $sn->SendNow();
	
}else{
	$sn = new SendNotification("Resolved", $resolutionComments, null, $email, $complainId, 0, 0);
	$sn->SendNow();
}

exit;
?>