<?php

header('Content-Type: application/json');

require_once '../database/config.php';
require_once '../classes/Secure.php';
require_once '../classes/Status.php';
require_once 'validate_api.php';

if(!isset($_POST["login_type"])){
	$status = new ReturnStatus("failed","login","Provide Login type");
	die($status->GetStatus());
}

$email = "";
$password = "";
$sql = "";

if($_POST["login_type"] == "web"){
	if(!isset($_POST["email"]) || !isset($_POST["password"])){
		$status = new ReturnStatus("failed","login","Provide email/password");
		die($status->GetStatus());
	}
	$email = mysqli_real_escape_string($conn, $_POST["email"]);
	$password = mysqli_real_escape_string($conn, sha1($_POST["password"]));
	$sql = "select * from users where user_email = ? and user_password = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('ss',$email, $password);
	$stmt->execute();
	if(!$stmt->fetch()){
		$status = new ReturnStatus("failed","login","Login Failed");
		echo $status->GetStatus();
		exit;
	}

}else{
	if(!isset($_POST["email"])){
		$status = new ReturnStatus("failed","login","Provide email");
		die($status->GetStatus());
	}
	$email = mysqli_real_escape_string($conn, $_POST["email"]);
	$sql = "select * from users where user_email = ? and user_password = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('ss',$email, $password);
	$stmt->execute();
	if(!$stmt->fetch()){
		$status = new ReturnStatus("failed","login","Login Failed");
		echo $status->GetStatus();
		exit;
	}

}

$stmt->close();

$obj = new SecureToken();
$sessKey = $obj->getToken(50);
$expiry = date('Y:m:d H:m:s');

$deleteSess = "DELETE FROM user_session WHERE user = ?";
$stmt = $conn->prepare($deleteSess);
$stmt->bind_param('s', $email);
$stmt->execute();

$stmt->close();

$sessionKey = "INSERT into user_session (user, session, expiry) values(?,?,?)";
$stmt = $conn->prepare($sessionKey);

$stmt->bind_param('sss', $email, $sessKey, $expiry);

$stmt->execute();

$stmt->close();
$status = array(
	'status' => "success",
	'type' => "login",
	'session' => $sessKey
	);

echo json_encode($status);

exit;

?>