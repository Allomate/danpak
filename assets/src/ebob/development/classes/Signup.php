<?php

require_once 'PushNotifications/RegisterDevice.php';

class Signup{

	function __construct($username, $email, $password, $gender, $phone, $address, $city, $country, $login_type, $token, $age){
		$this->username = $username;
		$this->email = $email;
		$this->password = $password;
		$this->gender = $gender;
		$this->phone = $phone;
		$this->address = $address;
		$this->city = $city;
		$this->country = $country;
		$this->type = $login_type;
		$this->firebaseToken = $token;
		$this->age = $age;
	}

	function saveUserDetails($conn){
		
		if(json_decode($this->fetchIfExisting($conn), true)["status"] == "failed"){
			die($this->fetchIfExisting($conn));
		}

		$sql = "INSERT INTO `users`(`user_name`, `user_email`, `user_password`, `user_age`, `user_gender`, `user_phone`, `user_address`, `user_city`, `user_country`, `user_login_type`, `user_active`, `created_at`, `modified_at`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $conn->prepare($sql);
		$active = 1;
		if($this->type == "web")
			$password = sha1($this->password);
		else
			$password = $this->password;
		$date = date('Y:m:d H:m:s');
		$stmt->bind_param('sssisssssssss',$this->username, $this->email, $password, $this->age, $this->gender, $this->phone, $this->address, $this->city, $this->country, $this->type, $active, $date, $date);
		if(!$stmt->execute()){
			$status = new ReturnStatus("failed","Signup",htmlspecialchars($stmt->error));
			$stmt->close();
			return $status->GetStatus();
		}else{
			$regDev = new RegisterDevice($this->firebaseToken, $this->email);
			$regDev->tokenizeDevice();
			$stmt->close();
			$status = new ReturnStatus("success","Signup","User signed up successfully");
			return $status->GetStatus();
		}
	}

	function fetchIfExisting($conn){
		$sql = "SELECT user_login_type from users where user_email = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('s', $this->email);
		$stmt->execute();
		$stmt->bind_result($lt);
		if($stmt->fetch()){
			$status = array(
				'status' => "failed",
				'type' => "Signup",
				'message' => "User Already Exist",
				'login_type' => $lt
				);
			$stmt->close();
			return json_encode($status);
		}else{
			$status = new ReturnStatus("success","Signup","User-DoNot-Exist");
			$stmt->close();
			return $status->GetStatus();
		}
	}

}

?>