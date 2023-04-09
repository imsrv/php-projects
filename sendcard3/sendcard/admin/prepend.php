<?php
error_reporting(E_ALL & ~E_NOTICE);
include("config.php");

	session_start();
	if(!isset($session["password"]) || $session["password"] != ADMIN_PASSWORD) {
		header("Location: login.php?redirect=" . basename($PHP_SELF));
	}

?>