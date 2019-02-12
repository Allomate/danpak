<?php
require 'PHPMailer-master/PHPMailerAutoload.php';

class MailSend
{
	function __construct($body, $attachment, $subject)
	{
		$this->body = $body;
		$this->attachment = $attachment;
		$this->subject = $subject;
	}

	function sendEmail(){
		$mail = new PHPMailer;
		$mail->Host = 'smtp.gmail.com';
		$mail->isSMTP();
		$mail->SMTPAuth = true;
		$emailFrom = "allomate.solutions@gmail.com";
		$mail->Username = "allomate.solutions@gmail.com";
		$mail->Password = "Allo1234";
		$mail->SMTPSecure = "SSL";
		$mail->Port = 587;
		$mail->Subject = $this->subject;
		$mail->Body = $this->body;
		$mail->addAttachment($this->attachment);
		$mail->IsHTML(true);
		$mail->setFrom($emailFrom, 'Danpak Backup');
		$mail->addAddress("junaid.qureshi@allomate.com");
		if($mail->send()){
			return "Success";
		}else{
			return $mail->ErrorInfo;
		}
	}
}
?>
