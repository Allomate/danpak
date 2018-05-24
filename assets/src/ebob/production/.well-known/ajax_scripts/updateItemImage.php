<?php

require_once '../database/config.php';

$itemImage = '../uploads/item_images/' . (time()+1000) .	 "-" . preg_replace('/\s+/', '_', $_FILES['itemImage']['name']);
move_uploaded_file ($_FILES['itemImage'] ['tmp_name'], $itemImage);

$sql = "SELECT item_image from warehouse_inventory where item_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $_POST["itemId"]);
$stmt->execute();
$stmt->bind_result($existingImg);
if ($stmt->fetch()) {
	if (file_exists($existingImg)) {
		unlink($existingImg);
	}
}
$stmt->close();

$sql = "UPDATE `warehouse_inventory` SET `item_image`= ? WHERE item_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $itemImage, $_POST["itemId"]);
if($stmt->execute()){
	echo "Success";
}
else
	die(htmlspecialchars($stmt->error));
$stmt->close();
exit;
?>