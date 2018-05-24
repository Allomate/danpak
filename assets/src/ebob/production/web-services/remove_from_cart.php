<?php

header('Content-Type: application/json');

require_once '../database/config.php';
require_once '../classes/Status.php';
require_once 'validate_api.php';
require_once '../classes/RemoveFromCart.php';

if(!isset($_POST['cart_id'])){
	$status = new ReturnStatus("failed","missing-information","Please provide cart_id");
	die($status->GetStatus());
}

$removeFromCart = new RemoveCart($conn, $_POST["cart_id"]);
echo $removeFromCart->removeItemsFromCart();

?>