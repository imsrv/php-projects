<? 

/*

	PHP Chatengine version 1.9
	by Michiel Papenhove
	e-mail: michiel@mipamedia.com
	http:// www.mipamedia.com
	
	Software is supplied "as is". You cannot hold me responsible for any problems that
	might of occur because of the use of this chat
	
*/

// special options

// general definitions

$levels = array (0, 1, 3, 2);
$levelnames = array("normal", "moderator", "special", "sysop");

$modes = array (0, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23);
$modenames = array("normal", "crap", "no spaces", "reverse", "yell", "stutter", "nerdie", "swear", "german porn", "no vowels", "ome jo", "nazi", "shut up", "maroc", "southpark");

$page_title = "Special Sysop options";

require("includes.php3");

function userlevel_list($mysql_link, $current_level, $login)
{
	global $levelnames, $levels;
	$aantal = count($levelnames);
	
	?>
	<select style="font-size:12px" name="userlevels[]">
	<?
	for ($f = 0; $f < $aantal; $f++)
	{
		if ($current_level == $levels[$f])
		{
			$add = " SELECTED ";
		}
		else
		{
			$add = "";
		}
		?>
		<option value="<? print($levels[$f]); ?>"<? print($add); ?>><? print($levelnames[$f]); ?></option>		
		<?
	}
	?>
	</select>
	<?
}

function usermode_list($mysql_link, $current_status, $login)
{
	global $modenames, $modes;
	$aantal = count($modenames);
	
	?>
	<select style="font-size:12px" name="mode[]">
	<?
	for ($f = 0; $f < $aantal; $f++)
	{
		if ($current_status == $modes[$f])
		{
			$add = " SELECTED ";
		}
		else
		{
			$add = "";
		}
		?>
		<option value="<? print($modes[$f]); ?>"<? print($add); ?>><? print($modenames[$f]); ?></option>		
		<?
	}
	?>
	</select>
	<?
}

function image_list($mysql_link, $img, $login)
{
	$dirobj = opendir("icons/");
	if ($img == "") $img = "nobody.gif";
	?>
	<select style="font-size:12px" name="img[]">
	<?
	while (($filen = readdir($dirobj))!=false)
	{
		if (($filen != ".") AND ($filen != "..")):
		if ($filen == $img)
		{
			$add = " SELECTED ";
		}
		else
		{
			$add = "";
		}
		?>
		<option value="<? print($filen); ?>"<? print($add); ?>><? print($filen); ?></option>
		<?
		endif;
	}
	?>
	</select>
	<?
	
}
function show_main($mysql_link)
{
	global $scriptname, $session, $gods, $mipa;
	
	print("<p>&nbsp;Special Sysop options:</p>");
	
	// fetch users
	// determine mode
	
	$check_login = strtoupper(user($mysql_link, $session));
	
	$is_godmember = false;
	$aantal = count($gods);
	for ($f = 0; $f < $aantal; $f++)
	{
		if ($check_login == $gods[$f]) { $is_godmember = true; }
	}	
	
	if (!$is_godmember)
	{
		$query= "SELECT * FROM chat_session_ids WHERE userlevel NOT IN (".sysops.") ORDER BY login;";
	}
	else
	{
		$query= "SELECT * FROM chat_session_ids WHERE login <> '$mipa' ORDER BY login;";
	}
	
		
	$result = mysql_query($query, $mysql_link);

	?>
	<form name="userform" method="post" action="<? print($scriptname); ?>">
	<table width="100%" border="0">
	<tr>
		<td><b>userinfo</b></td>
		<td><b>color</b></td>
		<td><b>image</b></td>
		<td><b>level</b></td>
		<td><b>mode</b></td>
		<td><b>kick</b></td>
		<td><b>ban</b></td>
	</tr>
	<?
	while ($record = mysql_fetch_array($result))
	{
		// fetch userrecord
		$query = "SELECT * FROM chat_users WHERE login = '".addslashes($record["login"])."';";
		$userrecord = mysql_fetch_array(mysql_query($query, $mysql_link));
		$login = $userrecord["login"];
		
		?>		
		<tr>
			<td>Nickname: <font color="gold"><? print($record["login"]); ?></font><br>IP: <? print($record["IP"]); ?><br>Real Name: <? print($userrecord["realname"]); ?><br>E-mail:<? print($userrecord["e_mail"]); ?><input type="hidden" name="loginname[]" value="<? print($login); ?>"></td>
			<td><input style="font-size:10px" type="text" name="color[]" value="<? print($userrecord["color"]); ?>"></td>
			<td><? image_list($mysql_link, $userrecord["img"], $login); ?></td>
			<td><? userlevel_list($mysql_link, $record["userlevel"], $login); ?></td>
			<td><? usermode_list($mysql_link, $record["status_online"], $login); ?></td>
			<td><input type="checkbox" name="<? print(urlencode($login)); ?>_kick"></td>
			<td><input type="checkbox" name="<? print(urlencode($login)); ?>_ban"></td>
		</tr>
		
		<?
	}
	?>
	</table>
	<input type="submit" value="update changes" class="button">
	<input type="hidden" name="action" value="update">
	<input type="hidden" name="session" value="<? print($session); ?>">
	</form>
	<?
}

function update($mysql_link, $loginname, $color, $img, $levels, $mode)
{
	// update session table
	
	$aantal = count($loginname);
	for ($f = 0; $f < $aantal; $f++)
	{
		// check if user was in invisible mode
		$query = "SELECT status_online FROM chat_session_ids WHERE login = '".$loginname[$f]."'";
		$checkres = mysql_fetch_array(mysql_query($query, $mysql_link));
		
		if ($checkres["status_online"] == 99) { $mode[$f] = 99; }
		
		$query  = "UPDATE chat_session_ids SET status_online = ".$mode[$f].", userlevel = ".$levels[$f]." WHERE login = '".$loginname[$f]."';";
		mysql_query($query, $mysql_link);
	}
	
	//update user table
	for ($f = 0; $f < $aantal; $f++)
	{
		$query = "UPDATE chat_users SET color = '".$color[$f]."', img = '".$img[$f]."' WHERE login = '".$loginname[$f]."'";
		mysql_query($query, $mysql_link);
	}
	
	// see if anyone has to be kicked or banned
	global $HTTP_POST_VARS;
	$hv = $HTTP_POST_VARS;
	
	while (list ($rkey, $rval) = each($hv))
	{
		if (eregi("kick", $rkey))
		{
			$naam = urldecode(addslashes(substr($rkey, 0, strpos($rkey, "_"))));
			$query = "DELETE FROM chat_session_ids WHERE login = '$naam';";
			system_message($mysql_link, $naam . " was kicked by the system");
			update_stats($mysql_link, $naam, "kicks", 1);
			mysql_query($query, $mysql_link);
		}
		if (eregi("ban", $rkey))
		{
			$naam = urldecode(addslashes(substr($rkey, 0, strpos($rkey, "_"))));
			$query = "UPDATE chat_users SET banned = 1 WHERE login = '$naam';";
			system_message($mysql_link, "".stripslashes($naam)." was banned by the system");
			mysql_query($query, $mysql_link);
		}
		
	}
	print("Updated.<br>");
	show_main($mysql_link);
	
}

// ******* MAIN

// check if user is sysop
$userlevel = user_level($mysql_link, $session);
$checked = validate($userlevel, sysops);

if ($checked)
{
	// options
	switch ($action)
	{
		case "": show_main($mysql_link); break;
		case "update": update($mysql_link, $loginname, $color, $img, $userlevels, $mode); break;
		
	}
}
else
{
	print("You are not authorized to use these options.");
}

end_page($mysql_link);

?>
