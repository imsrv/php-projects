<?
/////////////////////////////////////////////////////////
//	
//	source/index.php
//
//	(C)Copyright 2000-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
//
//		This file is part of IlohaMail.
//		IlohaMail is free software released under the GPL 
//		license.  See enclosed file COPYING for details,
//		or see http://www.fsf.org/copyleft/gpl.html
//
/////////////////////////////////////////////////////////

/********************************************************

	AUTHOR: Ryo Chijiiwa <ryo@ilohamail.org>
	FILE: source/index.php
	PURPOSE:
		1. Provides interface for logging in.
		2. Authenticates user/password for given IMAP server
		3. Initiates session
	PRE-CONDITIONS:
		$user - IMAP account name
		$password - IMAP account password
		$host - IMAP server
	COMMENTS:
		Modify form tags for "host" as required.
		For an example, if you only want the program to be used to log into specific 
		servers, you can use "select" lists (if multiple), or "hidden" (if single) tags.
		Alternatively, simply show a text box to have the user specify the server.
********************************************************/
include("../include/super2global.inc");
include("../include/nocache.inc");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<TITLE>IlohaMail</TITLE>
</HEAD>
<?
include_once("../include/encryption.inc");
include_once("../include/version.inc");
include_once("../include/langs.inc");
include_once("../conf/conf.inc");
include_once("../conf/login.inc");


// session not started yet
if (!isset($session) || (empty($session))){	
    //figure out lang
    if (strlen($int_lang)>2){
        //lang selected from menu (probably)
        $lang = $int_lang;
    }else{
        //default, or non-selection
        $lang = (isset($default_lang)?$default_lang:"eng/");
    }
    include_once("../conf/defaults.inc");

    //validate host
    if (isset($host)){
        //validate host
        if (!empty($default_host)){
            if (is_array($default_host)){
                if (empty($default_host[$host])){
                    $host="";
                    $error .= "Unauthorized host<br>\n";
                }
            }else{
                if (strcasecmp($host, $default_host)!=0){
                    $host="";
                    $error .= "Unauthorized host<br>\n";
                }
            }
        }
    }
    
	//attempt to initiate session
	if ((isset($user))&&(isset($password))&&(isset($host))){
		include("../include/icl.inc");
		$user_name = $user;
		
		//first, authenticate against server
		$iil_conn=iil_Connect($host, $user, $password, $AUTH_MODE);
		if ($iil_conn){
			//run custom authentication code
            include("../conf/custom_auth.inc");
            
			//if successful, start session
            if (empty($error)){
				if ((!isset($port))||(empty($port))) $port = 143;
                include("../include/write_sinc.inc");
                if ($new_user){
                    include("../conf/new_user.inc");
					$new_user = 1;
                }else{
					$new_user = 0;
				}
			}
            
			iil_Close($iil_conn);
		}else{
			$error = $iil_error."<br>";
		}
		
		//make log entry
		$log_action = "log in";
		include("../include/log.inc");
	}
}


// valid session
$login_success = false;
if ((isset($session)) && ($session != "")){
	$user=$session;
    
    //auth and load session data
	include("../include/session_auth.inc");
    
    //overwrite lang prefs if different
    if ((strlen($int_lang)>2) && (strcmp($int_lang, $my_prefs["lang"])!=0)){
        $my_prefs["lang"] = $int_lang;
        include("../lang/".$lang."init.inc");
        if ($supported_charsets[$my_prefs["charset"]]!=1) $my_prefs["charset"] = $lang_charset;
        include("../include/save_prefs.MySQL.inc");
    }
    
    //figure out which page to load in main frame
	if (($new_user)||($show_page=="prefs")) $main_page = "prefs.php?user=".$session;
	else $main_page = "main.php?folder=INBOX&user=".$session;
	
    if (($my_prefs["list_folders"]==1) && ($port!=110)){
		$login_success = true;
		?>
		<FRAMESET ROWS="30,*"  frameborder=no border=0 framespacing=0 MARGEINWIDTH="0" MARGINHEIGHT="0">
			<FRAMESET COLS="30,*"  frameborder=no border=0 framespacing=0 MARGEINWIDTH="0" MARGINHEIGHT="0">
				<FRAME SRC="radar.php?user=<?=$session?>" NAME="radar" SCROLLING="NO" MARGEINWIDTH="0" MARGINHEIGHT="0"  frameborder=no border=0 framespacing=0>
				<FRAME SRC="tool.php?user=<?=$session?>" NAME="tool" SCROLLING="NO" MARGEINWIDTH="0" MARGINHEIGHT="0"  frameborder=no border=0 framespacing=0>
			</FRAMESET>
			<FRAMESET COLS="180,*" frameborder=no border=0 framespacing=0 MARGEINWIDTH="0" MARGINHEIGHT="0">
				<FRAME SRC="folders.php?user=<?=$session?>" NAME="list1"  MARGINWIDTH=5 MARGINHEIGHT=5 NORESIZE frameborder=no border=0 framespacing=0>
				<FRAME SRC="<?=$main_page?>" NAME="list2" MARGINWIDTH=10 MARGINHEIGHT=10 FRAMEBORDER=no border=0 framespacing=0>
			</FRAMESET>
		</FRAMESET>
		<?
	}else if (empty($error)){
		$login_success = true;
		?>
		<FRAMESET ROWS="30,*"  frameborder=no border=0 framespacing=0 MARGEINWIDTH="0" MARGINHEIGHT="0">
			<FRAMESET COLS="30,*"  frameborder=no border=0 framespacing=0 MARGEINWIDTH="0" MARGINHEIGHT="0">
				<FRAME SRC="radar.php?user=<?=$session?>" NAME="radar" SCROLLING="NO" MARGEINWIDTH="0" MARGINHEIGHT="0"  frameborder=no border=0 framespacing=0>
				<FRAME SRC="tool.php?user=<?=$session?>" NAME="tool" SCROLLING="NO" MARGEINWIDTH="0" MARGINHEIGHT="0"  frameborder=no border=0 framespacing=0>
			</FRAMESET>
			<FRAME SRC="<?=$main_page?>" NAME="list2" MARGINWIDTH=10 MARGINHEIGHT=10 FRAMEBORDER=no border=0 framespacing=0>
		</FRAMESET>
		<?
	}
}
if (!$login_success){
	$langOptions="<option value=\"--\">--";
	while (list($key, $val)=each($languages)) 
		$langOptions.="<option value=\"$key\" ".(strcmp($key,$select_lang)==0?"SELECTED":"").">$val\n";

	$bgcolor = $default_colors["folder_bg"];
	$textColorOut = $default_colors["folder_link"];
	$bgcolorIn = $default_colors["tool_bg"];
	$textColorIn = $default_colors["tool_link"];
	?>
	<BODY BGCOLOR="<?=$bgcolor?>" TEXT="<?=$textColorOut?>" LINK="<?=$textColorOut?>" ALINK="<?=$textColorOut?>" VLINK="<?=$textColorOut?>" onLoad="document.forms[0].user.focus();">
	<p><BR><BR>
	<center>
	<form method="POST" action="index.php">
	<input type="hidden" name="logout" value=0>
	<table width="280" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$bgcolorIn?>">
	<tr><td align="center" colspan=2>
	<?
		include("../conf/login_title.inc");
        if (!empty($error)) echo "<font color=\"#FFAAAA\">".$error."</font><br>";
	?>
	</td>
	</tr>
	<tr><td align=right>User ID: </td><td><input type="text" name="user" value="<? echo $user; ?>" size=15></td></tr>
	<tr><td align=right>Password: </td><td><input type="password" name="password" value="" size=15></td></tr>
	<?
		//initialize host
		if ((!isset($host))||(empty($host))) $host = $default_host;
	
		//show (or hide) host....
		if ((is_string($host)) && (!empty($host))){
			//if hard coded
			if (!$hide_host){
				echo  "<tr><td align=right>Server: </td><td><b>$host</b>&nbsp;&nbsp;";
				echo "</td></tr>";
			}
			echo "<input type=hidden name=\"host\" value=\"$host\">";
		}else if (is_array($host)){
			//popup menu
			if ((!$hide_host) || (empty($default_host))){
				echo  "<tr><td align=right>Server:</td><td><select name=\"host\">\n";
				reset($host);
				while ( list($server, $name) = each($host) ){
					echo "<option value=\"$server\" ".($server==$default_host?"SELECTED":"").">$name\n";
				}
				echo "</select></td></tr>";
			}else{
				echo "<input type=hidden name=\"host\" value=\"$host\">";
			}
		}else{
			//textbox
			echo "<tr><td align=right>Server: </td><td><input type=text name=\"host\" value=\"\">&nbsp;&nbsp;</td></tr>";
		}
		
		//initialize default rootdir and port 
		if ((!isset($rootdir))||(empty($rootdir))) $rootdir = $default_rootdir;
		if ((!isset($port))||(empty($port))) $port = $default_port;
		
		//show (or hide) protocol selection
		if (!$hide_protocol){
			echo "<tr>";
			echo "<td align=\"right\">Type: </td>\n<td>";
            echo "<select name=\"port\">\n";
            echo "<option value=\"143\" ".($port==143?"SELECTED":"").">IMAP\n";
            echo "<option value=\"110\" ".($port==110?"SELECTED":"").">POP3\n";
            echo "</select>\n";
			//echo "<td><input type=\"text\" name=\"port\" value=\"$port\" size=\"4\"></td>";
			echo "</td></tr>\n";
		}else{
			echo "<input type=\"hidden\" name=\"port\" value=\"$default_port\">\n";
		}
		
		//show (or hide) root dir box
		if (!$hide_rootdir){
			echo "<tr>";
			echo "<td align=\"right\">Rootdir:</td>";
			echo "<td><input type=\"text\" name=\"rootdir\" value=\"$rootdir\" size=\"12\"></td>";
			echo "</tr>\n";
		}else{
			echo "<input type=\"hidden\" name=\"rootdir\" value=\"$default_rootdir\">\n";
		}
		
	?>
	<tr><td align=right>Language: </td><td>
    <select name="int_lang">
	<?=$langOptions?>
	</select></td></tr>
	<tr><td align="right" colspan="2"><input type=submit value="Log In">&nbsp;&nbsp;<p> </td></tr>
	</table>
	</form>
	<?
		include("../conf/login_blurb.inc");
	?>
	</center>
	</body>
	<?
}
	?>
</HTML>