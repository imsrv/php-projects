<?
/////////////////////////////////////////////////////////
//	
//	include/read_contacts.MySQL.inc
//
//	(C)Copyright 2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
//
//	This file is part of IlohaMail. IlohaMail is free software released 
//	under the GPL license.  See enclosed file COPYING for details, or 
//	see http://www.fsf.org/copyleft/gpl.html
//
/////////////////////////////////////////////////////////

/********************************************************

	PURPOSE:
		Read contact list, return array of associative arrays as $contacts
		Each record must contain at least 4 fields: id, name, email, group
	PRE-CONDITIONS:
		Assume session_auth.inc has been included at this point, and any variables
		initialized by said include may be assumed.
	POST-CONDITIONS:

********************************************************/

if (empty($sort_field)) $sort_field = "grp,name";
if (empty($sort_order)) $sort_order = "ASC";

	//connect to db
	$conn = false;
	if ($mysql_persistent) $conn = mysql_pconnect($mysql_host, $mysql_user, $mysql_password);
	if (!$conn) $conn = mysql_connect($mysql_host, $mysql_user, $mysql_password);

	if ($conn){
		if (mysql_select_db($mysql_db)){
			// get user id, if unspecified
            $mysql_userID = $session_dataID;
			if (!($mysql_userID>0)){
				$sql = "select id from $mysql_users where (login='$loginID') and (host='$host')";
				$r = mysql_query($sql);
				if ($r){
					$a = mysql_fetch_assoc($r);
					$mysql_userID = $a["id"];
				}else{
					$error.="MySQL error: Couldn't access users table <br>\n";
				}
			}
			
			if ($mysql_userID > 0){
				$sql = "SELECT * FROM $mysql_contacts WHERE owner='$mysql_userID' ORDER BY $sort_field $sort_order";
				$r = mysql_query($sql);
				if ($r){
					$num = mysql_num_rows($r);
					for ($i=0;$i<$num;$i++){
						$contacts[$i]=mysql_fetch_assoc($r);
					}
				}else{
					$error.="MySQL error: Couldn't access users table <br>\n";
				}
			}
		}else{
			$error .= "MySQL select DB failed. <br>\n";
		}
		//mysql_close($conn);
	}else{
		$error .= "MySQL connection failed. <br>\n";
	}
?>