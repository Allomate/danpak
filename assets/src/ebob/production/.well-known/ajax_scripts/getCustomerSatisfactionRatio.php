<?php
require_once '../database/config.php';
$companyId = $_POST["companyId"];
$sql = "SELECT sum(user_rating)/count(user_rating) FROM `complains` where company_id = ? and complain_status = 'resolved'
and user_rating is NOT NULL";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $companyId);
$stmt->execute();
$stmt->bind_result($satisfactionRatio);
$stmt->fetch();
echo $satisfactionRatio;
$stmt->close();
exit;
?>