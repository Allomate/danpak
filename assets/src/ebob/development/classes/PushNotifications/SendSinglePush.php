<?php 

require_once 'DbOperation.php';
require_once 'Firebase.php';
require_once 'Push.php';

class SendNotification{

	function __construct($title, $message, $image, $email, $complain, $rewards, $discounts){
		$this->title = $title;
		$this->message = $message;
		$this->image = $image;
		$this->email = $email;
		$this->complainId = $complain;
		$this->rewards = $rewards;
		$this->discounts = $discounts;
	}

	function SendNow(){

		$db = new DbOperation();

		$push = null; 
		
		$push = new Push($this->title, $this->message, $this->image, $this->complainId, $this->rewards, $this->discounts);

		$mPushNotification = $push->getPush(); 

		$devicetoken = $db->getTokenByEmail($this->email);

		$firebase = new Firebase(); 

		return $devicetoken;

	}

}

?>