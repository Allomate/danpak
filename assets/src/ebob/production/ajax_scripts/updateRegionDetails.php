<?php
require_once '../database/config.php';

$id = $_POST["id"];
$name = $_POST["name"];

$sql = "UPDATE company_regions set region_name = ? where region_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $name, $id);
if ($stmt->execute()) {
	echo "Success";
}else{
	echo htmlspecialchars($stmt->error);
}
$stmt->close();
die;
?>