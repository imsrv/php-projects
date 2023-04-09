<?
/********************************************************
	include/log.FS.inc
	
	(C)Copyright 2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html
	
	PURPOSE:
		Add log entry into MySQL log table.
	PRE-CONDITIONS:
		$log_time : date & time
		$log_timestamp : unix timestamp
		$log_ip : client IP address
		$log_account : User's account (user name @ host)
		$log_comment : error message or other comment

********************************************************/

include_once("../include/array2sql.inc");
include_once("../conf/mysqlrc.inc");

$backend_table = $mysql_log;
$backend_array = array(
	"logTime" => date("Y-m-d H:i:s", time()),
	"logTimeStamp" => $log_timestamp,
	"userID" => $dataID,
	"account" => $log_account,
	"action" => $log_action,
	"comment" => $log_comment,
	"ip" => $log_ip
);
$backend_operation = "INSERT";
$backend_dataID = $dataID;

include("../include/backend.MySQL.inc");


?>