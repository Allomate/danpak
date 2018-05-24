<?php

header('Content-Type: application/json');

require_once '../database/config.php';
require_once '../classes/Status.php';
require_once '../classes/Authenticate-Session.php';
require_once '../classes/ForgotPassword.php';
require_once 'validate_api.php';

$pwRecovery = new ForgotPassword($_POST['user_email']);
echo $pwRecovery->recoverPassword($conn);
die;

?>