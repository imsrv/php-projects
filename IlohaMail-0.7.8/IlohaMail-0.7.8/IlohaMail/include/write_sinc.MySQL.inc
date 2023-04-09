<?
/////////////////////////////////////////////////////////
//	
//	include/write_sinc.inc
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
		1.  Generate session ID
		2.  Initialize session
	PRE-CONDITIONS:
		$user_name - User name
		$host - IMAP server
	POST-CONDITIONS:
		$user - Session ID
        $new_user - true if new user, else false
		session info is stored in MySQL database
        prefs and colors stored in backend (MySQL or FS)
	COMMENTS:
        Should be possible to add support for other SQL DB backends (Postgres, Oracle) by
        replacing mysql_* functions with their equivalent functions.
	NOTE:
        In conf/mysqlrc.inc
        ...assumes the following tables are present:
            $mysql_users
            $mysql_sessions
        ...following are optional:
            $mysql_prefs
            $mysql_colors
        If $mysql_prefs or $mysql_colors is empty, a file based backend is used.

********************************************************/

function GetPrefsFolder($user, $host){
	$result=false;
	$path="../users/".$user.".".$host;
	if (file_exists($path)){
		$result=$path;
	}else{
		if (mkdir($path, 0700)) $result=$path;
	}
	return $result;
}

function GetSettings($result, $file){
	$lines = file($file);
	if (is_array($lines)){
                while ( list($k, $line) = each($lines) ){
			list($key, $val) = explode(":", $line);
			$result[$key] = base64_decode($val);
		}
	}else{
		$result=false;
	}
	
	return $result;
}

    include_once("../include/array2php.inc");
	include_once("../conf/mysqlrc.inc");
    include_once("../include/array2sql.inc");
    
    // initialize some vars
    $prefs_saved = false;
    $colors_saved = false;
    $new_user = false;

    // we only need user dirs if contacts, prefs, or colors table aren't specified
    if ((empty($mysql_contacts)) || (empty($mysql_prefs)) || (empty($mysql_colors))){
        //if needed, look for a path, or create one
        $path=GetPrefsFolder($user_name, $host);
    }

    // create session ID
    if (!isset($session)){
        srand ((double) microtime() * 1000000);
        $session=time()."-".rand(10000,99999);
        $user=$session;	
    }
    
    // generate random session key
    $key=GenerateMessage(strlen($password)+5);
        
    // Turn IP into encryption key
    $ip = $_SERVER["REMOTE_ADDR"];
    $ipkey="";
    $ip_a = explode(".", $ip);
    for ($i=3; $i>=0; $i--) $ipkey.=$ip_a[$i];
    
    // encrypt login ID, host, and passwords
    $encpass = EncryptMessage($ipkey, $password);
    $encHost = EncryptMessage($ipkey, $host);
    $encUser = EncryptMessage($ipkey, $user_name);
    if (!empty($path)) $encPath = EncryptMessage($ipkey, $path);

	// MySQL stuff
	//connect to db
	$conn = false;
	if ($mysql_persistent) $conn = mysql_pconnect($mysql_host, $mysql_user, $mysql_password);
	if (!$conn) $conn = mysql_connect($mysql_host, $mysql_user, $mysql_password);

	if ($conn){
        echo "<!-- Connected to DB -->"; flush();
		if (mysql_select_db($mysql_db)){
            echo "<!-- Selected DB -->"; flush();
            
			// check users table, create entry if necessary
			$sql = "select id from $mysql_users where (login='$user_name') and (host='$host')";
			$r = mysql_query($sql);
			if ($r){
				if (mysql_num_rows($r)<1){
                    // if user not in db, insert
					$sql = "insert into $mysql_users (login, host) values ('$user_name', '$host')";
					if (!mysql_query($sql)) $error.="MySQL error: Couldn't add user to users table<br>\n";
                    else{
                        $dataID = mysql_insert_id();
                        $new_user = true;
                    }

                    // create record in prefs
                    if ((empty($error)) && (!empty($mysql_prefs))){
                        $my_prefs = $default_prefs;
                        $my_prefs["id"] = $dataID;
                        $sql = Array2SQL($mysql_prefs, $my_prefs, "INSERT");
                        if (mysql_query($sql)){
                            $prefs_saved = true;
                        }else{
                            $error .= "MySQL error: Couldn't insert into $mysql_prefs<br>\n";
                            echo "\n<!-- $sql -->\n";
                            mysql_query("delete from $mysql_users where id='$dataID'");
                        }
                    }
                    
                    // create record in colors
                    if ((empty($error)) && (!empty($mysql_colors))){
                        $my_colors = $default_colors;
                        $my_colors["id"] = $dataID;
                        $sql = Array2SQL($mysql_colors, $my_colors, "INSERT");
                        if (mysql_query($sql)){
                            $colors_saved = true;
                        }else{
                            $error .= "MySQL error: Couldn't insert into $mysql_colors<br>\n";
                            echo "\n<!-- $sql -->\n";
                            if ($prefs_saved) mysql_query("delete from $mysql_prefs where id='$dataID'");
                            mysql_query("delete from $mysql_users where id='$dataID'");
                        }
                    }

				}else{
                    $dataID = mysql_result($r, 0, "id");
                    $colors_saved = true;
                    $prefs_saved = true;
                }
                echo "<!-- Selected: $dataID -->";
                
			}else{
				$error.="MySQL error: Couldn't access users table <br>\n";
			}
			
			// Initialize session
            if (empty($error)){
				if (empty($port)) $port = 143;
                $sql = "insert into $mysql_sessions (sid, login, password, host, path, dataID, port, inTime) values ";
                $sql.= "('$user', '$encUser', '$encpass', '$encHost', '$encPath', '$dataID', '$port',".time().")";
                if (!mysql_query($sql)) $error .= "MySQL Insert failed: ".mysql_error()." <br>\n";
            }
		}else{
			$error .= "MySQL select DB failed. <br>\n";
		}
		//mysql_close($conn);
	}else{
		$error .= "MySQL connection failed. <br>\n";
	}

    if (!empty($path)){
        if (!$prefs_saved){
            echo "\n<!-- Saving prefs to FS backend -->\n";
            // initialize $my_prefs, and create $userPath/prefs.inc file
            if (file_exists($path."/prefs")) $my_prefs = GetSettings($init["my_prefs"], $path."/prefs");
            else $my_prefs = $init["my_prefs"];
            include("../include/save_prefs.inc");
        }
    
        if (!$colors_saved){
            echo "\n<!-- Saving colors to FS backend -->\n";
            // initialize $my_colors, and create $userPath/colors.inc file
            if (file_exists($path."/colors")) $my_colors = GetSettings($init["my_colors"], $path."/colors");
            else $my_colors = $init["my_colors"];
            include("../include/save_colors.inc");
        }
    }
    
    if (!empty($error)){
        $session="";
        $user = $user_name;
    }
?>
