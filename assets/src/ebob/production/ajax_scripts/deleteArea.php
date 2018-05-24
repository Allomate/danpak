<?php
require_once '../database/config.php';

$id = $_POST["id"];

$sql = "DELETE from company_areas where area_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
if ($stmt->execute()) {
	echo "Success";
}else{
	echo htmlspecialchars($stmt->error);
}
$stmt->close();
die;
?>