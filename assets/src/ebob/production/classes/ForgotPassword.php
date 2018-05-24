<?php

require_once 'Secure.php';

class ForgotPassword{

	function __construct($user_email){
		$this->user_email = $user_email;
	}

	function recoverPassword($conn){
		$sql = "SELECT user_id from users where user_email = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('s', $this->user_email);
		$stmt->execute();
		$stmt->bind_result($user_id);
		$userId = 0;
		while ($stmt->fetch()) {
			$userId = $user_id;
			$stmt->close();
			$obj = new SecureToken();
			$recoveryToken = $obj->getToken(100);
			$sql = "INSERT INTO `forgot_password_recovery`(`token`, `user_id`) VALUES (?,?)";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('si', $recoveryToken, $userId);

			if ($stmt->execute()) {
				require_once 'Ecommerce/MailSend.php';
				$hostLink = "http://ecommerce.test";
				$emailBody = 'Please change your password by following this link: ' . $hostLink.'/password-recovery.php?recovery=' . $recoveryToken;
				$sendEmail = new MailSend($this->user_email, $emailBody, 'Recovery Password');
				if($sendEmail->sendEmail() != "Success"){
					return json_encode(array("Status"=>"Failed", "Preferences"=>$sendEmail->sendEmail()));
				}else{
					return json_encode(array("Status"=>"Success", "Preferences"=>'Email has been sent for password recovery. Please follow the link given in the email.'));
				}
			}
		}
	}
}

?>