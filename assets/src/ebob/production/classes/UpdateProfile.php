<?php

class UpdateProfile{

	function __construct($conn, $session, $email, $password, $gender, $phone, $address, $user_dp, $city, $country){
		$this->conn = $conn;
		$this->session = $session;
		$this->email = $email;
		$this->password = $password;
		$this->gender = $gender;
		$this->phone = $phone;
		$this->address = $address;
		$this->user_dp = $user_dp;
		$this->city = $city;
		$this->country = $country;
	}

	function updateProfile(){
		$date = date('Y:m:d H:m:s');
		if($this->password == ""){
			$sql = "UPDATE users set user_email = ?, user_gender = ?, user_phone = ?, user_address = ?, user_dp = ?, user_city= ?, user_country = ?, modified_at = ? where user_email = (SELECT user from user_session where session = ?)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param('sssssssss',$this->email, $this->gender, $this->phone, $this->address, $this->user_dp, $this->city, $this->country, $date, $this->session);
			if($stmt->execute()){
				$status = new ReturnStatus("success","update-profile","Profile updated successfully");
				return $status->GetStatus();
			}
		}else{
			$sql = "UPDATE users set user_email = ?, user_password = ?, user_gender = ?, user_phone = ?, user_address = ?, user_dp = ?, user_city= ?, user_country = ?, modified_at = ? where user_email = (SELECT user from user_session where session = ?)";
			$stmt = $this->conn->prepare($sql);
			$password = sha1($this->password);
			$stmt->bind_param('ssssssssss',$this->email, $password, $this->gender, $this->phone, $this->address, $this->user_dp, $this->city, $this->country, $date, $this->session);
			$stmt->execute();
			if($stmt->execute()){
				$status = new ReturnStatus("success","update-profile","Profile updated successfully");
				return $status->GetStatus();
			}
		}
	}

}

?>