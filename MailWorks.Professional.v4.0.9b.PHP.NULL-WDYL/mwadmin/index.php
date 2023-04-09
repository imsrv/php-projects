<?php

	ob_start();

	$currentVer = "4.0.9b";

	$title = "MailWorks Professional Administration Area";

	include("templates/top.php");
 	include_once("includes/functions.php");


	$auth = @$_COOKIE["auth"] == 1 ? true : false;

	// Amend the version number in a patch

	if($mwp_ver != $currentVer) {

		// rebuild the configuration file

		if($fileHandle = @fopen('conf.php', 'r')) {

			$data = '';

			while(!@feof($fileHandle)) {

				$data .= fgets($fileHandle, 1024);

			}

			// now find the line we need to change

			if(!empty($data)) {

				$data = str_replace($mwp_ver, $currentVer, $data);

				// now save the data

				$fileHandle = @fopen('conf.php', 'w');

				$write = fwrite($fileHandle, $data);

			} else {

				echo "<b>Unable to update config file. Please check your permissions on conf.php</b>";

			}

			fclose($fileHandle);

		}

	}

	// Display the page header

	if(!isLoggedIn()) {

		//header("location: login.php");

	} else {

		$content  = "You are currently logged in to the MailWorksPro admin area. Please choose an option from the menu down the left side of the page to get started.";
		$content .= "<br><br><a href='login.php?what=logout'>Logout >></a>";

	}

	MakeMsgPage('MailWorks Professional Admin Area', $content);

	include("templates/bottom.php");

?>