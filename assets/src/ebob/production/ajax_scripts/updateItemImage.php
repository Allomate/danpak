<?php

require_once '../database/config.php';

$totalImages = count($_FILES['itemImage']['name']);
$imagesUploaded = '';
$target_dir = '../uploads/item_images/';
for($i=0; $i<$totalImages; $i++) {
	$tmpFilePath = $_FILES['itemImage']['tmp_name'][$i];
	if ($tmpFilePath != ""){
		$newFilePath = $target_dir . time() . "-" . preg_replace('/\s+/', '_', $_FILES['itemImage']['name'][$i]);
		if(move_uploaded_file($tmpFilePath, $newFilePath)) {
			if($i == 0){
				$imagesUploaded = $newFilePath;
			}else{
				$imagesUploaded .= "," . $newFilePath;
			}
		}
	}
}

$sql = "SELECT item_image from warehouse_inventory where item_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $_POST["itemId"]);
$stmt->execute();
$stmt->bind_result($existingImgs);
$alreadyImgs = '';
while ($stmt->fetch()) {
	$alreadyImgs = $existingImgs;
}
$stmt->close();

if ($alreadyImgs != '') {
	$imagesUploaded = $imagesUploaded . "," . $alreadyImgs;
}

$sql = "UPDATE `warehouse_inventory` SET `item_image`= ? WHERE item_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $imagesUploaded, $_POST["itemId"]);
if($stmt->execute()){
	echo "Success";
}
else
	die(htmlspecialchars($stmt->error));
$stmt->close();
exit;
?>