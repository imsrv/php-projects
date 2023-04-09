<?
/********************************************************
	include/as_update.MySQL.inc
	
	(C)2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html
	
	PURPOSE:
        Update session table with latest send operation.

********************************************************/

include_once("../conf/mysqlrc.inc");

$backend_table = $mysql_sessions;
$backend_operation = "UPDATE";
$backend_array = array(
                "lastSend" => time(),
                "numSent" => $numSent + $num_recepients
                );
$backend_where = "sid='$sid'";

include("../include/backend.MySQL.inc");

?>