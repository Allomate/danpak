<?php

require_once '../database/config.php';

$pages = $_POST["permission_pages"];
$employee_id = $_POST["employee_id"];

$sql = "UPDATE `access_rights` set ".$pages." where employee_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $employee_id);
if($stmt->execute()){
	echo "Updated";
}
else
	die(htmlspecialchars($stmt->error));

exit;
?>