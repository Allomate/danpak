<?php
require_once '../database/config.php';

$id = $_POST["id"];
$name = $_POST["name"];

$sql = "UPDATE company_areas set area_name = ? where area_id = ?";
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