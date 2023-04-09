<?

/*

	PHP Chatengine version 1.9
	by Michiel Papenhove
	e-mail: michiel@mipamedia.com
	http:// www.mipamedia.com
	
	Software is supplied "as is". You cannot hold me responsible for any problems that
	might of occur because of the use of this chat
	
*/

$extra_info = "onLoad=\"start_timer()\" style=\"scrollbar-base-color:black;scrollbar-arrow-color:black\"";
require("includes.php3");

?>
<script>
<!--
function start_timer()
{
	self.setTimeout('update_screen()', 10000);
}

function update_screen()
{
	document.location.href = document.location.href;
}
//-->
</script>
<?

$add_tag = "WHERE status_online <> 99";

if ($session != "")
{
	$userlevel = user_level($mysql_link, $session);
	$showhidden = validate($userlevel, _canseeinvisible);
	if ($showhidden) $add_tag = "";
}

$query = "SELECT login, status_online FROM chat_session_ids $add_tag ORDER BY login ASC;";
$result = mysql_query($query, $mysql_link);

?>

<table bgcolor="#555555" border="0" width="100%" height="100%" cellpadding="2" cellspacing="0">
<tr>
	<td valign="top">
	<table border="0" bgcolor="#000000" width="100%" height="100%" cellpadding="5">
	<tr>
		<td valign="top">
		<font size="1">Online Users:</font><br><br>
		<b style="font-size: 8pt; font-weight : bold">

<?

while ($record = mysql_fetch_array($result))
{
	$query2 = "SELECT color, img FROM chat_users WHERE login = '".addslashes($record["login"])."';";
	$result2 = mysql_fetch_array(mysql_query($query2, $mysql_link));

	$kleur = $result2["color"];
	$image = $result2["img"];

	if ($kleur == "") $kleur = "gray";
	if ($image == "") $image = "nobody.gif";
	
	$at = ""; $aet = "";
	
	if ($record["status_online"] == 99)
	{
		$at = "<i>";
		$aet = "</i>";
	}
	
	$check_login = $record["login"];
	$check_state = $record["status_online"];
	
	$is_godmember = false;
	$aantal = count($gods);
	for ($f = 0; $f < $aantal; $f++)
	{
		if (strtoupper($check_login) == $gods[$f]) { $is_godmember = true; }
	}
	
	
	if ( (!$is_godmember))
	{
		print("<img src=\"icons/$image\" align=absmiddle>&nbsp;$at<span style=\"cursor:e-resize\" onClick=\"add_t('".addslashes($record["login"])."');\"><font color=\"".$kleur."\">".$record["login"]."</span></font>$aet<br>");
	}
	else
	{
		if ($check_state == 0) print("<img src=\"icons/$image\" align=absmiddle>&nbsp;$at<span style=\"cursor:e-resize\" onClick=\"add_t('".addslashes($record["login"])."');\"><font color=\"".$kleur."\">".$record["login"]."</span></font>$aet<br>");
	}
}

if (mysql_num_rows($result) == 0) print("<font color=\"red\">no users are on-line at this moment</font>");
?>
		</b>		
		<form name="usercontrol" action="users.php3" method="post" target="users">
		<input type="hidden" name="session" value="<? print($session); ?>">
		</form>
		</td>
	</tr>
	</table>
	</td>
</tr>
</table>

<?

//endif;

end_page($mysql_link);

// end

?>


