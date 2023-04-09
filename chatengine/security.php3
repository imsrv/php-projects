<?

/*

	PHP Chatengine version 1.9
	by Michiel Papenhove
	e-mail: michiel@mipamedia.com
	http:// www.mipamedia.com
	
	Software is supplied "as is". You cannot hold me responsible for any problems that
	might of occur because of the use of this chat
	
*/

if ($action == "") $extra_info = "onLoad=\"document.login.username.focus()\"";

// security
// this is the module that controls logging in and out, as well as the sessions

require("includes.php3");

// clean up

clean_up($mysql_link);

function show_login()
{
	global $scriptname;
	?>
	<form action="<? print($scriptname); ?>" method="post" name="login">
	<table height="100%" width="500"border="0">
	<tr>
		<td style="background-repeat : no-repeat" width="350" valign="bottom">
			<table border="0">
			<tr>
				<td width="20">&nbsp;</td>
				<td>
					<br><br><br><br><br><br><br><br><br>
					<table border="0">
					<tr>
						<td>Username:</td><td><input class="blacktext" type="text" name="username" value="" maxlength="17"></td>
					</tr>
						<td>Password:</td><td><input class="blacktext" type="password" name="password" value="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="button" type="submit" value="  log in  "></td>
					</tr>
					<tr>
						<td colspan="2" align="left"><input type="checkbox" name="silent">silent login (sysops only)</td>
					</tr>
					<tr>
					</table>
					<input type="hidden" name="action" value="check_login">
				</td>
			</tr>
			</table>
		</td>
		<td valign="top">
		</td>
	</tr>
	<tr>
		<td colspan="2">
			This chat has been designed to run on Internet Explorer at a resolution of at least 800x600<br><br>
			<font color="red">DISCLAIMER</font>: By entering this chat you agree with the following: this chat can be (and usually is) monitored by so-called
			sysops (both visible and invisible) that can read all messages, <b>public</b> or <b>private</b>. If you don't agree with that, please
			do not log in.
		</td>
	</tr>
	</table>
	</form>
	<?
}

function navi_form($session)
{
	?>
	<form action="showtext.php3" method="post" name="move">
	<input type="hidden" name="session" value="<? print($session); ?>">
	</form>
	<?
}
	

function check_login($mysql_link, $username, $password, $silent)
{
	// check if account exists

	$allow_silent = FALSE;

	// see how many sessions there are
	$query = "SELECT COUNT(*) AS usercount FROM chat_session_ids;";
	$result = mysql_fetch_array(mysql_query($query, $mysql_link));
	$amount_of_users = $result["usercount"];

	if ($amount_of_users > 49)		// currenly, no more than 49 users are allowed
	{
		js_alert("Sorry, the maximum amount of users for this chat session has been reached. Try again later.");
		show_login();
		return;
	}

	global $scriptname, $REMOTE_ADDR;
	$query = "SELECT * FROM chat_users WHERE login = '$username' AND password = '$password';";
	$result = mysql_query($query, $mysql_link);
	if (mysql_num_rows($result) == 0)
	{
		js_alert("Invalid login, please try again");
		show_login();
		return;
	}
	$temp = mysql_fetch_array($result);
	
	$userlevel = $temp["status"];
	$banned = $temp["banned"];
	
	// check if silent login is allowed
	$check = validate($userlevel, _allowsilentlogin);
	
	if (($silent == "on") and (!$check))
	{
		js_alert("You are not allowed to log in silently");
	}
	
	if (($silent == "on") and ($check))
	{
		$status_online = 99;
	}
	else
	{
		$status_online = 0;
	}
	
	// check if banned
	if ($banned == 1)
	{
		js_alert("You have been banned from this chatbox. Go away.");
		?>
		<table width="100%" height="100%" border="0">
		<td align="middle" valign="middle">
		You're banned. Go away. Go bother somebody else.<br><br>-= Fuck off =-</br>
		</td>
		</table>
		<?
		return;
	}
	
	$session = "";
	
	// check if user is already logged in, if so, delete entry
	$query = "SELECT * FROM chat_session_ids WHERE login = '$username';";
	$result = mysql_query($query, $mysql_link);
	$already_logged_in = FALSE;
	
	if (mysql_num_rows($result) != 0)
	{
		// erase entry
		$query = "DELETE FROM chat_session_ids WHERE login = '$username';";
		mysql_query($query, $mysql_link);
		$already_logged_in = TRUE;
	}
	
	if ($session == ""):
		// make new session id
		$pool = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		for ($f = 0; $f < 20; $f++)
		{
			srand((double)microtime()*1000000);
			$session .= substr($pool, rand(0, strlen($pool)), 1);
		}
	endif;
	
	// insert session id into database
	
	$query = "INSERT INTO chat_session_ids (session_id, login, last_action, status_online, lastlogin, IP, userlevel) ";
	$query .="VALUES ('$session', '$username', now(), $status_online, now(), '$REMOTE_ADDR' , '$userlevel');";
	mysql_query($query);
	
	// update last_date
	$query = "UPDATE chat_users SET last_date = now() WHERE login = '$username';";
	mysql_query($query, $mysql_link);
	
	$username = strtolower($username);
	
	// show logged in message
	if ($status_online <> 99)
	{
		if (!$already_logged_in)
		{
			system_message($mysql_link, "$username logged in");
		}
		else
		{
			system_message($mysql_link, "$username re-logged in");
		}
	}
	
	update_stats($mysql_link, $username, "logins", 1);
			
	navi_form($session);
	?>
	<script>
	<!--
	document.move.submit();
	//-->
	</script>
	<?
}

function do_relogin($mysql_link, $session)
{
	$username = strtolower(user($mysql_link, $session));
	$silent = "";
	$query = "SELECT login, password FROM chat_users WHERE login = '$username';";
	$result = mysql_fetch_array(mysql_query($query, $mysql_link));
	check_login($mysql_link, $result["login"], $result["password"], $silent);
}
// ***** MAIN

switch ($action)
{
	case "": show_login(); break;
	case "check_login": check_login($mysql_link, $username, $password, $silent); break;
	case "relogin": do_relogin($mysql_link, $session); break;
	
}

end_page($mysql_link);

?>
