<?php

class Profile{

	function __construct($conn, $session){
		$this->conn = $conn;
		$this->session = $session;
	}

	function getProfile(){
		$sql = "SELECT `user_id`, `user_name`, `user_email`, `user_gender`, `user_phone`, `user_address`, `user_dp`, `user_city`, `user_country`, `user_login_type`, `created_at` FROM `users` WHERE user_email = (SELECT user from user_session where session = ?)";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param('s', $this->session);
		$stmt->execute();
		$stmt->bind_result($user_id, $user_name, $user_email, $user_gender, $user_phone, $user_address, $user_dp, $user_city, $user_country, $user_login_type, $created_at);
		while($stmt->fetch()){
			$profile = array(
				'user_id' => $user_id,
				'user_name' => $user_name,
				'user_email' => $user_email,
				'user_gender' => $user_gender,
				'user_phone' => $user_phone,
				'user_address' => $user_address,
				'user_dp' => $user_dp,
				'user_city' => $user_city,
				'user_country' => $user_country,
				'user_login_type' => $user_login_type,
				'created_at' => $created_at
				);
		}
		return json_encode($profile);
	}

}

?>