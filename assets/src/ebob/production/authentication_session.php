<?php
if (!isset($_COOKIE["US-K"], $_COOKIE["US-LT"])) {
	header('Location: login.php');
	exit;
}
?>