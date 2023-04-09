<?
/////////////////////////////////////////////////////////
//	
//	include/session_auth.MySQL.inc
//
//	(C)Copyright 2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
//
//	This file is part of IlohaMail, and released under GPL.
//	See COPYING, or http://www.fsf.org/copyleft/gpl.html
//
/////////////////////////////////////////////////////////
/********************************************************

	PURPOSE:
		1.  Make sure session (pass as $user) is valid
		2.	Initialize $loginID variable, containing IMAP login ID.
		3.  Initialize $host variable, containing IMAP server name
		4.  Initialize $password variable, containing plain text password
		5.  Initialize $my_prefs variable, which should be an associated array containing user preferecnes
		6.  Initialize $my_colors variable, which should be an associated array containing user defined colors
	PRE-CONDITIONS:
		$user - Session ID
	POST-CONDITIONS:
	COMMENTS:
		All source files should include this file for session verification and user data initialization.
		This file uses a MySQL backend for session management.

********************************************************/

	include_once("../include/encryption.inc");
    
    //--------- MySQL Specific stuff -----------
    
	include_once("../conf/mysqlrc.inc");

    $my_prefs = false;
    $my_colors = false;
    
    $dataID = 0;

	//connect to database
	$conn = false;
	if ($mysql_persistent) $conn = mysql_pconnect($mysql_host, $mysql_user, $mysql_password);
	if (!$conn) $conn = mysql_connect($mysql_host, $mysql_user, $mysql_password);
	
	if ($conn){
		if (mysql_select_db($mysql_db)){
            //get session info
			$sql = "select * from $mysql_sessions where sid = '$user'";
			$r = mysql_query($sql);
			if (($r) && (mysql_num_rows($r)>0)){
				$a = mysql_fetch_assoc($r);
				$encLogin = $a["login"];
				$encPass = $a["password"];
				$encHost = $a["host"];
				$userPath = $a["path"];
                $dataID = $a["dataID"];
				$port = $a["port"];
                $lastSend = $a["lastSend"];
                $numSent = $a["numSent"];
                $session_dataID = $dataID;
			}else{
				echo "Invalid session ID: $user<br>\n";
			}
            
            //get prefs
            if ((!empty($mysql_prefs)) && ($dataID > 0)){
                $r = mysql_query("select * from $mysql_prefs where id='$dataID'");
                if (($r) && (mysql_num_rows($r)==1)) $my_prefs = mysql_fetch_assoc($r);
				if ($port==110) $my_prefs["list_folders"] = 0;
            }

            //get colors
            if ((!empty($mysql_colors)) && ($dataID > 0)){
                $r = mysql_query("select * from $mysql_colors where id='$dataID'");
                if (($r) && (mysql_num_rows($r)==1)) $my_colors = mysql_fetch_assoc($r);
            }
		}else{
			echo "MySQL select DB failed<br>\n";
		}
		//mysql_close($conn);
	}else{
		echo "MySQL connection failed<br>\n";
	}
    
    //--------- END MySQL Specific stuff -----------

	// Turn IP into encryption key
	$ip = $_SERVER["REMOTE_ADDR"];
	$ipkey="";
	$ip_a = explode(".", $ip);
	for ($i=3; $i>=0; $i--) $ipkey.=$ip_a[$i];
	
	$loginID = DecodeMessage($ipkey, $encLogin);
	$password = DecodeMessage($ipkey, $encPass);
	$host = DecodeMessage($ipkey, $encHost);

    // If we're using FS backend for some things, check that out too
    if (!empty($userPath)){
        // Find path to user dir
        $userPath = DecodeMessage($ipkey, $userPath);

        // Read prefs and colors
        if (!$my_colors) include_once($userPath."/colors.inc");
        if (!$my_prefs) include_once($userPath."/prefs.inc");
	
    }
    
    $my_charset=$my_prefs["charset"];
    
    if (($dataID==0)&&(!$do_not_die)){
    	exit;
    }
?>
