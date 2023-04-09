<?php

	ob_start();

	error_reporting(0);

	require_once("../mwadmin/conf.php");

	require_once("../mwadmin/includes/functions.php");

	doDbConnect();

	$email = @$_GET['email'];
	$iID = @$_GET['i'];
	$r = @$_GET['r'];

	if($email != '' && is_numeric($iID) && $r == 1)

	{

		//details have been set correctly

		$cResult = mysql_query("SELECT count(*) FROM {$dbPrefix}_track WHERE tEmail = '$email' AND tIId = '$iID'");

		if(mysql_result($cResult, 0, 0) == 0)

		{

			//they have not been tracked yet

			mysql_query("INSERT INTO {$dbPrefix}_track (`tEmail`, `tIId`, `tDate`) VALUES ('$email', '$iID', now())");


		}

	}

	header("Cache-control: private"); 

	//header('Content-Type: image/gif');

	header("Content-Disposition: inline; filename=image.gif");

	echo readfile("track.gif");

	ob_end_flush();

?>