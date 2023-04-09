<?php
/* Nullified by WDYL-WTN */
	require("../include/functions.php");
	
	session_start();
	session_destroy();
	redirect("index.php");
?>