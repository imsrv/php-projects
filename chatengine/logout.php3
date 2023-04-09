<?

/*

	PHP Chatengine version 1.9
	by Michiel Papenhove
	e-mail: michiel@mipamedia.com
	http:// www.mipamedia.com
	
	Software is supplied "as is". You cannot hold me responsible for any problems that
	might of occur because of the use of this chat
	
*/

$extra_info = "onLoad=\"position_window(); window.close(); \"";
require("includes.php3");

?>
<script>
<!--

function position_window()
{
var sAvailH = screen.availHeight;
var sAvailW = screen.availWidth;

window.moveTo( (sAvailW/2)-200, (sAvailH/2)-25);

}
//-->
</script>
<?

$username = "";
$status_online = 0;
$username = user($mysql_link, $session);

// get status_online
$query = "SELECT status_online FROM chat_session_ids WHERE session_id = '$session';";
$ures = mysql_query($query, $mysql_link);
if ($ures)
{
	$urec = mysql_fetch_array($ures);
	$status_online = $urec["status_online"];
}

if ($add_message != "")
{
	$add_message = "(".$add_message.")";
}

if ($username != "")
{
	if ($status_online <> 99)
	{
		system_message($mysql_link,"$username logged out");
	}
}


// log user out

$query = "DELETE FROM chat_session_ids WHERE session_id = '$session';";
mysql_query($query, $mysql_link);

end_page($mysql_link);
?>
