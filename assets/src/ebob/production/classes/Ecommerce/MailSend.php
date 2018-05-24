<?php
require 'PHPMailer-master/PHPMailerAutoload.php';

class MailSend
{
	function __construct($to, $body, $subject)
	{
		$this->to = $to;
		$this->body = $body;
		$this->subject = $subject;
	}

	function sendEmail(){
		$mail = new PHPMailer;
		$mail->Host = 'gator4077.hostgator.com';
		$mail->isSMTP();
		$mail->SMTPAuth = true;
		$emailFrom = "support@shopatcarts.com";
		$mail->Username = "support@shopatcarts.com";
		$mail->Password = "support$@123";
		$mail->SMTPSecure = "ssl";
		$mail->Port = 465;
		$mail->Subject = $this->subject;
		$mail->Body = $this->body;
		$mail->IsHTML(true);
		$mail->setFrom($emailFrom, 'Ecommerce');
		$mail->addAddress($this->to);
		if($mail->send()){
			return "Success";
		}else{
			return $mail->ErrorInfo;
		}
	}
}
?>