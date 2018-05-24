<?php

require_once 'SendSinglePush.php';

$sn = new SendNotification($_POST["title"], $_POST["message"], null, $_POST["email"]);
echo $sn->SendNow();
?>