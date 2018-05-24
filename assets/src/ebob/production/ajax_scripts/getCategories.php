<?php
require_once '../database/config.php';

$catId = $_POST["catId"];
$catType = $_POST["catType"];

if ($catType == "sub") {
	$sql = "SELECT sub_category_id, sub_category_name from sub_categories where main_category_id = ? order by sub_category_name";
}else if ($catType == "product") {
	$sql = "SELECT product_category_id, product_category_name from product_categories where sub_category_id = ? order by product_category_name";
}
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $catId);
$stmt->execute();
$stmt->bind_result($id, $name);
$categories = array();
while($stmt->fetch()){
	$categories[] = array(
		'id' => $id,
		'name' => $name
		);
}
echo json_encode($categories);
exit;
?>