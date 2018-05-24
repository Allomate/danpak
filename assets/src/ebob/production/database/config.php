<?php

$servername = "localhost";
$username = "allomate_admin";
$password = "123@321allomate";
$dbname = "allomate_pos";

	// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

?>