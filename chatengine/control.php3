<html>
<?

/*

	PHP Chatengine version 1.9
	by Michiel Papenhove
	e-mail: michiel@mipamedia.com
	http:// www.mipamedia.com
	
	Software is supplied "as is". You cannot hold me responsible for any problems that
	might of occur because of the use of this chat
	
*/

if ($session != "") $extra_info = "onLoad=\"start_timer()\"";

require("includes.php3");

erase_is($mysql_link);

$saidby = addslashes($saidby);
$saidto = addslashes($saidto);

require("process.php3");

// erase old text from database
$query = "SELECT COUNT(*) AS aantal FROM chat_text_db;";
$res = mysql_fetch_array(mysql_query($query, $mysql_link));
$aantal = $res["aantal"];
$maxaantal = 50;

if ($aantal > $maxaantal)
{
	$verschil = $aantal - $maxaantal;
	$query = "SELECT id FROM chat_text_db ORDER BY date ASC LIMIT 0, $verschil;";
	$res1 = mysql_query($query, $mysql_link);
	while ($r = mysql_fetch_array($res1))
	{
		$ids .= $r["id"].",";
	}
	$ids = substr($ids, 0, strrpos($ids, ","));
	mysql_query("DELETE FROM chat_text_db WHERE id IN ($ids);", $mysql_link);
}

$eerste = "nee";
$is_tekst = TRUE;

$username = user($mysql_link, $session);
$username = addslashes($username);

if ($session != "")
{
	check_secure($mysql_link, $session);
	if ($state=="")
	{
		$state="started";
		$eerste="ja";
		$readback = 10;
		
		if ($lijst == "no") { $readback = 0; }
		
		$query = "SELECT MAX(id)-$readback AS latestid FROM chat_text_db;";
		$ids = mysql_query($query, $mysql_link);
		$temp = mysql_fetch_array($ids);
		$latestid = $temp["latestid"];
		if ($latestid != "") $is_tekst = TRUE;
		if ($latestid == "") $is_tekst = FALSE;
	}

	$check_userlist = $userlist;

	if ($is_tekst): // start if
	
	// show chat messages
	$query = "SELECT * FROM chat_text_db WHERE id > $latestid AND status = '50';";
	$cm_result = mysql_query($query, $mysql_link);
	
	$query = "SELECT * FROM chat_text_db WHERE id > $latestid AND saidto = '0' ORDER BY date ASC;";
	$result = mysql_query($query, $mysql_link);

	// can this user see all private entries ?
	$userlevel = user_level($mysql_link, $session);
	
	if (!validate($userlevel, _readprivate))
	{
		$query = "SELECT * FROM chat_text_db WHERE id > $latestid AND saidto = '$username' AND saidby != '$username' ORDER BY date ASC;";
		$result2 = mysql_query($query, $mysql_link);
		$is_god = FALSE;
	}
	else
	{
		$query = "SELECT * FROM chat_text_db WHERE id > $latestid AND saidto != '0' AND saidto != '1' AND status != '50' ORDER BY date ASC;";
		$result2 = mysql_query($query, $mysql_link);
		$is_god = TRUE;
	}
	
	$query = "SELECT * FROM chat_text_db WHERE id > $latestid AND saidto <> '0' AND saidby = '$username' AND saidto != '1' AND status != '50' ORDER BY date ASC;";
	$result3 = mysql_query($query, $mysql_link);

	$mods = FALSE;
	if (validate($userlevel, _modmessages))
	{
		// get modmessages
		$query = "SELECT * FROM chat_text_db WHERE id > $latestid AND saidto = '1' ORDER BY date ASC;";
		$result4 = mysql_query($query, $mysql_link);
		$mods=TRUE;
	}

	$query = "SELECT MAX(id) AS latestid FROM chat_text_db;";
	$ids = mysql_fetch_array(mysql_query($query, $mysql_link));
	$latestid = $ids["latestid"];

	$data = "";
	$data2 = "";
	$data3 = "";
	
	while ($rec = mysql_fetch_array($cm_result))
	{
		$pr_cm = TRUE;
		if ($rec["saidto"] == "ask_for_refresh")
		{
			?>
			<script>
			<!--
			parent.users.document.location.href = 'users.php3?session=<? print($session); ?>';
			//-->
			</script>
			<?
			$pr_cm = FALSE;
		}
		if ($pr_cm)
			{
				js_alert("General chatmessage by ".addslashes($rec["saidby"]).":\\n\\n".addslashes($rec["text"]));
			}
	}

	while ($record = mysql_fetch_array($result))
	{
		$data .= process_normal($mysql_link, $session, $record["saidby"], $record["saidto"], $record["text"], $record["status"]);
	}
	
	while ($record = mysql_fetch_array($result2))
	{
		$data2 .= process_private($mysql_link, $session, $record["saidby"], $record["saidto"], $record["text"]);
	}
	
	while ($record = mysql_fetch_array($result3))
	{
		$data3 .= process_private($mysql_link, $session, $record["saidby"], $record["saidto"], $record["text"]);
	}

	if ($mods)
	{
		while ($record = mysql_fetch_array($result4))
		{
			$data4 .= process_mod($mysql_link, $session, $record["saidby"], $record["saidto"], $record["text"]);
		}
	}
	

	// add slashes to data
	$data = addslashes($data);
	$data2 = addslashes($data2);
	$data3 = addslashes($data3);
	if ($mods) $data4 = addslashes($data4);
	
	endif; // end if
	
	if (!$is_tekst) $latestid = 0;

	$encodedurl = urlencode($latestid);
	
	// make userlist
	$userlist = "";
	
	$add_tag = "WHERE status_online <> 99";
	
	if (validate($userlevel, _canseeinvisible)) $add_tag="";
	
	$query = "SELECT login FROM chat_session_ids $add_tag ORDER BY id;";
	$idresult = mysql_query($query, $mysql_link);
	while ($recc = mysql_fetch_array($idresult))
	{
		$userlist .= $recc["login"].",";
	}

	?>
	<script>
	<!--
	function do_print()
	{

	<?
		if ($eerste=="ja")
		{
			// stuur de algemene startup header door
			$gen_header  = "<style>";
			$gen_header .= "body		{ background-color: #000000; color: #ffffff ; font-family : tahoma ; font-size: 12px ; scrollbar-base-color:black;scrollbar-arrow-color:black }";
			$gen_header .= "td 		{ font-family : tahoma ; font-size: 14px }";
			$gen_header .= "input.typetext 	{ background-color: #000000; color: #ffffff ; font-family : tahoma ; font-size: 14px }";
			$gen_header .= "select.typetext { background-color: #000000; color: #ffffff ; font-family : tahoma ; font-size: 14px }";
			$gen_header .= "b.user 		{ line-height: 16px; background-color: #000000; color: #A13834 ; font-family : tahoma ; font-size: 12px; position: relative; left:0px}";
			$gen_header .= "b.text 		{ line-height: 16px; background-color: #000000; color: #white; font-family : tahoma ; font-weight: normal}";
			$gen_header .= "b.pr 		{ line-height: 16px; background-color: #000000; color: gold ; font-family : tahoma ; font-weight: normal}";
			$gen_header .= "b.system	{ line-height: 16px; background-color: #000000; color: gray ; font-family : tahoma ; font-weight: normal; position : relative; left:0px}";
			$gen_header .= "b.private	{ line-height: 16px; background-color: #000000; color: gray ; font-family : tahoma ; font-weight: normal}";

			$gen_header .= "</style><body>";

			$gen_header = eregi_replace("\n", "", $gen_header);
			print("parent.content.document.writeln(\"".$gen_header."\");");
			print("parent.private.document.writeln(\"".$gen_header."\");");

		}
		?>


		<?

		if ($is_tekst):

		if (mysql_num_rows($result) > 0)
		{
		?>

			parent.content.document.writeln("<? print($data); ?>");
			parent.content.scrollBy(0, 100);

		<?
		}

		if (mysql_num_rows($result2) > 0)
		{
		?>

			parent.private.document.writeln("<? print($data2); ?>");
			parent.private.scrollBy(0, 100);

		<?
		}

		if ((mysql_num_rows($result3) > 0) AND (!$is_god))
		{
		?>

			parent.private.document.writeln("<? print($data3); ?>");
			parent.private.scrollBy(0, 100);

		<?
		}

		if (($mods) AND (mysql_num_rows($result4) > 0))
		{
		?>

			parent.private.document.writeln("<? print($data4); ?>");
			parent.private.scrollBy(0, 100);

		<?
		}


		if ($check_userlist != $userlist)
		{
		?>
			parent.users.document.location.href = 'users.php3?session=<? print($session); ?>';
		<?
		}


		endif;

		?>
	}
	
	function update_now()
	{
		document.update_this.submit();
	}
	
	function start_timer()
	{
		self.setTimeout('update_now()', <? print(_refresh); ?>);
	}
	
	//-->
	</script>
	
	<body onLoad="document.update_this.page_loaded.value = '1'; do_print(); start_timer()" bgcolor="black">
	
	<form name="update_this" action="<? print($scriptnaam); ?>" method="post">
	<input type="hidden" name="session" value="<? print($session); ?>">
	<input type="hidden" name="state" value="started">
	<input type="hidden" name="latestid" value="<? print($encodedurl); ?>">
	<input type="hidden" name="userlist" value="<? print($userlist); ?>">
	<input type="hidden" name="check_userlist" value="<? print($check_userlist); ?>">
	<input type="hidden" name="page_loaded" value="0">
	
	</form>
	
	<?

	
	end_page($mysql_link);
}

if ($session == "") 
{
	?>
	<body bgcolor="black">
	<?
}

// end
	?>