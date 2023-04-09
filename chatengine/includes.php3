<?

/*

	PHP Chatengine version 1.9
	by Michiel Papenhove
	e-mail: michiel@mipamedia.com
	http:// www.mipamedia.com
	
	Software is supplied "as is". You cannot hold me responsible for any problems that
	might of occur because of the use of this chat
	
*/

// includes.php3

require("mysql.php3");

// version
define("_version", "1.9");
define("_programming", "Michiel Papenhove");
define("_design", "Michiel Papenhove");

define("_chatboxname", "-- your chatbox name here --");

// userlevel constants
define("_striphtml", "0,1,3");				// html is stripped for these groups
define("_readprivate", "2,100");			// these groups can read privates
define("_cankick", "2,1,100");				// these groups can kick
define("_unkickable", "2,100");				// these groups are unkickable
define("_specialoptions", "2,100");			// these groups can access the special options
define("_modmessages", "2,1,100");			// these groups can see modmessages
define("_allowsilentlogin", "2,100");		// these groups can silently login
define("_canseeinvisible", "2,100");		// these groups can see invisible users

define("_god", "100");						// define the god level

// groups
define("sysops", "2,9,100");				// sysop group
define("moderators", "1");					// moderator group
define("special", "3");						// special group

// connect to database
$mysql_link = mysql_connect(_hostname, _username, _userpassword);
mysql_select_db(_database, $mysql_link);

$gods = array("yournick");		// define the god nicks
$mipa = "yournick";				// define the mega mega mega god's nick :-)

// determine scriptname
$scriptname = substr($PHP_SELF, strrpos($PHP_SELF, "/")+1 );

// include basic layout elements
require("layout.php3");

// session functions

function check_timeout($mysql_link, $session)
{
	$query = "SELECT UNIX_TIMESTAMP(now())- UNIX_TIMESTAMP(last_action)) AS verschil FROM chat_session_ids WHERE session_id = '$session';";
	$result = mysql_fetch_array(mysql_query($query, $mysql_link));
	if ($result["verschil"] > _timeout)
	{
		?>
		<script>
		<!--
		parent.document.location.href = "index.php3";
		//-->
		</script>
		<?
	}
}

function check_secure($mysql_link, $session)
{
	global $chatSessionCookie;
	$username = user($mysql_link, $session);
	
	$query = "SELECT * FROM chat_session_ids WHERE session_id = '$session';";
	$result = mysql_query($query, $mysql_link);
	if (mysql_num_rows($result) == 0)
	{
		?>
		<script>
		<!--
		parent.document.location.href = "index.php3";
		//-->
		</script>
		<?
		exit;
	}
}

function user($mysql_link, $session)
{
	$query = "SELECT login FROM chat_session_ids WHERE session_id = '$session';";
	$result = mysql_fetch_array(mysql_query($query, $mysql_link));
	return $result["login"];
}

function user_level($mysql_link, $session)
{
	$query = "SELECT userlevel FROM chat_session_ids WHERE session_id = '$session';";
	$result = mysql_query($query, $mysql_link);
	$usertemp = mysql_fetch_array($result);
	$userl = $usertemp["userlevel"];
	return $userl;
}

function validate($item, $haystack)
{
	$val_array = split(",", $haystack);
	$validated = FALSE;
	
	while (list ($vkey, $vval) = each($val_array))
	{
		if ($vval == $item)
		{
			$validated = TRUE;
			break;
		}
	}
	
	return $validated;
}

function status_online($mysql_link, $session)
{
	$query = "SELECT status_online FROM chat_session_ids WHERE session_id = '$session'";
	$result = mysql_fetch_array(mysql_query($query, $mysql_link));
	return $result["status_online"];
}

function system_message($mysql_link, $mesg)
{
	$query = "INSERT INTO chat_text_db(saidby, saidto, status, text, date) ";
	$query .="VALUES ('system', '0', 0, '$mesg', now());";
	mysql_query($query, $mysql_link);
}

function clean_up($mysql_link)
{
	$query = "SELECT login FROM chat_session_ids;";
	$result = mysql_query($query, $mysql_link);
	if (mysql_num_rows($result) == 0)
	{
		mysql_query("DELETE FROM chat_text_db;", $mysql_link);
	}
}

// perform actions

function js($strng)
{
	?>
	<script>
	<!--
	parent.content.document.writeln('<? print($strng); ?>');
	//-->
	</script>
	<?
}

function js_alert($strng)
{
	?>
	<script>
	<!--
	alert('<? print($strng); ?>');
	//-->
	</script>
	<?
}

function erase_is($mysql_link)
{
	// erase invalid sessions
	$query = "SELECT login FROM chat_session_ids WHERE UNIX_TIMESTAMP(last_action) < (UNIX_TIMESTAMP(NOW()) - "._timeout.") AND status_online <> 99;";
	$result = mysql_query($query, $mysql_link);
	
	$query = "DELETE FROM chat_session_ids WHERE UNIX_TIMESTAMP(last_action) < (UNIX_TIMESTAMP(NOW()) - "._timeout.") AND status_online <> 99;";
	mysql_query($query, $mysql_link);

	while($reccie = mysql_fetch_array($result))
	{
		system_message($mysql_link,$reccie["login"]." was logged out due to inactivity");
	}
	
	// end erase
}

function update_stats($mysql_link, $username, $stat_name, $inc)
{
	// check if record exists
	$username = addslashes($username);
	$query = "SELECT nick FROM chat_stats WHERE nick = '$username';";
	$result = mysql_query($query, $mysql_link);
	if (mysql_num_rows($result) == 0)
	{
		// does not exist, make new one
		mysql_query("INSERT INTO chat_stats (nick, started_at) VALUES ('$username', now());", $mysql_link);
	}
	$query = "UPDATE chat_stats SET $stat_name = $stat_name + $inc WHERE nick = '$username';";
	mysql_query($query, $mysql_link);
}

?>
