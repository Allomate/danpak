<?php

$servername = "localhost";
$username = "junaid";
$password = "Snakebite76253";
$dbname = "allomate_danpak";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

?>
