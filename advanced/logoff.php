<?php
/*********************************************************
			This Free Script was downloaded at			
			Free-php-Scripts.net (HelpPHP.net)			
	This script is produced under the LGPL license		
		Which is included with your download.			
	Not like you are going to read it, but it mostly	
	States that you are free to do whatever you want	
				With this script!						
*********************************************************/

session_start();
$_SESSION['adminin'] = NULL;

// End All Session ID'S
$_SESSION = array();
// KILL ALL SESSIONS
session_destroy();
//Rdirect User our
header("Location: login.php" );
exit();


?>
