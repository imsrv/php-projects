<?
/********************************************************
	include/log.inc
	
	(C)Copyright 2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html
	
	PURPOSE:
		Shell for log.backend.inc

********************************************************/

include_once("../conf/conf.inc");

if ($log_active){
	if (empty($log_backend))
		$log_backend = $backend;
	if ($log_backend == "MySQL"){
		include_once("../conf/mysqlrc.inc");
		if ((!isset($mysql_log)) || (empty($mysql_log))) $log_backend = "FS";
	}
	if (($log_backend =="FS")&&(empty($log_file))) $log_backend ="";

	if (!empty($log_backend)){
		if (!empty($log_action)){
			$log_time = date("M d Y H:i:s", time());
			$log_timestamp = time();
			$log_ip = $_SERVER["REMOTE_ADDR"];
			$log_account = $user_name."@".$host;
			$log_comment = $log_comment.$error;

			include("../include/log.".$log_backend.".inc");
		}
	}
}
?>