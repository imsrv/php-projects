<?
/////////////////////////////////////////////////////////
//	
//	include/session_close.MySQL.inc
//
//	(C)Copyright 2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
//
//	This file is part of IlohaMail, and released under GPL.
//	See COPYING, or http://www.fsf.org/copyleft/gpl.html
//
/////////////////////////////////////////////////////////
/********************************************************

	PURPOSE:
	PRE-CONDITIONS:
		This page is include'd in "source/login.php" which is loaded upon logout.
		Session should be closed, and any cached data (i.e. password) purged.
	COMMENTS:
		This file is for the default MySQL-based back-end.

********************************************************/

	// delete this session and any old unclosed ones
	include("../conf/mysqlrc.inc");
	
	//connect to db
	$conn = false;
	if ($mysql_persistent) $conn = mysql_pconnect($mysql_host, $mysql_user, $mysql_password);
	if (!$conn) $conn = mysql_connect($mysql_host, $mysql_user, $mysql_password);

	if ($conn){
		if (mysql_select_db($mysql_db)){
			$expTime = time() - (60 * 60 * 24); //close all session that are over 24 hours old
			$sql = "delete from $mysql_sessions where (sid = '$user') or (inTime < $expTime)";
			if (!mysql_query($sql)) echo "MySQL query failed: $sql <br>\n";
		}else{
			echo "MySQL DB Select failed.<br>\n";
		}
		//mysql_close($conn);
	}else{
		echo "MySQL DB connection failed.<br>\n";
	}
	

?>